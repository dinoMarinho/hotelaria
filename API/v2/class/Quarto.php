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

        public function includeQuarto($tipo,$valorDiaria){
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
        
    }

?>