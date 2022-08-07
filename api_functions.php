<?php
// IMPORTS_CHECK
echo (IMPORTS_CHECK) ? "API Functions Loaded!<br>" : '';

function do_echo() {
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

?>