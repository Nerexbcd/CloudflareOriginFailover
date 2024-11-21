<?php

$routesFolder = $_SERVER['DOCUMENT_ROOT'].'/Routes';

$routes = [];

$routesFiles = scandir($routesFolder);

foreach ($routesFiles as $file) {
    if ($file == '.' || $file == '..') {
        unset($routesFiles[array_search($file,$routesFiles)]);
    } else {
        $routesFiles[array_search($file,$routesFiles)] = explode('.',$file)[0];
    }
}

foreach ($routesFiles as $file) {
    $routePath = $routesFolder . '/' . $file . '.php';
    if (is_file($routePath)) {
        $routes[$file] = $routePath;
    }
}

$pages = [];

function setRoute($request,$route) {
    global $pages, $routes;
    $pages[$request] = $routes[$route];
}

require($_SERVER['DOCUMENT_ROOT'].'/Config/routes.php');

?>