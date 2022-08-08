<?php

function todaysQuote() {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://zenquotes.io/api/today");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return json_encode(json_decode($output)[0]);
}

?>