<?php

function test() {
    $myObj = [
        "status" => http_response_text(http_response_code()),
        "code" => http_response_code(),
        "message" => "Testing in progress!",
        "result" => "Successful",
        "http_origin" => (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null
    ];

    $myJSON = json_encode($myObj);

    return $myJSON;
}
function err_404() {
    http_response_code(404);
    $myObj = [
        "status" => http_response_text(http_response_code()),
        "code" => http_response_code(),
        "message" => "Errno 404: Page not Found. ):",
        "http_origin" => (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null,
    ];

    $myJSON = json_encode($myObj);

    return $myJSON;
}

function err_500() {
    http_response_code(500);
    $myObj = [
        "status" => http_response_text(http_response_code()),
        "code" => http_response_code(),
        "message" => "Errno 500: Internal Server Error. ):",
        "http_origin" => (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null,
    ];

    $myJSON = json_encode($myObj);

    return $myJSON;
}

function perplexeus() {

    $myObj = [
        "status" => http_response_text(http_response_code()),
        "code" => http_response_code(),
        "message" => "Remember: Anything is Possible",
        "contact" => [
            "name" => "Prithvi Soma",
            "founder" => "Perplexeus",
            "site" => "https://me.perplexeus.com/",
            "insta" => "https://instagram.com/perplexeus/",
        ],
        "http_origin" => (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null,
    ];

    $myJSON = json_encode($myObj);

    return $myJSON;
}


// IMPORTS_CHECK
import_check('API Functions Loaded!');

?>