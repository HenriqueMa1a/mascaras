<?php
if(!class_exists('EventoDAO')){ require_once 'models/EventoDAO.class.php';}
if(!class_exists('EventoParticipanteDAO')){ require_once 'models/EventoParticipanteDAO.class.php';}
if(!class_exists('EventoPresencaDAO')){ require_once 'models/EventoPresencaDAO.class.php';}
if(!class_exists('InscricaoDAO')){ require_once 'models/InscricaoDAO.class.php';}
//require_once ('assets/barcode.class.php');
//Carregando a biblioteca mPDF
require_once ('MPDF57/pdf_ean13.php');
//require_once ('phpqrcode/qrlib.php');

/** CÓPIA DO EventoParticipante.CONTROLLER PARA CRIAR O EventoPresenca.CONTROLLER (KELLEN NERY)
 *  Controle responsável pela módulo EventoParticipante. 
 * 
 * @package Controller
 * @category Controller
 * @version 1.0
 * @since   2020-05-21
 * @version 1.6
 * @author  Kellen Nery
 * 
 * 
 * @edit    2020-05-22<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Implementação da Documentação
 */
class EventoPresencaController extends Controller{
    
    private $_NomeStatus = array(0=>'Não definida', 1=>'Pre-Inscrito', 2=>'Confirmado', 3=>'Recusado', 4=>'Cancelada', 5=>'Presença Confirmada', 6=>'Presente', 7=>'', 8=>'', 9=>'');
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-evento-participante');
    }
    
    /**
     *  Método para retornar um registro
     *
     * @return object Objeto do tipo EventoParticipante
     */    
    public function retornar() {
        
        try{ 
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            //$this->response->IdUsuario = $this->Usuario->Id;
            
            $IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);
			$IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);
			
            if ($IdParticipante && $IdEvento){ 
                $DAO = new EventoPresencaDAO();
                $obj = $DAO->retornarRegistroEventoParticipante($IdEvento, $IdParticipante); 
                
                if ($obj){ 
					$this->response->Id = $obj->getId();
                    $this->response->IdEvento = $obj->getIdEvento();
                    $this->response->NomeEvento = $obj->getNomeEvento();
                    $this->response->IdParticipante = $obj->getIdParticipante();
                    $this->response->NomeParticipante = $obj->getNomeParticipante();
                    $this->response->NomeCracha = $obj->getNomeCracha();
					$this->response->Entrada = $obj->getEntrada();
					$this->response->Saida = $obj->getSaida();
                    $this->response->Observacao = $obj->getObservacao();
                    $this->response->CargaHoraria = $obj->getCargaHoraria();       
                    
                    $this->response->Revisao = $obj->getRevisao();
					$this->response->Deletado = $obj->getDeletado(); 			
					
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
			
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }				
	
			$IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);
			$IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);
			
			$DAO = new EventoPresencaDAO();
			
            // Proteção contra Chave Duplicada
            $Chave = UUID::v4();
            if ($Chave){
                $obj = $DAO->retornarPorChave($Chave); // 2. Tentativa 
                if ($obj){
                    $Chave = UUID::v4();
                    $obj = $DAO->retornarPorChave($Chave); // 3. Tentativa 
                    if ($obj){
                        $Chave = UUID::v4();
                    }
                }
            }
            
			$obj = new EventoPresenca();
			$obj->setIdEvento($IdEvento);
			$obj->setIdParticipante($IdParticipante);
			$obj->setChave($Chave);			

            if ($DAO->salvar($obj)){  
                $Id = $obj->getId();
                $this->response->Id=$Id;
                $this->response->sucesso = 1;
			    $this->response->mensagem = "Registro foi cadastrado com sucesso.";
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
    public function editar($IdEventoPresenca=null, $Presenca=null, $IdParticipante=null, $NomeParticipante=null) {
        try {
			
			if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }

            if(!$IdEventoPresenca){ $IdEventoPresenca = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);}
            if(!$Presenca){ $Presenca = self::getVar('Situacao', FILTER_SANITIZE_NUMBER_INT);}
			
            $this->response->Id = $IdEventoPresenca;
            $this->response->Situacao = $Presenca;
			
            if ($IdEventoPresenca){ 
                $DAO = new EventoPresencaDAO();
                $obj = $DAO->retornar($IdEventoPresenca);
				
                if ($obj){
                    $obj->setDeletado($Presenca);
					
                    if ($DAO->atualizar($obj)){ 
                        $this->response->sucesso = 1;
						$this->response->mensagem = "Registro atualizado com sucesso.";
                    } else {
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$IdEventoPresenca'.";
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
     *  Método para EMITIR CREDENCIAL para crachá
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function emitirCredencial() {
		
		$IdParticipante = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
		$IdEvento = 1; //TEMPORARIAMENTE, DEVE SER BUSCADO O CÓDIGO DO EVENTO NO MOMENTO DO CLICK
		
		$dao = new EventoParticipanteDAO();
		$obj = $dao->retornarPorEventoParticipante($IdEvento, $IdParticipante);
	
		//$nomeCracha = $obj->getNomeCracha();

		// inicia o buffer
		ob_start ();

		// pega o conteudo do buffer, insere na variavel e limpa a memória
		$html = ob_get_clean ();
		$html = '';

		$html = $html . '<br><br> <p style="font-size:12pt;">' . $nomeCracha . "</p>";
	
		$mpdf=new PDF_EAN13();
		$mpdf->AddPage();
		$mpdf->EAN13(10,40,$IdParticipante);
	
		$mpdf->allow_charset_conversion = true;
		$mpdf->charset_in = 'utf-8';
		$mpdf->WriteHTML($html);

		// imprime
		$mpdf->Output();
		exit();
		
			
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
                $DAO = new EventoParticipanteDAO();
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
     * Método para excluir um registro fisicamente do banco
     * Criado por: Kellen Nery
     */    
    public function excluirFisico(){
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);

            //$this->response->Id=$Id;
            if ($Id){
                $DAO = new EventoParticipanteDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    if ($DAO->excluirFisico($Id)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Registro excluído com sucesso.";
                    } else {
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
     * Método para reprovar um registro
     *
     * @param int $Id O identificador do EventoParticipante
     * @param int $IdEvento O identificador do Evento
     * @param int $IdParticipante O identificador do Participante
     * @param string $Observacao Observações da transação
     * 
     * @return bool Se atualização relizada com sucesso
     */    
    public function reprovar($Id=null, $IdEvento=null, $IdParticipante=null, $Observacao=null){
        try {

            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            $DAO = new EventoParticipanteDAO();
            $daoEvento = new EventoDAO();
            $daoInscricao = new InscricaoDAO();
            
            // Coletar parametros
            if(!$Id){            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);}
            if(!$IdEvento){      $IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);}
            if(!$IdParticipante){$IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);}
            if(!$Observacao){    $Observacao = self::getVar('Observacao');}

            $this->response->Id = $Id;
            $this->response->IdEvento = $IdEvento;
            $this->response->IdParticipante = $IdParticipante;
            $this->response->Observacao = $Observacao;
		            
            // Criticar campos
            if(!$Id){
                if((!$IdEvento) || (!$IdParticipante)) {
                    $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
                    return false;
                }
            }
            if(!$Observacao) {
                $this->response->mensagem = "O campo <b>Observação</b> é de preenchimento obrigatório.";
                return false;
            }
            
            if ($Id){
                $obj = $DAO->retornar($Id);
            } else {
                $obj = $DAO->retornarPorEventoParticipante($IdEvento, $IdParticipante);
            }
                if ($obj){
                    $this->response->IdParticipante = $obj->getIdParticipante();
                    $this->response->Nome = $obj->getNomeParticipante();
                    $this->response->IdStatus = $obj->getIdStatus();
                    if ($obj->getIdStatus()==1) { // 1:Pre-Inscrito
                        $obj->setIdStatus(3); // 3:Recusado
                        $obj->setObservacao($Observacao);
                        $obj->setIdUsuarioAprovacao($this->Usuario->Id);
                        $obj->setDataAprovacao(date("Y-m-d H:i:s"));
                        if ($DAO->atualizar($obj)){
                            $this->response->sucesso = 1;
                            $this->response->mensagem = "O registro <b>'".$this->response->Nome."'</b> foi recusado com sucesso.";
                            
                                // Atualizar Inscrição Principal
                                $objInscricao = $daoInscricao->retornarPorUsuario($this->response->IdParticipante);
								
								if ($objInscricao){
                                    $this->response->IdFormulario = $objInscricao->getId();
                                    $this->response->Apelido = $objInscricao->getNomeCracha();
                                    $this->response->Email = $objInscricao->getEmail();
                                    $this->response->pSolicitacoes = $objInscricao->getSolicitacoes();
                                    $this->response->pAprovados = $objInscricao->getAprovados();
                                    $this->response->pReprovados = $objInscricao->getReprovados();
                                    if ($this->response->pSolicitacoes == ($this->response->pAprovados + $this->response->pReprovados)){
                                        $this->response->IdStatus = 10; // Inscrição Concluida
                                    } else {
                                        $this->response->IdStatus = 8;  // Inscrição Parcial
                                    }
                                    if ($daoInscricao->atualizarCampo($this->response->IdFormulario, 'id_status', $this->response->IdStatus)){
                                        $this->response->mensagem .= '<br/>Status principal atualizado com sucesso. ('.$this->response->IdStatus.')';
                                        
                                        if ($this->response->IdStatus ==10){ // 10: Concluído
                                            // Enviar Email;
                                            $this->response->Assunto = "Inscrição: ".$this->response->IdFormulario." - Status: ".$this->response->NomeStatus;
                                            $Conteudo = (file_exists('templates/inscricao.comunicar.email.html'))? file_get_contents('templates/inscricao.comunicar.email.html'): '';
                                            if ($Conteudo!=''){
                                                if ($this->response->pSolicitacoes == $this->response->pAprovados){
                                                    $this->response->Assunto = "Inscrição: ".$this->response->IdFormulario.' - Confirmação de inscrição no III Simpósio Internacional de Imunobiológicos';
                                                    $this->response->NomeStatus = "Confirmada.";
                                                    $this->response->TextoStatus = "Sua inscrição no III Simpósio Internacional de Imunobiológicos foi confirmada para todos os módulos solicitados.";
                                                } else if ($this->response->pSolicitacoes == $this->response->pReprovados){
                                                    $this->response->Assunto = "Inscrição: ".$this->response->IdFormulario.' - Cancelamento de inscrição no III Simpósio Internacional de Imunobiológicos';
                                                    $this->response->NomeStatus = "<b>Não</b> foi confirmada.";
                                                    $this->response->TextoStatus = "Sua inscrição no III Simpósio Internacional de Imunobiológicos não pode ser confirmada por indisponibilidade de vagas ou não atendimento aos pré-requisitos de participação.";
                                                } else {
                                                    $this->response->Assunto = "Inscrição: ".$this->response->IdFormulario.' - Confirmação PARCIAL de inscrição no III Simpósio Internacional de Imunobiológicos';
                                                    $this->response->NomeStatus = "Parcialmente confirmada.";
                                                    $this->response->TextoStatus = "Sua inscrição no III Simpósio Internacional de Imunobiológicos foi confirmada para alguns módulos solicitados e recusada para outros, de acordo com a disponibilidade de vagas.";
                                                }
                                                
                                                $Tabela = "<table style='border: 0.5px solid #000000; font-family: arial; font-size: 8pt; vertical-align: top; ' cellspacing='0' cellpadding='5'>"
                                                        ."<tr style='background-color: #ccc; '>"
                                                        ."    <td width='30' style='border: 0.5px solid #000000;'><b>#</b></td>"
                                                        ."    <td width='200' style='border: 0.5px solid #000000;'><b>Evento</b></td>"
                                                        ."    <td width='50' style='border: 0.5px solid #000000;'><b>Status</b></td>"
                                                        ."    <td width='300' style='border: 0.5px solid #000000;'><b>Observações</b></td>"
                                                        ."</tr>";
                                                        
                                                $listagem = $DAO->listar(null, null, '1', 'asc', null, null, $this->response->IdParticipante);
                                                if ($listagem) {
                                                    $i=0;
                                                    foreach ($listagem as $item){
                                                        $cor = ($i%2==0? '#eee': '#fff');
                                                        $corStatus = '#000000';
                                                        if ($item->getIdStatus()==1){ $corStatus = '#000000';} 
                                                        else if ($item->getIdStatus()==2){ $corStatus = '#69aa46';} 
                                                        else if ($item->getIdStatus()==3){ $corStatus = '#dd5a43';} 
                                                        $Tabela .= "<tr style='background-color: $cor;'>"
                                                                ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getId()."</td>"
                                                                ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getNomeEvento()."</td>"
                                                                ."    <td  style='border: 0.5px solid #000000; text-align:left;'><span style='color: $corStatus;'>".$item->getNomeStatus()."</span></td>"
                                                                ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getObservacao()."</td>"
                                                                ."</tr>";
                                                        $i++;
                                                    }
                                                }
                                                $Tabela .= '</table>';
                                                
                                                $Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
                                                $Conteudo = str_replace("{MENSAGEM}", $this->response->TextoStatus, $Conteudo);
                                                $Conteudo = str_replace("{TABELA}", $Tabela, $Conteudo);
                                                $Conteudo = str_replace("{NUMERO}", $this->response->IdFormulario, $Conteudo);
                                                $Conteudo = str_replace("{CRACHA}", $this->response->Apelido, $Conteudo);
                                                $Conteudo = str_replace("{STATUS}", $this->response->NomeStatus, $Conteudo);
                                                if (Email::enviar($this->response->Nome, $this->response->Email, 'sact@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
                                                    $this->response->mensagem .= "Uma mensagem foi enviado com sucesso para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
                                                } else {
                                                    $this->response->mensagem .= "<br/>Erro ao enviar comunicado para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
                                                    $this->response->mensagem .= "[".Email::getErro()." - ".Email::getMensagem()."]";
                                                }
                                            } else {
                                                $this->response->mensagem .= "<br/>Erro: Não existe template de email para esta operação.";
                                            }
                                        }
                                    } else {
                                        $this->response->mensagem .= '<br/>'.$daoInscricao->getMensagem();
                                    }
                                } else {
                                    $this->response->mensagem .= '<br/>Erro ao localizar a Inscrição principal. (IdParticipante:'.$this->response->IdParticipante.')';
                                }
                        } else {
                            $this->response->mensagem = $DAO->getMensagem();
                        }
                    } else {
                        $this->response->mensagem = "Não é possível realizar esta operação para registros com status: '".$this->response->IdStatus."'.";
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro. {Id:'$Id'}";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();

        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
  
    /**
     * Método para aprovar um registro
     *
     * @param int $Id O identificador do EventoParticipante
     * @param int $IdEvento O identificador do Evento
     * @param int $IdParticipante O identificador do Participante
     * @param string $Observacao Observações da transação
     * 
     * @return bool Se atualização relizada com sucesso
     */    
    public function aprovar($Id=null, $IdEvento=null, $IdParticipante=null, $Observacao=null){
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            $DAO = new EventoParticipanteDAO();
            $daoEvento = new EventoDAO();
            $daoInscricao = new InscricaoDAO();
            
            // Coletar parametros
            if(!$Id){            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);}
            if(!$IdEvento){      $IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);}
            if(!$IdParticipante){$IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);}
            if(!$Observacao){    $Observacao = self::getVar('Observacao');}
            
            $this->response->Id = $Id;
            $this->response->IdEvento = $IdEvento;
            $this->response->IdParticipante = $IdParticipante;
            $this->response->Observacao = $Observacao;
            
            // Criticar campos
            if(!$Id){
                if((!$IdEvento) || (!$IdParticipante)) {
                    $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
                    return false;
                }
            }
            /* if(!$Observacao) {
                $this->response->mensagem = "O campo <b>Observação</b> é de preenchimento obrigatório.";
                return false;
            } // */
            
            if ($Id){
                $obj = $DAO->retornar($Id);
            } else {
                $obj = $DAO->retornarPorEventoParticipante($IdEvento, $IdParticipante);
            }
            
            if ($obj){
                $IdEvento = $obj->getIdEvento();
                
                // Criticar Status e Capacidade do Evento
                $objEvento = $daoEvento->retornar($IdEvento);
                if ($objEvento){
                    $this->response->Capacidade = $objEvento->getCapacidade();
                    $this->response->Aprovados = $objEvento->getAprovados();
                    
                    if ($objEvento->getCapacidade() > $objEvento->getAprovados()) { // Verificar Capacidade
                    
                        $this->response->IdParticipante = $obj->getIdParticipante();
                        $this->response->Nome = $obj->getNomeParticipante();
                        $this->response->IdStatus = $obj->getIdStatus();
                        if ($obj->getIdStatus()==1) { // 1:Pre-Inscrito
                            $obj->setIdStatus(2); // 2:Aprovado (Inscrito)
                            //$obj->setObservacao($Observacao);
                            $obj->setIdUsuarioAprovacao($this->Usuario->Id);
                            $obj->setDataAprovacao(date("Y-m-d H:i:s"));
                            if ($DAO->atualizar($obj)){
                                $this->response->sucesso = 1;
                                $this->response->mensagem = "O registro <b>'".$this->response->Nome."'</b> foi aprovado com sucesso.";
                                
                                // Atualizar Inscrição Principal
                                $objInscricao = $daoInscricao->retornarPorUsuario($this->response->IdParticipante);
                                if ($objInscricao){
                                    $this->response->IdFormulario = $objInscricao->getId();
                                    $this->response->Apelido = $objInscricao->getNomeCracha();
                                    $this->response->Email = $objInscricao->getEmail();
                                    $this->response->pSolicitacoes = $objInscricao->getSolicitacoes();
                                    $this->response->pAprovados = $objInscricao->getAprovados();
                                    $this->response->pReprovados = $objInscricao->getReprovados();
                                    if ($this->response->pSolicitacoes == ($this->response->pAprovados + $this->response->pReprovados)){
                                        $this->response->IdStatus = 10; // Inscrição Concluida
                                    } else {
                                        $this->response->IdStatus = 8;  // Inscrição Parcial
                                    }
									
                                    if ($daoInscricao->atualizarCampo($this->response->IdFormulario, 'id_status', $this->response->IdStatus)){
                                        $this->response->mensagem .= '<br/>Status principal atualizado com sucesso. ('.$this->response->IdStatus.')';
                                        
                                        if ($this->response->IdStatus ==10){ // 10: Concluído
                                            // Enviar Email;
                                            $this->response->Assunto = "Inscrição: ".$this->response->IdFormulario." - Status: ".$this->response->NomeStatus;
                                            $Conteudo = (file_exists('templates/inscricao.comunicar.email.html'))? file_get_contents('templates/inscricao.comunicar.email.html'): '';
                                            if ($Conteudo!=''){
                                                if ($this->response->pSolicitacoes == $this->response->pAprovados){
                                                    $this->response->Assunto = "Inscrição: ".$this->response->IdFormulario.' - Confirmação de inscrição no III Simpósio Internacional de Imunobiológicos';
                                                    $this->response->NomeStatus = "Confirmada.";
                                                    $this->response->TextoStatus = "Sua inscrição no III Simpósio Internacional de Imunobiológicos foi confirmada para todos os módulos solicitados.";
                                                } else if ($this->response->pSolicitacoes == $this->response->pReprovados){
                                                    $this->response->Assunto = "Inscrição: ".$this->response->IdFormulario.' - Cancelamento de inscrição no III Simpósio Internacional de Imunobiológicos';
                                                    $this->response->NomeStatus = "<b>Não</b> foi confirmada.";
                                                    $this->response->TextoStatus = "Sua inscrição no III Simpósio Internacional de Imunobiológicos não pode ser confirmada por indisponibilidade de vagas ou não atendimento aos pré-requisitos de participação.";
                                                } else {
                                                    $this->response->Assunto = "Inscrição: ".$this->response->IdFormulario.' - Confirmação PARCIAL de inscrição no III Simpósio Internacional de Imunobiológicos';
                                                    $this->response->NomeStatus = "Parcialmente confirmada.";
                                                    $this->response->TextoStatus = "Sua inscrição no III Simpósio Internacional de Imunobiológicos foi confirmada para alguns módulos solicitados e recusada para outros, de acordo com a disponibilidade de vagas.";
                                                }
                                                
                                                $Tabela = "<table style='border: 0.5px solid #000000; font-family: arial; font-size: 8pt; vertical-align: top; ' cellspacing='0' cellpadding='5'>"
                                                        ."<tr style='background-color: #ccc; '>"
                                                        //."    <td width='30' style='border: 0.5px solid #000000;'><b>#</b></td>"
                                                        ."    <td width='200' style='border: 0.5px solid #000000;'><b>Evento</b></td>"
                                                        ."    <td width='50' style='border: 0.5px solid #000000;'><b>Status</b></td>"
                                                        ."    <td width='300' style='border: 0.5px solid #000000;'><b>Observações</b></td>"
                                                        ."</tr>";
                                                        
                                                $listagem = $DAO->listar(null, null, '1', 'asc', null, null, $this->response->IdParticipante);
                                                if ($listagem) {
                                                    $i=0;
                                                    foreach ($listagem as $item){
                                                        $cor = ($i%2==0? '#eee': '#fff');
                                                        $corStatus = '#000000';
                                                        if ($item->getIdStatus()==1){ $corStatus = '#000000';} 
                                                        else if ($item->getIdStatus()==2){ $corStatus = '#69aa46';} 
                                                        else if ($item->getIdStatus()==3){ $corStatus = '#dd5a43';} 
                                                        $Tabela .= "<tr style='background-color: $cor;'>"
                                                                //."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getId()."</td>"
                                                                ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getNomeEvento()."</td>"
                                                                ."    <td  style='border: 0.5px solid #000000; text-align:left;'><span style='color: $corStatus;'>".$item->getNomeStatus()."</span></td>"
                                                                ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getObservacao()."</td>"
                                                                ."</tr>";
                                                        $i++;
                                                    }
                                                }
                                                $Tabela .= '</table>';
                                                
                                                $Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
                                                $Conteudo = str_replace("{MENSAGEM}", $this->response->TextoStatus, $Conteudo);
                                                $Conteudo = str_replace("{TABELA}", $Tabela, $Conteudo);
                                                $Conteudo = str_replace("{NUMERO}", $this->response->IdFormulario, $Conteudo);
                                                $Conteudo = str_replace("{CRACHA}", $this->response->Apelido, $Conteudo);
                                                $Conteudo = str_replace("{STATUS}", $this->response->NomeStatus, $Conteudo);
                                                if (Email::enviar($this->response->Nome, $this->response->Email, 'sact@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
                                                    $this->response->mensagem .= "<br/>Uma mensagem foi enviado com sucesso para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
                                                } else {
                                                    $this->response->mensagem .= "<br/>Erro ao enviar comunicado para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
                                                    $this->response->mensagem .= "[".Email::getErro()." - ".Email::getMensagem()."]";
                                                }
                                            } else {
                                                $this->response->mensagem .= "<br/>Erro: Não existe template de email para esta operação.";
                                            }
                                        }
                                        
                                    } else {
                                        $this->response->mensagem .= '<br/>'.$daoInscricao->getMensagem();
                                    }
                                } else {
                                    $this->response->mensagem .= '<br/>Erro ao localizar a Inscrição principal. (IdParticipante:'.$this->response->IdParticipante.')';
                                }
                            } else {
                                $this->response->mensagem = $DAO->getMensagem();
                            }
                        } else {
                            $this->response->mensagem = "Não é possível realizar esta operação para registros com status: '".$this->response->IdStatus."'.";
                        }
                    } else {
                        $this->response->mensagem = "O Evento já está com a capacidade esgotada. <br/>{Capacidade: <b>".$this->response->Capacidade."</b>, Inscritos: <b>".$this->response->Aprovados."</b>}";
                    }
                } else {
                    $this->response->mensagem = "Erro ao localizar o evento de Id: '$IdEvento'.";
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
     * Método para aprovar todos os registros
     *
     * @param int $IdParticipante O identificador do Participante
     * @param string $Observacao Observações da transação
     * 
     * @return bool Se atualização relizada com sucesso
     */    
    public function aprovarTodos($IdParticipante=null, $Observacao=null){
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            $DAO = new EventoParticipanteDAO();
            
            // Coletar parametros
            if(!$IdParticipante){$IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);}
            if(!$Observacao){    $Observacao = self::getVar('Observacao');}

            $this->response->IdParticipante = $IdParticipante;
            
            // Criticar campos
            if(!$IdParticipante){
                $this->response->mensagem = "O identificador do participante é um parametro obrigatório.";
                return false;
            }
            /* if(!$Observacao) {
                $this->response->mensagem = "O campo <b>Observação</b> é de preenchimento obrigatório.";
                return false;
            } // */
            
            $listagem = $DAO->listar(null, null, '1', 'asc', null, 1, $IdParticipante); 
            if ($listagem) {
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem);
                $i = 0;
                $resumo = '';
                foreach ($listagem as $item){
                    $Id = $item->getId();
                    $IdEvento = $item->getIdEvento();
                    if ($this->aprovar($Id, $IdEvento, $IdParticipante, $Observacao)){
                        $resumo .= $this->response->mensagem.'<br/>';
                    } else {
                        $this->response->mensagem = "Erro ao aprovar a solicitação do <em>".$item->getNomeParticipante()."</em> para o evento <em>".$item->getNomeEvento()."</em>. (Id:'$Id').";
                    }
                }
                $this->response->sucesso = 1;
                $this->response->mensagem = $resumo;
            } else {
                $this->response->mensagem = "Erro ao localizar as solicitações do Participante: '$IdParticipante'.";
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();

        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

/**
     * Método para reprovar todos os registros
     *
     * @param int $IdParticipante O identificador do Participante
     * @param string $Observacao Observações da transação
     * 
     * @return bool Se atualização relizada com sucesso
     */    
    public function reprovarTodos($IdParticipante=null, $Observacao=null){
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            $DAO = new EventoParticipanteDAO();
            
            // Coletar parametros
            if(!$IdParticipante){$IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);}
            if(!$Observacao){    $Observacao = self::getVar('Observacao');}

            $this->response->IdParticipante = $IdParticipante;
            
            // Criticar campos
            if(!$IdParticipante){
                $this->response->mensagem = "O identificador do participante é um parametro obrigatório.";
                return false;
            }
            /* if(!$Observacao) {
                $this->response->mensagem = "O campo <b>Observação</b> é de preenchimento obrigatório.";
                return false;
            } // */
            
            $listagem = $DAO->listar(null, null, '1', 'asc', null, 1, $IdParticipante); 
            if ($listagem) {
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem);
                $i = 0;
                $resumo = '';
                foreach ($listagem as $item){
                    $Id = $item->getId();
                    $IdEvento = $item->getIdEvento();
                    if ($this->reprovar($Id, $IdEvento, $IdParticipante, $Observacao)){
                        $resumo .= $this->response->mensagem.'<br/>';
                    } else {
                        $this->response->mensagem = "Erro ao reprovar a solicitação do <em>".$item->getNomeParticipante()."</em> para o evento <em>".$item->getNomeEvento()."</em>. (Id:'$Id').";
                    }
                }
                $this->response->sucesso = 1;
                $this->response->mensagem = $resumo;
            } else {
                $this->response->mensagem = "Erro ao localizar as solicitações do Participante: '$IdParticipante'.";
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
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
        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
		
        $sord = self::getVar('sord');
        //$sEcho = self::getVar('sEcho');
        
        try {
            /** Ordering */
            $aColumns = array(0=>'img', 1=>'1', 3=>'2', 4=>'3', 5=>'4', 6=>'5' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = 'ep.id_evento';
                $sord = 'asc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            $IdEvento = self::getVar('IdEvento');
            $IdStatus = self::getVar('IdStatus');
            $IdParticipante = self::getVar('IdParticipante');
            $Nome = self::getVar('Nome');
			
            $daoEventoPresencao = new EventoPresencaDAO();
            
            $DAO = new EventoParticipanteDAO();
            $listagem = $DAO->listar($page, $rows, $sidx, $sord, $IdEvento, $IdStatus, $IdParticipante, $Nome);
			
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);
                
                $CertificadoAgrupado=0;
                
                $i = 0;
                foreach ($listagem as $item){
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizarTransacao('.$item->getId().');"><span class="glyphicon glyphicon-search"></span>';
                    if($item->getIdStatus()==2){ // Aprovado
                        $NomeStatus = '<span class="label label-success">'.$item->getNomeStatus().'</span>';
                    } else if($item->getIdStatus()==3){ // Reprovados
                        $NomeStatus = '<span class="label label-danger">'.$item->getNomeStatus().'</span>';
                    } else if($item->getIdStatus()==4){ // Cancelado
                        $NomeStatus = '<span class="label label-danger">'.$item->getNomeStatus().'</span>';
                    } else if($item->getIdStatus()==5){ // Confirmado
                        $NomeStatus = '<span class="label label-success">'.$item->getNomeStatus().'</span>';
                    } else if($item->getIdStatus()==6){ // Presente
                        $NomeStatus = '<span class="label label-success">'.$item->getNomeStatus().'</span>';
                    } else {
                        $NomeStatus = '<span class="label label-default">'.$item->getNomeStatus().'</span>';
                    }
                    // Saldo do Evento
                    if ($item->getSaldo() > 0){
                        if ($item->getSaldo() > ($item->getCapacidade()* 0.1)){
                            $strSaldo = "<b><span class='green'>".$item->getSaldo()."</span></b>";
                        } else {
                            $strSaldo = "<b><span class='orange'>".$item->getSaldo()."</span></b>";
                        }
                    } else {
                        $strSaldo = "<b><span class='red'>".$item->getSaldo()."</span></b>";
                    }
                    
                    $strCertificado = '';
                    $objPresenca = $daoEventoPresencao->retornarPorEventoParticipante($item->getIdEvento(), $item->getIdParticipante());
                    if ($objPresenca){
                        $strCertificado = 'Presente'; //$objPresenca->getCredencial();
                        if (($item->getIdEvento()==2) || ($item->getIdEvento()==3) || ($item->getIdEvento()==4) || ($item->getIdEvento()==5)) { // Cerificados agrupados;
                            if ($CertificadoAgrupado==0){ // Somente exibir botão de impressão para o primeiro evento encontrato;
                                $strCertificado = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificado(\''.$objPresenca->getChave().'\');" title="Visualizar Certificado"><span class="glyphicon glyphicon-file red"></span> Certificado</button>';
                            }
                            $CertificadoAgrupado++; 
                        } else {
                            $strCertificado = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificado(\''.$objPresenca->getChave().'\');" title="Visualizar Certificado"><span class="glyphicon glyphicon-file red"></span> Certificado</button>';
                        }
                    } 
                    
					$chkPresenca = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="opcaoPresenca" name="opcaoPresenca" onclick=marcarPresenca()>';
					
                    $this->response->aaData[$i] = array($bt_view, $item->getId(), $item->getIdEvento(), $item->getNomeEvento(), $strSaldo, $item->getIdParticipante(), $item->getNomeParticipante(), $item->getIdStatus(), $NomeStatus, $item->getObservacao(), $strCertificado, $item->getIdTipoEvento(), $chkPresenca);
                    $i++;
                }

                $this->response->sucesso = 1;
                $this->response->iTotalRecords = $this->response->records;
                $this->response->iTotalDisplayRecords = $this->response->records;
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
     *  Método para listar registro para um ComboBox
     *
     * @return array Retornar o array rows[] = {{value:'', text:''},...}
     */    
    public function listarCombo() {
        try {
            $Id = self::getVar('Id');
            $Nome = self::getVar('Nome');
        
            $DAO = new EventoParticipanteDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $Id, $Nome);
            if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = intval($item->getId()); 
                    $this->response->rows[$i]['text'] = $item->getNome();
                    $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                    $i++;
                }
                $this->response->sucesso=1;
            }else{
                $this->response->records=0;
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    } 


    /**
     *  Método para listar todos registros
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function relatorio() {
        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
        $sord = self::getVar('sord');
        //$sEcho = self::getVar('sEcho');
        
        try {
            $DAO = new InscricaoDAO();

            /** Ordering */
            $aColumns = array(0=>'img', 1=>'ep.id', 2=>'ep.id_evento', 3=>'e.nome', 4=>'ep.id_participante', 5=>'p.nome' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else if (is_numeric($sidx)) {
                $sidx = $aColumns[$sidx];
            } else {
                $sidx = 'e.name';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            // Paramentros
            $IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            $NomeEmpresa='';
            $IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);
            $NomeEvento='';
            $IdStatus = self::getVar('IdStatus', FILTER_SANITIZE_NUMBER_INT);
            $NomeStatus = ($IdStatus)? $this->_NomeStatus[$IdStatus]: '';
            $Nome = self::getVar('Nome');
            $DataInicial='';
            $DataFinal='';
            
            $daoEvento = new EventoDAO();
            $objEvento = $daoEvento->retornar($IdEvento);
            if ($objEvento){
                $NomeEvento = $objEvento->getNome();
                $DataInicial = $objEvento->getDataInicial();
                $DataFinal = $objEvento->getDataFinal();
            }
            
            
            $this->response->cabecalho='';
            $this->response->html='';
            
            // Cabeçalho 
                $this->_Pagina = 'A4';
                $this->response->cabecalho = (file_exists('views/cabecalho.'.$this->_Formato.'.html'))? file_get_contents('views/cabecalho.'.$this->_Formato.'.html'): '';
                $this->response->cabecalho = str_replace("{SISNOME}", $this->Config->Nome, $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{SISVERSAO}", $this->Config->Versao, $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{TITULO}", "Relatório de Participantes", $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{TIMESTAMP}", date("j-m-Y H:m"), $this->response->cabecalho);
                // Filtros
                $strFiltro = '';
                $strFiltro .= ($NomeEvento)? "Evento: <em>$NomeEvento</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($NomeStatus)? "Status: <em>$NomeStatus</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($Nome)? "Nome: <em>$Nome</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= (!$strFiltro)? "-x-": ""; 
                $this->response->cabecalho = str_replace("{FILTRO}", $strFiltro, $this->response->cabecalho);
            
            // Formato
            if (($this->_Formato=='excel') || ($this->_Formato=='pdf')){
                // Cabeçalho da Tabela
                $this->response->html.= "<table style='border: 0.5px solid #000000; font-family: arial; font-size: 8pt; vertical-align: top; ' cellspacing='0' cellpadding='5'>"
                                            ."<tr style='background-color: #ccc; '>"
                                            ."    <td width='30' style='border: 0.5px solid #000000;'><b>#</b></td>"
                                            ."    <td width='200' style='border: 0.5px solid #000000;'><b>Nome Completo</b></td>"
                                            ."    <td width='100' style='border: 0.5px solid #000000;'><b>Nome do Crachá</b></td>"
                                            ."    <td width='60' style='border: 0.5px solid #000000;'><b>Email</b></td>"
                                            ."    <td width='60' style='border: 0.5px solid #000000;'><b>Telefone</b></td>"
                                            ."    <td width='60' style='border: 0.5px solid #000000;'><b>Empresa</b></td>"
                                            ."    <td width='60' style='border: 0.5px solid #000000;'><b>Departamento</b></td>"
                                            ."    <td width='50' style='border: 0.5px solid #000000;'><b>Data da Inscrição</b></td>"
                                            ."</tr>";
            }
                        
            
            
            $listagem = $DAO->listar(null, null, '1', 'asc', $IdEmpresa, $IdEvento, null,  $IdStatus, $Nome);
            if ($listagem) {
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem);
                
                $i = 0;
                foreach ($listagem as $item){
                    $cor = ($i%2==0? '#eee': '#fff');
                    
                    $Ativo = ($item->getAtivo())? 'sim': 'não';
                    $DataCadastro = ($item->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($item->getDataCadastro(), false) : '';
                    
                    //$Campos = $item->getCampos();
                    //$Empresa = ($Campos->colaborador=="sim") ? 'Bio-Manguinhos': $Campos->empresa;
					$Empresa = ($item->getColaborador()=="S") ? 'Bio-Manguinhos': $item->getEmpresa();				
                    $Departamento = '';
					$Departamento = ($item->getColaborador()=="S") ? $item->getViceDiretoria(): $item->getCargo();
					
                    /*if($Campos->colaborador=="sim") {
                        $Departamento = $Campos->vicediretoria;
                        if ($Campos->vicediretoria=='DIBIO'){
                            $Departamento .= (($Campos->dibio!='') && ($Campos->dibio!='0'))? ' \ '.$Campos->dibio : '';
                        } else if ($Campos->vicediretoria=='VQUAL'){
                            $Departamento .= (($Campos->vqual!='') && ($Campos->vqual!='0'))? ' \ '.$Campos->vqual : '';
                        } else if ($Campos->vicediretoria=='VDTEC'){
                            $Departamento .= (($Campos->vdtec!='') && ($Campos->vdtec!='0'))? ' \ '.$Campos->vdtec : '';
                        } else if ($Campos->vicediretoria=='VPROD'){
                            $Departamento .= (($Campos->vprod!='') && ($Campos->vprod!='0'))? ' \ '.$Campos->vprod : '';
                        } else if ($Campos->vicediretoria=='VGEST'){
                            $Departamento .= (($Campos->vgest!='') && ($Campos->vgest!='0'))? ' \ '.$Campos->vgest : '';
                        } else {
                            
                        }
                    } else {
                        $Departamento = $Campos->cargo;
                    }*/
                    
                    $this->response->html.= "<tr style='background-color: $cor;'>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getId()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getNome()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getNomeCracha()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getEmail()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getTelefone()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$Empresa."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$Departamento."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$DataCadastro."</td>"
                                            ."</tr>";
                    $i++;
                }
                $this->response->html.= "<tr style='background-color: #ccc;'>"
                                        ."    <td  style='border: 0.5px solid #000000; text-align:right;' colspan='2'> <b>Total de registros</b></td>"
                                        ."    <td  style='border: 0.5px solid #000000; text-align:right;'><b>".$i."</b></td>"
                                        ."</tr>";
                $this->response->sucesso = 1;
            }else{
                $this->response->records = 0;
                if ($DAO->getErro()){
                    $this->response->erro = $DAO->getErro();
                    $this->response->mensagem = $DAO->getMensagem();
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->html.= "<tr><td colspan='5'>".$DAO->_query."</td></tr>"; }
            }
            $this->response->html.= "</table>";
            
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
        
}