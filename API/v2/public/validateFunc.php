<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../class/Funcionario.php');
    include('../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $mail = (isset($_POST['mail'])) ? $_POST['mail'] : '' ;
        $password = (isset($_POST['password'])) ? $_POST['password'] : '' ;
    }else{
        $mail = (isset($_GET['mail'])) ? $_GET['mail'] : '' ;
        $password = (isset($_GET['password'])) ? $_GET['password'] : '' ;
    }

    $Funcionario = new Funcionario($conn);

    $result = $Funcionario->validate($mail, $password);


    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>