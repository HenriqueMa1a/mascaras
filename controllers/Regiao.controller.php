<?php
if(!class_exists('PaisDAO')){ require_once 'models/PaisDAO.class.php';}
if(!class_exists('RegiaoDAO')){ require_once 'models/RegiaoDAO.class.php';}
/**
 *  Controle responsável pela módulo Regiao. 
 * 
 * @package Controller
 * @category Controller
 * @since   2020-05-21
 * @version 2.0
 * @author  Kellen Nery
 * 
 * 
 * @edit    2016-01-19<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Criação do CRUD 
 *          #1.17
 */
class RegiaoController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-estado');
    }
    
    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Regiao
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
                $DAO = new RegiaoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Id = $obj->getId();
                    $this->response->IdPais = $obj->getIdPais();
                    $this->response->SiglaPais = $obj->getSiglaPais();
                    $this->response->NomePais = $obj->getNomePais();
                    $this->response->Codigo = $obj->getCodigo();
                    $this->response->Sigla = $obj->getSigla();
                    $this->response->Nome = $obj->getNome();
                    $this->response->Ativo = ($obj->getAtivo())? 1: 0;
                    $this->response->Revisao = $obj->getRevisao();
                    $this->response->Acao = $obj->getAcao();
                    $this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
                    $this->response->NomeUsuarioAcao = $obj->getNomeUsuarioAcao();
                    $this->response->DataAcao = ($obj->getDataAcao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAcao(), false) : '';

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
     *  Método para criar um novo registro
     *
     * @return int O Identificador do registro criado
     */    
    public function incluir() {
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $IdPais = self::getVar('IdPais', FILTER_SANITIZE_NUMBER_INT);
            $SiglaPais = self::getVar('SiglaPais');
            $Codigo = self::getVar('Codigo');
            $Sigla = self::getVar('Sigla');
            $Nome = self::getVar('Nome');
            $Ativo = self::getVar('Ativo');
            
            // Criticar campos
            if(!$IdPais) {
                $this->response->mensagem = "O campo <b>País</b> é de preenchimento obrigatório.";
                return false;
            } else {
                $daoPais = new PaisDAO();
                $objPais = $daoPais->retornar($IdPais);
                if ($objPais) {
                    $SiglaPais = $objPais->getSigla();
                }
                $daoPais->Close();
            }
            if(!$Sigla) {
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            
            // Preparar Campos
            if(strlen($Sigla)>3){
                $Codigo = strtoupper($Sigla);
            } else {
                $Codigo = strtoupper($SiglaPais.'-'.$Sigla);
            }

            $obj = new Regiao();
            $obj->setIdPais($IdPais);
            $obj->setSiglaPais($SiglaPais);
            $obj->setCodigo($Codigo);
            $obj->setSigla($Sigla);
            $obj->setNome($Nome);
            $obj->setAtivo($Ativo);
            
            $DAO = new RegiaoDAO();
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
            $IdPais = self::getVar('IdPais', FILTER_SANITIZE_NUMBER_INT);
            $Sigla = self::getVar('Sigla');
            $Nome = self::getVar('Nome');
            $Ativo = self::getVar('Ativo');
            
            // Criticar campos
            if(!$IdPais) {
                $this->response->mensagem = "O campo <b>País</b> é de preenchimento obrigatório.";
                return false;
            } else {
                $daoPais = new PaisDAO();
                $objPais = $daoPais->retornar($IdPais);
                if ($objPais) {
                    $SiglaPais = $objPais->getSigla();
                }
                $daoPais->Close();
            }
            if(!$Sigla) {
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            // Preparar Campos
            if(strlen($Sigla)>3){
                $Codigo = strtoupper($Sigla);
            } else {
                $Codigo = strtoupper($SiglaPais.'-'.$Sigla);
            }
            
            $this->response->Id=$Id;
            if ($Id){
                $DAO = new RegiaoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $obj->setIdPais($IdPais);
                    $obj->setCodigo($Codigo);
                    $obj->setSigla($Sigla);
                    $obj->setNome($Nome);
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
                $DAO = new RegiaoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Nome = $obj->getNome();
                    if ($DAO->excluir($Id)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "O registro <b>'".$obj->getNome()."'</b> foi removido com sucesso.";
                    } else {
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
                }
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
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
            $aColumns = array(0=>'img', 1=>'id_estado', 2=>'nome_pais', 3=>'sigla', 4=>'nome', 5=>'ativo', 6=>'' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = 'id_estado';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            $IdPais = self::getVar('IdPais');
            $Nome = self::getVar('Nome');

            $DAO = new RegiaoDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $IdPais, $Nome);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getId().');"><span class="glyphicon glyphicon-search"></span>';
                    $this->response->aaData[$i] = array($bt_view, $item->getId(), $item->getNomePais(), $item->getSigla(), $item->getNome(), ($item->getAtivo())? 'sim': 'não');
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
            $IdPais = self::getVar('IdPais');
        
            $DAO = new RegiaoDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $IdPais);
            if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = $item->getId();
                    $this->response->rows[$i]['text'] = $item->getNome();
                    $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                    $i++;
                }
                $this->response->sucesso=1;
            }else{
                $this->response->records=0;
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

}