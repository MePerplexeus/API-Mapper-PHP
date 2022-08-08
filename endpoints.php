<?php

echo (IMPORTS_CHECK) ? "Endpoints Loaded!<br>" : '';

// Endpoints
$endpoints = [
    "test" => 'test',
    "dev" => 'perplexeus',
    "help" => [
        'endpoints' => 'showEndpoints',
    ],
    "err" => [
        "404" => 'err_404',
        "500" => 'err_500',
        "test" => 'test',
    ],
];


?>