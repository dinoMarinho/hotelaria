<?php
    header('Content-type: text/html; charset=utf-8');

    include_once('../../class/Quarto.php');
    include('../../config/dbConnection.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $tipo = (isset($_POST['tipo'])) ? $_POST['tipo'] : '' ;
        $valorDiaria = (isset($_POST['valorDiaria'])) ? $_POST['valorDiaria'] : '' ;
    }else {
        $tipo = (isset($_GET['tipo'])) ? $_GET['tipo'] : '' ;
        $valorDiaria = (isset($_GET['valorDiaria'])) ? $_GET['valorDiaria'] : '' ;
    }

    // Verifica se qual o método de envio dos dados
    $msg = '';
    $validate = false;

    // Verifica se o nome tem mais de 8 letras
    if (is_null($tipo) or !is_numeric($tipo)) {
        $msg .= 'Tipo inválido, ';
        $validate = true;
    }

    // Verifica se o e-mail é valido
    if (is_null($valorDiaria) or !is_numeric($valorDiaria)) {
        $msg .= 'E-mail vazio ou inválido, ';
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

    $result = $Quarto->include($tipo, $valorDiaria);

    $json = json_encode($result, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    print_r($json);
?>