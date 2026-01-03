#!/bin/bash

# 🚨 Запуск от root (для /etc/hosts)
[ "$UID" -eq 0 ] || exec sudo bash "$0" "$@"

APP_NAME="franken_reverb-laravel.test-1"
HOST_ENTRY="127.0.0.1 verbs.test"
REVERB_PORT=8080
FRANKEN_BIN="/usr/local/bin/frankenphp"

# 🐳 Проверяем FrankenPHP один раз
if [ -x "$FRANKEN_BIN" ]; then
    echo "✅ FrankenPHP уже установлен, скачивание пропущено."
else
    echo "⚡ FrankenPHP не найден, скачиваем последнюю версию..."
    LATEST_URL=$(curl -sI https://github.com/php/frankenphp/releases/latest/download/frankenphp-linux-x86_64 \
                 | grep -i location | tail -1 | awk '{print $2}' | tr -d "\r\n")
    sudo curl -L -o "$FRANKEN_BIN" "$LATEST_URL"
    sudo chmod +x "$FRANKEN_BIN"
    echo "✅ FrankenPHP скачан и готов к использованию."
fi

# 🧹 Остановка контейнеров
echo "🧹 Остановка контейнеров..."
docker compose down -v

# 🔧 Исправляем права на хосте
sudo chown -R $USER:$USER storage bootstrap/cache public
sudo chmod -R 775 storage bootstrap/cache public

# Логи для reverb
mkdir -p storage/logs
sudo chown -R $USER:$USER storage/logs
sudo chmod -R 775 storage/logs

# 📦 Проверка .env
if [ ! -f ".env" ]; then
    echo "⚡ .env не найден, создаём из .env.example..."
    cp .env.example .env
fi

# 📦 Установка Composer
echo "📦 Установка Composer..."
docker run --rm -u "$(id -u):$(id -g)" \
    -v "$(pwd)":/opt -w /opt laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

# 🐳 Запуск контейнеров
echo "🐳 Запуск контейнеров..."
./vendor/bin/sail up -d

# 🌐 Добавление в /etc/hosts
echo "🌐 Добавление в /etc/hosts..."
grep -qF "$HOST_ENTRY" /etc/hosts || echo "$HOST_ENTRY" | sudo tee -a /etc/hosts > /dev/null

# ⏳ Получаем данные из .env
DB_HOST=$(grep -E "^DB_HOST=" .env | cut -d '=' -f2)
DB_PORT=$(grep -E "^DB_PORT=" .env | cut -d '=' -f2)
DB_DATABASE=$(grep -E "^DB_DATABASE=" .env | cut -d '=' -f2)
DB_USERNAME=$(grep -E "^DB_USERNAME=" .env | cut -d '=' -f2)
DB_PASSWORD=$(grep -E "^DB_PASSWORD=" .env | cut -d '=' -f2)

# ⏳ Ждём MySQL
echo "⏳ Ждём MySQL..."
until docker exec -i "$APP_NAME" php -r "try { new PDO('mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_DATABASE', '$DB_USERNAME', '$DB_PASSWORD'); } catch(Exception \$e) { exit(1); }" >/dev/null 2>&1; do
    echo "⏳ MySQL ещё не готов..."
    sleep 2
done

# 🔑 Генерация APP_KEY
echo "🔑 Генерация APP_KEY..."
docker exec -it "$APP_NAME" php artisan key:generate

# ♻️ Очистка кэша
echo "♻️ Очистка кэша..."
docker exec -it "$APP_NAME" php artisan optimize:clear

# 📂 Миграции базы
echo "📂 Миграции базы данных..."
docker exec -it "$APP_NAME" php artisan migrate --force

# 🌱 Сидирование
echo "🌱 Сидирование базы..."
docker exec -it "$APP_NAME" php artisan db:seed --force

# 📦 Установка npm
echo "📦 Установка npm..."
docker exec -it "$APP_NAME" npm install

# ⚙️ Сборка фронтенда
echo "⚙️ Сборка фронтенда..."
docker exec -it "$APP_NAME" npm run build

echo "✅ Готово! Открывай: http://verbs.test"
echo "💡 WebSocket: ws://verbs.test:$REVERB_PORT"
