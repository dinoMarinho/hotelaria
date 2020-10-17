<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../class/Funcionario.php');
    include('../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
    }else{
        $id = (isset($_GET['id'])) ? $_GET['id'] : '' ;
    }

    // Verifica se qual o método de envio dos dados
    $msg = '';
    $validate = false;

    // Verifica se o e-mail é valido
    if (is_null($id) or !is_numeric($id)) {
        $msg .= 'A identificação do funcionário está vazio ou inválido,';
        $validate = true;
    }

    $msg .= 'por favor corrija os dados e tente novamente!';

    if ($validate) {
        $data = array('code' => 1,'message' => $msg);
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        print_r($json);
        die();
    }

    $Funcionario = new Funcionario($conn);

    $result = $Funcionario->delete($id);


    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>