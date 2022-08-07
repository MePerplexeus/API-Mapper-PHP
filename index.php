<?php

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/functions.php');
require_once(__DIR__.'/api_functions.php');
require_once(__DIR__.'/endpoints.php');

// IMPORTS_CHECK
echo (IMPORTS_CHECK) ? "Main Page Loaded!<br>" : '';

// CORS
cors();

// MAIN_CODE
$URI = explode('/', cleanURI());
$res = run_api($URI, $endpoints);
// echo $res;
echo json_encode(json_decode($res), JSON_PRETTY_PRINT);
// var_dump(headers_list());

?>