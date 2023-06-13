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
require_once ("Conteudo.class.php");
class ConteudoDAO extends PDOConnectionFactory {
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
				$obj = new Conteudo ();
				$obj->setId ( $p_Item ['id_conteudo'] );
				$obj->setIdUsuario ( $p_Item ["id_usuario"] );
				$obj->setNomeUsuario ( $p_Item ["nome_usuario"] );
				$obj->setTipo ( $p_Item ["tipo"] );
				$obj->setTitulo ( $p_Item ["titulo"] );
				$obj->setAutores ( $p_Item ["autores"] );
				$obj->setInstituicao ( $p_Item ["instituicao"] );
				$obj->setConteudo ( $p_Item ["conteudo"] );
				$obj->setArquivo ( $p_Item ["arquivo"] );
				$obj->setIdStatus ( trim ( $p_Item ["id_status"] ) );
				$obj->setIdOriginal ( trim ( $p_Item ["id_original"] ) );
				$obj->setRevisao ( $p_Item ["revisao"] );
				$obj->setFlagPolitica ( trim ( $p_Item ['fl_politica'] ) );
				$obj->setAtivo ( trim ( $p_Item ["fl_ativo"] ) );
				
				$obj->setIdUsuarioInclusao ( $p_Item ["id_usuario_inclusao"] );
				$obj->setDataInclusao ( trim ( $p_Item ["data_inclusao"] ) );
				
				// Aprovador
				$obj->setIdUsuarioAprovacao ( $p_Item ["id_usuario_aprovacao"] );
				$obj->setNomeUsuarioAprovacao ( $p_Item ["nome_usuario_aprovacao"] );
				$obj->setDataAprovacao ( trim ( $p_Item ["data_aprovacao"] ) );
				$obj->setObsAprovacao ( trim ( $p_Item ["obs_aprovacao"] ) );
				
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
			$stmt = $this->_conexao->prepare ( "INSERT INTO cad_conteudo (data_inclusao, id_usuario_inclusao, id_usuario, tipo, titulo, autores, instituicao, conteudo, arquivo, revisao, fl_politica, id_status, fl_ativo) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)" );
			$stmt->bindValue ( 1, $obj->getIdUsuario () );
			$stmt->bindValue ( 2, $obj->getIdUsuario () );
			$stmt->bindValue ( 3, $obj->getTipo () );
			$stmt->bindValue ( 4, $obj->getTitulo () );
			$stmt->bindValue ( 5, $obj->getAutores () );
			$stmt->bindValue ( 6, $obj->getInstituicao () );
			$stmt->bindValue ( 7, $obj->getConteudo () );
			$stmt->bindValue ( 8, $obj->getArquivo () );
			$stmt->bindValue ( 9, $obj->getRevisao () );
			$stmt->bindValue ( 10, $obj->getFlagPolitica () );
			$stmt->bindValue ( 11, $obj->getIdStatus () );
			
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
	 * função para Aprovar o registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro desta classe
	 * @param int $p_IdStatus
	 *        	O Identificador do Novo IdStatus do registro desta classe
	 * @param int $p_Obs
	 *        	O Observações do Novo IdStatus do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function aprovar($p_Id, $p_IdStatus, $p_Obs) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_conteudo SET data_aprovacao=NOW(), id_usuario_aprovacao=?, id_status=?, obs_aprovacao=?  WHERE id_conteudo=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $p_IdStatus );
			$stmt->bindValue ( 3, $p_Obs );
			$stmt->bindValue ( 4, $p_Id );
			
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
	
	/**
	 * função para Aprovar o registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro desta classe
	 * @param int $p_IdStatus
	 *        	O Identificador do Novo IdStatus do registro desta classe
	 * @param int $p_Obs
	 *        	O Observações do Novo IdStatus do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function atualizarArquivo($p_Id, $p_Arquivo, $p_IdOriginal, $p_Revisao) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_conteudo SET data_alteracao=NOW(), id_usuario_alteracao=?, arquivo=?, id_original=?, revisao=?  WHERE id_conteudo=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $p_Arquivo );
			$stmt->bindValue ( 3, $p_IdOriginal );
			$stmt->bindValue ( 4, $p_Revisao );
			$stmt->bindValue ( 5, $p_Id );
			
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
			$query = "SELECT c.*, u.nome AS nome_usuario, u1.nome AS nome_usuario_aprovacao
						FROM cad_conteudo c
                        LEFT JOIN cad_usuario u ON c.id_usuario=u.id_usuario
                        LEFT JOIN cad_usuario u1 ON c.id_usuario_aprovacao=u1.id_usuario
                        WHERE c.id_conteudo=:Id";
			
			$consulta = $this->_conexao->prepare ( $query );
			
			// valores encapsulados nas variáveis da classe Conteudo.
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
			$stmt = $this->_conexao->prepare ( "UPDATE cad_conteudo SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_conteudo=?" );
			
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
			$stmt = $this->_conexao->prepare ( "UPDATE cad_conteudo SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_conteudo=?" );
			
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
	 * função para atualiza o Status do registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function atualizaStatus($p_Id, $p_IdStatus) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_conteudo SET data_alteracao=NOW(), id_usuario_alteracao=?, id_status=? WHERE id_usuario=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $p_IdStatus );
			$stmt->bindValue ( 3, $p_Id );
			
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
	public function lista($page = null, $rows = null, $sidx = null, $sord = null, $id_usuario = null, $tipo = null, $titulo = null, $nome_usuario = null) {
		try {
			$filtro = '';
			if (! $sidx)
				$sidx = 1;
			if (! $sord)
				$sord = '';
			if ($sidx == 'IdConteudo')
				$sidx = 'c.id_conteudo';
			if ($sidx == 'IdUsuario')
				$sidx = 'c.id_usuario';
			if ($sidx == 'Titulo')
				$sidx = 'c.titulo';
			if ($sidx == 'Tipo')
				$sidx = 'c.tipo';
			if ($sidx == 'DataInclusao')
				$sidx = 'c.data_inclusao';
			if ($sidx == 'NomeUsuario')
				$sidx = 'u.nome';
			if ($tipo)
				$filtro .= " AND c.tipo=$tipo ";
			if ($id_usuario)
				$filtro .= " AND c.id_usuario=$id_usuario ";
			if ($nome_usuario)
				$filtro .= " AND u.nome LIKE '%$nome_usuario%' ";
			
			$query = "SELECT c.*, u.nome AS nome_usuario, u1.nome AS nome_usuario_aprovacao
						FROM cad_conteudo c
                        LEFT JOIN cad_usuario u ON c.id_usuario=u.id_usuario
                        LEFT JOIN cad_usuario u1 ON c.id_usuario_aprovacao=u1.id_usuario
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