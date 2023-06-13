<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Funcionalidade')){ require_once 'Funcionalidade.class.php';}
/**
 * Classe DAO de acesso a dados Funcionalidade
 */
class FuncionalidadeDAO extends PDOConnection {

    /**
     *  contrutor da classe FuncionalidadeDAO
     *
     *  @param string $p_NomeTabela O nome da tabela a ser mapeada
     *  @param string $p_ChavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @param string $p_NomeContador O nome do contador da tabela a ser mapeada
     * 
     *  @return void
     */    
    function __construct($p_NomeTabela='cad_funcionalidade', $p_ChavePrimaria='id_funcionalidade', $p_NomeContador=''){
        try{
            parent::__construct($p_NomeTabela, $p_ChavePrimaria, $p_NomeContador);
        } catch (PDOException $ex){ throw $ex; }
    }
	
	/**
	* Método interna para carregar objeto com os dados do registro.
	*
	*   @param object $Item O Objeto do tipo Registro do Banco de Dados
	*   @return object $Modelo O Objeto do tipo do Modelo desta operacao
	*/
    private static function carregarModelo($p_Item){
        try{
            if ($p_Item) {
                $obj = new Funcionalidade();
				$obj->setIdFuncionalidade($p_Item['id_funcionalidade']);
				$obj->setIdModulo($p_Item['id_modulo']);
				$obj->setDescricaoModulo((isset($p_Item['descricao_modulo']))? $p_Item['descricao_modulo']: '');
				$obj->setOperacao($p_Item['operacao']);
				$obj->setFuncao($p_Item['funcao']);
				$obj->setNome($p_Item['nome']);
				$obj->setDescricao($p_Item['descricao']);
				$obj->setImagem($p_Item['imagem']);
				$obj->setOrdem((isset($p_Item['ordem']))? $p_Item['ordem']: 0);
				$obj->setParametros((isset($p_Item['parametros']))? $p_Item['parametros']: '{}');
				$obj->setAtivo($p_Item['ativo']);
				$obj->setRevisao($p_Item['revisao']);
				$obj->setDeletado($p_Item['deletado']);
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
    *   @param object $obj O Objeto do tipo do Modelo desta operacao
    *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
    */
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_funcionalidade (acao,  data_acao, id_usuario_acao,  id_modulo,  operacao,  funcao,  nome,  descricao,  imagem,  ordem, parametros,  ativo)"
                                            ."VALUES ('incluir', ".$this::NOW.",  :IdUsuarioAcao,  :IdModulo, :Operacao, :Funcao, :Nome, :Descricao, :Imagem, :Ordem, :Parametros, :Ativo)";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario );
            $stmt->bindValue(':IdModulo', $p_Obj->getIdModulo());
            $stmt->bindValue(':Operacao', $p_Obj->getOperacao());
            $stmt->bindValue(':Funcao', $p_Obj->getFuncao());
            $stmt->bindValue(':Nome', $p_Obj->getNome());
            $stmt->bindValue(':Descricao', $p_Obj->getDescricao());
            $stmt->bindValue(':Imagem', $p_Obj->getImagem());
            $stmt->bindValue(':Ordem', $p_Obj->getOrdem());
            $stmt->bindValue(':Parametros', $p_Obj->getParametros());
            $stmt->bindValue(':Ativo', $p_Obj->getAtivo());

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id) $Id = $this->_conexao->lastInsertId('cad_funcionalidade_id_funcionalidade_seq'); // POSTGRSQL
                $p_Obj->setId($Id); 
                return true;
            } else{
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            }
        } catch (PDOException $ex){ throw $ex; }
    }

	/**
	* Método para retornar um registro pelo Identificador do registro.
	*
	*   @param int $p_Id O Identificador do registro
	*   @return object $Modelo O Objeto do tipo do Modelo desta operacao
	*/
    public function retornar($p_Id){
        try{
            // Preparo a query
            $query = "SELECT f.*, m.chave, m.nome AS nome_modulo, u1.nome AS nome_usuario_acao  "
                    ." FROM cad_funcionalidade f "
                    ." INNER JOIN cad_modulo m ON f.id_modulo=m.id_modulo LEFT JOIN cad_usuario u1 ON u1.id_usuario=f.id_usuario_acao "
                    ." WHERE f.id_funcionalidade=:Id";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':Id', $p_Id);

            // Executo a query preparada
            $stmt->execute();
     
            // Pega o resultado da query executada
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            if($item){
                return self::carregarModelo($item);
            } else{ return null; }
        } catch (PDOException $ex){ throw $ex; }
    }

	/**
	* Método para retornar um registro pelo Identificador do registro.
	*
	*   @param int $Chave A Chave do Módulo
	*   @param int $Operacao A Operação da Funcionalidade
	*   @return object $Modelo O Objeto do tipo do Modelo desta operacao
	*/
    public function retornarPorChave($p_Chave, $p_Operacao){
        try{
            // Preparo a query
            $query = "SELECT f.*, m.chave, m.nome AS nome_modulo, u1.nome AS nome_usuario_acao "
                    ." FROM cad_funcionalidade f "
                    ." INNER JOIN cad_modulo m ON f.id_modulo=m.id_modulo LEFT JOIN cad_usuario u1 ON u1.id_usuario=f.id_usuario_acao "
                    ." WHERE m.chave=:Chave AND f.operacao=:Operacao";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':Chave', $p_Chave);
            $stmt->bindValue(':Operacao', $p_Operacao);

            // Executo a query preparada
            $stmt->execute();
     
            // Pega o resultado da query executada
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            if($item){
                return self::carregarModelo($item);
            } else{ return null; }
        } catch (PDOException $ex){ throw $ex; }
    }
	
    /**
    * Método para retornar um registro pelo Identificador do registro.
    *
    *   @param int $p_Id O Identificador do registro
    *   @return object $Modelo O Objeto do tipo do Modelo desta operacao
    */
    public function retornarPorPerfil($p_IdPerfil, $p_Chave, $p_Operacao){
        try{
            // Preparo a query
            $query = "SELECT f.*, m.chave, m.nome AS nome_modulo, u1.nome AS nome_usuario_acao "
                    . "FROM cad_funcionalidade f "
                    . "INNER JOIN cad_modulo m ON f.id_modulo=m.id_modulo "
                    . "INNER JOIN cad_perfil_funcionalidade pf ON pf.id_funcionalidade=f.id_funcionalidade LEFT JOIN cad_usuario u1 ON u1.id_usuario=f.id_usuario_acao "
                    . "WHERE pf.id_perfil=:IdPerfil AND m.chave=:Chave AND f.operacao=:Operacao";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdPerfil', $p_IdPerfil);
            $stmt->bindValue(':Chave', $p_Chave);
            $stmt->bindValue(':Operacao', $p_Operacao);

            // Executo a query preparada
            $stmt->execute();
     
            // Pega o resultado da query executada
            $item = $stmt->fetch(PDO::FETCH_ASSOC);
            if($item){
                return self::carregarModelo($item);
            } else{ return null; }
        } catch (PDOException $ex){ throw $ex; }
    }	
	
    /**
    * Método para atualizar um registro.
    *
    *   @param object $Modelo O Objeto do tipo do Modelo desta operacao
    *   @return boolean $Resultado Flag que indica que a operação foi concluída com sucesso
    */
    public function atualizar($p_Obj){
        try{
            // Preparo a query 
            $query = "UPDATE cad_funcionalidade "
                    . " SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, id_modulo=:IdModulo, operacao=:Operacao, funcao=:Funcao, nome=:Nome, descricao=:Descricao, imagem=:Imagem, ordem=:Ordem, parametros=:Parametros, ativo=:Ativo "
                    . " WHERE id_funcionalidade=:Id";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario );
            $stmt->bindValue(':IdModulo', $p_Obj->getIdModulo());
            $stmt->bindValue(':Operacao', $p_Obj->getOperacao());
            $stmt->bindValue(':Funcao', $p_Obj->getFuncao());
            $stmt->bindValue(':Nome', $p_Obj->getNome());
            $stmt->bindValue(':Descricao', $p_Obj->getDescricao());
            $stmt->bindValue(':Imagem', $p_Obj->getImagem());
            $stmt->bindValue(':Ordem', $p_Obj->getOrdem());
            $stmt->bindValue(':Parametros', $p_Obj->getParametros());
            $stmt->bindValue(':Ativo', $p_Obj->getAtivo());
            $stmt->bindValue(':Id', $p_Obj->getId());

            // Executa a query preparada
            if ($stmt->execute()){
                return true;
            } else {  
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            }
        } catch (PDOException $ex){ throw $ex; }
    }
	
    /**
    * Método para excluir o registro.
    *
    *   @param int $p_Id O Identificador do registro desta operacao
    *   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
    */
    public function excluir($p_Id){
        try{
            // Preparo a query
            $query = "UPDATE cad_funcionalidade "
                    . " SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, deletado='".$this::SIM."' "
                    . " WHERE id_funcionalidade=:Id";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Id', $p_Id);

            // Executa a query preparada
            if ($stmt->execute()){
                return true;
            } else {  
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
    * Método para excluir o registro.
    *
    *   @param int $p_Id O Identificador do registro desta operacao
    *   @param int $p_IdPerfil O Identificador do Perfil
    *   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
    */
    public function excluirDoPerfil($p_Id, $p_IdPerfil){
        try{
            // Preparo a query
            $query = "UPDATE cad_perfil_funcionalidade "
                    . " SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, deletado='".$this::SIM."' "
                    . " WHERE id_funcionalidade=:Id AND id_perfil=:IdPerfil";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Id', $p_Id);
            $stmt->bindValue(':IdPerfil', $p_IdPerfil);

            // Executa a query preparada
            if ($stmt->execute()){
                return true;
            } else {  
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            }
        } catch (PDOException $ex){ throw $ex; }
    }
	
    /**
    * Método para listar os registros
    *
    *   @param int $p_Pagina A Pagina do registros a ser retornarda
    *   @param int $p_Linhas A Quantidade de registro a ser retornardo
    *   @param int $p_Ordem O nome do campo a ser Ordendado
    *   @param int $p_Direcao A direcao da ordenacao (ASC ou DESC)
    *   @param int $p_Nivel A Nível hieráquico do Modulo
    *   @param int $p_IdModulo O Identificador do Módulo
    *   @param int $p_IdPerfil O Identificador do Perfil
    *   @return array $listagem O um Array de Objetos do tipo do Modelo desta operacao
    */
    public function listarPorPai($p_IdModuloPai){
        try{
            
            $query = "SELECT f.*, m.descricao AS descricao_modulo, u.nome AS nome_usuario_acao "
                    . " FROM cad_funcionalidade f "
                    . " INNER JOIN cad_modulo m ON m.id_modulo=f.id_modulo AND m.deletado=0 "
                    . " LEFT JOIN cad_usuario u ON u.id_usuario=f.id_usuario_acao "
                    . " WHERE f.deletado=0 AND f.ativo=1 AND m.id_modulo_pai = $p_IdModuloPai ";
            
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
            }
        } catch (PDOException $ex){ throw $ex; }
    }
	
    /**
    * Método para listar os registros
    *
    *   @param int $p_Pagina A Pagina do registros a ser retornarda
    *   @param int $p_Linhas A Quantidade de registro a ser retornardo
    *   @param int $p_Ordem O nome do campo a ser Ordendado
    *   @param int $p_Direcao A direcao da ordenacao (ASC ou DESC)
    *   @param int $p_Nivel A Nível hieráquico do Modulo
    *   @param int $p_IdModulo O Identificador do Módulo
    *   @param int $p_IdPerfil O Identificador do Perfil
    *   @return array $listagem O um Array de Objetos do tipo do Modelo desta operacao
    */
    public function listar($p_Pagina=null, $p_Linhas=null, $p_Ordem=null, $p_Direcao='', $p_IdModulo=null, $p_IdPerfil=null){
        try{
            // Filtros
            $join='';
            $filtro='';
            if($p_IdModulo){ $filtro .= " AND f.id_modulo=$p_IdModulo ";}
            if ($p_IdPerfil) {
                $join .= " INNER JOIN cad_perfil_funcionalidade pf ON pf.id_funcionalidade=f.id_funcionalidade ";
                $filtro .= " AND pf.deletado='".$this::NAO."' AND pf.id_perfil=$p_IdPerfil ";
            }
            // Ordenação
            if($p_Ordem == 'IdModulo'){ $p_Ordem = ' f.id_modulo ';}
            if(!$p_Ordem){ $p_Ordem = '1'; }
            
            $query = "SELECT f.*, m.nome AS nome_modulo, m.chave, u1.nome AS nome_usuario_acao "
                    . " FROM cad_funcionalidade f "
                    . " INNER JOIN cad_modulo m ON m.id_modulo=f.id_modulo AND m.deletado='".$this::NAO."' $join "
                    . " LEFT JOIN cad_usuario u1 ON u1.id_usuario=f.id_usuario_acao "
                    . " WHERE f.deletado='".$this::NAO."' AND f.ativo='".$this::SIM."' $filtro "
                    . " ORDER BY $p_Ordem $p_Direcao";
            
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
            }
        } catch (PDOException $ex){ throw $ex; }
    }	
	
	
}