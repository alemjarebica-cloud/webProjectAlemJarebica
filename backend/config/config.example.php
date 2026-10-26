<?php
// Copy this file to config.php and fill in your real values.
// config.php is in .gitignore and must never be committed.

return [
    'db' => [
        'host' => 'localhost',
        'name' => 'quizhub',
        'user' => 'root',
        'pass' => '',
    ],
    'jwt_secret' => 'CHANGE_ME_TO_A_LONG_RANDOM_STRING',
    'external_api' => [
        'base_url' => 'https://opentdb.com',
        'api_key'  => '', // Open Trivia DB does not need a key, left here for the template
    ],
];