<?php
if(!class_exists('ModuloDAO')){ require_once 'models/ModuloDAO.class.php';}
if(!class_exists('FuncionalidadeDAO')){ require_once 'models/FuncionalidadeDAO.class.php';}
/**
 *  Controle responsável pela módulo Modulo. 
 * 
 * @package Controller
 * @category Controller
 * @version 1.0
 * @since   2020-05-21
 * @version 1.6
 * @author  Kellen Nery
 * 
 * 
 * @edit    2020-12-01<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Implementação da Documentação
 */
class ModuloController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-profissao-nivel');
    }
    
    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Modulo
     */    
    public function retornar() {
        
        try{
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            if ($Id){
                $DAO = new ModuloDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Id = $obj->getId();
                    $this->response->IdModuloPai = $obj->getIdModuloPai();
                    $this->response->IdModuloPai = $obj->getIdModuloPai();
                    $this->response->Chave = $obj->getChave();
                    $this->response->Classe = $obj->getClasse();
                    $this->response->Controle = $obj->getControle();
                    $this->response->Visao = $obj->getVisao();
                    $this->response->Nome = $obj->getNome();
                    $this->response->Descricao = $obj->getDescricao();
                    $this->response->Imagem = $obj->getImagem();
                    $this->response->Nivel = $obj->getNivel();
                    $this->response->Ordem = $obj->getOrdem();
                    $this->response->Visitas = $obj->getVisitas();
                    $this->response->Parametros = $obj->getParametros();
                    $this->response->Ativo = ($obj->getAtivo())? 1: 0;
                    $this->response->Revisao = $obj->getRevisao();
                    $this->response->Acao = $obj->getAcao();
                    $this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
                    $this->response->NomeUsuarioAcao = $obj->getNomeUsuarioAcao();
                    $this->response->DataAcao = ($obj->getDataAcao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAcao(), false) : '';

                    $this->response->parte2 = date("Y-m-d H:i:s.u");

                    // Listar Documentos
                    $this->response->Funcionalidades = array();
                    $fDAO = new FuncionalidadeDAO();
                    $listagem1 = $fDAO->listar(null, null, '1', '', $Id);
                    if ($listagem1) {
                        $i = 0;
                        foreach ($listagem1 as $item1){
                            $this->response->Funcionalidades[$i] = array($item1->getId(), $item1->getNome(), 1);
                            $i++;
                        }
                    }
                    if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query2 = $fDAO->_query; }
                    $fDAO = null;

                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro de Id: '$Id' localizado com sucesso.";
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
                    if ($DAO->getErro()){
                        $this->response->erro = $DAO->getErro();
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é parametros um parametro obrigatório.";
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
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $IdModuloPai = self::getVar('IdModuloPai', FILTER_SANITIZE_NUMBER_INT);
            $Chave = self::getVar('Chave');
            $Nome = self::getVar('Nome');
            $Descricao = self::getVar('Descricao');
            $Imagem = self::getVar('Imagem');
            $Parametros = self::getVar('Parametros');
            $Nivel = self::getVar('Nivel');
            $Ordem = self::getVar('Ordem', FILTER_SANITIZE_NUMBER_INT);
            $Classe = self::getVar('Classe');
            $Controle = self::getVar('Controle');
            $Visao = self::getVar('Visao');
            
            $Ativo = self::getVar('Ativo');
            $AnosRegistro = self::getVar('AnosRegistro', FILTER_SANITIZE_NUMBER_INT);
            $DiasLiberacao = self::getVar('DiasLiberacao', FILTER_SANITIZE_NUMBER_INT);
            $AnosAtivo = self::getVar('AnosAtivo', FILTER_SANITIZE_NUMBER_INT);

            // Criticar campos
            if(!$Id){
                $this->response->mensagem = "O campo <b>Id</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Chave){
                $this->response->mensagem = "O campo <b>Chave</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Classe){
                $this->response->mensagem = "O campo <b>Classe</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome){
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            if($Nivel==''){
                $this->response->mensagem = "O campo <b>Nivel</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$IdModuloPai){
                if ($Nivel>0){
                    $this->response->mensagem = "O campo <b>Módulo Pai</b> é de preenchimento obrigatório para nível maior que ZERO.";
                    return false;
                }
            }
            if (($Nivel>0) && ($Classe!='separador')){
                if(!$Controle){
                    $this->response->mensagem = "O campo <b>Controle</b> é de preenchimento obrigatório.";
                    return false;
                }
                if(!$Visao){
                    $this->response->mensagem = "O campo <b>Visao</b> é de preenchimento obrigatório.";
                    return false;
                }
            }
            // Proteção
			//if (!$Nivel) $Nivel = 0;
            
            $DAO = new ModuloDAO();
            $obj = $DAO->retornar($Id);
            if ($obj){
                $obj->setId($Id);
                $obj->setIdModuloPai($IdModuloPai);
                $obj->setNivel($Nivel);
                $obj->setOrdem($Ordem);
                $obj->setChave($Chave);
                $obj->setNome($Nome);
                $obj->setDescricao($Descricao);
                $obj->setParametros($Parametros);
                $obj->setImagem($Imagem);
                $obj->setNivel(($Nivel)? $Nivel: 0);
                $obj->setOrdem(($Ordem)? $Ordem: 0);
                $obj->setClasse($Classe);
                $obj->setControle($Controle);
                $obj->setVisao($Visao);
                $obj->setAtivo($Ativo);
                if ($DAO->salvar($obj)){
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro cadastrado com sucesso.";
                } else {
                    $this->response->mensagem = $DAO->getMensagem();
                }
            } else {
                $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
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
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $IdModuloPai = self::getVar('IdModuloPai', FILTER_SANITIZE_NUMBER_INT);
            $Chave = self::getVar('Chave');
            $Nome = self::getVar('Nome');
            $Descricao = self::getVar('Descricao');
            $Imagem = self::getVar('Imagem');
            $Parametros = self::getVar('Parametros');
            $Nivel = self::getVar('Nivel');
            $Ordem = self::getVar('Ordem', FILTER_SANITIZE_NUMBER_INT);
            $Classe = self::getVar('Classe');
            $Controle = self::getVar('Controle');
            $Visao = self::getVar('Visao');
            
            $Ativo = self::getVar('Ativo');
            $AnosRegistro = self::getVar('AnosRegistro', FILTER_SANITIZE_NUMBER_INT);
            $DiasLiberacao = self::getVar('DiasLiberacao', FILTER_SANITIZE_NUMBER_INT);
            $AnosAtivo = self::getVar('AnosAtivo', FILTER_SANITIZE_NUMBER_INT);

            // Criticar campos
            if(!$Id){
                $this->response->mensagem = "O campo <b>Id</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Chave){
                $this->response->mensagem = "O campo <b>Chave</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Classe){
                $this->response->mensagem = "O campo <b>Classe</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome){
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            if($Nivel==''){
                $this->response->mensagem = "O campo <b>Nivel</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$IdModuloPai){
                if ($Nivel>0){
                    $this->response->mensagem = "O campo <b>Módulo Pai</b> é de preenchimento obrigatório para nível maior que ZERO.";
                    return false;
                }
            }
            if (($Nivel>0) && ($Classe!='separador')){
                if(!$Controle){
                    $this->response->mensagem = "O campo <b>Controle</b> é de preenchimento obrigatório.";
                    return false;
                }
                if(!$Visao){
                    $this->response->mensagem = "O campo <b>Visao</b> é de preenchimento obrigatório.";
                    return false;
                }
            }
            // Proteção
			//if (!$Nivel) $Nivel = 0;
            
            $DAO = new ModuloDAO();
            $obj = $DAO->retornar($Id);
            if ($obj){
                $obj->setIdModuloPai($IdModuloPai);
                $obj->setNivel($Nivel);
                $obj->setOrdem($Ordem);
                $obj->setChave($Chave);
                $obj->setNome($Nome);
                $obj->setDescricao($Descricao);
                $obj->setParametros($Parametros);
                $obj->setImagem($Imagem);
                $obj->setNivel(($Nivel)? $Nivel: 0);
                $obj->setOrdem(($Ordem)? $Ordem: 0);
                $obj->setClasse($Classe);
                $obj->setControle($Controle);
                $obj->setVisao($Visao);
                $obj->setAtivo($Ativo);
                if ($DAO->atualizar($obj)){
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro atualizado com sucesso.";
                } else {
                    $this->response->mensagem = $DAO->getMensagem();
                }
            } else {
                $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
            }
            //if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
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
                $DAO = new ModuloDAO();
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
                //if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
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
        $sEcho = self::getVar('sEcho');
        
        try {
            /** Ordering */
            $aColumns = array(0=>'img', 1=>'id_modulo', 2=>'chave', 2=>'mp.nome', 3=>'nome', 4=>'m.ativo', 5=>'' );
            $sOrder = "";
            if (isset($_GET['iSortCol_0'])){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = 'id_modulo';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');
            $Ativo = self::getVar('Ativo');
            
            $DAO = new ModuloDAO();
            $listagem = $DAO->listar($page, $rows, $sidx, $sord, null, null, $Nome, $Ativo);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getId().');"><span class="glyphicon glyphicon-search"></span>';
                    $this->response->aaData[$i] = array($bt_view, $item->getId(), $item->getChave(), $item->getNomeModuloPai(), $item->getNome(), ($item->getAtivo())? 'sim': 'não');
                    $i++;
                }
                $this->response->sucesso = 1;
            }else{
                $this->response->page = 0; 
                $this->response->total = 0; 
                $this->response->records = 0;
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

    /**
     *  Método para listar registro de profissões para um ComboBox
     *
     * @return array Retornar o array rows[] = {{value:'', text:''},...}
     */    
    public function listarCombo() {
        try {
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');
            $IdModuloPai = self::getVar('IdModuloPai');
            $Nivel = self::getVar('Nivel');
        
            $DAO = new ModuloDAO();
            $listagem = $DAO->listar(null, null, '1', '', $Nivel, $IdModuloPai, $Nome, true);
            if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = intval($item->getId()); 
                    $this->response->rows[$i]['text'] = $item->getNome();
                    $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                    $i++;
                }
            }else{
                $this->response->records=0;
            }
            $this->response->sucesso=1;
            //if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    } 

}