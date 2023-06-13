<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('PerfilFuncionalidade')){ require_once 'PerfilFuncionalidade.class.php';}
/**
 * Classe DAO de relacionamento Perfil x Funcionalidade
 * 
 */
class PerfilFuncionalidadeDAO extends PDOConnection {

    /**
     *  contrutor da classe PerfilFuncionalidadeDAO
     *
     *  @param string $p_NomeTabela O nome da tabela a ser mapeada
     *  @param string $p_ChavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @param string $p_NomeContador O nome do contador da tabela a ser mapeada
     * 
     *  @return void
     */    
    function __construct($p_NomeTabela='perfil_funcionalidade', $p_ChavePrimaria='id_perfil_funcionalidade', $p_NomeContador=''){
        try{
            parent::__construct($p_NomeTabela, $p_ChavePrimaria, $p_NomeContador);
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *    função interna para carregar objeto com os dados do registro.
     *
     *   @param object $Item O Objeto do tipo Registro do Banco de Dados
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    private static function carregarModelo($p_Item){
        try{
            if ($p_Item) {
                $obj = new PerfilFuncionalidade();
                $obj->setId($p_Item['id_perfil_funcionalidade']);
                $obj->setIdFuncionalidade($p_Item["id_funcionalidade"]);
                $obj->setDescricaoFuncionalidade($p_Item["descricao_funcionalidade"]);
                $obj->setIdPerfil($p_Item["id_perfil"]);
                $obj->setNomePerfil($p_Item["nome_perfil"]);
                $obj->setIdModulo($p_Item["id_modulo"]);
                $obj->setNomeModulo($p_Item["nome_modulo"]);	
				$obj->setNomeModuloPai($p_Item["nome_modulo_pai"]);
                
                $obj->setDeletado($p_Item['deletado']);
                $obj->setAcao($p_Item['acao']);
                $obj->setIdUsuarioAcao($p_Item['id_usuario_acao']);
                $obj->setNomeUsuarioAcao((isset($p_Item['nome_usuario_acao']))? $p_Item['nome_usuario_acao']: '');
                $obj->setDataAcao($p_Item['data_acao']);
                return $obj;
            } else return null;
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *    função para gravar um registro novo.
     *
     *   @param object $obj O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
     */
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_perfil_funcionalidade (acao, data_acao, id_usuario_acao, deletado, id_perfil, id_funcionalidade)"
                                             ." VALUES ('incluir',     NOW(),  :IdUsuarioAcao,        0, :IdPerfil, :IdFuncionalidade)";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':IdPerfil', $obj->getIdPerfil());
            $stmt->bindValue(':IdFuncionalidade', $obj->getIdFuncionalidade());

            // Executo a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else{
                $obj->setId($this->_conexao->lastInsertId()); 
                return true;
            }
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *    função para retornar um registro pelo Identificador do registro.
     *
     *   @param int $p_Id O Identificador do registro
     *   @return object $obj O Objeto do tipo do Modelo desta classe
     */
    public function retornar($p_Id){
        try{
            // Preparo a query
            $query = "SELECT td.*, t.nome AS nome_funcionalidade, d.nome AS nome_perfil
                        FROM cad_perfil_funcionalidade td
                        INNER JOIN cad_funcionalidade t ON td.id_funcionalidade=t.id_funcionalidade
                        INNER JOIN cad_perfil d ON td.id_perfil=d.id_perfil
                        WHERE td.id_perfil_funcionalidade=:Id";
                        
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);

            // Passa os paramentros para a query 
            $stmt->bindValue(':Id', $p_Id);

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
     *    função para retornar um registro pelo Identificador do registro.
     *
     *   @param int $p_Id O Identificador do registro
     *   @return object $obj O Objeto do tipo do Modelo desta classe
     */
    public function retornarPerfilFuncionalidade($p_IdPerfil, $p_IdFuncionalidade){
        try{
            // Preparo a query
            $query = "SELECT pf.*, f.descricao AS descricao_funcionalidade, p.nome AS nome_perfil
                        FROM cad_perfil_funcionalidade pf
                        INNER JOIN cad_funcionalidade f ON pf.id_funcionalidade=f.id_funcionalidade
                        INNER JOIN cad_perfil p ON pf.id_perfil=p.id_perfil
                        WHERE pf.id_perfil=:IdPerfil AND pf.id_funcionalidade=:IdFuncionalidade AND pf.deletado=0 ";
                        
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdPerfil', $p_IdPerfil);
			$stmt->bindValue(':IdFuncionalidade', $p_IdFuncionalidade);

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
     *    função para retornar um registro pelo Identificador combindo
     *
     *   @param int $p_IdPerfil O Identificador do IdPerfil
     *   @param int $p_IdFuncionalidade O Identificador da Funcionalidade
     *   @return object $obj O Objeto do tipo do Modelo desta classe
     */
    public function listarPerfilFuncionalidade($p_IdPerfil){
        try{
            $query = "SELECT pf.*, f.descricao AS descricao_funcionalidade, p.nome AS nome_perfil, m.nome AS nome_modulo, u.nome AS nome_usuario_acao, mp.nome AS nome_modulo_pai
                        FROM cad_perfil_funcionalidade pf
                        INNER JOIN cad_funcionalidade f ON pf.id_funcionalidade=f.id_funcionalidade
                        INNER JOIN cad_perfil p ON pf.id_perfil=p.id_perfil
						INNER JOIN cad_modulo m ON f.id_modulo=m.id_modulo
						INNER JOIN cad_modulo mp ON m.id_modulo_pai=mp.id_modulo
						LEFT JOIN cad_usuario u ON pf.id_usuario_acao=u.id_usuario
                        WHERE pf.deletado=0 AND f.deletado=0 
						AND pf.id_perfil=$p_IdPerfil";
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
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            }
        } catch (PDOException $ex){ throw $ex; }

    }
    
    /**
     *    função para retornar um registro pelas Chave combindas
     *
     *   @param int $p_IdPerfil O Identificador do IdPerfil
     *   @param int $p_ChaveModulo A Chave do Módulo
     *   @param int $p_ChaveFuncionalidade A Chave da Funcionalidade
     *   @return object $obj O Objeto do tipo do Modelo desta classe
     */
    public function retornarPorChave($p_IdPerfil, $p_ChaveModulo, $p_ChaveFuncionalidade){
        try{
            // Preparo a query
            $query = "SELECT pf.*, p.nome AS nome_perfil, f.nome AS nome_funcionalidade"
                    ." FROM cad_perfil_funcionalidade pf "
                    ." INNER JOIN cad_perfil p ON p.id_perfil=pf.id_perfil"
                    ." INNER JOIN cad_funcionalidade f ON f.id_funcionalidade=pf.id_funcionalidade "
                    ." INNER JOIN cad_modulo m ON m.id_modulo=f.id_modulo"
                    ." WHERE (p.deletado='".$this::NAO."' AND p.id_perfil=:IdPerfil) "
                    ." AND (m.deletado='".$this::NAO."' AND m.chave=:ChaveModulo) "
                    ." AND (f.deletado='".$this::NAO."' AND f.chave=:ChaveFuncionalidade) ";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdPerfil', $p_IdPerfil);
            $stmt->bindValue(':ChaveModulo', $p_ChaveModulo);
            $stmt->bindValue(':ChaveFuncionalidade', $p_ChaveFuncionalidade);

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
     *    função para atualizar um registro.
     *
     *   @param object O Objeto do tipo do Modelo desta classe
     *   @return boolean Flag que indica que a operaçãoo foi concluída com sucesso
     */
    public function atualizar($obj){
        try{
            // Preparo a query 
            $query = "UPDATE cad_perfil_funcionalidade SET "
                    ." acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, id_perfil=:IdPerfil, id_funcionalidade=:IdFuncionalidade "
                    ." WHERE id_perfil_funcionalidade=:Id";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':IdPerfil', $obj->getIdPerfil());
            $stmt->bindValue(':IdFuncionalidade', $obj->getIdFuncionalidade());
            $stmt->bindValue(':Id', $obj->getId());

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else {
                return true;
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     *    função para recuperar o registro.
     *
     *   @param int $p_Id O Identificador do registro desta classe
     *   @return boolean Flag que indica que a operação foi concluída com sucesso
     */
    public function recuperar($p_Id){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("UPDATE cad_perfil_funcionalidade SET acao='recuperar', data_acao=".$this::NOW.", id_usuario_acao=:idFuncionalidade, deletado='".$this::NAO."' WHERE id_perfil_funcionalidade=:id");

            // Passa os paramentros para a query 
            $stmt->bindValue(':idFuncionalidade', $this->_idUsuario);
            $stmt->bindValue(':id', $p_Id);

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else {
                return true;
            }
        } catch (PDOException $ex){ throw $ex; }
    }    
    
    /**
     *    função para excluir o registro.
     *
     *   @param int $p_Id O Identificador do registro desta classe
     *   @return boolean Flag que indica que a operação foi concluída com sucesso
     */
    public function excluir($p_Id){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("UPDATE cad_perfil_funcionalidade SET acao='excluir', data_acao=NOW(), id_usuario_acao=:IdUsuarioAcao, deletado=1 WHERE id_perfil_funcionalidade=:Id");

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Id', $p_Id);

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else {
                return true;
            }
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *    função para excluir o registro.
     *
     *   @param int $p_Id O Identificador do registro desta operacao
     *   @return boolean Flag que indica que a operação foi concluída com sucesso
     */
    public function excluirPerfilFuncionalidade($p_IdPerfil, $p_IdFuncionalidade){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("UPDATE cad_perfil_funcionalidade SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:idUsuario, deletado='".$this::SIM."' WHERE id_perfil=:idPerfil AND id_funcionalidade=:idFuncionalidade");

            // Passa os paramentros para a query 
            $stmt->bindValue(':idUsuario', $this->_idUsuario);
            $stmt->bindValue(':idPerfil', $p_IdPerfil);
            $stmt->bindValue(':idFuncionalidade', $p_IdFuncionalidade);

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            } else {
                return true;
            }
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *    função para listar os registros
     *
     *   @param int $p_Pagina A Pagina do registros a ser retornarda
     *   @param int $p_Linhas A Quantidade de registro a ser retornardo
     *   @param int $p_Ordem O nome do campo a ser Ordendado
     *   @param int $p_Direcao A direcao da ordenacao (ASC ou DESC)
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $id_modulo=null, $id_funcionalidade=null, $id_perfil=null){
        try{
            $filtro='';
            if(!$sidx) $sidx = 1;
            if(!$sord) $sord = '';
            if($sidx == 'IdPerfilFuncionalidade') $sidx = 'td.id_perfil_funcionalidade';
            if($sidx == 'IdPerfil') $sidx = 'td.id_perfil';
            if($sidx == 'IdFuncionalidade') $sidx = 'td.id_funcionalidade';
            if($sidx == 'DataAcao') $sidx = 'td.data_acao';
            if($sidx == 'NomeFuncionalidade') $sidx = 'f.nome';
            if($sidx == 'NomePerfil') $sidx = 'd.nome';
            if($id_modulo) $filtro .= " AND f.id_modulo=$id_modulo ";
            if($id_funcionalidade) $filtro .= " AND td.id_funcionalidade=$id_funcionalidade ";
            if($id_perfil) $filtro .= " AND td.id_perfil=$id_perfil ";
            
            $query = "SELECT td.*, f.nome AS nome_funcionalidade, d.nome AS nome_perfil, u.nome nome_usuario_acao
                        FROM cad_perfil_funcionalidade td
                        INNER JOIN cad_funcionalidade f ON td.id_funcionalidade=f.id_funcionalidade
                        INNER JOIN cad_perfil d ON td.id_perfil=d.id_perfil
						LEFT JOIN cad_usuario u ON td.id_usuario_acao=u.id_usuario
                        WHERE td.deletado='".$this::NAO."' AND f.deletado='".$this::NAO."' $filtro
                        ORDER BY $sidx $sord";
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
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            }
        } catch (PDOException $ex){ throw $ex; }
    }
 
}