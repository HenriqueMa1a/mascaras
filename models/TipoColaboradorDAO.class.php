<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('TipoColaborador')){ require_once 'TipoColaborador.class.php';}
/**
 * Classe DAO de acesso a dados TipoColaborador
 */
class TipoColaboradorDAO extends PDOConnection {

    /**
     *  contrutor da classe UoDAO
     *
     *  @param string $p_NomeTabela O nome da tabela a ser mapeada
     *  @param string $p_ChavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @param string $p_NomeContador O nome do contador da tabela a ser mapeada
     * 
     *  @return void
     */    
    function __construct($p_NomeTabela='cad_tipo_colaborador', $p_ChavePrimaria='id_tipo_colaborador', $p_NomeContador='GLOBAL'){
        try{
            parent::__construct($p_NomeTabela, $p_ChavePrimaria, $p_NomeContador);
        } catch (PDOException $ex){ throw $ex; }
    }
    
	/**
	* Método interna para carregar objeto com os dados do registro.
	*
	*   @param object $Item O Objeto do tipo Registro do Banco de Dados
	*   @return object $Modelo O Objeto do tipo do Modelo desta classe
	*/
    private static function carregarModelo($p_Item){
        try{
			if ($p_Item) {
				$obj = new TipoColaborador();
				$obj->setIdTipoColaborador($p_Item['id_tipo_colaborador']);
				$obj->setDescricao($p_Item['descricao']);
				$obj->setAtivo($p_Item['ativo']);
				$obj->setDeletado($p_Item['deletado']);
				$obj->setDataCadastro($p_Item['data_cadastro']);
				$obj->setAcao($p_Item['acao']);
				$obj->setDataAcao($p_Item['data_acao']);
				$obj->setIdUsuarioAcao($p_Item['id_usuario_acao']);
				$obj->setNomeUsuarioAcao($p_Item['nome_usuario_acao']);
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
     *   @param int|string $p_Pais O Pais que deseja filtrar
     *   @param int|string $p_Regiao A Região que deseja filtrar
     *   @param string $p_Nome Parte do nome que deseja filtrar
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $p_IdTipoColaborador=null, $p_Descricao=null){
        try{
	
            $filtro='';
            if($p_IdTipoColaborador){
                if(is_numeric($p_IdTipoColaborador)){
                    $filtro .= " AND tc.id_tipo_colaborador=$p_IdTipoColaborador ";
                } 
            } 
            if($p_Descricao) {
                $p_Descricao=str_replace(' ', '%', $p_Descricao);
                $filtro .= " AND (lower(tc.descricao) LIKE lower('%$p_Descricao%'))";
            }
            
            $query = "SELECT tc.* "
                       ." FROM cad_tipo_colaborador tc "
                       ." WHERE tc.deletado=0 $filtro "
                       ." ORDER BY $sidx $sord";
    
			// Paginacao
			if ($rows){
				$queryCount = "SELECT count(*) AS count "
                       ." FROM cad_tipo_colaborador tc "
                       ." WHERE tc.deletado=0 $filtro "
                       ." ORDER BY $sidx $sord";
				$rsCount = $this->_conexao->prepare($queryCount);
				$rsCount->execute();
				$item = $rsCount->fetch(PDO::FETCH_ASSOC);				
				if($item){
					self::setTotalRegistros($item['count']);
				}
				$query .= self::definirPaginacao($page, $rows);
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
     * Método para atualizar um registro.
     *
     *   @param object $Modelo O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a opera??o foi conclu?da com sucesso
     */
    public function atualizar($obj){
        try{
            // Preparo a query 
            $query = "UPDATE cad_tipo_colaborador"
                    ." SET acao='editar', data_acao=now(), id_usuario_acao=:IdUsuarioAcao, ativo=:Ativo "
                    ." WHERE id_tipo_colaborador=:Id";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Ativo', 		   $obj->getAtivo());
            $stmt->bindValue(':Id',            $obj->getIdTipoColaborador());

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
     * Método para retornar um registro pelo Identificador do registro.
     *
     *   @param int $p_Id O Identificador do registro
     *   
     *   @return object $obj O Objeto do tipo do Modelo desta classe
     */
    public function retornar($p_Id){
        try{
            // Preparo a query
            $query = "SELECT tc.*, u.nome AS nome_usuario_acao "
                    ." FROM cad_tipo_colaborador tc "
                    ." LEFT JOIN cad_usuario u ON tc.id_usuario_acao=u.id_usuario "
                    ." WHERE tc.id_tipo_colaborador=:Id ";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':Id', $p_Id, PDO::PARAM_INT);

            // Executa a query preparada
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
	
	
}