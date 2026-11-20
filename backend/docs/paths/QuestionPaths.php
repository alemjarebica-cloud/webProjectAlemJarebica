<?php

use OpenApi\Attributes as OA;

class QuestionPaths
{
    #[OA\Get(
        path: '/questions', tags: ['questions'], summary: 'List all questions',
        responses: [
            new OA\Response(response: 200, description: 'List of questions', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Question'))),
        ]
    )]
    public function getQuestions() {}

    #[OA\Get(
        path: '/questions/{id}', tags: ['questions'], summary: 'Get one question',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'The question', content: new OA\JsonContent(ref: '#/components/schemas/Question')),
            new OA\Response(response: 404, description: 'Question not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getQuestionById() {}

    #[OA\Get(
        path: '/questions/{id}/answers', tags: ['questions'], summary: 'List the answers of one question',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Answers of the question', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Answer'))),
            new OA\Response(response: 404, description: 'Question not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function getQuestionAnswers() {}

    #[OA\Post(
        path: '/questions', tags: ['questions'], summary: 'Create a question',
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/QuestionInput')),
        responses: [
            new OA\Response(response: 201, description: 'Created question', content: new OA\JsonContent(ref: '#/components/schemas/Question')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function postQuestion() {}

    #[OA\Put(
        path: '/questions/{id}', tags: ['questions'], summary: 'Update a question',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/QuestionInput')),
        responses: [
            new OA\Response(response: 200, description: 'Updated question', content: new OA\JsonContent(ref: '#/components/schemas/Question')),
            new OA\Response(response: 400, description: 'Invalid data', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
            new OA\Response(response: 404, description: 'Question not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function putQuestion() {}

    #[OA\Delete(
        path: '/questions/{id}', tags: ['questions'], summary: 'Delete a question with its answers',
        parameters: [new OA\Parameter(name: 'id', in: 'path', required: true, example: 1, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Question deleted', content: new OA\JsonContent(ref: '#/components/schemas/Message')),
            new OA\Response(response: 404, description: 'Question not found', content: new OA\JsonContent(ref: '#/components/schemas/Error')),
        ]
    )]
    public function deleteQuestion() {}
}