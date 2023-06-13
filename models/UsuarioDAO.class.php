<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Usuario')){ require_once 'Usuario.class.php';}
/**
 * Classe DAO de acesso a dados a entidade Usuario
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
class UsuarioDAO extends PDOConnection {

    /**
     *  contrutor da classe que constroi também a super classe PadraoDAO
     *
     *  @param string $p_nomeTabela O nome da tabela a ser mapeada
     *  @param string $p_chavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @return void
     */ 
    function __construct(){
        try{
            parent::__construct('usuario', 'id_usuario');
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
    *  Metódio interna para carregar objeto com os dados do registro.
    *
    *   @param object $p_Item O Objeto do tipo Registro do Banco de Dados
    *   @return object|null $Modelo O Objeto do tipo do Modelo desta classe
    */
    private static function carregarModelo($p_Item){
        try{
            if ($p_Item) {
                $obj = new Usuario();
                $obj->setId($p_Item['id_usuario']);
                $obj->setChave($p_Item['chave']);
                $obj->setIdTipo($p_Item['id_tipo']);
                $obj->setNomeTipo((isset($p_Item['nome_tipo']))? trim($p_Item['nome_tipo']): '');
                $obj->setIdStatus($p_Item['id_status']);
                $obj->setNomeStatus((isset($p_Item['nome_status']))? trim($p_Item['nome_status']): '');
				$obj->setConta((isset($p_Item['conta']))? trim($p_Item['conta']): '');
				$obj->setNome((isset($p_Item['nome']))? trim($p_Item['nome']): '');
				$obj->setDataNascimento((isset($p_Item['data_nascimento']))? trim($p_Item['data_nascimento']): '');
				$obj->setCPF((isset($p_Item['cpf']))? trim($p_Item['cpf']): '');
				$obj->setEmail((isset($p_Item['email']))? trim($p_Item['email']): '');
				$obj->setObservacao((isset($p_Item['observacao']))? trim($p_Item['observacao']): '');
                $obj->setTelefone((isset($p_Item['telefone']))? trim($p_Item['telefone']): '');
                $obj->setCelular((isset($p_Item['celular']))? trim($p_Item['celular']): '');
				$obj->setImagem((isset($p_Item['imagem']))? trim($p_Item['imagem']): '');
				$obj->setTotalAcesso((isset($p_Item['total_acesso']))? $p_Item['total_acesso']: '');
				$obj->setDataAcesso((isset($p_Item['data_acesso']))? $p_Item['data_acesso']: '');
                $obj->setIdPerfil((isset($p_Item['id_perfil']))? $p_Item['id_perfil']: '');
                $obj->setNomePerfil((isset($p_Item['nome_perfil']))? trim($p_Item['nome_perfil']): '');
                $obj->setAtivo($p_Item['ativo']);
                $obj->setDataCadastro((isset($p_Item['data_cadastro']))? $p_Item['data_cadastro']: '');
                $obj->setDeletado($p_Item['ativo']);
                $obj->setAcao($p_Item['acao']);
                $obj->setDataAcao($p_Item['data_acao']);
                $obj->setIdUsuarioAcao($p_Item['id_usuario_acao']);
                $obj->setNomeUsuarioAcao((isset($p_Item['nome_usuario_acao']))? $p_Item['nome_usuario_acao']: '');
				
				$obj->setIdPosto((isset($p_Item['id_posto']))? $p_Item['id_posto']: '');
				
				$obj->setSenha((isset($p_Item['senha']))? $p_Item['senha']: '');
                
                return $obj;
            } else { 
                return null;
            }
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
    * Metódio para gravar um registro novo.
    *
    *   @param object $obj O Objeto do tipo do Modelo desta classe
    *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
    */
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_usuario "
                    ."(     acao, data_acao, data_cadastro, id_usuario_acao,  chave, id_tipo, id_status, id_perfil,  conta,  email,  nome, data_nascimento,  cpf,  imagem,  observacao,  telefone,  celular,  ativo)"
                    ." VALUES "
                    ."('incluir', ".$this::NOW.", ".$this::NOW.",  :IdUsuarioAcao, :Chave, :IdTipo, :IdStatus, :IdPerfil, :Conta, :Email, :Nome, :DataNascimento, :CPF, :Imagem, :Observacao, :Telefone, :Celular, :Ativo)";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            //$stmt->bindValue(':IdUsuario', $this->getContador('GLOBAL'));
            $stmt->bindValue(':Chave', $obj->getChave());
            $stmt->bindValue(':IdTipo', $obj->getIdTipo());
            $stmt->bindValue(':IdStatus', ($obj->getIdStatus()) ? $obj->getIdStatus() : null);
            $stmt->bindValue(':IdPerfil', $obj->getIdPerfil());
            $stmt->bindValue(':Conta', $obj->getConta());
            $stmt->bindValue(':Email', $obj->getEmail());
            $stmt->bindValue(':Nome', $obj->getNome());
            if ($obj->getDataNascimento()) {
                if ($obj->getDataNascimento()!=''){
                    $stmt->bindValue(':DataNascimento', $obj->getDataNascimento());
                } else { $stmt->bindValue(':DataNascimento', null);}
            } else{  $stmt->bindValue(':DataNascimento', null);}
            $stmt->bindValue(':CPF', ($obj->getCPF()) ? $obj->getCPF() : null);
            $stmt->bindValue(':Imagem', $obj->getImagem());
            $stmt->bindValue(':Observacao', ($obj->getObservacao())? $obj->getObservacao() : null);
            $stmt->bindValue(':Telefone', ($obj->getTelefone()) ? $obj->getTelefone() : null);
            $stmt->bindValue(':Celular', ($obj->getCelular()) ? $obj->getCelular() : null);
            if ($obj->getAtivo()) {
                $stmt->bindValue(':Ativo', '1');
            } else {
                $stmt->bindValue(':Ativo', '0');
            }
            
            // Executo a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            } else{
                $Id = $this->_conexao->lastInsertId(); // MYSQL
                if (!$Id){ 
                    $Id = $this->_conexao->lastInsertId('cad_usuario_id_usuario_seq'); // POSTGRSQL
                } 
                $obj->setId($Id); 
                return true;
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     *  Metódio para retornar um registro pelo Identificador do registro.
     *
     *  @param int $p_Id O Identificador do registro
     *  @return object|null Objeto da classe Usuario
     */
    public function retornar($p_Id){
        try{
            // Preparo a query
            $query = "SELECT u.*, t.nome AS nome_tipo, u2.nome AS nome_usuario_acao, p.nome AS nome_perfil, posto.id_posto, uS.senha  "
                    ." FROM cad_usuario u "
                    ." INNER JOIN cad_tipo_usuario t ON t.id_tipo_usuario=u.id_tipo "
					." LEFT JOIN cad_posto posto ON t.id_posto=posto.id_posto "
                   // ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=u.id_usuario_cadastro "
                    ." LEFT JOIN cad_usuario u2 ON u2.id_usuario=u.id_usuario_acao "
					." LEFT JOIN cad_usuario_senha uS ON uS.id_usuario=u.id_usuario "
                   // ." LEFT JOIN cad_empresa e ON e.id_empresa=u.id_empresa "
                    ." LEFT JOIN cad_perfil p ON p.id_perfil=u.id_perfil "
                    ." WHERE u.id_usuario=:Id";
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
     *  Metódio para retornar um registro pela Chave do registro.
     *
     *  @param string $p_Chave A Chave do registro
     *  @return object|null Objeto da classe Usuario
     */
    public function retornarPorChave($p_Chave){
        try{
            // Preparo a query 
            $query = "SELECT u.*, t.nome AS nome_tipo, u2.nome AS nome_usuario_acao, p.nome AS nome_perfil "
                    ." FROM cad_usuario u "
                    ." INNER JOIN cad_tipo_usuario t ON t.id_tipo_usuario=u.id_tipo "
                    //." LEFT JOIN cad_usuario u1 ON u1.id_usuario=u.id_usuario_cadastro "
                    ." LEFT JOIN cad_usuario u2 ON u2.id_usuario=u.id_usuario_acao "
                    //." LEFT JOIN cad_empresa e ON e.id_empresa=u.id_empresa "
                    ." LEFT JOIN cad_perfil p ON p.id_perfil=u.id_perfil "
                    ." WHERE u.deletado='".$this::NAO."' AND u.chave=:Chave";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':Chave', $p_Chave);

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
     *  Metódio para retornar um registro pelo Email do registro.
     *
     *  @param string $p_Email O e-mail do registro
     *  @return object|null Objeto da classe Usuario
     */
    public function retornarPorEmail($p_Email){
        try{
            // Preparo a query 
			$query = "SELECT u.*, t.nome AS nome_tipo, p.nome AS nome_perfil "
                    ." FROM cad_usuario u "
                    ." LEFT JOIN cad_tipo_usuario t ON t.id_tipo_usuario=u.id_tipo "
                    ." LEFT JOIN cad_perfil p ON p.id_perfil=u.id_perfil "
                    ." WHERE u.deletado='".$this::NAO."' AND u.email=:Email";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':Email', $p_Email);

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
     *  Metódio para retornar um registro pelo Conta do Facebook do registro.
     *
     *  @param string $p_ContaFacebook A Conta do Facebook do registro
     *  @return object|null Objeto da classe Usuario
     */
    public function retornarPorFacebook($p_ContaFacebook){
        try{
            // Preparo a query 
            $query = "SELECT u.*, t.nome AS nome_tipo, u1.nome AS nome_usuario_cadastro, u2.nome AS nome_usuario_acao, e.nome AS nome_empresa, p.nome AS nome_perfil "
                    ." FROM cad_usuario u "
                    ." INNER JOIN cad_tipo_usuario t ON t.id_tipo_usuario=u.id_tipo "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=u.id_usuario_cadastro "
                    ." LEFT JOIN cad_usuario u2 ON u2.id_usuario=u.id_usuario_acao "
                    ." LEFT JOIN cad_empresa e ON e.id_empresa=u.id_empresa "
                    ." LEFT JOIN cad_perfil p ON p.id_perfil=u.id_perfil "
                    ." WHERE u.deletado='".$this::NAO."' AND u.conta_facebook=:ContaFacebook";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':ContaFacebook', $p_ContaFacebook);

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
     *  Metódio para retornar um registro pela Conta do registro.
     *
     *   @param string $p_Conta A Conta da Acesso o registro
     *  @return object|null Objeto da classe Usuario
     */
    public function retornarPorConta($p_Conta){
        try{
            // Preparo a query 
            $query = "SELECT u.*, t.nome AS nome_tipo, u2.nome AS nome_usuario_acao, p.nome AS nome_perfil "
                    ." FROM cad_usuario u "
                    ." INNER JOIN cad_tipo_usuario t ON t.id_tipo_usuario=u.id_tipo "
                    ." LEFT JOIN cad_usuario u2 ON u2.id_usuario=u.id_usuario_acao "
                    ." LEFT JOIN cad_perfil p ON p.id_perfil=u.id_perfil "
                    ." WHERE u.deletado='".$this::NAO."' AND u.conta=:Conta";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':Conta', $p_Conta);

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
     *  Metódio para retornar um registro pelo CPF do usuário.
     *
     *  @param string $p_CPF cpf do usuário 
     *  @return object|null Objeto da classe Usuario
     */
    public function retornarPorCPF($p_CPF){
        try{
            // Preparo a query 
            $query = "SELECT u.*, t.nome AS nome_tipo, u1.nome AS nome_usuario_cadastro, u2.nome AS nome_usuario_acao, e.nome AS nome_empresa, p.nome AS nome_perfil "
                    ." FROM cad_usuario u "
                    ." INNER JOIN cad_tipo_usuario t ON t.id_tipo_usuario=u.id_tipo "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=u.id_usuario_cadastro "
                    ." LEFT JOIN cad_usuario u2 ON u2.id_usuario=u.id_usuario_acao "
                    ." LEFT JOIN cad_empresa e ON e.id_empresa=u.id_empresa "
                    ." LEFT JOIN cad_perfil p ON p.id_perfil=u.id_perfil "
                    ." WHERE u.deletado='".$this::NAO."' AND u.cpf=:CPF";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

            // Passa os paramentros para a query 
            $stmt->bindValue(':CPF', $p_CPF);

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
     *  Metódio para atualizar o registro
     *
     *   @param object O objeto recordset
     *   @return boolean Flag que indica que a operação foi concluída com sucesso
     */
    public function atualizar($obj){
        try{
            // Preparo a query
            $query = "UPDATE cad_usuario "
                    ." SET acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, chave=:Chave"
                    .", id_tipo=:IdTipo, id_perfil=:IdPerfil, ativo=:Ativo, nome=:Nome, data_nascimento=:DataNascimento"
                    .", conta=:Conta, email=:Email, cpf=:CPF, imagem=:Imagem, telefone=:Telefone, celular=:Celular"
                    .", observacao=:Observacao, id_status=:IdStatus "
                    ." WHERE id_usuario=:IdUsuario";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Chave', $obj->getChave());
            $stmt->bindValue(':IdTipo', $obj->getIdTipo());
            $stmt->bindValue(':IdStatus', $obj->getIdStatus());
            //$stmt->bindValue(':IdEmpresa', $obj->getIdEmpresa());
            //$stmt->bindValue(':IdPessoa', $obj->getIdPessoa());
            $stmt->bindValue(':IdPerfil', $obj->getIdPerfil());
            $stmt->bindValue(':Conta', $obj->getConta());
            $stmt->bindValue(':Email', $obj->getEmail());
            $stmt->bindValue(':Nome', $obj->getNome());
            if ($obj->getDataNascimento()) {
                if ($obj->getDataNascimento() != ''){
                    $stmt->bindValue(':DataNascimento', $obj->getDataNascimento());
                } else { $stmt->bindValue(':DataNascimento', null);}
            } else { $stmt->bindValue(':DataNascimento', null); }
            $stmt->bindValue(':CPF', $obj->getCPF());
            $stmt->bindValue(':Imagem', $obj->getImagem());
            $stmt->bindValue(':Observacao', ($obj->getObservacao())? $obj->getObservacao() : null);
            $stmt->bindValue(':Telefone', ($obj->getTelefone()) ? $obj->getTelefone() : null);
            $stmt->bindValue(':Celular', ($obj->getCelular()) ? $obj->getCelular() : null);
            $stmt->bindValue(':Ativo', $obj->getAtivo());
            $stmt->bindValue(':IdUsuario', $obj->getId());
			
            // Executo a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            } else{
                return true;
            }
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     *  Metódio para excluir o registro.
     *
     *  @param int $p_Id O Identificador do registro desta classe
     *  @return boolean Flag que indica que a operação foi concluída com sucesso
     */
    public function excluir($p_Id){
        try{
            // Preparo a query
            $query = "UPDATE cad_usuario "
                    ." SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, ativo='".$this::NAO."', deletado='".$this::SIM."' "
                    ." WHERE id_usuario=:Id";
            $stmt = $this->_conexao->prepare($query);

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao', $this->_idUsuario);
            $stmt->bindValue(':Id', $p_Id);

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            } else {
                return true;
            }
            // caso ocorra um erro, retorna o erro;
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     *  Metódio para excluir o registro.
     *
     *  @param int $p_Id O Identificador do registro
     *  @param int $p_Chave A Chave do registro
     *  @return boolean Flag que indica que a operação foi concluída com sucesso
     */
    public function ativar($p_Id, $p_Chave){
        try{
            // Preparo a query
            $query = "UPDATE cad_usuario "
                    ." SET acao='ativar', data_acao=".$this::NOW.", id_usuario_acao=id_usuario, id_status=10, ativo='".$this::SIM."'"
                    ." WHERE (id_usuario=:Id AND chave=:Chave)";
            $stmt = $this->_conexao->prepare($query);

            // Passa os paramentros para a query 
            $stmt->bindValue(':Id', $p_Id);
            $stmt->bindValue(':Chave', $p_Chave);

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new PDOException('<b>Erro ao executar a Query.</b><br/>['.$stmt->queryString.']<br/>'.$this->_erro[2]);
            } else {
                return true;
            }
            // caso ocorra um erro, retorna o erro;
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *  Metódio para contabilizar acesso ao sistema.
     *
     *  @param int $p_Id O Identificador do registro desta classe
     *  @return boolean Flag que indica que a operação foi concluída com sucesso
     */
    public function registarAcesso($p_Id){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("UPDATE cad_usuario SET data_acesso=".$this::NOW.", total_acesso=total_acesso+1 WHERE id_usuario=:id");

            // Passa os paramentros para a query 
            $stmt->bindValue(':id', $p_Id);

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
     *  Metódio para listar registro
     *
     *  @param int $p_Pagina A Página do registros a ser retornarda
     *  @param int $p_Linhas A Quantidade de registro a ser retornardo
     *  @param string $p_Ordem O nome do campo a ser Ordendado
     *  @param string $p_Direcao A direção da ordenação (ASC ou DESC)
     *  @param int $p_IdTipo O identificador do tipo de usuário
     *  @param int $p_IdStatus O identificador do status de usuário
     *  @param int $p_IdEmpresa O identificador do empresa de usuário
     *  @param int $p_IdPessoa O identificador da pessoa de usuário
     *  @param string $p_Nome O nome do usuário
     *  @param string $p_Email O e-mail do usuário
     *  @param string $p_CPF O nome do usuário
     *  @param string $p_Conta A conta do usuário
     *  @param int $p_IdPerfil O identificador do perfil de usuário
     *  
     *  @return array $listagem O um Array de Objetos do tipo do Modelo desta classe
     */
     public function listar($p_Pagina=null, $p_Linhas=null, $p_Ordem=null, $p_Direcao=null, $p_Nome=null, $p_IdTipo=null, $p_IdPerfil=null){

        try{
            $filtro='';
            if($p_Ordem == 'IdUsuario'){ $p_Ordem = 'id_usuario';}
            if($p_Ordem == 'DataAcao'){ $p_Ordem = 'u.data_acao';}
            if($p_Ordem == 'TotalAcesso'){ $p_Ordem = 'u.total_acesso';}
            if($p_Ordem == 'DataAcesso'){ $p_Ordem = 'u.data_acesso';}
            if($p_Nome){ $filtro .= " AND upper(u.nome) LIKE upper('%$p_Nome%') ";}
			if($p_IdTipo){ $filtro .= " AND u.id_tipo IN ($p_IdTipo) ";}
            if($p_IdPerfil){ $filtro .= " AND u.id_perfil IN ($p_IdPerfil) ";}
            
            // Preparo a query
            $query = "SELECT u.*, t.nome AS nome_tipo, u1.nome AS nome_usuario_acao, p.nome AS nome_perfil "
                        ." FROM cad_usuario u "
                        ." INNER JOIN cad_tipo_usuario t ON t.id_tipo_usuario=u.id_tipo "
						." LEFT JOIN cad_perfil p ON p.id_perfil=u.id_perfil "
                        ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=u.id_usuario_acao "
                        ." WHERE u.deletado='".$this::NAO."' $filtro "
                        ." ORDER BY $p_Ordem $p_Direcao";
						
            // Preparo a Paginação
            if ($p_Linhas){
                $queryCount="SELECT count(*) AS count "
                            ." FROM cad_usuario u "
                            ." WHERE u.deletado='".$this::NAO."' $filtro";
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
    
    /**
     *   função para retornar a quantidade de registro do filtro
     *
     *   @param int $p_IdTipo Identificador do Tipo de usuário
     *   @param int $p_IdStatus Identificador do Status
     *   @param int $p_IdEmpresa Identificador da Empresa
     *   @param int $p_IdPessoa Identificador da Profissao
     *   @param string $p_CPF Campo CPF 
     *   @param string $p_Email Campo Email
     * 
     *   @return int $count A quantidade de registro do filtro
     */
     public function contar($p_IdTipo=null, $p_IdStatus=null, $p_IdEmpresa=null, $p_IdPessoa=null, $p_CPF=null, $p_Email=null){

        try{
            $filtro='';
            if($p_IdTipo){ $filtro .= " AND u.id_tipo IN ($p_IdTipo) ";}
            if($p_IdStatus){ $filtro .= " AND u.id_status IN ($p_IdStatus) ";}
            if($p_IdEmpresa){ $filtro .= " AND u.id_empres=$p_IdEmpresa ";}
            if($p_IdPessoa){ $filtro .= " AND u.id_pessoa=$p_IdPessoa ";}
            if($p_CPF){ $filtro .= " AND ( u.cpf='$p_CPF' OR CAST(u.cpf AS int8)=cast('$p_CPF' AS int8) )";}
            if($p_Email){ $filtro .= " AND u.email = '$p_Email' ";}
            
            // Preparo a query
            $query = "SELECT count(u.id_usuario) AS count "
                    ." FROM cad_usuario u "
                    ." WHERE u.deletado='".$this::NAO."' $filtro";

            // Executa a query
            $this->_query = $query;
            $rs = $this->_conexao->prepare($query);
            $rs->execute();
            $item = $rs->fetch(PDO::FETCH_ASSOC);                
            if($item){
                return $item['count'];
            } else {
                return 0;
            }
        } catch (PDOException $ex){ throw $ex; }
    }
    
}