<?php

use OpenApi\Attributes as OA;

#[OA\Info(title: 'QuizHub API', version: '1.0', description: 'REST API of QuizHub: quizzes, questions, answers, categories, users and attempts.')]
#[OA\Server(url: API_BASE_URL)]

#[OA\Schema(schema: 'Error', properties: [new OA\Property(property: 'error', type: 'string', example: 'Category not found.')])]
#[OA\Schema(schema: 'Message', properties: [new OA\Property(property: 'message', type: 'string', example: 'Deleted.')])]

#[OA\Schema(schema: 'CategoryInput', required: ['name'], properties: [
    new OA\Property(property: 'name', type: 'string', example: 'Geography'),
])]
#[OA\Schema(schema: 'Category', allOf: [new OA\Schema(ref: '#/components/schemas/CategoryInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
])]

#[OA\Schema(schema: 'UserInput', required: ['name', 'email', 'password'], properties: [
    new OA\Property(property: 'name', type: 'string', example: 'Amar Hadzic'),
    new OA\Property(property: 'email', type: 'string', example: 'amar@example.com'),
    new OA\Property(property: 'password', type: 'string', example: 'Secret123!'),
    new OA\Property(property: 'role', type: 'string', enum: ['admin', 'user'], example: 'user'),
])]
#[OA\Schema(schema: 'UserUpdate', required: ['name', 'email'], properties: [
    new OA\Property(property: 'name', type: 'string', example: 'Amar Hadzic'),
    new OA\Property(property: 'email', type: 'string', example: 'amar@example.com'),
    new OA\Property(property: 'password', type: 'string', description: 'Optional. Leave it out to keep the current password.', example: 'NewSecret123!'),
    new OA\Property(property: 'role', type: 'string', enum: ['admin', 'user'], example: 'user'),
])]
#[OA\Schema(schema: 'User', properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'name', type: 'string', example: 'Amar Hadzic'),
    new OA\Property(property: 'email', type: 'string', example: 'amar@example.com'),
    new OA\Property(property: 'role', type: 'string', example: 'user'),
    new OA\Property(property: 'created_at', type: 'string', example: '2026-11-19 21:01:18'),
])]

#[OA\Schema(schema: 'QuizInput', required: ['title', 'category_id', 'created_by'], properties: [
    new OA\Property(property: 'title', type: 'string', example: 'Space Basics'),
    new OA\Property(property: 'description', type: 'string', example: 'Questions about planets and stars.'),
    new OA\Property(property: 'category_id', type: 'integer', example: 1),
    new OA\Property(property: 'created_by', type: 'integer', example: 1),
])]
#[OA\Schema(schema: 'Quiz', allOf: [new OA\Schema(ref: '#/components/schemas/QuizInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'created_at', type: 'string', example: '2026-11-19 21:01:18'),
])]

#[OA\Schema(schema: 'QuestionInput', required: ['quiz_id', 'text'], properties: [
    new OA\Property(property: 'quiz_id', type: 'integer', example: 1),
    new OA\Property(property: 'text', type: 'string', example: 'Which planet is closest to the Sun?'),
])]
#[OA\Schema(schema: 'Question', allOf: [new OA\Schema(ref: '#/components/schemas/QuestionInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
])]

#[OA\Schema(schema: 'AnswerInput', required: ['question_id', 'text'], properties: [
    new OA\Property(property: 'question_id', type: 'integer', example: 1),
    new OA\Property(property: 'text', type: 'string', example: 'Mercury'),
    new OA\Property(property: 'is_correct', type: 'boolean', example: true),
])]
#[OA\Schema(schema: 'Answer', properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'question_id', type: 'integer', example: 1),
    new OA\Property(property: 'text', type: 'string', example: 'Mercury'),
    new OA\Property(property: 'is_correct', type: 'integer', example: 1),
])]

#[OA\Schema(schema: 'AttemptInput', required: ['user_id', 'quiz_id', 'score'], properties: [
    new OA\Property(property: 'user_id', type: 'integer', example: 2),
    new OA\Property(property: 'quiz_id', type: 'integer', example: 1),
    new OA\Property(property: 'score', type: 'integer', example: 2),
])]
#[OA\Schema(schema: 'Attempt', allOf: [new OA\Schema(ref: '#/components/schemas/AttemptInput')], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'created_at', type: 'string', example: '2026-11-19 21:01:18'),
])]
class OpenApiSpec
{
}