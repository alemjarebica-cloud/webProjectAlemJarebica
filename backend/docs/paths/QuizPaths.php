<?php

use OpenApi\Attributes as OA;

class QuizPaths
{
    #[OA\Get(
        path: '/quizzes', tags: ['quizzes'], summary: 'List all quizzes, optionally filtered by category',
        parameters: [new OA\Parameter(name: 'category_id', in: 'query', required: false, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'List of quizzes', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Quiz'))),
            new OA\Response(response: 404, description: 'Category not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getQuizzes() {}

    #[OA\Get(
        path: '/quizzes/{id}', tags: ['quizzes'], summary: 'Get one quiz',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The quiz', content: new OA\JsonContent(ref: '#/components/schemas/Quiz')),
            new OA\Response(response: 404, description: 'Quiz not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getQuizById() {}

    #[OA\Get(
        path: '/quizzes/{id}/questions', tags: ['quizzes'], summary: 'List the questions of one quiz',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Questions of the quiz', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Question'))),
            new OA\Response(response: 404, description: 'Quiz not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getQuizQuestions() {}

    #[OA\Post(
        path: '/quizzes', tags: ['quizzes'], summary: 'Create a quiz',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/QuizInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created quiz', content: new OA\JsonContent(ref: '#/components/schemas/Quiz')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function postQuiz() {}

    #[OA\Put(
        path: '/quizzes/{id}', tags: ['quizzes'], summary: 'Update a quiz',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/QuizInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated quiz', content: new OA\JsonContent(ref: '#/components/schemas/Quiz')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Quiz not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function putQuiz() {}

    #[OA\Delete(
        path: '/quizzes/{id}', tags: ['quizzes'], summary: 'Delete a quiz with its questions, answers and attempts',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Quiz deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 404, description: 'Quiz not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function deleteQuiz() {}
}