# QuizHub

QuizHub is a single-page web application for creating and solving quizzes. Users can browse quizzes by category, solve them question by question, track their results on a personal dashboard and compete on a leaderboard. Admins manage quizzes, questions, categories and users, and can import questions from an external trivia API.

Project for the course IT 2001 - Web Programming (International Burch University).

## Tech stack

- Backend: PHP, FlightPHP, PDO, MySQL (REST API)
- Frontend: HTML, CSS, JavaScript, Bootstrap 5 (single-page application)
- Authentication: JWT
- API documentation: OpenAPI / Swagger

## Entities and relationships

The draft ERD is in [docs/erd.png](docs/erd.png).

| Entity | Description |
|---|---|
| users | id, name, email, password_hash, role (`admin` / `user`) |
| categories | id, name |
| quizzes | id, title, description, category_id, created_by |
| questions | id, quiz_id, text |
| answers | id, question_id, text, is_correct |
| attempts | id, user_id, quiz_id, score, created_at |

Relationships:

- Category 1-N Quizzes
- User 1-N Quizzes (author)
- Quiz 1-N Questions
- Question 1-N Answers
- User 1-N Attempts
- Quiz 1-N Attempts

## Roles

- **User**: browses and solves quizzes, sees own results and the leaderboard.
- **Admin**: full CRUD over quizzes, questions, categories and users, plus question import from the external API.



## External API

Open Trivia DB (https://opentdb.com). The backend calls it with a timeout and error handling and offers two endpoints: `GET /external/trivia/categories` and `GET /external/trivia/questions?amount=&category=&difficulty=`. Feature: on the "Import questions" admin page, admins fetch trivia questions and import them into a quiz (the page itself is connected to the API in Milestone 4). If the service is down, the API answers 503 with a friendly message and the rest of the application keeps working.

## Running the project locally

1. Install XAMPP (PHP 8.2, with the `zip` and `curl` extensions enabled in `php.ini`) into `C:\xampp` and start Apache and MySQL.
2. Put the project into `C:\xampp\htdocs\webProjectAlemJarebica`.
3. Open http://localhost/phpmyadmin, go to **Import** and import `backend/database/quizhub.sql`. This creates the `quizhub` database with sample data.
4. Copy `backend/config/config.example.php` to `backend/config/config.php` and adjust the database credentials if needed (XAMPP default: user `root`, empty password).
5. Install the backend libraries:

   ```bash
   cd backend
   composer install
   ```

6. Open the frontend at http://localhost/webProjectAlemJarebica/frontend/ and the API at http://localhost/webProjectAlemJarebica/backend/ (for example `/categories`).

Test accounts (password for both: `Test1234!`):

| Role | Email |
|---|---|
| admin | admin@example.com |
| user | test@example.com |

## Links

- Swagger documentation: http://localhost/webProjectAlemJarebica/backend/docs/ (local; the public link is added in Milestone 5)
- Deployed application: TODO (Milestone 5)

## Milestone status

- [x] Milestone 1: project structure, static frontend, draft ERD
- [x] Milestone 2: database and DAO layer
- [x] Milestone 3: services, routes, OpenAPI, external API
- [ ] Milestone 4: authentication, middleware, logging, connected frontend
- [ ] Milestone 5: frontend MVC, validations, deployment