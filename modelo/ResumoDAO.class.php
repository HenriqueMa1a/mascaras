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
require_once ("Resumo.class.php");

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
				$obj = new Resumo ();
				$obj->setId ( isset($p_Item ['id_resumo']) ? $p_Item ['id_resumo'] : '' );
                $obj->setChave(isset($p_Item["chave"])? $p_Item["chave"]: '');
				$obj->setIdUsuario ( isset($p_Item ["id_usuario"]) ?  $p_Item ["id_usuario"] : '' );
				$obj->setNomeUsuario ( isset($p_Item ["nome_usuario"])? $p_Item ["nome_usuario"]: '' );
				$obj->setTipo ( isset($p_Item ["tipo"]) ? $p_Item ["tipo"] : '' );
				$obj->setAno ( isset($p_Item ["ano"]) ?  $p_Item ["ano"] : '' ); 
				$obj->setIdEvento ( isset($p_Item ["id_evento"]) ?  $p_Item ["id_evento"] : '' );
				$obj->setTitulo ( isset($p_Item ["titulo"]) ? $p_Item ["titulo"] : '' );
				$obj->setAutor1 ( isset($p_Item ["autor1"]) ? $p_Item ["autor1"] : '' );
				$obj->setAutor2 ( isset($p_Item ["autor2"]) ? $p_Item ["autor2"] : '' );
				$obj->setAutor3 ( isset($p_Item ["autor3"]) ? $p_Item ["autor3"] : '' );
				$obj->setAutor4 ( isset($p_Item ["autor4"]) ? $p_Item ["autor4"] : '' );
				$obj->setAutor5 ( isset($p_Item ["autor5"]) ? $p_Item ["autor5"] : '' );
				$obj->setAutor6 ( isset($p_Item ["autor6"]) ? $p_Item ["autor6"] : '' );
				$obj->setAutor7 ( isset($p_Item ["autor7"]) ? $p_Item ["autor7"] : '' );
				$obj->setAutor8 ( isset($p_Item ["autor8"]) ? $p_Item ["autor8"] : '' );
				$obj->setAutor9 ( isset($p_Item ["autor9"]) ? $p_Item ["autor9"] : '' );
				$obj->setAutor10 ( isset($p_Item ["autor10"]) ? $p_Item ["autor10"] : '' );
				$obj->setInstituicao1 ( isset($p_Item ["instituicao1"]) ? $p_Item ["instituicao1"] : '' );
				$obj->setInstituicao2 ( isset($p_Item ["instituicao2"]) ? $p_Item ["instituicao2"] : '' );
				$obj->setInstituicao3 ( isset($p_Item ["instituicao3"]) ? $p_Item ["instituicao3"] : '' );
				$obj->setInstituicao4 ( isset($p_Item ["instituicao4"]) ? $p_Item ["instituicao4"] : '' );
				$obj->setInstituicao5 ( isset($p_Item ["instituicao5"]) ? $p_Item ["instituicao5"] : '' );
				$obj->setInstituicao6 ( isset($p_Item ["instituicao6"]) ? $p_Item ["instituicao6"] : '' );
				$obj->setInstituicao7 ( isset($p_Item ["instituicao7"]) ? $p_Item ["instituicao7"] : '' );
				$obj->setInstituicao8 ( isset($p_Item ["instituicao8"]) ? $p_Item ["instituicao8"] : '' );
				$obj->setInstituicao9 ( isset($p_Item ["instituicao9"]) ? $p_Item ["instituicao9"] : '' );
				$obj->setInstituicao10 ( isset($p_Item ["instituicao10"]) ? $p_Item ["instituicao10"] : '' );
				$obj->setEmail1 ( isset($p_Item ["email1"]) ? $p_Item ["email1"] : '' );
				$obj->setEmail2 ( isset($p_Item ["email2"]) ? $p_Item ["email2"] : '' );
				$obj->setEmail3 ( isset($p_Item ["email3"]) ? $p_Item ["email3"] : '' );
				$obj->setEmail4 ( isset($p_Item ["email4"]) ? $p_Item ["email4"] : '' );
				$obj->setEmail5 ( isset($p_Item ["email5"]) ? $p_Item ["email5"] : '' );
				$obj->setEmail6 ( isset($p_Item ["email6"]) ? $p_Item ["email6"] : '' );
				$obj->setEmail7 ( isset($p_Item ["email7"]) ? $p_Item ["email7"] : '' );
				$obj->setEmail8 ( isset($p_Item ["email8"]) ? $p_Item ["email8"] : '' );
				$obj->setEmail9 ( isset($p_Item ["email9"]) ? $p_Item ["email9"] : '' );
				$obj->setEmail10 ( isset($p_Item ["email10"]) ? $p_Item ["email10"] : '' );
				$obj->setApresentador1 ( isset($p_Item ["fl_apresentador1"]) ? $p_Item ["fl_apresentador1"] : '');
				$obj->setApresentador2 ( isset($p_Item ["fl_apresentador2"]) ? $p_Item ["fl_apresentador2"] : '');
				$obj->setApresentador3 ( isset($p_Item ["fl_apresentador3"]) ? $p_Item ["fl_apresentador3"] : '');
				$obj->setApresentador4 ( isset($p_Item ["fl_apresentador4"]) ? $p_Item ["fl_apresentador4"] : '');
				$obj->setApresentador5 ( isset($p_Item ["fl_apresentador5"]) ? $p_Item ["fl_apresentador5"] : '');
				$obj->setApresentador6 ( isset($p_Item ["fl_apresentador6"]) ? $p_Item ["fl_apresentador6"] : '');
				$obj->setApresentador7 ( isset($p_Item ["fl_apresentador7"]) ? $p_Item ["fl_apresentador7"] : '');
				$obj->setApresentador8 ( isset($p_Item ["fl_apresentador8"]) ? $p_Item ["fl_apresentador8"] : '');
				$obj->setApresentador9 ( isset($p_Item ["fl_apresentador9"]) ? $p_Item ["fl_apresentador9"] : '');
				$obj->setApresentador10 ( isset($p_Item ["fl_apresentador10"]) ? $p_Item ["fl_apresentador10"] : '');
				$obj->setJustificativa8 ( isset($p_Item ["justificativa8"]) ? $p_Item ["justificativa8"] : '' );
				$obj->setJustificativa9 ( isset($p_Item ["justificativa9"]) ? $p_Item ["justificativa9"] : '' );
				$obj->setJustificativa10 ( isset($p_Item ["justificativa10"]) ? $p_Item ["justificativa10"] : '' );
				$obj->setintroducao ( isset($p_Item ["introducao"]) ? $p_Item ["introducao"] : '' );
				$obj->setInstituicao ( isset($p_Item ["instituicao"]) ? $p_Item ["instituicao"] : '' );
				$obj->setObjetivo ( isset($p_Item ["objetivo"]) ? $p_Item ["objetivo"] : '' );
				$obj->setMetodologia ( isset($p_Item ["metodologia"]) ? $p_Item ["metodologia"] : '' );
				$obj->setResultado ( isset($p_Item ["resultado"]) ? $p_Item ["resultado"] : '' );
				$obj->setConclusao ( isset($p_Item ["conclusao"]) ? $p_Item ["conclusao"] : '' );
				$obj->setIdStatus ( isset($p_Item ["id_status"]) ?  trim ( $p_Item ["id_status"] ) : '');
				$obj->setRevisao ( isset($p_Item ["revisao"]) ? $p_Item ["revisao"] : '');
				$obj->setFlagPolitica ( isset($p_Item ['fl_politica']) ? trim ( $p_Item ['fl_politica'] ) : '' );
				$obj->setAtivo ( isset($p_Item ["fl_ativo"]) ? trim ( $p_Item ["fl_ativo"] ) : '' );
				$obj->setDataInclusao ( isset($p_Item ["data_inclusao"]) ? trim ( $p_Item ["data_inclusao"] ) : '' );
				
				$obj->setOutroResumo ( isset($p_Item ["OutroResumo"]) ? trim ( $p_Item ["OutroResumo"] ) : '' );
				$obj->setGest_Resumo ( isset($p_Item ["Gest_Resumo"]) ? trim ( $p_Item ["Gest_Resumo"] ) : '' );
				$obj->setEst_Qualitativo ( isset($p_Item ["Est_Qualitativo"]) ? trim ( $p_Item ["Est_Qualitativo"] ) : '' );
				$obj->setOutrosTemas ( isset($p_Item ["OutrosTemas"]) ? trim ( $p_Item ["OutrosTemas"] ) : '' );
				$obj->setFlagPolitica1 ( isset($p_Item ["fl_politica1"]) ? trim ( $p_Item ["fl_politica1"] ) : '' );				
				//$obj->setFlagPolitica2 ( trim ( $p_Item ['fl_politica2'] ) );
				$obj->setCodResumo ( isset($p_Item ["CodResumo"]) ? trim ( $p_Item ["CodResumo"] ) : '' );
				$obj->setObservacao ( isset($p_Item ["obs_aprovacao"]) ? trim ( $p_Item ["obs_aprovacao"] ) : '' );			
				$obj->setReferencia ( isset($p_Item ["referencia"]) ? trim ( $p_Item ["referencia"] ) : '' );	
				$obj->setBloco ( isset($p_Item ["bloco"]) ? trim ( $p_Item ["bloco"] ) : '' );	
				$obj->setPoster ( isset($p_Item ["poster"]) ? trim ( $p_Item ["poster"] ) : '' );	
				$obj->setDataApresentacao ( isset($p_Item ["data_apresentacao"]) ? trim ( $p_Item ["data_apresentacao"] ) : '' );	
				$obj->setHoraApresentacao ( isset($p_Item ["hora_apresentacao"]) ? trim ( $p_Item ["hora_apresentacao"] ) : '' );	
				$obj->setDataAlteracao ( isset($p_Item ["data_alteracao"]) ? trim ( $p_Item ["data_alteracao"] ) : '' );	

				$obj->setNomeUsuario ( isset($p_Item ["nome_alteracao"])? $p_Item ["nome_alteracao"]: '' );				
				
				//Trecho acrescentado por Kellen Nery 12/12/2016
				$obj->setNomeContato ( isset($p_Item ["nome_contato"]) ? trim ( $p_Item ["nome_contato"] ) : '' );
				$obj->setTelefoneContato ( isset($p_Item ["telefone_contato"]) ? trim ( $p_Item ["telefone_contato"] ) : '' );
				$obj->setEmailContato ( isset($p_Item ["email_contato"]) ? trim ( $p_Item ["email_contato"] ) : '' );
				$obj->setNomeCompleto ( isset($p_Item ["nome_completo"]) ? trim ( $p_Item ["nome_completo"] ) : '' );
				$obj->setEmail ( isset($p_Item ["email"]) ? trim ( $p_Item ["email"] ) : '' );
				
				// Aprovador
				$obj->setIdUsuarioAprovacao ( isset($p_Item ["id_usuario_aprovacao"])? $p_Item ["id_usuario_aprovacao"]: '' );
				$obj->setNomeUsuarioAprovacao ( isset($p_Item ["nome_usuario_aprovacao"])? $p_Item ["nome_usuario_aprovacao"]: '' );
				$obj->setDataAprovacao ( isset($p_Item ["data_aprovacao"])? $p_Item ["data_aprovacao"]: '' );
				$obj->setPalavraChave ( isset($p_Item ["palavraChave"])? $p_Item ["palavraChave"]: '' );
				
				//
				$obj->setDataNascimento ( isset($p_Item ["data_nascimento"])? $p_Item ["data_nascimento"]: '' );
				$obj->setFile1 ( isset($p_Item ["nome_arquivo1"]) ? trim ( $p_Item ["nome_arquivo1"] ) : '' );
				$obj->setFile2 ( isset($p_Item ["nome_arquivo2"]) ? trim ( $p_Item ["nome_arquivo2"] ) : '' );
				$obj->setCpf ( isset($p_Item ["cpf"]) ? trim ( $p_Item ["cpf"] ) : '' );
				$obj->setPassaporte ( isset($p_Item ["passaporte"]) ? trim ( $p_Item ["passaporte"] ) : '' );
				$obj->setPais ( isset($p_Item ["nome_pais"]) ? trim ( $p_Item ["nome_pais"] ) : '' );
				$obj->setEstado ( isset($p_Item ["nome_estado"]) ? trim ( $p_Item ["nome_estado"] ) : '' );
				
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
			
			// $query = "SELECT MAX(id_resumo) + 1 as id_resumo FROM cad_resumo";
			$query = "SELECT COUNT(tipo) as contadorTipo, tipo FROM cad_resumo WHERE fl_ativo=1 AND id_evento=".$obj->getIdEvento()." AND ano=".$obj->getAno()." AND tipo=".$obj->getTipo()." GROUP BY tipo";
			$consulta = $this->_conexao->prepare ( $query );
			$consulta->execute ();
			$item = $consulta->fetch ( PDO::FETCH_ASSOC );
			$valorTipoResultado = '';
			$codResumoValor = '';
			$totalTipo = 0;
			
			if ($obj->getTipo () == 1) {
				$valorTipoResultado = 'V';
			} else if ($obj->getTipo () == 2) {
				$valorTipoResultado = 'B';
			} else if ($obj->getTipo () == 3) {
				$valorTipoResultado = 'R';
			} else if ($obj->getTipo () == 4) {
				$valorTipoResultado = 'OTR';
			} else if ($obj->getTipo () == 5) {
				$valorTipoResultado = 'G';
			} else {
				$valorTipoResultado = '*';
			}
				
			$totalTipo = $item ["contadorTipo"];
			
			if ($item) {
				if ($totalTipo == 0 || $totalTipo == '') {
					$codResumoValor = $valorTipoResultado . "-" . ($totalTipo + 1);
				} else {
					$codResumoValor = $valorTipoResultado . "-" . ($totalTipo + 1);
				}
			} else {
				$codResumoValor = $valorTipoResultado . "-" . ($totalTipo + 1);
			}
			
			// isso ficaria uma porta aberta para um SQL Injection.
			$stmt = $this->_conexao->prepare ( "INSERT INTO cad_resumo (data_inclusao, id_usuario_inclusao, id_usuario, tipo, titulo, id_evento, 
			autor1, autor2, autor3, autor4, autor5, autor6, autor7, autor8, autor9, autor10, 
			instituicao1, instituicao2, instituicao3, instituicao4, instituicao5, instituicao6, instituicao7, instituicao8, instituicao9, instituicao10,   
            fl_apresentador1, fl_apresentador2, fl_apresentador3, fl_apresentador4, fl_apresentador5, fl_apresentador6, fl_apresentador7, fl_apresentador8, fl_apresentador9, fl_apresentador10, 
			justificativa8, justificativa9, justificativa10, 
			introducao, instituicao, objetivo, metodologia, resultado, conclusao, ano, revisao, fl_politica, id_status, CodResumo, 
			fl_ativo, OutroResumo, Gest_Resumo, Est_Qualitativo, OutrosTemas, palavraChave, chave, nome_contato, telefone_contato, email_contato) 
            VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?)" );
			$stmt->bindValue ( 1, $obj->getIdUsuario () );
			$stmt->bindValue ( 2, $obj->getIdUsuario () );
			$stmt->bindValue ( 3, $obj->getTipo () );
			$stmt->bindValue ( 4, utf8_decode ( $obj->getTitulo () ) );
			$stmt->bindValue ( 5, utf8_decode ( $obj->getIdEvento () ) );
			$stmt->bindValue ( 6, utf8_decode ( $obj->getAutor1 () ) );
			$stmt->bindValue ( 7, utf8_decode ( $obj->getAutor2 () ) );
			$stmt->bindValue ( 8, utf8_decode ( $obj->getAutor3 () ) );
			$stmt->bindValue ( 9, utf8_decode ( $obj->getAutor4 () ) );
			$stmt->bindValue ( 10, utf8_decode ( $obj->getAutor5 () ) );
			$stmt->bindValue ( 11, utf8_decode ( $obj->getAutor6 () ) );
			$stmt->bindValue ( 12, utf8_decode ( $obj->getAutor7 () ) );
			$stmt->bindValue ( 13, utf8_decode ( $obj->getAutor8 () ) );
			$stmt->bindValue ( 14, utf8_decode ( $obj->getAutor9 () ) );
			$stmt->bindValue ( 15, utf8_decode ( $obj->getAutor10 () ) );
			$stmt->bindValue ( 16, utf8_decode ( $obj->getInstituicao1 () ) );
			$stmt->bindValue ( 17, utf8_decode ( $obj->getInstituicao2 () ) );
			$stmt->bindValue ( 18, utf8_decode ( $obj->getInstituicao3 () ) );
			$stmt->bindValue ( 19, utf8_decode ( $obj->getInstituicao4 () ) );
			$stmt->bindValue ( 20, utf8_decode ( $obj->getInstituicao5 () ) );
			$stmt->bindValue ( 21, utf8_decode ( $obj->getInstituicao6 () ) );
			$stmt->bindValue ( 22, utf8_decode ( $obj->getInstituicao7 () ) );
			$stmt->bindValue ( 23, utf8_decode ( $obj->getInstituicao8 () ) );
			$stmt->bindValue ( 24, utf8_decode ( $obj->getInstituicao9 () ) );
			$stmt->bindValue ( 25, utf8_decode ( $obj->getInstituicao10 () ) );
			//$stmt->bindValue ( 25, utf8_decode ( $obj->getEmail1 () ) );
			//$stmt->bindValue ( 26, utf8_decode ( $obj->getEmail2 () ) );
			//$stmt->bindValue ( 27, utf8_decode ( $obj->getEmail3 () ) );
			//$stmt->bindValue ( 28, utf8_decode ( $obj->getEmail4 () ) );
			//$stmt->bindValue ( 29, utf8_decode ( $obj->getEmail5 () ) );
			//$stmt->bindValue ( 30, utf8_decode ( $obj->getEmail6 () ) );
			//$stmt->bindValue ( 31, utf8_decode ( $obj->getEmail7 () ) );
			//$stmt->bindValue ( 32, utf8_decode ( $obj->getEmail8 () ) );
			//$stmt->bindValue ( 33, utf8_decode ( $obj->getEmail9 () ) );
			//$stmt->bindValue ( 34, utf8_decode ( $obj->getEmail10 () ) );
			$stmt->bindValue ( 26, utf8_decode ( $obj->getApresentador1 () ) ? $obj->getApresentador1 () : 0 );
			$stmt->bindValue ( 27, utf8_decode ( $obj->getApresentador2 () ) ? $obj->getApresentador2 () : 0 );
			$stmt->bindValue ( 28, utf8_decode ( $obj->getApresentador3 () ) ? $obj->getApresentador3 () : 0 );
			$stmt->bindValue ( 29, utf8_decode ( $obj->getApresentador4 () ) ? $obj->getApresentador4 () : 0 );
			$stmt->bindValue ( 30, utf8_decode ( $obj->getApresentador5 () ) ? $obj->getApresentador5 () : 0 );
			$stmt->bindValue ( 31, utf8_decode ( $obj->getApresentador6 () ) ? $obj->getApresentador6 () : 0 );
			$stmt->bindValue ( 32, utf8_decode ( $obj->getApresentador7 () ) ? $obj->getApresentador7 () : 0 );
			$stmt->bindValue ( 33, utf8_decode ( $obj->getApresentador8 () ) ? $obj->getApresentador8 () : 0 );
			$stmt->bindValue ( 34, utf8_decode ( $obj->getApresentador9 () ) ? $obj->getApresentador9 () : 0 );;
			$stmt->bindValue ( 35, utf8_decode ( $obj->getApresentador10 () ) ? $obj->getApresentador10 () : 0 );
			$stmt->bindValue ( 36, utf8_decode ( $obj->getJustificativa8 () ) );
			$stmt->bindValue ( 37, utf8_decode ( $obj->getJustificativa9 () ) );
			$stmt->bindValue ( 38, utf8_decode ( $obj->getJustificativa10 () ) );
			$stmt->bindValue ( 39, utf8_decode ( $obj->getIntroducao () ) );
			$stmt->bindValue ( 40, utf8_decode ( $obj->getInstituicao () ) );
			$stmt->bindValue ( 41, utf8_decode ( $obj->getObjetivo () ) );
			$stmt->bindValue ( 42, utf8_decode ( $obj->getMetodologia () ) );
			$stmt->bindValue ( 43, utf8_decode ( $obj->getResultado () ) );
			$stmt->bindValue ( 44, utf8_decode ( $obj->getConclusao () ) );
			$stmt->bindValue ( 45, utf8_decode ( $obj->getAno () ) );
			$stmt->bindValue ( 46, $obj->getRevisao () );
			$stmt->bindValue ( 47, $obj->getFlagPolitica () );
			$stmt->bindValue ( 48, $obj->getIdStatus () );
			$stmt->bindValue ( 49, $obj->getCodResumo()? $obj->getCodResumo(): $codResumoValor );
			$stmt->bindValue ( 50, $obj->getOutroResumo () );
			$stmt->bindValue ( 51, $obj->getGest_Resumo () );
			$stmt->bindValue ( 52, $obj->getEst_Qualitativo () );
			$stmt->bindValue ( 53, $obj->getOutrosTemas () );
			$stmt->bindValue ( 54, utf8_decode ( $obj->getPalavraChave () ) );
            $stmt->bindValue ( 55, $obj->getChave());

			//Trecho acrescentado por Kellen Nery 12/12/2016
			$stmt->bindValue ( 56, utf8_decode ( $obj->getNomeContato () ) );
			$stmt->bindValue ( 57, utf8_decode ( $obj->getTelefoneContato () ) );
			$stmt->bindValue ( 58, utf8_decode ( $obj->getEmailContato () ) );
			
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
			$stmt = $this->_conexao->prepare ( "UPDATE cad_resumo SET data_aprovacao=NOW(), id_usuario_aprovacao=?, id_status=?, obs_aprovacao=? WHERE id_resumo=?" );
			
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
	 * função para retornar um registro pelo Identificador do registro.
	 *
	 * @param int $p_Id
	 *        	O Identificador do registro
	 * @return object $Modelo O Objeto do tipo do Modelo desta classe
	 */
	public function retorna($Id) {
		try {
			
			// preparo a query de update - Prepare Statement
			$query = "SELECT c.*, p.nome_completo, p.email, u1.nome AS nome_usuario_aprovacao, u2.nome AS nome_alteracao,
						p.data_nascimento, p.cpf, p.passaporte, pa.nome AS nome_pais
						FROM cad_resumo c
                        LEFT JOIN cad_pessoa p ON c.id_usuario=p.id
                        LEFT JOIN cad_usuario u1 ON c.id_usuario_aprovacao=u1.id_usuario
						LEFT JOIN cad_usuario u2 ON c.id_usuario_alteracao=u2.id_usuario
						LEFT JOIN cad_pais pa ON pa.id_pais=p.id_pais
                        WHERE c.id_resumo=:Id";
			
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
	public function retornaApresentador($Id) {
		try {
			
			// preparo a query de update - Prepare Statement
			$query = "SELECT fl_apresentador1, fl_apresentador2, fl_apresentador3, fl_apresentador4, fl_apresentador5, fl_apresentador6
            fl_apresentador7, fl_apresentador8, fl_apresentador9, fl_apresentador10 FROM cad_resumo WHERE id_resumo=:Id";
			
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
	public function retornaResumoPorID($Id_resumo) {
		try {
			// preparo a query de update - Prepare Statement
			$query = "SELECT * FROM cad_resumo WHERE id_resumo=" . $Id_resumo;
			
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
	public function retornaResumo($Id_usuario) {
		try {
			// preparo a query de update - Prepare Statement
			$query = "SELECT * FROM cad_resumo WHERE fl_ativo=1 and id_usuario=" . $Id_usuario;
			
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
	public function retornaResumoUsuario($Id_usuario, $Id_resumo) {
		try {
			// preparo a query de update - Prepare Statement
			$query = "SELECT * FROM cad_resumo WHERE id_usuario=" . $Id_usuario . " and id_resumo=" . $Id_resumo;
			
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
	
	/**
	 * função para atualizar um registro.
	 *
	 * @param object $Modelo
	 *        	O Objeto do tipo do Modelo desta classe
	 * @return boolean $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function atualiza($IdResumo, $TipoResumo, $TituloResumo, $Autor1, $Autor2, $Autor3, $Autor4, $Autor5, $Autor6, $Autor7, $Autor8, $Autor9, $Autor10, $Instituicao1, $Instituicao2, $Instituicao3, $Instituicao4, $Instituicao5, $Instituicao6, $Instituicao7, $Instituicao8, $Instituicao9, $Instituicao10, $Email1, $Email2, $Email3, $Email4, $Email5, $Email6, $Email7, $Email8, $Email9, $Email10, $Apresentador1, $Apresentador2, $Apresentador3, $Apresentador4, $Apresentador5, $Apresentador6, $Apresentador7, $Apresentador8, $Apresentador9, $Apresentador10, $Justificativa8, $Justificativa9, $Justificativa10, $Textointroducao, $TextoObjetivo, $TextoMetodologia, $TextoResumo, $TextoConclusao, $TextoPalavraChave, $FlagPolitica, $OutroResumo, $Gest_Resumo, $Est_Qualitativo, $OutrosTemas) {
		try {
			$valorTipoResultado = '';
			$codResumoValor = '';
			$totalTipo = 0;
			
			// Verficar se o tipoResumo foi alterado.
			
			$query1 = "SELECT tipo, CodResumo FROM cad_resumo where fl_ativo=1 and id_resumo =" . $IdResumo;
			$consulta1 = $this->_conexao->prepare ( $query1 );
			$consulta1->execute ();
			$item1 = $consulta1->fetch ( PDO::FETCH_ASSOC );
			
			if ($TipoResumo == 1) {
				$valorTipoResultado = 'V';
			} else if ($TipoResumo == 2) {
				$valorTipoResultado = 'B';
			} else if ($TipoResumo == 3) {
				$valorTipoResultado = 'R';
			} else if ($TipoResumo == 4) {
				$valorTipoResultado = 'OTR';
			} else {
				$valorTipoResultado = '*';
			}
			
			if ($item1) {
				if ($item1 ["tipo"] == $TipoResumo) {
					// $codResumoValor = $valorTipoResultado."-".$TipoResumo;
					$codResumoValor = $item1 ["CodResumo"];
				} else {
					// Altendo o código.
					$query = "SELECT (COUNT(tipo)+1) as contadorTipo, tipo FROM cad_resumo WHERE fl_ativo=1 AND ano=".date ("Y")." AND tipo=".$TipoResumo." GROUP BY tipo";
					$consulta = $this->_conexao->prepare ( $query );
					$consulta->execute ();
					$item = $consulta->fetch ( PDO::FETCH_ASSOC );
					$totalTipo = $item ["contadorTipo"];
					if ($item) {
						if ($totalTipo == 0 || $totalTipo == '') {
							$codResumoValor = $valorTipoResultado . "-" . ($totalTipo + 1);
						} else {
							$codResumoValor = $valorTipoResultado . "-" . $totalTipo;
						}
					} else {
						$codResumoValor = $valorTipoResultado . "-" . ($totalTipo + 1);
					}
				}
			} else {
				$codResumoValor = $valorTipoResultado . "-" . $TipoResumo + 1;
			}
			
			// CodResumo
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_resumo SET tipo=? , titulo=?, autor1=?, autor2=?, autor3=?, autor4=?, autor5=?,  
            autor6=?, autor7=?, autor8=?, autor9=?, autor10=?, instituicao1=?, instituicao2=?, instituicao3=?, instituicao4=?, instituicao5=?,
            instituicao6=?, instituicao7=?, instituicao8=?, instituicao9=?, instituicao10=?, email1=?, email2=?, email3=?, email4=?, email5=?, 
            email6=?, email7=?, email8=?, email9=?, email10=?, fl_apresentador1=?, fl_apresentador2=?, fl_apresentador3=?, fl_apresentador4=?, 
            fl_apresentador5=?, fl_apresentador6=?, fl_apresentador7=?, fl_apresentador8=?, fl_apresentador9=?, fl_apresentador10=?, justificativa8=?, 
            justificativa9=?, justificativa10=?, introducao=?, objetivo=?, metodologia=?, resultado=?, conclusao=?, palavraChave=?, fl_politica=?, CodResumo=?, OutroResumo=?, Gest_Resumo=?, Est_Qualitativo=?, OutrosTemas=?,
			nome_contato=?, telefone_contato=?, email_contato=? WHERE id_resumo=?" );
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue ( 1, $TipoResumo );
			$stmt->bindValue ( 2, $TituloResumo );
			$stmt->bindValue ( 3, $Autor1 );
			$stmt->bindValue ( 4, $Autor2 );
			$stmt->bindValue ( 5, $Autor3 );
			$stmt->bindValue ( 6, $Autor4 );
			$stmt->bindValue ( 7, $Autor5 );
			$stmt->bindValue ( 8, $Autor6 );
			$stmt->bindValue ( 9, $Autor7 );
			$stmt->bindValue ( 10, $Autor8 );
			$stmt->bindValue ( 11, $Autor9 );
			$stmt->bindValue ( 12, $Autor10 );
			$stmt->bindValue ( 13, $Instituicao1 );
			$stmt->bindValue ( 14, $Instituicao2 );
			$stmt->bindValue ( 15, $Instituicao3 );
			$stmt->bindValue ( 16, $Instituicao4 );
			$stmt->bindValue ( 17, $Instituicao5 );
			$stmt->bindValue ( 18, $Instituicao6 );
			$stmt->bindValue ( 19, $Instituicao7 );
			$stmt->bindValue ( 20, $Instituicao8 );
			$stmt->bindValue ( 21, $Instituicao9 );
			$stmt->bindValue ( 22, $Instituicao10 );
			$stmt->bindValue ( 23, $Email1 );
			$stmt->bindValue ( 24, $Email2 );
			$stmt->bindValue ( 25, $Email3 );
			$stmt->bindValue ( 26, $Email4 );
			$stmt->bindValue ( 27, $Email5 );
			$stmt->bindValue ( 28, $Email6 );
			$stmt->bindValue ( 29, $Email7 );
			$stmt->bindValue ( 30, $Email8 );
			$stmt->bindValue ( 31, $Email9 );
			$stmt->bindValue ( 32, $Email10 );
			$stmt->bindValue ( 33, $Apresentador1 );
			$stmt->bindValue ( 34, $Apresentador2 );
			$stmt->bindValue ( 35, $Apresentador3 );
			$stmt->bindValue ( 36, $Apresentador4 );
			$stmt->bindValue ( 37, $Apresentador5 );
			$stmt->bindValue ( 38, $Apresentador6 );
			$stmt->bindValue ( 39, $Apresentador7 );
			$stmt->bindValue ( 40, $Apresentador8 );
			$stmt->bindValue ( 41, $Apresentador9 );
			$stmt->bindValue ( 42, $Apresentador10 );
			$stmt->bindValue ( 43, $Justificativa8 );
			$stmt->bindValue ( 44, $Justificativa9 );
			$stmt->bindValue ( 45, $Justificativa10 );
			$stmt->bindValue ( 46, $Textointroducao );
			$stmt->bindValue ( 47, $TextoObjetivo );
			$stmt->bindValue ( 48, $TextoMetodologia );
			$stmt->bindValue ( 49, $TextoResumo );
			$stmt->bindValue ( 50, $TextoConclusao );
			$stmt->bindValue ( 51, $TextoPalavraChave );
			$stmt->bindValue ( 52, $FlagPolitica );
			$stmt->bindValue ( 53, $codResumoValor );
			$stmt->bindValue ( 54, $OutroResumo );
			$stmt->bindValue ( 55, $Gest_Resumo );
			$stmt->bindValue ( 56, $Est_Qualitativo );
			$stmt->bindValue ( 57, $OutrosTemas );
			//Trecho acrescentado por Kellen Nery 12/12/2016
			$stmt->bindValue ( 58, $NomeContato );
			$stmt->bindValue ( 59, $TelefoneContato );
			$stmt->bindValue ( 60, $EmailContato );		
			
			$stmt->bindValue ( 61, $IdResumo );
			
	
			
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
			// preparo a query de update - Prepare Statement
			$stmt = $this->_conexao->prepare ( "UPDATE cad_resumo SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_resumo=?" );
			
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
			$stmt = $this->_conexao->prepare ( "UPDATE cad_resumo SET data_alteracao=NOW(), id_usuario_alteracao=?, fl_ativo=0 WHERE id_resumo=?" );
			
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
	 * função para Alterar o status do Resumo.
	 *
	 * @param int $p_Id O Identificador do registro desta classe
	 * @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	 */
	public function alterarStatus($p_Id, $p_IdStatus, $p_Observacao=null, $Referencia=null, $DataApresentacao=null, $HoraApresentacao=null, $Bloco=null, $Poster=null) {
		try {
			// preparo a query de update - Prepare Statement
			
            $query = "UPDATE cad_resumo "
                        ." SET data_aprovacao=NOW(), id_usuario_aprovacao=:IdUsuarioAcao, id_status=:IdStatus, obs_aprovacao=:Observacao ";
            $query .= ($Referencia)? ", referencia='$Referencia'": ", referencia=null";
            $query .= ($DataApresentacao)? ", data_apresentacao='$DataApresentacao'": ", data_apresentacao=null";
			$query .= ($HoraApresentacao)? ", hora_apresentacao='$HoraApresentacao'": ", hora_apresentacao=null";
            $query .= ", bloco='$Bloco'";
            $query .= ", poster='$Poster'";
            $query .= ", id_usuario_alteracao=".$this->_idUsuario;
            $query .= ", data_alteracao=NOW()";
            $query .= " WHERE id_resumo=:Id";

			$stmt = $this->_conexao->prepare($query);
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
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
	
	public function verificaResumoPorID($Id) {
		try {
			
			// preparo a query de update - Prepare Statement
			$query = "SELECT c.*, p.nome_completo, p.email, p.data_nascimento FROM cad_resumo c inner join cad_pessoa p on p.id=c.id_usuario WHERE c.fl_ativo=1 and c.id_usuario=".$Id;
			
			$consulta = $this->_conexao->prepare ( $query );
			
			if ($consulta->execute()) {
				$listagem = array ();
				foreach ( $consulta as $item ) {
					$listagem [] = self::carregarModelo ( $item );
				}
				return $listagem;
			} else {
				$this->_erro = $this->_conexao->errorInfo ();
				throw new PDOException ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
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
			if ($sidx == 'Codigo')
				//$sidx = 'c.CodResumo';
				$sidx = 'substring_index(c.CodResumo,"-", 1), cast(substring_index(c.CodResumo,"-", -1) as UNSIGNED)';
			if ($sidx == 'IdResumo')
				$sidx = 'c.id_resumo';
			if ($sidx == 'IdUsuario')
				$sidx = 'c.id_usuario';
			if ($sidx == 'Titulo')
				$sidx = 'c.titulo';
			if ($sidx == 'Status')
				$sidx = 'c.id_status';
			if ($sidx == 'TipoDescricao')
				$sidx = 'c.tipo';
			if ($sidx == 'DataInclusao')
				$sidx = 'c.data_inclusao';
			if ($sidx == 'NomeUsuario')
				$sidx = 'p.nome_completo';

            $filtro .= " AND c.id_evento=(select id_parente from cad_evento where id_evento = $idEvento) ";
			if ($tipo)
				$filtro .= " AND c.tipo=$tipo ";
			if ($id_usuario)
				$filtro .= " AND c.id_usuario=$id_usuario ";
			if ($titulo)
				$filtro .= " AND c.titulo LIKE '%$titulo%' ";
			if ($id_status)
				$filtro .= " AND c.id_status=$id_status ";
			if ($nome_usuario)
				$filtro .= " AND p.nome_completo LIKE '%$nome_usuario%' ";
			
			$query = "SELECT c.*, p.nome_completo, p.email, u1.nome AS nome_usuario_aprovacao, p.data_nascimento, p.cpf, p.passaporte, pa.nome AS nome_pais, est.nome AS nome_estado  
						FROM cad_resumo c
                        LEFT JOIN cad_pessoa p ON c.id_usuario=p.id
                        LEFT JOIN cad_usuario u1 ON c.id_usuario_aprovacao=u1.id_usuario
						LEFT JOIN cad_pais pa ON pa.id_pais=p.id_pais
						LEFT JOIN cad_estado est ON est.id_estado=p.id_estado
                        WHERE c.fl_ativo=1 $filtro
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
			if ($sidx == 'Codigo'){ $sidx = 'c.CodResumo';}
			if ($sidx == 'IdResumo'){ $sidx = 'c.id_resumo';}
			if ($sidx == 'IdUsuario'){ $sidx = 'c.id_usuario';}
			if ($sidx == 'Titulo'){ $sidx = 'c.titulo';}
			if ($sidx == 'Status'){ $sidx = 'c.id_status';}
			if ($sidx == 'TipoDescricao'){ $sidx = 'c.tipo';}
			if ($sidx == 'DataInclusao'){ $sidx = 'c.data_inclusao';}
			if ($sidx == 'NomeUsuario'){ $sidx = 'u.nome';}
            
			if ($Chave!=''){
                $filtro .= " AND c.chave='$Chave' ";
			
                $query = "SELECT c.*, u.nome AS nome_usuario, u1.nome AS nome_usuario_aprovacao
                            FROM cad_resumo c
                            LEFT JOIN cad_usuario u ON c.id_usuario=u.id_usuario
                            LEFT JOIN cad_usuario u1 ON c.id_usuario_aprovacao=u1.id_usuario
                            WHERE c.fl_ativo=0 $filtro
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
     * Método para retornar um registro pelo Identificador do Resumo.
     *
     *   @param int $p_Chave A de identificador do EventoPresencaa
     *
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarPorChave($p_Chave){
        try{
            if ($p_Chave){
                // Preparo a query
                $query = "SELECT r.* "
                        ." FROM cad_resumo r "
                        ." WHERE r.fl_ativo=1 AND r.chave=:Chave;";
				
                $this->_query = $query;
                $stmt = $this->_conexao->prepare($query);
                
                // Passa os paramentros para a query 
                $stmt->bindValue(':Chave', $p_Chave);

                // Executo a query preparada
                $stmt->execute();
         
                // Pega o resultado da query executada
                $item = $stmt->fetch(PDO::FETCH_ASSOC);
                if($item){
                    return self::carregarModelo($item);
                } else {
                    $arrError = $stmt->errorInfo();
                    $this->_erro = $arrError[0];
                    $this->_mensagem = 'PDO-'.$arrError[2];
                    return null;
                }
            } else { return null; }
        } catch (PDOException $ex){ throw $ex; }
    }	
	
	
	/**
	 * Função para Atualziar Campo no Formulário .
	 *
	 * @param int $p_IdFormulario O Identificador do Formulário
	 * @param int $p_Campo O Identificador do Campo
	 * @param int $p_Valor O Observações do Novo Valor 
     * 
	 * @return boolean Flag que indica que a operação foi concluída com sucesso
	 */
	public function atualizarCampo($p_IdResumo, $p_Campo, $p_Valor) {
		try {
		
			$query = "UPDATE cad_resumo "
					." set " . $p_Campo . "=:Valor "
					." WHERE id_resumo=:Id ";
			
            $this->_query = $query;
                        
            // Preparo a query
            $stmt = $this->_conexao->prepare($query);
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue(':Id', $p_IdResumo);
			$stmt->bindValue(':Valor', $p_Valor);
			
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

