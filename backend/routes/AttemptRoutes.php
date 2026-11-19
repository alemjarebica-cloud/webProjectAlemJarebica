<?php

Flight::route('GET /attempts', function () {
    Flight::json(Flight::attempt_service()->getAll());
});

Flight::route('GET /attempts/@id:[0-9]+', function ($id) {
    Flight::json(Flight::attempt_service()->getById($id));
});

Flight::route('POST /attempts', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::attempt_service()->add($data), 201);
});

Flight::route('PUT /attempts/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::attempt_service()->update($id, $data));
});

Flight::route('DELETE /attempts/@id:[0-9]+', function ($id) {
    Flight::attempt_service()->delete($id);
    Flight::json(['message' => 'Attempt deleted.']);
});