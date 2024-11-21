<!DOCTYPE html>
<html lang="en" class="<?=$theme?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Nerexbcd">
    <title><?=$pagename; ?></title>
    <link rel="stylesheet" href="/Resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Resources/css/style.css">
    <link rel="stylesheet" href="/Resources/css/main-theme.css">
    <link rel="stylesheet" href="/Resources/css/simplebar.css">
    <link rel="stylesheet" href="/Resources/css/tom-select.bootstrap5.min.css">
    <script src="/Resources/js/bootstrap.bundle.min.js"></script>
    <script src="/Resources/js/forms.js"></script>
    <script src="/Resources/js/tom-select.complete.js"></script>
</head>
<body class="theme-bg">
    <header class="theme-bg-sec p-2 px-3 d-flex justify-content-between">
        <a href="/" class="text-decoration-none d-flex  align-items-center"><h3 class="theme-text mb-0 ">AssetOrganizationSystem</h3></a>
        <div class="d-flex">
            <button onclick="changeTheme()" class="btn btn-link p-0 text-decoration-none mx-1 mt-1"><h3 class="theme-text"><span id="theme_icon_sun" class="<?= $theme == 'night'?'':'d-none' ?>"><?=$icons->getIcon('sun')?></span><span id="theme_icon_moon" class="<?= $theme == 'night' ? 'd-none' : '' ?>"><?=$icons->getIcon('moon')?></span></h3></button>
            <?php 
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                    echo '<a href="#" data-bs-toggle="offcanvas" data-bs-target="#sidemenu" class="text-decoration-none mx-1 mt-1"><h3 class="theme-text">' . $icons->getIcon('menu') . '</h3></a>';
                } else {
                    echo '<a href="/login/" class="text-decoration-none mx-1 mt-1"><h3 class="theme-text">' . $icons->getIcon('user') . '</h3></a>';
                }
            ?>
        </div>
    </header>
    <div class="m-auto">
        <div class="container">
            <div class="d-flex py-4 justify-content-center float-start w-100">
                <div id="showSuccess" class="<?=isset($_GET["showSuccess"]) ? "" : "d-none"?> alert alert-success w-100 d-flex justify-content-between" role="alert"><div id="showSuccessText" class="align-middle"><?=$_GET["showSuccess"]?></div><a href="<?=$request?>" class="text-decoration-none float-end" style="color: #0a3622;"><?=$icons->getIcon('x')?></a></div>
                <div id="showError" class="<?=isset($_GET["showError"]) ? "" : "d-none"?> alert alert-danger w-100 d-flex justify-content-between" role="alert"><div id="showErrorText" class="align-middle"><?=$_GET["showError"]?></div><a href="<?=$request?>" class="text-decoration-none float-end" style="color: #58151c;"><?=$icons->getIcon('x')?></a></div>
                <div id="showWarning" class="<?=isset($_GET["showWarning"]) ? "" : "d-none"?> alert alert-warning w-100 d-flex justify-content-between" role="alert"><div id="showWarningText" class="align-middle"><?=$_GET["showWarning"]?></div><a href="<?=$request?>" class="text-decoration-none float-end" style="color: #664d03;"><?=$icons->getIcon('x')?></a></div>
            </div>
        </div>
    </div>

    <script>
        function changeTheme() {
            fetch('/changetheme');
            var isNight = document.getElementsByTagName('html')[0].classList.contains('night');

            if (isNight) {
                document.getElementsByTagName('html')[0].classList.remove('night');
                document.getElementById('theme_icon_sun').classList.add('d-none');
                document.getElementById('theme_icon_moon').classList.remove('d-none');
            } else {
                document.getElementsByTagName('html')[0].classList.add('night');
                document.getElementById('theme_icon_sun').classList.remove('d-none');
                document.getElementById('theme_icon_moon').classList.add('d-none');
            }
        }
    </script>