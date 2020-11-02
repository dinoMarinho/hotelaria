<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../../class/Log.php');

    include_once('../../class/Funcionario.php');
    include('../../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $name = (isset($_POST['name'])) ? $_POST['name'] : '' ;
        $mail = (isset($_POST['mail'])) ? $_POST['mail'] : '' ;
        $password = (isset($_POST['password'])) ? $_POST['password'] : '' ;
        $hotel_id = (isset($_POST['hotel_id'])) ? $_POST['hotel_id'] : '' ;
    }else{
        $name = (isset($_GET['name'])) ? $_GET['name'] : '' ;
        $mail = (isset($_GET['mail'])) ? $_GET['mail'] : '' ;
        $password = (isset($_GET['password'])) ? $_GET['password'] : '' ;
        $hotel_id = (isset($_GET['hotel_id'])) ? $_GET['hotel_id'] : '' ;
    }

    // Verifica se qual o método de envio dos dados
    $msg = '';
    $validate = false;

    // Verifica se o nome tem mais de 8 letras
    if (is_null($name) or strlen($name) < 8) {
        $msg .= 'Nome inválido, ';
        $validate = true;
    }

    // Verifica se o e-mail é valido
    if (is_null($mail) or filter_var($mail, FILTER_VALIDATE_EMAIL)==false ) {
        $msg .= 'E-mail vazio ou inválido, ';
        $validate = true;
    }

    // Tira os espaços iniciais da senha se existir
    $f_password = preg_replace("/\s+/", "", $password);

    // Verifica se a senha não está vazia, se tem mais de 10 caracteres, se tem pelo menos 1 um caractere especial e se tem pelo menos 1 letra maiúscula
    if (is_null($f_password) or strlen($f_password) < 10 or preg_match('/\p{Lu}/u', $f_password)==0 or preg_match('/[^a-zA-Z]+/', $f_password)==0) {
        $msg .= 'Senha inválida, ';
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

    $result = $Funcionario->include($name, $mail, $f_password,$hotel_id);

    $Log = new Log($conn);

    if (isset($result['code']) && $result['code'] == 1 ){
        $msg = 'Incluiu o usuário com Nome: '. $name. ' e E-mail: '. $mail;
    }else{
        $msg = 'Tentou incluir um usuário com Nome: '. $name. ' e E-mail: '. $mail;
    }   

    $log_result = $Log->insert($msg);

    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>