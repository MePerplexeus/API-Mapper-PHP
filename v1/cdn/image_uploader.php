<?php

function image_uploader() {
    
    if (!array_key_exists('file', $_FILES)) {
        // Nothing to upload!
        $res = [
            'result' => false,
            'message' => "Error: No Image to Upload",
        ];
        $addonKeys = [
            'upload_complete' => false,
            'image_uploaded' => false,
            'db_record_created' => false,
        ];
        
        return genJsonOutputFormat($res, "Image Uploader: Error", $identifier="db_response", $addonKeys);
    }

    $location = 'images/uploads';
    $location_dynamic = 'images' . DIRECTORY_SEPARATOR . 'uploads';

    if ($_FILES['file']['name'] != '') {
        $fileNewName = uniqid('mm_', true);
        $file['name'] = explode('.', $_FILES["file"]["name"]);
        $file['uid'] = $fileNewName;
        $file['ext'] = end($file['name']);
        $file['size'] = filesize($_FILES["file"]["tmp_name"]);
        $file['new_name'] = $file['uid'] . "." . $file['ext'];
        $file['location'] =  realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . $location_dynamic . DIRECTORY_SEPARATOR . $file['new_name'];  
        $file['imgURL'] = URL.'/v1/cdn/image/?id=' . $file['uid'];

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $file['location'])) {
            // Successfully Uploaded
            $signupFormItems = [
                "name" => $file['name'][0],
                "uid" => $file['uid'],
                "path" => $location,
                "type" => $file['ext'],
                "created_by" => $_POST['mmuid'],
                "created_on" => date("Y-m-d H:i:s"),
            ];
            
            sql_init('perplexeus.com', 'creatjad_perplex', 'trenzalore', 'creatjad_madmasters');
            $res = sqlCrt($signupFormItems, 'mm_media');

            if ($res['result']) {
                // DB Record Successful
                $addonKeys = [
                    'upload_complete' => true,
                    'image_uploaded' => true,
                    'db_record_created' => true,
                    'img_url' => $file['imgURL'],
                    'img_name' => $file['new_name'],
                    'img_id' => $file['uid'],
                    'img_location' => $file['location'],
                ];
                return genJsonOutputFormat($res, "Image Uploader: Successfully Uploaded Image", $identifier="db_response", $addonKeys);

            }

            $addonKeys = [
                'upload_complete' => false,
                'image_uploaded' => true,
                'db_record_created' => false,
            ];
            
            if (!unlink($file['location'])) {
                $addonKeys['removed_from_server'] = false;
            }
            else {
                $addonKeys['removed_from_server'] = true;
            }
            return genJsonOutputFormat($res, "Image Uploader: Error", $identifier="db_response", $addonKeys);

        } else {
            // Error: Failed to Upload Image
            $res = [
                'result' => false,
                'message' => "Failed to Upload Image",
            ];
            $addonKeys = [
                'upload_complete' => false,
                'image_uploaded' => false,
                'db_record_created' => false,
            ];
            
            return genJsonOutputFormat($res, "Image Uploader: Error", $identifier="db_response", $addonKeys);
        }
    }
}


?>