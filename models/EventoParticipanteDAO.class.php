<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('EventoParticipante')){ require_once 'EventoParticipante.class.php';}
/**
 * Classe DAO de acesso a dados EventoParticipante
 * 
 * @package Model.DAO
 * @category DAO
 * @since   2015-05-21
 * @version 1.6
 * @author  Kellen Nery
 * 
 * 
 * @edit    2020-12-01<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Implementação de Melhoria 
 *          #1.15
 */
class EventoParticipanteDAO extends PDOConnection {
    
    private $_NomeStatus = array(0=>'Não definida', 1=>'Pre-Inscrito', 2=>'Inscrito', 3=>'Recusado', 4=>'Cancelada', 5=>'Confirmado', 6=>'Presente', 7=>'', 8=>'', 9=>'');
    
    /**
     * Método interna para carregar objeto com os dados do registro.
     *
     *   @param object $Item O Objeto do tipo Registro do Banco de Dados
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    private function carregarModelo($p_Item){
        try{
            if ($p_Item) {
                $obj = new EventoParticipante();
                $obj->setId($p_Item['id_evento_participante']);
                $obj->setIdEvento($p_Item['id_evento']);
				$obj->setIdParente($p_Item['id_parente']);
                $obj->setNomeEvento(isset($p_Item['nome_evento'])? $p_Item['nome_evento']: '');
				$obj->setNameEvent(isset($p_Item['name_event'])? $p_Item['name_event']: '');
                $obj->setIdParticipante($p_Item['id_participante']);
                $obj->setNomeParticipante(isset($p_Item['nome_participante'])? $p_Item['nome_participante']: '');
				$obj->setIdTipoParticipante($p_Item['id_tipo_participante']);
				$obj->setNomeTipo($p_Item['nome_tipo_participante']);
                $obj->setObservacao(($p_Item['observacao'])? $p_Item['observacao']: '');
                $obj->setIdStatus($p_Item['id_status']);
                $obj->setNomeStatus($this->_NomeStatus[$p_Item['id_status']]);
                $obj->setDataCadastro(isset($p_Item['data_cadastro'])? $p_Item['data_cadastro']: '');
                $obj->setIdUsuarioAprovacao($p_Item['id_usuario_aprovacao']);
                $obj->setNomeUsuarioAprovacao(isset($p_Item['nome_usuario_aprovacao'])? $p_Item['nome_usuario_aprovacao']: '');
                $obj->setDataAprovacao(isset($p_Item['data_aprovacao'])? $p_Item['data_aprovacao']: '');
                
                // Evento
                $obj->setCapacidade(isset($p_Item['solicitacoes'])? intval($p_Item['capacidade']): 0);
                $obj->setSolicitacoes(isset($p_Item['solicitacoes'])? $p_Item['solicitacoes']: 0);
                $obj->setAprovados(isset($p_Item['Aprovados'])? $p_Item['Aprovados']: 0);
                $obj->setSaldo($obj->getCapacidade() - $obj->getAprovados());
				$obj->setDataInicial($p_Item['data_inicial']);
				$obj->setDataFinal($p_Item['data_final']);
                
                $obj->setRevisao(isset($p_Item['revisao'])? $p_Item['revisao']: 0);
                $obj->setAcao($p_Item['acao']);
                $obj->setIdUsuarioAcao($p_Item['id_usuario_acao']);
                $obj->setNomeUsuarioAcao((isset($p_Item['nome_usuario_acao']))? $p_Item['nome_usuario_acao']: '');
                $obj->setDataAcao($p_Item['data_acao']);
				
                $obj->setIdTipoEvento($p_Item['id_tipo_evento']);
				
				$obj->setCpf(isset($p_Item['cpf'])? $p_Item['cpf']: '');
				$obj->setPassaporte(isset($p_Item['passaporte'])? $p_Item['passaporte']: '');
				$obj->setEmail(isset($p_Item['email'])? $p_Item['email']: '');	
				$obj->setEventoAtivo($p_Item['evento_ativo']);
				
                return $obj;
            } else {
                return null;
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     * Método para gravar um registro novo.
     *
     *   @param object $obj O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
     */
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_evento_participante (     acao,      data_acao, id_usuario_acao,  data_cadastro, id_evento, id_participante, id_tipo_participante,  observacao, id_status, revisao)"
                                                ." VALUES ('incluir', ".$this::NOW.",  :IdUsuarioAcao, ".$this::NOW.", :IdEvento, :IdParticipante,  :IdTipoParticipante, :Observacao, :IdStatus,       1);";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',      $this->_idUsuario);
            $stmt->bindValue(':IdEvento',           $obj->getIdEvento());
            $stmt->bindValue(':IdParticipante',     $obj->getIdParticipante());
			$stmt->bindValue(':IdTipoParticipante', $obj->getIdTipoParticipante());
            $stmt->bindValue(':Observacao',         $obj->getObservacao());
            $stmt->bindValue(':IdStatus',           $obj->getIdStatus());

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id){ 
                    $Id = $this->_conexao->lastInsertId('cad_evento_participante_id_evento_participante_seq'); // POSTGRSQL
                } 
                $obj->setId($Id); 
                return true;
            } else {
                $arrError = $stmt->errorInfo();
                $this->_erro = $arrError[0];
                $this->_mensagem = 'PDO-'.$arrError[2];
                return null;
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     * Método para retornar um registro pelo Identificador do registro.
     *
     *   @param int|string $p_Id O Identificador ou Código do registro
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornar($p_Id){
        try{
            $filtro = '';
            if($p_Id){
                // Prepara o filtro
                $filtro .= (ctype_digit($p_Id))? " AND e.id_evento_participante=$p_Id ": " AND e.id_evento_participante='$p_Id' ";
                
                // Preparo a query
                $query = "SELECT e.*, p.nome AS nome_evento, p.data_inicial, p.id_tipo_evento, r.name nome_participante "
                    ." , u1.nome AS nome_usuario_acao, u2.nome AS nome_usuario_aprovacao, t.nome AS nome_tipo_participante "
                        ." FROM cad_evento_participante e "
                        ." INNER JOIN cad_evento p ON p.id_evento=e.id_evento "
                        ." LEFT JOIN m5wat_users r ON r.id=e.id_participante "
                        ." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
                        ." LEFT JOIN cad_usuario u2 ON e.id_usuario_aprovacao=u2.id_usuario "
						." LEFT JOIN cad_tipo_participante t ON e.id_tipo_participante=t.id_tipo_participante "
                        ." WHERE e.deletado=false $filtro";
	
                $this->_query = $query;
                $stmt = $this->_conexao->prepare($query);

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
     * Método para retornar um registro pelo Identificador do Evento e Participante.
     *
     *   @param int $p_IdEvento O identificador do Evento
     *   @param int $p_IdParticipante O identificador do Participante
     *
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarPorEventoParticipante($p_IdEvento, $p_IdParticipante){
        try{
            // Preparo a query
            $query = "SELECT e.*, p.nome AS nome_evento, r.name AS nome_participante, p.id_tipo_evento "
                    ." , u1.nome AS nome_usuario_acao, u2.nome AS nome_usuario_aprovacao, t.nome AS nome_tipo_participante "
                    ." FROM cad_evento_participante e "
                    ." INNER JOIN cad_evento p ON p.id_evento=e.id_evento "
                    ." LEFT JOIN m5wat_users r ON r.id=e.id_participante "
                    ." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
                    ." LEFT JOIN cad_usuario u2 ON e.id_usuario_aprovacao=u2.id_usuario "
					." LEFT JOIN cad_tipo_participante t ON e.id_tipo_participante=t.id_tipo_participante "
                    ." WHERE e.id_evento=".intval($p_IdEvento)." AND e.id_participante=".intval($p_IdParticipante).";";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

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
        } catch (PDOException $ex){ throw $ex; }
    }
	
    /**
     * Método para retornar um registro pelo Identificador do EventoParente e Participante.
     *
     *   @param int $p_IdEventoParente O identificador do Evento Principal (Evento Pai)
     *   @param int $p_IdParticipante O identificador do Participante
     *
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function listarPorEventoPrincipalParticipante($p_IdEventoPrincipal, $p_IdParticipante, $rows=null){
        try{
            // Preparo a query
            $query = "SELECT e.*, p.nome AS nome_evento, r.name AS nome_participante, p.id_tipo_evento, p.id_parente "
                    ." , u1.nome AS nome_usuario_acao, u2.nome AS nome_usuario_aprovacao, t.nome AS nome_tipo_participante "
                    ." FROM cad_evento_participante e "
                    ." INNER JOIN cad_evento p ON p.id_evento=e.id_evento "
                    ." LEFT JOIN m5wat_users r ON r.id=e.id_participante "
                    ." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
                    ." LEFT JOIN cad_usuario u2 ON e.id_usuario_aprovacao=u2.id_usuario "
					." LEFT JOIN cad_tipo_participante t ON e.id_tipo_participante=t.id_tipo_participante "
                    ." WHERE p.id_parente=".intval($p_IdEventoPrincipal)." AND e.id_participante=".intval($p_IdParticipante).";";
            $this->_query = $query;

            // Paginacao
            if ($rows){
                $queryCount= "SELECT count(e.*) AS count "
                            ." FROM cad_evento_participante e "
							." INNER JOIN cad_evento p ON p.id_evento=e.id_evento "
							." LEFT JOIN m5wat_users r ON r.id=e.id_participante "
							." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
							." LEFT JOIN cad_usuario u2 ON e.id_usuario_aprovacao=u2.id_usuario "
							." LEFT JOIN cad_tipo_participante t ON e.id_tipo_participante=t.id_tipo_participante "
							." WHERE p.id_parente=".intval($p_IdEventoPrincipal)." AND e.id_participante=".intval($p_IdParticipante).";";
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
        } catch (PDOException $ex){ throw $ex; }			
    }	
	
	
   /**
     * Método para retornar um registro e saber se o participante já se inscreveu no evento atual para submeter o resumo.
	 * Melhorar DEPOIS
     */
    public function retornarParaResumo($p_IdParticipante){ 
        try{
            // Preparo a query
            $query = "SELECT distinct e.id_participante "
                    ." FROM cad_evento_participante e "
                    ." WHERE e.id_evento in (7) AND e.id_participante=".intval($p_IdParticipante).";";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;;
			
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
        } catch (PDOException $ex){ throw $ex; }
    }
	
	

    /**
     * Método para atualizar um registro.
     *
     *   @param object $Modelo O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a opera??o foi conclu?da com sucesso
     */
    public function atualizar($obj){
        try{
            // Preparo a query 
            $query = "UPDATE cad_evento_participante "
                    ." SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao"
                    .", id_evento=:IdEvento, id_participante=:IdParticipante, id_status=:IdStatus "
                    .", id_usuario_aprovacao=:IdUsuarioAprovacao, data_aprovacao=:DataAprovacao, observacao=:Observacao"
                    .", revisao=(revisao+1)"
                    ." WHERE id_evento_participante=:Id";
								
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',      $this->_idUsuario);
            $stmt->bindValue(':IdEvento',           $obj->getIdEvento());
            $stmt->bindValue(':IdParticipante',     $obj->getIdParticipante());
            $stmt->bindValue(':Observacao',         $obj->getObservacao());
            $stmt->bindValue(':IdStatus',           $obj->getIdStatus());
            $stmt->bindValue(':IdUsuarioAprovacao', $obj->getIdUsuarioAprovacao());
            $stmt->bindValue(':DataAprovacao',      $obj->getDataAprovacao());
            $stmt->bindValue(':Id',                 $obj->getId());
			
            // Executa a query preparada
            if ($stmt->execute()){
                return true;
            } else {
                $arrError = $stmt->errorInfo();
                $this->_erro = $arrError[0];
                $this->_mensagem = 'PDO-'.$arrError[2];
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     * Método para excluir o registro.
     *
     *   @param int $p_Id O Identificador do registro desta classe
     *   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
     */
    public function excluir($p_Id){
        try{
            // Preparo a query
            $query = "UPDATE cad_evento_participante "
                    ." SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, deletado=".$this::SIM 
                    ." WHERE id_evento_participante=:Id";
            $this->_query = $query;
            
            $stmt = $this->_conexao->prepare($query);
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Id', $p_Id);

            // Executa a query preparada
            if ($stmt->execute()){
                return true;
            } else {
                $arrError = $stmt->errorInfo();
                $this->_erro = $arrError[0];
                $this->_mensagem = 'PDO-'.$arrError[2];
                return null;
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     * Método para excluir o registro.
     *   @param int $p_Id O Identificador do registro desta classe
     *   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
     */
    public function excluirFisico($p_Id){
        try{
            // Preparo a query
            $query = "delete from cad_evento_participante "
                    ." WHERE id_evento_participante=:Id";
            $this->_query = $query;
            
            $stmt = $this->_conexao->prepare($query);
            // Passa os paramentros para a query 
            //$stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Id', $p_Id);
			
            // Executa a query preparada
            if ($stmt->execute()){
                return true;
            } else {
                $arrError = $stmt->errorInfo();
                $this->_erro = $arrError[0];
                $this->_mensagem = 'PDO-'.$arrError[2];
                return null;
            }
        } catch (PDOException $ex){ throw $ex; }
    }	
		
	
    /**
     * Método para listar os registros
     *
     *   @param int $page A Pagina do registros a ser retornarda 
     *   @param int $rows A Quantidade de registro a ser retornardo
     *   @param int $sidx O nome do campo a ser Ordendado
     *   @param int $sord A direcao da ordenacao (ASC ou DESC)
     *   @param int|string $p_Evento O Evento que deseja filtrar
     *   @param int|string $p_Participante A Região que deseja filtrar
     *   @param string $p_Nome Parte do nome que deseja filtrar
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $p_Evento=null, $p_Status=null, $p_Participante=null, $p_Nome=null){
        try{		
            $filtro='';
            if($sidx=='IdEventoParticipante'){ $sidx='id_evento_participante';}
            if($sidx=='IdEvento'){ $sidx='id_evento';}
            if($sidx=='IdParticipante'){ $sidx='id_participante';}
            if($sidx=='Observacao'){ $sidx='ep.observacao';}
            if($sidx=='NomeEvento'){ $sidx='e.nome';}
            if($sidx=='NomeParticipante'){ $sidx='p.name';}
            if($sidx=='Nome'){ $sidx='p.name';}
            if($sidx=='DataInicial'){ $sidx='p.data_inicial';}
            if($sidx=='IdTipoEvento'){ $sidx='p.id_tipo_evento';}
/*
            if($p_Evento != null){
                $filtro .= (is_numeric($p_Evento))? " AND ep.id_evento=$p_Evento ": " AND ep.id_evento IN ($p_Evento) ";
            } else {
				$p_Evento = 999;
				$filtro .= (is_numeric($p_Evento))? " AND ep.id_evento=$p_Evento ": " AND ep.id_evento IN ($p_Evento) ";
			}
*/			
             if($p_Evento != null){
				$filtro .= " AND (ep.id_evento='$p_Evento' or e.id_parente='$p_Evento') "; 
                //$filtro .= (is_numeric($p_Evento))? " AND ep.id_evento=$p_Evento ": " AND ep.id_evento IN ($p_Evento) ";
            }
			
            if($p_Participante){
                $filtro .= (is_numeric($p_Participante))? " AND ep.id_participante=$p_Participante ": '';
            } 
            if($p_Status){
                $filtro .= (is_numeric($p_Status))? " AND ep.id_status=$p_Status ": " AND ep.id_status IN ($p_Status) ";
            }
            
            if($p_Nome) {
                $p_Nome=str_replace(' ', '%', $p_Nome);
                $filtro .= " AND (lower(p.name) LIKE lower('%$p_Nome%'))";
            }
            
            $query = "SELECT ep.*, e.nome nome_evento, e.name name_event, e.capacidade, e.id_tipo_evento, e.ativo AS evento_ativo "
                    ." , p.name nome_participante, e.data_inicial, p.username cpf, p.email, e.id_parente "
                    ." , u1.nome AS nome_usuario_acao, t.id_tipo_participante, t.nome AS nome_tipo_participante "
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t1 WHERE t1.deletado=false AND t1.id_evento=ep.id_evento) AS solicitacoes"
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t2 WHERE t2.deletado=false AND t2.id_evento=ep.id_evento AND t2.id_status=2) AS Aprovados"
                    ." FROM cad_evento_participante ep "
                    ." INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
                    ." INNER JOIN m5wat_users p ON p.id=ep.id_participante "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=ep.id_usuario_acao "
					." LEFT JOIN cad_tipo_participante t ON ep.id_tipo_participante=t.id_tipo_participante "
                    ." WHERE ep.deletado=".$this::NAO." $filtro "
                    ." ORDER BY $sidx $sord";
			
            $this->_query = $query;
            
            // Paginacao
            if ($rows){
                $queryCount= "SELECT count(ep.*) AS count "
                            ." FROM cad_evento_participante ep "
                            ." INNER JOIN cad_evento p ON p.id_evento=ep.id_evento "
                            ." INNER JOIN m5wat_users p ON p.id=ep.id_participante "
                            ." LEFT JOIN cad_usuario u1 ON ep.id_usuario_acao=u1.id_usuario "
							." LEFT JOIN cad_tipo_participante t ON ep.id_tipo_participante=t.id_tipo_participante "
                            ." WHERE ep.deletado=".$this::NAO." $filtro ";
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
        } catch (PDOException $ex){ throw $ex; }
    }

	
    /**
     * Método para listar os registros
     *
     *   @param int $page A Pagina do registros a ser retornarda 
     *   @param int $rows A Quantidade de registro a ser retornardo
     *   @param int $sidx O nome do campo a ser Ordendado
     *   @param int $sord A direcao da ordenacao (ASC ou DESC)
     *   @param int|string $p_Evento O Evento que deseja filtrar
     *   @param int|string $p_Participante A Região que deseja filtrar
     *   @param string $p_Nome Parte do nome que deseja filtrar
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listarPresenca($page=null, $rows=null, $sidx=null, $sord=null, $p_Evento=null, $p_Status=null, $p_Participante=null, $p_Nome=null){
        try{		
            $filtro='';
            if($sidx=='IdEventoParticipante'){ $sidx='id_evento_participante';}
            if($sidx=='IdEvento'){ $sidx='id_evento';}
            if($sidx=='IdParticipante'){ $sidx='id_participante';}
            if($sidx=='Observacao'){ $sidx='ep.observacao';}
            if($sidx=='NomeEvento'){ $sidx='e.nome';}
            if($sidx=='NomeParticipante'){ $sidx='p.name';}
            if($sidx=='Nome'){ $sidx='p.name';}
            if($sidx=='DataInicial'){ $sidx='p.data_inicial';}
            if($sidx=='IdTipoEvento'){ $sidx='p.id_tipo_evento';}
		
            if($p_Evento != null){
				$filtro .= " AND (ep.id_evento='$p_Evento' or e.id_parente='$p_Evento') "; 
            }
			
            if($p_Participante){
                $filtro .= (is_numeric($p_Participante))? " AND ep.id_participante=$p_Participante ": '';
            } 
            if($p_Status){
                $filtro .= (is_numeric($p_Status))? " AND ep.id_status=$p_Status ": " AND ep.id_status IN ($p_Status) ";
            }
            
            if($p_Nome) {
                $p_Nome=str_replace(' ', '%', $p_Nome);
                $filtro .= " AND (lower(p.name) LIKE lower('%$p_Nome%'))";
            }
            
            $query = "SELECT p.id AS id_participante, p.cpf, p.passaporte, p.nome_completo AS nome_participante, p.email, p.id_status  " 
                    ." FROM cad_pessoa p "
					." INNER JOIN cad_evento_participante ep ON ep.id_participante=p.id "
                    ." INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
                    ." WHERE ep.deletado=".$this::NAO." $filtro "
					." GROUP BY p.id, p.cpf, p.passaporte, p.nome_completo, p.email, p.id_status"
                    ." ORDER BY $sidx $sord";
			
            $this->_query = $query;
            
            // Paginacao
            if ($rows){
                $queryCount= "select count(*) as count "
							." from ( "
							."        SELECT p.id AS id_participante, p.cpf, p.passaporte, p.nome_completo AS nome_participante, p.email, p.id_status "
							."        FROM cad_pessoa p "
							."        INNER JOIN cad_evento_participante ep ON ep.id_participante=p.id "
							."        INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
							."        WHERE ep.deletado=".$this::NAO." $filtro "
							."        GROUP BY p.id, p.cpf, p.passaporte, p.nome_completo, p.email, p.id_status "
							."       ) as tabela ";
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
        } catch (PDOException $ex){ throw $ex; }
    }

	
    /**
     * Método para listar os registros
     *
     *   @param int $page A Pagina do registros a ser retornarda
     *   @param int $rows A Quantidade de registro a ser retornardo
     *   @param int $sidx O nome do campo a ser Ordendado
     *   @param int $sord A direcao da ordenacao (ASC ou DESC)
     *   @param int|string $p_Evento O Evento que deseja filtrar
     *   @param int|string $p_Participante A Região que deseja filtrar
     *   @param string $p_Nome Parte do nome que deseja filtrar
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listarCertificados($p_Participante=null){
        try{		
            $filtro='';
			$sord='';
			$sidx='ep.id_evento';
	
            if($p_Participante){
                $filtro .= (is_numeric($p_Participante))? " AND ep.id_participante=$p_Participante ": '';
            } 
            
            $query = "SELECT ep.*, e.nome nome_evento, e.capacidade, e.id_tipo_evento, e.id_parente "
                    ." , p.name nome_participante, e.data_inicial, e.data_final, p.username cpf, p.email "
                    ." , u1.nome AS nome_usuario_acao, t.nome AS nome_tipo_participante "
                    ." FROM cad_evento_participante ep "
                    ." INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
                    ." INNER JOIN m5wat_users p ON p.id=ep.id_participante "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=ep.id_usuario_acao "
					." LEFT JOIN cad_tipo_participante t ON ep.id_tipo_participante=t.id_tipo_participante "
                    ." WHERE ep.deletado=".$this::NAO." $filtro "
                    ." ORDER BY $sidx $sord";

            $this->_query = $query;
            
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
        } catch (PDOException $ex){ throw $ex; }
    }	
	
	
	
}