<?php
require "includes/config.php";
require "includes/classes/User.php";
require "includes/classes/Artist.php";
require "includes/classes/Album.php";
require "includes/classes/Song.php";


$db = new Database();
$con = $db->getConnString();



if (isset($_SESSION['userLoggedIn'])) {
    $sessionusername = $_SESSION['userLoggedIn'];
    $userLoggedIn = new User($con,  $_SESSION['userLoggedIn']);

    //TODO: Check if username exists
    $checkUsernameQuery = mysqli_query($con, "SELECT username FROM users WHERE username = '$sessionusername'");
    if (mysqli_num_rows($checkUsernameQuery) != 0) {

        if ($userLoggedIn->getcheckuser()) {
            $username = $userLoggedIn->getUsername();
            $userId = $userLoggedIn->getUserId();
            $userrole = $userLoggedIn->getUserrole();
            $userRegstatus = $userLoggedIn->getUserStatus();
            echo "<script>
            userLoggedIn = '$username'; 
            
            </script>";
            if ($userRegstatus === "registered") {
                echo "
                    <script>
                    isRegistered = '$userRegstatus';
                    
                    </script>";
            }
        } else {
            $username = $sessionusername;
            $userId = $sessionusername;
            $userrole = $sessionusername;
            $userRegstatus = "trial";
            echo "<script>userLoggedIn = '$sessionusername'; </script>";
        }
    } else {
        $userLoggedIn = new User($con,  $_SESSION['userLoggedIn']);
        if ($userLoggedIn->getcheckuser()) {
            $username = $userLoggedIn->getUsername();
            $userId = $userLoggedIn->getUserId();
            $userrole = $userLoggedIn->getUserrole();
            $userRegstatus = $userLoggedIn->getUserStatus();
            echo "<script>userLoggedIn = '$username'; </script>";
            if ($userRegstatus === "registered") {
                echo "
                    <script>
                    isRegistered = '$userRegstatus';
                    
                    </script>";
            }
        } else {
            $username = 'Guest';
            $username = $username;
            $userId = $username;
            $userrole = $username;
            $userRegstatus = "trial";
            echo "<script>userLoggedIn = '$sessionusername'; </script>";
        }
    }
} elseif (isset($_COOKIE['userID']) && ($_COOKIE['userID'] != '')) {

    //get cookie value and assign to varible
    $cookieusername = $_COOKIE['userID'];
    //TODO: Check if username exists
    $checkUsernameQuery = mysqli_query($con, "SELECT username FROM users WHERE username = '$cookieusername'");

    if (mysqli_num_rows($checkUsernameQuery) != 0) {
        //set sessionbased on cookie -- linked to nowPlayingcontainer to work
        $_SESSION['userLoggedIn'] = $cookieusername;

        $userLoggedIn = new User($con, $cookieusername);

        if ($userLoggedIn->getcheckuser()) {
            $username = $userLoggedIn->getUsername();
            $userId = $userLoggedIn->getUserId();
            $userrole = $userLoggedIn->getUserrole();
            $userRegstatus = $userLoggedIn->getUserStatus();
            echo "<script>userLoggedIn = '$username'; </script>";

            if ($userRegstatus === "registered") {
                echo "
                    <script>
                    isRegistered = '$userRegstatus';
                    
                    </script>";
            } 
        } else {
            $username = 'Guest';
            $username = $username;
            $userId = $username;
            $userrole = $username;
            $userRegstatus = "trial";
            echo "<script>userLoggedIn = '$username'; </script>";
        }
    } else {
    }
} else {

    $username = 'Guest';
    $_SESSION['userLoggedIn'] = $username;

    $userLoggedIn = new User($con, $username);

    if ($userLoggedIn->getcheckuser()) {
        $username = $userLoggedIn->getUsername();
        $userId = $userLoggedIn->getUserId();
        $userrole = $userLoggedIn->getUserrole();
        $userRegstatus = $userLoggedIn->getUserStatus();
        echo "<script>userLoggedIn = '$username'; </script>";

        if ($userRegstatus === "registered") {
            echo "
                <script>
                isRegistered = '$userRegstatus';
                
                </script>";
        } 
    } else {
        $username = $username;
        $userId = $username;
        $userrole = $username;
        $userRegstatus = "trial";
        echo "<script>userLoggedIn = '$username'; </script>";
    }
}


