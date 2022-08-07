<?php
// IMPORTS_CHECK
echo (IMPORTS_CHECK) ? "API Functions Loaded!<br>" : '';

function do_echo() {
    $myObj = [
        "status" => http_response_text(http_response_code()),
        "code" => http_response_code(),
        "message" => "Testing in progress!",
        "result" => "Successful",
        "http_origin" => $_SERVER['HTTP_ORIGIN']
    ];

    $myJSON = json_encode($myObj);

    return $myJSON;
}

?>