<?php

class Following
{

    private $con;
    private $userid;
    private $otherid;



    public function __construct($con, $userid, $otherid)
    {
        $this->con = $con;
        $this->userid = $userid;
        $this->otherid = $otherid;

        $checkuser = mysqli_query($this->con, "SELECT * FROM users WHERE id='$this->userid'");
        if (mysqli_num_rows($checkuser) == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function getUserid()
    {
        return $this->userid;
    }

    public function getOtherid()
    {
        return $this->otherid;
    }


    public function checkuserArtistFollowing()
    {
        $followingquery = mysqli_query($this->con, "SELECT * FROM artistfollowing WHERE artistid='$this->otherid' AND userid='$this->userid'");
        if (mysqli_num_rows($followingquery) == 0) {
            return true;
        } else {
            return false;
        }
    }

 
}
