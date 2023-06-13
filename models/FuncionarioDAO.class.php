<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Funcionario')){ require_once 'Funcionario.class.php';}

/**
 * Classe DAO de acesso a dados Funcionario
 * 
 */
class FuncionarioDAO extends PDOConnection {

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
                $obj = new Funcionario();
                $obj->setIdFuncionario($p_Item['id_funcionario']);
				$obj->setCpf(isset($p_Item['cpf'])? $p_Item['cpf']: null);
				$obj->setCodigoCartao(isset($p_Item['codigo_cartao'])? $p_Item['codigo_cartao']: '');
				$obj->setIdTipoColaborador(isset($p_Item['tipo_colaborador'])? $p_Item['tipo_colaborador']: '');
				$obj->setTipoColaborador(isset($p_Item['descricao_tipo_colaborador'])? $p_Item['descricao_tipo_colaborador']: '');
				$obj->setTipoColaboradorAtivo(isset($p_Item['tipo_colaborador_ativo'])? $p_Item['tipo_colaborador_ativo']: 0);
				$obj->setNomeFuncionario(isset($p_Item['nome_funcionario'])? $p_Item['nome_funcionario']: '');
				$obj->setVinculo(isset($p_Item['vinculo'])? $p_Item['vinculo']: '');
				$obj->setModalidade(isset($p_Item['modalidade'])? $p_Item['modalidade']: '');
				
				$origem='';
				if (isset($p_Item['nivel5'])){
					$origem = $p_Item['nivel5'];
				}
				if (isset($p_Item['nivel4'])){
					$origem .= '/'.$p_Item['nivel4'];
				}
				if (isset($p_Item['nivel3'])){
					$origem .= '/'.$p_Item['nivel3'];
				}	
				if (isset($p_Item['nivel2'])){
					$origem .= '/'.$p_Item['nivel2'];
				}					
				$obj->setOrigemUO($origem ? $origem : null);
				
                $obj->setIdUoAlocacao(isset($p_Item['id_uo_alocacao'])? $p_Item['id_uo_alocacao']: null);
                $obj->setUoAlocacao($p_Item['sigla']);
				$obj->setUoAlocacaoAtivo(isset($p_Item['uo_ativo'])? $p_Item['uo_ativo']: 0);
				
				$obj->setJornadaTrabalho(isset($p_Item['id_jornada_trabalho'])? $p_Item['id_jornada_trabalho']: '');
				$obj->setDescricaoJornada(isset($p_Item['descricao_jornada'])? $p_Item['descricao_jornada']: '');
				$obj->setQtdMascaras(isset($p_Item['qtd_mascaras'])? $p_Item['qtd_mascaras']: '');
				
