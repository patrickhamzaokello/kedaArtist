<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    require "includes/config.php";
    require "includes/classes/User.php";
    require "includes/classes/Artist.php";
    require "includes/classes/Album.php";
    require "includes/classes/Genre.php";
    require "includes/classes/Song.php";
    require "includes/classes/Playlist.php";
    require "includes/classes/SharedPlaylist.php";
    require "includes/classes/Shared.php";
    require "includes/classes/LikedSong.php";

    $db = new Database();
    $con = $db->getConnString();


    if (isset($_SESSION['userLoggedIn'])) {
        $userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
        $userrole = $userLoggedIn->getUserrole();
        $userRegstatus = $userLoggedIn->getUserStatus();

        if ($userRegstatus === "registered") {
            echo "
                <script>
                isRegistered = '$userRegstatus';
                
                </script>";
        } else {
        }
    } else {
        echo "
        <div>

            <div class='suggestions' style='text-decoration:none' >
            Error Occurred. Please Refresh the Page. 
            
            <a href='index'>
            <p style='color:light-gray; text-decoration: none;'>Click to Refresh Page<p></a>
            </div>

        </div>    
        ";
        exit();
    }
} else {
    include("includes/header.php");
    include("includes/footer.php");

    $url = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$url')</script>";
    exit();
}
