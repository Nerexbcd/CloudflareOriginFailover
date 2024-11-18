<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['theme'])) {
    $_SESSION['theme'] = "night";
}

$theme = $_SESSION['theme'];

// require($_SERVER['DOCUMENT_ROOT']."/Lib/Environment/accounts.php");
require($_SERVER['DOCUMENT_ROOT']."/Lib/featherIcons/featherIcons.php");
require($_SERVER['DOCUMENT_ROOT']."/Lib/Utilities/database.php");
require($_SERVER['DOCUMENT_ROOT']."/Lib/Utilities/generators.php");
require($_SERVER['DOCUMENT_ROOT']."/Lib/Rules/permissions.php");

$request = rtrim(explode('?',$_SERVER['REQUEST_URI'])[0],'/');
$request = $request == "" ? "/" : $request;
$request = explode('/',$request)[1] == "api" ? "/api" : $request;
$request = explode('/',$request)[1] == "assets" ? "/assets" : $request;

$views = __DIR__ . '/Views/';

require($_SERVER['DOCUMENT_ROOT']."/Lib/Base/routing.php");

if (array_key_exists($request, $pages)) {
    require $pages[$request];
} else {
    http_response_code(404);
    // require $viewDir . '404.php';
}

?>