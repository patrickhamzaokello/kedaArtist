<?php


$mwonyaamixarray = array();
$mixquery = mysqli_query($con, "SELECT * FROM ( SELECT * FROM songs WHERE genre = $songgenre ORDER BY RAND() LIMIT 10) AS mix ORDER BY plays DESC");


while ($row = mysqli_fetch_array($mixquery)) {

    array_push($mwonyaamixarray, $row['id']);

}


// SELECT * FROM ( SELECT * FROM songs ORDER BY plays DESC LIMIT 8 )  songs WHERE genre = (SELECT genre from songs where id='$mixid')ORDER BY RAND()

// SELECT * FROM ( SELECT * FROM songs ORDER BY plays DESC LIMIT 8 )  songs WHERE genre = (SELECT genre from songs where id='180') ORDER BY RAND()

// SELECT * FROM ( SELECT * FROM songs ORDER BY RAND() LIMIT 30 ) songs WHERE genre = (SELECT genre from songs where id='180') ORDER BY plays DESC 

// SELECT * FROM ( SELECT * FROM songs ORDER BY RAND() LIMIT 30 ) songs WHERE genre = 1 ORDER BY plays DESC  

?>

