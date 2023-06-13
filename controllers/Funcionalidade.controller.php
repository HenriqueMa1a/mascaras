<?php
if(!class_exists('FuncionalidadeDAO')){ require_once 'models/FuncionalidadeDAO.class.php';}
/**
 *  Controle responsável pela módulo Inscricao. 
 */
class FuncionalidadeController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-funcionalidade');
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
			
			$idModuloPai = self::getVar('IdModuloPai', FILTER_SANITIZE_NUMBER_INT);
			$idPerfil = self::getVar('IdPerfil', FILTER_SANITIZE_NUMBER_INT);

            $DAO = new FuncionalidadeDAO();
            $listagem = $DAO->listarPorPai($idModuloPai);
            if ($listagem) { 
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){ 
				
					$funcionalidade = $item->getIdFuncionalidade();
					$DAOPf = new PerfilFuncionalidadeDAO();
					$objPf = $DAOPf->retornarPerfilFuncionalidade($idPerfil, $funcionalidade);
					if ($objPf){ //se POSSUI acesso apresenta marcado SIM
						$bt_acaoSim = '<input class="form-check-input acesso" type="checkbox" name="acesso[]" id="simHabilita_' . $funcionalidade . '" value=' . $funcionalidade . ' onclick="habilitarSIM('.$funcionalidade.');" disabled checked>';
						$bt_acaoNao = '<input class="form-check-input acesso" type="checkbox" name="acesso[]" id="naoHabilita_' . $funcionalidade . '" onclick="habilitarNAO('.$funcionalidade.');" disabled>';
					}else {  //se NÃO POSSUI acesso apresenta marcado NÃO
						$bt_acaoSim = '<input class="form-check-input acesso" type="checkbox" name="acesso[]" id="simHabilita_' . $funcionalidade . '" onclick="habilitarSIM('.$funcionalidade.');" disabled >';
						$bt_acaoNao = '<input class="form-check-input acesso" type="checkbox" name="acesso[]" id="naoHabilita_' . $funcionalidade . '" onclick="habilitarNAO('.$funcionalidade.');" disabled checked>';						
					}	
					$this->response->aaData[$i] = array($item->getIdFuncionalidade(), $item->getIdModulo(), $item->getDescricaoModulo(), $item->getDescricao(), $bt_acaoSim, $bt_acaoNao);
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
    
}