<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'functions.php');

// v1 Endpoints
// addEndpoint('/v1/quotes/today', 'todaysQuote');
// addEndpoint('/v1/me', 'perplexeus_auth');
addEndpoint('/v1/cdn/image', 'cdn_fetch_image_v1');
addEndpoint('/v1/cdn/image_up', 'cdn_upload_image_v1'); // Func Not Created Yet 

// Homepage
addEndpoint('/v1/home/banners', 'get_banners');



// IMPORTS_CHECK
import_check('API v1 Endpoints Loaded!');

?>