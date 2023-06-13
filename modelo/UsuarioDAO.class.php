<?php
/**
* @description Classe DAO para a tabela Usuario. Data Access Object que irá fazer operações na tabela Usuario (básica: Insert, Update, Delete e Lista)
* @author Kellen Nery
* @date 26/03/2013
* @version 1.2
* @package MDS
* @copyright www.asasolucoes.com
*/

// Includes
require_once ("PDOConnectionFactory.class.php");
require_once ("Usuario.class.php");
class UsuarioDAO extends PDOConnectionFactory {
	// irá receber uma conexão
	private $_conexao = null;
	private $_mensagem = null;
	private $_erro = null;
	private $_idUsuario = null;
	
	/**
	 * Contrutores
	 */
	function __construct() {
		try {
			$this->_conexao = self::getConnection ();
			$this->_mensagem = '';
			$this->_idUsuario = (isset ( $_SESSION ['USO_ID'] )) ? $_SESSION ['USO_ID'] : 1;
		} catch ( PDOException $ex ) {
			echo "Erro: " . $ex->getMessage ();
		}
	}
	function __destruct() {
		$this->_conexao = null;
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
				$obj = new Usuario ();
				$obj->setId ( $p_Item ['id_usuario'] );
				$obj->setIdTipoUsuario ( $p_Item ['id_tipo_usuario'] );
				$obj->setIdStatusUsuario ( $p_Item ['id_status_usuario'] );
				$obj->setIdPais ( $p_Item ['id_pais'] );
				$obj->setIdEstado ( $p_Item ['id_estado'] );
				$obj->setNome ( trim ( $p_Item ['nome'] ) );
				$obj->setSenha ( trim ( $p_Item ['senha'] ) );
				$obj->setEmail ( trim ( $p_Item ['email'] ) );
				$obj->setCpf ( $p_Item ['cpf'] );
				$obj->setDataNascimento ( $p_Item ['data_nascimento'] );
				$obj->setFlagColaborador ( trim ( $p_Item ['fl_colaborador'] ) );
				$obj->setViceDiretoria ( trim ( $p_Item ['vice_diretoria'] ) );
				$obj->setDepartamento ( trim ( $p_Item ['departamento'] ) );
				$obj->setDivisao ( trim ( $p_Item ['divisao'] ) );
				$obj->setSecao ( trim ( $p_Item ['secao'] ) );
				$obj->setUnidadeExterna ( trim ( $p_Item ['unidade_externa'] ) );
				$obj->setAreaAtuacao ( trim ( $p_Item ['area_atuacao'] ) );
				$obj->setCidade ( trim ( $p_Item ['cidade'] ) );
				$obj->setTelefone ( trim ( $p_Item ['telefone'] ) );
				$obj->setTotalAcesso ( $p_Item ['total_acesso'] );
				$obj->setDataAcesso ( $p_Item ['data_acesso'] );
				$obj->setCanalComunicacao ( trim ( $p_Item ['canal_comunicacao'] ) );
				$obj->setFlagPolitica ( trim ( $p_Item ['fl_politica'] ) );
				$obj->setFormacaoAcademica ( $p_Item ['formacao_academica'] );
				$obj->setFlagResumo ( $p_Item ['fl_resumo'] );
				
				$obj->setDataInclusao ( $p_Item ['data_inclusao'] );
				$obj->setPerfil ( $p_Item ['perfil'] );
				$obj->setGerente ( $p_Item ['fl_gerente'] );
				$obj->setAdmin ( $p_Item ['fl_admin'] );
				$obj->setAtivo ( $p_Item ['fl_ativo'] );
				$obj->setAutorizadoPor ( $p_Item ['autorizadoPor'] );
				$obj->setNomeChefiaImediata ( $p_Item ['NomeChefiaImediata'] );
				$obj->setNomeGerenteDepartamento ( $p_Item ['NomeGerenteDepartamento'] );
				$obj->setNomeViceDiretoria ( $p_Item ['NomeViceDiretoria'] );
				
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
			$stmt = $this->_conexao->prepare ( "INSERT INTO cad_usuario (data_inclusao, id_usuario_inclusao, id_tipo_usuario, id_status_usuario, id_pais, id_estado, nome, cpf, email, senha, fl_colaborador, unidade_externa, vice_diretoria, departamento, divisao, secao, area_atuacao, telefone, canal_comunicacao, fl_politica, formacao_academica, fl_resumo, perfil, fl_gerente, fl_ativo, data_nascimento, autorizadoPor, NomeChefiaImediata, NomeGerenteDepartamento, NomeViceDiretoria) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $obj->getIdTipoUsuario () );
			$stmt->bindValue ( 3, $obj->getIdStatusUsuario () );
			$stmt->bindValue ( 4, $obj->getIdPais () );
			$stmt->bindValue ( 5, $obj->getIdEstado () );
			$stmt->bindValue ( 6, $obj->getNome () );
			$stmt->bindValue ( 7, $obj->getCpf () );
			$stmt->bindValue ( 8, $obj->getEmail () );
			$stmt->bindValue ( 9, $obj->getSenha () );
			$stmt->bindValue ( 10, $obj->getFlagColaborador () );
			$stmt->bindValue ( 11, $obj->getUnidadeExterna () );
			$stmt->bindValue ( 12, $obj->getViceDiretoria () );
			$stmt->bindValue ( 13, $obj->getDepartamento () );
			$stmt->bindValue ( 14, $obj->getDivisao () );
			$stmt->bindValue ( 15, $obj->getSecao () );
			$stmt->bindValue ( 16, $obj->getAreaAtuacao () );
			$stmt->bindValue ( 17, $obj->getTelefone () );
			$stmt->bindValue ( 18, $obj->getCanalComunicacao () );
			$stmt->bindValue ( 19, $obj->getFlagPolitica () );
			$stmt->bindValue ( 20, $obj->getFormacaoAcademica () );
			$stmt->bindValue ( 21, $obj->getFlagResumo () );
			$stmt->bindValue ( 22, $obj->getPerfil () );
			$stmt->bindValue ( 23, $obj->getGerente () );
			$stmt->bindValue ( 24, $obj->getAtivo () );
			
			if ($obj->getDataNascimento ()) {
				$stmt->bindValue ( 25, $obj->getDataNascimento () );
			} else {
				$stmt->bindValue ( 25, null );
			}
			
			// executo a query preparada
			
			$stmt->bindValue ( 26, $obj->getAutorizadoPor () );
			$stmt->bindValue ( 27, $obj->getNomeChefiaImediata () );
			$stmt->bindValue ( 28, $obj->getNomeGerenteDepartamento () );
			$stmt->bindValue ( 29, $obj->getNomeViceDiretoria () );
			
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				throw new Exception ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
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
	public function retorna($p_Id) {
		try {
			
			// preparo a query
			$consulta = $this->_conexao->prepare ( "SELECT u.*, e.sigla AS uf, e.nome AS nome_estado FROM cad_usuario u LEFT JOIN cad_estado e ON e.id_estado=u.id_estado WHERE u.id_usuario=?" );
			
			// valores encapsulados nas variáveis da classe Usuario.
			// sequencia de índices que representa cada valor de minha query
			$consulta->bindValue ( 1, $p_Id );
			
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
	 * função para retornar um registro pelo Identificador do registro.
	 *
	 * @param string $p_Email
	 *        	O e-mail do registro
	 * @return object $Modelo O Objeto do tipo do Modelo desta classe
	 */
	public function retornaPorEmail($p_Email) {
		try {
			
			// preparo a query
			$consulta = $this->_conexao->prepare ( "SELECT * FROM cad_usuario WHERE email=:email" );
			
			// valores encapsulados nas variáveis da classe Usuario.
			// sequencia de índices que representa cada valor de minha query
			$consulta->bindParam ( ':email', $p_Email );
			
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
			$stmt = $this->_conexao->prepare (
				 "UPDATE cad_usuario SET data_alteracao=NOW(), id_usuario_alteracao=?, id_tipo_usuario=?, id_status_usuario=?, ".
					" id_pais=?, id_estado=?, nome=?, cpf=?, email=?, senha=?, fl_colaborador=?, unidade_externa=?, vice_diretoria=?, departamento=?, ".
					" divisao=?, secao=?, area_atuacao=?, telefone=?, canal_comunicacao=?, fl_politica=?, formacao_academica=?, fl_resumo=?, perfil=?, ".
					" fl_gerente=?, fl_ativo=?, data_nascimento=?, autorizadoPor=?, NomeChefiaImediata=?, ".
					" NomeGerenteDepartamento=?, NomeViceDiretoria=? WHERE id_usuario=?" );
			                                                                                                                                                                                                                                                                                                                                                                                    
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $obj->getIdTipoUsuario () );
			$stmt->bindValue ( 3, $obj->getIdStatusUsuario () );
			$stmt->bindValue ( 4, $obj->getIdPais () );
			$stmt->bindValue ( 5, $obj->getIdEstado () );
			$stmt->bindValue ( 6, utf8_decode ( $obj->getNome () ) );
			$stmt->bindValue ( 7, utf8_decode ( $obj->getCpf () ) );
			$stmt->bindValue ( 8, utf8_decode ( $obj->getEmail () ) );
			$stmt->bindValue ( 9, $obj->getSenha () );
			$stmt->bindValue ( 10, $obj->getFlagColaborador () );
			$stmt->bindValue ( 11, $obj->getUnidadeExterna () );
			$stmt->bindValue ( 12, $obj->getViceDiretoria () );
			$stmt->bindValue ( 13, $obj->getDepartamento () );
			$stmt->bindValue ( 14, $obj->getDivisao () );
			$stmt->bindValue ( 15, $obj->getSecao () );
			$stmt->bindValue ( 16, $obj->getAreaAtuacao () );
			$stmt->bindValue ( 17, $obj->getTelefone () );
			$stmt->bindValue ( 18, $obj->getCanalComunicacao () );
			$stmt->bindValue ( 19, $obj->getFlagPolitica () );
			$stmt->bindValue ( 20, $obj->getFormacaoAcademica () );
			$stmt->bindValue ( 21, $obj->getFlagResumo () );
			$stmt->bindValue ( 22, $obj->getPerfil () );
			$stmt->bindValue ( 23, $obj->getGerente () );
			$stmt->bindValue ( 24, $obj->getAtivo () );
			if ($obj->getDataNascimento ()) {
				$stmt->bindValue ( 25, $obj->getDataNascimento () );
			} else {
				$stmt->bindValue ( 25, null );
			}
				
			// executo a query preparada
				
			$stmt->bindValue ( 26, $obj->getAutorizadoPor () );
			$stmt->bindValue ( 27, $obj->getNomeChefiaImediata () );
			$stmt->bindValue ( 28, $obj->getNomeGerenteDepartamento () );
			$stmt->bindValue ( 29, $obj->getNomeViceDiretoria () );
			$stmt->bindValue ( 30, $obj->getId () );
			
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
	 * função para validar Usuário e Senha do registro.
	 *
	 * @param string $p_Email
	 *        	O Email do registros a ser validado
	 * @param string $p_Senha
	 *        	A Senha do registro a ser validado
	 * @return boolean $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function validaUsuario($p_Email, $p_Senha) {
		$p_Email = trim ( $p_Email );
		if (strlen ( $p_Email ) < 6) // Verifica se pelo menos tem mais 6 letras 'a@a.br'
			throw new Exception ( '<b>Acesso negado.</b><br/>O e-mail <b>' . $p_Email . '</b> é inválido.' );
		
		try {
			
			// preparo a query de update - Prepare Statement
			$consulta = $this->_conexao->prepare ( "SELECT * FROM cad_usuario WHERE (email=:email)" );
			
			// sequencia de índices que representa cada valor de minha query
			$consulta->bindParam ( ':email', $p_Email );
			
			// executo a query preparada
			$consulta->execute ();
			
			$linha = $consulta->fetch ( PDO::FETCH_ASSOC );
		} catch ( PDOException $ex ) {
			throw new Exception ( $ex->getMessage () );
		}
		
		// Valida Usuario;
		if ($linha) {
			// Valida Senha do usário
			if (trim ( $linha ['senha'] ) == trim ( $p_Senha )) {
				// Valida se registro ativo
				if ($linha ['fl_ativo'] == 1) {
					// Usuario OK
					return $this->retorna ( $linha ['id_usuario'] );
				} else
					throw new Exception ( 'Erro: 184 - O usuário ou senha está incorreto.' );
			} else
				throw new Exception ( 'Erro: 185 - O usuário ou senha está incorreto.' );
		} else
			throw new Exception ( 'Erro: 186 - O usuário ou senha está incorreto.' );
	}
	
	/**
	 * função para atualizar a senha do registro.
	 *
	 * @param object $Modelo
	 *        	O Objeto do tipo do Modelo desta classe
	 * @return boolean $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function atualizaSenha($obj) {
		try {
			
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_usuario SET data_alteracao=NOW(), id_usuario_alteracao=?, senha=? WHERE id_usuario=?" );
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $obj->getSenha () );
			$stmt->bindValue ( 3, $obj->getId () );
			
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
	 * função para registrar acesso ao portal.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro desta classe
	 * @return boolean $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function registaAcesso($p_Id) {
		try {
			
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_usuario SET data_acesso=NOW(), total_acesso=total_acesso+1 WHERE id_usuario=?" );
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $p_Id );
			
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
	 * função para Remover registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function remove($p_Id) {
		try {
			// executo a query
			$num = $this->_conexao->exec ( "DELETE FROM cad_usuario WHERE id_usuario=$p_Id" );
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
			$stmt = $this->_conexao->prepare ( "UPDATE cad_usuario SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_usuario=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $p_Id );
			
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
	 * função para atualiza o Status do registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function atualizaStatus($p_Id, $p_IdStatusUsuario) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_usuario SET data_alteracao=NOW(), id_usuario_alteracao=?, id_status_usuario=? WHERE id_usuario=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $this->_idUsuario );
			$stmt->bindValue ( 2, $p_IdStatusUsuario );
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
	 * @param int $id_tipo
	 *        	Filtrar pelo Tipo do Objeto
	 * @param int $id_status
	 *        	Filtrar pelo Status do Obejto
	 * @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
	 */
	public function lista($page = null, $rows = null, $sidx = null, $sord = null, $id_tipo = null, $id_status = null, $fl_resumo = null, $id_estado = null, $nome = null, $email = null, $cpf = null, $perfil = null) {
		try {
			$filtro = '';
			if ($sidx == 'IdUsuario')
				$sidx = 'id_usuario';
			if ($sidx == 'DataInclusao')
				$sidx = 'u.data_inclusao';
			if ($sidx == 'TotalAcesso')
				$sidx = 'u.total_acesso';
			if ($sidx == 'DataAcesso')
				$sidx = 'u.data_acesso';
			if ($sidx == 'FlagResumo')
				$sidx = 'u.fl_resumo';
			if ($id_tipo)
				$filtro .= " AND u.id_tipo_usuario=$id_tipo ";
			if ($id_status)
				$filtro .= " AND u.id_status_usuario=$id_status ";
			if (($fl_resumo == '0') || ($fl_resumo == '1'))
				$filtro .= " AND u.fl_resumo=$fl_resumo ";
			if ($id_estado)
				$filtro .= " AND u.id_estado=$id_estado ";
			if ($nome)
				$filtro .= " AND u.nome LIKE '%$nome%' ";
			if ($email)
				$filtro .= " AND u.email LIKE '%$email%' ";
			if ($cpf)
				$filtro .= " AND u.cpf LIKE '%$cpf%' ";
			if ($perfil)
				$filtro .= " AND (u.perfil > 0) ";
			
			$query = "SELECT u.*, e.sigla AS uf, e.nome AS nome_estado 
                        FROM cad_usuario u
						LEFT JOIN cad_estado e ON e.id_estado=u.id_estado 
                        WHERE u.fl_ativo=1 and u.id_usuario <> 343 and u.id_usuario <> 374 and u.id_usuario <> 373 and u.id_usuario <> 372 $filtro
                        ORDER BY $sidx $sord";
			
			// Paginação
			if ($rows) {
				$queryCount = "SELECT count(*) AS count
							FROM cad_usuario u
							WHERE u.fl_ativo=1 $filtro";
				$rsCount = $this->_conexao->prepare ( $queryCount );
				$rsCount->execute ();
				$item = $rsCount->fetch ( PDO::FETCH_ASSOC );
				if ($item) {
					self::setTotalRegistros ( $item ['count'] );
				}
				$query .= self::definirPaginacao ( $page, $rows );
			}
			
			$rs = $this->_conexao->query ( $query );
			// echo $query;
			if ($rs) {
				$listagem = array ();
				foreach ( $rs as $item ) {
					$listagem [] = self::carregarModelo ( $item );
				}
				return $listagem;
			} else {
				$this->_erro = $this->_conexao->errorInfo ();
				throw new Exception ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			}
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return null;
		}
	}
}
?>