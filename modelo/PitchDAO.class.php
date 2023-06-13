<?php
/**
* @description Classe DAO para a tabela Pitch. Data Access Object que irá fazer operações na tabela Usuario (básica: Insert, Update, Delete e Lista)
* @date 08/05/2020
*/

// Includes
require_once ("PDOConnectionFactory.class.php");
require_once ("Pitch.class.php");

class PitchDAO extends PDOConnectionFactory {
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
				$obj = new Pitch();
				$obj->setId( $p_Item ["id_pitch"] );
				$obj->setIdParticipante( $p_Item ["id_participante"] );
				$obj->setNomeCompleto( $p_Item ["nome_completo"] );
				$obj->setCpf( $p_Item ["cpf"] );
				$obj->setPassaporte( $p_Item ["passaporte"] );
				$obj->setEmail( $p_Item ["email"] );
				$obj->setTelefone( $p_Item ["telefone"] );
				$obj->setIdEvento( $p_Item ["id_evento_principal"] );
				$obj->setNomeEvento( $p_Item ["nome_evento"] );
				$obj->setDescricao( $p_Item ["descricao"] );
				$obj->setWebsite( $p_Item ["website"] );
				$obj->setTipoSolucao( $p_Item ["tipo_solucao"] );
				$obj->setProblema( $p_Item ["problema"] );
				$obj->setSolucao( $p_Item ["solucao"] );
				$obj->setRelevancia( $p_Item ["relevancia"] );
				$obj->setModeloNegocios( $p_Item ["modelo_negocios"] );	
				$obj->setEquipe( $p_Item ["equipe"] );	
				$obj->setFase( $p_Item ["fase"] );
				$obj->setMetas( $p_Item ["metas"] );
				$obj->setInnovation( $p_Item ["innovation"] );	
				$obj->setLinks( $p_Item ["links"] );
				$obj->setStatus( $p_Item ["status"] );
				$obj->setDataCadastro( $p_Item ["data_cadastro"] );
				$obj->setAcao( $p_Item ["acao"] );
				$obj->setDataAcao( $p_Item ["data_acao"] );
				$obj->setIdUsuarioAcao( $p_Item ["id_usuario_acao"] );	
				$obj->setNomeUsuarioAcao( $p_Item ["usuario_acao_pessoa"]  ? $p_Item ["usuario_acao_pessoa"] : $p_Item ["usuario_acao_usuario"] );
				//$obj->setNomeUsuarioAcao( $p_Item ["nome_usuario_acao"] );
				$obj->setRevisao( $p_Item ["revisao"] );
				$obj->setAtivo( $p_Item ["ativo"] );
				$obj->setChave(isset($p_Item["chave"])? $p_Item["chave"]: '');		
				$obj->setReferencia( $p_Item ["referencia"] );
				$obj->setDataApresentacao( $p_Item ["data_apresentacao"] );
				$obj->setHoraApresentacao( $p_Item ["hora_apresentacao"] );
				$obj->setObservacao(isset($p_Item["chave"])? $p_Item["observacao"]: '');	
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
            // Preparo a query
            $query = "INSERT INTO cad_pitch "
						."( id_participante"
						.", id_evento_principal"
						.", descricao"
						.", website"
						.", tipo_solucao"
						.", problema"
						.", solucao"
						.", relevancia"
						.", modelo_negocios"
						.", equipe"
						.", fase"
						.", metas"
						.", innovation"
						.", links"
						.", status"
						.", data_cadastro"
						.", acao"
						.", data_acao"
						.", id_usuario_acao"
						.", revisao"
						.", ativo"
						.", chave)"
                    ." VALUES "
						."( :IdParticipante"
						.", :IdEventoPrincipal"
						.", :Descricao"
						.", :Website"
						.", :TipoSolucao"
						.", :Problema"
						.", :Solucao"
						.", :Relevancia"
						.", :ModeloNegocios"
						.", :Equipe"
						.", :Fase"
						.", :Metas"
						.", :Innovation"
						.", :Links"
						.", :Status"
						.", :DataCadastro"
						.", :Acao"
						.", NOW()"
						.", :IdUsuarioAcao"
						.", :Revisao"
						.", 1"
						.", :Chave)";
					
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
			$stmt->bindValue(':IdParticipante',		$obj->getIdParticipante());
			$stmt->bindValue(':IdEventoPrincipal',	$obj->getIdEvento());
			$stmt->bindValue(':Descricao',			utf8_decode($obj->getDescricao()));
			$stmt->bindValue(':Website',			utf8_decode($obj->getWebsite()));
			$stmt->bindValue(':TipoSolucao',		$obj->getTipoSolucao());
			$stmt->bindValue(':Problema',			utf8_decode($obj->getProblema()));
			$stmt->bindValue(':Solucao',			utf8_decode($obj->getSolucao()));
			$stmt->bindValue(':Relevancia',			utf8_decode($obj->getRelevancia()));
			$stmt->bindValue(':ModeloNegocios',		utf8_decode($obj->getModeloNegocios()));
			$stmt->bindValue(':Equipe',				utf8_decode($obj->getEquipe()));
			$stmt->bindValue(':Fase',				$obj->getFase());
			$stmt->bindValue(':Metas',				utf8_decode($obj->getMetas()));
			$stmt->bindValue(':Innovation',			utf8_decode($obj->getInnovation()));
			$stmt->bindValue(':Links',				utf8_decode($obj->getLinks()));
			$stmt->bindValue(':Status',				$obj->getStatus());
			$stmt->bindValue(':DataCadastro',		$obj->getDataCadastro());
			$stmt->bindValue(':Acao',				utf8_decode($obj->getAcao()));
			$stmt->bindValue(':IdUsuarioAcao',		$obj->getIdUsuarioAcao());
			$stmt->bindValue(':Revisao',			$obj->getRevisao());
			$stmt->bindValue(':Chave',              $obj->getChave ());
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo();
				if (isset($this->_erro[2])) $this->_mensagem = '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2];
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
			$query = "SELECT p.*, pe.nome_completo, pe.email, pe.telefone, pe.cpf, pe.passaporte, u.email AS usuario_acao_pessoa, 
			                 cadu.email AS usuario_acao_usuario, e.nome as nome_evento
						FROM cad_pitch p
                        LEFT JOIN cad_pessoa pe ON p.id_participante=pe.id
                        LEFT JOIN m5wat_users u ON p.id_usuario_acao=u.id
						LEFT JOIN cad_usuario cadu ON p.id_usuario_acao=cadu.id_usuario
						LEFT JOIN cad_evento e ON p.id_evento_principal=e.id_evento
                        WHERE p.id_pitch=:Id";
			
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
	public function lista($page = null, $rows = null, $sidx = null, $sord = null, $idEvento = null, $id_usuario = null, $tipo = null, $titulo = null, $nome_usuario = null, $id_status = null) {

		try {
			
			$filtro = '';
			if (! $sidx)
				$sidx = 1;

			if (! $sord)
				$sord = '';
			if ($sidx == 'IdPitch')
				$sidx = 'pi.id_pitch';
			if ($sidx == 'Titulo')
				$sidx = 'pi.descricao';
			if ($sidx == 'Status')
				$sidx = 'pi.status';
			if ($sidx == 'TipoSolucao')
				$sidx = 'pi.tipo_solucao';
			if ($sidx == 'DataInclusao')
				$sidx = 'pi.data_acao';
			if ($sidx == 'NomeUsuario')
				$sidx = 'p.nome_completo';

            $filtro .= " AND pi.id_evento_principal=(select id_parente from cad_evento where id_evento = $idEvento) ";
			if ($tipo)
				$filtro .= " AND pi.tipo_solucao=$tipo ";
			if ($id_usuario)
				$filtro .= " AND pi.id_participante=$id_usuario ";
			if ($titulo)
				$filtro .= " AND pi.descricao LIKE '%$titulo%' ";
			if ($id_status)
				$filtro .= " AND pi.status=$id_status ";
			if ($nome_usuario)
				$filtro .= " AND p.nome_completo LIKE '%$nome_usuario%' ";	
			
			$query = "SELECT pi.*, p.nome_completo, p.cpf, p.passaporte, p.email, p.telefone, 
			                 u.nome as nome_usuario_acao, e.nome as nome_evento, pi.revisao as revisao  
						FROM cad_pitch pi
                        LEFT JOIN cad_pessoa p ON pi.id_participante=p.id
						LEFT JOIN cad_usuario u ON pi.id_usuario_acao=u.id_usuario
						LEFT JOIN cad_evento e ON pi.id_evento_principal=e.id_evento
                        WHERE pi.ativo=1 $filtro
                        ORDER BY $sidx $sord";
			
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
	
	/**
	 * função para Remover registro.
	 *
	 * @param int $p_Id, O Identificador do registro desta classe
	 * @param string $p_Acao, que diz a origem da remoção do registro (alteração, exclusão)
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function remove($p_Id) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_pitch SET data_acao=NOW(), id_usuario_acao=?, ativo=0 WHERE id_pitch=?" );
			
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
	 * função para Remover registro.
	 *
	 * @param int $p_Id, O Identificador do registro desta classe
	 * @param string $p_Acao, que diz a origem da remoção do registro (alteração, exclusão)
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function submete($p_Id) {
		try {
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_pitch SET data_acao=NOW(), id_usuario_acao=?, status=2 WHERE id_pitch=?" );
			
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
	 * função para Contar registros.
	 *
	 * @param int $p_IdUsuario
	 * @param $p_IdEvento	 
	 * @return o número de registros
	 */
	public function conta($p_IdUsuario, $p_IdEvento) {

		try {
			
			// preparo a query de update - Prepare Statement
			$query = "Select COUNT(*) from cad_pitch WHERE id_participante=:IdUsuario and id_evento_principal=:IdEventoPrincipal and ativo=1";
			$consulta = $this->_conexao->prepare ( $query );
			
			// valores encapsulados nas variáveis da classe Resumo.
			$consulta->bindParam ( ':IdUsuario', 			$p_IdUsuario );
			$consulta->bindParam ( ':IdEventoPrincipal', 	$p_IdEvento );
			
			// executo a query preparada
			$consulta->execute ();
			
			$item = $consulta->fetch ( PDO::FETCH_ASSOC );
			if ($item) {
				return $item;
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
	 * função para listar registro
	 *
	 * @param int $page A Página do registros a ser retornarda
	 * @param int $rows A Quantidade de registro a ser retornardo
	 * @param int $sidx O nome do campo a ser Ordendado
	 * @param int $sord A direção da ordenação (ASC ou DESC)
	 * @param int $id_usuario Filtrar pelo Identiicador do usuário
	 * @param int $tipo Filtrar pelo Tipo do Objeto
	 * @param int $titulo Filtrar pelo Titulo do Obejto
	 * @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
	 */
	public function listarHistorico($page=null, $rows=null, $sidx=null, $sord=null, $Chave=null){
		try {
			$filtro = '';
			if (!$sidx){ $sidx=1;}
			if (!$sord){ $sord='DESC';}
			if ($sidx == 'TipoSolucao'){ $sidx = 'p.tipo_solucao';}
			if ($sidx == 'IdPitch'){ $sidx = 'p.id_picth';}
			if ($sidx == 'Descricao'){ $sidx = 'p.descricao';}
			if ($sidx == 'Status'){ $sidx = 'p.status';}
			if ($sidx == 'DataInclusao'){ $sidx = 'p.data_cadastro';}
            
			if ($Chave!=''){
                $filtro .= " AND p.chave='$Chave' ";
			
                $query = "SELECT p.*
                            FROM cad_pitch p
                            WHERE p.ativo=0 $filtro
                            ORDER BY $sidx $sord";
                $this->_query = $query;
                $rs = $this->_conexao->query ( $query );
                
                // Paginacao
                if ($rows){
                    $queryCount= "SELECT count(e.*) AS count "
                                ." FROM cad_evento e "
                                ." INNER JOIN cad_tipo_evento p ON p.id_tipo_evento=e.id_tipo_evento "
                                ." LEFT JOIN cad_localizacao r ON r.id_localizacao=e.id_localizacao "
                                ." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
                                ." WHERE e.deletado=false $filtro ";
                    $rsCount = $this->_conexao->prepare($queryCount);
                    $rsCount->execute();
                    $item = $rsCount->fetch(PDO::FETCH_ASSOC);                
                    if($item){
                        self::setTotalRegistros($item['count']);
                    }
                    //$query .= self::definirPaginacao($page, $rows);
                    $query .= " LIMIT $p_Linhas OFFSET $p_Pagina;"; 
                }
                
                // Preparo a query
                $stmt = $this->_conexao->prepare($query);

                // Executa a query preparada
                if ($stmt->execute()){
                    $this->_query = $stmt->queryString;
                    $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if($rs){
                        $listagem = array();
                        foreach ($rs as $item){
                            $listagem[] = self::carregarModelo($item);
                        }
                        return $listagem;
                    } else {
                        $arrError = $stmt->errorInfo();
                        $this->_erro = ($arrError[0])? $arrError[0]: $arrError[1];
                        $this->_mensagem = 'PDO-'.$arrError[2];
                        return null;
                    }
                } else {
                    $arrError = $stmt->errorInfo();
                    $this->_erro = ($arrError[0])? $arrError[0]: $arrError[1];
                    $this->_mensagem = 'PDO-'.$arrError[2];
                }
            } else {
                return null;
            }
		} catch (PDOException $ex){ throw $ex; }
	}	
	
	/**
	 * função para Alterar o status do Pitch.
	 *
	 * @param int $p_Id O Identificador do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function alterarStatus($p_Id, $p_IdStatus, $p_DescricaoStatus=null, $p_Observacao=null, $Referencia=null, $DataApresentacao=null, $HoraApresentacao=null) {
		try {
			
			// preparo a query de update - Prepare Statement	
            $query = "UPDATE cad_pitch "
                        ." SET data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao, status=:IdStatus, observacao=:Observacao ";
            $query .= ", referencia='$Referencia'";
            $query .= ($DataApresentacao)? ", data_apresentacao='$DataApresentacao'": ", data_apresentacao=null";
			$query .= ($HoraApresentacao)? ", hora_apresentacao='$HoraApresentacao'": ", hora_apresentacao=null";
            $query .= ", acao='$p_DescricaoStatus'";
            $query .= " WHERE id_pitch=:Id";
 
			$stmt = $this->_conexao->prepare($query);
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue(':IdUsuarioAcao', 5);
			$stmt->bindValue(':IdStatus', $p_IdStatus);
			$stmt->bindValue(':Observacao', $p_Observacao);
			$stmt->bindValue(':Id', $p_Id);			
						
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
	
}
?>

