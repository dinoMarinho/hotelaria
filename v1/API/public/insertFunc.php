<?php
    header('Content-type: text/html; charset=utf-8');

    include_once("../dbConnection.php");
    include_once('../Class/Funcionario.php');


    // Verifica se qual o método de envio dos dados

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $name = $_POST['name'];
        $mail = $_POST['email'];
        $password = $_POST['password'];
    }else{
        $name = $_GET['name'];
        $mail = $_GET['email'];
        $password = $_GET['password'];
    }

    $msg = '';
    $validate = false;

    
    if($name == '' || strlen($name) < 8){
        $msg .= 'Nome invalido, ';
        $validate = true;
    }

    if($mail == '' || filter_var($mail, FILTER_VALIDATE_EMAIL)==false ){
        $msg .= 'Email invalido, ';
        $validate = true;
    }


    $f_password = preg_replace("/\s+/", "", $password);

    if($f_password == '' || strlen($f_password) < 10 || preg_match('/\p{Lu}/u', $f_password)==0 || preg_match('/[^a-zA-Z]+/', $f_password)==0){
        $msg .= 'Senha invalida, ';
        $validate = true;
    }

    $msg .= 'por favor corrija os dados e tente novamente!';

    if($validate){
        $data = array('code' => 1,'message' => $msg);
        $json = json_encode($data);
        print_r($json);
        die();
    }
 
    $Funcionario = new Funcionario($conn);

    $Funcionario->test();
    /*
    $return = $Funcionario->include($name, $mail, $f_password);

    $json = json_encode($return);
    print_r($return);
    */

?>

