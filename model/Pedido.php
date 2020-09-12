<?php

    require_once('Marca.php');

    class Pedido{
        private $id;
        private $nome;
        private $email;
        private $telefone;
        private $produto;
        private $valorMax;
        private $marca;

        public function __construct(string $nome="", string $email="", 
                                string $telefone="", string $produto="", float $valorMax=0.0, Marca $marca=null, int $id=-1){
                                    $this->id = $id;
                                    $this->nome = $nome;
                                    $this->email = $email;
                                    $this->telefone = $telefone;
                                    $this->produto = $produto;
                                    $this->valorMax = $valorMax;
                                    $this->marca = $marca;
        }

        public function setId(int $id){
            $this->id = $id;
        }
        public function getId(){
            return $this->id;
        }

        public function setNome(string $nome){
            $this->nome = $nome;
        }
        public function getNome(){
            return $this->nome;
        }

        public function setEmail(string $email){
            $this->email = $email;
        }
        public function getEmail(){
            return $this->email;
        }

        public function setTelefone(string $telefone){
            $this->telefone = $telefone;
        }
        public function getTelefone(){
            return $this->telefone;
        }

        public function setProduto(string $produto){
            $this->produto = $produto;
        }
        public function getProduto(){
            return $this->produto;
        }

        public function setValorMax(float $valorMax){
            $this->valorMax = $valorMax;
        }
        public function getValorMax(){
            return $this->valorMax;
        }

        public function setMarca(Marca $marca){
            $this->marca = $marca;
        }
        public function getMarca(){
            return $this->marca;
        }
    }

?>