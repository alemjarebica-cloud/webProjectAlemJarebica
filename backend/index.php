<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/utils/exceptions.php';

require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/CategoryService.php';
require_once __DIR__ . '/services/QuizService.php';
require_once __DIR__ . '/services/QuestionService.php';
require_once __DIR__ . '/services/AnswerService.php';
require_once __DIR__ . '/services/AttemptService.php';

Flight::register('user_service', 'UserService');
Flight::register('category_service', 'CategoryService');
Flight::register('quiz_service', 'QuizService');
Flight::register('question_service', 'QuestionService');
Flight::register('answer_service', 'AnswerService');
Flight::register('attempt_service', 'AttemptService');

Flight::map('error', function (Throwable $e) {
    $status = $e instanceof HttpException ? $e->getStatus() : 500;
    $message = $status === 500 ? 'Something went wrong on the server.' : $e->getMessage();

    if ($status === 500) {
        error_log($e);
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

Flight::start();