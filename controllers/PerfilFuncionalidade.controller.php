<?php
if(!class_exists('PerfilFuncionalidadeDAO')){ require_once 'models/PerfilFuncionalidadeDAO.class.php';}
/**
 *  Controle responsável pela módulo Inscricao. 
 */
class PerfilFuncionalidadeController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-perfil-funcionalidade');
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
    public function listarPerfilFuncionalidade() { 
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
			
			$idPerfil = self::getVar('Id');

            $DAO = new PerfilFuncionalidadeDAO();
            $listagem = $DAO->listarPerfilFuncionalidade($idPerfil);
            if ($listagem) { 
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){ 
					//$bt_acaoSim = '<input class="form-check-input" type="checkbox" name="simHabilita" id="simHabilita" value="S" onclick="habilitarSN('.$item->getId().');">';
					//$bt_acaoNao = '<input class="form-check-input" type="checkbox" name="naoHabilita" id="naoHabilita" value="N" onclick="habilitarSN('.$item->getId().');">';
					$this->response->aaData[$i] = array($item->getId(), $item->getDescricaoFuncionalidade(), $bt_acaoSim, $bt_acaoNao);
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
     * @return object Objeto do tipo Posto
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
                $DAO = new PostoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->idPosto = $obj->getIdPosto();
                    $this->response->descricao = $obj->getDescricao();
                    $this->response->responsavel = $obj->getResponsavel();
                    $this->response->ativo = $obj->getAtivo();
					$this->response->dataCadastro = $obj->getDataCadastro();

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
     * @return object Objeto do tipo Posto
     */    
    public function retornarPerfilFuncionalidade() {
        
        try{
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            //$this->response->IdUsuario = $this->Usuario->Id;
            
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            if ($Id){
                $DAO = new PerfilFuncionalidadeDAO();
                $obj = $DAO->retornarPerfilFuncionalidade($Id);
                if ($obj){
                    $this->response->idPerfilFuncionalidade = $obj->getId();
                    $this->response->idPerfil = $obj->getIdPerfil();
                    $this->response->nomePerfil = $obj->getNomePerfil();
                    $this->response->idFuncionalidade = $obj->getIdFuncionalidade();
					$this->response->descricaoFuncionalidade = $obj->getDescricaoFuncionalidade();

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

    
}