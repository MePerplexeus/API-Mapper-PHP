<?php

function cdn_fetch_image_v1() {
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'image_fetcher.php');
}

function cdn_upload_image_v1() {
    return authorize(function() {
        require_once(__DIR__ . DIRECTORY_SEPARATOR . 'image_uploader.php');
        return image_uploader();
    });
}


// IMPORTS_CHECK
import_check('API v1 CDN Functions Loaded!');

?>