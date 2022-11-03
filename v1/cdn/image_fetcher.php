<?php
// Check if imageID is passed
if (isset($_GET['id']) && !empty($_GET['id'])) {

    // Set imageID as uid
    $uid = $_GET['id'];

    // Set imageType as type
    if (isset($_GET['t']) && !empty($_GET['t'])) {
        $type = $_GET['t'];
        if ($type === '.svg') {
            $path = 'icons';
        } elseif ($type === '.mp4' || $type === '.m4v' || $type === '.avi' || $type === '.mpd') {
            $path = 'videos';
        } else {
            if (isset($_GET['logo'])) {
                $path = 'logo';
                $type = 'png';
            } else {
                $path = 'images';
            }
        }
    } else {
        if (isset($_GET['logo'])) {
            $path = 'logo';
            $type = 'png';
        } else {
            $path = 'images';
            $type = 'jpg';
        }
    }

    // check if image file exists by details
    if (file_exists((__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $uid. '.' .$type))) {
        $name = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $uid. '.' .$type);
    } else {
        $name = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'questions.jpg');
    }


} else {
    // imageID isn't passed
    $type = 'jpg';
    $name = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'questions.jpg');
}

if ($type === '.svg') {
    // file is of svg type
    header("Content-Type: image/svg+xml");
    header("Content-Length: " . filesize($name));
    
    echo file_get_contents($name);
    exit;
}

// open the file in a binary mode
$fp = fopen($name, 'rb');

// send the right headers
header("Content-Type: image/".$type);
header("Content-Length: " . filesize($name));

// dump the picture and stop the script
fpassthru($fp);
exit;

?>