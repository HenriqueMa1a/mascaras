<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Endereco')){ require_once 'Endereco.class.php';}
/**
 * Classe DAO de acesso a dados a entidade Endereço
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
class EnderecoDAO extends PDOConnection {

    /**
     *  contrutor da classe EnderecoDAO
     *
     *  @param string $p_NomeTabela O nome da tabela a ser mapeada
     *  @param string $p_ChavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @param string $p_NomeContador O nome do contador da tabela a ser mapeada
     * 
     *  @return void
     */    
    function __construct($p_NomeTabela='endereco', $p_ChavePrimaria='id_endereco', $p_NomeContador=''){
        try{
            parent::__construct($p_NomeTabela, $p_ChavePrimaria, $p_NomeContador);
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *   Método interna para carregar objeto com os dados do registro.
     *
     *   @param object $p_Item O Objeto do tipo Registro do Banco de Dados
     *   @return object Objeto do tipo do Endereço
     */
    private static function carregarModelo($p_Item){
        try{
            if ($p_Item) {
                $obj = new Endereco();
                $obj->setId($p_Item['id_endereco']);
                $obj->setIdEmpresa($p_Item['id_empresa']);
                $obj->setNomeEmpresa(isset($p_Item['nome_empresa'])? $p_Item['nome_empresa']: '');
                $obj->setIdPessoa($p_Item['id_pessoa']);
                $obj->setNomePessoa(isset($p_Item['nome_pessoa'])? $p_Item['nome_pessoa']: '');
                $obj->setTipo(trim($p_Item['tipo']));
                $obj->setDescricao(trim($p_Item['descricao']));

                $obj->setLogradouro(trim($p_Item['logradouro']));
                $obj->setNumero(trim($p_Item['numero']));
                $obj->setComplemento(trim($p_Item['complemento']));
                $obj->setBairro(trim($p_Item['bairro']));
                $obj->setCEP(trim($p_Item['cep']));
                $obj->setIdCidade(trim($p_Item['id_cidade']));
                $obj->setCidade(trim($p_Item['cidade']));
                $obj->setUF($p_Item['uf']);
                $obj->setIdPais($p_Item['id_pais']);
                $obj->setNomePais(isset($p_Item['nome_pais'])? $p_Item['nome_pais']: '');
                $obj->setObservacao(trim($p_Item['observacao']));
                $obj->setIdStatus($p_Item['id_status']);
                $obj->setNomeStatus((isset($p_Item['nome_status']))? $p_Item['nome_status']: '');

                $obj->setRevisao($p_Item['revisao']);
                $obj->setIdUsuarioCadastro($p_Item['id_usuario_cadastro']);
                $obj->setNomeUsuarioCadastro((isset($p_Item['nome_usuario_cadastro']))? $p_Item['nome_usuario_cadastro']: '');
                $obj->setDataCadastro($p_Item['data_cadastro']);
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
     *   Método para gravar um registro novo.
     *
     *   @param object $obj O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
     */
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_endereco "
                    ."(acao,  data_acao, id_usuario_acao, id_empresa, id_pessoa,  tipo,  descricao,  logradouro,  numero,  complemento,  bairro,  cep, id_cidade,  cidade,  uf, id_pais,  observacao,  revisao, id_status, data_cadastro, id_usuario_cadastro) "
                    ." VALUES "
                    ."('incluir', ".$this::NOW.",  :IdUsuarioAcao, :IdEmpresa, :IdPessoa, :Tipo, :Descricao, :Logradouro, :Numero, :Complemento, :Bairro, :CEP, :IdCidade, :Cidade, :UF, :IdPais, :Observacao, :Revisao, :IdStatus,         ".$this::NOW.",  :IdUsuarioCadastro) ";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':IdEmpresa',      $obj->getIdEmpresa());
            $stmt->bindValue(':IdPessoa',       $obj->getIdPessoa());
            $stmt->bindValue(':Tipo',           $obj->getTipo());
            $stmt->bindValue(':Descricao',      $obj->getDescricao());
            $stmt->bindValue(':Logradouro',     $obj->getLogradouro());
            $stmt->bindValue(':Numero',         $obj->getNumero());
            $stmt->bindValue(':Complemento',    $obj->getComplemento());
            $stmt->bindValue(':Bairro',         $obj->getBairro());
            $stmt->bindValue(':CEP',            $obj->getCEP());
            $stmt->bindValue(':IdCidade',       ($obj->getIdCidade())? $obj->getIdCidade(): null);
            $stmt->bindValue(':Cidade',         $obj->getCidade());
            $stmt->bindValue(':UF',             $obj->getUF());
            $stmt->bindValue(':IdPais',         ($obj->getIdPais())? $obj->getIdPais(): null);
            $stmt->bindValue(':Observacao',     $obj->getObservacao());
            $stmt->bindValue(':Revisao',        $obj->getRevisao());
            $stmt->bindValue(':IdStatus',       $obj->getIdStatus());
            $stmt->bindValue(':IdUsuarioCadastro', $this->_idUsuario );
            
            // Executo a query preparada
            if (!$stmt->execute()){
                //$stmt->debugDumpParams();
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else{
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id){
                    $Id = $this->_conexao->lastInsertId('cad_endereco_id_endereco_seq'); // POSTGRSQL
                }
                $obj->setId($Id); 
                return true;
            }
        }catch ( PDOException $ex ){ 
            throw new PDOException($ex);
        }
    }

    /**
     *   Método para retornar um registro pelo Identificador do registro.
     *
     *   @param int $p_Id O Identificador do registro
     *   @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornar($p_Id){
        try{
            // Preparo a query
            $query = "SELECT t.*, e.nome AS nome_empresa, p.nome AS nome_pessoa, s.nome AS nome_status "
                    ." , u1.nome AS nome_usuario_acao, u2.nome AS nome_usuario_cadastro "
                    ." FROM cad_endereco t "
                    ." LEFT JOIN cad_empresa e ON e.id_empresa=t.id_empresa "
                    ." LEFT JOIN cad_pessoa p ON p.id_pessoa=t.id_pessoa "
                    ." LEFT JOIN cad_status s ON s.id_status=t.id_status "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=t.id_usuario_acao "
                    ." LEFT JOIN cad_usuario u2 ON u1.id_usuario=t.id_usuario_cadastro "
                    ." WHERE t.deletado=false AND t.id_endereco=:Id "
                    ." ORDER BY data_cadastro DESC LIMIT 1 OFFSET 0;";
                    
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
            } else{
                return null;
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     *   Método para retornar um registro pelo Identificador da Empresa.
     *
     *   @param int $p_IdEmpresa O Identificador do Empresa
     *   @param int $p_Tipo O tipo de registro {1:'Residencial', 2:'Comercial'}
     *   @return object $Modelo Objeto do tipo Endereço
     */
    public function retornarPorEmpresa($p_IdEmpresa, $p_Tipo=2){
        try{
            // Preparo a query
            $query = "SELECT t.*, e.nome AS nome_empresa, p.nome AS nome_pessoa, s.nome AS nome_status "
                    ." , u1.nome AS nome_usuario_acao, u2.nome AS nome_usuario_cadastro "
                    ." FROM cad_endereco t "
                    ." LEFT JOIN cad_empresa e ON e.id_empresa=t.id_empresa "
                    ." LEFT JOIN cad_pessoa p ON p.id_pessoa=t.id_pessoa "
                    ." LEFT JOIN cad_status s ON s.id_status=t.id_status "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=t.id_usuario_acao "
                    ." LEFT JOIN cad_usuario u2 ON u1.id_usuario=t.id_usuario_cadastro "
                    ." WHERE t.deletado=false AND t.id_empresa=:IdEmpresa ";

            if($p_Tipo){ $query.= " AND t.tipo=$p_Tipo ";}
 
            $query.= " ORDER BY data_cadastro DESC LIMIT 1 OFFSET 0;";
                    
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdEmpresa', $p_IdEmpresa);

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
     *   Método para retornar um registro pelo Identificador da Pessoa.
     *
     *   @param int $p_IdPessoa O Identificador do Pessoa
     *   @param int $p_Tipo O tipo de registro {1:'Residencial', 2:'Comercial'}
     *   @return object $Modelo Objeto do tipo Endereço
     */
    public function retornarPorPessoa($p_IdPessoa, $p_Tipo=1){
        try{
            // Preparo a query
            $query = "SELECT t.*, e.nome AS nome_empresa, p.nome AS nome_pessoa, s.nome AS nome_status "
                    ." , u1.nome AS nome_usuario_acao, u2.nome AS nome_usuario_cadastro "
                    ." FROM cad_endereco t "
                    ." LEFT JOIN cad_empresa e ON e.id_empresa=t.id_empresa "
                    ." LEFT JOIN cad_pessoa p ON p.id_pessoa=t.id_pessoa "
                    ." LEFT JOIN cad_status s ON s.id_status=t.id_status "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=t.id_usuario_acao "
                    ." LEFT JOIN cad_usuario u2 ON u1.id_usuario=t.id_usuario_cadastro "
                    ." WHERE t.deletado=false AND t.id_pessoa=:IdPessoa ";

            if($p_Tipo){ $query.= " AND t.tipo=$p_Tipo ";}
 
            $query.= " ORDER BY data_cadastro DESC LIMIT 1 OFFSET 0;";
                    
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdPessoa', $p_IdPessoa);

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
     *   Método para atualizar um registro.
     *
     *   @param object $obj O Objeto do tipo do Modelo desta classe
     *   @return boolean Se a operação foi concluída com sucesso
     */
    public function atualizar($obj){
        try{
        
            // Preparo a query 
            $query = "UPDATE cad_endereco "
                    ." SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao "
                    .", id_empresa=:IdEmpresa, id_pessoa=:IdPessoa, tipo=:Tipo,  descricao=:Descricao "
                    .", logradouro=:Logradouro, numero=:Numero, complemento=:Complemento,  bairro=:Bairro, cep=:CEP, id_cidade=:IdCidade, cidade=:Cidade, uf=:UF, id_pais=:IdPais "
                    .", observacao=:Observacao, revisao=(revisao+1) "
                    ." WHERE id_endereco=:Id";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario);
            $stmt->bindValue(':IdEmpresa',      $obj->getIdEmpresa());
            $stmt->bindValue(':IdPessoa',       $obj->getIdPessoa());
            $stmt->bindValue(':Tipo',           $obj->getTipo());
            $stmt->bindValue(':Descricao',      $obj->getDescricao());
            $stmt->bindValue(':Logradouro',     $obj->getLogradouro());
            $stmt->bindValue(':Numero',         $obj->getNumero());
            $stmt->bindValue(':Complemento',    $obj->getComplemento());
            $stmt->bindValue(':Bairro',         $obj->getBairro());
            $stmt->bindValue(':CEP',            $obj->getCEP());
            $stmt->bindValue(':IdCidade',       ($obj->getIdCidade())? $obj->getIdCidade(): null);
            $stmt->bindValue(':Cidade',         $obj->getCidade());
            $stmt->bindValue(':UF',             $obj->getUF());
            $stmt->bindValue(':IdPais',         ($obj->getIdPais())? $obj->getIdPais(): null);
            $stmt->bindValue(':Observacao',     $obj->getObservacao());
            $stmt->bindValue(':Id',             $obj->getId());

            // Executo a query preparada
            if (!$stmt->execute()){
                //$stmt->debugDumpParams();
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else{
                return true;
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     *   Método para excluir o registro.
     *
     *   @param int $p_Id O Identificador do registro desta classe
     *   @return boolean TRUE $Resultado Flag que indica que a operação foi concluída com sucesso
     */
    public function excluir($p_Id){
        try{
            // Preparo a query
            $query = "UPDATE cad_endereco "
                    ." SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, deletado=".$this::SIM
                    ." WHERE id_endereco=:Id";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

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
     *   Método para listar os registros com filtro
     *
     *   @param int $p_Pagina A Página do registros a ser retornarda
     *   @param int $p_Linhas A Quantidade de registro a ser retornardo
     *   @param int $p_Ordem O nome do campo a ser Ordendado
     *   @param int $p_Direcao A direção da ordenação (ASC ou DESC)
     * 
     *   @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
     public function listar($p_Pagina=null, $p_Linhas=null, $p_Ordem=null, $p_Direcao=null, $id_empresa=null, $id_pessoa=null, $tipo=null, $id_status=null){

        try{
            $filtro='';
            if($p_Ordem == 'IdEndereco'){ $p_Ordem = 'id_endereco';}
            if($p_Ordem == 'DataAcao'){ $p_Ordem = 't.data_acao';}
            if($p_Ordem == 'DataCadastro'){ $p_Ordem = 't.data_cadastro';}
            if($p_Ordem == 'DataNascimento'){ $p_Ordem = 't.data_nascimento';}
            if(!$p_Ordem){ $p_Ordem = "t.data_cadastro ";}
            if(!$p_Direcao){ $p_Direcao = " desc ";}
            if($id_empresa){ $filtro .= " AND t.id_empresa=$id_empresa ";}
            if($id_pessoa){ $filtro .= " AND t.id_pessoa='$id_pessoa' ";}
            if($tipo){ $filtro .= " AND t.tipo=$tipo ";}
            if($id_status){ $filtro .= " AND t.id_status=$id_status ";}
            
            // Preparo a query
            $query = "SELECT t.*, e.nome AS nome_empresa, p.nome AS nome_pessoa, s.nome AS nome_status "
                    ." , u1.nome AS nome_usuario_acao, u2.nome AS nome_usuario_cadastro "
                    ." FROM cad_endereco t "
                    ." LEFT JOIN cad_empresa e ON e.id_empresa=t.id_empresa "
                    ." LEFT JOIN cad_pessoa p ON p.id_pessoa=t.id_pessoa "
                    ." LEFT JOIN cad_status s ON s.id_status=t.id_status "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=t.id_usuario_acao "
                    ." LEFT JOIN cad_usuario u2 ON u1.id_usuario=t.id_usuario_cadastro "
                    ." WHERE t.deletado=".$this::NAO." $filtro "
                    ." ORDER BY $p_Ordem $p_Direcao";

                    // Preparo a Paginação
            if ($p_Linhas){
                $queryCount = "SELECT count(*) AS count FROM cad_endereco t WHERE t.deletado=".$this::NAO." $filtro";
                $rsCount = $this->_conexao->prepare($queryCount);
                $rsCount->execute();
                $item = $rsCount->fetch(PDO::FETCH_ASSOC);                
                if($item){
                    self::setTotalRegistros($item['count']);
                }
                $query .= self::definirPaginacao($p_Pagina, $p_Linhas);
                //$query .= " LIMIT $p_Pagina,$p_Linhas;";
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
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            }
        } catch (PDOException $ex){ throw $ex; }
    }
 
}