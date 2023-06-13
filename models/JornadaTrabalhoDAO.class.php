<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('JornadaTrabalho')){ require_once 'JornadaTrabalho.class.php';}
/**
 * Classe DAO de acesso a dados JornadaTrabalho
 */
class JornadaTrabalhoDAO extends PDOConnection {

    /**
     *  contrutor da classe UoDAO
     *
     *  @param string $p_NomeTabela O nome da tabela a ser mapeada
     *  @param string $p_ChavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @param string $p_NomeContador O nome do contador da tabela a ser mapeada
     * 
     *  @return void
     */    
    function __construct($p_NomeTabela='cad_jornada_trabalho', $p_ChavePrimaria='id_jornada', $p_NomeContador='GLOBAL'){
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
				$obj = new JornadaTrabalho();
				$obj->setIdJornada($p_Item['id_jornada']);
				$obj->setDescricao($p_Item['descricao']);
				$obj->setQtdMascaras($p_Item['qtd_mascaras']);
				$obj->setDeletado($p_Item['deletado']);
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
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $p_IdJornada=null, $p_Descricao=null){
        try{
			
            $filtro='';
            if($p_IdJornada){
                if(is_numeric($p_IdJornada)){
                    $filtro .= " AND j.id_jornada=$p_IdJornada ";
                } 
            } 
            if($p_Descricao) {
                $p_Descricao=str_replace(' ', '%', $p_Descricao);
                $filtro .= " AND (lower(j.descricao) LIKE lower('%$p_Descricao%'))";
            }
            
            $query = "SELECT j.*, u.nome AS nome_usuario_acao "
                       ." FROM cad_jornada_trabalho j "
					   ." LEFT JOIN cad_usuario u on u.id_usuario = j.id_usuario_acao"
                       ." WHERE j.deletado='".$this::NAO."' $filtro "
                       ." ORDER BY $sidx $sord";
    
			// Paginacao
			if ($rows){
				$queryCount = "SELECT count(*) AS count "
                       ." FROM cad_jornada_trabalho j "
					   ." LEFT JOIN cad_usuario u on u.id_usuario = j.id_usuario_acao"
                       ." WHERE j.deletado='".$this::NAO."' $filtro "
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
     * Método para retornar um registro pelo Identificador do registro.
     *
     *   @param int $p_Id O Identificador do registro
     *   
     *   @return object $obj O Objeto do tipo do Modelo desta classe
     */
    public function retornar($p_Id){
        try{
            // Preparo a query
            $query = "SELECT j.*, u.nome  nome_usuario_acao "
                    ." FROM cad_jornada_trabalho j "
                    ." LEFT JOIN cad_usuario u ON j.id_usuario_acao=u.id_usuario "
                    ." WHERE j.id_jornada=:Id ";
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

    /**
     * Método para gravar um registro novo.
     *
     *   @param object $obj O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
     */
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_jornada_trabalho  (     acao, data_acao, id_usuario_acao, deletado, qtd_mascaras,  descricao)"
                                          ." VALUES ('incluir',     NOW(),  :IdUsuarioAcao,        0, :QtdMascaras, :Descricao)";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':Descricao',      $obj->getDescricao());
            $stmt->bindValue(':QtdMascaras',    $obj->getQtdMascaras());

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                $obj->setIdJornada($Id); 
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
            $query = "UPDATE cad_jornada_trabalho"
                    ." SET acao='editar', data_acao=now(), id_usuario_acao=:IdUsuarioAcao, qtd_mascaras=:QtdMascaras, descricao=:Descricao "
                    ." WHERE id_jornada=:Id";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Descricao',      $obj->getDescricao());
            $stmt->bindValue(':QtdMascaras',    $obj->getQtdMascaras());
            $stmt->bindValue(':Id',             $obj->getIdJornada());

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
            $query = "UPDATE cad_jornada_trabalho SET acao='excluir', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao, deletado=1 WHERE id_jornada=:Id";
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