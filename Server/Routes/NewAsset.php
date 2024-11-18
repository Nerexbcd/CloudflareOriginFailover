<?php
    $pagename = "New Asset";

    if (!Permissions::admin()) {
        header("location: /?showError=You don't have Permission to Access or Execute this!!");
        exit();
    }

    require($_SERVER['DOCUMENT_ROOT'].'/Lib/Environment/assets.php');

    if (array_key_exists('create', $_POST)) {

        $result = createNewAsset($_POST["assetName"],$_POST["assetAuthor"],$_POST["category"],$_POST["relBase"],$_POST["urlRef"],$_POST["urlImg"],$_FILES["fileImg"]);
        if ($result['ok']) {
            header("location: /?showSuccess=".$result['message']);
        } else {
            header("location: " . $request . "/?showError=" . $result['message']);
        } 
        
    }

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');

    require $views . 'new-assets.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>