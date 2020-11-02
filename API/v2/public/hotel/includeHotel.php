<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../../class/Log.php');

    include_once('../../class/Hotel.php');
    include('../../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $name = (isset($_POST['name'])) ? $_POST['name'] : '' ;
    }else{
        $name = (isset($_GET['name'])) ? $_GET['name'] : '' ;
    }

    $msg = '';
    $validate = false;

    // Verifica se o nome tem mais de 8 letras
    if (is_null($name) or strlen($name) < 8) {
        $msg .= 'Nome inválido com menos de 8 caracteres ou vazio, ';
        $validate = true;
    }

    $msg .= 'por favor corrija os dados e tente novamente!';

    if ($validate) {
        $data = array('code' => 1,'message' => $msg);
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        print_r($json);
        die();
    }

    $Hotel = new Hotel($conn);

    $result = $Hotel->include($name);

    $Log = new Log($conn);

    if (isset($result['code']) && $result['code'] == 1 ){
        $msg = 'Incluiu o hotel com Nome: '. $name;
    }else{
        $msg = 'Tentou incluir um hotel com Nome: '. $name;
    }   

    $log_result = $Log->insert($msg);

    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>