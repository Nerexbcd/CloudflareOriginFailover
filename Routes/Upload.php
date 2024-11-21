<?php
    // Will be a Page where the user selects the asset to upload, and use plupload to separate in chuncks and upload it

    $pagename = "Upload Asset Files | " . $_GET["assetId"];

    if (!Permissions::admin()) {
        header("location: /?showError=You don't have Permission to Access or Execute this!!");
        exit();
    }
    
    require($_SERVER['DOCUMENT_ROOT'].'/Lib/Environment/assets.php');

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');

    require $views . 'upload.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>