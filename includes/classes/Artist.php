<?php

class Artist
{

    private $con;
    private $id;
    private $name;
    private $email;
    private $profilephoto;
    private $coverimage;
    private $bio;
    private $genre;
    private $tag;
    private $dateAdded;
    private $totalsongs;
    private $totalalbum;


    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT * FROM artists WHERE id='$this->id'");
        $artistfetched = mysqli_fetch_array($query);


        if (mysqli_num_rows($query) < 1) {

            $this->name = null;
            $this->email = null;
            $this->profilephoto = null;
            $this->coverimage = null;
            $this->bio = null;
            $this->genre = null;
            $this->tag = null;
            $this->dateAdded = null;
            $this->totalsongs = null;
            $this->totalalbum = null;
        } else {

            $this->name = $artistfetched['name'];
            $this->email = $artistfetched['email'];
            $this->profilephoto = $artistfetched['profilephoto'];
            $this->coverimage = $artistfetched['coverimage'];
            $this->bio = $artistfetched['bio'];
            $this->genre = $artistfetched['genre'];
            $this->tag = $artistfetched['tag'];
            $this->dateAdded = $artistfetched['datecreated'];
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getdateadded()
    {
        $phpdate = strtotime($this->dateAdded);
        $mysqldate = date('d M Y', $phpdate);
        // $mysqldate = date( 'd/M/Y H:i:s', $phpdate );

        return $mysqldate;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }


    public function getProfilePath()
    {
        return $this->profilephoto;
    }

    public function getArtistCoverPath()
    {
        return $this->coverimage;
    }

    public function getArtistBio()
    {
        return $this->bio;
    }


    public function getGenre()
    {
        return $this->genre;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function getGenrename()
    {
        $query = mysqli_query($this->con, "SELECT name FROM genres WHERE id='$this->genre'");
        $row = mysqli_fetch_array($query);
        return $row['name'];
    }

    public function getTotalSongs()
    {
        $query = mysqli_query($this->con, "SELECT COUNT(*) as totalsongs FROM songs WHERE artist ='$this->id'");
        $row = mysqli_fetch_array($query);
        return $row['totalsongs'];
    }
    public function getTotalablums()
    {
        $query = mysqli_query($this->con, "SELECT COUNT(*) as totalalbum FROM albums WHERE artist ='$this->id'");
        $row = mysqli_fetch_array($query);
        return $row['totalalbum'];
    }

    public function getSongIds()
    {
        $query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id' and tag != 'ad' ORDER BY plays DESC");
        $array = array();

        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['id']);
        }

        return $array;
    }
}
