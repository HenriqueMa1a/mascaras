<?php
/**
* @description Classe DAO para a tabela agenda. Data Access Object que irá fazer operações na tabela Usuario (básica: Insert, Update, Delete e Lista)
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright Bio-Manguinhos|Fiocruz
*/

// Includes
require_once ("PDOConnectionFactory.class.php");
require_once ("Apresentacao.class.php");
class ResumoDAO extends PDOConnectionFactory {
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
				$obj = new Apresentacao ();
				$obj->setIdApresentacao ( $p_Item ['id_apresentacao'] );
				$obj->setTipo ( $p_Item ['tipo'] );
				$obj->setTitulo ( $p_Item ['titulo'] );
				$obj->setConteudo ( $p_Item ['conteudo'] );
				$obj->setAtivo ( trim ( $p_Item ["fl_ativo"] ) );
				$obj->setDataInclusao ( trim ( $p_Item ["data_inclusao"] ) );
				
				return $obj;
			} else
				return null;
		} catch ( Exception $ex ) {
			throw new Exception ( $ex->getMessage (), $ex->getCode () );
		}
	}
	
	/**
	 * função para gravar um novo registro.
	 *
	 * @param object $Modelo
	 *        	O Objeto do tipo do Modelo desta classe
	 * @return boolean $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function salva($obj) {
		try {
			
			// isso ficaria uma porta aberta para um SQL Injection.
			$stmt = $this->_conexao->prepare ( "INSERT INTO cad_apresentacao (data_inclusao, id_usuario_inclusao, tipo, titulo, conteudo, fl_ativo) VALUES (NOW(), ?, ?, ?, ?, 1)" );
			$stmt->bindValue ( 1, $obj->getIdUsuario () );
			$stmt->bindValue ( 2, $obj->getTipo () );
			$stmt->bindValue ( 3, utf8_decode ( $obj->getTitulo () ) );
			$stmt->bindValue ( 4, utf8_decode ( $obj->getConteudo () ) );
			
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
	
	/**
	 * função para retornar um registro pelo Identificador do registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro
	 * @return object $Modelo O Objeto do tipo do Modelo desta classe
	 */
	public function retorna($Id) {
		try {
			
			// preparo a query de update - Prepare Statement
			$query = "SELECT *
						FROM cad_apresentacao 
                        WHERE id_apresentacao=:Id";
			
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
	
	/**
	 * função para atualizar um registro.
	 *
	 * @param object $Modelo
	 *        	O Objeto do tipo do Modelo desta classe
	 * @return boolean $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function atualiza($obj) {
		try {
			
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_apresentacao SET data_alteracao=NOW(), id_usuario_alteracao=?, tipo=?, titulo=?, conteudo=? WHERE id_apresentacao=?" );
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $obj->getTipo () );
			$stmt->bindValue ( 3, utf8_decode ( $obj->getTitulo () ) );
			$stmt->bindValue ( 4, utf8_decode ( $obj->getConteudo () ) );
			$stmt->bindValue ( 5, $obj->getId () );
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				throw new PDOException ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			} else
				return true;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}
	
	/**
	 * função para Remover registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function remove($p_Id) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_apresentacao SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_apresentacao=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $p_Id );
			
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
	
	/**
	 * função para Desativar registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function desativa($p_Id) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_apresentacao SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_apresentacao=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $p_Id );
			
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
	
	/**
	 * função para listar registro
	 *
	 * @param int $page
	 *        	A Página do registros a ser retornarda
	 * @param int $rows
	 *        	A Quantidade de registro a ser retornardo
	 * @param int $sidx
	 *        	O nome do campo a ser Ordendado
	 * @param int $sord
	 *        	A direção da ordenação (ASC ou DESC)
	 * @param int $id_usuario
	 *        	Filtrar pelo Identiicador do usuário
	 * @param int $tipo
	 *        	Filtrar pelo Tipo do Objeto
	 * @param int $titulo
	 *        	Filtrar pelo Titulo do Obejto
	 * @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
	 */
	public function lista($page = null, $rows = null, $sidx = null, $sord = null, $id_usuario = null, $tipo = null, $titulo = null, $conteudo = null) {
		try {
			$filtro = '';
			if (! $sidx)
				$sidx = 1;
			if (! $sord)
				$sord = '';
			if ($sidx == 'IdApresentacao')
				$sidx = 'c.id_apresentacao';
			if ($sidx == 'IdUsuario')
				$sidx = 'c.id_usuario';
			if ($sidx == 'Titulo')
				$sidx = 'c.titulo';
			if ($sidx == 'Tipo')
				$sidx = 'c.tipo';
			if ($sidx == 'DataInclusao')
				$sidx = 'c.data_inclusao';
			if ($tipo)
				$filtro .= " AND c.tipo=$tipo ";
			if ($id_usuario)
				$filtro .= " AND c.id_usuario=$id_usuario ";
			if ($conteudo)
				$filtro .= " AND c.conteudo LIKE '%$conteudo%' ";
			
			$query = "SELECT c.*
						FROM cad_apresentacao c
                        WHERE c.fl_ativo=1 $filtro
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