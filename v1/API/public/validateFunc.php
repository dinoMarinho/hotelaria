<?php
    header('Content-type: text/html; charset=utf-8');

    include_once("../dbConnection.php");
    include_once('../Class/Funcionario.php');


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
    }else{
        $username = $_GET['username'];
        $password = $_GET['password'];
    }


    $Funcionario = new Funcionario($conn);

    $result = $Funcionario->validate($username, $password);


    $json = json_encode($result);
    print_r($json);
?>