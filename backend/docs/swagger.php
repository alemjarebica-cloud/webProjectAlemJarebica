<?php

require __DIR__ . '/../vendor/autoload.php';

// Base URL of the API, computed from the request so Swagger UI always calls the right address.
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
define('API_BASE_URL', $scheme . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME'], 2));

require_once __DIR__ . '/doc_setup.php';
foreach (glob(__DIR__ . '/paths/*.php') as $file) {
    require_once $file;
}

$sources = [__DIR__ . '/doc_setup.php', __DIR__ . '/paths'];

if (class_exists(\OpenApi\Builder::class)) {
    $openapi = (new \OpenApi\Builder())->addSource($sources)->build();
} else {
    $openapi = (new \OpenApi\Generator())->generate($sources);
}

header('Content-Type: application/json');
echo $openapi->toJson();