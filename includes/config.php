<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ob_start();

session_start();

// $timezone = date_default_timezone_set("Europe/London");

// $con = mysqli_connect("localhost", "mwonyaAdmin", "UpjYTaZ8Lg#g", "mwonya");

// $con = mysqli_connect("localhost", "root", "", "mwonya", 3306);


class Database
{


    var $hostname;
    var $username;
    var $password;
    var $databasename;
    var $port_name;
    var $con;

    /***
     * true -- in local developement
     * false -- in production development
     */
    var $local = true;

    function getConnString()
    {

        if ($this->local) {
            $this->hostname = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->databasename = "mwonya";
            $this->port_name = "3306";
            $this->con;
        } else {
            $this->hostname = "178.79.148.46";
            $this->username = "streamerMwonyaa";
            $this->password = "upJH4122kzPTY2";
            $this->databasename = "mwonya";
            $this->port_name = "3306";
            $this->con;
        }

        try {
            $this->con = new mysqli($this->hostname, $this->username, $this->password, $this->databasename, $this->port_name);
        } catch (\Throwable $th) {
            $this->con = null;
        }
        return $this->con;
    }
}