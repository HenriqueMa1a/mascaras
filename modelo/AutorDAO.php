<?php
/**
* @description Classe DAO para a tabela cad_Autor. Data Access Object que irá fazer operações na tabela Usuario (básica: Insert, Update, Delete e Lista)
* @author Rodolpho de Paula
* @date 22/01/2014
* @version 1.0
* @package MDS
* @copyright Bio-Manguinhos|Fiocruz
*/

// Includes
require_once ("PDOConnectionFactory.class.php");
require_once ("Autor.class.php");
class AutorDAO extends PDOConnectionFactory {
	
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
			if (isset ( $_SESSION ['USO_ID'] ))
				$this->_idUsuario = (isset ( $_SESSION ['USO_ID'] )) ? $_SESSION ['USO_ID'] : 1;
		} catch ( PDOException $ex ) {
			echo "Erro: " . $ex->getMessage ();
		}
	}
	public function setMensagem($p_mensagem) {
		$this->_mensagem = $p_mensagem;
	}
	public function getMensagem() {
		return $this->_mensagem;
	}
	private static function carregarModelo($p_Item) {
		try {
			if ($p_Item) {
				$obj = new Autor ();
				$obj->setIdAutor ( $p_Item ['id_autor'] );
				$obj->setIdResumo ( $p_Item ['id_resumo'] );
				$obj->setNome ( $p_Item ['nome'] );
				$obj->setInstituicao ( $p_Item ['instituicao'] );
				$obj->setJustificativa ( $p_Item ['justificativa'] );
				$obj->setFlagPrincipal ( $p_Item ['fl_principal'] );
				$obj->setFlagApresentador ( $p_Item ['fl_apresentador'] );
				$obj - setDatacadastro ( $p_Item ['data_cadastro'] );
				
				return $obj;
			} else
				return null;
		} catch ( Exception $ex ) {
			throw new Exception ( $ex->getMessage (), $ex->getCode () );
		}
	}
	public function salva($obj) {
		try {
			// isso ficaria uma porta aberta para um SQL Injection.
			$stmt = $this->_conexao->prepare ( "INSERT INTO cad_autor (id_resumo, nome, instituicao, justificativa, fl_principal, fl_apresentador) VALUES (?, ?, ?, ?, ?, ?)" );
			$stmt->bindValue ( 1, $obj->getIdResumo () );
			$stmt->bindValue ( 2, $obj->getNome () );
			$stmt->bindValue ( 3, $obj->getInstituicao () );
			$stmt->bindValue ( 4, $obj->getJustificativa () );
			$stmt->bindValue ( 5, $obj->getFlagPrincipal () );
			$stmt->bindValue ( 6, $obj->getFlagApresentador () );
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				$this->_mensagem = '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2];
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
	public function retorna($Id) {
		try {
			
			// preparo a query de update - Prepare Statement
			$query = "SELECT ca.id_autor, ca.id_Resumo, ca.nome, ca.instituicao, ca.justificativa, ca.fl_principal, ca.fl_apresentador, ca.data_cadastro
						FROM CAD_AUTOR as ca inner join
                        CAD_RESUMO AS CR ON CR.ID_RESUMO = CA.ID_Resumo
                        WHERE cr.id_resumo=:Id";
			
			$consulta = $this->_conexao->prepare ( $query );
			
			// valores encapsulados nas variáveis da classe Resumo.
			$consulta->bindParam ( ':Id', $Id );
			
			// executo a query preparada
			$consulta->execute ();
			
			$item = $consulta->fetch ( PDO::FETCH_ASSOC );
			if ($item) {
				return self::carregarModelo ( $item );
			} else {
				return null;
			}
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return null;
		}
	}
	public function retornaAutorPorID($Id_autor) {
		try {
			// preparo a query de update - Prepare Statement
			$query = "SELECT * FROM CAD_AUTOR WHERE id_resumo=" . $Id_resumo;
			
			$consulta = $this->_conexao->prepare ( $query );
			
			// valores encapsulados nas variáveis da classe Resumo.
			// $consulta->bindParam(':Id', $Id_usuario);
			
			// executo a query preparada
			$consulta->execute ();
			
			$item = $consulta->fetch ( PDO::FETCH_ASSOC );
			if ($item) {
				return self::carregarModelo ( $item );
			} else {
				return null;
			}
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return null;
		}
	}
	public function retornaAutorPorUsuario($Id_usuario) {
		try {
			// preparo a query de update - Prepare Statement
			$query = "SELECT ca.id_autor, ca.id_Resumo, ca.nome, ca.instituicao, ca.justificativa, ca.fl_principal, ca.fl_apresentador, ca.data_cadastro
						FROM CAD_AUTOR as ca inner join
                        CAD_RESUMO AS CR ON CR.ID_RESUMO = CA.ID_Resumo
                        WHERE cr.id_usuario=" . $Id_usuario;
			
			$consulta = $this->_conexao->prepare ( $query );
			
			// valores encapsulados nas variáveis da classe Resumo.
			// $consulta->bindParam(':Id', $Id_usuario);
			
			// executo a query preparada
			$consulta->execute ();
			
			$item = $consulta->fetch ( PDO::FETCH_ASSOC );
			if ($item) {
				return self::carregarModelo ( $item );
			} else {
				return null;
			}
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return null;
		}
	}
	public function atualiza($IdAutor, $Nome, $Instituicao, $Justificacao, $FlagPrincipal, $FlagApresentador) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_autor SET nome=? , instituicao=?, justificativa=?, fl_principal=?, fl_apresentador=? WHERE id_autor=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $Nome );
			$stmt->bindValue ( 2, $Instituicao );
			$stmt->bindValue ( 3, $Justificacao );
			$stmt->bindValue ( 4, $FlagPrincipal );
			$stmt->bindValue ( 5, $FlagApresentador );
			$stmt->bindValue ( 6, $IdAutor );
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				throw new Exception ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			} else
				return true;
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
	public function remove($p_IdAutor) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "DELETE FROM cad_autor WHERE id_autor=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $p_IdAutor );
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				throw new Exception ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			} else
				return true;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
}
?>
	