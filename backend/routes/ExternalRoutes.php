<?php

Flight::route('GET /external/trivia/categories', function () {
    Flight::json(Flight::trivia_service()->getCategories());
});

Flight::route('GET /external/trivia/questions', function () {
    $params = Flight::request()->query->getData();
    Flight::json(Flight::trivia_service()->getQuestions($params));
});