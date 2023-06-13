<?php
//if(!class_exists('PDOLog')){ require_once 'PDOLog.class.php';}
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('LogAcao')){ require_once 'LogAcao.class.php';}
/**
 * Classe DAO de acesso a dados LogAcao
 * 
 * @package Model.DAO
 * @category DAO
 * @since   2015-05-21
 * @version 1.6
 * @author  Kellen Nery
 * 
 * 
 * @edit    2012-07-08<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Implementação da documentação 
 *          #1.06
 */
class LogAcaoDAO extends PDOConnection {
	
    /**
     *  contrutor da classe ContaGerenciaDAO
     *
     *  @param string $p_NomeTabela O nome da tabela a ser mapeada
     *  @param string $p_ChavePrimaria O nome da chave primária da tabela a ser mapeada
     * 
     *  @return void
     */    
    function __construct($p_NomeTabela='acao', $p_ChavePrimaria='id_acao'){
        try{
            parent::__construct($p_NomeTabela, $p_ChavePrimaria);
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
				$obj = new LogAcao();
                $obj->setId($p_Item['id_log_acao']);
                $obj->setIdModulo($p_Item['id_modulo']);
                $obj->setChave($p_Item['chave']);
                $obj->setClasse($p_Item['classe']);
                $obj->setIdFuncionalidade($p_Item['id_funcionalidade']);
                $obj->setParametros((isset($p_Item['parametros']))? $p_Item['parametros']: '{}');
                $obj->setIdentificador($p_Item['identificador']);
				
                $obj->setAcao($p_Item['acao']);
				$obj->setIP($p_Item['ip']);
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
            $query = "INSERT INTO log_acao (data_acao, id_usuario_acao, id_modulo, chave, classe, id_funcionalidade, acao, parametros, identificador, ip) VALUES (".$this::NOW.", :IdUsuarioAcao, :IdModulo, :Chave, :Classe, :IdFuncionalidade, :Acao, :Parametros, :Identificador, :IP); ";
            //$this->setQuery($query);
            
            $stmt = $this->_conexao->prepare($query);
			
			// Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario );
			($obj->getIdModulo())? $stmt->bindValue(':IdModulo', $obj->getIdModulo()): $stmt->bindValue(':IdModulo', null);
            $stmt->bindValue(':Chave', $obj->getChave());
            $stmt->bindValue(':Classe', $obj->getClasse());
            ($obj->getIdFuncionalidade())? $stmt->bindValue(':IdFuncionalidade', $obj->getIdFuncionalidade()): $stmt->bindValue(':IdFuncionalidade', null);
            $stmt->bindValue(':Acao', $obj->getAcao());
            $stmt->bindValue(':Parametros', $obj->getParametros());
			$stmt->bindValue(':Identificador', $obj->getIdentificador());
			$stmt->bindValue(':IP', $obj->getIP());
            
            // Executo a query preparada
            if ($stmt->execute()){
                $obj->setId($this->getInsertId()); 
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
	*   @param int $p_Id O Identificador do registro
	*   @return object $Modelo O Objeto do tipo do Modelo desta classe
	*/
    public function retornar($p_Id){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("SELECT t.* FROM log_acao t WHERE t.id_log_acao=:Id");

            // Passa os paramentros para a query 
            $stmt->bindValue(':Id', $p_Id);

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
	* Método para listar os registros
	*
	*   @param int $p_Pagina A Pagina do registros a ser retornarda
	*   @param int $p_Linhas A Quantidade de registro a ser retornardo
	*   @param int $p_Ordem O id_funcionalidade do campo a ser Ordendado
	*   @param int $p_Direcao A direcao da ordenacao (ASC ou DESC)
	*   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
	*/
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $id_usuario=null, $id_modulo=null, $id_funcionalidade=null){
        try{
            $filtro='';
            if($sidx == 'IdLogAcao') $sidx = 't.id_log_acao';
            if($sidx == 'IdModulo') $sidx = 't.id_modulo';
			if($id_usuario) $filtro .= " AND t.id_usuario=$id_usuario ";
			if($id_modulo) $filtro .= " AND t.id_modulo=$id_modulo ";
			if($id_funcionalidade) $filtro .= " AND t.id_funcionalidade IN ($id_funcionalidade) ";
			if(!$sidx) $sidx = ' t.id_log_acao ';
			if(!$sord) $sord = ' DESC ';
			
			// Preparo a query
            $query = "SELECT t.*
						FROM log_acao t
						WHERE t.deletado=false AND t.ativo=true $filtro
                        ORDER BY $sidx $sord";
						
			// Preparo a Paginação
			if ($rows){
				$queryCount = "SELECT count(*) AS count "
								." FROM log_acao t "
								." WHERE t.deletado=false AND t.ativo=true $filtro";
				$rsCount = $this->_conexao->prepare($queryCount);
				$rsCount->execute();
				$item = $rsCount->fetch(PDO::FETCH_ASSOC);				
				if($item){
					self::setTotalRegistros($item['count']);
				}
				$query .= self::definirPaginacao($page, $rows);
			}
			
			// Executa a query
			$this->_query = $query;
            $rs = $this->_conexao->query($query);
            if($rs){
                $listagem = array();
                foreach ($rs as $item){
                    $listagem[] = self::carregarModelo($item);
                }
                return $listagem;
            } else {
				$this->_erro = $this->_conexao->errorInfo();
				//$this->_query = $stmt->queryString;
                //throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            }
        } catch (PDOException $ex){ throw $ex; }
    }

}