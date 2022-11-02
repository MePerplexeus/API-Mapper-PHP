<?php
// Check if imageID is passed
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // imageID is passed
    // Set imageID as uid
    $uid = $_GET['id'];
    // get image details
    $img = getImageLocation($uid);

    // check if image file exists by details
    if (file_exists((__DIR__ . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $img['path'] . DIRECTORY_SEPARATOR . $img['uid']. '.' .$img['type']))) {
        $name = (__DIR__ . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . $img['path'] . DIRECTORY_SEPARATOR . $img['uid']. '.' .$img['type']);
    } else {
        $name = (__DIR__ . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'questions.jpg');
    }
    
} else {
    // imageID isn't passed
    $img['type'] = 'jpg';
    $name = (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'questions.jpg');
}
// echo uniqid(); // 6310879ec9ea3

if ($img['type'] === 'svg') {
    // file is of svg type
    header("Content-Type: image/svg+xml");
    header("Content-Length: " . filesize($name));
    
    echo file_get_contents($name);
    exit;
}

// open the file in a binary mode
$fp = fopen($name, 'rb');

// send the right headers
header("Content-Type: image/".$img['type']);
header("Content-Length: " . filesize($name));

// dump the picture and stop the script
fpassthru($fp);
exit;

// Function to get image details by id
function getImageLocation($uid) {
    //SET LINK
    sql_init('perplexeus.com', 'creatjad_perplex', 'trenzalore', 'creatjad_madmasters');

    $res = sqlGet(['uid', 'path', 'type'], 'mm_media', ['uid'=>$uid]);
    if ($res['count'] > 0) {
        $res = $res['result'][0]; // first row
        return [
            'uid' => $res[0],
            'path' => $res[1],
            'type' => $res[2],
        ];
        
    }
    return [
        'uid' => 'questions',
        'path' => 'images',
        'type' => 'jpg',
    ];
}
?>