#!/bin/bash

# Обеспечить запуск от root
[ "$UID" -eq 0 ] || exec sudo bash "$0" "$@"

APP_NAME="franken_reverb-laravel.test-1"
HOST_ENTRY="127.0.0.1 http://verbs.test"

echo "📦 Проверка .env файла..."
docker exec -it "$APP_NAME" test -f .env || docker exec -it "$APP_NAME" cp .env.example .env

echo "🧹 Остановка и очистка контейнеров..."
docker compose down -v

echo "📦 Установка Composer зависимостей..."
docker run --rm   -u "$(id -u):$(id -g)"   -v "$(pwd)":/opt   -w /opt   laravelsail/php84-composer:latest   composer install --ignore-platform-reqs

echo "🐳 Запуск контейнеров..."
./vendor/bin/sail up -d
sleep 10

echo "🌐 Добавление в /etc/hosts..."
grep -qF "$HOST_ENTRY" /etc/hosts || echo "$HOST_ENTRY" >> /etc/hosts

echo "🔑 Генерация APP_KEY..."
docker exec -it "$APP_NAME" php artisan key:generate

echo "♻️ Очистка кэша (view, config, route, events)..."
docker exec -it "$APP_NAME" php artisan optimize:clear

echo "📂 Миграции базы данных..."
docker exec -it "$APP_NAME" php artisan migrate

echo "🌱 Сидирование базы..."
docker exec -it "$APP_NAME" php artisan db:seed --force

echo "📦 Установка npm зависимостей..."
docker exec -it "$APP_NAME" npm install

echo "⚙️ Сборка фронтенда..."
docker exec -it "$APP_NAME" npm run build

echo "✅ Готово! Открывай: http://verbs.test"
