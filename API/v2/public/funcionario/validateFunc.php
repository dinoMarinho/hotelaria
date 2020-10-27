<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../../class/Log.php');

    include_once('../../class/Funcionario.php');
    include('../../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $mail = (isset($_POST['mail'])) ? $_POST['mail'] : '' ;
        $password = (isset($_POST['password'])) ? $_POST['password'] : '' ;
    }else{
        $mail = (isset($_GET['mail'])) ? $_GET['mail'] : '' ;
        $password = (isset($_GET['password'])) ? $_GET['password'] : '' ;
    }

    // Verifica se qual o método de envio dos dados
    $msg = '';
    $validate = false;

    // Verifica se o e-mail é valido
    if (is_null($mail) or filter_var($mail, FILTER_VALIDATE_EMAIL)==false) {
        $msg .= 'E-mail vazio ou inválido,';
        $validate = true;
    }

    // Tira os espaços iniciais da senha se existir
    $f_password = preg_replace("/\s+/", "", $password);

    // Verifica se a senha não está vazia, se tem mais de 10 caracteres, se tem pelo menos 1 um caractere especial e se tem pelo menos 1 letra maiúscula
    if (is_null($f_password)) {
        $msg .= 'Senha vazia, ';
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

    $result = $Funcionario->validate($mail, $password);

    $Log = new Log($conn);

    if (isset($result['code']) && $result['code'] == 1 ){
        $msg = 'Validou o usuário com E-mail: '. $mail;
    }else{
        $msg = 'Tentou validar o usuário com E-mail: '. $mail;
    }   

    $log_result = $Log->insert($msg);

    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>