<?php

Flight::route('GET /categories', function () {
    Flight::json(Flight::category_service()->getAll());
});

Flight::route('GET /categories/@id:[0-9]+', function ($id) {
    Flight::json(Flight::category_service()->getById($id));
});

Flight::route('GET /categories/@id:[0-9]+/quizzes', function ($id) {
    Flight::json(Flight::quiz_service()->getByCategory($id));
});

Flight::route('POST /categories', function () {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::category_service()->add($data), 201);
});

Flight::route('PUT /categories/@id:[0-9]+', function ($id) {
    $data = Flight::request()->data->getData();
    Flight::json(Flight::category_service()->update($id, $data));
});

Flight::route('DELETE /categories/@id:[0-9]+', function ($id) {
    Flight::category_service()->delete($id);
    Flight::json(['message' => 'Category deleted.']);
});