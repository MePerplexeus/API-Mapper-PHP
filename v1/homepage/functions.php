<?php

function get_banners() {
    
    $auth = authorization_check();
    if ($auth[0]) {

        // required input data
        // => page (homepage/userdash)
        // => status (published/draft/inactive)
        // => date (today)

        // content DB
        // => id
        // => type [banner_homepage/banner_userdash/posts(blog)/shorts/reviews/...]
        // => content [banner(bg[],heading,subheading,button[])/...]
        // => status
        // => date_created
        // => created_by
        // => start_date
        // => end_date

        $banners = [
            [
                "bg" => [
                    "mobile" => "https://www.freepik.com/vectors/background-banner",
                    "tablet" => "https://www.freepik.com/vectors/background-banner",
                    "desktop" => "https://www.freepik.com/vectors/background-banner",
                ],
                "heading" => "Anime - The source of my motivation",
                "subheading" => "Journey to fitness",
                "button" => [
                    "text" => "Explore",
                    "link" => "/anime-fitness",
                ],
            ],
            [
                "bg" => [
                    "mobile" => "https://www.freepik.com/vectors/background-banner",
                    "tablet" => "https://www.freepik.com/vectors/background-banner",
                    "desktop" => "https://www.freepik.com/vectors/background-banner",
                ],
                "heading" => "Anime - The source of my motivation",
                "subheading" => "Journey to fitness",
                "button" => [
                    "text" => "Explore",
                    "link" => "/anime-fitness",
                ],
            ],
            [
                "bg" => [
                    "mobile" => "https://www.freepik.com/vectors/background-banner",
                    "tablet" => "https://www.freepik.com/vectors/background-banner",
                    "desktop" => "https://www.freepik.com/vectors/background-banner",
                ],
                "heading" => "Anime - The source of my motivation",
                "subheading" => "Journey to fitness",
                "button" => [
                    "text" => "Explore",
                    "link" => "/anime-fitness",
                ],
            ],
        ];
        
        $myObj = [
            "status" => http_response_text(http_response_code()),
            "code" => http_response_code(),
            "message" => "Active Banners for Homepage",
            "banners" => $banners,
            "http_origin" => (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null,
        ];

        return json_encode($myObj);

    } else {
        return $auth[1];
    }
}

// IMPORTS_CHECK
import_check('API v1 Homepage Functions Loaded!');

?>