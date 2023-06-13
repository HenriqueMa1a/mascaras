<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Distribuicao')){ require_once 'Distribuicao.class.php';}

/**
 * Classe DAO de acesso a dados Distribuicao
 * 
 */
class DistribuicaoDAO extends PDOConnection {

    //private $_NomeStatus = array(0=>'Não definida', 1=>'Pre-Inscrito', 2=>'Inscrito', 3=>'Recusado', 4=>'Cancelada', 5=>'Confirmado', 6=>'Presente', 7=>'', 8=>'', 9=>'');
    private $_NomeStatus = array(0=>'-x-', 1=>'Pendente', 2=>'-x-', 3=>'-x-', 4=>'-x-', 5=>'-x-', 6=>'', 7=>'', 8=>'Parcilal', 9=>'', 10=>'Concluído' );

    /**
     * Método interna para carregar objeto com os dados do registro.
     *
     *   @param object $Item O Objeto do tipo Registro do Banco de Dados
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    private function carregarModelo($p_Item){
		
        try{
            if ($p_Item) {
                $obj = new Distribuicao();
				$obj->setIdDistribuicao($p_Item['id_distribuicao']);
				$obj->setData(isset($p_Item['data'])? $p_Item['data']: '');
				$obj->setIdFuncionario(isset($p_Item['id_funcionario'])? $p_Item['id_funcionario']: null);
				$obj->setNomeFuncionario(isset($p_Item['nome_funcionario'])? $p_Item['nome_funcionario']: '');
				$obj->setModalidade(isset($p_Item['modalidade'])? $p_Item['modalidade']: '');
				$obj->setTipoColaborador(isset($p_Item['tipo_colaborador'])? $p_Item['tipo_colaborador']: '');
				
				$obj->setUoCodigo(isset($p_Item['codigo_uo'])? $p_Item['codigo_uo']: '');
				$obj->setUoAlocacao(isset($p_Item['uo_alocacao'])? $p_Item['uo_alocacao']: '');
				$obj->setUoNivel1(isset($p_Item['nivel1'])? $p_Item['nivel1']: '');
				$obj->setUoNivel2(isset($p_Item['nivel2'])? $p_Item['nivel2']: '');
				$obj->setUoNivel3(isset($p_Item['nivel3'])? $p_Item['nivel3']: '');
				$obj->setUoNivel4(isset($p_Item['nivel4'])? $p_Item['nivel4']: '');
				$obj->setUoNivel5(isset($p_Item['nivel5'])? $p_Item['nivel5']: '');
				
				$obj->setJornadaTrabalho(isset($p_Item['id_jornada_trabalho'])? $p_Item['id_jornada_trabalho']: '');
				$obj->setDescricaoJornada(isset($p_Item['descricao_jornada'])? $p_Item['descricao_jornada']: '');
				$obj->setIdPosto(isset($p_Item['id_posto'])? $p_Item['id_posto']: null);
				$obj->setDescricaoPosto(isset($p_Item['descricao_posto'])? $p_Item['descricao_posto']: '');
				$obj->setQtde(isset($p_Item['qtde'])? $p_Item['qtde']: null);
				$obj->setDeletado(isset($p_Item['deletado'])? $p_Item['deletado']: 0);
				$obj->setAcao(isset($p_Item['acao'])? $p_Item['acao']: '');
				$obj->setDataAcao(isset($p_Item['data_acao'])? $p_Item['data_acao']: '');
				$obj->setIdUsuarioAcao($p_Item['id_usuario_acao']);
				$obj->setNomeUsuarioAcao(isset($p_Item['nome_usuario_acao'])? $p_Item['nome_usuario_acao']: '');
				
                return $obj;
            } else {
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
     *   @param int|string $p_IdEmpresa O Identificador da Empresa
     *   @param int|string $p_IdEvento O Identificador do Evento
     *   @param int|string $p_IdStatus O Status dos registro
     *   @param string $p_Nome Parte do nome que deseja filtrar
     *
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $p_Nome=null, $p_IdPosto=null, $p_DataInicial=null, $p_DataFinal=null, $p_IdFuncionario=null){
        try{
            $filtro='';
            if(($sidx=='nome')||($sidx=='Nome')){ $sidx='f.nome_funcionario';}
			if(($sidx=='data')||($sidx=='Data')){ $sidx='d.data';}
			
            if($p_Nome) {
                $p_Nome=str_replace(' ', '%', $p_Nome);
                $filtro .= " AND (lower(f.nome_funcionario) LIKE lower('%$p_Nome%'))";
            }

            if($p_IdFuncionario) {
                $filtro .= (ctype_digit($p_IdFuncionario))? " AND d.id_funcionario=$p_IdFuncionario ": " AND d.id_funcionario='$p_IdFuncionario' ";
            }			
			
            if($p_IdPosto){
                $filtro .= (ctype_digit($p_IdPosto))? " AND d.id_posto=$p_IdPosto ": " AND d.id_posto='$p_IdPosto' ";
            }	
			
			$dataInicio = date("Y-m-d", strtotime($p_DataInicial));
			$dataFim = date("Y-m-d", strtotime($p_DataFinal));
			
            if( ($p_DataInicial<>null) && ($p_DataFinal<>null) ){  
                $filtro .= " AND DATE(d.data) BETWEEN '$dataInicio' AND '$dataFim' ";
            }			

            $query = "SELECT d.*, f.nome_funcionario, f.id_jornada_trabalho, f.modalidade, j.descricao AS descricao_jornada, "
					." p.descricao AS descricao_posto, u.nome AS nome_usuario_acao, uo.codigo AS codigo_uo, tc.descricao AS tipo_colaborador, "
					." uo.sigla AS uo_alocacao, uo1.sigla AS nivel1, uo2.sigla AS nivel2, uo3.sigla AS nivel3, uo4.sigla AS nivel4, uo5.sigla AS nivel5 "
                    ." FROM cad_distribuicao d "
                    ." INNER JOIN cad_funcionario f ON d.id_funcionario = f.id_funcionario "
					." LEFT JOIN cad_jornada_trabalho j ON j.id_jornada = f.id_jornada_trabalho "
					." LEFT JOIN cad_tipo_colaborador tc ON tc.id_tipo_colaborador = f.tipo_colaborador "
                    ." LEFT JOIN cad_uo uo ON uo.id_uo = f.id_uo_alocacao "
					." LEFT JOIN cad_uo uo1 ON uo1.id_uo = uo.id_uo_nivel1 "
					." LEFT JOIN cad_uo uo2 ON uo2.id_uo = uo.id_uo_nivel2 "
					." LEFT JOIN cad_uo uo3 ON uo3.id_uo = uo.id_uo_nivel3 "
					." LEFT JOIN cad_uo uo4 ON uo4.id_uo = uo.id_uo_nivel4 "
					." LEFT JOIN cad_uo uo5 ON uo5.id_uo = uo.id_uo_nivel5 "					
					." INNER JOIN cad_posto p ON d.id_posto = p.id_posto "
					." LEFT JOIN cad_usuario u ON u.id_usuario = d.id_usuario_acao "
                    ." WHERE d.deletado=0 AND 1=1 $filtro "
                    ." ORDER BY $sidx $sord";
					
            $this->_query = $query;
			
            // Paginacao
            if ($rows){
                $queryCount= "SELECT count(d.*) AS count "
                            ." FROM cad_distribuicao d "
							." INNER JOIN cad_funcionario f ON d.id_funcionario = f.id_funcionario "
							." LEFT JOIN cad_jornada_trabalho j ON j.id_jornada = f.id_jornada_trabalho "
							." LEFT JOIN cad_tipo_colaborador tc ON tc.tipo_colaborador = f.id_tipo_colaborador "
							." LEFT JOIN cad_uo uo ON uo.id_uo = f.id_uo_alocacao "
							." LEFT JOIN cad_uo uo1 ON uo1.id_uo = uo.id_uo_nivel1 "
							." LEFT JOIN cad_uo uo2 ON uo2.id_uo = uo.id_uo_nivel2 "
							." LEFT JOIN cad_uo uo3 ON uo3.id_uo = uo.id_uo_nivel3 "
							." LEFT JOIN cad_uo uo4 ON uo4.id_uo = uo.id_uo_nivel4 "
							." LEFT JOIN cad_uo uo5 ON uo5.id_uo = uo.id_uo_nivel5 "
							." INNER JOIN cad_posto p ON d.id_posto = p.id_posto "
							." LEFT JOIN cad_usuario u ON u.id_usuario = d.id_usuario_acao "						
                            ." WHERE d.deletado=0 AND 1=1 $filtro ";
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
                        $obj = self::carregarModelo($item);
                        $listagem[] = $obj;
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
                $filtro .= (ctype_digit($p_Id))? " AND d.id_distribuicao=$p_Id ": " AND d.id_distribuicao='$p_Id' ";
            
                // Preparo a query
                $query = "SELECT d.*, f.nome_funcionario, f.id_jornada_trabalho, j.descricao AS descricao_jornada, "
						." p.descricao AS descricao_posto, u.nome AS nome_usuario_acao "
						." FROM cad_distribuicao d "
						." INNER JOIN cad_funcionario f ON d.id_funcionario = f.id_funcionario "
						." LEFT JOIN cad_jornada_trabalho j ON j.id_jornada = f.id_jornada_trabalho "
						." INNER JOIN cad_posto p ON d.id_posto = p.id_posto "
						." LEFT JOIN cad_usuario u ON u.id_usuario = d.id_usuario_acao "
                        ." WHERE d.deletado=0 $filtro";
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
     * Método para gravar um registro novo.
     *
     *   @param object $obj O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
     */
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_distribuicao  (     acao, data_acao, id_usuario_acao, deletado,  id_funcionario, id_posto,              data,  qtde)"
                                          ." VALUES ('incluir',     NOW(),  :IdUsuarioAcao,        0,  :IdFuncionario, :IdPosto, :DataDistribuicao, :Qtde)";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',   $this->_idUsuario);
            $stmt->bindValue(':IdFuncionario',   $obj->getIdFuncionario());
            $stmt->bindValue(':IdPosto',         $obj->getIdPosto());
			$stmt->bindValue(':Qtde',       	 $obj->getQtde());
			$stmt->bindValue(':DataDistribuicao',$obj->getData());

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                $obj->setIdDistribuicao($Id); 
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
     * Método para atualizar um registro.
     *
     *   @param object $Modelo O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a opera??o foi conclu?da com sucesso
     */
    public function atualizar($obj){
        try{
            // Preparo a query 
            $query = "UPDATE cad_distribuicao"
                    ." SET acao='editar', data_acao=now(), id_usuario_acao=:IdUsuarioAcao, data=:DataDistribuicao, id_funcionario=:IdFuncionario, id_posto=:IdPosto, qtde=:Qtde "
                    ." WHERE id_distribuicao=:Id";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', 		$this->_idUsuario);
            $stmt->bindValue(':DataDistribuicao',   $obj->getData());
            $stmt->bindValue(':IdFuncionario', 		$obj->getIdFuncionario());
            $stmt->bindValue(':IdPosto', 	   		$obj->getIdPosto());
            $stmt->bindValue(':Qtde',          		$obj->getQtde());
			$stmt->bindValue(':Id',            		$obj->getIdDistribuicao());

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
            $query = "UPDATE cad_distribuicao SET acao='excluir', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao, deletado=1 WHERE id_distribuicao=:Id";
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
		
    
}