<?php

use OpenApi\Attributes as OA;

class CategoryPaths
{
    #[OA\Get(
        path: '/categories', tags: ['categories'], summary: 'List all categories',
        responses: [
            new OA\Response(response: 200, description: 'List of categories',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Category'))),
        ]
    )]
    public function getCategories() {}

    #[OA\Get(
        path: '/categories/{id}', tags: ['categories'], summary: 'Get one category',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The category', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
            new OA\Response(response: 404, description: 'Category not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getCategoryById() {}

    #[OA\Get(
        path: '/categories/{id}/quizzes', tags: ['categories'], summary: 'List the quizzes of one category',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Quizzes of the category',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Quiz'))),
            new OA\Response(response: 404, description: 'Category not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getCategoryQuizzes() {}

    #[OA\Post(
        path: '/categories', tags: ['categories'], summary: 'Create a category',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created category', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function postCategory() {}

    #[OA\Put(
        path: '/categories/{id}', tags: ['categories'], summary: 'Update a category',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/CategoryInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated category', content: new OA\JsonContent(ref: '#/components/schemas/Category')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Category not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function putCategory() {}

    #[OA\Delete(
        path: '/categories/{id}', tags: ['categories'], summary: 'Delete a category (only if it has no quizzes)',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Category deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 400, description: 'Category still has quizzes', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Category not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function deleteCategory() {}
}