<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/rafael/class/database/Inf.php";

	class ConectDatabase extends Inf
	{
		private static $conexao = null;

		function __clone()
		{
			//...
		}

		private static function Conctar()
		{
			try
			{
				$conn = new PDO(
					self::getTipoBanco().
					":host=".self::getHost().
					";port=".self::getPorta().
					";dbname=".self::getBanco(), self::getUsuario(), self::getSenha()
				);
				
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				return $conn;
			}
			catch (PDOException $e)
			{
				return false;
			}
		}

		public static function getInstance()
		{
			if (!isset(self::$conexao))
			{
				return self::$conexao = self::Conctar();
			}
			else
			{
				return self::$conexao;
			}
		}
	}
?>