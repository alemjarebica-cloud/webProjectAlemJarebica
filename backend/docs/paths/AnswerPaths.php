<?php

use OpenApi\Attributes as OA;

class AnswerPaths
{
    #[OA\Get(
        path: '/answers', tags: ['answers'], summary: 'List all answers',
        responses: [
            new OA\Response(response: 200, description: 'List of answers', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Answer'))),
        ]
    )]
    public function getAnswers() {}

    #[OA\Get(
        path: '/answers/{id}', tags: ['answers'], summary: 'Get one answer',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The answer', content: new OA\JsonContent(ref: '#/components/schemas/Answer')),
            new OA\Response(response: 404, description: 'Answer not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getAnswerById() {}

    #[OA\Post(
        path: '/answers', tags: ['answers'], summary: 'Create an answer (a question can have only one correct answer)',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/AnswerInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created answer', content: new OA\JsonContent(ref: '#/components/schemas/Answer')),
            new OA\Response(response: 400, description: 'Invalid data or the question already has a correct answer', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function postAnswer() {}

    #[OA\Put(
        path: '/answers/{id}', tags: ['answers'], summary: 'Update an answer',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/AnswerInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated answer', content: new OA\JsonContent(ref: '#/components/schemas/Answer')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Answer not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function putAnswer() {}

    #[OA\Delete(
        path: '/answers/{id}', tags: ['answers'], summary: 'Delete an answer',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Answer deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 404, description: 'Answer not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function deleteAnswer() {}
}