<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils/exceptions.php';
require_once __DIR__ . '/utils/Logger.php';

require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/CategoryService.php';
require_once __DIR__ . '/services/QuizService.php';
require_once __DIR__ . '/services/QuestionService.php';
require_once __DIR__ . '/services/AnswerService.php';
require_once __DIR__ . '/services/AttemptService.php';
require_once __DIR__ . '/services/OpenTriviaService.php';

Flight::register('user_service', 'UserService');
Flight::register('category_service', 'CategoryService');
Flight::register('quiz_service', 'QuizService');
Flight::register('question_service', 'QuestionService');
Flight::register('answer_service', 'AnswerService');
Flight::register('attempt_service', 'AttemptService');
Flight::register('trivia_service', 'OpenTriviaService');

Flight::map('error', function (Throwable $e) {
    $status = $e instanceof HttpException ? $e->getStatus() : 500;
    $message = $status === 500 ? 'Something went wrong on the server.' : $e->getMessage();

    if ($status === 500) {
        Logger::error(get_class($e) . ': ' . $e->getMessage() . ' (' . basename($e->getFile()) . ':' . $e->getLine() . ')');
    }

    Flight::response()->clearBody()->status($status)
        ->header('Content-Type', 'application/json')
        ->write(json_encode(['error' => $message]))
        ->send();
});

Flight::map('notFound', function () {
    Flight::response()->clearBody()->status(404)
        ->header('Content-Type', 'application/json')
        ->write(json_encode(['error' => 'Endpoint not found.']))
        ->send();
});

require_once __DIR__ . '/routes/CategoryRoutes.php';
require_once __DIR__ . '/routes/QuizRoutes.php';
require_once __DIR__ . '/routes/QuestionRoutes.php';
require_once __DIR__ . '/routes/AnswerRoutes.php';
require_once __DIR__ . '/routes/AttemptRoutes.php';
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/ExternalRoutes.php';

Flight::start();