<?php
/**
* @description Classe DAO para a tabela agenda. Data Access Object que irá fazer operações na tabela Agenda (básica: Insert, Update, Delete e Lista)
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright Bio-Manguinhos|Fiocruz
*/
require_once ("PDOConnectionFactory.class.php");
require_once ("Pais.class.php");
class PaisDAO extends PDOConnectionFactory {
	// irá receber uma conexão
	private $_conexao = null;
	private $_mensagem = null;
	private $_erro = null;
	private $_idUsuario = null;
	/*
	 * //Construtor function __construct(){}
	 */
	
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
	
	// realiza uma inserção
	public function salva($obj) {
		try {
			
			// isso ficaria uma porta aberta para um SQL Injection.
			$stmt = $this->_conexao->prepare ( "INSERT INTO cad_pais (data_inclusao, id_usuario_inclusao, sigla, nome, fl_ativo) VALUES (NOW(), ?, ?, ?, ?)" );
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, utf8_decode ( $obj->getSigla () ) );
			$stmt->bindValue ( 3, utf8_decode ( $obj->getNome () ) );
			$stmt->bindValue ( 4, $obj->getAtivo () );
			
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
	
	// realiza um Select
	public function retorna($id) {
		try {
			
			// preparo a query de update - Prepare Statement
			$consulta = $this->_conexao->prepare ( "SELECT * FROM cad_pais WHERE id_pais=?" );
			
			// valores encapsulados nas variáveis da classe Agenda.
			// sequencia de índices que representa cada valor de minha query
			$consulta->bindValue ( 1, $id );
			// $consulta->bindParam(':id', $id, PDO::PARAM_INT);
			
			// executo a query preparada
			$consulta->execute ();
			
			$linha = $consulta->fetch ( PDO::FETCH_ASSOC );
			if ($linha) {
				// instancio a classe Agenda
				$obj = new Pais ();
				
				// echo $i." - ".$row['name']."<br/>";
				$obj->setId ( $linha ['id_pais'] );
				$obj->setNome ( $linha ['nome'] );
				$obj->setSigla ( $linha ['sigla'] );
				$obj->setAtivo ( $linha ['fl_ativo'] );
				
				return $obj;
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
			$stmt = $this->_conexao->prepare ( "UPDATE cad_pais SET data_alteracao=NOW(), id_usuario_alteracao=?, sigla=?, nome=? WHERE id_pais=?" );
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, utf8_decode ( $obj->getSigla () ) );
			$stmt->bindValue ( 3, utf8_decode ( $obj->getNome () ) );
			$stmt->bindValue ( 4, $obj->getId () );
			
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
			$num = $this->_conexao->exec ( "DELETE FROM cad_pais WHERE id_pais=$id" );
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
			$stmt = $this->_conexao->prepare ( "UPDATE cad_pais SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_pais=?" );
			
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
	
	// retorna uma lista de objetos
	public function lista($page = null, $rows = null, $sidx = null, $sord = null) {
		try {
			
			if ($sidx == 'IdPais')
				$sidx = 'id_pais';
			
			$query = "SELECT p.*
                        FROM cad_pais p
                        WHERE p.fl_ativo=1 
                        ORDER BY $sidx $sord";
			$rs = $this->_conexao->query ( $query );
			
			if ($rs) {
				$listagem = array ();
				foreach ( $rs as $item ) {
					$obj = new Pais ();
					$obj->setId ( $item ["id_pais"] );
					$obj->setNome ( trim ( $item ["nome"] ) );
					$obj->setSigla ( trim ( $item ["sigla"] ) );
					$obj->setAtivo ( $item ["fl_ativo"] );
					// echo $obj->getNome()." - ".$obj->getSigla()."<br/>";
					$listagem [] = $obj;
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