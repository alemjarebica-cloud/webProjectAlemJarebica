<?php

Flight::route('GET /questions', function () {
    Flight::json(Flight::question_service()->getAll());
});

Flight::route('GET /questions/@id:[0-9]+', function ($id) {
    Flight::json(Flight::question_service()->getById($id));
});

Flight::route('GET /questions/@id:[0-9]+/answers', function ($id) {
    Flight::json(Flight::answer_service()->getByQuestion($id));
});

Flight::route('POST /questions', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::question_service()->add($data), 201);
});

Flight::route('PUT /questions/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::question_service()->update($id, $data));
});

Flight::route('DELETE /questions/@id:[0-9]+', function ($id) {
    Flight::question_service()->delete($id);
    Flight::json(['message' => 'Question deleted.']);
});