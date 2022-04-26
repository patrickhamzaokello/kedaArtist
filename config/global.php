<?php
session_start();
$artistname = $_SESSION['name'] ?? '';
$artistid = $_SESSION["id"] ?? '';
$artistgenre = $_SESSION["genre"] ?? '';
$contenttag = $_SESSION["tag"] ?? '';