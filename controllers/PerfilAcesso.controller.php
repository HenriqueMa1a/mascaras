<?php
if(!class_exists('PerfilAcessoDAO')){ require_once 'models/PerfilAcessoDAO.class.php';}
if(!class_exists('FuncionalidadeDAO')){ require_once 'models/FuncionalidadeDAO.class.php';}
if(!class_exists('UsuarioDAO')){ require_once 'models/UsuarioDAO.class.php';}
/**
 *  Controle responsável pela módulo TipoUsuario. 
 * 
 */
class PerfilAcessoController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-perfil');
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
            
            $idPerfil = self::getVar('idPerfil');
            $nome = self::getVar('nome');

            $DAO = new PerfilAcessoDAO();
            $listagem = $DAO->listar($page, $rows, $sidx, $sord, $idPerfil, $nome);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getIdPerfil().');"><span class="glyphicon glyphicon-search"></span>';
                    $this->response->aaData[$i] = array($bt_view, $item->getIdPerfil(), $item->getSigla(), $item->getNome(), ($item->getAtivo())? 'SIM': 'NÃO');
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
            $idPerfil = self::getVar('idPerfil');
            $nome = self::getVar('nome');
        
            $DAO = new PerfilAcessoDAO();
        
			$listagem = $DAO->listar(null, null, 'nome', 'asc', $idPerfil, $nome);
			
			if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = intval($item->getIdPerfil()); 
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
                $DAO = new PerfilAcessoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->idPerfil = $obj->getIdPerfil();
                    $this->response->sigla = $obj->getSigla();
                    $this->response->nome = $obj->getNome();
                    $this->response->ativo = ($obj->getAtivo())? 1: 0;
					$this->response->Deletado = ($obj->getDeletado())? 1: 0;
					$this->response->Revisao = $obj->getRevisao();
					$this->response->Acao = $obj->getAcao();
					$this->response->DataAcao = $obj->getDataAcao();
					$this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
					$this->response->NomeUsuarioAcao = $obj->getNomeUsuarioAcao();	

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
            $sigla = self::getVar('sigla');
            $nome = self::getVar('descricao');
            //$ativo = self::getVar('ativo');
            $idUsuarioAcao = self::getVar('IdUsuarioAcao');
			$ativo = (isset($_POST['ativo'])) ? 1 : 0;
            
            // Criticar campos
            if(!$sigla){
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$nome){
                $this->response->mensagem = "O campo <b>Descrição</b> é de preenchimento obrigatório.";
                return false;
            }
            
			//Objeto PerfilAcesso
            $objP = new PerfilAcesso();
            $objP->setSigla($sigla);
            $objP->setNome($nome);
            $objP->setIdUsuarioAcao(intval($IdUsuarioAcao));
            $objP->setAtivo($ativo);
			
			//Salva o Perfil
			$DAOPerfil = new PerfilAcessoDAO();
			if ($DAOPerfil->salvar($objP)){
                $idPerfil = $objP->getIdPerfil();
                $this->response->Id=$idPerfil;				
			
				//buscando as funcionalidades selecionadas
				$arrFuncionalidades = array();
				$habilitado = (isset($_POST['acesso'])) ? 1 : 0;
				if($habilitado){
					foreach($_POST['acesso'] as $acesso){
						if(intval($acesso)){
							$arrFuncionalidades[] = $acesso;
						}
					}
				}

				//Objeto PerfilFuncionalidade
				$DAOPF = new PerfilFuncionalidadeDAO();
				foreach($arrFuncionalidades as $idFuncionalidade){
					$objPF = new PerfilFuncionalidade();
					$objPF->setIdPerfil($idPerfil);
					$objPF->setIdFuncionalidade($idFuncionalidade);
					$DAOPF->salvar($objPF);	
				}
				$DAOPF->Close();			

                $this->response->sucesso = 1;
                $this->response->mensagem = "Registro '$nome' foi cadastrado com sucesso.";
            } else {
                $this->response->mensagem = $DAOPerfil->getMensagem();
            }

            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAOPerfil->_query; }
            $DAOPerfil->Close();
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
            $idPerfil = self::getVar('idPerfil', FILTER_SANITIZE_NUMBER_INT);
            $sigla = self::getVar('sigla');
            $nome = self::getVar('descricao');
            $revisao = self::getVar('revisao', FILTER_SANITIZE_NUMBER_INT);
            $ativo = (isset($_POST['ativo'])) ? 1 : 0;
			//$IdUsuarioAcao = self::getVar('IdUsuarioAcao', FILTER_SANITIZE_NUMBER_INT);
            
            // Criticar campos
            if(!$sigla) {
                $this->response->mensagem = "O campo <b>Sigla</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$nome) {
                $this->response->mensagem = "O campo <b>Descrição</b> é de preenchimento obrigatório.";
                return false;
            }
            
            $this->response->Id=$idPerfil;
            if ($idPerfil){
                $DAOP = new PerfilAcessoDAO();
                $objP = $DAOP->retornar($idPerfil);
                if ($objP){
                    $objP->setSigla($sigla);
                    $objP->setNome($nome);
                    $objP->setRevisao($revisao + 1);
                    $objP->setAtivo($ativo);

                    if ($DAOP->atualizar($objP)){

						//buscando as funcionalidades selecionadas
						$arrFuncionalidades = array();
						foreach($_POST['acesso'] as $acesso){
							if(intval($acesso)){
								$arrFuncionalidades[] = $acesso;
							}
						}

						//Recuperando as funcionalidades do Perfil a ser alterado para compor o Array, retirando do array as funcionalidades
						//já inseridas e deletando as funcionalidades que o perfil não terá mais
						$DAOPF = new PerfilFuncionalidadeDAO();
						$listagemPF = $DAOPF->listarPerfilFuncionalidade($idPerfil);
						if($listagemPF){
							foreach($listagemPF as $obj){
								$funcionalidade = array_search($obj->getIdFuncionalidade(), $arrFuncionalidades);
								if($funcionalidade!==false){//se encontrou, funcionalidade já está inserida, apaga do array
									unset($arrFuncionalidades[$funcionalidade]);
								}else{//se não encontrou, não quero mais essa funcionalidade, então deletar
									if ($DAOPF->excluir($obj->getId())){
										$this->response->sucesso = 1;
									} else {
										$this->response->mensagem = $DAOPF->getMensagem();
									}								
								}
							}
						}
						foreach($arrFuncionalidades as $idFuncionalidade){
							$objPF = new PerfilFuncionalidade();
							$objPF->setIdPerfil($idPerfil);
							$objPF->setIdFuncionalidade($idFuncionalidade);
							$DAOPF->salvar($objPF);	
						}

						$DAOPF->Close();	

                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Registro '$nome' atualizado com sucesso.";
                    } else {
                        $this->response->erro = $DAOP->getErro();
                        $this->response->mensagem = $DAOP->getMensagem();
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAOP->_query; }
                $DAOP->Close();
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
                $DAO = new PerfilAcessoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
					
					$DAO1 = new UsuarioDAO();
					$obj1 = $DAO1->listar(null, null, 'IdUsuario', null, null, null, $Id);
					if ($obj1){
						$this->response->mensagem = "Registro não pode ser excluído, existem usuários vinculados a este Perfil<br>";
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