<?php

require "includes/config.php";
require "includes/classes/User.php";
require "includes/classes/Artist.php";
require "includes/classes/Album.php";
require "includes/classes/Song.php";

$db = new Database();
$con = $db->getConnString();

?>