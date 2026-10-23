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