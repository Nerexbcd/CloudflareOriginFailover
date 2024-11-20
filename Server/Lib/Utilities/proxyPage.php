<?php

function get_proxy_site_page( $url )
{
    $options = [
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,     // return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    ];

    $ch = curl_init($url);
    // curl_setopt_array($ch, $options);
    $remoteSite = curl_exec($ch);
    curl_close($ch);
    return $remoteSite;
}