<?php
    $pagename = "Setup";

    if (!Permissions::setup()) {
        header("location: /?showError=Setup already done!!");
        exit();
    }
    
    // if (isset($_POST["setupUser"])) {
    //     $result = setupUser($_POST['username'],$_POST['email'],$_POST['password'],$_POST['passwordconf']);
    //     if ($result['ok']) {
    //         header("location: /?showSuccess=" . $result['message']);
    //     } else {
    //         header("location: " . $request . "/?showError=" . $result['message']);
    //     } 
    // }

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');

    require $views . 'setup.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>