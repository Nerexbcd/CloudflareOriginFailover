<?php
    $pagename = "Login";

    if (!Permissions::noLoggedIn()) {
        header("location: /?showError=You are already Logged In!!");
        exit();
    }

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');

    require $views . 'login.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>