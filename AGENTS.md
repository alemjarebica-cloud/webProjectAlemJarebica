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
11. DAO classes extend BaseDao and pass only the table name and the list of allowed columns. BaseDao builds INSERT/UPDATE statements only from allowed columns, never from raw request keys.
12. Database connections come only from Database::connect() (backend/config/Database.php), which reads credentials from config.php.
13. The database schema lives in backend/database/quizhub.sql and must be kept in sync with the ERD in docs/erd.png.
14. Routes only read the input (path, query, JSON body), call one service method and answer with Flight::json() and the right status code. No business rules, no SQL and no try/catch in routes.
15. Services are the only layer that calls DAOs. They validate input with utils/Validator.php and throw HttpException subclasses (ValidationException 400, NotFoundException 404, ExternalServiceException 503). Services never read request data, echo output or choose HTTP status codes.
16. Errors are handled in one place: Flight::map('error') in backend/index.php turns every exception into JSON. A 500 never exposes stack traces, SQL or file paths; details go to backend/logs/error.log through utils/Logger.php.
17. External APIs are called only from the backend, in a service, with a timeout, a status check and a JSON check. Failures are logged and answered with a friendly 503. The API key lives in config.php, never in Git.
18. Every route is documented with OpenAPI attributes in backend/docs/paths/ and every schema in backend/docs/doc_setup.php. Code and documentation are changed in the same commit.
19. Test scripts (test-*.php) are for local use only and are never committed.

## Folder structure

```
backend/
  routes/       FlightPHP route definitions
  services/     business logic
  dao/          database access (base DAO + one DAO per entity)
  middleware/   auth, role check, request logging, error handling
  config/       config.example.php (config.php is git-ignored)
  database/     quizhub.sql (schema and sample data)
  utils/        Validator, Logger, exceptions
  docs/         OpenAPI: swagger.php, doc_setup.php, paths/ (Swagger UI at /backend/docs/)
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