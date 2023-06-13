<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('EventoPresenca')){ require_once 'EventoPresenca.class.php';}
/**
 * Classe DAO de acesso a dados EventoPresenca
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
class EventoPresencaDAO extends PDOConnection {
    
    /**
     * Método interna para carregar objeto com os dados do registro.
     *
     *   @param object $Item O Objeto do tipo Registro do Banco de Dados
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    private function carregarModelo($p_Item){
        try{
            if ($p_Item) {   
                $obj = new EventoPresenca();
                $obj->setId($p_Item['id_evento_presenca']);
                $obj->setChave(isset($p_Item['chave'])? $p_Item['chave']: '');
                $obj->setIdEvento($p_Item['id_evento']);
                $obj->setNomeEvento(isset($p_Item['nome_evento'])? $p_Item['nome_evento']: ''); // Evento
                $obj->setCargaHoraria(isset($p_Item['carga_horaria'])? $p_Item['carga_horaria']: '00:00'); // Evento
                $obj->setIdParticipante($p_Item['id_participante']);
                $obj->setNomeParticipante(isset($p_Item['nome_participante'])? $p_Item['nome_participante']: '');
                $obj->setCredencial(isset($p_Item['credencial'])? $p_Item['credencial']: '');
                $obj->setNomeCracha(isset($p_Item['nome_cracha'])? $p_Item['nome_cracha']: '');
                $obj->setEntrada(isset($p_Item['entrada'])? $p_Item['entrada']: '');
                $obj->setSaida(isset($p_Item['saida'])? $p_Item['saida']: '');
                $obj->setObservacao(($p_Item['observacao'])? $p_Item['observacao']: '');
                
				$obj->setDeletado($p_Item['deletado']);
                $obj->setRevisao(isset($p_Item['revisao'])? $p_Item['revisao']: 0);
                $obj->setAcao($p_Item['acao']);
                $obj->setIdUsuarioAcao($p_Item['id_usuario_acao']);
                $obj->setNomeUsuarioAcao((isset($p_Item['nome_usuario_acao']))? $p_Item['nome_usuario_acao']: '');
                $obj->setDataAcao($p_Item['data_acao']);
				
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
            $query = "INSERT INTO cad_evento_presenca (     acao,      data_acao, id_usuario_acao,  chave, id_evento, id_participante,        entrada, revisao)"
                                            ." VALUES ('incluir', ".$this::NOW.",  :IdUsuarioAcao, :Chave, :IdEvento, :IdParticipante, ".$this::NOW.",       1);";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
 
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':Chave',          $obj->getChave());
            $stmt->bindValue(':IdEvento',       $obj->getIdEvento());
            $stmt->bindValue(':IdParticipante', $obj->getIdParticipante());

            // Executo a query preparada
            if ($stmt->execute()){ 
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id){ 
                    $Id = $this->_conexao->lastInsertId('cad_evento_presenca_id_evento_presenca_seq'); // POSTGRSQL
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
                // Preparo a query
                $query = "SELECT ep.*, r.nome_cracha, e.nome AS nome_evento, e.carga_horaria"  
                    ." , u1.nome AS nome_usuario_acao "
                        ." FROM cad_evento_presenca ep "
                        ." INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
                        ." LEFT JOIN cad_pessoa r ON r.id=ep.id_participante "
                        ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=ep.id_usuario_acao "
                        ." WHERE ep.id_evento_presenca=:Id;";
                $this->_query = $query;
                $stmt = $this->_conexao->prepare($query);
				
                // Passa os paramentros para a query 
                $stmt->bindValue(':Id', $p_Id);

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
     *   @param int $p_Chave A de identificador do EventoPresencaa
     *
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarPorChave($p_Chave){
        try{
            if ($p_Chave){
                // Preparo a query
                $query = "SELECT ep.*, p.nome_completo AS nome_participante, e.nome AS nome_evento, e.carga_horaria"
                        ." , u1.nome AS nome_usuario_acao "
                        ." FROM cad_evento_presenca ep "
                        ." INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
						." INNER JOIN cad_pessoa p ON p.id=ep.id_participante "
                        ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=ep.id_usuario_acao "
                        ." WHERE ep.deletado='false' AND ep.chave=:Chave;";
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
     * Método para retornar um registro pelo Identificador do Evento e Participante. Apenas quem não está deletado
     *
     *   @param int $p_IdEvento O identificador do Evento
     *   @param int $p_IdParticipante O identificador do Participante
     *
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarPorEventoParticipante($p_IdEvento, $p_IdParticipante){
        try{
            if (($p_IdEvento) && ($p_IdParticipante)){
                // Preparo a query
                $query = "SELECT ep.*, p.nome_cracha, p.resumo, e.nome AS nome_evento, e.carga_horaria"
                        ." , u1.nome AS nome_usuario_acao "
                        ." FROM cad_evento_presenca ep "
                        ." INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
                        ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=ep.id_usuario_acao "
						." LEFT JOIN cad_pessoa p ON p.id=ep.id_participante "
                        ." WHERE ep.deletado=".$this::NAO." AND ep.id_evento=".intval($p_IdEvento)." AND ep.id_participante=".intval($p_IdParticipante).";";
						
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
            } else { return null; }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     * Método para retornar um registro pelo Identificador do Evento e Participante, independente de estar deletado ou não.
     *	 Criado por: KELLEN NERY - 30/01/2017
     *   @param int $p_IdEvento O identificador do Evento
     *   @param int $p_IdParticipante O identificador do Participante
     *
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarRegistroEventoParticipante($p_IdEvento, $p_IdParticipante){
        try{ 
            if (($p_IdEvento) && ($p_IdParticipante)){
                // Preparo a query
                $query = "SELECT ep.*, p.nome_cracha, e.nome AS nome_evento, e.carga_horaria, p.nome_completo as nome_participante"
                        ." , u1.nome AS nome_usuario_acao "
                        ." FROM cad_evento_presenca ep "
                        ." INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
                        ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=ep.id_usuario_acao "
						." LEFT JOIN cad_pessoa p ON p.id=ep.id_participante "
                        ." WHERE ep.id_evento=".intval($p_IdEvento)." AND ep.id_participante=".intval($p_IdParticipante).";";
				
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
            } else { return null; }
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
            $query = "UPDATE cad_evento_presenca "
                    ." SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao"
                    .", chave=:Chave, id_evento=:IdEvento, id_participante=:IdParticipante, credencial=:Credencial, nome_cracha=:NomeCracha "
                    .", entrada=:Entrada, observacao=:Observacao, deletado=:Presenca"
                    .", revisao=(revisao+1)"
                    ." WHERE id_evento_presenca=:Id";
					
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':Chave',          $obj->getChave());
            $stmt->bindValue(':IdEvento',       $obj->getIdEvento());
            $stmt->bindValue(':IdParticipante', $obj->getIdParticipante());
            $stmt->bindValue(':Credencial',     $obj->getCredencial());
            $stmt->bindValue(':NomeCracha',     $obj->getNomeCracha());
            $stmt->bindValue(':Entrada',        $obj->getEntrada());
            //$stmt->bindValue(':Saida',          $obj->getSaida());
            $stmt->bindValue(':Observacao',     $obj->getObservacao());
            $stmt->bindValue(':Id',             $obj->getId());
			$stmt->bindValue(':Presenca',       $obj->getDeletado());

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
            $query = "UPDATE cad_evento_presenca "
                    ." SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, deletado=".$this::SIM 
                    ." WHERE id_evento_presenca=:Id";
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
     * Método para listar os registros
     *
     *   @param int $page A Pagina do registros a ser retornarda
     *   @param int $rows A Quantidade de registro a ser retornardo
     *   @param int $sidx O nome do campo a ser Ordendado
     *   @param int $sord A direcao da ordenacao (ASC ou DESC)
     *   @param int|string $p_Evento O Evento que deseja filtrar
     *   @param int|string $p_Participante A Região que deseja filtrar
     *   @param string $p_Credencial A credencial que deseja filtrar     
     *   @param string $p_Nome Parte do nome que deseja filtrar
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
	 
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $p_Evento=null, $p_Credencial=null, $p_Participante=null, $p_Nome=null){
        try{
            $filtro='';
            if($sidx=='IdEventoPresenca'){ $sidx='id_evento_presenca';}
            if($sidx=='IdEvento'){ $sidx='id_evento';}
            if($sidx=='IdParticipante'){ $sidx='id_participante';}
            if($sidx=='Observacao'){ $sidx='ep.observacao';}
            if($sidx=='NomeEvento'){ $sidx='e.nome';}
            if($sidx=='NomeParticipante'){ $sidx='p.name';}
            if($sidx=='Nome'){ $sidx='p.name';}
            if($p_Evento){
                $filtro .= (is_numeric($p_Evento))? " AND ep.id_evento=$p_Evento ": " AND ep.id_evento IN ($p_Evento) ";
            }
            if($p_Participante){
                $filtro .= (is_numeric($p_Participante))? " AND ep.id_participante=$p_Participante ": '';
            } 
            if($p_Credencial){
                $filtro .= " AND ep.credencial='$p_Credencial' ";
            }
            
            if($p_Nome) {
                $p_Nome=str_replace(' ', '%', $p_Nome);
                $filtro .= " AND (lower(p.name) LIKE lower('%$p_Nome%'))";
            }
            
            $query = "SELECT ep.*, e.nome nome_evento, e.carga_horaria "
                    ." , ep.nome_cracha AS nome_participante "
                    ." , u1.nome AS nome_usuario_acao "
                    ." FROM cad_evento_presenca ep "
                    ." INNER JOIN cad_evento e ON e.id_evento=ep.id_evento "
                    ." LEFT JOIN m5wat_users p ON p.id=ep.id_participante "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=ep.id_usuario_acao "
                    ." WHERE ep.deletado=".$this::NAO." $filtro "
                    ." ORDER BY $sidx $sord";
            $this->_query = $query;
                        
            // Paginacao
            if ($rows){
                $queryCount= "SELECT count(ep.*) AS count "
                            ." FROM cad_evento_presenca ep "
                            ." INNER JOIN cad_evento p ON p.id_evento=ep.id_evento "
                            ." LEFT JOIN m5wat_users p ON p.id=ep.id_participante "
                            ." LEFT JOIN cad_usuario u1 ON ep.id_usuario_acao=u1.id_usuario "
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
}