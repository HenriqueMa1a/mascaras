<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Padrao')){ require_once 'Padrao.class.php';}

/**
 * Classe DAO de acesso a dados Padrao
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
class PadraoDAO extends PDOConnection {

    /**
     *  contrutor da classe UsuarioPerfilDAO
     *
     *  @param string $p_NomeTabela O nome da tabela a ser mapeada
     *  @param string $p_ChavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @param string $p_NomeContador O nome do contador da tabela a ser mapeada
     * 
     *  @return void
     */    
    function __construct($p_NomeTabela, $p_ChavePrimaria, $p_NomeContador=null){
        try{
            parent::__construct($p_NomeTabela, $p_ChavePrimaria, $p_NomeContador);
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     * Método interna para carregar objeto com os dados do registro.
     *
     *   @param object $p_Item O Objeto do tipo Registro do Banco de Dados
     *   @return object|null $Modelo O Objeto do tipo do Modelo desta classe
     */
    protected function carregarModelo($p_Item){
        try{
            if ($p_Item) {
                $obj = new Padrao();
                $obj->setId($p_Item[$this->_chavePrimaria]);
                $obj->setSigla($p_Item["sigla"]);
                $obj->setNome($p_Item["nome"]);
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
     *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
     */
    public function salvar($obj){
        try{
            // Preparo a query
            if ($this->_nomeContador){
                $query = "INSERT INTO ".$this->_nomeTabela." (acao, data_acao, id_usuario_acao, ".$this->_chavePrimaria.", sigla, nome, ativo) "
                        ."VALUES "
                        ."('incluir', ".$this::NOW.", :IdUsuarioAcao, ".$this->getContador($this->_nomeContador).", :Sigla, :Nome, :Ativo)";
            } else {
                $query = "INSERT INTO ".$this->_nomeTabela." (acao, data_acao, id_usuario_acao, sigla, nome, ativo) "
                        ."VALUES "
                        ."('incluir', ".$this::NOW.", :IdUsuarioAcao, :Sigla, :Nome, :Ativo)";
            }
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Sigla', $obj->getSigla());
            $stmt->bindValue(':Nome', $obj->getNome());
            $stmt->bindValue(':Ativo', ($obj->getAtivo())? '1': '0');

            // Executo a query preparada
            if ($stmt->execute()){
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id){
                    $Id = $this->_conexao->lastInsertId($this->_nomeTabela."_".$this->_chavePrimaria."_seq"); // POSTGRSQL
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
     *   @return object|null $obj O Objeto do tipo do Modelo desta classe
     */
    public function retornar($p_Id){
        try{
            // Preparo a query
            $query = "SELECT t.*, u1.nome AS nome_usuario_acao FROM ".$this->_nomeTabela." AS t "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=t.id_usuario_acao "
                    ." WHERE t.".$this->_chavePrimaria."=:Id";
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
     *   @param object $obj O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a operaçãoo foi concluída com sucesso
     */
    public function atualizar($obj){
        try{
            // Preparo a query 
            $query = "UPDATE ".$this->_nomeTabela." "
                    ." SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, sigla=:Sigla, nome=:Nome, ativo=:Ativo "
                    ." WHERE ".$this->_chavePrimaria."=:Id";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Sigla', $obj->getSigla());
            $stmt->bindValue(':Nome', $obj->getNome());
            $stmt->bindValue(':Ativo', ($obj->getAtivo())? '1': '0');
            $stmt->bindValue(':Id', $obj->getId());

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
     *   @return boolean true|false $Resultado Flag que indica que a operação foi concluída com sucesso
     */
    public function excluir($p_Id){
        try{
            // Preparo a query
            $query = "UPDATE ".$this->_nomeTabela." "
                    ." SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, deletado='".$this::SIM."', ativo='".$this::NAO."' "
                    ." WHERE ".$this->_chavePrimaria."=:Id";
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
     * Método para listar os registros
     *
     *   @param int $p_Pagina A Pagina do registros a ser retornarda
     *   @param int $p_Linhas A Quantidade de registro a ser retornardo
     *   @param int $p_Ordem O nome do campo a ser Ordendado
     *   @param int $p_Direcao A direcao da ordenacao (ASC ou DESC)
     *   @param int $p_Ids Os identificadores a serem filtrados
     *   @param int $p_Nome O nome a ser filtrado
     * 
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
    public function listar($p_Pagina=null, $p_Linhas=null, $p_Ordem=null, $p_Direcao=null, $p_Ids=null, $p_Nome=null){
        try{
            $filtro = '';
            if(!$p_Ordem){ $p_Ordem = '2'; }
            if($p_Ids){ $filtro .= " AND t.".$this->_chavePrimaria." IN ($p_Ids) ";}
            if($p_Nome){ $filtro .= " AND t.nome LIKE '%$p_Nome%' ";}

            // Preparo a query
            $query = "SELECT t.*, u1.nome AS nome_usuario_acao FROM ".$this->_nomeTabela." AS t "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=t.id_usuario_acao "
                    ."WHERE t.deletado='".$this::NAO."' $filtro "
                    ."ORDER BY $p_Ordem $p_Direcao";
            $this->_query = $query;

            // Paginacao
            if ($p_Linhas){
                $queryCount = "SELECT count(*) AS count FROM ".$this->_nomeTabela." AS t WHERE t.deletado='".$this::NAO."' AND t.ativo='".$this::SIM."' $filtro";
                $rsCount = $this->_conexao->prepare($queryCount);
                $rsCount->execute();
                $item = $rsCount->fetch(PDO::FETCH_ASSOC);				
                if($item){
                    self::setTotalRegistros($item['count']);
                }
                $query .= self::definirPaginacao($p_Pagina, $p_Linhas);
            }

            // Executa a query
            $this->_query = $query;
            $rs = $this->_conexao->query($query);
            if($rs){
                $this->_query = $rs->queryString;
            	$listagem = array();
                foreach ($rs as $item){
                    $listagem[] = self::carregarModelo($item);
                }
                return $listagem;
            } else {
               $arrError = $stmt->errorInfo();
                $this->_erro = ($arrError[0])? $arrError[0]: $arrError[1];
                $this->_mensagem = 'PDO-'.$arrError[2];
            }
        } catch (PDOException $ex){ throw $ex; }
    }

}