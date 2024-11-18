<?php
    // Will be a page where the user uploaded files will be reviewed, marked and moved for the storage


    $pagename = "Process Uploaded Files";

    if (!Permissions::admin()) {
        header("location: /?showError=You don't have Permission to Access or Execute this!!");
        exit();
    }

    require($_SERVER['DOCUMENT_ROOT'].'/Lib/Environment/assets.php');

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');

    require $views . 'processing-uploaded.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>