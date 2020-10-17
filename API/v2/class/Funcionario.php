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

        public function encryptPassword($password){
            $password_hash = trim(password_hash($password, PASSWORD_DEFAULT));
            return $password_hash; 
        }

        public function include($name,$mail,$password){
            // Pega os dados da conexão com a base de dados
            $conn = $this->getConn();

            // Criptografa a senha do usuário
            $password = $this->encryptPassword($password);

            try {
                // Prepara a query e junta os valores
                $stmt_check = $conn->prepare("SELECT email FROM funcionarios WHERE email=:mail");
                $stmt_check->bindParam(":mail", $mail);
                $stmt_check->execute();

                // Verifica se o usuário já foi cadastrado
                if ($stmt_check->rowCount() == 0) {
                    // Insere o usuário no banco de dados
                    $stmt = $conn->prepare("INSERT INTO funcionarios (nome, email, senha) VALUES (:nome, :email, :senha)");
                    $stmt->bindParam(':nome', $name);
                    $stmt->bindParam(':email', $mail);
                    $stmt->bindParam(':senha', $password);

                    // Executa a query
                    $stmt->execute();

                    $result = array('code' => 1, 'message'=> 'Funcionário:'.$name.' com E-mail:'.$mail.' foi incluído com sucesso!!');
                } else {
                    $result = array('code' => 0, 'message'=> 'E-mail:'.$mail.' já cadastro no sistema!!');
              }

            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na inclusão!Erro: '.$e->getMessage());
            }

            $stmt_check = null;
            $stmt = null;
            $conn = null;
      
            return $result;
        }

        public function validate($mail, $password){
            // Pega os dados da conexão com a base de dados
            $conn = $this->getConn();

            try{
                 // Prepara a query e junta os valores
                 $stmt = $conn->prepare("SELECT * FROM funcionarios WHERE email=:mail");
                 $stmt->bindParam(":mail", $mail);
                 $stmt->execute();
 
                 // Verifica se o usuário existe
                 if ($stmt->rowCount() > 0) {
                    //  Pega todos os dados do usuário e atribui a variável
                    $data = $stmt->fetchAll();
                    
                    // Varre dado por dado da busca
                    foreach ($data as $row) {
                        // Verifica se o hash é valido na senha
                        if(password_verify($password, $row['senha'])){
                            $result = array(
                                'code'  => 1,
                                'id'    => $row['id'],
                                'name'  => $row['nome'],
                                'email' => $row['email']
                            );
                        }else{ 
                            $result = array('code' => 0, 'message'=> 'Senha inválida');    
                        }
                    }

                 } else {
                    $result = array('code' => 0, 'message'=> 'Funcionário sem cadastro encontrado!!');
                 }

            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na validação no banco de dados!Erro: '.$e->getMessage());
            }

            $stmt = null;
            $conn = null;
      
            return $result;
        }

        public function delete($id){
            // Pega os dados da conexão com a base de dados
            $conn = $this->getConn();

            try{
                // Prepara a query e junta os valores
                $stmt = $conn->prepare("DELETE * FROM funcionarios WHERE id=:id");
                $stmt->bindParam(":id", $id);
                $stmt->execute();      

                // Executa a query
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $result = array('code' => 1, 'message'=> 'Funcionário deletado com sucesso!!');
                } else {
                    $result = array('code' => 0, 'message'=> 'Funcionário não encontrado!!');
                }

            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na tentativa de delete no banco de dados!Erro: '.$e->getMessage());
            }

            $stmt = null;
            $conn = null;
      
            return $result;
        }

        public function getInformation($id){
            // Pega as informações do funcinário
            $info = $this->information($id);

            if (isset($info['code'])) {
                if ($info['code'] == 1){
                    $result = array(
                        'code' => 1, 
                        'id'    => $info['id'],
                        'name'  => $info['name'],
                        'email' => $info['email'],
                        'comission' => $info['comission']
                    );
                } else {
                    $result = array('code' => 1, 'message'=> 'Não achou o funcinário');
                }
            } else{
                $result = array('code' => 0, 'message'=> 'Não achou o código');
            }

            return $result;
        }

        /*
            @method privates
        */

        private function getConn(){ return $this->conn; }

        private function information($id){
            // Pega os dados da conexão com a base de dados
            $conn = $this->getConn();

            try{
                // Prepara a query e junta os valores
                $stmt = $conn->prepare("SELECT * FROM funcionarios WHERE id=:id");
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                // Verifica se o usuário existe
                if ($stmt->rowCount() > 0) {
                   // Pega todos os dados do usuário e atribui a variável
                   $data = $stmt->fetchAll();
                   
                   // Varre dado por dado da busca
                   foreach ($data as $row) {
                        $result = array(
                            'code'  => 1,
                            'id'    => $row['id'],
                            'name'  => $row['nome'],
                            'email' => $row['email'],
                            'senha' => $row['senha'],
                            'comission' => $row['comissao'],
                        );
                   }
                   
                } else {
                   $result = array('code' => 0, 'message'=> 'Funcionário sem cadastro encontrado!!');
                }

            } catch(PDOException $e){
                $result = array('code' => 0, 'message'=> 'Houve um erro na tentativa de buscar dados no banco de dados!Erro: '.$e->getMessage());
            }

            $stmt = null;
            $conn = null;
      
            return $result;
        }
        
    }
?>