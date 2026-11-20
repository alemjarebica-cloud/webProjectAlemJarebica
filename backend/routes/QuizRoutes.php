<?php

Flight::route('GET /quizzes', function () {
    $categoryId = Flight::request()->query['category_id'] ?? null;
    if ($categoryId !== null) {
        Flight::json(Flight::quiz_service()->getByCategory((int) $categoryId));
    } else {
        Flight::json(Flight::quiz_service()->getAll());
    }
});

Flight::route('GET /quizzes/@id:[0-9]+', function ($id) {
    Flight::json(Flight::quiz_service()->getById($id));
});

Flight::route('GET /quizzes/@id:[0-9]+/questions', function ($id) {
    Flight::json(Flight::question_service()->getByQuiz($id));
});

Flight::route('POST /quizzes', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::quiz_service()->add($data), 201);
});

Flight::route('PUT /quizzes/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::quiz_service()->update($id, $data));
});

Flight::route('DELETE /quizzes/@id:[0-9]+', function ($id) {
    Flight::quiz_service()->delete($id);
    Flight::json(['message' => 'Quiz deleted.']);
});