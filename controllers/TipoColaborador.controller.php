<?php
if(!class_exists('TipoColaboradorDAO')){ require_once 'models/TipoColaboradorDAO.class.php';}
/**
 *  Controle responsável pela módulo UO. 
 * 
 */
class TipoColaboradorController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-tipo_colaborador');
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
            
            $idTipoColaborador = self::getVar('idTipoColaborador');
           // $codigo = self::getVar('codigo');
			//$sigla = self::getVar('sigla');
			$descricao = self::getVar('descricao');

            $DAO = new TipoColaboradorDAO();
            $listagem = $DAO->listar($page, $rows, $sidx, $sord, $idTipoColaborador, $descricao);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
					if ($item->getAtivo()){
						$chkAtivar = '<input type="checkbox" id="ativarTipo_'.$item->getIdTipoColaborador().'" checked onclick=ativarTipo('.$item->getIdTipoColaborador().')>';
					}else{
						$chkAtivar = '<input type="checkbox" id="ativarTipo_'.$item->getIdTipoColaborador().'" onclick=ativarTipo('.$item->getIdTipoColaborador().')>';
					}
						
                    $this->response->aaData[$i] = array($item->getIdTipoColaborador(), $item->getDescricao(), $chkAtivar);
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
		  
            $idTipoColaborador = self::getVar('tipoColaborador');
            $descricao = self::getVar('descricao');
        
            $DAO = new TipoColaboradorDAO();
        
			$listagem = $DAO->listar(null, null, 'descricao', 'asc', $idTipoColaborador, $descricao);

			if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = intval($item->getIdTipoColaborador()); 
                    $this->response->rows[$i]['text'] = $item->getDescricao();
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
                $DAO = new TipoColaboradorDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Id = $obj->getIdTipoColaborador();
                    $this->response->Descricao = $obj->getDescricao();
                    $this->response->Ativo = ($obj->getAtivo())? 1: 0;
					//$this->response->Deletado = ($obj->getDeletado())? 1: 0;
                    //$this->response->Acao = $obj->getAcao();
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
     *  Método para editar um registro
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function editar() {
		
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            //$Descricao = self::getVar('Descricao');
            $Ativo = self::getVar('Ativo');
			$IdUsuarioAcao = self::getVar('IdUsuarioAcao', FILTER_SANITIZE_NUMBER_INT);
			
            $this->response->Id=$Id;
            if ($Id){
                $DAO = new TipoColaboradorDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    //$obj->setDescricao($Descricao);
                    $obj->setIdUsuarioAcao($IdUsuarioAcao);
                    $obj->setAtivo($Ativo);

                    if ($DAO->atualizar($obj)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Registro atualizado com sucesso.";
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

    
}