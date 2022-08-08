<?php

header('Content-Type: application/json');

define('IMPORTS_CHECK', false);

// DEFINED_VARIABLES
define('BASE_URL', preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']));
define('URL', $_SERVER['HTTP_HOST']);

define('ALLOWED_ORIGINS', [
    'https://anon.plx',
]);

// IMPORTS_CHECK
echo (IMPORTS_CHECK) ? "Config Loaded!<br>" : '';

?>