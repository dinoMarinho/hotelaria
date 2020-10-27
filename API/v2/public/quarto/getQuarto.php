<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../../class/Log.php');

    include_once('../../class/Quarto.php');
    include('../../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
    }else {
        $id = (isset($_GET['id'])) ? $_GET['id'] : '' ;
    }

    // Verifica se qual o método de envio dos dados
    $msg = '';
    $validate = false;

    // Verifica se o nome tem mais de 8 letras
    if (is_null($id) or !is_numeric($id)) {
        $msg .= 'ID do quarto inválido, ';
        $validate = true;
    }

    $msg .= 'por favor corrija os dados e tente novamente!';

    if ($validate) {
        $data = array('code' => 1,'message' => $msg);
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        print_r($json);
        die();
    }

    $Quarto = new Quarto($conn);

    $result = $Quarto->getQuarto($id);

    $Log = new Log($conn);

    if (isset($result['code']) && $result['code'] == 1 ){
        $msg = 'Pegou todas as informações do quarto com ID: '.$id;
    }else{
        $msg = 'Tentou pegar todas as informações do quarto com ID: '.$id;
    }   

    $log_result = $Log->insert($msg);

    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>