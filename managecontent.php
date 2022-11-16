<?php
include("config/global.php");
include("config/database.php");
include("classes/Album.php");


if(!isset($_SESSION["name"])){
    header("Location:login");
}
?>

<!doctype html>
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <?php
    echo "<script>userLoggedIn = '$artistname';</script>";

    ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Mwonyaa is Home to Ugandan Music, Live Radio, Podcasts,Dj Mixes and Poems. All available on the go and whenever you need them. This is also the best Place to Discover upcoming and new Talented Ugandan Content Creators">
    <meta name="keywords" content="Mwonyaa, Mwonyaa Music, Ugandan Streaming Platform, Mwonyaa Music Streaming Platform">

    <!-- favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="mask-icon" href="../assets/images/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="../favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="../browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- favicon end  -->

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- end of bootstrap -->
    <script src="https://unpkg.com/feather-icons"></script>


    <script src="mwonyacreate.js"></script>


    <link rel="stylesheet" href="mwonyacreate.css">
    <!-- <link rel="stylesheet" href="vanillaupload.css"> -->
    <title>Mwonyaa Manage content</title>


    <style>
        body {
            background: #180026;
            position: fixed;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-inverse bg-dark">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Mwonyaa Artist</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index">Home</a></li>


                    <?php
                    if ($contenttag == "music") {
                        echo " 
                        <li><a class='nav-link' href='createcollection'>New Media Collection</a></li> 
                        <li><a class='nav-link' href='uploadmedia'>Add Songs</a></li>
                        <li  class='active'><a class='nav-link' href='managecontent'>Manage Content</a></li>
                     
                        ";
                    } else if ($contenttag == "podcast") {
                        echo "
                       <li><a class='nav-link' href='createcollection'>Create Podcast Collection</a></li> 
                        <li><a class='nav-link' href='uploadmedia'>Add Podcast</a></li>
                        <li  class='active'><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
                    } else if ($contenttag == "dj") {
                        echo "
                        <li><a class='nav-link' href='createcollection'>Create Mixtape Collection</a></li> 
                        <li><a class='nav-link' href='uploadmedia'>Add Mixtape</a></li>
                        <li  class='active'><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
                    } else if ($contenttag == "poem") {

                        echo " 
                       <li><a class='nav-link' href='createcollection'>Create Poem Collection</a></li> 
                        <li><a class='nav-link' href='uploadmedia'>Add Poem</a></li>
                        <li  class='active'><a class='nav-link' href='managecontent'>Manage Content</a></li>
                        
                        ";
                    } else {
                        echo " ";
                    }

                    ?>


                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <?php
                    if (isset($_SESSION["name"])) {

                        echo "
                        <li><a role='link' onclick='openPage(\"profileedit?id=" . $artistid . "\")'><span class='glyphicon glyphicon-user' ></span> $artistname</a></li>

                        <li><a href='logout' tite='Logout'><span class='glyphicon glyphicon-log-out'></span> Logout</a>
                        </li> ";
                    } else {
                        echo "
                        <li><a href='contentcreator'><span class='glyphicon glyphicon-user'></span> Sign Up</a></li>
                        <li><a href='login' tite='Login'><span class='glyphicon glyphicon-log-in'></span> Login</a>

                        </li>

                        ";
                    }


                    ?>

                </ul>
            </div>
        </div>
    </nav>


    <div class="albumeditbody">

        <div class="albumedit">



            <div class="leftsidealbumes">
                <!-- code here -->
                <div class="menu_nav">
                    <ul class="menu_nav-list">
                        <p>Manage</p>
                        <li class="menu_nav-item" onclick="openPage('home')"><button class="menu_nav-button"><i data-feather="home"></i>Home</button></li>
                        <li class="menu_nav-item" onclick='openPage("profileedit?id=<?= $artistid ?>")'><button class="menu_nav-button"><i data-feather="lock"></i>Account</button></li>

                    </ul>
                    <ul class="menu_nav-list">
                        <p>Add New Media</p>
                        <li style="display:none;" class="menu_nav-item"><button class="menu_nav-button menu_nav-button--black"><i data-feather="file-plus"></i>Add<i data-feather="chevron-right"></i></button>
                            <ul class="menu_nav-sub-list">
                                <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button menu_nav-button--orange menu_nav-button--checked"><i data-feather="music"></i>Single<i data-feather="check"></i></button></li>
                                <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button menu_nav-button--green"><i data-feather="disc"></i>EP</button></li>
                                <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button menu_nav-button--green"><i data-feather="folder"></i>Album</button></li>
                                <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button menu_nav-button--green"><i data-feather="mic"></i>Podcast</button></li>
                                <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button menu_nav-button--green "><i data-feather="speaker"></i>Mix Tape</button></li>
                            </ul>
                        </li>
                        <li class="menu_nav-item" onclick="openPage('uploadmedia')"><button class="menu_nav-button"><i data-feather="music"></i>Single</button></li>
                        <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button"><i data-feather="disc"></i>EP</button></li>
                        <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button"><i data-feather="folder"></i>Album</button></li>
                        <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button"><i data-feather="mic"></i>Podcast</button></li>
                        <li class="menu_nav-item" onclick="openPage('createcollection')"><button class="menu_nav-button"><i data-feather="speaker"></i>Mix Tape</button></li>
                    </ul>
                    <ul class="menu_nav-list">
                        <a href="Logout">
                            <li class="menu_nav-item"><button class="menu_nav-button menu_nav-button--delete"><i data-feather="log-out"></i>Logout</button></li>
                        </a>
                    </ul>
                </div>

            </div>

            <div class="midddlesidedetails" id="albumSection">

                <?php

                $albumQuery = mysqli_query($con, "SELECT * FROM albums  WHERE  artist='$artistid' ORDER BY datecreated DESC");

                $albums_data = array();

                if (mysqli_num_rows($albumQuery) != 0) {
                    while ($row = mysqli_fetch_array($albumQuery)) {

                        array_push($albums_data, $row);
                    }
                }



                ?>

                <div class="mcontainer ">
                    <div class=" mycontainer">
                        <div class="activity">
                            <div class="icon">
                                <svg width="50" height="50" viewBox="0 0 78 78" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.75 66.3V11.7C9.75 11.1828 9.95545 10.6868 10.3211 10.3211C10.6868 9.95545 11.1828 9.75 11.7 9.75H66.3C66.8172 9.75 67.3132 9.95545 67.6789 10.3211C68.0446 10.6868 68.25 11.1828 68.25 11.7V66.3C68.25 66.8172 68.0446 67.3132 67.6789 67.6789C67.3132 68.0446 66.8172 68.25 66.3 68.25H11.7C11.1828 68.25 10.6868 68.0446 10.3211 67.6789C9.95545 67.3132 9.75 66.8172 9.75 66.3V66.3Z" stroke="#F8F8F8" stroke-width="4.875" />
                                    <path d="M39 50.375V24.7C39 24.1828 39.2054 23.6868 39.5711 23.3211C39.9368 22.9554 40.4328 22.75 40.95 22.75H48.75M39 50.375C39 51.6679 38.4864 52.9079 37.5721 53.8221C36.6579 54.7364 35.4179 55.25 34.125 55.25C32.8321 55.25 31.5921 54.7364 30.6779 53.8221C29.7636 52.9079 29.25 51.6679 29.25 50.375C29.25 49.0821 29.7636 47.8421 30.6779 46.9279C31.5921 46.0136 32.8321 45.5 34.125 45.5C35.4179 45.5 36.6579 46.0136 37.5721 46.9279C38.4864 47.8421 39 49.0821 39 50.375V50.375Z" stroke="#F8F8F8" stroke-width="4.875" stroke-linecap="round" />
                                </svg>

                            </div>
                            <h5>Single</h5>
                            <p>Add a new Music Single / Podcast Episode </p>

                        </div>

                        <div class="activity">
                            <div class="icon">
                                <svg width="50" height="50" viewBox="0 0 78 78" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M64.8537 13.1464C57.9969 6.28962 48.6971 2.4375 39.0001 2.4375C29.3031 2.4375 20.0032 6.28962 13.1464 13.1464C6.28962 20.0032 2.4375 29.3031 2.4375 39.0001C2.4375 48.6971 6.28962 57.9969 13.1464 64.8537C20.0032 71.7105 29.3031 75.5627 39.0001 75.5627C48.6971 75.5627 57.9969 71.7105 64.8537 64.8537C71.7105 57.9969 75.5627 48.6971 75.5627 39.0001C75.5627 29.3031 71.7105 20.0032 64.8537 13.1464V13.1464ZM39.0001 70.6876C21.5276 70.6876 7.31258 56.4725 7.31258 39.0001C7.31258 21.5276 21.5276 7.31258 39.0001 7.31258C56.4725 7.31258 70.6876 21.5276 70.6876 39.0001C70.6876 56.4725 56.4725 70.6876 39.0001 70.6876Z" fill="#F8F8F8" />
                                    <path d="M39 23.1562C35.8664 23.1562 32.8032 24.0855 30.1977 25.8264C27.5922 27.5673 25.5615 30.0418 24.3623 32.9369C23.1631 35.8319 22.8494 39.0176 23.4607 42.091C24.072 45.1643 25.581 47.9874 27.7968 50.2032C30.0126 52.419 32.8357 53.928 35.909 54.5393C38.9824 55.1507 42.1681 54.8369 45.0631 53.6377C47.9582 52.4385 50.4327 50.4078 52.1736 47.8023C53.9145 45.1968 54.8438 42.1336 54.8438 39C54.839 34.7994 53.1682 30.7723 50.198 27.802C47.2277 24.8318 43.2006 23.161 39 23.1562V23.1562ZM39 49.9688C36.8306 49.9688 34.7099 49.3254 32.9061 48.1202C31.1023 46.9149 29.6964 45.2018 28.8662 43.1976C28.036 41.1933 27.8188 38.9878 28.242 36.8601C28.6652 34.7324 29.7099 32.7779 31.2439 31.2439C32.7779 29.7099 34.7324 28.6652 36.8601 28.242C38.9878 27.8188 41.1933 28.036 43.1976 28.8662C45.2018 29.6964 46.9149 31.1023 48.1202 32.9061C49.3255 34.7099 49.9688 36.8306 49.9688 39C49.9655 41.9081 48.8088 44.6961 46.7525 46.7525C44.6961 48.8088 41.9081 49.9655 39 49.9688V49.9688Z" fill="#F8F8F8" />
                                    <path d="M36.5594 36.5626H41.4344V41.4376H36.5594V36.5626ZM38.9969 17.0626V12.1876C34.761 12.175 30.5836 13.1768 26.8143 15.1093C23.1751 16.9759 20.0065 19.6434 17.5469 22.9111L21.4447 25.839C23.4793 23.1044 26.1274 20.8856 29.176 19.3613C32.2246 17.8369 35.5885 17.0496 38.9969 17.0626V17.0626Z" fill="#F8F8F8" />
                                </svg>
                            </div>
                            <h5>EP (Extended play)</h5>

                            <p>Add a new Music EP</p>
                        </div>
                        <div class="activity">

                            <div class="icon">
                                <svg width="50" height="50" viewBox="0 0 78 78" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M63.8518 26.8125H14.1482C11.7191 26.8125 9.75 28.7816 9.75 31.2107V61.4143C9.75 63.8434 11.7191 65.8125 14.1482 65.8125H63.8518C66.2809 65.8125 68.25 63.8434 68.25 61.4143V31.2107C68.25 28.7816 66.2809 26.8125 63.8518 26.8125Z" stroke="#F8F8F8" stroke-width="4.875" stroke-linejoin="round" />
                                    <path d="M21.9375 12.1875H56.0625ZM17.0625 19.5H60.9375Z" fill="#F8F8F8" />
                                    <path d="M21.9375 12.1875H56.0625M17.0625 19.5H60.9375" stroke="#F8F8F8" stroke-width="4.875" stroke-miterlimit="10" stroke-linecap="round" />
                                </svg>

                            </div>
                            <h5>Album</h5>

                            <p>Add a new Music Album. </p>
                        </div>

                        <div class="activity">

                            <div class="icon">
                                <svg width="50" height="50" viewBox="0 0 78 78" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M45.7336 42.7163C47.2832 41.0416 48.1429 38.8433 48.1406 36.5616C48.1406 34.1374 47.1776 31.8124 45.4634 30.0982C43.7492 28.384 41.4242 27.421 39 27.421C36.5758 27.421 34.2508 28.384 32.5366 30.0982C30.8224 31.8124 29.8594 34.1374 29.8594 36.5616C29.8571 38.8433 30.7168 41.0416 32.2664 42.7163C31.3944 43.1465 30.6253 43.7596 30.0117 44.514C29.3798 45.2755 28.926 46.1686 28.6835 47.128C28.441 48.0875 28.4159 49.0889 28.6102 50.0593L31.5352 64.6843C31.8438 66.2034 32.6671 67.5695 33.866 68.552C35.065 69.5345 36.5663 70.0732 38.1164 70.0772H39.8836C41.4337 70.0732 42.935 69.5345 44.134 68.552C45.3329 67.5695 46.1562 66.2034 46.4648 64.6843L49.3898 50.0593C49.5841 49.0889 49.559 48.0875 49.3165 47.128C49.074 46.1686 48.6202 45.2755 47.9883 44.514C47.3747 43.7596 46.6056 43.1465 45.7336 42.7163V42.7163ZM39 31.0772C40.0847 31.0772 41.1451 31.3989 42.047 32.0015C42.9489 32.6042 43.6518 33.4607 44.0669 34.4628C44.482 35.465 44.5906 36.5677 44.379 37.6316C44.1674 38.6954 43.645 39.6727 42.878 40.4397C42.111 41.2067 41.1338 41.729 40.07 41.9406C39.0061 42.1522 37.9034 42.0436 36.9012 41.6285C35.8991 41.2134 35.0425 40.5105 34.4399 39.6086C33.8373 38.7067 33.5156 37.6463 33.5156 36.5616C33.5236 35.1095 34.104 33.7192 35.1308 32.6924C36.1576 31.6656 37.5479 31.0852 39 31.0772ZM45.7945 49.3585L42.8695 63.9835C42.7238 64.6691 42.3484 65.2844 41.8055 65.7276C41.2625 66.1709 40.5845 66.4155 39.8836 66.421H38.1164C37.4155 66.4155 36.7375 66.1709 36.1945 65.7276C35.6516 65.2844 35.2762 64.6691 35.1305 63.9835L32.2055 49.3585C32.1161 48.916 32.1271 48.459 32.2379 48.0213C32.3486 47.5836 32.5562 47.1764 32.8453 46.8296C33.1244 46.4751 33.4809 46.1891 33.8876 45.9937C34.2942 45.7983 34.7402 45.6986 35.1914 45.7022H42.8086C43.2598 45.6986 43.7058 45.7983 44.1124 45.9937C44.5191 46.1891 44.8756 46.4751 45.1547 46.8296C45.4438 47.1764 45.6514 47.5836 45.7621 48.0213C45.8729 48.459 45.8839 48.916 45.7945 49.3585V49.3585ZM56.6719 38.9991C56.6678 36.4051 56.0927 33.8437 54.9874 31.4969C53.8821 29.1502 52.2736 27.0755 50.2763 25.4203C48.279 23.765 45.9418 22.5698 43.4306 21.9194C40.9194 21.269 38.2958 21.1795 35.7461 21.6572C33.1964 22.1348 30.7831 23.1679 28.6776 24.6831C26.5721 26.1983 24.826 28.1585 23.5632 30.4245C22.3005 32.6905 21.5521 35.2066 21.3712 37.7944C21.1903 40.3821 21.5813 42.9779 22.5164 45.3976C22.6051 45.6216 22.6487 45.8609 22.6446 46.1018C22.6405 46.3427 22.5888 46.5804 22.4926 46.8012C22.3963 47.0221 22.2573 47.2217 22.0836 47.3887C21.9099 47.5557 21.705 47.6866 21.4805 47.7741C21.2634 47.8441 21.038 47.8851 20.8102 47.896C20.4387 47.8947 20.0765 47.7803 19.7716 47.5681C19.4668 47.3558 19.2339 47.0557 19.1039 46.7077C17.8561 43.4765 17.414 39.9899 17.816 36.5495C18.2179 33.109 19.4517 29.8183 21.4108 26.9616C23.3698 24.105 25.9952 21.7686 29.0598 20.1542C32.1245 18.5398 35.5362 17.6962 39 17.6962C42.4638 17.6962 45.8755 18.5398 48.9402 20.1542C52.0048 21.7686 54.6302 24.105 56.5892 26.9616C58.5483 29.8183 59.7821 33.109 60.184 36.5495C60.586 39.9899 60.1439 43.4765 58.8961 46.7077C58.7188 47.1615 58.3704 47.5275 57.9259 47.7269C57.4814 47.9264 56.9764 47.9433 56.5195 47.7741C56.0713 47.591 55.7123 47.2401 55.5188 46.7963C55.3253 46.3524 55.3127 45.8506 55.4836 45.3976C56.2731 43.3569 56.676 41.1872 56.6719 38.9991ZM70.0781 38.9991C70.0884 44.2223 68.7781 49.3633 66.2692 53.9444C63.7602 58.5255 60.1339 62.3981 55.7273 65.2022C55.4334 65.3807 55.0962 65.4755 54.7523 65.4765C54.4446 65.4839 54.14 65.4121 53.868 65.2681C53.5959 65.124 53.3653 64.9125 53.1984 64.6538C53.0682 64.4518 52.979 64.2261 52.9361 63.9896C52.8932 63.7531 52.8973 63.5105 52.9482 63.2756C52.9992 63.0407 53.0959 62.8182 53.233 62.6207C53.37 62.4233 53.5446 62.2548 53.7469 62.1249C58.7487 58.9344 62.5809 54.2077 64.6684 48.6543C66.7559 43.1009 66.986 37.0203 65.3242 31.325C63.6624 25.6297 60.1984 20.6269 55.452 17.0675C50.7056 13.5081 44.9328 11.584 39 11.584C33.0672 11.584 27.2944 13.5081 22.548 17.0675C17.8016 20.6269 14.3376 25.6297 12.6758 31.325C11.014 37.0203 11.2441 43.1009 13.3316 48.6543C15.4191 54.2077 19.2513 58.9344 24.2531 62.1249C24.6612 62.3875 24.9482 62.8015 25.0511 63.2758C25.154 63.75 25.0642 64.2457 24.8016 64.6538C24.5389 65.0619 24.125 65.3489 23.6507 65.4518C23.1764 65.5546 22.6807 65.4649 22.2727 65.2022C17.725 62.2979 14.0118 58.2596 11.4986 53.4847C8.98538 48.7097 7.75871 43.3627 7.93929 37.9697C8.11986 32.5768 9.70147 27.3238 12.5285 22.7276C15.3555 18.1315 19.3304 14.3506 24.0622 11.757C28.794 9.16343 34.1195 7.84653 39.5148 7.93591C44.91 8.02528 50.189 9.51786 54.8323 12.2667C59.4756 15.0156 63.3231 18.9261 65.9963 23.6134C68.6695 28.3006 70.0763 33.6032 70.0781 38.9991V38.9991Z" fill="#F8F8F8" />
                                </svg>


                            </div>
                            <h5>Podcast</h5>

                            <p>Create a new Podcast</p>
                        </div>

                    </div>




                </div>


                <?php if ($albums_data) : ?>

                    <div class="recently_added" style="margin: 1em;">
                        <p class="subtitle">Recently Added</p>
                        <a href="#" class="featured-title">Media Management</a>
                    </div>








                    <div class="artist_cols">
                        <div class="cols_listing">
                            <?php
                            foreach ($albums_data as $row) :

                            ?>

                                <?php
                                $album = new Album($con, $row['id']);
                                ?>


                                <div class="cols_item" role='link' tabindex='0' onclick="openPage('selectedalbum.php?id=<?= $row['id'] ?>')">
                                    <img loading="lazy" class="image" src="<?= $album->getArtworkPath() ?>">
                                    <div class="albumlistinfo">
                                        <h2><?= $album->getTitle() ?></h2>
                                        <p><?= $album->getDatecreated() ?></p>
                                    </div>
                                </div>


                            <?php endforeach ?>





                        </div>
                    </div>



                <?php else :  ?>
                    Working on Getting Featured Music Artists Curated for You
                <?php endif ?>









            </div>

            <div class="rightsidealbum">
                <p class="contentlabel">Over-all Statistics</p>

                <div class="rightsidealbumstats">


                    <?php

                    $totalplaysquery = mysqli_query($con, "SELECT SUM(`plays`) AS totalplays FROM songs where `artist` = '$artistid'");
                    $row = mysqli_fetch_array($totalplaysquery);




                    $totalalbumquery = mysqli_query($con, "SELECT COUNT(`title`) AS noalbums FROM albums where `artist` = '$artistid'");
                    $noalbums = mysqli_fetch_array($totalalbumquery);

                    $totalsongsquery = mysqli_query($con, "SELECT COUNT(`title`) AS nosongs FROM songs where `artist` = '$artistid'");
                    $nosongs = mysqli_fetch_array($totalsongsquery);







                    echo "
                
                
                <div class='totalplays'>
                <div class='stats'>
                <h1>Total Plays </h1>
                <p>" . $row['totalplays'] . "</p>
                </div> 
                </div>
                
                
                <div class='totalplays'>
                <div class='stats'>

                <h1>Artist Albums </h1>
                <p>" . $noalbums['noalbums'] . "</p>
                </div>
                </div>



                 <div class='totalplays'>
                <div class='stats'>

                <h1>Artist Songs </h1>
                <p>" . $nosongs['nosongs'] . "</p>
                </div>
                </div>

                
                
                ";


                    ?>
                </div>
            </div>

        </div>

    </div>




    <script>
        feather.replace()
    </script>

</body>

</html>