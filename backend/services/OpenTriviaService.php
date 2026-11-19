<?php

require_once __DIR__ . '/../utils/exceptions.php';
require_once __DIR__ . '/../utils/Validator.php';
require_once __DIR__ . '/../utils/Logger.php';

class OpenTriviaService
{
    private const UNAVAILABLE = 'The trivia service is not available right now. Please try again later.';
    private const BUSY = 'The trivia service is busy. Please wait a few seconds and try again.';

    private string $baseUrl;
    private int $timeout;

    public function __construct(?array $config = null)
    {
        if ($config === null) {
            $all = require __DIR__ . '/../config/config.php';
            $config = $all['external_api'];
        }
        $this->baseUrl = rtrim($config['base_url'], '/');
        $this->timeout = (int) ($config['timeout'] ?? 5);
    }

    public function getCategories(): array
    {
        $data = $this->request('/api_category.php');
        if (!isset($data['trivia_categories']) || !is_array($data['trivia_categories'])) {
            $this->fail('unexpected categories response', self::UNAVAILABLE);
        }

        $categories = [];
        foreach ($data['trivia_categories'] as $category) {
            if (!isset($category['id'], $category['name'])) {
                $this->fail('unexpected category item', self::UNAVAILABLE);
            }
            $categories[] = ['id' => (int) $category['id'], 'name' => (string) $category['name']];
        }
        return $categories;
    }

    public function getQuestions(array $params): array
    {
        $amount = $params['amount'] ?? 10;
        Validator::integer($amount, 'amount', 1, 50);

        // type=multiple: one correct and three wrong answers, like our own data model.
        // encode=url3986: text arrives URL-encoded, so there are no HTML entities like &quot;.
        $query = ['amount' => (int) $amount, 'type' => 'multiple', 'encode' => 'url3986'];

        if (isset($params['category']) && $params['category'] !== '') {
            Validator::integer($params['category'], 'category', 1, 100);
            $query['category'] = (int) $params['category'];
        }
        if (!empty($params['difficulty'])) {
            if (!in_array($params['difficulty'], ['easy', 'medium', 'hard'], true)) {
                throw new ValidationException("Field 'difficulty' must be easy, medium or hard.");
            }
            $query['difficulty'] = $params['difficulty'];
        }

        $data = $this->request('/api.php?' . http_build_query($query));
        $code = $data['response_code'] ?? -1;

        if ($code === 1) {
            throw new NotFoundException('Not enough questions for this selection. Try a smaller amount or another category.');
        }
        if ($code === 5) {
            $this->fail('rate limit (response_code 5)', self::BUSY);
        }
        if ($code !== 0 || !isset($data['results']) || !is_array($data['results'])) {
            $this->fail("unexpected response_code $code", self::UNAVAILABLE);
        }

        $questions = [];
        foreach ($data['results'] as $item) {
            if (!isset($item['question'], $item['category'], $item['difficulty'], $item['correct_answer'])
                || !isset($item['incorrect_answers']) || !is_array($item['incorrect_answers'])) {
                $this->fail('unexpected question item', self::UNAVAILABLE);
            }
            $questions[] = [
                'question' => rawurldecode($item['question']),
                'category' => rawurldecode($item['category']),
                'difficulty' => rawurldecode($item['difficulty']),
                'correct_answer' => rawurldecode($item['correct_answer']),
                'incorrect_answers' => array_map('rawurldecode', $item['incorrect_answers']),
            ];
        }
        return $questions;
    }

    // All the checks for an external call are in this one method.
    private function request(string $path): array
    {
        $url = $this->baseUrl . $path;

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => ['Accept: application/json'],
        ]);
        $body = curl_exec($curl);
        $status = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);

        if ($body === false) {
            $this->fail("request to $url failed: $curlError", self::UNAVAILABLE);   // timeout, DNS, no internet
        }
        if ($status === 429) {
            $this->fail("HTTP 429 from $url", self::BUSY);                           // rate limit
        }
        if ($status !== 200) {
            $this->fail("HTTP $status from $url", self::UNAVAILABLE);                // their error
        }

        $data = json_decode($body, true);
        if (!is_array($data)) {
            $this->fail("response from $url is not JSON", self::UNAVAILABLE);        // not JSON
        }

        Logger::info("External API call GET $url -> $status");
        return $data;
    }

    private function fail(string $reason, string $userMessage): never
    {
        Logger::error("External API (Open Trivia DB) failed: $reason");
        throw new ExternalServiceException($userMessage);
    }
}