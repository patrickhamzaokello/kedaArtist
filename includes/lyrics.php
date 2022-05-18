<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.lyrics.ovh/v1/artist/title");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);

$data = var_dump($response);


echo "
<h1>$data</h1>

";