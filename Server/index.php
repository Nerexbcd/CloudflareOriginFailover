<?php

// require($_SERVER['DOCUMENT_ROOT']."/Lib/Environment/accounts.php");
/* require($_SERVER['DOCUMENT_ROOT']."/Lib/Utilities/database.php");
require($_SERVER['DOCUMENT_ROOT']."/Lib/Utilities/generators.php");
require($_SERVER['DOCUMENT_ROOT']."/Lib/Rules/permissions.php"); */

$request = rtrim(explode('?',$_SERVER['REQUEST_URI'])[0],'/');
$request = $request == "" ? "/" : $request;
$request = explode('/',$request)[1] == "api" ? "/api" : $request;

$views = $_SERVER['DOCUMENT_ROOT'] . '/Views/';

require($_SERVER['DOCUMENT_ROOT']."/Lib/Base/routing.php");

if (array_key_exists($request, $pages)) {
    require $pages[$request];
} else {
    require $pages['/404'];
}

?>