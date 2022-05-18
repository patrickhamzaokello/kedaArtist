<?php
require "config.php";
require "classes/User.php";
// require "classes/Artist.php";
// require "classes/Album.php";
// require "classes/Song.php";

$db = new Database();
$con = $db->getConnString();


$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);



$username = $userLoggedIn->getUsername();
$userID = $userLoggedIn->getUserId();

$usersquery = mysqli_query($con, "SELECT * FROM users where username != '$username' ");

if (mysqli_num_rows($usersquery) == 0) {
    echo "<span class='noResults'>no users</span>";
}

while ($row = mysqli_fetch_array($usersquery)) {


    $otheruserid = $row['id'];
    $otheruserName = $row['username'];



    echo "
    <div class='friend'>

    <div class='userdiv'>
  <img src='" . $row['profilePic'] . "' alt='' />
  <div class='useroverlay'></div>
  <div class='userbuttonclass'>
  ";


    $followingquery = mysqli_query($con, "SELECT * FROM friends WHERE followee='$userID' AND follower='$otheruserid'");
    if (mysqli_num_rows($followingquery) == 0) {
        echo "
    <svg class='follow' onclick='followfriend(`$userID`,`$username`,`$otheruserid`,`$otheruserName`,0)' xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 50 50'><defs><style>.a{fill:#089844;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style></defs><g transform='translate(-9253 -4370)'><circle class='a' cx='25' cy='25' r='25' transform='translate(9253 4370)'/><g transform='translate(-4.635 -4.635)'><path class='b' d='M0,0V36.27' transform='translate(9283.135 4382.5)'/><line class='b' y2='36.27' transform='translate(9301.27 4399.292) rotate(90)'/></g></g></svg>

    ";
    } else {
        echo "
<svg class='unfollow' onclick='followfriend(`$userID`,`$username`,`$otheruserid`,`$otheruserName`,1)'  xmlns='http://www.w3.org/2000/svg' width='50' height='50' viewBox='0 0 50 50'><defs><style>.a{fill:#089844;}.b{fill:none;stroke:#fff;stroke-width:3px;}</style></defs><g transform='translate(-9249 -4374)'><circle class='a' cx='25' cy='25' r='25' transform='translate(9249 4374)'/><g transform='translate(-2.362 16.434)'><path class='b' d='M22.836-1.084,8.268,23.312-.961,17.168' transform='translate(9271.091 4365.979) rotate(16)'/></g></g></svg>

    ";
    }



    echo "
  </div>
  
  
</div>

<p>
" . $row['username'] . "
</p>

</div>
    
    ";
}

?>