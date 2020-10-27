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

    }
?>