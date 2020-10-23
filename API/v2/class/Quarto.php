<?php
    header('Content-type: text/html; charset=utf-8');

    class Quarto {
        private $tipo;
        private $valorDiaria;
        private $lucroOp;
        private $conn;

        public function __construct($conn){ $this->conn = $conn; }

        private function getConn(){ return $this->conn; }

        public function setTipo($tipo){ $this->tipo = $tipo; }

        public function setvalorDiaria($valorDiaria){ $this->valorDiaria = $valorDiaria; }

        public function setLucroOp($lucroOp){ $this->lucroOp = $lucroOp; }

        public function getTipo(){ return $this->lucroOp; }

        public function getvalorDiaria(){ return $this->valorDiaria; }

        public function getLucroOp(){ return $this->LucroOp; }

        private static function moeda($get_valor) {
            $source = array('.', ',');
            $replace = array('', '.');
            $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
            return $valor; //retorna o valor formatado para gravar no banco
        }

        public function include($tipo,$valorDiaria){
            // Pega os dados da conexão com a base de dados
            $conn = $this->getConn();

            try {
                // Insere o usuário no banco de dados
                $stmt = $conn->prepare("INSERT INTO quartos (tipo, valorDiaria) VALUES (:tipo, :valor)");
                $stmt->bindParam(':tipo', $tipo);
                $stmt->bindParam(':valor', $valorDiaria);

                 // Executa a query
                 $stmt->execute();

                 $result = array('code' => 1, 'message'=> 'Quarto incluído com sucesso');

            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na inclusão do quarto!Erro: '.$e->getMessage());
            }

            $stmt = null;
            $conn = null;

            return $result;
        }

        public function getAll(){
            // Pega os dados da conexão com a base de dados
            $conn = $this->getConn();

            try {
                // Insere o usuário no banco de dados
                $stmt = $conn->prepare("SELECT * FROM quartos");

                 // Executa a query
                 $stmt->execute();

                 if ($stmt->rowCount() > 0) {
                    // Pega todos os dados do usuário e atribui a variável
                    $data = $stmt->fetchAll();
                    
                    $quartos = array();
                    $i = 0;

                    // Varre dado por dado da busca
                    foreach ($data as $row) {
                        $quartos[$i] = [
                            'id'   => $row['id'],
                            'tipo' => $row['tipo'],
                            'valorDiaria' => $row['valorDiaria'],
                            'lucroOp' => $row['lucroOp']
                        ];
                        $i++;                 
                    }

                    $result = array('code' => 1, 'message'=> 'Retorno de todos os quarto com sucesso!!!', 'quartos' => $quartos);

                 } else {
                    $result = array('code' => 0, 'message'=> 'Nenhum Quarto cadastrado');
                 }
                 
            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na busca dos quartos!Erro: '.$e->getMessage());
            }

            $stmt = null;
            $conn = null;

            return $result;
        }

        public function getQuarto($id) {
            // Pega os dados da conexão com a base de dados
            $conn = $this->getConn();

            try {
                // Insere o usuário no banco de dados
                $stmt = $conn->prepare("SELECT * FROM quartos WHERE id = :id");
                $stmt->bindParam(':id', $id);

                 // Executa a query
                 $stmt->execute();

                 if ($stmt->rowCount() > 0) {
                    // Pega todos os dados do usuário e atribui a variável
                    $data = $stmt->fetchAll();
                    
                    $quarto = array();

                    // Varre dado por dado da busca
                    foreach ($data as $row) {
                        $quarto = [
                            'id'   => $row['id'],
                            'tipo' => $row['tipo'],
                            'valorDiaria' => $row['valorDiaria'],
                            'lucroOp' => $row['lucroOp']
                        ];
                        $i++;                 
                    }

                    $result = array('code' => 1, 'message'=> 'Retorno de todos os quarto com sucesso!!!', 'quarto' => $quarto);

                 } else {
                    $result = array('code' => 0, 'message'=> 'Nenhum Quarto cadastrado');
                 }
                 
            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na inclusão do quarto!Erro: '.$e->getMessage());
            }

            $stmt = null;
            $conn = null;

            return $result;
        }

        public function includelucroOp($id,$value){
            // Pega as informações do funcinário
            $info = $this->getQuarto($id);

            if (isset($info['code']) && $info['code'] == 1) {
                   if(is_null($info['lucroOp'])){
                       $old_lucroOp = 0;
                   }else{
                       $old_lucroOp = $info['lucroOp'];
                   }
                   $new_value = $this->moeda($info['lucroOp'] + $value);

                   // Pega os dados da conexão com a base de dados
                   $conn = $this->getConn();

                   try{
                       $stmt = $conn->prepare("UPDATE quartos set lucroOP=:lucroOp WHERE id=:id");
                       $stmt->bindParam(":id", $id);
                       $stmt->bindParam(":lucroOp", $new_value);
                       $stmt->execute();

                       // Verifica se o usuário existe
                       if ($stmt->rowCount() > 0) {
                           $result = array('code' => 1, 'message'=> 'O lucro operacinal foi adicionado com sucesso!');
                       } else {
                           $result = array('code' => 0, 'message'=> 'Houve um erro ao incluir o lucro operacinal no quarto!');
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

        
        
    }

?>