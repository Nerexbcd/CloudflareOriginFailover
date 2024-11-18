<?php

$routesFolder = $_SERVER['DOCUMENT_ROOT'].'/Routes/';

$routes = [];

$routesFiles = scandir($routesFolder);

foreach ($routesFiles as $file) {
    $routePath = $routesFolder . '/' . $file;
    if (is_file($routePath)) {
        $routes[explode('.',$file)[0]] = $routePath;
    }
}

$pages = [];

function setRoute($request,$route) {
    global $pages, $routes;
    $pages[$request] = $routes[$route];
}

require($_SERVER['DOCUMENT_ROOT'].'/Config/routes.php');

?>