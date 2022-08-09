<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'functions.php');

// v1 Endpoints
addEndpoint('/v1/quotes/today', 'todaysQuote');
addEndpoint('/v1/me', 'perplexeus_v1');



// IMPORTS_CHECK
import_check('API v1 Endpoints Loaded!');

?>