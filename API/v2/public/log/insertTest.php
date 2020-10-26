<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../../class/Log.php');
    include('../../config/dbConnection.php');

    $Log = new Log($conn);

    $result =  $Log->insert();

    echo $result;

   