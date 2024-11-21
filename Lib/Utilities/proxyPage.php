<?php

function get_proxy_site_page( $url )
{
    $ch = curl_init($url);

/*     $options = [
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,     // return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    ];

    curl_setopt_array($ch, $options); */


    curl_setopt(($ch), CURLOPT_RETURNTRANSFER, true);
    curl_setopt(($ch), CURLOPT_HEADER, false);
    curl_setopt(($ch), CURLOPT_FOLLOWLOCATION, true);
    curl_setopt(($ch), CURLOPT_ENCODING, "");
    curl_setopt(($ch), CURLOPT_AUTOREFERER, true);
    curl_setopt(($ch), CURLOPT_CONNECTTIMEOUT, 120);
    curl_setopt(($ch), CURLOPT_TIMEOUT, 120);
    curl_setopt(($ch), CURLOPT_MAXREDIRS, 10);

    curl_setopt(($ch), CURLOPT_SSL_VERIFYPEER, false);

    $remoteSite = curl_exec($ch);
    curl_close($ch);
    return $remoteSite;
}