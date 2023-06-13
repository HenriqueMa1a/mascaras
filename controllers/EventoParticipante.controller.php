<?php
require_once ("assets/Email.class.php");
if(!class_exists('EventoDAO')){ require_once 'models/EventoDAO.class.php';}
if(!class_exists('EventoParticipanteDAO')){ require_once 'models/EventoParticipanteDAO.class.php';}
if(!class_exists('EventoPresencaDAO')){ require_once 'models/EventoPresencaDAO.class.php';}
if(!class_exists('InscricaoDAO')){ require_once 'models/InscricaoDAO.class.php';}
if(!class_exists('ResumoDAO')){ require_once 'modelo/ResumoDAO.class.php';}
if(!class_exists('LogAcaoDAO')){ require_once 'models/LogAcaoDAO.class.php';}
if(!class_exists('LogAcao')){ require_once 'models/LogAcao.class.php';}
if(!class_exists('PessoaDAO')){ require_once 'models/PessoaDAO.class.php';}
/**
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
class EventoParticipanteController extends Controller{
    
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
            //if (!parent::isLogged()){
            //    self::logOff();
            //    self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            //}
            //$this->response->IdUsuario = $this->Usuario->Id;
            
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
			$IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);
			$IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);
			
			$DAO = new EventoParticipanteDAO();
			if (($Id)||($IdEvento)||($IdParticipante)){
				if ($Id){
					$obj = $DAO->retornar($Id);
				} else {
					$obj = $DAO->retornarPorEventoParticipante($IdEvento, $IdParticipante);
				}

                if ($obj){
                    $this->response->Id = $obj->getId();
                    $this->response->IdEvento = $obj->getIdEvento();
                    $this->response->NomeEvento = $obj->getNomeEvento();
                    $this->response->IdParticipante = $obj->getIdParticipante();
                    $this->response->NomeParticipante = $obj->getNomeParticipante();
                    $this->response->Observacao = $obj->getObservacao();
                    $this->response->IdStatus = $obj->getIdStatus();
                    $this->response->NomeStatus = $obj->getNomeStatus();
                    $this->response->DataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '';
                    $this->response->DataAprovacao = ($obj->getDataAprovacao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAprovacao(), false) : '';
                    $this->response->NomeUsuarioAprovacao = $obj->getNomeUsuarioAprovacao();
                    
                    $this->response->Revisao = $obj->getRevisao();
                    $this->response->Acao = $obj->getAcao();
                    $this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
                    $this->response->NomeUsuarioAcao = $obj->getNomeUsuarioAcao();
                    $this->response->DataAcao = ($obj->getDataAcao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAcao(), false) : '';

                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro com id: '$Id' foi localizado com sucesso.";
                } else {
                    $this->response->mensagem = "Participante não registrado para o evento atual !";//"Erro ao localizar o registro com id: '$Id'.";
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
     * @return object Objeto do tipo EventoParticipante
     */    
    public function retornarParaPresenca() {
        
        try{
            
			$IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);
			$IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);
			
			$DAO = new EventoParticipanteDAO();
			if (($IdEvento)||($IdParticipante)){
				$obj = $DAO->listarPorEventoPrincipalParticipante($IdEvento, $IdParticipante);

				if ($obj){			
					$DAOParticipante = new InscricaoDAO();
					$objParticipante = $DAOParticipante->retornar($IdParticipante);
					$this->response->NomeParticipante = $objParticipante->getNomeCompleto();
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
/*    public function incluir() {
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
            
            $DAO = new EventoParticipanteDAO();

            $obj = new EventoParticipante();
            $obj->setId($Id);
            $obj->setSigla($Sigla);
            $obj->setNome($Nome);
            $obj->setAtivo($Ativo);
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
*/	
	
    /**
     *  Método para criar um novo registro
     *
     * @return int O Identificador do registro criado
     */    
    public function incluir() {
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
			$IdTipoParticipante = self::getVar('IdTipoParticipante', FILTER_SANITIZE_NUMBER_INT);
			$IdStatus = self::getVar('IdStatus', FILTER_SANITIZE_NUMBER_INT);

			//Evento Principal Ativo
			$DAOEvento = new EventoDAO();
			$objEvento = $DAOEvento->retornarEventoPrincipalAtivo();
			$IdEventoPrincipal = $objEvento->getIdEvento();	
			$DAOEvento->Close();	
            
            $DAO = new EventoParticipanteDAO();

            $obj = new EventoParticipante();
            $obj->setIdParticipante($Id);
            $obj->setIdEvento($IdEventoPrincipal);
            $obj->setIdTipoParticipante($IdTipoParticipante);
            $obj->setIdStatus($IdStatus);
            if ($DAO->salvar($obj)){
                $Id = $obj->getId();
                $this->response->Id=$Id;
                $this->response->sucesso = 1;
                
				//colocando no cad_pessoa o status 1 (pendente)
				$DAOInscricao = new InscricaoDAO();
				if($DAOInscricao->atualizarCampo($obj->getIdParticipante(), 'id_status', 1)) { 
					$this->response->mensagem = "Registro cadastrado com sucesso.";
				} 
				$DAOInscricao->Close();
				
				$this::enviarEmailIncluir($Id);
            } else {
                $this->response->mensagem = $DAO->getMensagem();
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }	
	
    /**
     *  Método para enviar notificação de pré inscrição (inclusão)
     *
     * KELLEN NERY
     */    
    public function enviarEmailIncluir($p_Id) {	
		
		$Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);	
		$DAOEmail = new PessoaDAO();
		$obj = $DAOEmail->retornar($Id);
		
		if ($obj){		
			$Id    		= $obj->getId();
			$Nome  		= $obj->getNomeCompleto();
			$Cpf   		= $obj->getCpf();
			$Passaporte = $obj->getPassaporte();			
			$Documento 	= ($Cpf) ? $Cpf : $Passaporte;
			$Email 		= $obj->getEmail();
			$Data  		= date("Y-m-d H:i:s");   //$obj->getDataAcao();
		
			$Conteudo = "";
			$Conteudo .= "Prezado(a) <em>$Nome</em><br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "Sua solicitação de inscrição foi <u>cadastrada</u> em nossa base de dados em $Data <br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "Nº: $Id<br/>";
			$Conteudo .= "Nome: $Nome<br/>";
			$Conteudo .= "E-mail: $Email<br/>";
			$Conteudo .= "Login (CPF/Passaporte): $Documento<br/>";
			$Conteudo .= "Status da Inscrição: <b>Pendente</b><br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "A confirmação de inscrição será enviada posteriormente, via e-mail, considerando a disponibilidade de vagas e os critérios de participação no evento.<br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "Atenciosamente,<br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "<font face='Arial' color='DarkBlue' size=2><b>Comissão Científica e Tecnológica</b></font><br/>";
			$Conteudo .= "<font face='Arial' color='Gray' size=2>V International Symposium on Immunobiologicals</font><br/>";
			$Conteudo .= "<font face='Arial' color='Gray' size=2>Bio-Manguinhos | FIOCRUZ</font><br/>";
			$Conteudo .= "http://isi.bio.fiocruz.br<br/>";
			$Conteudo .= "";	
	
			if (Email::enviar($Nome, $Email, 'isi@bio.fiocruz.br', 'Cadastro no V International Symposium on Immunobiologicals de Bio-Manguinhos – aguardando confirmação('.$Id.')',$Conteudo)){
				$response->erro = 242;
				$response->mensagem = utf8_encode ( "Notificação enviada com sucesso!" );
				return true;
			} else {
				$response->erro = 243;
				$response->mensagem = utf8_encode ( "Tivemos problema no envio de seu email." );
				return false;
			}
			
		}
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
            $this->response->Id=$Id;
            if ($Id){
                $DAO = new EventoParticipanteDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $obj->setSigla($Sigla);
                    $obj->setNome($Nome);
                    $obj->setAtivo($Ativo);
                    if ($DAO->atualizar($obj)){
                        $this->response->sucesso = 1;
                        $this->response->mensagem = "Registro '$Nome' atualizado com sucesso.";
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
     * Excluir a partir do ID da tabela CAD_EVENTO_PARTICIPANTE
     */    
    public function excluirFisico(){
        try {
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
			//$IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);

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
     * Método para excluir um registro fisicamente do banco pelo idParticipante e idEvento, da tabela CAD_EVENTO_PARTICIPANTE
	 * A exclusão será registrada em uma tabela de Log
	 * Data: Novembro/2018
     */    
    public function excluirParticipanteEvento(){ 
        try {
            $IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);
			$IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT);

			if (!$IdEvento){ 
				$DAOEvento = new EventoDAO();
				$objEvento = $DAOEvento->retornarEventoPrincipalAtivo();
				if($objEvento) {
					$IdEvento = $objEvento->getIdEvento();
				}
				$DAOEvento->Close();
			}
			
            if (($IdParticipante) && ($IdEvento)){   
				
				$DAOResumo = new ResumoDAO ();
				$temResumoAprovado = false;
				$arrayResumos = array();
				
				$listagemResumo = $DAOResumo->lista ( null, null, null, null, $IdEvento, $IdParticipante, null, null, null, null );			
				
				if ($listagemResumo){
					foreach ($listagemResumo as $itemResumo) {
						if (($itemResumo->getIdStatus()==4) || ($itemResumo->getIdStatus()==5) || ($itemResumo->getIdStatus()==6)){
							$temResumoAprovado = true;
						}else{
							$arrayResumos[] = $itemResumo->getId();
						}
					}	
				}else {
					
				}

				if (!$temResumoAprovado){ 
					
					$DAOLog = new LogAcaoDAO();	
					$DAO = new EventoParticipanteDAO();
					$listagemEventosParticipantes = $DAO->listar(null, null, '1', null, $IdEvento, null, $IdParticipante, null);
					
					if ($listagemEventosParticipantes) {
						$this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagemEventosParticipantes);
						$msg = 'Cancelada a inscrição no V International Symposium on Immunobiologicals em ';
						foreach ($listagemEventosParticipantes as $item){
							$Id = $item->getId(); //ID do registro CAD_EVENTO_PARTICIPANTE, ou seja, da Inscrição no Evento
							
							/* Criando um objeto para salvar o Log da Exclusão */
							$objLogAcao = new LogAcao();
							$objLogAcao->setIdModulo("41");
							$objLogAcao->setChave("cadastro-inscricao");
							$objLogAcao->setClasse("cadastro-inscricao");
							$objLogAcao->setIdFuncionalidade("33");  
							$objLogAcao->setAcao("Excluir");  
							$objLogAcao->setParametros("{id_evento_participante: ".$item->getId()."; id_participante: ".$item->getIdParticipante()."; id_evento: ".$item->getIdEvento()."}");
							$objLogAcao->setIdentificador(0);
							$objLogAcao->setIP("");
							
							if ($DAOLog->salvar($objLogAcao)){
								$this->response->sucesso = 1;
							} else {
								$this->response->mensagem = $DAO->getMensagem();
							}									
							/***************************************************/
							
							/*Exclusão de cada dia de solicitação de inscrição*/
							if ($DAO->excluirFisico($Id)){
								$msg .= $item->getNomeEvento().', ';
							} else {
								$this->response->mensagem = "Erro cancelar a solicitação de inscrição do <em>".$item->getNomeParticipante()."</em> para o dia <em>".$item->getNomeEvento()."</em>. (Id:'$Id').";
							}
							/***************************************************/

							/*Atualiza status do participante*/ 
							$DAOInscricao = new InscricaoDAO();
							if ($DAOInscricao->atualizarCampo($item->getIdParticipante(), 'id_status', '1')){
								//$msg .= $this->response->mensagem.'<br/>';
							} else {
								$this->response->mensagem = "Erro ao atualizar a inscrição do <em>".$item->getNomeParticipante()."</em> para pendente.";
							}						
							/***************************************************/						
							
						}
						$this->response->sucesso = 1;
						$this->response->mensagem = substr_replace($msg, '.', -2);
					} else {
						$this->response->mensagem = "Erro ao localizar as solicitações do Participante: '$IdParticipante'.";
					}	

					/*Exclusão dos resumos do participante*/
					foreach ($arrayResumos as $idResumo){					
						if ($DAOResumo->remove($idResumo)){
							//$this->response->mensagem = '';
						} else {
							$this->response->mensagem = "Erro ao excluir resumo.";
						}						
					}
					/***************************************************/
					
					if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
					$DAO->Close();
					$DAOLog->Close();
					$DAOInscricao->Close();	
					$DAOResumo->Close();
					
				}else{  
					$this->response->mensagem = "Você possui Resumo submetido que já foi <b>aprovado</b> pela Comissão Científica e Tecnológica, sua inscrição não pode ser cancelada.";	
				}	

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
							$IdEvento = $obj->getIdEvento();
							$objEvento = $daoEvento->retornar($IdEvento);								
							
							$objInscricao = $daoInscricao->retornarPorUsuario($this->response->IdParticipante, $objEvento->getIdParente());
							
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
									$this->response->IdStatus = 8;  // Inscrição Em análise
								}
								if ($daoInscricao->atualizarCampo($this->response->IdFormulario, 'id_status', $this->response->IdStatus)){
									$this->response->mensagem .= '<br/>Status principal atualizado com sucesso. ('.$this->response->IdStatus.')';
									
									if ($this->response->IdStatus ==10){ // 10: Concluído
										// Enviar Email;
										$Conteudo = (file_exists('templates/inscricao.comunicar.email.html'))? file_get_contents('templates/inscricao.comunicar.email.html'): '';
										if ($Conteudo!=''){
											if ($this->response->pAprovados > 0){ //Pelo menos 1 inscrição Confirmada

												$this->response->Assunto = "Inscrição aceita no V International Symposium on Immunobiologicals de Bio-Manguinhos (".$this->response->IdFormulario.")";
												$this->response->TextoMsg = "Sua inscrição no V International Symposium on Immunobiologicals de Bio-Manguinhos foi confirmada. <br/>";
												$this->response->TextoMsg .= "O evento será realizado no Centro Cultural da Fundação Getúlio Vargas, na Praia de Botafogo.<br/>";
												$this->response->TextoInscricao = "Inscrição: <b>".$this->response->IdFormulario . "</b>";
												$this->response->TextoCracha = "Nome no Crachá: <b>".$this->response->Apelido . "</b>";
												$this->response->TextoLocal = "<b>Endereço:</b> Praia de Botafogo, 190 - Botafogo, Rio de Janeiro - RJ. <br/>";
												$this->response->TextoLocal .= "<b>Data:</b> 11 a 13 de maio de 2020 - das 9h as 17h. <br/>";
												//$this->response->TextoDecisao = "De acordo com as suas solicitações e com a disponibilidade de vagas, sua inscrição foi confirmada para os seguintes dias do evento:";
												$this->response->TextoTrabalho = "Submissão de trabalhos para exposição de pôsteres científicos pelo site http://isi.bio.fiocruz.br. Participe, apresente seu trabalho e concorra a prêmios.";
												
												//Montar a tabela com os dias do evento que o participante irá participar
												/*
												$Tabela = "<table style='border: 0.5px solid #000000; font-family: arial; font-size: 8pt; vertical-align: top; ' cellspacing='0' cellpadding='5'>"
														."<tr style='background-color: #ccc; '>"
														//."    <td width='30' style='border: 0.5px solid #000000;'><b>#</b></td>"
														."    <td width='200' style='border: 0.5px solid #000000;'><b>Dias Solicitados</b></td>"
														."    <td width='50' style='border: 0.5px solid #000000;'><b>Status</b></td>"
														."    <td width='300' style='border: 0.5px solid #000000;'><b>Observações</b></td>"
														."</tr>";     
												$listagem = $DAO->listar(null, null, '1', 'asc', $objEvento->getIdParente(), null, $this->response->IdParticipante);
												if ($listagem) {
													$i=0;
													$Dia7=''; $Dia8=''; $Dia9='';
													foreach ($listagem as $item){
														$cor = ($i%2==0? '#eee': '#fff');
														$corStatus = '#000000';
														if ($item->getIdStatus()==1){
															$corStatus = '#000000';
														}else {
															if ($item->getIdStatus()==2){
																$corStatus = '#69aa46'; 
																$Dia = date( 'd', strtotime( $item->getDataInicial() ) );
																if($Dia == 7) {$Dia7 = 7;} else{if($Dia == 8) {$Dia8 = 8;} else	{$Dia9 = 9;}}	
															}else {
																if ($item->getIdStatus()==3){ 
																	$corStatus = '#dd5a43';
																}
															}
														} 
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
												/*--*/

												//Verificar o tipo do email e os dias que serão gravados na Agenda
												$email = $objInscricao->getEmail();
												$dominio   = '@gmail';
												$pos = strpos( $email, $dominio );
												if ($pos === false){ //outlook
													$tipoAgenda = "<a href='https://isi.bio.fiocruz.br/agenda_2020.ics' title='Clique aqui para agendar o evento'><img src='https://isi.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
												/*
													if( ($Dia7) && ($Dia8) && ($Dia9)) //inscrito todos os dias
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento789Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( ($Dia7) && (!$Dia8) && (!$Dia9)) //inscrito apenas no primeiro dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento7Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( (!$Dia7) && ($Dia8) && (!$Dia9)) //inscrito apenas no segundo dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento8Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( (!$Dia7) && (!$Dia8) && ($Dia9)) //inscrito apenas no terceiro dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento9Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( ($Dia7) && ($Dia8) && (!$Dia9)) //inscrito no primeiro e no segundo dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento78Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( ($Dia7) && (!$Dia8) && ($Dia9)) //inscrito no primeiro e no terceiro dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento79Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( (!$Dia7) && ($Dia8) && ($Dia9)) //inscrito no segundo e no terceiro dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento89Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";																
												*/		
												}else{  //gmail
													//$tipoAgenda = "<a href='https://www.google.com/calendar/event?action=TEMPLATE&pprop=eidmsgid%3A75u2tpoqbvs320grbiqboik3en_161b5b01c62188ae&dates=20180508T140000%2F20180510T170000&text=VI%20SACT&location=Avenida%20Gra%C3%A7a%20Aranha%2C%20Av.%20Gra%C3%A7a%20Aranha%2C%201%20-%20Centro%2C%20Rio%20de%20Janeiro%20-%20RJ%2C%20Brasil&details&add=";
													//$tipoAgenda .= substr($email, 0, $pos);
													//$tipoAgenda .= "%40gmail.com&ctok=d3VuZXJsdWl6QGdtYWlsLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													$tipoAgenda = "<a href='https://calendar.google.com/calendar/embed?src=bpn6d249q7tuvkc5vcuvq1j4bc%40group.calendar.google.com&ctz=America%2FSao_Paulo' title='Clique aqui para agendar o evento'><img src='https://isi.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
												/*
													if( ($Dia7) && ($Dia8) && ($Dia9)) //inscrito todos os dias
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=YnBuNmQyNDlxN3R1dmtjNXZjdXZxMWo0YmNAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( ($Dia7) && (!$Dia8) && (!$Dia9)) //inscrito apenas no primeiro dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=bm11bW1hazBna2FzMWN0cXVjZWJjcDYwODRAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( (!$Dia7) && ($Dia8) && (!$Dia9)) //inscrito apenas no segundo dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=Y242bjNvcDlub3Q5aGRrNXJrYW02ZGVwZm9AZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( (!$Dia7) && (!$Dia8) && ($Dia9)) //inscrito apenas no terceiro dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=ZXQ0NDEwczQzc3NwOG1vYW1tbW1vdGxyY3NAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( ($Dia7) && ($Dia8) && (!$Dia9)) //inscrito no primeiro e no segundo dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=dXRhZ2l0NWI2Yms1aW1ib3BqN2dkaXVnYzhAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( ($Dia7) && (!$Dia8) && ($Dia9)) //inscrito no primeiro e no terceiro dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=a2I2bXM1ODJlc3NzMDloOTFlczNldGx1ZWtAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( (!$Dia7) && ($Dia8) && ($Dia9)) //inscrito no segundo e no terceiro dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=cHJuMGRtMG5vZmhqYmN1aGttMzk4NmhvajBAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";													
												*/	
												}													
	
												
											} else {//Todas as inscrições Recusadas
												$this->response->Assunto = "Inscrição no V ISI recusada";
												//$this->response->NomeStatus = "<b>Não</b> foi confirmada.";
												$this->response->TextoMsg = "Sua inscrição no V International Symposium on Immunobiologicals de Bio-Manguinhos não pode ser confirmada por indisponibilidade de vagas ou não atendimento aos pré-requisitos de participação.";
												$this->response->TextoLocal = "";
												$this->response->TextoTrabalho = "";
												$this->response->TextoInscricao = "";
												$this->response->TextoCracha = "";
												$this->response->TextoDecisao = "";
												$Tabela = "";
												$tipoAgenda = "";
											} 
											
											$Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
											$Conteudo = str_replace("{MENSAGEM}", $this->response->TextoMsg, $Conteudo);
											$Conteudo = str_replace("{LOCAL}", $this->response->TextoLocal, $Conteudo);
											$Conteudo = str_replace("{DECISAO}", $this->response->TextoDecisao, $Conteudo);
											$Conteudo = str_replace("{TABELA}", $Tabela, $Conteudo);
											$Conteudo = str_replace("{NUMERO}", $this->response->TextoInscricao, $Conteudo);
											$Conteudo = str_replace("{CRACHA}", $this->response->TextoCracha, $Conteudo);
											$Conteudo = str_replace("{TRABALHO}", $this->response->TextoTrabalho, $Conteudo);
											$Conteudo = str_replace("{AGENDA}", $tipoAgenda, $Conteudo);											
											
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
     * Método para cancelar uma decisão (aprovação ou reprovação) um registro,retornando ao status Pendente-Aguardando Decisão
     * Kellen Nery
	 *
     * @param int $Id O identificador do EventoParticipante
     * @param int $IdEvento O identificador do Evento
     * @param int $IdParticipante O identificador do Participante
     * @param string $Observacao Observações da transação
     * 
     * @return bool Se atualização relizada com sucesso
     */    
    public function cancelar($Id=null, $IdEvento=null, $IdParticipante=null, $Observacao=null){
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
            
            if ($obj){ //objeto evento-participante
                $IdEvento = $obj->getIdEvento();
                
                // Alterando o Status do Evento
                $objEvento = $daoEvento->retornar($IdEvento);
                if ($objEvento){
                    $this->response->Capacidade = $objEvento->getCapacidade();
                    $this->response->Aprovados = $objEvento->getAprovados();
                    $this->response->IdParticipante = $obj->getIdParticipante();
                    $this->response->Nome = $obj->getNomeParticipante();
                    $this->response->IdStatus = $obj->getIdStatus();
					
					//Volta o status para Pré-inscrito, Aguardando Decisão
					$obj->setIdStatus(1);
					$obj->setObservacao($Observacao);
					$obj->setIdUsuarioAcao($this->Usuario->Id);
                    $obj->setDataAcao(date("Y-m-d H:i:s"));
					if ($DAO->atualizar($obj)){
						$this->response->sucesso = 1;
						$this->response->mensagem = "O registro <b>'".$this->response->Nome."'</b> foi retornado ao status <b>Aguardando Decisão</b> com sucesso.";					

						// Atualizar Inscrição Principal
                        $objInscricao = $daoInscricao->retornarPorUsuario($this->response->IdParticipante, $objEvento->getIdParente());
						if ($objInscricao){
							$this->response->IdFormulario = $objInscricao->getId();
							$this->response->Apelido = $objInscricao->getNomeCracha();
							$this->response->Email = $objInscricao->getEmail();
							$this->response->pSolicitacoes = $objInscricao->getSolicitacoes();
							$this->response->pAprovados = $objInscricao->getAprovados();
							$this->response->pReprovados = $objInscricao->getReprovados();
							
							//caso tenham mais de 1 evento
							if ($this->response->pSolicitacoes == ($this->response->pAprovados + $this->response->pReprovados)){
								$this->response->IdStatus = 10; // Inscrição Concluida
							} else {
								if ($this->response->pSolicitacoes < ($this->response->pAprovados + $this->response->pReprovados)) {
									$this->response->IdStatus = 8;  // Inscrição Em Análise
								} else {
									$this->response->IdStatus = 1;  // Inscrição Pendente
								}
							}
									
							if ($daoInscricao->atualizarCampo($this->response->IdFormulario, 'id_status', $this->response->IdStatus)){
								$this->response->mensagem .= '<br/>Status principal atualizado com sucesso. ('.$this->response->IdStatus.')';
                                $DiaEvento = $objEvento->getNome();        
								// Enviar Email;
								$Conteudo = (file_exists('templates/inscricao.comunicar.email.html'))? file_get_contents('templates/inscricao.comunicar.email.html'): '';
								if ($Conteudo!=''){
									$this->response->Assunto = "Revisão em Inscrição - V International Symposium on Immunobiologicals de Bio-Manguinhos (".$this->response->IdFormulario.")";
									$this->response->NomeStatus = "<b>Não</b> foi confirmada.";
									$this->response->TextoStatus = "A decisão dada para sua inscrição no V International Symposium on Immunobiologicals de Bio-Manguinhos foi temporariamente cancelada.<br/><br/>";
									$this->response->TextoStatus .= "Motivo: $Observacao<br/><br/>";
									$this->response->TextoLocal = "";
									$this->response->TextoTrabalho = "";
									$this->response->TextoInscricao = "";
									$this->response->TextoCracha = ""; 
									
									$Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
									$Conteudo = str_replace("{MENSAGEM}", $this->response->TextoStatus, $Conteudo);
									$Conteudo = str_replace("{NUMERO}", $this->response->TextoInscricao, $Conteudo);
									$Conteudo = str_replace("{CRACHA}", $this->response->TextoCracha, $Conteudo);
									$Conteudo = str_replace("{STATUS}", $this->response->NomeStatus, $Conteudo);
									$Conteudo = str_replace("{LOCAL}", $this->response->TextoLocal, $Conteudo);
									$Conteudo = str_replace("{TRABALHO}", $this->response->TextoTrabalho, $Conteudo);
									$Conteudo = str_replace("{AGENDA}", "", $Conteudo);
									$Conteudo = str_replace("{DECISAO}", "", $Conteudo);
                                    $Conteudo = str_replace("{TABELA}", "", $Conteudo);									
													
									if (Email::enviar($this->response->Nome, $this->response->Email, 'isi@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
										$this->response->mensagem .= "<br/>Uma mensagem foi enviado com sucesso para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
									} else {
										$this->response->mensagem .= "<br/>Erro ao enviar comunicado para <b>".$this->response->Nome."</b> <em>(".$this->response->Email.")</em>.";
										$this->response->mensagem .= "[".Email::getErro()." - ".Email::getMensagem()."]";
									}
								} else {
									$this->response->mensagem .= "<br/>Erro: Não existe template de email para esta operação.";
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
            //if(!$Observacao){    $Observacao = self::getVar('Observacao');}
            
            $this->response->Id = $Id;
            $this->response->IdEvento = $IdEvento;
            $this->response->IdParticipante = $IdParticipante;
            $this->response->Observacao = '';
            
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
                            $obj->setObservacao($Observacao); //campo foi limpo acima
                            $obj->setIdUsuarioAprovacao($this->Usuario->Id);
                            $obj->setDataAprovacao(date("Y-m-d H:i:s"));
                            if ($DAO->atualizar($obj)){
                                $this->response->sucesso = 1;
                                $this->response->mensagem = "O registro <b>'".$this->response->Nome."'</b> foi aprovado com sucesso.";
                                
                                // Atualizar Inscrição Principal
                                $objInscricao = $daoInscricao->retornarPorUsuario($this->response->IdParticipante, $objEvento->getIdParente());
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
                                        $this->response->IdStatus = 8;  // Inscrição Em análise
                                    }								
									
                                    if ($daoInscricao->atualizarCampo($this->response->IdFormulario, 'id_status', $this->response->IdStatus)){
                                        $this->response->mensagem .= '<br/>Status principal atualizado com sucesso. ('.$this->response->IdStatus.')';								
										
                                        if ($this->response->IdStatus ==10){ // 10: Concluído
                                            // Enviar Email;
                                            $Conteudo = (file_exists('templates/inscricao.comunicar.email.html'))? file_get_contents('templates/inscricao.comunicar.email.html'): '';
                                            if ($Conteudo!=''){
												$this->response->Assunto = "Inscrição aceita no V International Symposium on Immunobiologicals de Bio-Manguinhos (".$this->response->IdFormulario.")";
												$this->response->TextoMsg = "Sua inscrição no V International Symposium on Immunobiologicals de Bio-Manguinhos foi confirmada. <br/>";
												$this->response->TextoMsg .= "O evento será realizado no Centro Cultural da Fundação Getúlio Vargas, na Praia de Botafogo.<br/>";
												$this->response->TextoInscricao = "Inscrição: <b>".$this->response->IdFormulario . "</b>";
												$this->response->TextoCracha = "Nome no Crachá: <b>".$this->response->Apelido . "</b>";
												$this->response->TextoLocal = "<b>Endereço:</b> Praia de Botafogo, 190 - Botafogo, Rio de Janeiro - RJ. <br/>";
												$this->response->TextoLocal .= "<b>Data:</b> 11 a 13 de maio de 2020 - das 9h as 17h. <br/>";
												//$this->response->TextoDecisao = "De acordo com as suas solicitações e com a disponibilidade de vagas, sua inscrição foi confirmada para os seguintes dias do evento:";
												$this->response->TextoTrabalho = "Submissão de trabalhos para exposição de pôsteres científicos pelo site http://isi.bio.fiocruz.br. Participe, apresente seu trabalho e concorra a prêmios.";
                                                
												/*---não será utilizado tabela com os dias selecionados do evento para 2020
												//Montar a tabela com os dias do evento que o participante irá participar
                                                $Tabela = "<table style='border: 0.5px solid #000000; font-family: arial; font-size: 8pt; vertical-align: top; ' cellspacing='0' cellpadding='5'>"
                                                        ."<tr style='background-color: #ccc; '>"
                                                        //."    <td width='30' style='border: 0.5px solid #000000;'><b>#</b></td>"
                                                        ."    <td width='200' style='border: 0.5px solid #000000;'><b>Dias Solicitados</b></td>"
                                                        ."    <td width='50' style='border: 0.5px solid #000000;'><b>Status</b></td>"
                                                        ."    <td width='300' style='border: 0.5px solid #000000;'><b>Observações</b></td>"
                                                        ."</tr>";     
                                                $listagem = $DAO->listar(null, null, '1', 'asc', $objEvento->getIdParente(), null, $this->response->IdParticipante);
                                                if ($listagem) {
                                                    $i=0;
													$Dia7=''; $Dia8=''; $Dia9='';
                                                    foreach ($listagem as $item){
                                                        $cor = ($i%2==0? '#eee': '#fff');
                                                        $corStatus = '#000000';
                                                        if ($item->getIdStatus()==1){
															$corStatus = '#000000';
														}else {
															if ($item->getIdStatus()==2){
																$corStatus = '#69aa46'; 
																$Dia = date( 'd', strtotime( $item->getDataInicial() ) );
																if($Dia == 7) {$Dia7 = 7;} else{if($Dia == 8) {$Dia8 = 8;} else	{$Dia9 = 9;}}	
															}else {
																if ($item->getIdStatus()==3){ 
																	$corStatus = '#dd5a43';
																}
															}
														} 
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

												*/

												//Verificar o tipo do email e os dias que serão gravados na Agenda
												$email = $objInscricao->getEmail();
												$dominio   = '@gmail';
												$pos = strpos( $email, $dominio );
												if ($pos === false){ //outlook
													$tipoAgenda = "<a href='https://isi.bio.fiocruz.br/agenda_2020.ics' title='Clique aqui para agendar o evento'><img src='https://isi.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
												/*
													if( ($Dia7) && ($Dia8) && ($Dia9)) //inscrito todos os dias
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento789Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( ($Dia7) && (!$Dia8) && (!$Dia9)) //inscrito apenas no primeiro dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento7Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( (!$Dia7) && ($Dia8) && (!$Dia9)) //inscrito apenas no segundo dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento8Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( (!$Dia7) && (!$Dia8) && ($Dia9)) //inscrito apenas no terceiro dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento9Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( ($Dia7) && ($Dia8) && (!$Dia9)) //inscrito no primeiro e no segundo dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento78Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( ($Dia7) && (!$Dia8) && ($Dia9)) //inscrito no primeiro e no terceiro dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento79Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";
													if( (!$Dia7) && ($Dia8) && ($Dia9)) //inscrito no segundo e no terceiro dia
														$tipoAgenda = "<a href='https://sact.bio.fiocruz.br/evento89Sact2019.ics' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_outlook.jpg'> </a>";																
												*/
												
												}else{  //gmail
													//$tipoAgenda = "<a href='https://www.google.com/calendar/event?action=TEMPLATE&pprop=eidmsgid%3A75u2tpoqbvs320grbiqboik3en_161b5b01c62188ae&dates=20180508T140000%2F20180510T170000&text=VI%20SACT&location=Avenida%20Gra%C3%A7a%20Aranha%2C%20Av.%20Gra%C3%A7a%20Aranha%2C%201%20-%20Centro%2C%20Rio%20de%20Janeiro%20-%20RJ%2C%20Brasil&details&add=";
													//$tipoAgenda .= substr($email, 0, $pos);
													//$tipoAgenda .= "%40gmail.com&ctok=d3VuZXJsdWl6QGdtYWlsLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													$tipoAgenda = "<a href='https://calendar.google.com/calendar/embed?src=bpn6d249q7tuvkc5vcuvq1j4bc%40group.calendar.google.com&ctz=America%2FSao_Paulo' title='Clique aqui para agendar o evento'><img src='https://isi.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
												/*
													if( ($Dia7) && ($Dia8) && ($Dia9)) //inscrito todos os dias
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=YnBuNmQyNDlxN3R1dmtjNXZjdXZxMWo0YmNAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( ($Dia7) && (!$Dia8) && (!$Dia9)) //inscrito apenas no primeiro dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=bm11bW1hazBna2FzMWN0cXVjZWJjcDYwODRAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( (!$Dia7) && ($Dia8) && (!$Dia9)) //inscrito apenas no segundo dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=Y242bjNvcDlub3Q5aGRrNXJrYW02ZGVwZm9AZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( (!$Dia7) && (!$Dia8) && ($Dia9)) //inscrito apenas no terceiro dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=ZXQ0NDEwczQzc3NwOG1vYW1tbW1vdGxyY3NAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( ($Dia7) && ($Dia8) && (!$Dia9)) //inscrito no primeiro e no segundo dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=dXRhZ2l0NWI2Yms1aW1ib3BqN2dkaXVnYzhAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( ($Dia7) && (!$Dia8) && ($Dia9)) //inscrito no primeiro e no terceiro dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=a2I2bXM1ODJlc3NzMDloOTFlczNldGx1ZWtAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
													if( (!$Dia7) && ($Dia8) && ($Dia9)) //inscrito no segundo e no terceiro dia
														$tipoAgenda = "<a href='https://calendar.google.com/calendar?cid=cHJuMGRtMG5vZmhqYmN1aGttMzk4NmhvajBAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ' title='Clique aqui para agendar o evento'><img src='http://sact.bio.fiocruz.br/images/calendar_google.jpg' width='100' height='100'> </a>";
												*/
												}
                                                
                                                $Conteudo = str_replace("{NOME}", $this->response->Nome, $Conteudo);
                                                $Conteudo = str_replace("{MENSAGEM}", $this->response->TextoMsg, $Conteudo);
												$Conteudo = str_replace("{LOCAL}", $this->response->TextoLocal, $Conteudo);
												$Conteudo = str_replace("{DECISAO}", $this->response->TextoDecisao, $Conteudo);
                                                $Conteudo = str_replace("{TABELA}", $Tabela, $Conteudo);
                                                $Conteudo = str_replace("{NUMERO}", $this->response->TextoInscricao, $Conteudo);
                                                $Conteudo = str_replace("{CRACHA}", $this->response->TextoCracha, $Conteudo);
												$Conteudo = str_replace("{TRABALHO}", $this->response->TextoTrabalho, $Conteudo);
												$Conteudo = str_replace("{AGENDA}", $tipoAgenda, $Conteudo);
												
                                                if (Email::enviar($this->response->Nome, $this->response->Email, 'isi@bio.fiocruz.br', $this->response->Assunto, $Conteudo)){
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

		$visao = self::getVar('visao'); 
		
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
			//Alteração realizado em 11/04/2018
			//Se o método foi chamado do cadastro de presença e não foi selecionado nenhum evento,
			//atribui um código de evento inválido para não mostrar nenhum registro.
			$Visao = self::getVar('visao');
			if (($Visao == 'cadastro-presenca.view.php') && ($IdEvento == null)){
				$IdEvento = 999;
			}						
			
            $IdStatus = self::getVar('IdStatus');
            $IdParticipante = self::getVar('IdParticipante');
            $Nome = self::getVar('Nome');
			
            $daoEventoPresencao = new EventoPresencaDAO();
			$daoResumo = new ResumoDAO();
            
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
						//Objeto para marcar/desmarcar presença já MARCADO
						$chkPresenca = '<input type="checkbox" id="opcaoPresenca_'.$item->getIdParticipante().'" checked onclick=marcarPresenca('.$item->getIdParticipante().','.$item->getIdEvento().')>';
						
                        $strCertificado = 'Presente'; //$objPresenca->getCredencial();
                        if (($item->getIdEvento()==2) || ($item->getIdEvento()==3) || ($item->getIdEvento()==4) || ($item->getIdEvento()==5)) { // Cerificados agrupados;
                            if ($CertificadoAgrupado==0){ // Somente exibir botão de impressão para o primeiro evento encontrato;
                                $strCertificado = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificado(\''.$objPresenca->getChave().'\');" title="Visualizar Certificado"><span class="glyphicon glyphicon-file red"></span> Certificado</button>';
                            }
                            $CertificadoAgrupado++; 
                        } else {
                            $strCertificado = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificado(\''.$objPresenca->getChave().'\');" title="Visualizar Certificado"><span class="glyphicon glyphicon-file red"></span> Certificado</button>';
                        }
                    
					} else{
						//Objeto para marcar/desmarcar presença DESMARCADO
						if($item->getIdStatus()==2){ //opção de check habilitado apenas se o participante estiver inscrito
							$chkPresenca = '<input type="checkbox" id="opcaoPresenca_'.$item->getIdParticipante().'" onclick=marcarPresenca('.$item->getIdParticipante().','.$item->getIdEvento().')>';
						}else{
							$chkPresenca = '<input type="checkbox" id="opcaoPresenca_'.$item->getIdParticipante().'" disabled onclick=marcarPresenca('.$item->getIdParticipante().','.$item->getIdEvento().')>';
						}
					
					}

					//Para colocar o botão que baixa os certificados dos autores de trabalho
                    $strCertificadoPoster = array();
                    $objResumo = $daoResumo->verificaResumoPorID($item->getIdParticipante());	

					foreach ($objResumo as $itemResumo){
						//se o participante tiver presença no evento e tiver trabalho submetido aprovado para exposição ou apresentação, cria botão(ões)
						if ( ($objPresenca)&&( ($itemResumo->getIdStatus()==5)||($itemResumo->getIdStatus()==6) ) && ($itemResumo->getAno()==2018) ){ 
							$strCertificadoPoster[] = '<button type="button" class="btn btn-default btn-xs" onclick="visualizarCertificadoPoster(\''.$objPresenca->getChave().'\','.$itemResumo->getId().');" title="Visualizar Certificado Pôster"><span class="glyphicon glyphicon-file blue"></span> Certificado</button>';
							
						}

					}
					
					if($item->getIdStatus()==2){ //opção de check habilitado apenas se o participante estiver inscrito
						$bt_viewCred = '<a class="btn btn-vazio btn-sm btn-grid" title="Gerar Credencial" onclick="emitirCredencial('.$item->getIdParticipante().');"><span class="glyphicon glyphicon-barcode"></span>';
					}else{
						$bt_viewCred = '<a class="btn btn-vazio btn-sm btn-grid" title="Gerar Credencial" disabled onclick="emitirCredencial('.$item->getIdParticipante().');"><span class="glyphicon glyphicon-barcode"></span>';
					}	
					
					if($visao == 'cadastro-presenca.view.php'){ //origem: quem chamou este método, listar
						$this->response->aaData[$i] = array($bt_viewCred, $item->getIdParticipante(), $item->getCpf(), $item->getNomeParticipante(), $item->getEmail(), $NomeStatus, $chkPresenca);
					}else{
						$DAOEvento = new EventoDAO();
						$EventoPrincipal = $DAOEvento->retornar($item->getIdParente());
						
						if($EventoPrincipal->getIdStatus()==5){ // Publicado
							$NomeStatusEvento = '<span class="label label-primary">'.$EventoPrincipal->getNomeStatus().'</span>';
						} else if($EventoPrincipal->getIdStatus()==8){ // Encerrado
							$NomeStatusEvento = '<span class="label label-default">'.$EventoPrincipal->getNomeStatus().'</span>';
						} else {
							$NomeStatusEvento = '<span class="label label-default">'.$EventoPrincipal->getNomeStatus().'</span>';
						}						

						$this->response->aaData[$i] = array($bt_view, $item->getId(), $item->getIdEvento(), $item->getNomeEvento(), $strSaldo, $item->getIdParticipante(), $item->getNomeParticipante(), $item->getIdStatus(), $NomeStatus, $strCertificado, $strCertificadoPoster, $item->getObservacao(), $item->getIdTipoEvento(), $chkPresenca, $item->getNameEvent(), $item->getIdParente(), $EventoPrincipal->getNome(), $NomeStatusEvento, $EventoPrincipal->getAtivo());
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
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

	/**
     *  Método para listar todos registros para MARCAR PRESENÇA
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function listarPresenca() {

        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
        $sord = self::getVar('sord');
        
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

            $EventoPrincipal = self::getVar('IdEvento');					
            $IdStatus = self::getVar('IdStatus');
            $Nome = self::getVar('Nome');
			if ($IdDecisao == 8){
				$IdDecisao = "";
			}
            $this->response->IdDecisao = self::getVar('IdDecisao');

            $DAO = new InscricaoDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', null, $EventoPrincipal, $IdStatus, $IdDecisao, $Nome);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){ 
                    $DataCadastro = ($item->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($item->getDataCadastro(), false) : '';
					$Cracha = ($item->getNomeCracha()) ? '<span class="label label-default">'. $item->getNomeCracha().'</span>': '';

                    if($item->getIdStatus()==1){
                        $NomeStatus = '<span class="label label-default">'.'Pendente</span>';
                    } else if($item->getIdStatus()==8){
                        $NomeStatus = '<span class="label label-warning">'.'Em análise</span>';
                    } else if($item->getIdStatus()==10){
                        $NomeStatus = '<span class="label label-primary">'.'Concluído</span>';
                    } else {
                        $NomeStatus = '<span class="label label-info">'.'Não definido</span>';
                    }  					
                    
                    $IdDecisao = 0;
                    $NomeDecisao = '';
					
                    if ($item->getSolicitacoes() > 0) {
                        if ($item->getSolicitacoes() == $item->getAprovados()){
                            $IdDecisao = 2;
                            $NomeDecisao = ' <span class="label label-success" title="'.$item->getAprovados().'/'.$item->getSolicitacoes().' Confirmadas">Confirmada</span>';
                        } else if ($item->getSolicitacoes() == $item->getReprovados()){
                            $IdDecisao = 3;
                            $NomeDecisao = ' <span class="label label-danger" title="'.$item->getReprovados().'/'.$item->getSolicitacoes().' Recusadas">Recusada</span>';
						} else if (($item->getAprovados()>0) && ($item->getSolicitacoes() == ($item->getAprovados() + $item->getReprovados()))){
                            $IdDecisao = 8;
                            $NomeDecisao = ' <span class="label label-success" title="'.$item->getAprovados().'/'.$item->getSolicitacoes().' Confirmadas" >Parcialmente Confirmada</span>';
                        } else {
                            $IdDecisao = 1;
                            $NomeDecisao = ' <span class="label label-vazio" title="'.($item->getSolicitacoes() - ($item->getAprovados() + $item->getReprovados())).'/'.$item->getSolicitacoes().'">Aguardando decisão</span>';
                        }
                    }
					
					if ($item->getCpf()){
						$documento = $item->getCpf();
						$tipo = '<span class="label label-default">CPF</span>';
					}else{
						$documento = $item->getPassaporte();
						$tipo = '<span class="label label-default">Passaporte</span>';
					}	

					$daoEventoPresenca = new EventoPresencaDAO();
                    $objPresenca = $daoEventoPresenca->retornarPorEventoParticipante($EventoPrincipal, $item->getId());
                    if ($objPresenca){
						$chkPresenca = '<input type="checkbox" id="opcaoPresenca_'.$item->getId().'" checked onclick=marcarPresenca('.$item->getId().','.$EventoPrincipal.')>';
					} else{
						if( ($item->getIdStatus()==10) && (($IdDecisao==2) or ($IdDecisao==8)) ){ //opção de check habilitado apenas se o participante estiver inscrito em pelo menos 1 dia do evento
							$chkPresenca = '<input type="checkbox" id="opcaoPresenca_'.$item->getId().'" onclick=marcarPresenca('.$item->getId().','.$EventoPrincipal.')>';
						}else{
							$chkPresenca = '<input type="checkbox" id="opcaoPresenca_'.$item->getId().'" disabled onclick=marcarPresenca('.$item->getId().','.$EventoPrincipal.')>';
						}
					
					}					
					$this->response->aaData[$i] = array($item->getId(), $documento.'<br/><p align="Right">'.$tipo.'</p>', $item->getNomeCompleto(), $item->getEmail(), $NomeDecisao, $NomeStatus, $chkPresenca);						
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
			$DAOPresenca = new EventoPresencaDAO();

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
            $IdEvento = self::getVar('IdEvento', FILTER_SANITIZE_NUMBER_INT); //{para o ano de 2017 que será apenas um único evento}
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
                                            ."    <td width='50' style='border: 0.5px solid #000000;'><b>Presença</b></td>"
                                            ."</tr>";
            }
                        
            
            
            $listagem = $DAO->listar(null, null, '1', 'asc', $IdEmpresa, $IdEvento, null,  $IdStatus, $Nome);
            if ($listagem) {
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem);
                
                $i = 0;
                foreach ($listagem as $item){
                    $cor = ($i%2==0? '#eee': '#fff');
                    
                    $Ativo = ($item->getAtivo())? 'sim': 'não';
                    $DataCadastro = ($item->getDataInscricao()) ? Formatacao::formatarDataHoraSQL($item->getDataInscricao(), false) : '';
                    
                    //$Campos = $item->getCampos();
                    //$Empresa = ($Campos->colaborador=="sim") ? 'Bio-Manguinhos': $Campos->empresa;
					$Empresa = ($item->getColaborador()=="S") ? 'Bio-Manguinhos': $item->getEmpresa();				
                    $Departamento = '';
					$Departamento = ($item->getColaborador()=="S") ? $item->getViceDiretoria(): $item->getCargo();
					
					$objPresencaEvento = $DAOPresenca->retornarPorEventoParticipante($IdEvento, $item->getId());
					if($objPresencaEvento){
						$Presenca = 'Sim';
					}else{
						$Presenca = 'Não';
					}
					
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
											."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$Presenca."</td>"
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
	
    /**
     *  Método para retornar um registro
     *
     * Melhorar DEPOIS
     */    
    public function retornarParaResumo() { 
        
        try{
            //if (!parent::isLogged()){
            //    self::logOff();
            //    self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            //}
            //$this->response->IdUsuario = $this->Usuario->Id;
            
			$IdParticipante = self::getVar('IdParticipante', FILTER_SANITIZE_NUMBER_INT);
			
			$DAO = new EventoParticipanteDAO();
			$obj = $DAO->retornarParaResumo($IdParticipante);

			if ($obj){
				$this->response->Id = $obj->getId();
				$this->response->IdEvento = $obj->getIdEvento();
				$this->response->NomeEvento = $obj->getNomeEvento();
				$this->response->IdParticipante = $obj->getIdParticipante();
				$this->response->NomeParticipante = $obj->getNomeParticipante();
				$this->response->Observacao = $obj->getObservacao();
				$this->response->IdStatus = $obj->getIdStatus();
				$this->response->NomeStatus = $obj->getNomeStatus();
				$this->response->DataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '';
				$this->response->DataAprovacao = ($obj->getDataAprovacao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAprovacao(), false) : '';
				$this->response->NomeUsuarioAprovacao = $obj->getNomeUsuarioAprovacao();
				
				$this->response->Revisao = $obj->getRevisao();
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

        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

        
}