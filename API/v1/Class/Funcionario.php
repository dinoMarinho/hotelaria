<?php
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Funcionario {

    private $name;
    private $email;
    private $password;
    private $commission;
    private $conn;

    
    public function __construct($conn){
        $this->conn = $conn;   
    }
    
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

    public function test(){
        $conn = $this->getConn();
        
        $stmt = $conn->query("SELECT * FROM funcionarios");
        if($stmt->num_rows > 0){
            echo 'entrou';
            while($row = $stmt->fetch_assoc()){
                echo $row['nome'];
            }
        }else{
            echo 'nao entrou';
        }
        $stmt->close();
        $conn->close();
    }
    
    public function include($name, $email, $password){
        $conn = $this->getConn();
        
        $password = $this->encryptPassword($password);

        try{
            $stmt_check = $conn->prepare("SELECT * FROM funcionarios WHERE email=?");
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();

            if($stmt_check->num_rows > 0){
                $result = array('code' => 0, 'message'=> 'E-mail ja cadastrado!'); 
            }else{
                try{
                    $stmt = $conn->prepare("INSERT INTO funcionarios(nome, email,senha) VALUES (?,?,?)");
                    $stmt->bind_param("sss", $name, $email, $password);
                    $stmt->execute();            

                    $result = array('code' => 1,'message' => 'Funcionario cadastrado com sucesso!!');

                }catch(Exception $e){
                    $result = array('code' => 0, 'message'=> 'Houve um erro na inclusão!Erro: '.$e->getMessage());
                }
            }
        }catch(Exception $e){
            $result = array('code' => 0, 'message'=> 'Houve um erro na inclusão!Erro: '.$e->getMessage());
        }
        $stmt->close();
        $conn->close();

        return $result;
    }

    public function validate($username, $password){
        $conn = $this->getConn();
        
        try{
            $stmt = $conn->prepare("SELECT * FROM funcionarios WHERE email=?");
            $stmt->bind_param("s", $username);

            $stmt->execute();

            return $stmt;
    
            if($stmt->num_rows > 0){
                while($row = $stmt->fetch_assoc()){
                    if(password_verify($password, $row['senha'])){
                        $data = array(
                            'code'  => 1,
                            'id'    => $row['id'],
                            'name'  => $row['nome'],
                            'email' => $row['email']
                        );
                    }else{ 
                        $data = array('code' => 0, 'message'=> 'Senha invalida');    
                    }
                }
            }else{
                $data = array('code' => 0, 'message'=> 'Usuario sem cadastro encontrado');
            }
        }catch(Exception $e){
            $result = array('code' => 0, 'message'=> 'Houve um erro na consulta!Erro: '.$e->getMessage());
        }
        $stmt->close();
        $conn->close();

        return $data;
    }

    public function includeComission($id,$val){
        $conn = $this->getConn();

        try{
            $stmt = $conn->prepare("UPDATE funcionarios SET comissao=? WHERE id=?");
            $stmt->bind_param("di", $val, $id);
            if($stmt->execute()){
                $result = array('code' => 1, 'message'=> 'Comissão adicionada com sucesso!');
            }else{
                $result = array('code' => 0, 'message'=> 'Funcionario não encontrado');
            }                     
        }catch(Exception $e){
            $result = array('code' => 0, 'message'=> 'Houve um erro na inclusão!Erro: '.$e->getMessage());
        }      
        $stmt->close();
        $conn->close();

        return $result;
    }

    public function delete($id){
        $conn = $this->getConn();

        try{
            $stmt = $conn->prepare("DELETE * FROM funcionarios WHERE id=?");
            $stmt->bind_param("i", $id);
            if($stmt->execute()){
                $result = array('code' => 1, 'message'=> 'Funcionario com identificação:'.$id.' deletado com sucesso');
            }else{
                $result = array('code' => 0, 'message'=> 'Funcionario não encontrado');
            }         
        }catch(Exception $e){
            $result = array('code' => 0, 'message'=> 'Houve um erro na exclusão!Erro: '.$e->getMessage());
        }
        $stmt->close();
        $conn->close();

        return $result;
    }

}

?>