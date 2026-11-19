<?php

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'TriviaCategory', properties: [
    new OA\Property(property: 'id', type: 'integer', example: 17),
    new OA\Property(property: 'name', type: 'string', example: 'Science & Nature'),
])]
#[OA\Schema(schema: 'TriviaQuestion', properties: [
    new OA\Property(property: 'question', type: 'string', example: 'What is the chemical symbol for gold?'),
    new OA\Property(property: 'category', type: 'string', example: 'Science & Nature'),
    new OA\Property(property: 'difficulty', type: 'string', example: 'easy'),
    new OA\Property(property: 'correct_answer', type: 'string', example: 'Au'),
    new OA\Property(property: 'incorrect_answers', type: 'array', items: new OA\Items(type: 'string'), example: ['Ag', 'Fe', 'Pb']),
])]
class ExternalPaths
{
    #[OA\Get(
        path: '/external/trivia/categories', tags: ['external API'],
        summary: 'List the Open Trivia DB categories (external API)',
        responses: [
            new OA\Response(response: 200, description: 'Categories from Open Trivia DB',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/TriviaCategory'))),
            new OA\Response(response: 503, description: 'The external service is unavailable', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getTriviaCategories() {}

    #[OA\Get(
        path: '/external/trivia/questions', tags: ['external API'],
        summary: 'Fetch multiple-choice trivia questions from Open Trivia DB (external API)',
        parameters: [
            new OA\Parameter(name: 'amount', in: 'query', required: false, example: 5, description: '1 to 50, default 10', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'category', in: 'query', required: false, example: 17, description: 'Category id from /external/trivia/categories', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'difficulty', in: 'query', required: false, example: 'easy', schema: new OA\Schema(type: 'string', enum: ['easy', 'medium', 'hard'])),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Questions from Open Trivia DB',
                content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/TriviaQuestion'))),
            new OA\Response(response: 400, description: 'Invalid parameters', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Not enough questions for this selection', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 503, description: 'The external service is unavailable or busy', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getTriviaQuestions() {}
}