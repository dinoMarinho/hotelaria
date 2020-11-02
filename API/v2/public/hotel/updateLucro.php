<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../../class/Log.php');

    include_once('../../class/Hotel.php');
    include('../../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
        $value = (isset($_POST['value'])) ? $_POST['value'] : '' ;
    }else{
        $id = (isset($_GET['id'])) ? $_GET['id'] : '' ;
        $value = (isset($_GET['value'])) ? $_GET['value'] : '' ;
    }

    $msg = '';
    $validate = false;

    if (is_null($id) or !is_numeric($id)) {
        $msg .= 'A identificação do hotel está vazia ou é inválida,';
        $validate = true;
    }
    
    if (is_null($value) or !is_numeric($value)) {
        $msg .= 'O valor da receita do hotél está vazia ou é inválida,';
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

    $result = $Hotel->updateLucro($id,$value);

    $Log = new Log($conn);

    if (isset($result['code']) && $result['code'] == 1 ){
        $msg = 'Atualizou o lucro do hotel com ID: '. $id;
    }else{
        $msg = 'Tentou atualizar o lucro do hotel com ID:'. $id;
    }   

    $log_result = $Log->insert($msg);

    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>