# AI Log

## Milestone 1

### AI tools used

- Claude (chat): planning the project (topic, entities, pages), step-by-step Git setup, project folder structure, `.gitignore`, `config.example.php`, static SPA frontend (hash router and Bootstrap views), draft ERD (dbdiagram.io code) and README draft.
- `AGENTS.md` was drafted with AI and then reviewed and adjusted by me.

### Most important prompts

- "Suggest a web application topic and entities for the project requirements" (PDF from the professor attached).
- "Explain step by step how to do Milestone 1" (repo, branch, folders, frontend, ERD, docs).
- "Create the static SPA frontend with a router and all pages" (11 views).
- "Generate dbdiagram.io code for the ERD with 6 entities."

### Cases where the AI was wrong or produced poor output

1. **Wrong assumption about the XAMPP setup.** The AI gave a URL and the path `C:\xampp\apache\conf\httpd.conf` assuming a standard XAMPP install. `http://localhost/webProjectAlemJarebica/frontend/` returned "Not Found". I noticed it in the browser. We found the cause with `Get-Process httpd`: Apache runs from `C:\xampp\htdocs\apache` and serves `C:\xampp\htdocs\htdocs`, which contains an old copy of the lab 1 project. Fix: I run the frontend with PHP's built-in server (`php -S localhost:8000 -t frontend`).
2. **Router linked to pages that did not exist yet.** The first router version only had two views, so navigation links led to missing files and clicking "Next" on the quiz page showed "Not Found" for `views/result.html`. I noticed it by clicking through the app. Fix: I added all remaining view files and routes.

## Milestone 2

### AI tools used

- Claude (chat): database schema as a .sql file with sample data, PDO connection class (`Database.php`), `BaseDao` with reusable CRUD methods and one DAO class per entity, test scripts, and help fixing my local XAMPP setup.

### Most important prompts

- "Create the MySQL schema for the 6 entities from the ERD with sample data."
- "Create a BaseDao with CRUD using prepared statements and one DAO for each entity."
- "Write a test script that creates, reads, updates and deletes rows in all DAO classes."

### Cases where the AI was wrong or produced poor output

1. **`getAll()` had no `ORDER BY`.** The first `BaseDao` returned `SELECT *` without ordering. I noticed it when my test printed the categories as ids 2, 1, 3 instead of 1, 2, 3. Fix: I added `ORDER BY id`.
2. **Cleanup command failed without administrator rights.** While reinstalling XAMPP, the AI told me to delete the leftover `C:\xampp` folder with `Remove-Item`. It failed with "Access denied" because PowerShell was not running as administrator. I noticed it from the error output, we checked the file permissions with `icacls`, and I fixed it by reopening PowerShell as administrator.

### My own work

I reinstalled XAMPP into the correct folder, imported the database in phpMyAdmin, ran and checked every test, and reviewed and committed the code.

## Milestone 3

### AI tools used

- Claude (chat): services and `BaseService`, `Validator`, exception classes, FlightPHP routes and the error handler, swagger-php attributes and Swagger UI, the Open Trivia DB service with timeout and logging, and test scripts.

### Most important prompts

- "Create a service for every entity with validation and business rules; only services call the DAO."
- "Create FlightPHP routes for CRUD of all six entities with correct status codes and one error handler."
- "Document every endpoint with OpenAPI attributes and show it in Swagger UI."
- "Call Open Trivia DB from a service with a timeout, error handling, logging and a friendly 503."

### Cases where the AI was wrong or produced poor output

1. **Library version mismatch.** The lecture material and the AI's first answer assumed swagger-php 6.12 and the `Generator` class, but Composer installed 7.8.0, where `Builder` is the new entry point and classic attributes are deprecated. I noticed the version in the Composer output. We checked the 7.x documentation, and `swagger.php` now uses `Builder` and falls back to `Generator`.
2. **Missing PHP extension.** `composer require` failed because the `zip` extension was not enabled in my `php.ini`. The AI had not checked this beforehand. I saw the error in the terminal, enabled `extension=zip` and ran `composer install`.
3. **Documentation did not match the code.** The AI documented `PUT /users/{id}` with a required `password`, but `UserService` only requires it when creating a user. We noticed it while reviewing the docs. Fix: a separate `UserUpdate` schema with an optional password.
4. **Test file staged for commit.** The AI did not tell me to ignore the test scripts, so `test-routes.php` appeared in `git status` as a file to commit. I noticed it in the status output, unstaged it and added `test-*.php` to `.gitignore`.

### My own work

I created and ran all files locally, tested the services, routes, Swagger and the external API (including a failure test with a wrong URL), fixed the environment problems, and checked every `git status` before committing.