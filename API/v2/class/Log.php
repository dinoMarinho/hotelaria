<?php
    header('Content-type: text/html; charset=utf-8');

    class Log {
        private $conn;
        private $ip;
        private $hora;
        private $mensagem;
 

        public function __construct($conn){ $this->conn = $conn; }

        private function getConn(){ return $this->conn; }

        public function setIP($ip){$this->ip = $ip;}

        public function setHora($hora){$this->hora = $hora;}

        public function setMensagem($mensagem){$this->$mensagem = $mensagem;}

        private function getIP(){ return $this->ip; }

        private function getHora(){ return $this->hora; }

        private function getMensagem(){ return $this->mensagem; }

        private function getRealIp(){
            if(!empty($_SERVER['HTTP_CLIENT_IP'])){
                $ip=$_SERVER['HTTP_CLIENT_IP'];
              }
              elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
              }
              else{
                $ip=$_SERVER['REMOTE_ADDR'];
              }
        
            return $ip;
        }

        public function insert($mensagem){

            $hora = date('Y-m-d H:i:s');
            $ip = $this->getRealIp();
            
            $conn = $this->getConn();

            try {
                
                $stmt = $conn->prepare("INSERT INTO logs (ip, hora, mensagem) VALUES (:ip, :hora, :mensagem)");
                $stmt->bindParam(':ip', $ip);
                $stmt->bindParam(':hora', $hora);
                $stmt->bindParam(':mensagem', $mensagem);

                $stmt->execute();

                $result = array('code' => 1, 'message'=> 'Log inserido com sucesso!');

            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na inclusão do Log!Erro: '.$e->getMessage());
            }
            

            $stmt = null;
            $conn = null;

            return $result;
        }

        public function getAll(){
            $conn = $this->getConn();

            try {

                $stmt = $conn->prepare("SELECT * FROM logs");

                 $stmt->execute();

                 if ($stmt->rowCount() > 0) {
                    $data = $stmt->fetchAll();
                    
                    $logs = array();
                    $i = 0;

                    
                    foreach ($data as $row) {
                        $log[$i] = [
                            'id'   => $row['id'],
                            'ip' => $row['ip'],
                            'hora' => $row['hora'],
                            'mensagem' => $row['mensagem']
                        ];
                        $i++;                 
                    }

                    $result = array('code' => 1, 'message'=> 'Sucesso!!', 'logs' => $logs);

                 } else {
                    $result = array('code' => 0, 'message'=> 'Nenhum log encontrado!');
                 }
                 
            } catch(PDOException $e) {
                $result = array('code' => 0, 'message'=> 'Houve um erro na busca dos logs!Erro: '.$e->getMessage());
            }

            $stmt = null;
            $conn = null;

            return $result;
        }
        

    }
?>