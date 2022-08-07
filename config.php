<?php

header('Content-Type: application/json');

define('IMPORTS_CHECK', false);

// IMPORTS_CHECK
echo (IMPORTS_CHECK) ? "Config Loaded!<br>" : '';

define('ALLOWED_ORIGINS', [
    'https://anon.plx',
])

?>