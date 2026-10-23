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

Test accounts: TODO (added in a later milestone).

## External API

Open Trivia DB (https://opentdb.com). Feature: admins fetch trivia questions by amount, category and difficulty on the "Import questions" page and import them into a quiz.

## Running the project locally

Milestone 1 contains only the static frontend.

```bash
php -S localhost:8000 -t frontend
```

Then open http://localhost:8000/.

Backend setup (importing the .sql file and creating `backend/config/config.php` from `config.example.php`): TODO (Milestone 2).

## Links

- Swagger documentation: TODO (Milestone 3)
- Deployed application: TODO (Milestone 5)

## Milestone status

- [x] Milestone 1: project structure, static frontend, draft ERD
- [ ] Milestone 2: database and DAO layer
- [ ] Milestone 3: services, routes, OpenAPI, external API
- [ ] Milestone 4: authentication, middleware, logging, connected frontend
- [ ] Milestone 5: frontend MVC, validations, deployment