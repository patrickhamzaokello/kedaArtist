<?php
require "config.php";
require "classes/User.php";
require "classes/Artist.php";
require "classes/Following.php";
require "classes/Genre.php";

$db = new Database();
$con = $db->getConnString();


$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);



$username = $userLoggedIn->getUsername();
$userID = $userLoggedIn->getUserId();

$genreidcollection  = array();
$getartistgenres = mysqli_query($con, "SELECT DISTINCT genre from artists ORDER BY genre ASC");
while ($genrerow = mysqli_fetch_array($getartistgenres)) {
    array_push($genreidcollection, $genrerow['genre']);
}

foreach ($genreidcollection as $genreid) {

    $genre = new Genre($con, $genreid);



    if ($genre->getTag() == 'music') {




        echo "
    
    <div class='artistgenrehead'>

    <p class='genreartist'>" . $genre->getGenre() . " <span class='genratag'>" . $genre->getTag() . "</span></p>

</div>
        <div class='usercollection'>
       




    ";


        $artistidcollection = array();
        $usersquery = mysqli_query($con, "SELECT id FROM artists where genre=$genreid ");

        while ($row = mysqli_fetch_array($usersquery)) {
            array_push($artistidcollection, $row['id']);
        }



        foreach ($artistidcollection as $artistid) {
            $artist = new Artist($con, $artistid);
            $following = new Following($con, $userID, $artistid);
            echo "
    <div class='friend'>

    <div class='userdiv'>
  <img src='" . $artist->getProfilePath() . "' alt='' />
  <div class='useroverlay'></div>
  <div class='userbuttonclass'>
  ";


            if ($following->checkuserArtistFollowing()) {
                echo "
    <svg class='follow' onclick='followfriend(`$userID`,`$artistid`,`$artistid`,`$artistid`,0)' xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 50 50'><defs><style>.a{fill:#089844;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style></defs><g transform='translate(-9253 -4370)'><circle class='a' cx='25' cy='25' r='25' transform='translate(9253 4370)'/><g transform='translate(-4.635 -4.635)'><path class='b' d='M0,0V36.27' transform='translate(9283.135 4382.5)'/><line class='b' y2='36.27' transform='translate(9301.27 4399.292) rotate(90)'/></g></g></svg>

    ";
            } else {
                echo "
<svg class='unfollow' onclick='followfriend(`$userID`,`$artistid`,`$artistid`,`$artistid`,1)'  xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 50 50'><defs><style>.a{fill:#089844;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style></defs><g transform='translate(-9249 -4374)'><circle class='a' cx='25' cy='25' r='25' transform='translate(9249 4374)'/><g transform='translate(-2.362 16.434)'><path class='b' d='M22.836-1.084,8.268,23.312-.961,17.168' transform='translate(9271.091 4365.979) rotate(16)'/></g></g></svg>

    ";
            }



            echo "
            </div>
            
            
            </div>

            <p>
            " . $artist->getName() . "
            </p>

            </div>
                
                ";
        }

        echo "
</div>
";
    }
}
