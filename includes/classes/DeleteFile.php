<?php
$file = fopen("test.txt", "w");
echo fwrite($file, "Hello World. Testing!");
fclose($file);

unlink("test.txt");




class Artist
{

    private $con;
    private $id;
    private $medianame;


    public function __construct($con, $id, $medianame)
    {
        $this->con = $con;
        $this->id = $id;
        $this->medianame = $medianame;
    }

    public function deletemedia()
    {

        unlink($this->medianame);
        return $this->id;
    }
}