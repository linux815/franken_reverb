# 🧪 FrankenPHP + Caddy + Laravel Reverb — Realtime Chat

Этот проект представляет собой простой Laravel-чат с real-time возможностями, построенный на:

- ⚡ **FrankenPHP** — высокопроизводительный PHP-сервер
- 🌐 **Caddy** — автоматический HTTPS и прокси
- 💬 **Laravel Reverb** — WebSocket-сервер для вещания
- 🛠️ Realtime SPA-чат с Vue 3 + Tailwind CSS

---

## 🚀 Разворачивание проекта

1. Склонируй репозиторий:

```bash
git clone <your-repo-url>
cd <project-folder>
```

2. Запусти деплой-скрипт:

```bash
./deploy.sh
```

> ⚠️ Требуется запуск от `root` — скрипт сам проверит и пересоздаст контейнеры, настроит `.env`, установит зависимости и соберёт фронт.

3. Перейди в браузер:  
   👉 [http://verbs.test](http://verbs.test)

---

## 🔐 Логин по умолчанию

- **Email:** `test@test.com`
- **Пароль:** `password`

---

## 📂 Структура

- `app/Services/` — слой бизнес-логики
- `app/DTO/` — DTO-объекты
- `app/Repositories/` — работа с моделями через репозитории
- `resources/js/` — Vue-компоненты чата
- `routes/web.php` — публичные маршруты и WebSocket
- `deploy.sh` — единый скрипт развёртывания

---

## 🧪 Возможности

- Вход под любым пользователем
- Отправка сообщений в реальном времени
- Список пользователей онлайн
- Laravel Events + Broadcasting (Reverb)
- Vue 3 SPA + Tailwind CSS 4

---

## 📌 Требования

- Docker + Docker Compose
- Node.js & npm (в контейнере)
- DNS-запись или `/etc/hosts` → `127.0.0.1 verbs.test`

---

## 🤝 Благодарности

- Laravel
- FrankenPHP
- Caddy Server
- Tailwind CSS
- Vue.js

---

> 💡 Используй как boilerplate для чатов, уведомлений, real-time дашбордов и интерактивных приложений.
