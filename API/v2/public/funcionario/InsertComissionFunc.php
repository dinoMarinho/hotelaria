<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../../class/Log.php');

    include_once('../../class/Funcionario.php');
    include('../../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $id = (isset($_POST['id'])) ? $_POST['id'] : '' ;
        $value = (isset($_POST['value'])) ? $_POST['value'] : '' ;
    }else{
        $id = (isset($_GET['id'])) ? $_GET['id'] : '' ;
        $value = (isset($_GET['value'])) ? $_GET['value'] : '' ;
    }

    // Verifica se qual o método de envio dos dados
    $msg = '';
    $validate = false;

    // Verifica se o e-mail é valido
    if (is_null($id) or !is_numeric($id)) {
        $msg .= 'A identificação do funcionário está vazia ou inválido,';
        $validate = true;
    }
    
    if (is_null($value) or !is_numeric($value)) {
        $msg .= 'O valor da comissão do funcionário está vazia ou inválido,';
        $validate = true;
    }

    if (is_null($hotel_id) or !is_numeric($hotel_id)) {
        $msg .= 'A identificação do hotel está vazia ou é inválida,';
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

    $result = $Funcionario->includeComission($id,$value, $hotel_id);

    $Log = new Log($conn);

    if (isset($result['code']) && $result['code'] == 1 ){
        $msg = 'Incluiu a comissão ao usuário com ID: '. $id. 'no valor de: '.$value;
    }else{
        $msg = 'Tentou incluir uma comissão ao usuário com ID: '. $id. 'no valor de: '.$value;
    }   

    $log_result = $Log->insert($msg);

    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>