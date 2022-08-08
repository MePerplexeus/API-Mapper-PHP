<?php

// IMPORTS_CHECK
echo (IMPORTS_CHECK) ? "Functions Loaded!<br>" : '';

function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}

function cleanURI($URI) {
    return explode('/', (endsWith($URI, '/')) ? substr($URI, 1, -1) : substr($URI, 1));
}

function IsNullOrEmptyString($str){
    return ($str === null || trim($str) === '');
}

function run_api($URI, $endpoints) {
    if (!IsNullOrEmptyString($URI[0])) {

        if (!array_key_exists($URI[0], $endpoints)) {
            return err_404();
        }

        $endpoint = $endpoints[$URI[0]];
        array_shift($URI);

        if (count($URI)) {
            return run_api($URI, $endpoint);

        } else {

            if (is_callable($endpoint)) {
                // echo '{callable: '.$endpoint.'}'; // check called function name
                return $endpoint();

            } else {
                // echo "{uncallable: 404}";
                return err_404();

            }
        }
    } else {
        // echo "{uncallable: 404}";
        return err_404();
    }
}

function cors() {
    
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        if (in_array($_SERVER['HTTP_ORIGIN'], ALLOWED_ORIGINS)){
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    
        exit(0);
    }
    
    // echo "You have CORS!";
}

function http_response_text($code = NULL) {

    if ($code !== NULL) {

        switch ($code) {
            case 100: $text = 'Continue'; break;
            case 101: $text = 'Switching Protocols'; break;
            case 200: $text = 'OK'; break;
            case 201: $text = 'Created'; break;
            case 202: $text = 'Accepted'; break;
            case 203: $text = 'Non-Authoritative Information'; break;
            case 204: $text = 'No Content'; break;
            case 205: $text = 'Reset Content'; break;
            case 206: $text = 'Partial Content'; break;
            case 300: $text = 'Multiple Choices'; break;
            case 301: $text = 'Moved Permanently'; break;
            case 302: $text = 'Moved Temporarily'; break;
            case 303: $text = 'See Other'; break;
            case 304: $text = 'Not Modified'; break;
            case 305: $text = 'Use Proxy'; break;
            case 400: $text = 'Bad Request'; break;
            case 401: $text = 'Unauthorized'; break;
            case 402: $text = 'Payment Required'; break;
            case 403: $text = 'Forbidden'; break;
            case 404: $text = 'Not Found'; break;
            case 405: $text = 'Method Not Allowed'; break;
            case 406: $text = 'Not Acceptable'; break;
            case 407: $text = 'Proxy Authentication Required'; break;
            case 408: $text = 'Request Time-out'; break;
            case 409: $text = 'Conflict'; break;
            case 410: $text = 'Gone'; break;
            case 411: $text = 'Length Required'; break;
            case 412: $text = 'Precondition Failed'; break;
            case 413: $text = 'Request Entity Too Large'; break;
            case 414: $text = 'Request-URI Too Large'; break;
            case 415: $text = 'Unsupported Media Type'; break;
            case 500: $text = 'Internal Server Error'; break;
            case 501: $text = 'Not Implemented'; break;
            case 502: $text = 'Bad Gateway'; break;
            case 503: $text = 'Service Unavailable'; break;
            case 504: $text = 'Gateway Time-out'; break;
            case 505: $text = 'HTTP Version not supported'; break;
            default: $text = 'Unknown http status code "' . $code . '"'; break;
        }
        return $text;
    }
}

function flatCall($data_arr, $data_arr_call){
    $current = $data_arr;
    foreach($data_arr_call as $key){
        $current = $current[$key];
    }

    return $current;
}

function addEndpoint($URI, $function) {
    global $endpoints;

    if (!IsNullOrEmptyString($URI) && is_callable($function)) {
        $keys = cleanURI($URI);
        $string='$endpoints';
        foreach($keys as $index => $key) {   
            $string.="['".$key."']";
        }
        $string.= '="'.$function.'";';
        eval($string);

        // echo json_encode($endpoints);
    }
}

?>