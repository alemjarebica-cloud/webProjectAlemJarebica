# AGENTS.md

Context file for AI coding assistants working on this repository.

## Project description

QuizHub is a single-page web application for creating and solving quizzes. Users solve quizzes and track results; admins manage quizzes, questions, categories and users and can import questions from Open Trivia DB (https://opentdb.com).

## Technology stack

- Backend: pure PHP, FlightPHP framework, PDO, MySQL
- Frontend: plain HTML, CSS and JavaScript, Bootstrap 5
- Auth: JWT
- API docs: OpenAPI / Swagger

## Architecture rules

1. Backend and frontend code must never be mixed. Backend is pure PHP, frontend is only HTML, CSS and JS.
2. Backend layering: routes -> services -> dao. Routes only handle HTTP (read request, return JSON with the correct status code). Services contain business logic and validation and are the only layer that calls the DAO. DAO classes are the only layer that talks to the database.
3. All database access uses PDO with prepared statements. Never build SQL by concatenating user input.
4. All DAO classes extend a base DAO class with reusable CRUD methods.
5. Middleware (authentication, authorization, request logging, error handling) is reusable code registered in FlightPHP, never copied into routes.
6. Secrets (database credentials, JWT secret, API keys) live in `backend/config/config.php`, which is not committed. Only `config.example.php` is committed.
7. The frontend is a single-page application: a hash router loads HTML views from `frontend/views/` into `#app` without page reloads.
8. From Milestone 5, only frontend service files communicate with the backend; views contain no AJAX calls.
9. Error responses must not expose stack traces, SQL queries or file paths.
10. Do not add libraries or frameworks that are not listed in the technology stack without asking.

## Folder structure

```
backend/
  routes/       FlightPHP route definitions
  services/     business logic
  dao/          database access (base DAO + one DAO per entity)
  middleware/   auth, role check, request logging, error handling
  config/       config.example.php (config.php is git-ignored)
  logs/         info.log and error.log (git-ignored)
frontend/
  css/  js/  views/  assets/
docs/           AI_LOG.md, erd.png
```

## Naming conventions

- Application language (UI text, code, comments, docs): English.
- Database tables: lowercase plural snake_case (`users`, `quizzes`); columns snake_case.
- PHP classes: PascalCase with a layer suffix (`QuizDao`, `QuizService`); files named after the class.
- PHP methods and variables: camelCase.
- JS files and view files: lowercase kebab-case (`admin-quizzes.html`).
- API routes: lowercase plural nouns (`/quizzes`, `/quizzes/{id}`).

## Git workflow

- One branch per milestone: `milestone1` ... `milestone5`. Never merge a milestone branch into `main`; the reviewer does that.
- Update `AGENTS.md` and `docs/AI_LOG.md` in every milestone.