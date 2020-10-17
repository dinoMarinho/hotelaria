<?php

$servername = "localhost";
$database = "hotelaria";
$username = "vinicius";
$password = "6731@Dinno2020";
// Create connection
@$conn = mysqli_connect($servername, $username, $password, $database); //Retira warnings
// Check connection
if (!$conn) {
    $data = array('code' => 1, 'message' => 'Connection failed: ' . mysqli_connect_error());
    $json = json_encode($data);
    print_r($json);
    die();
}


