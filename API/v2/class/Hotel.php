<?php
    header('Content-type: text/html; charset=utf-8');

    class Hotel {
        private $receita;
        private $qtdeQuartos;
        private $lucro;
        private $diaria;
        private $comissoes;
        private $quartosVendidos;

        public function __construct($conn){ $this->conn = $conn; }

        private function getConn(){ return $this->conn; }

        public function setReceita($receita){$this->receita = $receita;}

        public function setQtdeQuartos($qtdeQuartos){$this->qtdeQuartos = $qtdeQuartos;}
        
        public function setLucro($lucro){$this->lucro = $lucro;}

        public function setDiaria($diaria){$this->diaria = $diaria;}

        public function setComissoes($comissoes){$this->comissoes = $comissoes;}

        public function setQuartosVendidos($quartosVendidos){$this->quartosVendidos = $quartosVendidos;}

        public function getReceita(){ return $this->receita; }

        public function getQtdeQuartos(){ return $this->qtdeQuartos; }

        public function getLucro(){ return $this->lucro; }

        public function getDiaria(){ return $this->diaria; }

        public function getQuartosVendidos(){ return $this->quartosVendidos; }

        public function include($nome){ 
            $conn = $this->getConn();
            try {
                // Prepara a query e junta os valores
                $stmt_check = $conn->prepare("SELECT * FROM hotel WHERE nome=:nome");
                $stmt_check->bindParam(":nome", $nome);
                $stmt_check->execute();

                // Verifica se o hotel já foi cadastrado
                if ($stmt_check->rowCount() == 0) {
                    // Insere o hotel no banco de dados
                    $stmt = $conn->prepare("INSERT INTO hotel (receita, qtdeQuarto, lucro, comissaoGeral, quartosVendidos, nome) VALUES ( 0,0, 0 , 0 , 0, 0, :nome)");
                    $stmt->bindParam(':nome', $nome);

                    // Executa a query
                    $stmt->execute();

                    $result = array('code' => 1, 'message'=> 'Hotel '.$name.'foi incluído com sucesso!!');
                } else {
                    $result = array('code' => 0, 'message'=> 'Hotel'.$nome.' já cadastro no sistema!!');
              }

            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na inclusão!Erro: '.$e->getMessage());
            }

            $stmt_check = null;
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
        
        public function getHotel($id){
            $conn = $this->getConn();

            try{

                $stmt = $conn->prepare("SELECT * FROM hotel WHERE id=:id");
                $stmt->bindParam(":id", $id);
                
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                   $data = $stmt->fetchAll();
                   
                   foreach ($data as $row) {
                        $result = array(
                            'code'  => 1,
                            'id'    => $row['id'],
                            'receita'  => $row['receita'],
                            'qtdeQuartos' => $row['qtdeQuartos'],
                            'lucro' => $row['lucro'],
                            'comissaoGeral' => $row['comissaoGeral'],
                            'quartosVendidos' => $row['comissaoGeral'],
                            'nome' => $row['nome']
                        );
                   }
                   
                } else {
                   $result = array('code' => 0, 'message'=> 'Hotel sem cadastro encontrado!!');
                }

            } catch(PDOException $e){
                $result = array('code' => 0, 'message'=> 'Houve um erro na tentativa de buscar dados no banco de dados!Erro: '.$e->getMessage());
            }

            $stmt = null;
            $conn = null;

            return $result;
        }

        public function updateReceita($id,$value){ 

            $info = $this->getHotel($id);

            $new_value = $this->moeda($value);

            if (isset($info['code']) && $info['code'] == 1) {
                
                try{
                    $stmt = $conn->prepare("UPDATE hotel set receita=:receita WHERE id=:id");
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":receita", $new_value);
                    $stmt->execute();

                    // Verifica se o usuário existe
                    if ($stmt->rowCount() > 0) {
                        $result = array('code' => 1, 'message'=> 'A receita foi atualizada com sucesso no hotel '. $info['nome']);
                    } else {
                        $result = array('code' => 0, 'message'=> 'Houve um erro ao atualizar a receita do hotel '. $info['nome']);
                    }

                } catch(PDOException $e) {
                    $result = array('code' => 0, 'message'=> 'Houve um erro na tentativa de buscar dados no banco de dados!Erro: '.$e->getMessage());
                }

            } else {
                $result = array('code' => 0, 'message'=> $info['message']);
            }
            
            return $result;
        }

        public function updateLucro($id,$value){ 

            $info = $this->getHotel($id);

            $new_value = $this->moeda($value);

            if (isset($info['code']) && $info['code'] == 1) {
                
                try{
                    $stmt = $conn->prepare("UPDATE hotel set lucro=:lucro WHERE id=:id");
                    $stmt->bindParam(":id", $id);
                    $stmt->bindParam(":lucro", $new_value);
                    $stmt->execute();

                    // Verifica se o usuário existe
                    if ($stmt->rowCount() > 0) {
                        $result = array('code' => 1, 'message'=> 'O lucro foi atualizada com sucesso no hotel '. $info['nome']);
                    } else {
                        $result = array('code' => 0, 'message'=> 'Houve um erro ao atualizar o lucro do hotel '. $info['nome']);
                    }

                } catch(PDOException $e) {
                    $result = array('code' => 0, 'message'=> 'Houve um erro na tentativa de buscar dados no banco de dados!Erro: '.$e->getMessage());
                }

            } else {
                $result = array('code' => 0, 'message'=> $info['message']);
            }
            
            return $result;
        }


    }
?>