<?php
    $pagename = "Recover Password";

    if (!Permissions::noLoggedIn()) {
        header("location: /?showError=You are already Logged In!!");
        exit();
    }

    // if (isset($_GET["reset"])) 
    // { 
    //     resetRecovery();
    //     header("location: " . $request . "/");
    // }


    // $first = false;

    // if(array_key_exists('submit', $_POST)) { 
    //     if ($first) {

    //     } else {
    //         $result = confirmRecovery($_POST['confCode']);
    //         if ($result['ok']) {
    //             header("location: /?showSuccess=".$result['message']);
    //         } else {
    //             header("location: " . $request . "/?showError=" . $result['message']);
    //         } 
    //     }
    // }

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/header.php');
    require($_SERVER['DOCUMENT_ROOT'].'/Inc/sidemenu.php');

    require $views . 'password-recovery.php';

    require($_SERVER['DOCUMENT_ROOT'].'/Inc/footer.php');
?>