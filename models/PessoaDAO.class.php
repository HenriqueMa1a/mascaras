<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('Pessoa')){ require_once 'Pessoa.class.php';}
/**
 * Classe DAO de acesso a dados Pessoa PARA O NOVO MODELO DE FORMULÁRIO DE INSCRIÇÃO
 * 
 * @package Model.DAO
 * @category DAO
 * @since   2016-10-24
 * @version 1.6
 * @author  Kellen Nery
 * 
 *   
 */
class PessoaDAO extends PDOConnection {

    /**
     *  contrutor da classe que constroi também a super classe PadraoDAO
     *
     *  @param string $p_nomeTabela O nome da tabela a ser mapeada
     *  @param string $p_chavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @return void
     */ 
    function __construct(){
        try{
            parent::__construct('pessoa', 'id');
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     * função interna para carregar objeto com os dados do registro.
     *
     * @param object $p_Item O Objeto do tipo Registro do Banco de Dados
     * @return object|null O Objeto do tipo do Modelo desta classe
     */
    private function carregarModelo($p_Item){
        try{
            if ($p_Item) {
                $obj = new Pessoa();
                $obj->setId($p_Item['id']);
                $obj->setNomeCompleto(strtoupper($p_Item['nome_completo']));
                $obj->setNomeCracha(strtoupper($p_Item['nome_cracha'])); 
                $obj->setCpf($p_Item['cpf']);
				$obj->setPassaporte($p_Item['passaporte']);
                $obj->setEmail(trim($p_Item['email']));
                $obj->setSenha(trim($p_Item['senha']));               
                $obj->setTelefone(trim($p_Item['telefone']));
                $obj->setDataNascimento($p_Item['data_nascimento']);
				$obj->setIdPais($p_Item['id_pais']);
				$obj->setNomePais((isset($p_Item['nome_pais']))? $p_Item['nome_pais']: '');
                $obj->setIdEstado($p_Item['id_estado']);
                $obj->setNomeEstado((isset($p_Item['nome_estado']))? $p_Item['nome_estado']: '');   
                $obj->setIdCidade($p_Item['id_cidade']);
                $obj->setNomeCidade((isset($p_Item['nome_cidade']))? $p_Item['nome_cidade']: ''); 
                $obj->setGraduacao($p_Item['graduacao']);                
                $obj->setPosGraduacao((isset($p_Item['pos_graduacao']))? $p_Item['pos_graduacao']: '');
                $obj->setMestrado((isset($p_Item['mestrado']))? $p_Item['mestrado']: '');
                $obj->setDoutorado((isset($p_Item['doutorado']))? $p_Item['doutorado']: '');
                $obj->setPosDoutorado((isset($p_Item['pos_doutorado']))? $p_Item['pos_doutorado']: '');               
                $obj->setColaborador($p_Item['colaborador']);
                $obj->setViceDiretoria((isset($p_Item['vice_diretoria']))? $p_Item['vice_diretoria']: '');
                $obj->setEmpresa((isset($p_Item['empresa']))? $p_Item['empresa']: '');
                $obj->setCargo((isset($p_Item['cargo']))? $p_Item['cargo']: '');
				$obj->setResumo($p_Item['resumo']);
				$obj->setDataAcao($p_Item['data_acao']);
				$obj->setIdStatus($p_Item['id_status']);
				$obj->setNomeStatus($p_Item['nome_status']);
				$obj->setDataCadastro($p_Item['data_cadastro']);
                                
                return $obj;
            } else { return null; }
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *   função para gravar um registro novo.
     *
     *   @param object $obj O Objeto do tipo do Modelo desta classe
     *   @return boolean $Resultado Flag que indica que a operacaoo foi concluida com sucesso
     */
    public function salvar($obj){
        try{
            // Preparo a query
            $query = "INSERT INTO cad_pessoa "
                    ."(     acao, id_usuario_acao,      data_acao, revisao,  id, nome_completo, nome_cracha,  cpf,  passaporte,  email,  telefone, data_nascimento, id_pais, id_estado, id_cidade,  graduacao, pos_graduacao,  mestrado,  doutorado, pos_doutorado,  colaborador, vice_diretoria,  empresa,  cargo,  resumo, id_status)"
                    ." VALUES "
                    ."('incluir',  :IdUsuarioAcao, ".$this::NOW.",       1, :Id, :NomeCompleto, :NomeCracha, :Cpf, :Passaporte, :Email, :Telefone, :DataNascimento, :IdPais, :IdEstado, :IdCidade, :Graduacao, :PosGraduacao, :Mestrado, :Doutorado, :PosDoutorado, :Colaborador, :ViceDiretoria, :Empresa, :Cargo, :Resumo, 1)";
            $this->_query = $query;
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',  $this->_idUsuario );
			$stmt->bindValue(':Id',             $obj->getId());
            $stmt->bindValue(':NomeCompleto',   strtoupper($obj->getNomeCompleto()));		
            $stmt->bindValue(':NomeCracha',     strtoupper($obj->getNomeCracha()));
            $stmt->bindValue(':Cpf',            $obj->getCpf());
			$stmt->bindValue(':Passaporte',     $obj->getPassaporte());
            $stmt->bindValue(':Email',          $obj->getEmail());
            $stmt->bindValue(':Telefone',       $obj->getTelefone());
            $stmt->bindValue(':DataNascimento', $obj->getDataNascimento());
			$stmt->bindValue(':IdPais',         $obj->getIdPais());
            $stmt->bindValue(':IdEstado',       $obj->getIdEstado());
            $stmt->bindValue(':IdCidade',       $obj->getIdCidade());
            $stmt->bindValue(':Graduacao',      $obj->getGraduacao());
            $stmt->bindValue(':PosGraduacao',   $obj->getPosGraduacao());
            $stmt->bindValue(':Mestrado',       $obj->getMestrado());
            $stmt->bindValue(':Doutorado',      $obj->getDoutorado());
            $stmt->bindValue(':PosDoutorado',   $obj->getPosDoutorado());
            $stmt->bindValue(':Colaborador',    $obj->getColaborador());
            $stmt->bindValue(':ViceDiretoria',  $obj->getViceDiretoria());
            $stmt->bindValue(':Empresa',        $obj->getEmpresa());
            $stmt->bindValue(':Cargo',          $obj->getCargo());
            $stmt->bindValue(':Resumo',         $obj->getResumo());
            
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
            $query = "SELECT p.*, c.nome AS nome_cidade, e.nome AS nome_estado, pa.nome AS nome_pais, uj.password AS senha "
                    ." , u1.nome AS nome_usuario_acao, uj.registerDate AS data_cadastro "
                    ." FROM cad_pessoa p "
                    ." LEFT JOIN cad_cidade c ON c.id=p.id_cidade "
                    ." LEFT JOIN cad_estado e ON e.id_estado=p.id_estado "
                    ." LEFT JOIN cad_pais pa ON pa.id_pais=p.id_pais "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=p.id_usuario_acao "
                    ." LEFT JOIN m5wat_users uj ON uj.id=p.id "					
                    ." WHERE p.id=:Id ";
 
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
     * função para retornar um registro pelo Email do registro.
     *
     * @param string $p_Email O e-mail do registro
     * @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarPorEmail($p_Email){
        try{
            // Preparo a query 
            $query = "SELECT p.*, c.nome AS nome_cidade, e.nome AS nome_estado, uj.password AS senha "
                    ." , u1.nome AS nome_usuario_acao, uj.registerDate AS data_cadastro "
                    ." FROM cad_pessoa p "
                    ." LEFT JOIN cad_cidade c ON c.id=p.id_cidade "
                    ." LEFT JOIN cad_estado e ON e.id_estado=p.id_estado "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=p.id_usuario_acao "
                    ." LEFT JOIN m5wat_users uj ON uj.id=p.id "					
                    ." WHERE p.email=:Email ";
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
     * função para retornar um registro pelo CPF do registro.
     *
     * @param string $p_CPF O CPF da pessoa
     * 
     * @return object $Modelo O Objeto do tipo do Modelo desta classe
     */
    public function retornarPorCPF($p_CPF){
        try{
            // Preparo a query 
            $query = "SELECT p.*, e.nome AS nome_empresa, s.nome AS nome_status "
                    ." , u1.nome AS nome_usuario_acao, u2.nome AS nome_usuario_cadastro "
                    ." FROM cad_pessoa p "
                    ." LEFT JOIN cad_empresa e ON e.id_empresa=p.id_empresa "
                    ." LEFT JOIN cad_status s ON s.id_status=p.id_status "
                    ." LEFT JOIN cad_usuario u1 ON u1.id_usuario=p.id_usuario_acao "
                    ." LEFT JOIN cad_usuario u2 ON u2.id_usuario=p.id_usuario_cadastro "
                    ." WHERE p.deletado=0 AND ( p.cpf='$p_CPF' OR CAST(p.cpf AS bigint)=cast('$p_CPF' AS bigint) )"; //." WHERE p.deletado=0 AND ( p.cpf='$p_CPF' OR CAST(p.cpf AS BIGINT)=cast('$p_CPF' AS BIGINT) )";
            $stmt = $this->_conexao->prepare($query);
            $this->_query = $query;

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
     * função para atualizar um registro.
     *
     * @param object $obj O Objeto do tipo do Modelo desta classe
     * 
     * @return boolean $Resultado Flag que indica que a operação foi concluída com sucesso
     */
    public function atualizar($obj){
        try{			
			// Preparo a query 
			$query = "UPDATE cad_pessoa SET "
					." acao='editar', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuarioAcao, email=:Email "
					.", nome_completo=:NomeCompleto, nome_cracha=:NomeCracha, telefone=:Telefone, data_nascimento=:DataNascimento "
					.", id_pais=:IdPais, id_estado=:IdEstado, id_cidade=:IdCidade, graduacao=:Graduacao, pos_graduacao=:PosGraduacao "
					.", mestrado=:Mestrado, doutorado=:Doutorado, pos_doutorado=:PosDoutorado, colaborador=:Colaborador "
					.", vice_diretoria=:ViceDiretoria, empresa=:Empresa, cargo=:Cargo, resumo=:Resumo, revisao=(revisao+1) " //, id_status=1 "
					." WHERE id=:Id; "
					."UPDATE m5wat_users SET name=:NomeCompleto, email=:Email "
					.", lastvisitDate=".$this::NOW." "
					." WHERE id=:Id2; ";		
            $stmt = $this->_conexao->prepare($query);
            
            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuarioAcao',      $this->_idUsuario);
			$stmt->bindValue(':Email',    		    $obj->getEmail());
			$stmt->bindValue(':Senha',    		    $obj->getSenha());
            $stmt->bindValue(':NomeCompleto',    	strtoupper($obj->getNomeCompleto()));	
            $stmt->bindValue(':NomeCracha',    		strtoupper($obj->getNomeCracha()));
            $stmt->bindValue(':Telefone',    		$obj->getTelefone());
            $stmt->bindValue(':DataNascimento',    	$obj->getDataNascimento());
			$stmt->bindValue(':IdPais',    			$obj->getIdPais());
            $stmt->bindValue(':IdEstado',    		$obj->getIdEstado());
            $stmt->bindValue(':IdCidade',    		$obj->getIdCidade());
            $stmt->bindValue(':Graduacao',    		$obj->getGraduacao());
            $stmt->bindValue(':PosGraduacao',    	$obj->getPosGraduacao());
            $stmt->bindValue(':Mestrado',    		$obj->getMestrado());
            $stmt->bindValue(':Doutorado',    		$obj->getDoutorado());	
            $stmt->bindValue(':PosDoutorado',    	$obj->getPosDoutorado());
            $stmt->bindValue(':Colaborador',    	$obj->getColaborador());
            $stmt->bindValue(':ViceDiretoria',    	$obj->getViceDiretoria());
            $stmt->bindValue(':Empresa',    		$obj->getEmpresa());	
            $stmt->bindValue(':Cargo',    			$obj->getCargo());							           
            $stmt->bindValue(':Id',             	$obj->getId());
			$stmt->bindValue(':Id2',             	$obj->getId());
            $stmt->bindValue(':Resumo',             $obj->getResumo());
			
            // Executo a query preparada
            if (!$stmt->execute()){
                //$stmt->debugDumpParams();
                $this->_erro = $stmt->errorInfo();
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else{
                return 1;
            }
        } catch (PDOException $ex){ throw $ex; }
    }  
      
    /**
     * Método para excluir um registro
     *
     * @param int $p_Id O Identificador do registro desta classe
     *
     * @return boolean Flag que a operação foi concluída com sucesso
     */
    public function excluir($p_Id){
        try{
            // Preparo a query
            $stmt = $this->_conexao->prepare("UPDATE cad_pessoa SET acao='excluir', data_acao=".$this::NOW.", id_usuario_acao=:IdUsuario, deletado=1 WHERE id_pessoa=:Id");

            // Passa os paramentros para a query 
            $stmt->bindValue(':IdUsuario', $this->_idUsuario);
            $stmt->bindValue(':Id', $p_Id);

            // Executa a query preparada
            if (!$stmt->execute()){
                $this->_erro = $stmt->errorInfo();
                throw new Exception('<b>Erro ao executar a Query.</b><br/>'. $this->_erro[2]);
            } else {
                return 1;
            }
            // caso ocorra um erro, retorna o erro;
        } catch (PDOException $ex){ throw $ex; }
    }

    /**
     * Método para listar efiltrar os registros
     *
     * @param int $p_Pagina A Página do registros a ser retornarda
     * @param int $p_Linhas A Quantidade de registro a ser retornardo
     * @param int $p_Ordem O nome do campo a ser Ordendado
     * @param int $p_Direcao A direção da ordenação (ASC ou DESC)
     * @param int $p_IdPessoa O identificador da pessoa
     * @param string $p_Chave A Chave o cadastro da pessoa
     * @param int $p_IdStatus O Status do cadastro da pessoa
     * @param int $p_IdEmpresa O identificador da Federação
     * @param int $p_IdContrato O identificador da Contrato
     * @param string $p_Nome O Nome da pessoa
     * @param string $p_Email O E-mail da pessoa
     * @param string $p_CPF O CPF da pessoa
     * @param string $p_DataNascimento A date de Nascimento da pessoa (formato: aaaa-mm-dd)
     * @param string $p_Matricula O número da matricula da pessoa
     * @param int $p_Ativo Flag de registro Ativo
     * 
     * @return array $listagem Retorna um Array de Objetos do tipo Pessoa
     */
     public function listar($p_Pagina=null, $p_Linhas=null, $p_Ordem=null, $p_Direcao=null, $p_IdPessoa=null, $p_Chave=null, $p_IdStatus=null, $p_IdEmpresa=null, $p_IdContrato=null, $p_Nome=null, $p_Email=null, $p_CPF=null, $p_DataNascimento=null, $p_Matricula=null, $p_Ativo=null){

        try{
            $join='';
            $filtro='';
            if($p_Ordem == 'IdPessoa'){ $p_Ordem = 'id_pessoa';}
            if($p_Ordem == 'IdEmpresa'){ $p_Ordem = 'p.id_empresa';}
            if($p_Ordem == 'DataAcao'){ $p_Ordem = 'p.data_acao';}
            if($p_Ordem == 'DataCadastro'){ $p_Ordem = 'p.data_cadastro';}
            if(!$p_Ordem){ $p_Ordem = "p.nome";}
            
            if($p_IdPessoa){ $filtro .= " AND (p.id_pessoa=$p_IdPessoa) "; }
            if($p_Chave){ $filtro .= " AND (p.chave=$p_Chave) "; }
            if($p_IdEmpresa){ 
                if($p_Ordem == 'IdEmpresa'){ $p_Ordem = 'r.id_empresa';}
                $join=" LEFT JOIN cad_funcionario r ON r.id_pessoa=p.id_pessoa AND r.deletado=0 ";
                $filtro .= " AND (p.id_empresa=$p_IdEmpresa OR r.id_empresa=$p_IdEmpresa)";
            }
            if($p_IdStatus){ $filtro .= " AND p.id_status IN ($p_IdStatus) "; }
            if($p_Nome) {
                $p_Nome=str_replace(' ', '%', $p_Nome);
                $filtro .= " AND ( (upper(p.nome) LIKE upper('%$p_Nome%')) OR (upper(p.apelido) LIKE upper('%$p_Nome%')))";
            }
            if($p_Email){ $filtro .= " AND p.email = '$p_Email' ";}
            if($p_CPF){ $filtro .= " AND ( p.cpf='$p_CPF' OR CAST(p.cpf AS BIGINT)=cast('$p_CPF' AS BIGINT) )";}
            if($p_DataNascimento){ $filtro .= " AND p.data_nascimento='$p_DataNascimento' ";}
            if($p_Matricula){ $filtro .= " AND (p.matricula=CAST('$p_Matricula' AS INTEGER)) ";}
            if(($p_Ativo===1)||($p_Ativo===true)||($p_Ativo==='true')){
                $filtro .= " AND p.ativo=1 "; 
            }else if(($p_Ativo===0)||($p_Ativo===false)||($p_Ativo==='false')){
                $filtro .= " AND p.ativo=0 "; 
            }
            
            // Preparo a query
            //$query = "SELECT DISTINCT p.id_pessoa, p.matricula, p.nome, p.apelido, p.sexo, p.data_nascimento, p.id_status "
            $query = "SELECT DISTINCT p.* "
                    ." , e.nome AS nome_empresa, s.nome AS nome_status "
                    ." FROM cad_pessoa p "
                    ." INNER JOIN cad_empresa e ON e.id_empresa=p.id_empresa "
                    ." INNER JOIN cad_status s ON s.id_status=p.id_status "
                    ." $join "
                    ." WHERE p.deletado=0 $filtro "
                    ." ORDER BY $p_Ordem $p_Direcao";

            // Preparo a Paginação
            if ($p_Linhas){
                $queryCount = "SELECT count(p.id_pessoa) AS count "
                    ." FROM cad_pessoa p "
                    ." INNER JOIN cad_empresa e ON e.id_empresa=p.id_empresa "
                    ." INNER JOIN cad_status s ON s.id_status=p.id_status "
                    ." $join "
                    ." WHERE p.deletado=0 $filtro";
                $rsCount = $this->_conexao->prepare($queryCount);
                $rsCount->execute();
                $item = $rsCount->fetch(PDO::FETCH_ASSOC);                
                if($item){
                    self::setTotalRegistros($item['count']);
                }
                $query .= self::definirPaginacao($p_Pagina, $p_Linhas);
                //$query .= " LIMIT $p_Pagina,$p_Linhas;";
                //$query .= " LIMIT $p_Linhas OFFSET $p_Pagina;"; 
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

    /**
     *   função para retornar a quantidade de registro do filtro
     *
     *   @param int $p_IdEmpresa Identificador da Federação
     *   @param int $p_IdContrato Identificador da Contrato
     *   @param int $p_IdProfissao Identificador da Profissao
     *   @param int $p_IdStatus Identificador do Status
     *   @param string $p_CPF Campo CPF 
     *   @param string $p_Email Campo Email
     * 
     *   @return int $count A quantidade de registro do filtro
     */
     public function contar($p_IdEmpresa=null, $p_IdContrato=null, $p_IdProfissao=null, $p_IdStatus=null, $p_CPF=null, $p_Email=null){

        try{
            $filtro='';
            if($p_IdContrato){ 
                $filtro .= " AND p.id_pessoa IN (SELECT r.id_pessoa cad_funcionario r ON r.id_pessoa=p.id_pessoa AND r.deletado='".$this::NAO."' AND r.id_contrato=$p_IdContrato )";
            } else if($p_IdEmpresa){ 
                $filtro .= " AND (p.id_empresa=$p_IdEmpresa OR p.id_pessoa IN (SELECT r.id_pessoa cad_funcionario r ON r.id_pessoa=p.id_pessoa AND r.deletado='".$this::NAO."' AND r.id_empresa=$p_IdEmpresa)";
            }
            if($p_IdProfissao){
                $filtro .= " AND p.id_pessoa IN (SELECT r.id_pessoa cad_funcionario r ON r.id_pessoa=p.id_pessoa AND r.deletado='".$this::NAO."' AND r.id_profissao IN ($p_IdProfissao))";
            }
            if($p_IdStatus){ $filtro .= " AND p.id_status IN ($p_IdStatus) ";}
            if($p_CPF){ $filtro .= " AND ( p.cpf='$p_CPF' OR CAST(p.cpf AS BIGINT)=cast('$p_CPF' AS BIGINT) )";}
            if($p_Email){ $filtro .= " AND p.email = '$p_Email' ";}
            
            // Preparo a query
            $query = "SELECT count(p.id_pessoa) AS count "
                    ." FROM cad_pessoa p "
                    ." INNER JOIN cad_empresa e ON e.id_empresa=p.id_empresa "
                    ." WHERE p.deletado='".$this::NAO."' AND p.id_status<>9 $filtro";

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
	
	
	/**
	 * Função para Atualizar Campo no Formulário .
	 *
	 * @param int $p_IdFormulario O Identificador do Formulário
	 * @param int $p_Campo O Identificador do Campo
	 * @param int $p_Valor O Observações do Novo Valor 
     * 
	 * @return boolean Flag que indica que a operação foi concluída com sucesso
	 */
	public function atualizarCampo($p_IdResumo, $p_Campo, $p_Valor) {
		try {
		
			$query = "UPDATE cad_pessoa "
					." set " . $p_Campo . "=:Valor "
					." WHERE id=:Id ";
			
            $this->_query = $query;
                        
            // Preparo a query
            $stmt = $this->_conexao->prepare($query);
			
			// sequencia de índices que representa cada valor de minha query
			$stmt->bindValue(':Id', $p_IdResumo);
			$stmt->bindValue(':Valor', $p_Valor);
			
			// executo a query preparada
			if (! $stmt->execute ()) {
				$this->_erro = $stmt->errorInfo ();
				throw new Exception ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			} else
				return true;
			
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return false;
		}
	}	
    
}