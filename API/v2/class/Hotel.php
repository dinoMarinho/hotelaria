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

        public function setqtdeQuartos($qtdeQuartos){$this->qtdeQuartos = $qtdeQuartos;}
        
        public function setLucro($lucro){$this->lucro = $lucro;}

        public function setDiaria($diaria){$this->diaria = $diaria;}

        public function setComissoes($comissoes){$this->comissoes = $comissoes;}

        public function setquartosVendidos($quartosVendidos){$this->quartosVendidos = $quartosVendidos;}
    }
?>