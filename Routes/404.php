<?php
require($_SERVER['DOCUMENT_ROOT']."/Lib/Utilities/proxyPage.php");

$page =  get_proxy_site_page('https://failover.nerexbcd.dev');

if (!str_contains($_SERVER['HTTP_HOST'],'nerexbcd.dev')) {$page = str_replace('<script src="https://failover.nerexbcd.dev/dev.js" type="text/javascript"></script>', '',$page);}

echo $page;
http_response_code(404);