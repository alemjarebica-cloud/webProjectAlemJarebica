<?php

use OpenApi\Attributes as OA;

class UserPaths
{
    #[OA\Get(
        path: '/users', tags: ['users'], summary: 'List all users (without passwords)',
        responses: [
            new OA\Response(response: 200, description: 'List of users', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/User'))),
        ]
    )]
    public function getUsers() {}

    #[OA\Get(
        path: '/users/{id}', tags: ['users'], summary: 'Get one user',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The user', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getUserById() {}

    #[OA\Get(
        path: '/users/{id}/attempts', tags: ['users'], summary: 'List the attempts of one user',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 2, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Attempts of the user', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Attempt'))),
            new OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getUserAttempts() {}

    #[OA\Post(
        path: '/users', tags: ['users'], summary: 'Create a user (the password is stored hashed)',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created user', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 400, description: 'Invalid data or the email is already used', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function postUser() {}

    #[OA\Put(
        path: '/users/{id}', tags: ['users'], summary: 'Update a user (the password is optional)',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UserUpdate')),
        responses: [
            new OA\Response(response: 200, description: 'Updated user', content: new OA\JsonContent(ref: '#/components/schemas/User')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function putUser() {}

    #[OA\Delete(
        path: '/users/{id}', tags: ['users'], summary: 'Delete a user (only if the user has no quizzes)',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'User deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 400, description: 'User still has quizzes', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'User not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function deleteUser() {}
}