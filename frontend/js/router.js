const routes = {
  '/login': 'views/login.html',
  '/register': 'views/register.html',
  '/dashboard': 'views/dashboard.html',
  '/quizzes': 'views/quizzes.html',
  '/quiz': 'views/quiz.html',
  '/result': 'views/result.html',
  '/leaderboard': 'views/leaderboard.html',
  '/profile': 'views/profile.html',
  '/admin/quizzes': 'views/admin-quizzes.html',
  '/admin/categories-users': 'views/admin-categories-users.html',
  '/admin/import': 'views/admin-import.html'
};

async function loadRoute() {
  const path = location.hash.slice(1) || '/login';
  const file = routes[path];
  const app = document.getElementById('app');

  if (!file) {
    app.innerHTML = '<h2>404 - Page not found</h2>';
    return;
  }

  const response = await fetch(file);
  app.innerHTML = await response.text();
}

window.addEventListener('hashchange', loadRoute);
window.addEventListener('load', loadRoute);