<?php

$base = 'http://localhost/webProjectAlemJarebica/backend';
$failed = 0;

function call(string $method, string $path, ?array $body = null): array
{
    global $base;
    $ch = curl_init($base . $path);
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json'],
    ]);
    if ($body !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }
    $raw = (string) curl_exec($ch);
    $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['status' => $status, 'body' => json_decode($raw, true), 'raw' => $raw];
}

function check(string $label, int $expected, array $res): void
{
    global $failed;
    $ok = $res['status'] === $expected;
    if (!$ok) {
        $failed++;
    }
    echo ($ok ? 'PASS' : 'FAIL') . '  ' . str_pad($label, 42, '.') . " expected $expected, got {$res['status']}";
    echo $ok ? "\n" : '  ' . $res['raw'] . "\n";
}

check('GET /categories', 200, call('GET', '/categories'));
check('GET /quizzes', 200, call('GET', '/quizzes'));
check('GET /users', 200, call('GET', '/users'));

$cat = call('POST', '/categories', ['name' => 'Route test']);
check('POST /categories', 201, $cat);
check('POST /categories (empty body)', 400, call('POST', '/categories', []));
check('GET /categories/999', 404, call('GET', '/categories/999'));
check('GET /categories/abc (no route)', 404, call('GET', '/categories/abc'));
check('PUT /categories/{id}', 200, call('PUT', "/categories/{$cat['body']['id']}", ['name' => 'Route test 2']));

$user = call('POST', '/users', ['name' => 'Route User', 'email' => 'routetest@example.com', 'password' => 'Secret123!']);
check('POST /users', 201, $user);
check('POST /users (duplicate email)', 400, call('POST', '/users', ['name' => 'Dup', 'email' => 'routetest@example.com', 'password' => 'Secret123!']));

$quiz = call('POST', '/quizzes', ['title' => 'Route quiz', 'category_id' => $cat['body']['id'], 'created_by' => $user['body']['id']]);
check('POST /quizzes', 201, $quiz);
check('GET /quizzes?category_id=', 200, call('GET', "/quizzes?category_id={$cat['body']['id']}"));
check('GET /categories/{id}/quizzes', 200, call('GET', "/categories/{$cat['body']['id']}/quizzes"));

$question = call('POST', '/questions', ['quiz_id' => $quiz['body']['id'], 'text' => 'Route question?']);
check('POST /questions', 201, $question);
check('GET /quizzes/{id}/questions', 200, call('GET', "/quizzes/{$quiz['body']['id']}/questions"));

$answer = call('POST', '/answers', ['question_id' => $question['body']['id'], 'text' => 'Right', 'is_correct' => true]);
check('POST /answers (correct)', 201, $answer);
check('POST /answers (second correct)', 400, call('POST', '/answers', ['question_id' => $question['body']['id'], 'text' => 'Also', 'is_correct' => true]));
check('GET /questions/{id}/answers', 200, call('GET', "/questions/{$question['body']['id']}/answers"));

$attempt = call('POST', '/attempts', ['user_id' => $user['body']['id'], 'quiz_id' => $quiz['body']['id'], 'score' => 1]);
check('POST /attempts', 201, $attempt);
check('POST /attempts (score too high)', 400, call('POST', '/attempts', ['user_id' => $user['body']['id'], 'quiz_id' => $quiz['body']['id'], 'score' => 9]));
check('GET /users/{id}/attempts', 200, call('GET', "/users/{$user['body']['id']}/attempts"));

check('DELETE /categories/{id} (has quiz)', 400, call('DELETE', "/categories/{$cat['body']['id']}"));
check('DELETE /quizzes/{id}', 200, call('DELETE', "/quizzes/{$quiz['body']['id']}"));
check('GET /attempts/{id} (after cascade)', 404, call('GET', "/attempts/{$attempt['body']['id']}"));
check('DELETE /users/{id}', 200, call('DELETE', "/users/{$user['body']['id']}"));
check('DELETE /categories/{id}', 200, call('DELETE', "/categories/{$cat['body']['id']}"));
check('GET /nothing', 404, call('GET', '/nothing'));

echo $failed === 0 ? "\nAll checks passed.\n" : "\n$failed check(s) FAILED.\n";