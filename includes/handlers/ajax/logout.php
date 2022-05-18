<?php

session_start();
session_destroy();
setcookie("userID", "", time() - (11 * 365 * 24 * 60 * 60));


?>

