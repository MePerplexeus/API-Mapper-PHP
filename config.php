<?php

header('Content-Type: application/json');

define('IMPORTS_CHECK', false);

// DEFINED_VARIABLES
define('BASE_URL', preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']));
define('URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);

// ENC_KEY
define('ENC_KEY', '$2y$10$tOU3gEWcWyJLU87cJayws.eO5s4eJK1g3U4oRlhY55JQ74YHD79oW');


define('ALLOWED_ORIGINS', [
    'https://anon.plx',
]);

// IMPORTS_CHECK
echo (IMPORTS_CHECK) ? "Config Loaded!<br>" : '';

?>