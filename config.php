<?php

header('Content-Type: application/json');

define('IMPORTS_CHECK', false);

// SET TIMEZONE
date_default_timezone_set('Asia/Kolkata');

// DEFINED_VARIABLES
define('BASE_URL', preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']));
define('SUB_URL', $_SERVER['HTTP_HOST']);
define('URL', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);

// SESSION SETTINGS
session_name('sugarswap_SSN');
session_set_cookie_params(0, "/", '.'.BASE_URL);
session_start();

// ENC_KEY
define('ENC_KEY', '$2y$10$tOU3gEWcWyJLU87cJayws.eO5s4eJK1g3U4oRlhY55JQ74YHD79oW');


// SET ALLOWED ORIGIN URL ADDRESSES
define('ALLOWED_ORIGINS', [
    'https://app.sugarswap.plx',
]);

// IMPORTS_CHECK
function import_check($message, $nextLine=false) {
    echo (IMPORTS_CHECK) ? (($nextLine)? '
': '' )." • ".$message."
" : '';
}
import_check('Config Loaded!');

?>