if (isset($_GET['term'])) {
    $term = urldecode($_GET['term']);
} else {
    $term = "";
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YNG3P75VXH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-YNG3P75VXH');
    </script>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mwonyaa Stream</title>

    <!-- favicon -->
    <meta name="theme-color" content="#381b56" />
    <link rel="shortcut icon" href="assets/favicon/favicon.ico">
    <meta name="msapplication-config" content="assets/favicon/browserconfig.xml">
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">


    <!-- favicon end  -->

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('mwonyaa_service_worker.js').then(function(registration) {
                console.log('ServiceWorker registration successful!');
            }).catch(function(err) {
                console.log('ServiceWorker registration failed: ', err);
            });
        }
    </script>


    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900italic,900' rel='stylesheet' type='text/css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/8.3.0/nouislider.min.css'>

    <link rel="stylesheet" href="staticFiles/css/style.css">
    <!-- <link rel="stylesheet" href="https://d1d1i04hu392ot.cloudfront.net/staticFiles/css/style.css"> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- <script src="https://d1d1i04hu392ot.cloudfront.net/staticFiles/js/MainScript.js"></script> -->
    <script src="staticFiles/js/MainScript.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.4.0/dist/ionicons/ionicons.js"></script>

    <!-- <script src="https://unpkg.com/wavesurfer.js"></script> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js" integrity="sha512-eviLb3jW7+OaVLz5N3B5F0hpluwkLb8wTXHOTy0CyNaZM5IlShxX1nEbODak/C0k9UdsrWjqIBKOFY0ELCCArw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(".searchInput").focus();
        $(function() {

            $(".searchInput").keyup(function() {
                clearTimeout(timer);

                $(".spinner img").css("visibility", "visible");


                timer = setTimeout(function() {

                    var val = $(".searchInput").val();
                    openPage("search?term=" + val);
                }, 2000)
            });

        });

        function menuhandler() {
            document.getElementById("navmenu").classList.toggle("change");
            document.getElementById("nav").classList.toggle("navchange");
        }
    </script>


</head>

