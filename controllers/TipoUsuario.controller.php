<?php
if(!class_exists('TipoUsuarioDAO')){ require_once 'models/TipoUsuarioDAO.class.php';}
if(!class_exists('UsuarioDAO')){ require_once 'models/UsuarioDAO.class.php';}
/**
 *  Controle responsável pela módulo TipoUsuario. 
 * 
 */
class TipoUsuarioController extends Controller{
	
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-tipo-usuario');
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
            $aColumns = array(0=>'img', 1=>'1', 3=>'sigla', 4=>'sigla3', 5=>'nome', 6=>'ativo' );
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
            
            $idTipoUsuario = self::getVar('idTipoUsuario');
            $nome = self::getVar('nome');

            $DAO = new TipoUsuarioDAO();
            $listagem = $DAO->listar($page, $rows, $sidx, $sord, $idTipoUsuario, $nome, null);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getIdTipoUsuario().');"><span class="glyphicon glyphicon-search"></span>';
                    $this->response->aaData[$i] = array($bt_view, $item->getIdTipoUsuario(), $item->getSigla(), $item->getNome(), ($item->getNomePosto())? $item->getNomePosto() : '---', ($item->getAtivo())? 'SIM': 'NÃO');
                    $i++;
                }
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
     *  Método para listar registro para um ComboBox
     *
     * @return array Retornar o array rows[] = {{value:'', text:''},...}
     */    
    public function listarCombo() { 

	   try {
            $idTipoUsuario = self::getVar('idTipoUsuario');
            $nome = self::getVar('nome');
        
            $DAO = new TipoUsuarioDAO();
        
			$listagem = $DAO->listar(null, null, 'nome', 'asc', $idTipoUsuario, $nome);
			
			if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = intval($item->getIdTipoUsuario()); 
                    $this->response->rows[$i]['text'] = $item->getNome();
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
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo TipoUsuario
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
                $DAO = new TipoUsuarioDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Id = $obj->getIdTipoUsuario();
                    $this->response->Sigla = $obj->getSigla();
                    $this->response->Nome = $obj->getNome();
					$this->response->idPostoVinculo = $obj->getIdPosto();
                    $this->response->Ativo = ($obj->getAtivo())? 1: 0;
					$this->response->Deletado = ($obj->getDeletado())? 1: 0;
                    $this->response->Acao = $obj->getAcao();
                    $this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
                    $this->response->NomeUsuarioAcao = $obj->getNomeUsuarioAcao();
                    $this->response->DataAcao = ($obj->getDataAcao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAcao(), false) : '';

                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro com id: '$Id' foi localizado com sucesso.";
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
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
     *  Método para criar um novo registro
     *
     * @return int O Identificador do registro criado
     */    
    public function incluir() {
        try {
            $Sigla = self::getVar('sigla');
            $Nome = self::getVar('descricao');
            $IdPosto = self::getVar('postoVinculado');
            $Ativo = self::getVar('ativo');
            $IdUsuarioAcao = self::getVar('IdUsuarioAcao');
            
            // Criticar campos
            if(!$Sigla){
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome){
                $this->response->mensagem = "O campo <b>Descrição</b> é de preenchimento obrigatório.";
                return false;
            }
            
            $obj = new TipoUsuario();
            $obj->setSigla($Sigla);
            $obj->setNome($Nome);
			$obj->setIdPosto($IdPosto);
            $obj->setIdUsuarioAcao(intval($IdUsuarioAcao));
            $obj->setAtivo($Ativo);
            
            $DAO = new TipoUsuarioDAO();
            if ($DAO->salvar($obj)){
                $Id = $obj->getId();
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
            $Sigla = self::getVar('sigla');
            $Nome = self::getVar('descricao');
            $IdPosto = self::getVar('postoVinculado', FILTER_SANITIZE_NUMBER_INT);
            $Ativo = (isset($_POST['ativo'])) ? 1 : 0;
			$IdUsuarioAcao = self::getVar('IdUsuarioAcao', FILTER_SANITIZE_NUMBER_INT);
            
            // Criticar campos
            if(!$Sigla) {
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Descrição</b> é de preenchimento obrigatório.";
                return false;
            }
            
            $this->response->Id=$Id;
            if ($Id){
                $DAO = new TipoUsuarioDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
					//$obj->setIdTipoUsuario($Id);
                    $obj->setSigla($Sigla);
                    $obj->setNome($Nome);
                    $obj->setIdPosto(($IdPosto)? $IdPosto: null);
                    $obj->setIdUsuarioAcao($IdUsuarioAcao);
                    $obj->setAtivo($Ativo);

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
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
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
                $DAO = new TipoUsuarioDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
					
					$DAO1 = new UsuarioDAO();
					$obj1 = $DAO1->listar(null, null, 'IdUsuario', null, null, $Id, null);
					if ($obj1){
						$this->response->mensagem = "Registro não pode ser excluído, existem usuários vinculados a este Tipo<br>";
						$this->response->mensagem .= "Favor verificar o cadastro de usuário.";
					} else {	
						$this->response->Nome = $obj->getNome();
						if ($DAO->excluir($Id)){
							$this->response->sucesso = 1;
							$this->response->mensagem = "O registro <b>'".$obj->getNome()."'</b> foi removido com sucesso.";
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