<?php

class Shared
{

    private $con;
    private $id;
    private $followee;
    private $follower;
    private $usernameID;
    private $datefollowed;
    private $username;
    private $friendsarray = array();



    public function __construct($con, $usernameID, $username)
    {
        $this->con = $con;
        $this->usernameID = $usernameID;
        $this->username = $username;

        $query = mysqli_query($this->con, "SELECT * FROM friends where followee ='$this->usernameID'");

        if (mysqli_num_rows($query) == 0) {
            echo "

            <p class='noplaylistshared'>No Playlist Shared with You!, Follow Friends to get Playlists</p>
             
                        
                 
                ";
            exit;
        }

        while($friend = mysqli_fetch_array($query)){
            $this->id = $friend['id'];
            $this->followee = $friend['followee'];
            $this->follower = $friend['follower'];
            $this->datefollowed = $friend['datefollowed'];
            array_push($this->friendsarray, $this->follower);
        }

       
    }


    public function getOwner()
    {
        return $this->username;
    }

   
    public function getNumberOfSongs()
    {
        $query = mysqli_query($this->con, "SELECT DISTINCT songId  FROM likedsongs WHERE username='$this->username'");
        return mysqli_num_rows($query);
        
    }

    public function getSongIds()
    {
        $query = mysqli_query($this->con, "SELECT DISTINCT songId FROM likedsongs WHERE username='$this->username' ORDER BY songId ASC");

        $array = array();


        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['songId']);
        }

        return $array;
    }

    public function getPlaylist()
    {
        $array = array();

        foreach($this->friendsarray as $friendID){
             $query = mysqli_query($this->con, "SELECT  id FROM playlists WHERE ownerID='$friendID' AND status=2");

            if(mysqli_num_rows($query) == 0){
             
            } 
            else{
                while ($row = mysqli_fetch_array($query)) {
                    array_push($array, $row['id']);
                }

            }


        }     

       
        return $array;
    }
}