<body>



    <section class="content">

        <?php

        include("includes/navBarContainer.php");

        ?>



        <div class="content__middle">

            <div class="page-topbar" id="page_topbar">
                <div class="topbar-search">
                    <div class="popper-wrapper">

                        <div id="menu-bar">
                            <div id="navmenu" onclick="menuhandler()">
                                <div id="bar1" class="bar"></div>
                                <div id="bar2" class="bar"></div>
                                <div id="bar3" class="bar"></div>
                            </div>
                        </div>

                        <form class="topbar-search-form" autocomplete="off">
                            <button class="topbar-search-submit" type="submit" aria-labelledby="topbar-search">
                                <svg viewBox="0 0 16 16" width="16" height="16" focusable="false" role="img" aria-hidden="true" class="sk__sc-1vdzswr-0 bcVpWu topbar-search-icon">
                                    <g>
                                        <path d="M13 7.5a5.5 5.5 0 1 0-11 0 5.5 5.5 0 0 0 11 0zm-1.43 5.07a6.5 6.5 0 1 1 .73-.685l2.054 2.054a.5.5 0 0 1-.708.707L11.57 12.57z"></path>
                                    </g>
                                </svg>
                            </button>
                            <input name="searchinputfield" class="searchInput topbar-search-input" id="topbar-search" type="search" aria-label="Search" placeholder="Search" value="<?php echo $term ?>" onfocus="this.value = this.value" />
                            <button class="topbar-search-clear" type="button" aria-hidden="true" aria-label="Clear">
                                <svg viewBox="0 0 16 16" width="16" height="16" focusable="false" role="img" aria-hidden="true" class="sk__sc-1vdzswr-0 bcVpWu topbar-search-icon">
                                    <g>
                                        <path d="m8.002 8.71 6.295 6.294.707-.707L8.71 8.002l6.294-6.295L14.297 1 8.002 7.295 1.707 1 1 1.707l6.295 6.295L1 14.297l.707.707L8.002 8.71z"></path>
                                    </g>
                                </svg>
                            </button>
                            <span class="spinner"> <img src="assets/images/icons/spinner.gif" alt=""></span>

                        </form>
                    </div>
                </div>
                <div class="popper-wrapper topbar-action"><button class="topbar-notification" type="button" aria-label="Notifications"><svg class="svg-icon svg-icon-bell" focusable="false" height="18" role="img" width="18" viewBox="0 0 12 12" aria-hidden="true">
                            <path d="M6.003 0C6.513 0 7.029 0 7 1c1.569.196 2.992 1.677 3 3.5.009 1.957.16 3.293.856 3.854.091.073.144.183.144.3v.961a.385.385 0 0 1-.385.385h-9.23A.385.385 0 0 1 1 9.615v-.961c0-.117.053-.227.144-.3.697-.56.847-1.897.856-3.854.009-1.99 1.23-3.342 2.999-3.5-.015-1 .494-1 1.004-1ZM5 11.328 8 11l-.175.283c-.29.472-.733.717-1.305.717-.55 0-.982-.144-1.28-.437L5 11.328Z"></path>
                        </svg>


                        <span class="badge badge-info topbar-notification-counter" aria-hidden="true">20</span></button></div>

                <div class="popper-wrapper topbar-action"><button onclick="openPage('manageaccount')" class="topbar-profile" type="button">
                        <!-- <img class="topbar-profile-picture" src="<?= $userLoggedIn->getcheckuser() ? $userLoggedIn->getuserCoverimage() : $username ?>" alt="user"> -->

                        <svg class="svg-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 22.8C17.9646 22.8 22.8 17.9646 22.8 12C22.8 6.0354 17.9646 1.2 12 1.2C6.0354 1.2 1.2 6.0354 1.2 12C1.2 17.9646 6.0354 22.8 12 22.8ZM12 24C18.6276 24 24 18.6276 24 12C24 5.3724 18.6276 0 12 0C5.3724 0 0 5.3724 0 12C0 18.6276 5.3724 24 12 24Z" fill="#CBB0E7" />
                            <path d="M4.80078 18.978C4.80078 18.3582 5.26398 17.8344 5.88078 17.766C10.5098 17.2536 13.5128 17.2998 18.1316 17.7774C18.3622 17.8016 18.5808 17.8925 18.7607 18.0389C18.9405 18.1853 19.0739 18.3809 19.1444 18.6019C19.2149 18.8228 19.2195 19.0595 19.1577 19.283C19.0959 19.5066 18.9704 19.7073 18.7964 19.8606C13.3454 24.612 10.2302 24.5466 5.18478 19.8654C4.93878 19.6374 4.80078 19.3134 4.80078 18.9786V18.978Z" fill="#CBB0E7" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.0682 18.3738C13.486 17.8998 10.5262 17.8554 5.94462 18.3624C5.79381 18.3799 5.65478 18.4525 5.55414 18.5662C5.45351 18.6799 5.39835 18.8267 5.39922 18.9786C5.39922 19.1502 5.47062 19.3128 5.59122 19.4256C8.09202 21.7452 9.98682 22.7934 11.839 22.8C13.6978 22.8066 15.6946 21.7668 18.4006 19.4088C18.4866 19.3322 18.5485 19.2324 18.5788 19.1214C18.609 19.0103 18.6064 18.8929 18.5712 18.7833C18.536 18.6738 18.4697 18.5768 18.3804 18.5042C18.2911 18.4316 18.1827 18.3865 18.0682 18.3744V18.3738ZM5.81322 17.1696C10.4908 16.6518 13.5376 16.6986 18.1924 17.1804C18.5394 17.2166 18.8683 17.3532 19.1388 17.5734C19.4094 17.7937 19.6098 18.0881 19.7157 18.4205C19.8215 18.7529 19.8281 19.109 19.7346 19.4451C19.6412 19.7812 19.4518 20.0828 19.1896 20.313C16.4446 22.7058 14.1586 24.009 11.8354 24C9.50562 23.9916 7.32042 22.6662 4.77582 20.3052C4.59363 20.1355 4.4484 19.93 4.34919 19.7017C4.24998 19.4733 4.19893 19.2269 4.19922 18.978C4.19835 18.5306 4.36254 18.0987 4.66036 17.7649C4.95818 17.4311 5.36867 17.2189 5.81322 17.169V17.1696Z" fill="#CBB0E7" />
                            <path d="M16.7992 9.60005C16.7992 10.8731 16.2935 12.094 15.3933 12.9942C14.4932 13.8943 13.2723 14.4 11.9992 14.4C10.7262 14.4 9.50528 13.8943 8.60511 12.9942C7.70493 12.094 7.19922 10.8731 7.19922 9.60005C7.19922 8.32701 7.70493 7.10611 8.60511 6.20594C9.50528 5.30576 10.7262 4.80005 11.9992 4.80005C13.2723 4.80005 14.4932 5.30576 15.3933 6.20594C16.2935 7.10611 16.7992 8.32701 16.7992 9.60005V9.60005Z" fill="#CBB0E7" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9992 13.2C12.954 13.2 13.8697 12.8208 14.5448 12.1456C15.2199 11.4705 15.5992 10.5548 15.5992 9.60005C15.5992 8.64527 15.2199 7.7296 14.5448 7.05446C13.8697 6.37933 12.954 6.00005 11.9992 6.00005C11.0444 6.00005 10.1288 6.37933 9.45363 7.05446C8.7785 7.7296 8.39922 8.64527 8.39922 9.60005C8.39922 10.5548 8.7785 11.4705 9.45363 12.1456C10.1288 12.8208 11.0444 13.2 11.9992 13.2V13.2ZM11.9992 14.4C13.2723 14.4 14.4932 13.8943 15.3933 12.9942C16.2935 12.094 16.7992 10.8731 16.7992 9.60005C16.7992 8.32701 16.2935 7.10611 15.3933 6.20594C14.4932 5.30576 13.2723 4.80005 11.9992 4.80005C10.7262 4.80005 9.50528 5.30576 8.60511 6.20594C7.70493 7.10611 7.19922 8.32701 7.19922 9.60005C7.19922 10.8731 7.70493 12.094 8.60511 12.9942C9.50528 13.8943 10.7262 14.4 11.9992 14.4V14.4Z" fill="#CBB0E7" />
                        </svg>

                    </button></div>
            </div>
            <div class="loadercentered">
                <div class="lds-facebook">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div class="showdialogbox">
                <!-- alertmessage -->
            </div>
            <div class="artist wholecontent is-verified d-none" id="mainContent">