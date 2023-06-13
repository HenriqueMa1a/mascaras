<?php
/**
* @description Classe DAO para a tabela Modulo. Data Access Object que irá fazer operações na tabela Modulo (básica: Insert, Update, Delete e Lista)
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* 
*/
require_once ("PDOConnectionFactory.class.php");
require_once ("Modulo.class.php");
class ModuloDAO extends PDOConnectionFactory {
	// irá receber uma conexão
	private $_conexao = null;
	private $_mensagem = null;
	private $_erro = null;
	private $_idUsuario = null;
	
	// Destrutor
	function __destruct() {
		$this->_conexao = null;
	}
	
	// constructor
	function __construct() {
		try {
			$this->_conexao = PDOConnectionFactory::getConnection ();
			$this->_mensagem = '';
			$this->_idUsuario = (isset ( $_SESSION ['USO_ID'] )) ? $_SESSION ['USO_ID'] : 1;
		} catch ( PDOException $ex ) {
			echo "Erro: " . $ex->getMessage ();
		}
	}
	public function setMensagem($p_nome) {
		$this->_mensagem = $p_mensagem;
	}
	public function getMensagem() {
		return $this->_mensagem;
	}
	
	/**
	 * função interna para carregar objeto com os dados do registro.
	 *
	 * @param object $Item
	 *        	O Objeto do tipo Registro do Banco de Dados
	 * @return object $Modelo O Objeto do tipo do Modelo desta classe
	 */
	private static function carregarModelo($p_Item) {
		try {
			if ($p_Item) {
				$obj = new Modulo ();
				$obj->setId ( $p_Item ['id_modulo'] );
				$obj->setIdModuloPai ( $p_Item ['id_modulo_pai'] );
				$obj->setChave ( $p_Item ['chave'] );
				$obj->setNome ( $p_Item ['nome'] );
				$obj->setDescricao ( $p_Item ['descricao'] );
				$obj->setImagem ( $p_Item ['imagem'] );
				$obj->setNivel ( $p_Item ['nivel'] );
				$obj->setOrdem ( $p_Item ['ordem'] );
				//$obj->setTotalVisitas ( $p_Item ['total_visitas'] );
				//$obj->setAtivo ( $p_Item ['fl_ativo'] );
				return $obj;
			} else
				return null;
		} catch ( Exception $ex ) {
			throw new Exception ( $ex->getMessage (), $ex->getCode () );
		}
	}
	
	// realiza uma inserção
	public function salva($obj) {
		try {
			
			// isso ficaria uma porta aberta para um SQL Injection.
			$stmt = $this->_conexao->prepare ( "INSERT INTO cad_modulo (data_inclusao, id_usuario_inclusao, id_modulo_pai, chave, nome, descricao, imagem, nivel, ordem, fl_ativo) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)" );
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $obj->getIdModuloPai () );
			$stmt->bindValue ( 3, $obj->getChave () );
			$stmt->bindValue ( 4, utf8_decode ( $obj->getNome () ) );
			$stmt->bindValue ( 5, utf8_decode ( $obj->getDescricao () ) );
			$stmt->bindValue ( 6, utf8_decode ( $obj->getImagem () ) );
			$stmt->bindValue ( 7, $obj->getNivel () );
			$stmt->bindValue ( 8, $obj->getOrdem () );
			$stmt->bindValue ( 9, $obj->getAtivo () );
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				throw new PDOException ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			} else {
				$obj->setId ( $this->_conexao->lastInsertId () );
				return true;
			}
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
	
	// realiza um Select
	public function retorna($p_Id) {
		try {
			
			// preparo a query de update - Prepare Statement
			$consulta = $this->_conexao->prepare ( "SELECT m.* FROM cad_modulo m WHERE m.id_modulo=?" );
			
			// valores encapsulados nas variáveis da classe Agenda.
			$consulta->bindValue ( 1, $p_Id );
			
			// executo a query preparada
			$consulta->execute ();
			
			$linha = $consulta->fetch ( PDO::FETCH_ASSOC );
			if ($linha) {
				return self::carregarModelo ( $linha );
			} else {
				return null;
			}
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return null;
		}
	}
	
