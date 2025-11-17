# Todo App PRD

## Overview
A simple multi-user Todo application built with Laravel and Blade. Users can register, log in, and manage their own todos. Minimal UI leveraging Laravel + Vite default stack without external CSS frameworks; only light CSS via resources/css/app.css.

## Goals
- CRUD for todos scoped to the authenticated user.
- Mark todo as complete and display completion status.
- Server-side validation with clear error display in Blade forms.
- Authorization so users can only access their own todos.
- Dockerized app for easy run with a single service.

## Out of Scope
- Advanced UI/UX or component libraries.
- Teams, sharing, reminders/notifications.
- API endpoints (this PRD targets Blade pages).

## Users & Roles
- Guest: can register and log in.
- Authenticated User: manage own todos only.

## Data Model
- Todo
  - id
  - user_id (FK -> users.id)
  - title (string, required)
  - description (text, nullable)
  - due_date (date, required)
  - is_completed (boolean, default false)
  - timestamps

## Core User Stories
- As a user, I can register, log in, and log out.
- As a user, I can create a todo with title and due date.
- As a user, I can view a list of my todos.
- As a user, I can edit my todo.
- As a user, I can delete my todo.
- As a user, I can mark a todo as completed and see which todos are completed.

## Functional Requirements
- Authentication:
  - Register (name, email, password, password confirmation)
  - Login (email, password)
  - Logout (POST)
- Todos:
  - List: GET /todos — only user’s todos ordered by due_date desc by default
  - Create: GET /todos/create, POST /todos
  - Edit: GET /todos/{todo}/edit, PUT/PATCH /todos/{todo}
  - Delete: DELETE /todos/{todo}
  - Mark Complete: PATCH /todos/{todo}/complete
- Validation errors displayed inline on forms.

## Validation
- title: required, string, max:255
- description: nullable, string
- due_date: required, date
- is_completed: boolean

## Authorization
- Only owner can view, update, delete, or mark their todo complete.
- Policy: TodoPolicy maps view, update, delete to ownership.

## UX Notes
- Blade templates for all pages.
- Basic layout with header/nav, minimal CSS via app.css.
- Completed todos visibly indicated.

## Non-Functional Requirements
- Laravel 11+ with Vite.
- SQLite database by default.
- Minimal dependencies.
- Dockerized build running via php built-in server in container.

## Success Criteria
- All routes function with validation and authorization.
- User can see which todos are completed.
- App runs via Docker and via local PHP dev server.

## Milestones
1) Scaffold Laravel, configure SQLite, minimal auth.
2) Implement Todo model/migration, controller, policy, routes.
3) Blade views and validation.
4) Vite CSS and small layout.
5) Dockerize and docs.
