<?php
require($_SERVER['DOCUMENT_ROOT']."/Lib/Utilities/proxyPage.php");

echo str_replace('<script src="https://failover.nerexbcd.dev/dev.js" type="text/javascript"></script>', '', str_replace('<script type="text/javascript">autoMode()</script>','<script type="text/javascript">setMode("404")</script>',str_replace('// Mode Line (Auto)','// Mode Line (Custom)',get_proxy_site_page('https://failover.nerexbcd.dev/?mode=404'))));
http_response_code(404);