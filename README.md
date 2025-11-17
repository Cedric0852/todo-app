# Todo App (Laravel + Blade + Vite + Tailwind)

A minimal multi-user Todo application. Users can register, log in, and manage their own todos. Uses Blade for all pages, server-side validation, and Tailwind via Vite. Dockerized for easy run.

## Features
- **Auth**: Register, login, logout (session-based)
- **Todos**: Create, list, edit, delete your own
- **Complete**: Mark as completed and see completion status
- **Validation**: Inline error messages on forms
- **Authorization**: Only owners can update/delete
- **UI**: Blade views, Tailwind via Vite (no extra UI frameworks)

## Tech
- Laravel 12, PHP 8.2+
- SQLite (default)
- Vite + Tailwind CSS v4
- Docker (multi-stage build)

## Project Structure
- Laravel app lives in `app/`
- PRD: `PRD.md`
- Docker: root `docker-compose.yml`, `app/Dockerfile`

## Local Development
Prereqs: PHP 8.2+, Composer 2.x, Node 20+, npm

Option A — one command dev (recommended)
```
cd app
composer dev:init
```
- Creates the SQLite DB if missing, runs migrations, then starts Laravel server and Vite.
- Open http://127.0.0.1:8000 (Vite on http://localhost:5173).

Lightweight alternative (server + Vite only):
```
cd app
composer dev:basic
```
Use this if you prefer to run migrations manually.

Option B — manual steps
1) Install deps and set env
```
cd app
composer install
cp .env.example .env
php artisan key:generate
```
2) Database (SQLite)
```
# create file if missing
mkdir -p database
# Windows PowerShell
ni database/database.sqlite -i file -Force
# macOS/Linux
: > database/database.sqlite
```
3) Migrate
```
php artisan migrate
```
4) Frontend
```
npm install
npm run dev
```
5) Run server
```
php artisan serve
```
Open http://127.0.0.1:8000

## Docker
Prereqs: Docker Desktop
Run from the repository root (folder that contains `docker-compose.yml`).

Build and run:
```
docker compose up --build
```
- App served on http://localhost:8080
- On first run, container creates `database/database.sqlite` and runs migrations automatically

## Routes
- GET `/` → redirect to login or todos
- GET `/register` → show register
- POST `/register` → create user
- GET `/login` → show login
- POST `/login` → authenticate
- POST `/logout` → logout
- Resource `/todos` (index, create, store, edit, update, destroy)
- PATCH `/todos/{todo}/complete` → mark completed

## Validation Rules
- `title`: required|string|max:255
- `description`: nullable|string
- `due_date`: required|date
- `is_completed`: boolean

## Notes
- Blade used for all pages
- Tailwind via Vite; see `resources/css/app.css`, `vite.config.js`
- SQLite default via `.env` (`DB_CONNECTION=sqlite`)

## Testing
Run the test suite from the `app/` directory:
```
composer test
```
- Uses in-memory SQLite (no external DB required).
- No need to run Vite or build assets; tests stub the Vite hot file automatically

## Product Requirements
See `PRD.md` for goals, scope, data model, and milestones.
