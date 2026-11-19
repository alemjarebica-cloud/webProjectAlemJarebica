<?php

Flight::route('GET /answers', function () {
    Flight::json(Flight::answer_service()->getAll());
});

Flight::route('GET /answers/@id:[0-9]+', function ($id) {
    Flight::json(Flight::answer_service()->getById($id));
});

Flight::route('POST /answers', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::answer_service()->add($data), 201);
});

Flight::route('PUT /answers/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::answer_service()->update($id, $data));
});

Flight::route('DELETE /answers/@id:[0-9]+', function ($id) {
    Flight::answer_service()->delete($id);
    Flight::json(['message' => 'Answer deleted.']);
});