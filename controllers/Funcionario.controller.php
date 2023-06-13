<?php
if(!class_exists('FuncionarioDAO')){ require_once 'models/FuncionarioDAO.class.php';}
if(!class_exists('DistribuicaoDAO')){ require_once 'models/DistribuicaoDAO.class.php';}
/**
 *  Controle responsável pela módulo Inscricao. 
 */
class FuncionarioController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-Funcionario');
        $this->Config->Debug=1;
		
		define('_JEXEC', 1 );
		define('JPATH_BASE', "/var/www/html/isi" );
		define( 'DS','/' );
		//echo "<!-- JPATH_BASE.DS=".JPATH_BASE.DS." //-->";
		
		//require_once(JPATH_BASE.DS. 'includes'.DS.'defines.php' );
		//require_once(JPATH_BASE.DS.'includes'.DS.'framework.php' );
		//require_once(JPATH_BASE.DS.'libraries/joomla/database/factory.php');
    }
  
    /**
     *  Método para listar todos registros
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function listar() {
        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
        $sord = self::getVar('sord');
        //$sEcho = self::getVar('sEcho');
        
        try {
            /** Ordering */
            $aColumns = array(0=>'img', 1=>'id', 2=>'user_full_name', 3=>'username', 4=>'name', 5=>'ativo', 6=>'', 7=>'' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = '1';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            $nome = self::getVar('nome');
			//$dirVd = self::getVar('dirVd');
            $alocacao = self::getVar('alocacao');
			$vinculo = self::getVar('vinculo');			
			$modalidade = self::getVar('modalidade');
			$jornada = self::getVar('jornada');
			$tipoColaborador = self::getVar('tipoColaborador');

            $DAO = new FuncionarioDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $nome, $alocacao, $vinculo, $modalidade, $jornada, $tipoColaborador);
            if ($listagem) { 
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){ 
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getIdFuncionario().');"><span class="glyphicon glyphicon-search"></span>';
					$codigoCartao = ($item->getCodigoCartao()) ? '<span class="label label-primary">'. $item->getCodigoCartao().'</span>': '';
					$origemUO = ($item->getOrigemUO()) ? '<span class="label label-info">'. $item->getOrigemUO().'</span>': '';

					$this->response->aaData[$i] = array($bt_view, $item->getCpf(), $item->getNomeFuncionario().'<br/>'.$codigoCartao, ($item->getUoAlocacao())?$item->getUoAlocacao().'<br/>'.$origemUO:'---', $item->getVinculo(), $item->getModalidade(),$item->getDescricaoJornada(), $item->getTipoColaborador());
                    $i++;
                }
                $this->response->records = $i;
                $this->response->sucesso = 1;
                $this->response->iTotalRecords = $this->response->records;
                $this->response->iTotalDisplayRecords = $this->response->records;
            }else{
                $this->response->page = 0; 
                $this->response->total = 0; 
                $this->response->records = 0;
                if ($DAO->getErro()){
                    $this->response->erro = $DAO->getErro();
                    $this->response->mensagem = $DAO->getMensagem();
                }
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
	
    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Funcionario
     */    
    public function retornar() {
        
        try{
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            //$this->response->IdUsuario = $this->Usuario->Id;
            
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            if ($Id){
                $DAO = new FuncionarioDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
					$this->response->idFunc = $obj->getIdFuncionario();
					$this->response->cpf = ($obj->getCpf())? $obj->getCpf() : '' ;
					$this->response->cartao = $obj->getCodigoCartao();
					$this->response->tipoColaborador = $obj->getIdTipoColaborador();
					$this->response->nome = $obj->getNomeFuncionario();
					$this->response->vinculo = $obj->getVinculo();
					$this->response->modalidade = $obj->getModalidade();
					$this->response->origemUO = $obj->getOrigemUO();
					$this->response->alocacao = $obj->getIdUoAlocacao();
					$this->response->jornada = $obj->getJornadaTrabalho();
					$this->response->horario = $obj->getHorario();
					$this->response->obs = $obj->getObservacao();
					$this->response->dataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '';
					$this->response->acao = $obj->getAcao();
					$this->response->dataAcao = ($obj->getDataAcao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAcao(), false) : '';
					$this->response->idUsuarioAcao = $obj->getIdUsuarioAcao();
					$this->response->nomeUsuarioAcao = $obj->getNomeUsuarioAcao();

                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro com id: '$Id' foi localizado com sucesso.";
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                    if ($DAO->getErro()){
                        $this->response->erro = $DAO->getErro();
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Funcionario
     */    
    public function retornarCodigoCartao() {
        
        try{
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            //$this->response->IdUsuario = $this->Usuario->Id;
            
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            if ($Id){
                $DAO = new FuncionarioDAO();
                $obj = $DAO->retornarCodigoCartao($Id);
                if ($obj){
					
					$this->response->idFunc = $obj->getIdFuncionario();
					$this->response->cpf = ($obj->getCpf())? $obj->getCpf() : '' ;
					$this->response->cartao = $obj->getCodigoCartao();
					$this->response->tipoColaborador = $obj->getTipoColaborador();
					$this->response->tipoColaboradorAtivo = $obj->getTipoColaboradorAtivo();
					$this->response->nome = $obj->getNomeFuncionario();
					$this->response->vinculo = $obj->getVinculo();
					$this->response->modalidade = $obj->getModalidade();
					//$this->response->dirVd = $obj->getDirVd();
					$this->response->alocacao = $obj->getIdUoAlocacao();
					$this->response->alocacaoSigla = $obj->getUoAlocacao();
					$this->response->alocacaoAtivo = $obj->getUoAlocacaoAtivo();
					$this->response->jornada = $obj->getJornadaTrabalho();
					$this->response->qtdMascaras = $obj->getQtdMascaras();
					$this->response->horario = $obj->getHorario();
					$this->response->obs = $obj->getObservacao();
					$this->response->dataCadastro = $obj->getDataCadastro();
					$this->response->acao = $obj->getAcao();
					$this->response->dataAcao = $obj->getDataAcao();
					$this->response->idUsuarioAcao = $obj->getIdUsuarioAcao();
					$this->response->nomeUsuarioAcao = $obj->getNomeUsuarioAcao();					
					
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro com id: '$Id' foi localizado com sucesso.";
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                    if ($DAO->getErro()){
                        $this->response->erro = $DAO->getErro();
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
	
	
    /**
     *  Método para listar registro para um ComboBox
     *
     * @return array Retornar o array rows[] = {{value:'', text:''},...}
     */    
    public function listarCombo() { 
       
	   try {
		  
            $idFuncionario = self::getVar('idFuncionario');
            $nome = self::getVar('nome');
        
            $DAO = new FuncionarioDAO();
        
			$listagem = $DAO->listar(null, null, 'nome', 'asc', $idFuncionario, $nome);
        
			if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = intval($item->getIdFuncionario()); 
                    $this->response->rows[$i]['text'] = $item->getNomeFuncionario();
                    $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                    $i++;
                }
            }else{
                $this->response->records=0;
                 if ($DAO->getErro()){
                    $this->response->erro = $DAO->getErro();
                    $this->response->mensagem = $DAO->getMensagem();
                }
            }
			
            $this->response->sucesso=1;
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
		
    } 
	
    /**
     *  Método para criar um novo registro
     *
     * @return int O Identificador do registro criado
     */    
    public function incluir() {
        try {
            $Cpf = self::getVar('cpf');
			$Cartao = self::getVar('cartao');
			$TipoColaborador = self::getVar('tipoColaborador');
            $Nome = self::getVar('nome');
            $Vinculo = self::getVar('vinculo');
			$Modalidade = self::getVar('modalidade');
			//$DirVd = self::getVar('dirVd');
            $Alocacao = self::getVar('alocacao');
			$Jornada = self::getVar('jornada');
			$Horario = self::getVar('horario');
			$Observacao = self::getVar('obs');
            $IdUsuarioAcao = self::getVar('IdUsuarioAcao');

			$DAO = new FuncionarioDAO();
			
            // Criticar campos
            if(!$Nome){
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Jornada){
                $this->response->mensagem = "O campo <b>Jornada de Trabalho</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Cartao){
                $this->response->mensagem = "O campo <b>Código do Cartão</b> é de preenchimento obrigatório.";
                return false;
            }	

			if($Cpf) {
				if (!Validacao::validarCPF($Cpf)){
					$this->response->mensagem = "Erro: O campo <b>CPF</b> está com valor inválido. <br>Favor conferir o número do documento.";
					return false;
				}
				if ($DAO->contar($Cpf)>0){
					$this->response->mensagem = "Erro: O <b>CPF</b> já cadastrado.";
					return false;					
				}
			}				
            
            $obj = new Funcionario();
			
            $obj->setCpf(($Cpf) ? $Cpf : null);
			$obj->setCodigoCartao($Cartao);
			$obj->setTipoColaborador(($TipoColaborador) ? $TipoColaborador : null); 
            $obj->setNomeFuncionario($Nome);
            $obj->setVinculo(($Vinculo) ? $Vinculo : null);
			$obj->setModalidade(($Modalidade) ? $Modalidade : null);
			//$obj->setDirVd(($DirVd) ? $DirVd : null);
            $obj->setIdUoAlocacao(($Alocacao) ? $Alocacao : null);
			$obj->setJornadaTrabalho(($Jornada) ? $Jornada : null); 
			$obj->setHorario(($Horario) ? $Horario : null);
			$obj->setObservacao(($Observacao) ? $Observacao : null);
            $obj->setIdUsuarioAcao(intval($IdUsuarioAcao));
			
            if ($DAO->salvar($obj)){
                $Id = $obj->getIdFuncionario();
                $this->response->Id=$Id;
				
                $this->response->sucesso = 1;
                $this->response->mensagem = "Registro '$Nome' foi cadastrado com sucesso.";
            } else {
                $this->response->mensagem = $DAO->getMensagem();
            }

            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
	
    /**
     *  Método para editar um registro
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function editar() {
		
        try {
			$Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $Cpf = self::getVar('cpf');
			$Cartao = self::getVar('cartao', FILTER_SANITIZE_NUMBER_INT);
			$TipoColaborador = self::getVar('tipoColaborador', FILTER_SANITIZE_NUMBER_INT);
            $Nome = self::getVar('nome');
            $Vinculo = self::getVar('vinculo');
			$Modalidade = self::getVar('modalidade');
			//$DirVd = self::getVar('dirVd');
            $Alocacao = self::getVar('alocacao', FILTER_SANITIZE_NUMBER_INT);
			$Jornada = self::getVar('jornada');
			$Horario = self::getVar('horario');
			$Observacao = self::getVar('obs');
            $IdUsuarioAcao = self::getVar('IdUsuarioAcao', FILTER_SANITIZE_NUMBER_INT);	

            $DAO = new FuncionarioDAO();			

            // Criticar campos
            if(!$Nome){
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Jornada){
                $this->response->mensagem = "O campo <b>Jornada de Trabalho</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Cartao){
                $this->response->mensagem = "O campo <b>Código do Cartão</b> é de preenchimento obrigatório.";
                return false;
            }
			
			if($Cpf) {
				if (!Validacao::validarCPF($Cpf)){
					$this->response->mensagem = "Erro: O campo <b>CPF</b> está com valor inválido. <br>Favor conferir o número do documento.";
					return false;
				}
				if ($DAO->contar($Cpf)>0){
					$obj1 = $DAO->retornarPorCPF($Cpf);
					if ($obj1->getIdFuncionario() != $Id){
						$this->response->mensagem = "Erro: O <b>CPF</b> já cadastrado.";
						return false;
					}
				}				
			}			
			
            $this->response->Id=$Id;
            if ($Id){

                $obj = $DAO->retornar($Id);
				
                if ($obj){
					$obj->setCpf(($Cpf) ? $Cpf : null);
					$obj->setCodigoCartao($Cartao);
					$obj->setIdTipoColaborador(($TipoColaborador) ? $TipoColaborador : null); 
					$obj->setNomeFuncionario($Nome);
					$obj->setVinculo(($Vinculo) ? $Vinculo : null);
					$obj->setModalidade(($Modalidade) ? $Modalidade : null);
					//$obj->setDirVd(($DirVd) ? $DirVd : null);
					$obj->setIdUoAlocacao(($Alocacao) ? $Alocacao : null);
					$obj->setJornadaTrabalho(($Jornada) ? $Jornada : null); 
					$obj->setHorario(($Horario) ? $Horario : null);
					$obj->setObservacao(($Observacao) ? $Observacao : null);
					$obj->setIdUsuarioAcao($IdUsuarioAcao);					
					
                    if ($DAO->atualizar($obj)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Registro '$Nome' atualizado com sucesso.";
                    } else {
                        $this->response->erro = $DAO->getErro();
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
			
			$DAO->Close();
			
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
		
    }	
	
    /**
     * Método para excluir um registro
     * 
     * @param int Identificador do registro 
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function excluir($p_Id=null){
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            
            // Coletar parametros
            if ($p_Id>0) {
                $Id = $p_Id;
            } else {
                $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            }
			
            $this->response->Id = $Id;
            if ($Id){
                $DAO = new FuncionarioDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
					
					$DAO1 = new DistribuicaoDAO();
					$obj1 = $DAO1->listar(null, null, 'nome', null, null, null, null, null, $Id);
					if ($obj1){
						$this->response->mensagem = "Registro não pode ser excluído. <br>";
						$this->response->mensagem .= "Existem entregas de máscaras realizadas para o(a) funcionário(a): <b>".$obj->getNomeFuncionario()."</b>!";
					} else {	
						$this->response->Nome = $obj->getNomeFuncionario();
						if ($DAO->excluir($Id)){
							$this->response->sucesso = 1;
							$this->response->mensagem = "O registro <b>'".$obj->getNomeFuncionario()."'</b> foi removido com sucesso.";
						} else {
							$this->response->mensagem = $DAO->getMensagem();
						}					
					}
					$DAO1->Close();							
					
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

	
}