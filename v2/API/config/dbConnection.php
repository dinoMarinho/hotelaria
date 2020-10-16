<?php
    $dsn = "mysql:host=localhost;dbname=hotelaria;charset=utf8";
    $username = "root";
    $password = "6731@Dinno2020";

    try {
        $conn = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $data = array('code' => 0, 'message' => 'Conexão deu certo! ');
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    }catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
        $data = array('code' => 1, 'message' => 'Conexão Falhou ' . $e->getMessage());
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    print_r($json);
?>
