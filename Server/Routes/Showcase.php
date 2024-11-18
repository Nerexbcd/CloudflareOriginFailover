<?php
    $pagename = "Showcase";
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Lib/Environment/assets.php');

    if (isset($_GET['search'])) {
        $query = $_GET['search'];
    } else {
        $query = false;
    }

    require $views . 'showcase.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>