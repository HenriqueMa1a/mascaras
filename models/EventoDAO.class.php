<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Evento')){ require_once 'Evento.class.php';}
/**
 * Classe DAO de acesso a dados Evento
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
class EventoDAO extends PDOConnection {
    
    private $_NomeStatus = array(0=>'Não definida', 1=>'Cadastrado', 2=>'Confirmado', 3=>'Descontinuado', 4=>'Cancelado', 5=>'Publicado', 6=>'Em Andamento', 7=>'', 8=>'Encerrado', 9=>'Arquivado');
    
    /**
     * Método interna para carregar objeto com os dados do registro.
     *
     *   @param object $Item O Objeto do tipo Registro do Banco de Dados
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    private function carregarModelo($p_Item){
        try{
            if ($p_Item) {
                $obj = new Evento();
                $obj->setIdEvento($p_Item['id_evento']);
                $obj->setIdEmpresa(isset($p_Item['id_empresa'])? $p_Item['id_empresa']: '');
                $obj->setIdParente($p_Item['id_parente']);
                $obj->setIdTipoEvento($p_Item['id_tipo_evento']);
                $obj->setNomeTipoEvento(isset($p_Item['nome_tipo_evento'])? $p_Item['nome_tipo_evento']: '');
                $obj->setIdLocalizacao($p_Item['id_localizacao']);
                $obj->setNomeLocalizacao(isset($p_Item['nome_localizacao'])? $p_Item['nome_localizacao']: '');
                $obj->setSigla($p_Item['sigla']);
                $obj->setNome($p_Item['nome']);
				$obj->setName($p_Item['name']);
                $obj->setCapacidade(intval($p_Item['capacidade']));
                $obj->setDataInicial(isset($p_Item['data_inicial'])? $p_Item['data_inicial']: '');
                $obj->setDataFinal(isset($p_Item['data_final'])? $p_Item['data_final']: '');
                $obj->setCargaHoraria(isset($p_Item['carga_horaria'])? $p_Item['carga_horaria']: '');
                $obj->setTextoCertificado(isset($p_Item['texto_certificado'])? $p_Item['texto_certificado']: '');
                $obj->setObservacao($p_Item['observacao']);
                $obj->setIdStatus($p_Item['id_status']);
                $obj->setNomeStatus(isset($p_Item['id_status'])? $this->_NomeStatus[$p_Item['id_status']]: ''); //$obj->setNomeStatus(isset($p_Item['nome_status'])? $p_Item['nome_status']: '');
                
                // Calculados
                $obj->setSolicitacoes(isset($p_Item['solicitacoes'])? $p_Item['solicitacoes']: 0);
                $obj->setAprovados(isset($p_Item['Aprovados'])? $p_Item['Aprovados']: 0);
                $obj->setReprovados(isset($p_Item['Reprovados'])? $p_Item['Reprovados']: 0);
                $obj->setPresentes(isset($p_Item['presentes'])? $p_Item['presentes']: 0);
                
                $obj->setAtivo($p_Item['ativo']);
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
            $query = "INSERT INTO cad_evento  (     acao, data_acao, id_usuario_acao, id_empresa, id_parente, id_tipo_evento, id_localizacao,  sigla,  nome,  capacidade, data_inicial, data_final, carga_horaria, texto_certificado,  observacao, id_status,   ativo, revisao)"
                                    ." VALUES ('incluir',     NOW(),  :IdUsuarioAcao, :IdEmpresa, :IdParente,  :IdTipoEvento, :IdLocalizacao, :Sigla, :Nome, :Capacidade, :DataInicial, :DataFinal, :CargaHoraria, :TextoCertificado, :Observacao, :IdStatus,  :Ativo,       1)";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':IdEmpresa',      $obj->getIdEmpresa());
            $stmt->bindValue(':IdParente',      $obj->getIdParente());
            $stmt->bindValue(':IdTipoEvento',   $obj->getIdTipoEvento());
            $stmt->bindValue(':IdLocalizacao',  $obj->getIdLocalizacao());
            $stmt->bindValue(':Sigla',          $obj->getSigla());
            $stmt->bindValue(':Nome',           $obj->getNome());
            $stmt->bindValue(':Capacidade',     $obj->getCapacidade());
            $stmt->bindValue(':DataInicial',    $obj->getDataInicial());
            $stmt->bindValue(':DataFinal',      $obj->getDataFinal());
            $stmt->bindValue(':CargaHoraria',   $obj->getCargaHoraria());
            $stmt->bindValue(':TextoCertificado', $obj->getTextoCertificado());
            $stmt->bindValue(':Observacao',     $obj->getObservacao());
            $stmt->bindValue(':IdStatus',       $obj->getIdStatus());
            $stmt->bindValue(':Ativo',          $obj->getAtivo());

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id){ 
                    $Id = $this->_conexao->lastInsertId('cad_evento_id_evento_seq'); // POSTGRSQL
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
                $filtro .= (ctype_digit($p_Id))? " AND e.id_evento=$p_Id ": " AND e.id_evento='$p_Id' ";
            
                // Preparo a query
                $query = "SELECT e.*, p.nome AS nome_tipo_evento, r.nome AS nome_localizacao"
                        ." , u1.nome AS nome_usuario_acao "
                        . ", (SELECT COUNT(*) FROM cad_evento_participante t1 WHERE t1.deletado=false AND t1.id_evento=e.id_evento) AS solicitacoes"
                        . ", (SELECT COUNT(*) FROM cad_evento_participante t2 WHERE t2.deletado=false AND t2.id_evento=e.id_evento AND t2.id_status=2) AS Aprovados"
                        . ", (SELECT COUNT(*) FROM cad_evento_participante t3 WHERE t3.deletado=false AND t3.id_evento=e.id_evento AND (t3.id_status=3 OR t3.id_status=4)) AS Reprovados"
                        . ", (SELECT COUNT(*) FROM cad_evento_participante t3 WHERE t3.deletado=false AND t3.id_evento=e.id_evento AND t3.id_status=6) AS presentes"
                        ." FROM cad_evento e "
                        ." INNER JOIN cad_tipo_evento p ON p.id_tipo_evento=e.id_tipo_evento "
                        ." LEFT JOIN cad_localizacao r ON r.id_localizacao=e.id_localizacao "
                        ." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
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
     * Método para atualizar um registro.
     *
     *   @param object $Modelo O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a opera??o foi conclu?da com sucesso
     */
    public function atualizar($obj){
        try{ 
            // Preparo a query 
            $query = "UPDATE cad_evento "
                    ." SET acao='editar', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao"
                    .", id_parente=:IdParente, id_tipo_evento=:IdTipoEvento, id_localizacao=:IdLocalizacao, sigla=:Sigla, nome=:Nome, capacidade=:Capacidade, data_inicial=:DataInicial, data_final=:DataFinal, carga_horaria=:CargaHoraria, texto_certificado=:TextoCertificado, observacao=:Observacao, id_status=:IdStatus, ativo=:Ativo, revisao=(revisao+1)"
                    ." WHERE id_evento=:Id";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            //$stmt->bindValue(':IdEmpresa',      $obj->getIdEmpresa());
            $stmt->bindValue(':IdParente',      $obj->getIdParente());
            $stmt->bindValue(':IdTipoEvento',   $obj->getIdTipoEvento());
            $stmt->bindValue(':IdLocalizacao',   $obj->getIdLocalizacao());
            $stmt->bindValue(':Sigla',          $obj->getSigla());
            $stmt->bindValue(':Nome',           $obj->getNome());
            $stmt->bindValue(':Capacidade',     $obj->getCapacidade());
            $stmt->bindValue(':DataInicial',    $obj->getDataInicial());
            $stmt->bindValue(':DataFinal',      $obj->getDataFinal());
            $stmt->bindValue(':CargaHoraria',   $obj->getCargaHoraria());
            $stmt->bindValue(':TextoCertificado', $obj->getTextoCertificado());
            $stmt->bindValue(':Observacao',     $obj->getObservacao());
            $stmt->bindValue(':IdStatus',       $obj->getIdStatus());
            $stmt->bindValue(':Ativo',          $obj->getAtivo());
            $stmt->bindValue(':Id',             $obj->getIdEvento());
			
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
     * Método para atualizar o campo IdParente do registro, quando for incluído um novo Evento Principal.
     *
     *   @param int $p_Id O Identificador do registro desta classe
     */
	public function gravarEventoPrincipal($p_Id){
        try{ 
            // Preparo a query 
            $query = "UPDATE cad_evento "
                    ." SET acao='editar', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao"
                    .", id_parente=:Id"
                    ." WHERE id_evento=:Id";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':Id',             $p_Id);
			
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
            $query = "UPDATE cad_evento SET acao='excluir', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao, deletado=true, observacao=null WHERE id_evento=:Id";
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
     * Método para atualizar os registros de participantes.
     *
     *   @param int $p_Id O Identificador do registro desta classe
     *   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
     */
    public function atualizarParticipantes($p_Id=null){
        try{
            
            // Preparo a query
            $count=0;

            /* USUÁRIO X ultimo FORMS_RECORDS */ 
            $query = "UPDATE m5wat_users u SET id_formulario = (SELECT MAX(fr.id) FROM m5wat_facileforms_records fr WHERE fr.user_id=u.id);";
            $this->_query = $query;
            $count+= $this->_conexao->exec($query);
            
            /* EVENTO 2 = DIA 02/05/2016 */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 2, 1, u.id, 1, u.registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='dias' AND c3.value LIKE '%02/05/2016%')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=2);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);

            /* EVENTO 3 = DIA 03/05/2016 */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 3, 1, u.id, 1, registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='dias' AND c3.value LIKE '%03/05/2016%')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=3);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);
            
            /* EVENTO 4 = DIA 04/05/2016 */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 4, 1, u.id, 1, registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='dias' AND c3.value LIKE '%04/05/2016%')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=4);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);
            
            /* EVENTO 5 = DIA 05/05/2016 */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 5, 1, u.id, 1, registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='dias' AND c3.value LIKE '%05/05/2016%')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=5);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);

            /* EVENTO 6 = WORKSHOP 'Governança do Conhecimento' */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 6, 1, u.id, 1, registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='workshop' AND c3.value='Governança do Conhecimento')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=6);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);

            /* EVENTO 7 = WORKSHOP 'Aptâmeros' */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 7, 1, u.id, 1, registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='workshop' AND c3.value='Aptâmeros')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=7);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);

            /* EVENTO 8 = WORKSHOP 'Nanotecnologia aplicada em imunobiológicos' */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 8, 1, u.id, 1, registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='workshop' AND c3.value='Nanotecnologia aplicada em imunobiológicos')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=8);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);

            /* EVENTO 9 = WORKSHOP 'Adjuvantes' */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 9, 1, u.id, 1, registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='workshop' AND c3.value='Adjuvantes')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=9);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);

            /* EVENTO 10 = WORKSHOP 'Arboviroses emergentes: Chikungunya e Zika' */ 
            $query = "INSERT cad_evento_participante (id_evento, id_tipo_participante, id_participante, id_status, data_cadastro, data_acao) "
                ." SELECT 10, 1, u.id, 1, registerDate, NOW() FROM m5wat_users u WHERE id_formulario IN (SELECT c3.record FROM m5wat_facileforms_subrecords c3 WHERE c3.name='workshop' AND c3.value='Arboviroses emergentes:  Chikungunya e Zika')"
                ."     AND u.id NOT IN (SELECT id_participante FROM cad_evento_participante c4 WHERE c4.id_participante=u.id AND id_evento=10);";
            $this->_query .= $query;
            $count+= $this->_conexao->exec($query);
            
            return $count;
            
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     * Método para listar os registros
     *
     *   @param int $page A Pagina do registros a ser retornarda
     *   @param int $rows A Quantidade de registro a ser retornardo
     *   @param int $sidx O nome do campo a ser Ordendado
     *   @param int $sord A direcao da ordenacao (ASC ou DESC)
     *   @param int|string $p_TipoEvento O TipoEvento que deseja filtrar
     *   @param int|string $p_Status A Região que deseja filtrar
     *   @param string $p_Nome Parte do nome que deseja filtrar
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $p_Empresa=null, $p_TipoEvento=null, $p_Localizacao=null, $p_Status=null, $p_Parente=null, $p_Evento=null, $p_Nome=null){
        try{
            $filtro='';
            if($sidx=='IdEvento'){ $sidx='id_evento';}
            if($sidx=='SiglaTipoEvento'){ $sidx='p.sigla';}
            if($sidx=='NomeTipoEvento'){ $sidx='p.nome';}
            if($sidx=='NomeStatus'){ $sidx='r.nome';}
            if($p_Empresa){
                $filtro .= (ctype_digit($p_Empresa))? " AND e.id_empresa=$p_Empresa ": " AND e.id_empresa='$p_Empresa' ";
            }
            if($p_TipoEvento){
                $filtro .= (ctype_digit($p_TipoEvento))? " AND e.id_tipo_evento=$p_TipoEvento ": " AND e.id_tipo_evento IN ($p_TipoEvento) ";
            }
            if($p_Localizacao){
                $filtro .= (ctype_digit($p_Localizacao))? " AND e.id_localizacao=$p_Localizacao ": " AND e.id_localizacao='$p_Localizacao' ";
            }
            if($p_Status){
                $filtro .= (ctype_digit($p_Status))? " AND e.id_status=$p_Status ": " AND e.id_status IN ($p_Status) ";
            }
            //if($p_Parente){
            //    $filtro .= (ctype_digit($p_Parente))? " AND e.id_parente=$p_Parente ": " AND e.id_parente IN ($p_Parente) ";
            //}
            
			//Acrescentando essa condição para quando for necessário buscar somente os eventos Principais 
			if($p_Parente){
                $filtro .= " AND e.id_evento=e.id_parente ";
            }			
			
            if($p_Evento){
                $filtro .= (ctype_digit($p_Evento))? " AND e.id_evento=$p_Evento ": " AND e.id_evento IN($p_Evento) ";
            }
            if($p_Nome) {
                $p_Nome=str_replace(' ', '%', $p_Nome);
                $filtro .= " AND (lower(e.nome) LIKE lower('%$p_Nome%'))";
            }
            
            $query = "SELECT e.*, p.nome nome_tipo_evento, r.nome nome_localizacao "
                    ." , u1.nome AS nome_usuario_acao "
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t1 WHERE t1.deletado=false AND t1.id_evento=e.id_evento) AS solicitacoes"
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t2 WHERE t2.deletado=false AND t2.id_evento=e.id_evento AND t2.id_status=2) AS Aprovados"
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t3 WHERE t3.deletado=false AND t3.id_evento=e.id_evento AND (t3.id_status=3 OR t3.id_status=4)) AS Reprovados"
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t3 WHERE t3.deletado=false AND t3.id_evento=e.id_evento AND t3.id_status=6) AS presentes"
                    ." FROM cad_evento e "
                    ." INNER JOIN cad_tipo_evento p ON p.id_tipo_evento=e.id_tipo_evento "
                    ." LEFT JOIN cad_localizacao r ON r.id_localizacao=e.id_localizacao "
                    ." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
                    ." WHERE e.deletado=false $filtro "
                    ." ORDER BY $sidx $sord";	
			
            $this->_query = $query;
                        
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
        } catch (PDOException $ex){ throw $ex; }
    }
	
    /**
     * Método para listar os registros
     *
     *   @param int $page A Pagina do registros a ser retornarda
     *   @param int $rows A Quantidade de registro a ser retornardo
     *   @param int $sidx O nome do campo a ser Ordendado
     *   @param int $sord A direcao da ordenacao (ASC ou DESC)
     *   @param int|string $p_TipoEvento O TipoEvento que deseja filtrar
     *   @param int|string $p_Status A Região que deseja filtrar
     *   @param string $p_Nome Parte do nome que deseja filtrar
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listarEventosSeminario($page=null, $rows=null, $sidx=null, $sord=null, $p_Empresa=null, $p_TipoEvento=null, $p_Localizacao=null, $p_Status=null, $p_Parente=null, $p_Evento=null, $p_Nome=null){
        try{
            $filtro='';
            if($sidx=='IdEvento'){ $sidx='id_evento';}
            if($sidx=='SiglaTipoEvento'){ $sidx='p.sigla';}
            if($sidx=='NomeTipoEvento'){ $sidx='p.nome';}
            if($sidx=='NomeStatus'){ $sidx='r.nome';}
            if($p_Empresa){
                $filtro .= (ctype_digit($p_Empresa))? " AND e.id_empresa=$p_Empresa ": " AND e.id_empresa='$p_Empresa' ";
            }
            if($p_TipoEvento){
                $filtro .= (ctype_digit($p_TipoEvento))? " AND e.id_tipo_evento=$p_TipoEvento ": " AND e.id_tipo_evento IN ($p_TipoEvento) ";
            }
            if($p_Localizacao){
                $filtro .= (ctype_digit($p_Localizacao))? " AND e.id_localizacao=$p_Localizacao ": " AND e.id_localizacao='$p_Localizacao' ";
            }
            if($p_Status){
                $filtro .= (ctype_digit($p_Status))? " AND e.id_status=$p_Status ": " AND e.id_status IN ($p_Status) ";
            }
            if($p_Parente){
                $filtro .= (ctype_digit($p_Empresa))? " AND e.id_parente=$p_Parente ": " AND e.id_parente IN ($p_Parente) ";
            }
            if($p_Evento){
                $filtro .= (ctype_digit($p_Evento))? " AND e.id_evento=$p_Evento ": " AND e.id_evento IN($p_Evento) ";
            }
            if($p_Nome) {
                $p_Nome=str_replace(' ', '%', $p_Nome);
                $filtro .= " AND (lower(e.nome) LIKE lower('%$p_Nome%'))";
            }
            
            $query = "SELECT e.*, p.nome nome_tipo_evento, r.nome nome_localizacao "
                    ." , u1.nome AS nome_usuario_acao "
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t1 WHERE t1.deletado=false AND t1.id_evento=e.id_evento) AS solicitacoes"
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t2 WHERE t2.deletado=false AND t2.id_evento=e.id_evento AND t2.id_status=2) AS Aprovados"
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t3 WHERE t3.deletado=false AND t3.id_evento=e.id_evento AND (t3.id_status=3 OR t3.id_status=4)) AS Reprovados"
                    . ", (SELECT COUNT(*) FROM cad_evento_participante t3 WHERE t3.deletado=false AND t3.id_evento=e.id_evento AND t3.id_status=6) AS presentes"
                    ." FROM cad_evento e "
                    ." INNER JOIN cad_tipo_evento p ON p.id_tipo_evento=e.id_tipo_evento "
                    ." LEFT JOIN cad_localizacao r ON r.id_localizacao=e.id_localizacao "
                    ." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
                    ." WHERE e.ativo=true and e.id_evento!=e.id_parente "
					." and e.deletado=false $filtro "
                    ." ORDER BY $sidx $sord";	
			
            $this->_query = $query;
                        
            // Paginacao
            if ($rows){
                $queryCount= "SELECT count(e.*) AS count "
                            ." FROM cad_evento e "
                            ." INNER JOIN cad_tipo_evento p ON p.id_tipo_evento=e.id_tipo_evento "
                            ." LEFT JOIN cad_localizacao r ON r.id_localizacao=e.id_localizacao "
                            ." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
							." WHERE e.ativo=true and e.id_evento!=e.id_parente "
							." and e.deletado=false $filtro ";
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
     * Método para listar todos os eventos e subeventos que estiverem ativos.
     *
     */
    public function retornarEventoAtivo(){
        try{
			// Preparo a query
			$query = "SELECT e.*, p.nome AS nome_tipo_evento, r.nome AS nome_localizacao"
					." , u1.nome AS nome_usuario_acao "
					. ", (SELECT COUNT(*) FROM cad_evento_participante t1 WHERE t1.deletado=false AND t1.id_evento=e.id_evento) AS solicitacoes"
					. ", (SELECT COUNT(*) FROM cad_evento_participante t2 WHERE t2.deletado=false AND t2.id_evento=e.id_evento AND t2.id_status=2) AS Aprovados"
					. ", (SELECT COUNT(*) FROM cad_evento_participante t3 WHERE t3.deletado=false AND t3.id_evento=e.id_evento AND (t3.id_status=3 OR t3.id_status=4)) AS Reprovados"
					. ", (SELECT COUNT(*) FROM cad_evento_participante t3 WHERE t3.deletado=false AND t3.id_evento=e.id_evento AND t3.id_status=6) AS presentes"
					." FROM cad_evento e "
					." INNER JOIN cad_tipo_evento p ON p.id_tipo_evento=e.id_tipo_evento "
					." LEFT JOIN cad_localizacao r ON r.id_localizacao=e.id_localizacao "
					." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
					." WHERE e.ativo=true";
			$this->_query = $query;
			
            // Paginacao
            if ($rows){
                $queryCount= "SELECT count(*) AS count "
							." FROM cad_evento e "
							." INNER JOIN cad_tipo_evento p ON p.id_tipo_evento=e.id_tipo_evento "
							." LEFT JOIN cad_localizacao r ON r.id_localizacao=e.id_localizacao "
							." LEFT JOIN cad_usuario u1 ON e.id_usuario_acao=u1.id_usuario "
							." WHERE e.ativo=true";
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
     * função para retornar um único registro, o Evento Principal Ativo para as inscrições.
     *
     * @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarEventoPrincipalAtivo(){
        try{
            // Preparo a query 
            $query = "SELECT e.* "
                    ." FROM cad_evento e "				
                    ." WHERE e.ativo=true and e.id_evento=e.id_parente ";			

            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Executo a query preparada
            $stmt->execute();
            
            // Pega o resultado da query executada
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            if($item){
                return self::carregarModelo($item);
            } else{
                return null;
            }
        } catch (PDOException $ex){ throw $ex; }
    }	
	
    /**
     * função para verificar se o Evento Principal tem subEventos.
     *
     * @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function EventoComSubEventos($p_Id){
        try{
            // Preparo a query 
            $query = "SELECT COUNT(*) as quantidade "
                    ." FROM cad_evento e "				
                    ." WHERE e.id_parente=$p_Id ";			
		
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Executo a query preparada
            $stmt->execute();
            
            // Pega o resultado da query executada
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
			
            if($item['quantidade'] > 1){
                return true;
            } else{
                return false;
            }
        } catch (PDOException $ex){ throw $ex; }
    }	


    /**
     * função para retornar a quantidade de subeventos.
     *
     * @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function QtdSubEventos($p_Id){
        try{
            // Preparo a query 
            $query = "SELECT COUNT(*) as quantidade "
                    ." FROM cad_evento e "				
                    ." WHERE e.id_parente=$p_Id ";			
		
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Executo a query preparada
            $stmt->execute();
            
            // Pega o resultado da query executada
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            if($item){
                return $item['quantidade'];
            } else{
                return null;
            }

        } catch (PDOException $ex){ throw $ex; }
    }	
	
}