<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Posto')){ require_once 'Posto.class.php';}

/**
 * Classe DAO de acesso a dados Funcionario
 * 
 */
class PostoDAO extends PDOConnection {

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
                $obj = new Posto();
				$obj->setIdPosto($p_Item['id_posto']);
				$obj->setDescricao(isset($p_Item['descricao'])? $p_Item['descricao']: '');
				$obj->setResponsavel(isset($p_Item['responsavel'])? $p_Item['responsavel']: '');
				$obj->setDataCadastro(isset($p_Item['data_cadastro'])? $p_Item['data_cadastro']: '');
                $obj->setAtivo(isset($p_Item['ativo'])? $p_Item['ativo']: 0);
				$obj->setDeletado(isset($p_Item['deletado'])? $p_Item['deletado']: 0);
                $obj->setAcao(isset($p_Item['acao'])? $p_Item['acao']: '');
                $obj->setDataAcao(isset($p_Item['data_acao'])? $p_Item['data_acao']: '');
                $obj->setIdUsuarioAcao($p_Item['id_usuario_acao']);
				$obj->setNomeUsuarioAcao(isset($p_Item['nome'])? $p_Item['nome']: '');
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
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $p_Descricao=null, $p_Responsavel=null){
        try{
            $filtro='';
            if(($sidx=='descricao')||($sidx=='Descricao')){ $sidx='p.descricao';}
			
            if($p_Descricao) {
                $p_Descricao=str_replace(' ', '%', $p_Descricao);
                $filtro .= " AND (lower(p.descricao) LIKE lower('%$p_Descricao%'))";
            }	

            if($p_Responsavel) {
                $p_Responsavel=str_replace(' ', '%', $p_Responsavel);
                $filtro .= " AND (lower(p.responsavel) LIKE lower('%$p_Responsavel%'))";
            }				

            $query = "SELECT p.*, u.nome "
                    ." FROM cad_posto p "
					." LEFT JOIN cad_usuario u ON u.id_usuario = p.id_usuario_acao "
                    ." WHERE 1=1 AND p.deletado=0 $filtro "
                    ." ORDER BY $sidx $sord";
					
            $this->_query = $query;

            // Paginacao
            if ($rows){
                $queryCount= "SELECT count(p.*) AS count "
                            ." FROM cad_posto p "
							." LEFT JOIN cad_usuario u ON u.id_usuario = p.id_usuario_acao "
                            ." WHERE 1=1  AND p.deletado=0 $filtro ";
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
                $filtro .= (ctype_digit($p_Id))? " AND p.id_posto=$p_Id ": " AND p.id_posto='$p_Id' ";
            
                // Preparo a query
                $query = "SELECT p.*, u.nome "
                        ." FROM cad_posto p"
                        ." LEFT JOIN cad_usuario u ON u.id_usuario = p.id_usuario_acao "
                        ." WHERE p.deletado=0 $filtro";
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
            $query = "INSERT INTO cad_posto  (     acao, data_acao, id_usuario_acao, data_cadastro, deletado, descricao, responsavel,   ativo)"
                                   ." VALUES ('incluir',     NOW(),  :IdUsuarioAcao,         NOW(),        0,     :Nome, :Responsavel, :Ativo)";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':Nome',           $obj->getDescricao());
            $stmt->bindValue(':Responsavel',    $obj->getResponsavel());
            $stmt->bindValue(':Ativo',          $obj->getAtivo());

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                $obj->setIdPosto($Id); 
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
            $query = "UPDATE cad_posto"
                    ." SET acao='editar', data_acao=now(), id_usuario_acao=:IdUsuarioAcao, descricao=:Nome, responsavel=:Responsavel, ativo=:Ativo "
                    ." WHERE id_posto=:Id";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', 	$this->_idUsuario);
            $stmt->bindValue(':Nome',			$obj->getDescricao());
            $stmt->bindValue(':Responsavel',    $obj->getResponsavel());
            $stmt->bindValue(':Ativo', 			$obj->getAtivo());
            $stmt->bindValue(':Id',         	$obj->getIdPosto());

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
            $query = "UPDATE cad_posto SET acao='excluir', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao, deletado=1, ativo=0 WHERE id_posto=:Id";
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