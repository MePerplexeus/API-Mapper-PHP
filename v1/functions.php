<?php

function todaysQuote() {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://zenquotes.io/api/today");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    
    $myObj = [
        "status" => http_response_text(http_response_code()),
        "code" => http_response_code(),
        "message" => "Here's Your Quote Of The Day!",
        "quote" => json_decode($output)[0],
        "http_origin" => (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null,
    ];
    return json_encode($myObj);
}

function perplexeus_v1() {
    $auth = authorization_check();
    if ($auth[0]) {
        return perplexeus();
    } else {
        return $auth[1];
    }
    
}

?>