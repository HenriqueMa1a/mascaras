<?php
if(!class_exists('PerfilDAO')){ require_once 'models/PerfilDAO.class.php';}
if(!class_exists('FuncionalidadeDAO')){ require_once 'models/FuncionalidadeDAO.class.php';}
if(!class_exists('PerfilFuncionalidadeDAO')){ require_once 'models/PerfilFuncionalidadeDAO.class.php';}
/**
 *  Controle responsável pela módulo Perfil. 
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
 *          Melhotia da proteção do perfil 1:Administrador
 *          #1.17
 */
class PerfilController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-perfil');
    }
    
    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Perfil
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
                $DAO = new PerfilDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Id = $obj->getId();
                    $this->response->Sigla = $obj->getSigla();
                    $this->response->Nome = $obj->getNome();
                    $this->response->Ativo = $obj->getAtivo();
                    $this->response->Acao = $obj->getAcao();
                    $this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
                    $this->response->NomeUsuarioAcao = $obj->getNomeUsuarioAcao();
                    $this->response->DataAcao = ($obj->getDataAcao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAcao(), false) : '';
                    $this->response->funcoes = array();
                    
                    $this->response->parte2 = date("Y-m-d H:i:s.u");

                    // Listar Documentos
                    $fDAO = new FuncionalidadeDAO();
                    $listagem1 = $fDAO->listar(1, 10000, '1', '', '', $obj->getId());
                    if ($listagem1) {
                        $i = 0;
                        foreach ($listagem1 as $item1){
                            $this->response->funcoes[$i]['cell'] = array($item1->getId(), $item1->getChave(), $item1->getOperacao(), 1);
                            $i++;
                        }
                    }
                    //if ($this->Config->Debug){ $this->response->query = $fDAO->_query;}

                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro com id: '$Id' foi localizado com sucesso.";
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                }
                //if (($this->Config->Debug) || ($this->Usuario->Id==1)) $this->response->query = $DAO->_query;
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é parametros um parametro obrigatório.";
            }
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
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
            $Sigla = self::getVar('Sigla');
            $Nome = self::getVar('Nome');
            $Ativo = self::getVar('Ativo');
            
            // Criticar campos
            if(!$Sigla) {
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
                $DAO = new PerfilDAO();
                
                $obj = new Perfil();
                $obj->setSigla($Sigla);
                $obj->setNome($Nome);
                $obj->setAtivo($Ativo);
                if ($DAO->salvar($obj)){
                    $Id = $obj->getId();
                    $this->response->Id=$Id;
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro atualizado com sucesso.";
                } else {
                    $this->response->mensagem = $DAO->getMensagem();
                }
                //if (($this->Config->Debug) || ($this->Usuario->Id==1)) $this->response->query = $DAO->_query;
                
                // Atualizar as Funcionalidades do Perfil
                $totsucesso=0;
                $totErro=0;
                $strErro = '';

                $IdPerfil = $Id;
                $this->response->IdPerfil = $IdPerfil;
                $pfDAO = new PerfilFuncionalidadeDAO();

                // 1. Listar Todas as funcionalidades
                $fDAO = new FuncionalidadeDAO();
                $listagem1 = $fDAO->listar(1, 10000, '1', '');
                if ($listagem1) {
                    $i = 0;
                    foreach ($listagem1 as $item1){
                        $IdFuncionalidade = $item1->getId();
                        $chave = $item1->getChave().'-'.$item1->getOperacao();
                        $this->response->rows[$IdFuncionalidade] = $chave;
                        if (self::getVar($chave)) {
                            // 2. Verifica se esta Funcionalidade já pertence ao Perfil;
                            $objPF = $pfDAO->retornarPerfilFuncionalidade($IdPerfil, $IdFuncionalidade);
                            if (!$objPF){
                                // 2.1 Cadastrar Perfil x Funcionalidade
                                $objPF = new PerfilFuncionalidade();
                                $objPF->setIdPerfil($IdPerfil);
                                $objPF->setIdFuncionalidade($IdFuncionalidade);
                                if ($pfDAO->salvar($objPF)){
                                    $totsucesso++;
                                } else {
                                    $totErro++;
                                    $strErro .= $pfDAO->getMensagem().'<br/>';
                                }
                                $this->response->rows[$chave] = 'incluir';
                            } else {
                                // 2.2 Recupera PerfilFuncionalidade
                                if ($objPF->getDeletado()){
                                    $IdPerfilFuncionalidade = $objPF->getId();
                                    if ($pfDAO->recuperar($IdPerfilFuncionalidade)){
                                        $totsucesso++;
                                    } else {
                                        $totErro++;
                                        $strErro .= "Esta funcionalidade já esta cadastrado no Perfil de Id: '$IdPerfil'.<br/>";
                                    }
                                    $this->response->rows[$chave] = 'recuperar';
                                } else {
                                    // Já esta Ativo
                                }
                            }

                        } else { // Remover Funcionalidade do Perfil
                            $pfDAO->excluirPerfilFuncionalidade($IdPerfil, $IdFuncionalidade);
                            $this->response->rows[$chave] = 'excluir';
                        }
                        $i++;
                    }
                }
                //if ($this->Config->Debug){ $this->response->query = $fDAO->_query; }
                $fDAO->Close();
                
            $DAO->Close();
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
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
            $Sigla = self::getVar('Sigla');
            $Nome = self::getVar('Nome');
            $Ativo = self::getVar('Ativo');
            
            // Criticar campos
            if(!$Sigla) {
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            
            $DAO = new PerfilDAO();
            $obj = $DAO->retornar($Id);
            if ($obj){

                $obj->setSigla($Sigla);
                $obj->setNome($Nome);
                $obj->setAtivo($Ativo);
                if ($DAO->atualizar($obj)){
                    $this->response->Id=$Id;
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro atualizado com sucesso.";
                } else {
                    $this->response->mensagem = $DAO->getMensagem();
                }
                
                // Atualizar as Funcionalidades do Perfil
                $totsucesso=0;
                $totErro=0;
                $strErro = '';

                $IdPerfil = $Id;
                $this->response->IdPerfil = $IdPerfil;
                $pfDAO = new PerfilFuncionalidadeDAO();

                // 1. Listar Todas as funcionalidades
                $fDAO = new FuncionalidadeDAO();
                $listagem1 = $fDAO->listar(1, 10000, '1', '');
                if ($listagem1) {
                    $i = 0;
                    foreach ($listagem1 as $item1){
                        $IdFuncionalidade = $item1->getId();
                        $chave = $item1->getChave().'-'.$item1->getOperacao();
                        $this->response->rows[$IdFuncionalidade] = $chave;
                        if (self::getVar($chave)) {
                            // 2. Verifica se esta Funcionalidade já pertence ao Perfil;
                            $objPF = $pfDAO->retornarPerfilFuncionalidade($IdPerfil, $IdFuncionalidade);
                            if (!$objPF){
                                // 2.1 Cadastrar Perfil x Funcionalidade
                                $objPF = new PerfilFuncionalidade();
                                $objPF->setIdPerfil($IdPerfil);
                                $objPF->setIdFuncionalidade($IdFuncionalidade);
                                if ($pfDAO->salvar($objPF)){
                                    $totsucesso++;
                                } else {
                                    $totErro++;
                                    $strErro .= $pfDAO->getMensagem().'<br/>';
                                }
                                $this->response->rows[$chave] = 'incluir';
                            } else {
                                // 2.2 Recupera PerfilFuncionalidade
                                if ($objPF->getDeletado()){
                                    $IdPerfilFuncionalidade = $objPF->getId();
                                    if ($pfDAO->recuperar($IdPerfilFuncionalidade)){
                                        $totsucesso++;
                                    } else {
                                        $totErro++;
                                        $strErro .= "Esta funcionalidade já esta cadastrado no Perfil de Id: '$IdPerfil'.<br/>";
                                    }
                                    $this->response->rows[$chave] = 'recuperar';
                                } else {
                                    // Já esta Ativo
                                }
                            }

                        } else { // Remover Funcionalidade do Perfil
                            $pfDAO->excluirPerfilFuncionalidade($IdPerfil, $IdFuncionalidade);
                            $this->response->rows[$chave] = 'excluir';
                        }
                        $i++;
                    }
                }
                //if ($this->Config->Debug){ $this->response->query = $fDAO->_query; }
                $fDAO->Close();

                $this->response->totsucesso = $totsucesso;
                $this->response->totErro = $totErro;
                    

            } else {
                $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
            }
            //if (($this->Config->Debug) || ($this->Usuario->Id==1)) $this->response->query = $DAO->_query;
            $DAO->Close();
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
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
                    
            $DAO = new PerfilDAO();
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
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     *  Método para listar todos registros
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function listar() {
        $this->response->IdUsuario=$this->Usuario->Id;
        
        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
        $sord = self::getVar('sord');
        //$sEcho = self::getVar('sEcho');
        
        try {
            /** Ordering */
            $aColumns = array(0=>'img', 1=>'id_perfil', 2=>'sigla', 3=>'nome', 4=>'ativo', 5=>'' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = 'id_perfil';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');

            $DAO = new PerfilDAO();
            $listagem = $DAO->listar($page, $rows, $sidx, $sord, $Id, $Nome);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
                    if ((($item->getId()==1) && ($this->Usuario->Id==1)) || ($item->getId()!=1)) { // Proteger o perfil 1:Administrador
                        $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getId().');"><span class="glyphicon glyphicon-search"></span>';
                        $this->response->aaData[$i] = array($bt_view, $item->getId(), $item->getSigla(), $item->getNome(), ($item->getAtivo())? 'sim': 'não');
                        $i++;
                    }
                }
                $this->response->sucesso = 1;
                $this->response->iTotalRecords = $this->response->records;
                $this->response->iTotalDisplayRecords = $this->response->records;
            }else{
                $this->response->page = 0; 
                $this->response->total = 0; 
                $this->response->records = 0;
            }
            //if (($this->Config->Debug) || ($this->Usuario->Id==1)) $this->response->query = $DAO->_query;
            $DAO->Close();
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

    /**
     *  Método para listar registro para um ComboBox
     *
     * @return array Retornar o array rows[] = {{value:'', text:''},...}
     */    
    public function listarCombo() {
        $this->response->IdUsuario=$this->Usuario->Id;
        
        try {
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');
        
            $DAO = new PerfilDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $Id, $Nome);
            if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    if ((($item->getId()==1) && ($this->Usuario->Id==1)) || ($item->getId()!=1)) { // Proteger o perfil 1:Administrador
                        $this->response->rows[$i]['value'] = intval($item->getId()); 
                        $this->response->rows[$i]['text'] = $item->getNome();
                        $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                        $i++;
                    }
                }
                $this->response->sucesso=1;
            }else{
                $this->response->records=0;
            }
            //if (($this->Config->Debug) || ($this->Usuario->Id==1)) $this->response->query = $DAO->_query;
            $DAO->Close();
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    } 

}