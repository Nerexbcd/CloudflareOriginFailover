<?php
    $pagename = "Admin Dashboard";

    if (!Permissions::admin()) {
        header("location: /?showError=You don't have Permission to Access or Execute this!!");
        exit();
    }

    require($_SERVER['DOCUMENT_ROOT'].'/Lib/Environment/assets.php');

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');

    require $views . 'admin.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>