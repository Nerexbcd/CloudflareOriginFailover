<?php
require($_SERVER['DOCUMENT_ROOT']."/Lib/Utilities/proxyPage.php");

/* echo '<script>console.log('.file_get_contents('http://failover.nerexbcd.dev/index.html', false, stream_context_create($arrContextOptions)).')</script>';
echo file_get_contents('http://failover.nerexbcd.dev/index.html'); */

echo str_replace('<script src="https://failover.nerexbcd.dev/dev.js" type="text/javascript"></script>', '', str_replace('<script type="text/javascript">autoMode()</script>','<script type="text/javascript">setMode("404")</script>',str_replace('// Mode Line (Auto)','// Mode Line (Custom)',get_proxy_site_page('https://failover.nerexbcd.dev'))));
http_response_code(404);