	// realiza um Select
	public function retornaPorChave($p_Chave) {
		try {
			
			// preparo a query de update - Prepare Statement
			$consulta = $this->_conexao->prepare ( "SELECT m.* FROM cad_modulo m WHERE m.chave=?" );
			
			// valores encapsulados nas variáveis da classe Agenda.
			$consulta->bindValue ( 1, $p_Chave );
			
			// executo a query preparada
			$consulta->execute ();
			
			$linha = $consulta->fetch ( PDO::FETCH_ASSOC );
			if ($linha) {
				return self::carregarModelo ( $linha );
			} else {
				return null;
			}
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return null;
		}
	}
	
	// realiza um Update
	public function atualiza($obj) {
		try {
			
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_modulo SET data_alteracao=NOW(), id_usuario_alteracao=?, id_modulo_pai=?, chave=?, nome=?, descricao=?, imagem=?, nivel=?, ordem=? WHERE id_modulo=?" );
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $obj->getIdModuloPai () );
			$stmt->bindValue ( 3, $obj->getChave () );
			$stmt->bindValue ( 4, utf8_decode ( $obj->getNome () ) );
			$stmt->bindValue ( 5, utf8_decode ( $obj->getDescricao () ) );
			$stmt->bindValue ( 6, utf8_decode ( $obj->getImagem () ) );
			$stmt->bindValue ( 7, $obj->getNivel () );
			$stmt->bindValue ( 8, $obj->getOrdem () );
			$stmt->bindValue ( 9, $obj->getId () );
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				throw new PDOException ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			} else
				return true;
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
	
	// remove um registro
	public function remove($id) {
		try {
			// executo a query
			$num = $this->_conexao->exec ( "DELETE FROM cad_modulo WHERE id_modulo=$id" );
			// caso seja execuado ele retorna o número de rows que foram afetadas.
			if ($num >= 1) {
				return $num;
			} else {
				return 0;
			}
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
	
	// desativa um registro
	public function desativa($id) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_modulo SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_modulo=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $id );
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				throw new PDOException ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			} else
				return true;
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
	
	// registra log de visita
	public function visita($p_Id) {
		try {
			// executo a query
			$num = $this->_conexao->exec ( "UPDATE cad_modulo SET total_visitas=total_visitas+1 WHERE id_modulo=$p_Id" );
			// caso seja execuado ele retorna o número de rows que foram afetadas.
			if ($num >= 1) {
				return $num;
			} else {
				return 0;
			}
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
	
	// registra log de visita
	public function visitaPorChave($p_Chave) {
		try {
			// executo a query
			$num = $this->_conexao->exec ( "UPDATE cad_modulo SET total_visitas=total_visitas+1 WHERE chave='$p_Chave'" );
			// caso seja execuado ele retorna o número de rows que foram afetadas.
			if ($num >= 1) {
				return $num;
			} else {
				return 0;
			}
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
	
	// retorna uma lista de objetos
	public function lista($page = null, $rows = null, $sidx = null, $sord = null, $nivel = null, $id_modulo_pai = null) {
		try {
			$filtro = '';
			if ($sidx == 'IdModulo')
				$sidx = 'id_modulo';
			if ($sidx == 'IdModuloPai')
				$sidx = 'id_modulo_pai';
			if ($sidx == 'Nome')
				$sidx = 'nome';
			if ($sidx == 'Descricao')
				$sidx = 'descricao';
			if ($sidx == 'Nivel')
				$sidx = 'nivel';
			if ($sidx == 'Ordem')
				$sidx = 'ordem';
			if ($nivel)
				$filtro .= " AND nivel=$nivel ";
			if ($id_modulo_pai)
				$filtro .= " AND id_modulo_pai=$id_modulo_pai ";
			
			$query = "SELECT * FROM cad_modulo 
						WHERE fl_ativo=1 $filtro
                        ORDER BY $sidx $sord";
			// echo $query;
			$rs = $this->_conexao->query ( $query );
			if ($rs) {
				$listagem = array ();
				foreach ( $rs as $item ) {
					$listagem [] = self::carregarModelo ( $item );
				}
				return $listagem;
			} else {
				$this->_erro = $this->_conexao->errorInfo ();
				throw new PDOException ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			}
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return null;
		}
	}
}
?>