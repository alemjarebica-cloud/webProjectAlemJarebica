<?php

use OpenApi\Attributes as OA;

class AttemptPaths
{
    #[OA\Get(
        path: '/attempts', tags: ['attempts'], summary: 'List all attempts',
        responses: [
            new OA\Response(response: 200, description: 'List of attempts', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Attempt'))),
        ]
    )]
    public function getAttempts() {}

    #[OA\Get(
        path: '/attempts/{id}', tags: ['attempts'], summary: 'Get one attempt',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The attempt', content: new OA\JsonContent(ref: '#/components/schemas/Attempt')),
            new OA\Response(response: 404, description: 'Attempt not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getAttemptById() {}

    #[OA\Post(
        path: '/attempts', tags: ['attempts'], summary: 'Save a quiz result (score cannot exceed the number of questions)',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/AttemptInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created attempt', content: new OA\JsonContent(ref: '#/components/schemas/Attempt')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function postAttempt() {}

    #[OA\Put(
        path: '/attempts/{id}', tags: ['attempts'], summary: 'Update an attempt',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/AttemptInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated attempt', content: new OA\JsonContent(ref: '#/components/schemas/Attempt')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Attempt not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function putAttempt() {}

    #[OA\Delete(
        path: '/attempts/{id}', tags: ['attempts'], summary: 'Delete an attempt',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Attempt deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 404, description: 'Attempt not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function deleteAttempt() {}
}