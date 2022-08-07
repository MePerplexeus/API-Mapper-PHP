<?php

echo (IMPORTS_CHECK) ? "Endpoints Loaded!<br>" : '';

// Endpoints
$endpoints = [
    "test" => 'do_echo',
    "dev" => 'perplexeus',
    "err" => [
        "404" => 'err_404',
        "500" => 'err_500',
        "test" => 'do_echo',
    ],
];


?>