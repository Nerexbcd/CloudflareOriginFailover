<?php
    $pagename = "Asset | " . $_GET["assetId"];

    if (!Permissions::user()) {
        header("location: /?showError=You don't have Permission to Access this Page!!");
        exit();
    }

    require($_SERVER['DOCUMENT_ROOT'].'/Lib/Environment/assets.php');

    if(!checkAsset($_GET["assetId"])){
        header("location: /?showError=Asset Id Not Found!!");
        exit();
    }

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php'); 

    require $views . 'show-assets.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>