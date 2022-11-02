<?php

function test() {
    $myObj = genJsonOutputFormat("Successful", $message="API Testing in progress!");

    return $myObj;
}

function err_404() {
    http_response_code(404);
    $myObj = genJsonOutputFormat('404', $message="Errno 404: Page not Found. ):");

    return $myObj;
}

function err_500() {
    http_response_code(500);
    $myObj = genJsonOutputFormat('500', $message="Errno 500: Internal Server Error. ):");

    return $myObj;
}

function perplexeus() {

    $myObj = genJsonOutputFormat([
            "name" => "Prithvi Soma",
            "founder" => "Perplexeus",
            "site" => "https://me.perplexeus.com/",
            "insta" => "https://instagram.com/perplexeus/",
        ], $message="Remember: Anything is Possible", $identifier="contact");

    return $myObj;
}


// IMPORTS_CHECK
import_check('API Functions Loaded!');

?>