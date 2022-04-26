<?php
include("config/global.php");
include("config/database.php");



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


    <script src="mwonyacreate.js"></script>


    <link rel="stylesheet" href="mwonyacreate.css">

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
                <p class="contentlabel">Albums Collection</p>



                <!-- <span class="flow" role="link" tabindex="0"
                    onclick="openPage('artistprofileedit.php?id=<?php echo $artistid ?>')">
                    pato
                </span> -->

                <div class="albumlisting">

                    <?php

                    $albumQuery = mysqli_query($con, "SELECT * FROM albums  WHERE  artist='$artistid' ORDER BY title ASC");

                    if (mysqli_num_rows($albumQuery) != 0) {
                        while ($row = mysqli_fetch_array($albumQuery)) {


                            echo " <div class='albumlist'>




                            <div class='album' role='link' tabindex='0' onclick='openPage(\"selectedalbum.php?id=" . $row['id'] . "\")'>
                            <img  class='image' src='" . $row['artworkPath'] . "'>

                            </div>  
                            <p>" . $row['title'] . "</p>

                            </div>";
                        }
                    } else {
                        echo " <div class='albumlist'>



<div class='adminroles'>
                                       <li><a role='link' onclick='openPage(\"profileedit?id=" . $artistid . "\")'>Account Settings</a></li>


                <li><a href='createcollection' tite='create ablumm'>New Collection</a>


                <li><a href='uploadmedia' tite='create ablumm'>Add Media</a>
                </div>

                            </div>";
                    }



                    ?>


                </div>

            </div>

            <div class="midddlesidedetails" id="albumSection">

                <div class="featured">
                    <div class="left">
                        <div class="inner transition2">

                            <p class="subtitle">Quick Actions Shortcuts</p>
                            <a href="#" class="featured-title">This is Meant to help you navigate your page faster and
                                efficiently</a>



                        </div>
                    </div>
                </div>

                <div class="firstheading">

                    <div class="circledeco"></div>
                    <div class="featured">
                        <div class="left">
                            <div class="inner transition2">
                                <p class="subtitle">New Features</p>
                                <a href="#" class="featured-title">Media Management</a>
                                <p class="featured-desc">
                                    We are working on new Features everyday to ensure easy and fast content Management
                                    by
                                    Artists. Our Lastest Feature is allowing Artist to signup and Manage their content
                                    easily. we are committed to adding more Features to ensure fast and automated
                                    deployment
                                    of content.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="guidlines">


                    <div class="featured">
                        <div class="left">
                            <div class="inner transition2">
                                <h3>Guidlines on How to Use this Page</h3>
                                <br>
                                <p class="subtitle">GuideLines #1</p>
                                <a href="#" class="featured-title">How to upload Songs to your Account</a>
                                <p class="featured-desc">
                                    Mwonyaa stream is built on the model of songs or media being in a container or in
                                    an
                                    album, A song upload should be attached to a container or album for it to be
                                    available on the platform. Here are the steps to upload songs to your account.<br>
                                <ol>

                                    <li>Create a container or album and give it a cover art by clicking this link <a class="linkaction" href="createcollection">here.</a></li><br>
                                    <li>If you have an existing album or container, follow this link <a class="linkaction" href="mwonyasongs">here.</a> and select the existing
                                        album from the drop
                                        down option</li><br>
                                    <li>Add Songs to your Album <a class="linkaction" href="mwonyasongs">here.</a></li>

                                </ol>

                                </p>
                            </div>

                            <div class="inner transition2">
                                <p class="subtitle">GuideLines #2</p>
                                <a href="#" class="featured-title">How to Edit Artist Info</a>
                                <p class="featured-desc">
                                    This is where you can edit description, name / username, email and other details
                                    about
                                    an Artist. follow this <span class="linkaction" onclick='openPage("artistprofileedit?id=<?= $artistid ?>")'>
                                        Link</span> to update your profile
                                </p>
                            </div>

                            <div class="inner transition2">
                                <p class="subtitle">GuideLines #3</p>
                                <a href="#" class="featured-title">Any Question?</a>
                                <p class="featured-desc">
                                    For any questions and requests, feel free to email us at our email,
                                    info@mwonyaa.com. we shall be glad to talk to you and help make your experience of
                                    Mwonyaa Stream better
                                </p>
                            </div>
                        </div>

                    </div>
                </div>









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





</body>

</html>