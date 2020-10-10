<?php
header('Content-type: text/html; charset=utf-8');

class Funcionario {

    private $name;
    private $email;
    private $password;
    private $commission;
    private $conn;

    public function __construct($conn){ $this->conn = $conn; }
    
    public function setName($name){ $this->name = $name; }

    public function setEmail($email){ $this->email = $email; }
    
    public function setPassword($password){ $this->password = $password; }  
    
    public function setComission($commission){ $this->comission = $commission; }

    public function getName(){ return $this->name; }

    public function getEmail(){ return $this->email; }

    public function getPassword(){ return $this->password; }
    
    public function getComission(){ return $this->commission; }

    public function getConn(){ return $this->conn; }

    public function encryptPassword($password){ 
        // Criptografia hash 
        $password_hash = trim(password_hash($password, PASSWORD_DEFAULT));
        return $password_hash; 
    }

}

?>