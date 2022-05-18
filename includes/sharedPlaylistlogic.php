 <?php
require "config.php";
require "classes/User.php";
require "classes/Shared.php";
require "classes/SharedPlaylist.php";
// require "classes/Album.php";
// require "classes/Song.php";

$db = new Database();
$con = $db->getConnString();


$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);

$usernameID = $userLoggedIn->getUserId();
$username = $userLoggedIn->getUsername();

$shareedplay = new Shared($con, $usernameID,$username);



$playlistId = $shareedplay->getPlaylist();


foreach ($playlistId as $playlistgotID) {


$playlist = new SharedPlaylist($con, $playlistgotID);

echo $playlist->playlistCol();


}

?>