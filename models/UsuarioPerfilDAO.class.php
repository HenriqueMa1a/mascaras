<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('UsuarioPerfil')){ require_once 'UsuarioPerfil.class.php';}
/**
 * Classe DAO de acesso a dados UsuarioPerfil
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
class UsuarioPerfilDAO extends PDOConnection {
    
    /**
     *  contrutor da classe que constroi também a super classe PadraoDAO
     *
     *  @param string $p_nomeTabela O nome da tabela a ser mapeada
     *  @param string $p_chavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @return void
     */ 
    function __construct(){
        try{
            parent::__construct('usuario_perfil', 'id_perfil_usuario');
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
                $obj = new UsuarioPerfil();
                $obj->setId($p_Item['id_usuario_perfil']);
                $obj->setIdUsuario($p_Item["id_usuario"]);
                $obj->setNomeUsuario($p_Item["nome_usuario"]);
                $obj->setIdPerfil($p_Item["id_perfil"]);
                $obj->setNomePerfil($p_Item["nome_perfil"]);
                
                $obj->setAtivo($p_Item['ativo']);
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
    *    função para gravar um registro novo.
    *
    *   @param object $obj O Objeto do tipo do Modelo desta classe
    *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
    */
    public function salvar($obj){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("INSERT INTO cad_usuario_perfil (acao, data_acao, id_usuario_acao, id_usuario, id_perfil, ativo) VALUES ('incluir', ".$this::NOW.", ?, ?, ?, true)");
            // Passa os paramentros para a query 
            $stmt->bindValue(1, $this->_idUsuario);
            $stmt->bindValue(2, $obj->getIdUsuario());
            $stmt->bindValue(3, $obj->getIdPerfil());

            // Executo a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else{
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id) $Id = $this->_conexao->lastInsertId('cad_usuario_perfil_id_usuario_perfil_seq'); // POSTGRSQL
                $obj->setId($Id); 
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
            $query = "SELECT td.*, t.nome AS nome_usuario, d.nome AS nome_perfil
                        FROM cad_usuario_perfil td
                        INNER JOIN cad_usuario t ON td.id_usuario=t.id_usuario
                        INNER JOIN cad_perfil d ON td.id_perfil=d.id_perfil
                        WHERE td.id_usuario_perfil=:id";
                        
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);

            // Passa os paramentros para a query 
            $stmt->bindValue(':id', $p_Id);

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
    *   @param int $p_IdUsuario O Identificador da Usuario
    *   @param int $p_IdPerfil O Identificador do IdPerfil
    *   @return object $obj O Objeto do tipo do Modelo desta classe
    */
    public function retornarUsuarioPerfil($p_IdUsuario, $p_IdPerfil){
        try{
            // Preparo a query
            $query = "SELECT td.*, t.nome AS nome_usuario, d.nome AS nome_perfil
                        FROM cad_usuario_perfil td
                        INNER JOIN cad_usuario t ON td.id_usuario=t.id_usuario
                        INNER JOIN cad_perfil d ON td.id_perfil=d.id_perfil
                        WHERE td.id_usuario=:idUsuario AND td.id_perfil=:idPerfil";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);

            // Passa os paramentros para a query 
            $stmt->bindValue(':idUsuario', $p_IdUsuario);
            $stmt->bindValue(':idPerfil', $p_IdPerfil);

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
    *   @param object $Modelo O Objeto do tipo do Modelo desta classe
    *   @return boolean $Resultado Flag que indica que a operaçãoo foi concluída com sucesso
    */
    public function atualizar($obj){
        try{
            // Preparo a query 
            $stmt = $this->_conexao->prepare("UPDATE cad_usuario_perfil SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=?, id_usuario=?, id_perfil=?,  ativo=? WHERE id_usuario_perfil=?");
            // Passa os paramentros para a query 
            $stmt->bindValue(1, $this->_idUsuario);
            $stmt->bindValue(2, $obj->getIdUsuario());
            $stmt->bindValue(3, $obj->getIdPerfil());
            $stmt->bindValue(4, $obj->getAtivo());
            $stmt->bindValue(5, $obj->getId());

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else 
                return true;
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
    *    função para recuperar o registro.
    *
    *   @param int $p_Id O Identificador do registro desta classe
    *   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
    */
    public function recuperar($p_Id){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("UPDATE cad_usuario_perfil SET acao='recuperar', data_acao=".$this::NOW.", id_usuario_acao=:idUsuario, ativo=true WHERE id_usuario_perfil=:id");

            // Passa os paramentros para a query 
            $stmt->bindValue(':idUsuario', $this->_idUsuario);
            $stmt->bindValue(':id', $p_Id);

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else 
                return true;
        } catch (PDOException $ex){ throw $ex; }
    }    
    
    /**
    *    função para excluir o registro.
    *
    *   @param int $p_Id O Identificador do registro desta classe
    *   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
    */
    public function excluir($p_Id){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("UPDATE cad_usuario_perfil SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:idUsuario, deletado=true WHERE id_usuario_perfil=:id");

            // Passa os paramentros para a query 
            $stmt->bindValue(':idUsuario', $this->_idUsuario);
            $stmt->bindValue(':id', $p_Id);

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else 
                return true;
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
    public function listar($page=null, $rows=null, $sidx=null, $sord=null, $id_colegio=null, $id_usuario=null, $id_perfil=null){
        try{
            $filtro='';
            if(!$sidx) $sidx = 1;
            if(!$sord) $sord = '';
            if($sidx == 'IdUsuarioPerfil') $sidx = 'td.id_usuario_perfil';
            if($sidx == 'IdPerfil') $sidx = 'td.id_perfil';
            if($sidx == 'IdUsuario') $sidx = 'td.id_usuario';
            if($sidx == 'DataAcao') $sidx = 'td.data_acao';
            if($sidx == 'NomeUsuario') $sidx = 'u.nome';
            if($sidx == 'NomePerfil') $sidx = 'd.nome';
            if($id_colegio) $filtro .= " AND u.id_colegio=$id_colegio ";
            if($id_usuario) $filtro .= " AND td.id_usuario=$id_usuario ";
            if($id_perfil) $filtro .= " AND td.id_perfil=$id_perfil ";
            
            $query = "SELECT td.*, u.nome AS nome_usuario, d.nome AS nome_perfil
                        FROM cad_usuario_perfil td
                        INNER JOIN cad_usuario u ON td.id_usuario=u.id_usuario
                        INNER JOIN cad_perfil d ON td.id_perfil=d.id_perfil
                        WHERE td.ativo=true AND u.ativo=true $filtro
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