<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('UsuarioSenha')){ require_once 'UsuarioSenha.class.php';}
/**
 * Classe DAO de relacionamento Usuario x Senha
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
class UsuarioSenhaDAO extends PDOConnection {

    
    /**
     *  contrutor da classe que constroi também a super classe PadraoDAO
     *
     *  @param string $p_nomeTabela O nome da tabela a ser mapeada
     *  @param string $p_chavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @return void
     */ 
    function __construct(){
        try{
            parent::__construct('usuario_senha', 'id_usuario_senha');
        } catch (PDOException $ex){ throw $ex; }
    }
    
	/**
	* Método interna para carregar objeto com os dados do registro.
	*
	*   @param object $Item O Objeto do tipo Registro do Banco de Dados
	*
	*   @return object $Modelo O Objeto do tipo do Modelo desta classe
	*/
    private static function carregarModelo($p_Item){
        try{
			if ($p_Item) {
				$obj = new UsuarioSenha();
                $obj->setId($p_Item['id_usuario_senha']);
                $obj->setIdUsuario($p_Item['id_usuario']);
                $obj->setNomeUsuario((isset($p_Item['nome_usuario']))? $p_Item['nome_usuario']: '');
                $obj->setSenha($p_Item['senha']);
                $obj->setTentativa($p_Item['tentativa']);
                $obj->setValidade($p_Item['validade']);
                $obj->setBloqueado((($p_Item['bloqueado']===1) || ($p_Item['bloqueado']===true))? 1: 0);
                
                $obj->setAtivo($p_Item["ativo"]);
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
	*
	*   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
	*/
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_usuario_senha "
                    ."(acao,      data_acao, id_usuario_acao,  senha,  validade, tentativa,  ativo, id_usuario)"
                    ." VALUES "
                    ."('incluir', ".$this::NOW.",  :IdUsuarioAcao, :Senha, :Validade, :Tentativa, :Ativo, :IdUsuario)";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Senha', $obj->getSenha());
			if ($obj->getValidade()) {
				if ($obj->getValidade() != '') {
					$stmt->bindValue(':Validade', $obj->getValidade());
				} else  $stmt->bindValue(':Validade', null);
			} else  $stmt->bindValue(':Validade', null);
            $stmt->bindValue('Tentativa', $obj->getTentativa());
            if ($obj->getAtivo()) { $stmt->bindValue(':Ativo', '1');
                } else { $stmt->bindValue(':Ativo', '0'); }
			$stmt->bindValue(':IdUsuario', $obj->getIdUsuario());

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id){ 
                    $Id = $this->_conexao->lastInsertId('cad_estado_id_estado_seq'); // POSTGRSQL
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
	*   @param int $p_Id O Identificador do registro
	*
	*   @return object $obj O Objeto do tipo do Modelo desta classe
	*   RETORNAR PELO ID DO USUÁRIO
	*/
    public function retornar($p_Id){
        try{
            // Preparo a query
         /*  $query = "SELECT c.*, e.nome nome_estado, i.nome nome_usuario 
                        FROM cad_usuario_senha c
                        INNER JOIN cad_usuario i ON i.id_usuario=c.id_usuario
                        LEFT JOIN cad_estado e ON e.id_estado=e.id_estado
                        WHERE c.id_usuario_senha=:Id";
		*/				
           $query = "SELECT c.*  
                        FROM cad_usuario_senha c
                        WHERE c.id_usuario=:Id";
						
            $this->_query = $query;                        
            $stmt = $this->_conexao->prepare($query);
			
			// Passa os paramentros para a query 
            $stmt->bindValue(':Id', $p_Id, PDO::PARAM_INT);

            // Executa a query preparada
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
	* Método para retornar um registro pelo Identificador do registro.
	*
	*   @param int $p_Id O Identificador do registro
	*
	*   @return object $obj O Objeto do tipo do Modelo desta classe
	*/
    public function retornarUltima($p_IdUsuario){
        try{
            // Preparo a query
           	$query = "SELECT us.*, u.nome nome_usuario "
                    ." FROM cad_usuario_senha us "
                    ." INNER JOIN cad_usuario u ON u.id_usuario=us.id_usuario "
                    ." WHERE us.id_usuario_senha=(SELECT MAX(id_usuario_senha) FROM cad_usuario_senha WHERE deletado='".$this::NAO."' AND id_usuario=".intval($p_IdUsuario).")";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
			
            // Executa a query preparada
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
	*
	*   @return boolean $Resultado Flag que indica que a opera??o foi conclu?da com sucesso
	*/
    public function atualizar($obj){
        try{
            // Preparo a query 
         /*   $query = "UPDATE cad_usuario_senha "
                    ." SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao"
                    .", validade=:Validade, Tentativa=:tentativa, ativo=:Ativo"
                    ." WHERE id_usuario_senha=:Id";  */
            $query = "UPDATE cad_usuario_senha "
                    ." SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao"
                    .", senha=:Senha "
                    ." WHERE id_usuario=:Id";					
					
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
			$stmt->bindValue(':Senha', $obj->getSenha());
			$stmt->bindValue(':Id', $obj->getIdUsuario());
			/*
			if ($obj->getValidade()) {
				if ($obj->getValidade() != '') {
					$stmt->bindValue(':Validade', $obj->getValidade());
				} else  $stmt->bindValue(':Validade', null);
			} else  $stmt->bindValue(':Validade', null);
            $stmt->bindValue('Tentativa', $obj->getTentativa());
            if ($obj->getAtivo()) { $stmt->bindValue(':Ativo', '1');
                } else { $stmt->bindValue(':Ativo', '0'); }
			*/

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
	*
	*   @param int $p_Id O Identificador do registro desta classe
	*
	*   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	*/
    public function excluir($p_Id){
        try{
            // Preparo a query
            $query = "UPDATE cad_usuario_senha SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, deletado='1' WHERE id_usuario_senha=:Id";
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
	*
	*   @param int $p_Id O Identificador do registro desta classe
	*
	*   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
	*/
    public function excluirTodos($p_IdUsuario){
        try{
            // Preparo a query
            $query = "UPDATE cad_usuario_senha SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, deletado='1' WHERE id_usuario=:IdUsuario";
            $this->_query = $query;
            
            $stmt = $this->_conexao->prepare($query);

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
			$stmt->bindValue(':IdUsuario', $p_IdUsuario);

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
	*   @param int $p_Situacao O Situacao da Disciplina
	*   @param int $p_Disciplinas Os Identificadores das Diciplinas
	*   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
	*/
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $id_usuario=null){
        try{
            $filtro='';
            if($sidx == 'IdUsuario') $sidx = 'c.id_usuario';
			if($id_usuario) $filtro .= " AND c.id_usuario=$id_usuario ";
			if(!$sidx) $sidx = 'c.nome';
			
            $query = "SELECT c.*, u.nome nome_usuario 
                        FROM cad_usuario_senha c
                        LEFT JOIN cad_usuario u ON c.id_usuario=u.id_usuario
                        WHERE c.deletado='".$this::NAO."' $filtro
                        ORDER BY $sidx $sord";
			// Paginacao
			if ($rows){
				$queryCount = "SELECT count(*) AS count
							FROM cad_usuario_senha
							WHERE deletado='".$this::NAO."' $filtro";
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

}