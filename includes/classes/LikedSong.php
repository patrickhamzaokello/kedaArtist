<?php

class LikedSong
{

    private $con;
    private $id;
    private $songId;
    private $userID;
    private $songorder;



    public function __construct($con, $userID)
    {
        $this->con = $con;
        $this->userID = $userID;

        $query = mysqli_query($this->con, "SELECT * FROM likedsongs WHERE userID='$this->userID' ORDER BY songorder ASC");

        if (mysqli_num_rows($query) == 0) {
           
            $this->id = null;
            $this->songId = null;
            $this->userID = null;
            $this->songorder = null;

        }

        $likedsong = mysqli_fetch_array($query);

        $this->id = $likedsong['id'];
        $this->songId = $likedsong['songId'];
        $this->userID = $likedsong['userID'];
        $this->songorder = $likedsong['songorder'];
    }


    public function getOwner()
    {
        return $this->userID;
    }

    public function getSongorder()
    {

        return $this->songorder;
    }



    public function getNumberOfSongs()
    {
        $query = mysqli_query($this->con, "SELECT DISTINCT songId  FROM likedsongs WHERE userID='$this->userID'");
        return mysqli_num_rows($query);
    }

    public function getSongIds()
    {
        $query = mysqli_query($this->con, "SELECT DISTINCT songId FROM likedsongs WHERE userID='$this->userID' ORDER BY songorder DESC");

        $array = array();

        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['songId']);
        }

        return $array;
    }

    public function getArtistIds()
    {
        $query = mysqli_query($this->con, "SELECT DISTINCT artistId FROM likedsongs WHERE userID='$this->userID' ORDER BY artistId DESC");
        $array = array();

        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['artistId']);
        }

        return $array;
    }

    public function getArtistYouFollow()
    {
        $query = mysqli_query($this->con, "SELECT artistid FROM artistfollowing WHERE userid='$this->userID' ORDER BY datefollowed DESC");
        $array = array();

        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['artistid']);
        }

        return $array;
    }

    public function getRecentAlbumId()
    {

        $query = mysqli_query($this->con, "SELECT artistid FROM artistfollowing WHERE userid='$this->userID' ORDER BY datefollowed DESC");
        $albumQuery = mysqli_query($this->con, "SELECT id FROM albums WHERE tag = \"music\" ORDER BY datecreated DESC Limit 20 ");

        $artistIdarray = array();
        $albumQueryarray = array();

        while ($row = mysqli_fetch_array($query)) {
            array_push($artistIdarray, $row['artistid']);
        }

        while ($row = mysqli_fetch_array($albumQuery)) {
            array_push($albumQueryarray, $row['id']);
        }

        $albumidarray = array();

        foreach ($albumQueryarray as $id) {

            foreach ($artistIdarray as $artist) {


                $query = mysqli_query($this->con, "SELECT id FROM albums WHERE artist='$artist' AND id='$id' ORDER BY datecreated Limit 1");

                while ($row = mysqli_fetch_array($query)) {
                    echo $row['id'];

                    array_push($albumidarray, $row['id']);
                }
            }
        }

        return $albumidarray;
    }
}
