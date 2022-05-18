<?php

class Genre
{

    private $con;
    private $genreid;
    private $genre;
    private $tag;



    public function __construct($con, $genreid)
    {
        $this->con = $con;
        $this->genreid = $genreid;

        $checkgenre = mysqli_query($this->con, "SELECT name,tag FROM genres WHERE id='$this->genreid'");
        $genrefetched = mysqli_fetch_array($checkgenre);

        if (mysqli_num_rows($checkgenre) == 0) {
            $this->genre = null;
            $this->tag = null;
        } else {
            $this->genre = $genrefetched['name'];
            $this->tag = $genrefetched['tag'];
        }
    }
    
    public function getGenre()
    {
        return $this->genre;
    }

    public function getTag()
    {
        return $this->tag;
    }


  

 
}
