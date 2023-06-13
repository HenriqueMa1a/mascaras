<?php
if(!class_exists('TipoEventoDAO')){ require_once 'models/TipoEventoDAO.class.php';}
if(!class_exists('EventoDAO')){ require_once 'models/EventoDAO.class.php';}
/**
 *  Controle responsável pela módulo Evento. 
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
class EventoController extends Controller{
    
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
     * @return object Objeto do tipo Evento
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
                $DAO = new EventoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Id = $obj->getIdEvento();
                    $this->response->IdEmpresa = $obj->getIdEmpresa();
                    $this->response->IdParente = $obj->getIdParente();
                    $this->response->IdTipoEvento = $obj->getIdTipoEvento();
                    $this->response->NomeTipoEvento = $obj->getNomeTipoEvento();
                    $this->response->IdLocalizacao = $obj->getIdLocalizacao();
                    $this->response->NomeLocalizacao = $obj->getNomeLocalizacao();
                    $this->response->Sigla = $obj->getSigla();
                    $this->response->Nome = $obj->getNome();
                    $this->response->Capacidade = intval($obj->getCapacidade());
                    $this->response->Observacao = $obj->getObservacao();
                    //$this->response->DataInicial = ($obj->getDataInicial()) ? Formatacao::formatarDataHoraSQL($obj->getDataInicial(), false) : '';
                    //$this->response->DataFinal = ($obj->getDataFinal()) ? Formatacao::formatarDataHoraSQL($obj->getDataFinal(), false) : '';
                    if ($obj->getDataInicial()){
                        $dtDataInicial = explode(" ", Formatacao::formatarDataHoraSQL($obj->getDataInicial(), false)); 
                        if (count($dtDataInicial)>1){
                            $this->response->DataInicial = $dtDataInicial[0];
                            $this->response->HoraInicial = substr($dtDataInicial[1], 0, 5);
                        } else {
                            $this->response->DataInicial = Formatacao::formatarDataSQL($obj->getDataInicial(), false);
                            $this->response->HoraInicial = '00:00';
                        }
                    } else {
                        $this->response->DataInicial = '';
                        $this->response->HoraInicial = '00:00';
                    }
                    if ($obj->getDataFinal()){
                        $dtDataFinal = explode(" ", Formatacao::formatarDataHoraSQL($obj->getDataFinal(), false)); 
                        if (count($dtDataFinal)>1){
                            $this->response->DataFinal = $dtDataFinal[0];
                            $this->response->HoraFinal = substr($dtDataFinal[1], 0, 5);
                        } else {
                            $this->response->DataFinal = Formatacao::formatarDataSQL($obj->getDataFinal(), false);
                            $this->response->HoraFinal = '00:00';
                        }
                    } else {
                        $this->response->DataFinal = '';
                        $this->response->HoraFinal = '00:00';
                    }
                    $this->response->CargaHoraria = ($obj->getCargaHoraria())? $obj->getCargaHoraria() : '00:00';
                    $this->response->TextoCertificado = $obj->getTextoCertificado();
                        
                    $this->response->Solicitacoes = $obj->getSolicitacoes();
                    $this->response->Aprovados = $obj->getAprovados();
                    $this->response->Reprovados = $obj->getReprovados();
                    $this->response->Saldo = ($obj->getCapacidade() - $obj->getAprovados());
                    $this->response->Presentes = $obj->getPresentes();
                    
                    $this->response->IdStatus = $obj->getIdStatus();
                    $this->response->NomeStatus = $obj->getNomeStatus();
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
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo Evento
     */    
    public function retornarEventoAtivo() {
        
        try{
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            $DAO = new EventoDAO();
            $obj = $DAO->retornarEventoAtivo();
            if ($obj){
               $this->response->Evento = $obj->getIdEvento();
               $this->response->sucesso = 1;
               $this->response->mensagem = "Registro foi localizado com sucesso.";
            } else {
               $this->response->mensagem = "Erro ao localizar o registro.";
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
     *  Método para retornar o Evento Ativo (somente 1 Evento Principal pode estar ativo)
     *
     * @return object Objeto do tipo Evento 
     */    
    public function retornarEventoPrincipalAtivo() {
        try { 
            $DAO = new EventoDAO(); 
			$obj = $DAO->retornarEventoPrincipalAtivo();

			if ($obj) { 				
                $this->response->IdEvento = $obj->getIdEvento();
				 $this->response->IdParente = $obj->getIdParente();
                $this->response->sucesso=1;
            }else{
                $this->response->mensagem = "Erro ao localizar o registro, não existe nenhum Evento ativo no momento.";
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
     *  Método para criar um novo registro
     *
     * @return int O Identificador do registro criado
     */    
    public function incluir() {
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
			$IdParente = self::getVar('IdParente', FILTER_SANITIZE_NUMBER_INT);		
            $IdTipoEvento = self::getVar('IdTipoEvento', FILTER_SANITIZE_NUMBER_INT);
            $IdLocalizacao = self::getVar('IdLocalizacao', FILTER_SANITIZE_NUMBER_INT);
            $Sigla = self::getVar('Sigla');
            $Nome = self::getVar('Nome');
            $Capacidade = self::getVar('Capacidade', FILTER_SANITIZE_NUMBER_INT);
            $DataInicial = self::getVar('DataInicial');
            $HoraInicial = self::getVar('HoraInicial');
            $DataFinal = self::getVar('DataFinal');
            $HoraFinal = self::getVar('HoraFinal');
            $CargaHoraria = self::getVar('CargaHoraria');
            $TextoCertificado = self::getVar('TextoCertificado');
            $Observacao = self::getVar('Observacao');
            $IdStatus = 5;//self::getVar('IdStatus', FILTER_SANITIZE_NUMBER_INT);
            $Ativo = self::getVar('Ativo');
            
            // Criticar campos
            if(!$IdTipoEvento){
                $this->response->mensagem = "O campo <b>Tipo de Evento</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$IdLocalizacao){
                $this->response->mensagem = "O campo <b>Localização</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$DataInicial) {
                $this->response->mensagem = "Erro: O campo <b>Data Inicial</b> é de preenchimento obrigatório.";
                return false;
            } else if (!Validacao::validarData($DataInicial)){
                $this->response->DataInicial = $DataInicial;
                $this->response->mensagem = "Erro: O campo <b>Data Inicial</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                return false;
            }
            if(!$DataFinal) {
                $this->response->mensagem = "Erro: O campo <b>Data Final</b> é de preenchimento obrigatório.";
                return false;
            } else if (!Validacao::validarData($DataFinal)){
                $this->response->DataFinal = $DataFinal;
                $this->response->mensagem = "Erro: O campo <b>Data Final</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                return false;
            }
            
            // Validar Data Futura
            $Dias = DataHora::diferencaData($DataInicial, $DataFinal, 'd');
            $this->response->Dias = $Dias;
            if (($Dias<0)){ // Menor não pode
                $this->response->Dias = $Dias;
                $this->response->mensagem = "Erro: O campo <b>Data Final</b> tem que ser maior que o campo <b>Data Inicial</b>.";
                return false;
            }
            if(!$CargaHoraria) {
                $this->response->mensagem = "Erro: O campo <b>Carga Horária</b> é de preenchimento obrigatório.";
                return false;
            }
            
            // Preparar Campos
            $HoraInicial = (strpos($HoraInicial, ':')!==false)? $HoraInicial.':00': '00:00:00';
            $HoraFinal = (strpos($HoraFinal, ':')!==false)?  $HoraFinal.':00': '00:00:00';
            $DataInicial = Formatacao::formatarDataSQL($DataInicial);
            $DataFinal = Formatacao::formatarDataSQL($DataFinal);
            
            $obj = new Evento();
            $obj->setIdEmpresa(($IdEmpresa)? $IdEmpresa: $this->Usuario->IdEmpresa);
            $obj->setIdParente(($IdParente)? $IdParente: null);			
            $obj->setIdTipoEvento($IdTipoEvento);
            $obj->setIdLocalizacao(($IdLocalizacao)? $IdLocalizacao: null);
            $obj->setSigla($Sigla);
            $obj->setNome($Nome);
            $obj->setCapacidade(intval($Capacidade));
            $obj->setDataInicial($DataInicial.' '.$HoraInicial);
            $obj->setDataFinal($DataFinal.' '.$HoraFinal);
            $obj->setCargaHoraria($CargaHoraria);
            $obj->setTextoCertificado($TextoCertificado);
            $obj->setObservacao($Observacao);
            $obj->setIdStatus($IdStatus);
            $obj->setAtivo($Ativo);
            
            $DAO = new EventoDAO();
            if ($DAO->salvar($obj)){
                $Id = $obj->getId();
                $this->response->Id=$Id;
				//Verificar se é evento Principal
				if(!$obj->getIdParente()){ 
					$DAO->gravarEventoPrincipal($Id);
				}
				
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
            $IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            $IdTipoEvento = self::getVar('IdTipoEvento', FILTER_SANITIZE_NUMBER_INT);
            $IdLocalizacao = self::getVar('IdLocalizacao', FILTER_SANITIZE_NUMBER_INT);
            $Sigla = self::getVar('Sigla');
            $Nome = self::getVar('Nome');
            $Capacidade = self::getVar('Capacidade', FILTER_SANITIZE_NUMBER_INT);
            $DataInicial = self::getVar('DataInicial');
            $HoraInicial = self::getVar('HoraInicial');
            $DataFinal = self::getVar('DataFinal');
            $HoraFinal = self::getVar('HoraFinal');
            $CargaHoraria = self::getVar('CargaHoraria');
            $TextoCertificado = self::getVar('TextoCertificado');
            $Observacao = self::getVar('Observacao');
            $IdStatus = self::getVar('IdStatus', FILTER_SANITIZE_NUMBER_INT);
            $Ativo = self::getVar('Ativo');
            
            // Criticar campos
            if(!$IdTipoEvento){
                $this->response->mensagem = "O campo <b>Tipo de Evento</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$IdLocalizacao){
                $this->response->mensagem = "O campo <b>Localização</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$Nome) {
                $this->response->mensagem = "O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$DataInicial) {
                $this->response->mensagem = "Erro: O campo <b>Data Inicial</b> é de preenchimento obrigatório.";
                return false;
            } else if (!Validacao::validarData($DataInicial)){
                $this->response->DataInicial = $DataInicial;
                $this->response->mensagem = "Erro: O campo <b>Data Inicial</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                return false;
            }
            if(!$DataFinal) {
                $this->response->mensagem = "Erro: O campo <b>Data Final</b> é de preenchimento obrigatório.";
                return false;
            } else if (!Validacao::validarData($DataFinal)){
                $this->response->DataFinal = $DataFinal;
                $this->response->mensagem = "Erro: O campo <b>Data Final</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                return false;
            }
            // Validar Data Futura
            $Dias = DataHora::diferencaData($DataInicial, $DataFinal, 'd');
            $this->response->Dias = $Dias;
            if (($Dias<0)){ // Menor não pode
                $this->response->Dias = $Dias;
                $this->response->mensagem = "Erro: O campo <b>Data Final</b> tem que ser maior que o campo <b>Data Inicial</b>.";
                return false;
            }
            if(!$CargaHoraria) {
                $this->response->mensagem = "Erro: O campo <b>Carga Horária</b> é de preenchimento obrigatório.";
                return false;
            }

            // Preparar Campos
            $this->response->HoraInicial = $HoraInicial;
            $HoraInicial = (strpos($HoraInicial, ':')!==false)? $HoraInicial.':00': '00:00:00';
            $HoraFinal = (strpos($HoraFinal, ':')!==false)?  $HoraFinal.':00': '00:00:00';
            $DataInicial = Formatacao::formatarDataSQL($DataInicial);
            $DataFinal = Formatacao::formatarDataSQL($DataFinal);
            
            $this->response->DataInicial = $DataInicial.' '.$HoraInicial;
            
            $this->response->Id=$Id;
            if ($Id){
                $DAO = new EventoDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    //$obj->setIdEmpresa(($IdEmpresa)? $IdEmpresa: $this->Usuario->IdEmpresa);
                    //$obj->setIdParente(($IdParente)? $IdParente: null);
                    $obj->setIdTipoEvento($IdTipoEvento);
                    $obj->setIdLocalizacao(($IdLocalizacao)? $IdLocalizacao: null);
                    $obj->setSigla($Sigla);
                    $obj->setNome($Nome);
                    $obj->setCapacidade(intval($Capacidade));
                    $obj->setDataInicial($DataInicial.' '.$HoraInicial);
                    $obj->setDataFinal($DataFinal.' '.$HoraFinal);
                    $obj->setCargaHoraria($CargaHoraria);
                    $obj->setTextoCertificado($TextoCertificado);
                    $obj->setObservacao($Observacao);
                    $obj->setIdStatus($IdStatus);
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
                $DAO = new EventoDAO();
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
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
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
            $aColumns = array(0=>'img', 1=>'id_evento', 2=>'nome_tipo_evento', 3=>'nome', 4=>'data', 5=>'', 6=>'' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = 'id_evento';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            $IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            $IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);
			$IdTipoEvento = self::getVar('IdTipoEvento', FILTER_SANITIZE_NUMBER_INT);
            $IdLocalizacao = self::getVar('IdLocalizacao', FILTER_SANITIZE_NUMBER_INT);
            $IdStatus = self::getVar('IdStatus');
            $IdParente = self::getVar('IdParente', FILTER_SANITIZE_NUMBER_INT);
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');

            $DAO = new EventoDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $IdEmpresa, $IdTipoEvento, $IdLocalizacao, $IdStatus, $IdParente, $Id, $Nome);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getIdEvento().');"><span class="glyphicon glyphicon-search"></span>';
                    if ($item->getDataInicial() == $item->getDataFinal()){
                        $DataInicial = ($item->getDataInicial()) ? Formatacao::formatarDataSQL($item->getDataInicial(), false) : '';
                        $DataFinal = ($item->getDataFinal()) ? Formatacao::formatarDataSQL($item->getDataFinal(), false) : '';
                        $DataEvento = $DataInicial;
                    } else {
                        $DataInicial = ($item->getDataInicial()) ? Formatacao::formatarDataSQL($item->getDataInicial(), false) : '';
                        $DataFinal = ($item->getDataFinal()) ? Formatacao::formatarDataSQL($item->getDataFinal(), false) : '';
                        $DataEvento = $DataInicial.' à '.$DataFinal;
                    }
                    $DataAcao = ($item->getDataAcao()) ? Formatacao::formatarDataHoraSQL($item->getDataAcao(), false) : '';
                    $Saldo = ($item->getCapacidade() - $item->getAprovados());
                    if ($Saldo > 0){
                        if ($Saldo > ($item->getCapacidade()* 0.1)){
                            $Saldo = "<b><span class='green'>$Saldo</span></b>";
                        } else {
                            $Saldo = "<b><span class='orange'>$Saldo</span></b>";
                        }
                    } else {
                        $Saldo = "<b><span class='red'>$Saldo</span></b>";
                    }
					
					$temSubEventos = $DAO->EventoComSubEventos($item->getIdEvento());
					
					//Se for um Evento Principal com SubEventos não mostrar Capacidade, Solicitações , Inscrições e Saldo
					if ($temSubEventos){
						$this->response->aaData[$i] = array($bt_view, $item->getIdEvento(), $item->getNomeTipoEvento(), $item->getNome(), $DataEvento, '---', '---', '---', '---', ($item->getAtivo())? 'sim': 'não');
					}else{
						$this->response->aaData[$i] = array($bt_view, $item->getIdEvento(), $item->getNomeTipoEvento(), $item->getNome(), $DataEvento, $item->getCapacidade(), $item->getSolicitacoes(), $item->getAprovados(), $Saldo, ($item->getAtivo())? 'sim': 'não');
                    }
					
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
            $IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            $IdTipoEvento = self::getVar('IdTipoEvento', FILTER_SANITIZE_NUMBER_INT);
            $IdLocalizacao = self::getVar('IdLocalizacao', FILTER_SANITIZE_NUMBER_INT);
            $IdStatus = self::getVar('IdStatus');
            $IdParente = self::getVar('IdParente', FILTER_SANITIZE_NUMBER_INT);
            $IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');
            $Nivel = self::getVar('Nivel', FILTER_SANITIZE_NUMBER_INT);

            $DAO = new EventoDAO(); 
			
            $listagem = $DAO->listar(null, null, 'IdEvento', 'desc', $IdEmpresa, $IdTipoEvento, $IdLocalizacao, $IdStatus, $IdParente, $IdEvento, $Nome);
			if ($listagem) { 
                $this->response->records = count($listagem);
                $i = 0;				
                foreach ($listagem as $item){
					$this->response->rows[$i]['value'] = $item->getIdEvento();
					$this->response->rows[$i]['text'] = $item->getNome();					
					$i++;
					/*
                    if ($Nivel==0){
                        if (intval($item->getIdParente())==0){
                            $this->response->rows[$i]['value'] = $item->getIdEvento();
                            $this->response->rows[$i]['text'] = $item->getNome();
                            $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                            $i++;
                        }
                    } else {
                        if (($IdEvento > 0) && ($item->getIdParente()>0)){
                            $this->response->rows[$i]['value'] = $item->getIdEvento();
                            $this->response->rows[$i]['text'] = $item->getNome();
                            $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                            $i++;
                        }
                    }
					*/					
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

    /**
     *  Método para listar registro para um ComboBox
     *
     * @return array Retornar o array rows[] = {{value:'', text:''},...}
     */    
    public function listarEventosSeminario() {
        try { 
            $IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            $IdTipoEvento = self::getVar('IdTipoEvento', FILTER_SANITIZE_NUMBER_INT);
            $IdLocalizacao = self::getVar('IdLocalizacao', FILTER_SANITIZE_NUMBER_INT);
            $IdStatus = self::getVar('IdStatus');
            $IdParente = self::getVar('IdParente', FILTER_SANITIZE_NUMBER_INT);
            $IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');
            $Nivel = self::getVar('Nivel', FILTER_SANITIZE_NUMBER_INT);

            $DAO = new EventoDAO(); 
			
            $listagem = $DAO->listarEventosSeminario(null, null, 'nome', 'asc', $IdEmpresa, $IdTipoEvento, $IdLocalizacao, $IdStatus, $IdParente, $IdEvento, $Nome);
			
			if ($listagem) { 
                $this->response->records = count($listagem);
                $i = 0;			
                foreach ($listagem as $item){
					$this->response->rows[$i]['value'] = $item->getIdEvento();
					$this->response->rows[$i]['texto'] = $item->getNome();
					$this->response->rows[$i]['text'] = $item->getName();
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
	
	
    /**
     * Método para atualizarParticipantes um registro
     * 
     * @param int Identificador do registro 
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function atualizarParticipantes($p_Id=null){
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
            //$this->response->Id = $Id;
            //if ($Id){
                $DAO = new EventoDAO();
                $resultado = $DAO->atualizarParticipantes($Id);
                if ($resultado){
                    $this->response->sucesso = 1;
                    $this->response->mensagem = $resultado." solcitações de inscrições foram incluidas com sucesso.";
                } else {
                    $this->response->mensagem = "Nenhuma solcitação de inscrição foi encontrado.";
                    $this->response->mensagem .= $DAO->getMensagem();
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            //} else {
            //    $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            //}
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
	
}