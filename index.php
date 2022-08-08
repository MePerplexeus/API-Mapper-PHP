<?php

// API URL STRUCTURE
// api.{domainname}.{tld}/{version}/{...route_endpoints}

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'config.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'functions.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'api_functions.php');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'endpoints.php');

// IMPORTS_CHECK
echo (IMPORTS_CHECK) ? "Main Page Loaded!<br>" : '';

// CORS
cors();

// MAIN_CODE
$URI = cleanURI($_SERVER['REQUEST_URI']);

// API Version Check & Access
if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $URI[0] . DIRECTORY_SEPARATOR . 'index.php')) {
    require_once(__DIR__ . DIRECTORY_SEPARATOR . $URI[0] . DIRECTORY_SEPARATOR . 'index.php');
}

// echo () ? 'File exists!<br>' : 'File doesn\'t exist!<br>';

$res = run_api($URI, $endpoints);
// echo $res;
echo json_encode(json_decode($res), JSON_PRETTY_PRINT);
// var_dump(headers_list());

?>