                $obj->setHorario(isset($p_Item['horario'])? $p_Item['horario']: '');       
				$obj->setObservacao(isset($p_Item['observacao'])? $p_Item['observacao']: '');       
				$obj->setDataCadastro(isset($p_Item['data_cadastro'])? $p_Item['data_cadastro']: '');
                $obj->setAcao(isset($p_Item['acao'])? $p_Item['acao']: '');
                $obj->setDataAcao(isset($p_Item['data_acao'])? $p_Item['data_acao']: '');
                $obj->setIdUsuarioAcao($p_Item['id_usuario_acao']);
				$obj->setNomeUsuarioAcao(isset($p_Item['nome'])? $p_Item['nome']: '');
                $obj->setAtivo(isset($p_Item['ativo'])? $p_Item['ativo']: 0);
				$obj->setDeletado(isset($p_Item['deletado'])? $p_Item['deletado']: 0);
				
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
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $p_Nome=null, $p_Alocacao=null, $p_Vinculo=null, $p_Modalidade=null, $p_Jornada=null, $p_TipoColaborador=null){
        try{
            $filtro='';
            if(($sidx=='nome')||($sidx=='Nome')){ $sidx='f.nome_funcionario';}
			
            if($p_Nome) {
                $p_Nome=str_replace(' ', '%', $p_Nome);
                $filtro .= " AND (lower(f.nome_funcionario) LIKE lower('%$p_Nome%'))";
            }			

            if($p_Alocacao){
                $filtro .= (ctype_digit($p_Alocacao))? " AND f.id_uo_alocacao=$p_Alocacao ": " AND f.id_uo_alocacao='$p_Alocacao' ";
            }	
			
            if($p_Vinculo){
                $filtro .= (ctype_digit($p_Vinculo))? " AND f.vinculo=$p_Vinculo ": " AND f.vinculo='$p_Vinculo' ";
            }	

            if($p_Modalidade){
                $filtro .= (ctype_digit($p_Modalidade))? " AND f.modalidade=$p_Modalidade ": " AND f.modalidade='$p_Modalidade' ";
            }				

            if($p_Jornada){
                $filtro .= (ctype_digit($p_Jornada))? " AND f.id_jornada_trabalho=$p_Jornada ": " AND f.id_jornada_trabalho='$p_Jornada' ";
            }	

            if($p_TipoColaborador){
                $filtro .= (ctype_digit($p_TipoColaborador))? " AND f.tipo_colaborador=$p_TipoColaborador ": " AND f.tipo_colaborador='$p_TipoColaborador' ";
            }				

            $query = "SELECT f.*, uo.sigla, u.nome, j.descricao AS descricao_jornada, j.qtd_mascaras, tc.descricao AS descricao_tipo_colaborador, "
					." uo1.sigla AS nivel1, uo2.sigla AS nivel2, uo3.sigla AS nivel3, uo4.sigla AS nivel4, uo5.sigla AS nivel5 "
                    ." FROM cad_funcionario f "
                    ." LEFT JOIN cad_uo uo ON uo.id_uo = f.id_uo_alocacao "
					." LEFT JOIN cad_uo uo1 ON uo1.id_uo = uo.id_uo_nivel1 "
					." LEFT JOIN cad_uo uo2 ON uo2.id_uo = uo.id_uo_nivel2 "
					." LEFT JOIN cad_uo uo3 ON uo3.id_uo = uo.id_uo_nivel3 "
					." LEFT JOIN cad_uo uo4 ON uo4.id_uo = uo.id_uo_nivel4 "
					." LEFT JOIN cad_uo uo5 ON uo5.id_uo = uo.id_uo_nivel5 "
					." LEFT JOIN cad_usuario u ON u.id_usuario = f.id_usuario_acao "
					." LEFT JOIN cad_jornada_trabalho j ON j.id_jornada = f.id_jornada_trabalho "
					." LEFT JOIN cad_tipo_colaborador tc ON tc.id_tipo_colaborador = f.tipo_colaborador "
                    ." WHERE 1=1 AND f.deletado=0 $filtro "
                    ." ORDER BY $sidx $sord";
			
            $this->_query = $query;

            // Paginacao
            if ($rows){
                $queryCount= "SELECT count(f.*) AS count "
                            ." FROM cad_funcionario f "
							." LEFT JOIN cad_uo uo ON uo.id_uo = f.id_uo_alocacao "
							." LEFT JOIN cad_uo uo1 ON uo1.id_uo = uo.id_uo_nivel1 "
							." LEFT JOIN cad_uo uo2 ON uo2.id_uo = uo.id_uo_nivel2 "
							." LEFT JOIN cad_uo uo3 ON uo3.id_uo = uo.id_uo_nivel3 "
							." LEFT JOIN cad_uo uo4 ON uo4.id_uo = uo.id_uo_nivel4 "
							." LEFT JOIN cad_uo uo5 ON uo5.id_uo = uo.id_uo_nivel5 "
							." LEFT JOIN cad_usuario u ON u.id_usuario = f.id_usuario_acao "
							." LEFT JOIN cad_jornada_trabalho j ON j.id_jornada = f.id_jornada_trabalho "
							." LEFT JOIN cad_tipo_colaborador tc ON tc.id_tipo_colaborador = f.tipo_colaborador "							
                            ." WHERE 1=1 AND f.deletado=0 $filtro ";
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
                $filtro .= (ctype_digit($p_Id))? " AND f.id_funcionario=$p_Id ": " AND f.id_funcionario='$p_Id' ";
            
                // Preparo a query
                $query = "SELECT f.*, uo.sigla, u.nome, j.descricao AS descricao_jornada, j.qtd_mascaras, tc.descricao AS descricao_tipo_colaborador, "
						." uo1.sigla AS nivel1, uo2.sigla AS nivel2, uo3.sigla AS nivel3, uo4.sigla AS nivel4, uo5.sigla AS nivel5, uo.ativo AS uo_ativo, tc.ativo AS tipo_colaborador_ativo "
                        ." FROM cad_funcionario f"
                        ." LEFT JOIN cad_uo uo ON uo.id_uo = f.id_uo_alocacao "
						." LEFT JOIN cad_uo uo1 ON uo1.id_uo = uo.id_uo_nivel1 "
						." LEFT JOIN cad_uo uo2 ON uo2.id_uo = uo.id_uo_nivel2 "
						." LEFT JOIN cad_uo uo3 ON uo3.id_uo = uo.id_uo_nivel3 "
						." LEFT JOIN cad_uo uo4 ON uo4.id_uo = uo.id_uo_nivel4 "
						." LEFT JOIN cad_uo uo5 ON uo5.id_uo = uo.id_uo_nivel5 "
                        ." LEFT JOIN cad_usuario u ON u.id_usuario = f.id_usuario_acao "
						." LEFT JOIN cad_jornada_trabalho j ON j.id_jornada = f.id_jornada_trabalho "
						." LEFT JOIN cad_tipo_colaborador tc ON tc.id_tipo_colaborador = f.tipo_colaborador "
                        ." WHERE f.deletado=0 $filtro";
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
     * Método para retornar um registro pelo Identificador do registro.
     *
     *   @param int|string $p_Id O Identificador ou Código do registro
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarCodigoCartao($p_Id){
        try{
            $filtro = '';
            if($p_Id){
                // Prepara o filtro
                $filtro .= (ctype_digit($p_Id))? " AND f.codigo_cartao=$p_Id ": " AND f.codigo_cartao='$p_Id' ";
            
                // Preparo a query
                $query = "SELECT f.*, uo.sigla, u.nome, j.descricao AS descricao_jornada, j.qtd_mascaras, tc.descricao AS descricao_tipo_colaborador"
						." , uo.ativo AS uo_ativo, tc.ativo AS tipo_colaborador_ativo "
                        ." FROM cad_funcionario f "
                        ." LEFT JOIN cad_uo uo ON uo.id_uo = f.id_uo_alocacao "
                        ." LEFT JOIN cad_usuario u ON u.id_usuario = f.id_usuario_acao "
						." LEFT JOIN cad_jornada_trabalho j ON j.id_jornada = f.id_jornada_trabalho "
						." LEFT JOIN cad_tipo_colaborador tc ON tc.id_tipo_colaborador = f.tipo_colaborador "
                        ." WHERE f.deletado=0 $filtro";
						
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
			$query = "INSERT INTO cad_funcionario  ( acao, data_acao, id_usuario_acao, data_cadastro, ativo, deletado, cpf,  vinculo, id_uo_alocacao, nome_funcionario, id_jornada_trabalho, codigo_cartao, tipo_colaborador,  modalidade,  horario,  observacao)"
									 ." VALUES ('incluir',     NOW(),  :IdUsuarioAcao,	      NOW(),	 1,        0, :Cpf,	:Vinculo,  :IdUoAlocacao,            :Nome,            :Jornada,       :Cartao, :TipoColaborador, :Modalidade, :Horario, :Observacao)";
										  
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':Cpf',      		$obj->getCpf());
            $stmt->bindValue(':Vinculo',        $obj->getVinculo());
            $stmt->bindValue(':IdUoAlocacao', 	$obj->getIdUoAlocacao());
            $stmt->bindValue(':Nome',           $obj->getNomeFuncionario());
            $stmt->bindValue(':Jornada', 	    $obj->getJornadaTrabalho());
            $stmt->bindValue(':Cartao',         $obj->getCodigoCartao());
			$stmt->bindValue(':TipoColaborador',$obj->getIdTipoColaborador());
			$stmt->bindValue(':Modalidade',     $obj->getModalidade());
			//$stmt->bindValue(':DirVd',          $obj->getDirVd());
			$stmt->bindValue(':Horario',        $obj->getHorario());
			$stmt->bindValue(':Observacao',     $obj->getObservacao());

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                $obj->setIdFuncionario($Id); 
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
            $query = "UPDATE cad_funcionario"
					." SET acao='editar', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao, cpf=:Cpf, vinculo=:Vinculo,"
					." id_uo_alocacao=:IdUoAlocacao, nome_funcionario=:Nome, id_jornada_trabalho=:Jornada, codigo_cartao=:Cartao, "
					." tipo_colaborador=:TipoColaborador, modalidade=:Modalidade, horario=:Horario, observacao=:Observacao "
					." WHERE id_funcionario=:Id";
					
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
 
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Cpf',      		$obj->getCpf());
            $stmt->bindValue(':Vinculo',        $obj->getVinculo());
            $stmt->bindValue(':IdUoAlocacao', 	$obj->getIdUoAlocacao());
            $stmt->bindValue(':Nome',           $obj->getNomeFuncionario());
            $stmt->bindValue(':Jornada', 	    $obj->getJornadaTrabalho());
            $stmt->bindValue(':Cartao',         $obj->getCodigoCartao());
			$stmt->bindValue(':TipoColaborador',$obj->getIdTipoColaborador());
			$stmt->bindValue(':Modalidade',     $obj->getModalidade());
			//$stmt->bindValue(':DirVd',          $obj->getDirVd());
			$stmt->bindValue(':Horario',        $obj->getHorario());
			$stmt->bindValue(':Observacao',     $obj->getObservacao());			
            $stmt->bindValue(':Id',        	    $obj->getIdFuncionario());

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
            $query = "UPDATE cad_funcionario SET acao='excluir', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao, deletado=1, ativo=0 WHERE id_funcionario=:Id";
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
     * função para retornar um registro pelo CPF do registro.
     *
     * @param string $p_CPF O CPF da pessoa
     * 
     * @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarPorCPF($p_CPF){
        try{
            // Preparo a query 
            $query = "SELECT f.*, u.nome AS nome_usuario_acao, j.descricao AS descricao_jornada, j.qtd_mascaras "
                    ." FROM cad_funcionario f "
                    ." LEFT JOIN cad_usuario u ON u.id_usuario=f.id_usuario_acao "
					." LEFT JOIN cad_jornada_trabalho j ON j.id_jornada = f.id_jornada_trabalho "
                    ." WHERE f.deletado=0 AND f.cpf='$p_CPF'";
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
     *   função para retornar a quantidade de registro do filtro
     *   @return int $count A quantidade de registro do filtro
     */
     public function contar($p_CPF=null){

        try{
            if($p_CPF){ $filtro .= " AND f.cpf='$p_CPF'";}
            
            // Preparo a query
            $query = "SELECT count(f.id_funcionario) AS count "
                    ." FROM cad_funcionario f "
                    ." WHERE f.deletado=0 $filtro";

            // Executa a query
            $this->_query = $query;
            $rs = $this->_conexao->prepare($query);
            $rs->execute();
            $item = $rs->fetch(PDO::FETCH_ASSOC);                
            if($item){
                return $item['count'];
            } else {
                return 0;
            }
        } catch (PDOException $ex){ throw $ex; }
    }
	
	
	
}