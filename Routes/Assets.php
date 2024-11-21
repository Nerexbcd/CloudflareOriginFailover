<?php
    $request = explode('/',rtrim(explode('?',$_SERVER['REQUEST_URI'])[0],'/'));

    require($_SERVER['DOCUMENT_ROOT'].'/Lib/Environment/assets.php');

    if (count($request) >= 3) {
        if (!Permissions::user()) {
            header("location: /?showError=You don't have Permission to Access or Execute this!!");
            exit();
        }

        $assetId = $request[2];

        require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
        require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');
    
        require $views . 'show-asset.php';
    
        require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');

        return;
    }

    $pagename = "Assets Admin Page";

    if (!Permissions::admin()) {
        header("location: /?showError=You don't have Permission to Access or Execute this!!");
        exit();
    }

    if (array_key_exists('deletionConfirmed', $_POST)) {
        deleteAsset($_POST["assetId"]);
        header("location: " . $request . "/?showSuccess=Asset Deleted with Success!");
    }


    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');

    require $views . 'assets.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>