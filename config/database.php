<?php

$local = true;

if ($local) {
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $databasename = "mwonya";
} else {
    $hostname = "178.79.148.46";
    $username = "streamerMwonyaa";
    $password = "upJH4122kzPTY2";
    $databasename = "mwonya";
}



$con = mysqli_connect($hostname, $username, $password, $databasename);

// Check connection
if (mysqli_connect_errno($con)) {
    echo "MySQL database connection failed: " . mysqli_connect_error();
}


try {
    $conn = new PDO("mysql:host=$hostname;dbname=$databasename", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Database connected successfully";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}