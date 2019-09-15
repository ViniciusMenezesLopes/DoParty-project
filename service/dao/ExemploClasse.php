<?php
    require_once $_SERVER['DOCUMENT_ROOT']. "/rafael/class/database/OperacaoClass.php";

    class Classe extends OperacaoClass
    {
        private static $tabela = 'tbl_pessoa';

        private $atributos     = [
            'id'       => ['valor' => null, 'required' => true],
            'nome'     => ['valor' => null, 'required' => true],
            'idade'    => ['valor' => null, 'required' => false],
            'telefone' => ['valor' => null, 'required' => false],
            'email'    => ['valor' => null, 'required' => false],
        ];

        public function insert()
        {
            return $this->create($this->atributos, self::$tabela);
        }
        public function search()
        {
            return $this->read($this->atributos, self::$tabela);
        }
        public function update()
        {
            return $this->modify($this->atributos, self::$tabela);
        }
        public function delete()
        {
            return $this->ruleOut($this->atributos, self::$tabela);
        }

        public function setId($id)
        {
            $this->atributos['id']['valor'] = $id;
        }
        public function setNome($nome)
        {
            $this->atributos['nome']['valor'] = $nome;
        }
        public function setIdade($idade)
        {
            $this->atributos['idade']['valor'] = $idade;
        }
        public function setTelefone($telefone)
        {
            $this->atributos['telefone']['valor'] = $telefone;
        }
        public function setEmail($email)
        {
            $this->atributos['email']['valor'] = $email;
        }
    }
?>