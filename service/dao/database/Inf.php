<?php
	/*
		Classe de dados para conexão com a base.

		Autor: Rafael Moreira Almeida
		Email: rafa.almeid@hotmail.com
		Data : 25/07/2019
	*/
	
	abstract class Inf
	{
		private static $tipoBanco = "mysql";
		private static $porta     = "";
		private static $host      = "127.0.0.1";
		private static $banco     = "VirtualBox";
		private static $usuario   = "root";
		private static $senha     = "";

		public function __clone()
		{
			//...
		}

		protected function getTipoBanco()
		{
			return self::$tipoBanco;
		}		
		protected function getPorta()
		{
			return self::$porta;
		}
		protected function getHost()
		{
			return self::$host;
		}
		protected function getBanco()
		{
			return self::$banco;
		}
		protected function getUsuario()
		{
			return self::$usuario;
		}		
		protected function getSenha()
		{
			return self::$senha;
		}
	}
?>