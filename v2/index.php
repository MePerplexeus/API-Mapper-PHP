<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . 'functions.php');

// v2 Endpoints
addEndpoint('/v2/cdn/image', 'cdn_fetch_image');
addEndpoint('/v2/cdn/image_up', 'cdn_upload_image'); // Func Not Created Yet 

// Homepage
// addEndpoint('/v2/home/banners', 'get_banners');



// IMPORTS_CHECK
import_check('API v2 Endpoints Loaded!');

?>