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
        
            // Pega as informações do funcinário
            $info = $this->information($mail);

            if (isset($info['code']) && $info['code'] == 1) {
                if(password_verify($password, $info['password'])){
                    $result = array(
                        'code'    => 1,
                        'id'      => $info['id'],
                        'name'    => $info['name'],
                        'email'   => $info['email'],
                        'message' => 'Funcionário logado com sucesso!!'
                    );
                }else{ 
                        $result = array('code' => 0, 'message'=> 'Senha inválida');    
                }
            } else{
                $result = array('code' => 0, 'message'=> 'Funcionário sem cadastro encontrado!!');
            }
      
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

            if (isset($info['code']) && $info['code'] == 1) {
                $result = array(
                    'code' => 1, 
                    'name'  => $info['name'],
                    'email' => $info['email'],
                    'comission' => $info['comission']
                );
            } else {
                $result = array('code' => 0, 'message'=> $info['message']);
            }

            return $result;
        }

        public function includeComission($id,$value){
             // Pega as informações do funcinário
             $info = $this->information($id);

             if (isset($info['code']) && $info['code'] == 1) {
                    if(is_null($info['comission'])){
                        $old_comission = 0;
                    }else{
                        $old_comission = $info['comission'];
                    }
                    $new_value = $this->moeda($info['comission'] + $value);

                    // Pega os dados da conexão com a base de dados
                    $conn = $this->getConn();

                    try{
                        $stmt = $conn->prepare("UPDATE funcionarios set comissao=:comissao WHERE id=:id");
                        $stmt->bindParam(":id", $id);
                        $stmt->bindParam(":comissao", $new_value);
                        $stmt->execute();

                        // Verifica se o usuário existe
                        if ($stmt->rowCount() > 0) {
                            $result = array('code' => 1, 'message'=> 'A comissão foi adicionada com sucesso!');
                        } else {
                            $result = array('code' => 0, 'message'=> 'Houve um erro ao incluir a comissão no funcinário!');
                        }
                    }catch(PDOException $e){
                        $result = array('code' => 0, 'message'=> 'Houve um erro na tentativa de buscar dados no banco de dados!Erro: '.$e->getMessage());
                    }
                            
                    $stmt = null;
                    $conn = null;

                
            } else {
                $result = array('code' => 0, 'message'=> $info['message']);
            }

            return $result;
        }

        /*
            @method privates
        */

        private function getConn(){ return $this->conn; }

        private function information($info){
            // Pega os dados da conexão com a base de dados
            $conn = $this->getConn();

            try{

                if(is_numeric($info)){
                    $stmt = $conn->prepare("SELECT * FROM funcionarios WHERE id=:id");
                    $stmt->bindParam(":id", $info);
                } else {
                    $stmt = $conn->prepare("SELECT * FROM funcionarios WHERE email=:mail");
                    $stmt->bindParam(":mail", $info);
                }

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
                            'password' => $row['senha'],
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

        private static function moeda($get_valor) {
            $source = array('.', ',');
            $replace = array('', '.');
            $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
            return $valor; //retorna o valor formatado para gravar no banco
        }
        
    }
?>