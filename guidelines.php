<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

    include("config/database.php");
    include("includes/classes/User.php");
    include("includes/classes/Artist.php");
    include("includes/classes/Album.php");
    include("includes/classes/Song.php");
    include("includes/classes/Playlist.php");
    include("includes/classes/LikedSong.php");

   
    if (isset($_GET['userLoggedIn'])) {
        $userLoggedIn = new User($con, $_GET['userLoggedIn']);
    } else {
        echo "username variable was not passed into the page check the openPage js function";
        exit();
    }
} else {
    include("managecontent.php");


    $url = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$url')</script>";
    exit();
}


?>
<!-- headerends -->

<div class="pagesection">

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

<!-- options menu -->
