<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/rafael/class/database/ConectDatabase.php";

	abstract class OperacaoClass
	{
		protected function read($atributos, $tabela)
		{
			$filtro = $this->validaPesquisa($atributos);
			$where  = "";

			if($filtro)
			{
				$where .= "WHERE {$filtro}";
			}

			$sql   = "SELECT * FROM {$tabela} {$where}";

			if($this->realizaConexao())
			{
				$query = $this->realizaConexao()->prepare($sql);
				$query->execute();
				return  $query->fetchAll(PDO::FETCH_ASSOC);
			}

			return false;
		}

		protected function create($atributos, $tabela)
		{
			$campos = $this->validaInsert($atributos);
			$sql    = "";

			if(is_array($campos))
			{
				$coluna = '('.$campos['coluna'].')';
				$valor  = '('.$campos['valor'].')';
				$sql   .= "INSERT INTO {$tabela} {$coluna} VALUES {$valor}";
				$query  = $this->realizaConexao()->prepare($sql);
				$query->execute();
				return $this->realizaConexao()->lastInsertId();
			}

			return false;
		}

		protected function modify($atributos, $tabela)
		{
			$sql = "";

			if($this->validaId($atributos) && $this->verificaAtributos($atributos))
			{
				$id    =  $atributos['id']['valor'];
				$set   =  $this->validaUpdade($atributos);
				$sql  .= "UPDATE {$tabela} SET {$set} WHERE id = {$id}";
				$query = $this->realizaConexao()->prepare($sql);
				$query->execute();
				return $query->rowCount();
			}

			return false;
		}

		protected function ruleOut($atributos, $tabela)
		{
			$sql = "";

			if($this->validaId($atributos))
			{
				$id    =  $atributos['id']['valor'];
				$sql  .= "DELETE FROM {$tabela} WHERE id = {$id}";
				$query = $this->realizaConexao()->prepare($sql);
				$query->execute();
				return $query->rowCount();
			}

			return false;
		}

		protected function query($sql)
		{
			$query = $this->realizaConexao()->prepare($sql);
			$query->execute();
			return  $query->fetchAll(PDO::FETCH_ASSOC);
		}

		//------------------------------------------------------------------------

		/*
			Método pega a instância da conexão.
			Retorno: Bool
		*/
		private function realizaConexao()
		{
			if($conexao = ConectDatabase::getInstance()) return $conexao;
			else return false;
		}

		/*
			Método recebe o array dos atributos das classes do Model e retorna suas posições e seus valores
			Retorno: String
		*/
		private function showAtributos($arrayAtributos = array())
        {
			$atributes = "";
			foreach ($arrayAtributos as $key => $value)
			{
                $atributes .= $key.': '.$value['valor'].'<br/>';
			}
			return $atributes;
		}

		/*
			Método recebe array com os atributos e retorna os que foram setados.
			Retorno: Array
		*/
		private function atributosSetados($arrayAtributos = array())
		{
			$validos = "";
			foreach ($arrayAtributos as $key => $value)
			{
				if(!empty($value['valor'])) $validos .= $key." = ".$value['valor']."<br/>";
			}

			return $validos;
		}

		/*
			Método recebe o array dos atributos da classe do Model e retorna a ID se existir e não estiver com valor nulo ou vazio
			Caso esteja nulo ou vazio, ou ainda, o ID não exista retorna 'false'.
			Retorno: Bool
		*/
		private function validaId($arrayAtributos = array())
		{
			if(isset($arrayAtributos['id']) && !empty($arrayAtributos['id']['valor']))
			{
				return true;
			}
			return false;
		}

		/*
			Método recebe o array dos atributos e verifica se estão vazios ou se algum atributo obrigatório não foi setado. 
			Se não houver valor setado nos atrubutos o método invalida retornando false. Se houver valores valida com true
			Retorno: Bool
		*/
		private function verificaAtributos($arrayAtributos = array())
		{
			// Total de atributos no array, desconsiderando o 'id'
			$numeroAtributos = count($arrayAtributos) - 1;
			$atributosVazios = 0;

			foreach ($arrayAtributos as $key => $value)
			{
				if($key != 'id')
				{
					if(empty($value['valor'])) $atributosVazios++;
					if(empty($value['valor']) && $value['required']) return false;
				}
			}
			if($atributosVazios == $numeroAtributos) return false;
			return true;
		}

		/*
			Método recebe array e retorna uma string com os colunas e seus valores
			Retorno: String
		*/
		private function validaUpdade($arrayAtributos = array())
		{
			$numeroPosicao = 0;
			$set           = "";

			foreach ($arrayAtributos as $key => $value)
			{
				if(!empty($value['valor']) && $key != 'id')
				{
					$numeroPosicao++;
					$valor = (is_string($value['valor']) ? "'".$value['valor']."'" : $value['valor']);
					$set  .= ($numeroPosicao > 1 ? ', ' : ' ').$key.' = '.$valor;
				}
			}
			return $set;
		}

		/*
			Método recebe array e retorna outro array com os valores dos atributos setados e os índices
			Retorno: Array
		*/
		private function validaInsert($arrayAtributos = array())
		{
			$numeroPosicao = 0;
			$colunas       = "";
			$valores       = "";

			if($this->verificaAtributos($arrayAtributos))
			{
				foreach ($arrayAtributos as $key => $value)
				{
					if(!empty($value['valor']) && $key != 'id')
					{
						$numeroPosicao++;
						$valores .= ($numeroPosicao > 1 ? ', ' : '').(is_string($value['valor']) ? "'".$value['valor']."'" : $value['valor']);
						$colunas .= ($numeroPosicao > 1 ? ', ' : '').$key;
					}
				}

				return ['coluna' => $colunas, 'valor'  => $valores];
			}

			return false;
		}

		/*
			Método recebe array dos atributos e retorna os atributos e os valores setados.
			Retorno: String
		*/
		private function validaPesquisa($arrayAtributos = array())
		{
			$numeroPosicao = 0;
			$set           = "";

			foreach ($arrayAtributos as $key => $value)
			{
				if(!empty($value['valor']))
				{
					$numeroPosicao++;
					$valor = (is_string($value['valor']) ? "'".$value['valor']."'" : $value['valor']);
					$set  .= ($numeroPosicao > 1 ? ' AND ' : ' ').$key.' = '.$valor;
				}
			}
			return $set;
		}
	}
?>