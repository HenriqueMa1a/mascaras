<?php
require_once ("assets/Email.class.php");
if(!class_exists('PessoaDAO')){ require_once 'models/PessoaDAO.class.php';}
if(!class_exists('EventoParticipanteDAO')){ require_once 'models/EventoParticipanteDAO.class.php';}
if(!class_exists('EnderecoDAO')){ require_once 'models/EnderecoDAO.class.php';}
//if(!class_exists('RegistroDAO')){ require_once 'models/RegistroDAO.class.php';}
//if(!class_exists('DocumentoDAO')){ require_once 'models/DocumentoDAO.class.php';}
if(!class_exists('EmpresaDAO')){ require_once 'models/EmpresaDAO.class.php';}
if(!class_exists('PaisDAO')){ require_once 'models/PaisDAO.class.php';}
if(!class_exists('EstadoDAO')){ require_once 'models/EstadoDAO.class.php';}
//if(!class_exists('StatusDAO')){ require_once 'models/StatusDAO.class.php';}
if(!class_exists('EventoDAO')){ require_once 'models/EventoDAO.class.php';}
if(!class_exists('InscricaoDAO')){ require_once 'models/InscricaoDAO.class.php';}
/**
 *  Controle responsável pela módulo Pessoa PARA O NOVO MODELO DE FORMULÁRIO DE INSCRIÇÃO. 
 * 
 * @package Controller
 * @category Controller
 * @since   2016-10-25
 * @version 2.0
 * @author  Kellen Nery
 * 
 *
 */
class PessoaController extends Controller{
	
	private $_NomeStatus = array(0=>'Não definida', 1=>'Pendente', 2=>'', 3=>'', 4=>'', 5=>'', 6=>'', 7=>'', 8=>'Em análise', 9=>'', 10=>'Concluído');
    
	Protected $mainframe;
	Protected $appJoomla;
	Protected $userJoomla;

    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('ficha-inscricao');
        $this->Config->Debug=1;
		
		define('_JEXEC', 1 );
		define('JPATH_BASE', "/var/www/html/isi" );
		define( 'DS','/' );
		//echo "<!-- JPATH_BASE.DS=".JPATH_BASE.DS." //-->";
		
		require_once(JPATH_BASE.DS. 'includes'.DS.'defines.php' );
		require_once(JPATH_BASE.DS.'includes'.DS.'framework.php' );
		require_once(JPATH_BASE.DS.'libraries/joomla/database/factory.php');
		
		
		$this->mainframe = JFactory::getApplication('site');
		//$this->mainframe = JFactory::getApplication('site');
		$this->mainframe->initialise();
		
		
		$this->appJoomla = JFactory::getApplication();
		$this->userJoomla = JFactory::getUser();
		
		$status = $this->userJoomla->guest;
		if($status = 1){
			//do user logged out stuff
		} else {
			//do user logged in stuff
		}		
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
            $Matricula = self::getVar('Matricula', FILTER_SANITIZE_NUMBER_INT);
            $Chave = self::getVar('Chave');
            $this->response->Id = $Id;
            
            if (($Id) || ($Matricula) || ($Chave)){
                $DAO = new PessoaDAO();
                $obj = null;
                if ($Id) {
                    $this->response->Id = $Id;
                    $obj = $DAO->retornar($Id);
					
                } else if ($Matricula) {
                    $this->response->Matricula = $Matricula;
                    $obj = $DAO->retornarPorMatricula($Matricula);
                } else if ($Chave) {
                    $this->response->Chave = $Chave;
                    $obj = $DAO->retornarPorMatricula($Chave);
                }
                if ($obj){	
                    $this->response->Id = $obj->getId();
                    $this->response->NomeCompleto = $obj->getNomeCompleto();
                    $this->response->NomeCracha = $obj->getNomeCracha();
					
                    $this->response->Cpf = '';
                    if ($obj->getCpf()) {
                        $cpf = $obj->getCpf();
                        $cpf = str_replace('.', '', str_replace('.', '', str_replace('.', '', str_replace('.', '', str_replace('-', '', $cpf)))));
                        if (strlen($cpf) < 11){
                            $cpf = substr('000000000000'.$cpf, -11);
                        }
                        $this->response->Cpf = formatacao::formatarCPF($cpf);
                    }
					
					$this->response->Passaporte = $obj->getPassaporte();
                    $this->response->Email = $obj->getEmail();
					$this->response->Senha = $obj->getSenha();
                    $this->response->DataNascimento = date('d/m/Y', strtotime($obj->getDataNascimento()));
                    $this->response->IdPais = $obj->getIdPais();
                    $this->response->NomePais = $obj->getNomePais();
                    $this->response->IdEstado = $obj->getIdEstado();
                    $this->response->NomeEstado = $obj->getNomeEstado();
                    $this->response->IdCidade = $obj->getIdCidade();
                    $this->response->NomeCidade = $obj->getNomeCidade();
                    $this->response->Telefone = $obj->getTelefone();
                    $this->response->Graduacao = $obj->getGraduacao();
                    $this->response->PosGraduacao = $obj->getPosGraduacao();
                    $this->response->Mestrado = $obj->getMestrado();
                    $this->response->Doutorado = $obj->getDoutorado();
                    $this->response->PosDoutorado = $obj->getPosDoutorado();
                    $this->response->Colaborador = $obj->getColaborador();
                    $this->response->ViceDiretoria = $obj->getViceDiretoria();
                    $this->response->Empresa = $obj->getEmpresa();
                    $this->response->Cargo = $obj->getCargo();
                    $this->response->Resumo = $obj->getResumo();
                    $this->response->DataAcao = date('d/m/Y H:i:s', strtotime($obj->getDataAcao()));
                    $this->response->IdStatus = $obj->getIdStatus();
					//$this->response->NomeStatus = $obj->getNomeStatus();
					$this->response->DataCadastro = date('d/m/Y H:i:s', strtotime($obj->getDataCadastro()));
					
                    // Critica
                    $this->response->Critica = $obj->getCritica();
                    $this->response->NomeCritica = '';
                    if ($obj->getCritica() > 0){
                        $strCritica = '';
                        if (($obj->getCritica() & 1)==1){ $strCritica .= '<li> Data de nascimento inválida</li>'; }
                        if (($obj->getCritica() & 2)==2){ $strCritica .= '<li> CFP inválido</li>'; }
                        if (($obj->getCritica() & 4)==4){ $strCritica .= '<li> CFP duplicado</li>'; }
                        if (($obj->getCritica() & 16)==16){ $strCritica .= '<li> E-mail Duplicado </li>'; }
                        $this->response->NomeCritica =  "<b>Críticas do Cadastro: </b><br/><ol class='alert-list'>$strCritica</ol>";
                    }                  

                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Registro do <b>'".$this->response->Nome."'</b> foi localizado com sucesso.";

				} else {
                    if ($Id) {
                        $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                    } else if ($Matricula) {
                        $this->response->mensagem = "Erro ao localizar o registro com Matricula: '$Matricula'.";
                    } else if ($Chave) {
                        $this->response->mensagem = "Erro ao localizar o registro com chave: '$Chave'.";
                    } else {
                        $this->response->mensagem = "Erro ao localizar o registro.";
                    }
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
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
            $Id = 0; //self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
			
            $NomeCompleto = self::getVar('NomeCompleto');
            $NomeCracha = self::getVar('NomeCracha');
            $Cpf = self::getVar('TipoCPF');
			$Passaporte = self::getVar('TipoPassaporte');
            $Email = self::getVar('Email');
			$Email2 = self::getVar('Email2');
			$Senha = self::getVar('Senha');
			$Senha2 = self::getVar('Senha2');
			$Telefone = self::getVar('Telefone');
            $DataNascimento = self::getVar('DataNascimento');
			$Pais = self::getVar('IdPais');
			$Estado = self::getVar('IdEstado', FILTER_SANITIZE_NUMBER_INT);
			$Cidade = self::getVar('IdCidade', FILTER_SANITIZE_NUMBER_INT);	
			$Graduacao = self::getVar('Graduacao');
			$PosGraduacao = self::getVar('PosGraduacao');
			$Mestrado = self::getVar('Mestrado');
			$Doutorado = self::getVar('Doutorado');
			$PosDoutorado = self::getVar('PosDoutorado');
			
			$OutraGraduacao = self::getVar('OutraGraduacao');
			$OutraPosGraduacao = self::getVar('OutraPosGraduacao');
			$OutroMestrado = self::getVar('OutroMestrado');
			$OutroDoutorado = self::getVar('OutroDoutorado');
			$OutroPosDoutorado = self::getVar('OutroPosDoutorado');				
			
			$Colaborador = self::getVar('Colaborador'); 
			$ViceDiretoria = self::getVar('Diretoria');
			$Empresa = self::getVar('Empresa');
			$Cargo = self::getVar('Cargo');
			$Resumo = self::getVar('Submeter');
			$WorkShop = self::getVar('WorkShop');
			
            $DAO = new PessoaDAO();
            
            // Validação
            if(!$NomeCompleto) {
                $this->response->mensagem = "Erro: O campo <b>Nome Completo</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$NomeCracha) {
                $this->response->mensagem = "Erro: O campo <b>Nome para o crachá</b> é de preenchimento obrigatório.";
                return false;
            }
				
            if( (!$Cpf) && (!$Passaporte) ) { 
				$this->response->mensagem = "Erro: O campo <b>Tipo de Documento</b> é de preenchimento obrigatório.";
				return false;
            } else {
				if($Cpf) {
					if (!Validacao::validarCPF($Cpf)){
						$this->response->mensagem = "Erro: O campo <b>CPF</b> está com valor inválido. <br>Favor conferir o número na cópia do documento.";
						return false;
					}
				}
            }				
				
            if(!$Email) {
                $this->response->mensagem = "Erro: O campo <b>E-mail</b> é de preenchimento obrigatório.";
                return false;
            }				
			else{
				if($Email <> $Email2){
					$this->response->mensagem = "Erro: <b>E-mail</b> não confere!";
					return false;
				} 
			}

            if(!$Senha) {
                $this->response->mensagem = "Erro: O campo <b>Senha</b> é de preenchimento obrigatório.";
                return false;
            }				
			else{
				if($Senha <> $Senha2){
					$this->response->mensagem = "Erro: <b>Senha</b> não confere!";
					return false;
				} 
			}

            if(!$Telefone) {
                $this->response->mensagem = "Erro: O campo <b>Telefone</b> é de preenchimento obrigatório.";
                return false;
            }
			
            if(!$DataNascimento) {
                $this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> é de preenchimento obrigatório.";
                return false;
            } else if (!Validacao::validarData($DataNascimento)){
                $this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                return false;
            }

            if(!$Pais) {
                $this->response->mensagem = "Erro: O campo <b>Pais</b> é de preenchimento obrigatório.";
                return false;
            }	
			
            if((!$Estado) && ($Pais == 76)) {
                $this->response->mensagem = "Erro: O campo <b>Estado</b> é de preenchimento obrigatório.";
                return false;
            }	

            if((!$Cidade) && ($Pais == 76)) {
                $this->response->mensagem = "Erro: O campo <b>Cidade</b> é de preenchimento obrigatório.";
                return false;
            }

			if(!$Graduacao) {
				$this->response->mensagem = "Erro: O campo <b>Graduação</b> é de preenchimento obrigatório.";
				return false;					
			} else {
				if($Graduacao == "Outras (Especificar)"){
					if(!$OutraGraduacao){
						$this->response->mensagem = "Erro: O campo <b>Graduação</b> é de preenchimento obrigatório.";
						return false;							
					} else {
						$Graduacao = $OutraGraduacao;
					}
				}	
			}				
			
			if($PosGraduacao == "Outras (Especificar)") {
				$PosGraduacao = $OutraPosGraduacao;
            }							

			if($Mestrado == "Outras (Especificar)") {
				$Mestrado = $OutroMestrado;
            }

			if($Doutorado == "Outras (Especificar)") {
				$Doutorado = $OutroDoutorado;
            }

			if($PosDoutorado == "Outras (Especificar)") {
				$PosDoutorado = $OutroPosDoutorado;
            }						
			
			if(!$Colaborador) {
                $this->response->mensagem = "Erro: Deve ser selecionado uma opção para a pergunta <b>Colaborador de Bio-Manguinhos</b>.";
                return false;
            }	

            if($Colaborador == "N" ) { //não é colaborador
				if(!$Empresa) {
					$this->response->mensagem = "Erro: O campo <b>Empresa</b> é de preenchimento obrigatório.";
					return false;
				}
				if(!$Cargo) {
					$this->response->mensagem = "Erro: O campo <b>Cargo</b> é de preenchimento obrigatório.";
					return false;
				}
            } else {
				if(!$ViceDiretoria) {
					$this->response->mensagem = "Erro: O campo <b>Vice Diretoria</b> é de preenchimento obrigatório.";
					return false;
				}
            }

			if(!$Resumo) {
                $this->response->mensagem = "Erro: Deve ser selecionado uma opção para a pergunta <b>Deseja Submeter Resumo</b>.";
                return false;
            }			
                
            // Proteção
            //    $Chave = ($Chave) ? $Chave : UUID::v4();
            //    $IdFederacao = ($IdFederacao) ? $IdFederacao : $this->Usuario->IdEmpresa;
			if ($Cpf){
				$Cpf = Formatacao::limparFormatacao($Cpf);
				$Documento = Formatacao::limparFormatacao($Cpf);	
			}else{
				$Documento = $Passaporte;
			}

			// Gravar no Joomla
			$data = array("name"=>$NomeCompleto, "username"=>$Documento, "password"=>$Senha, "password2"=>$Senha, "email"=>$Email, "block"=>0, "groups"=>array("1","4"));
			$user = JFactory::getUser();
			if($user->id != 0)  {     
				$this->response->mensagem = "Usuário já esta cadastrado";
				return false;

			} else {											
				/* criar novo cadastro*/
				$user = new JUser;
				if(!$user->bind($data)) { //Write to database
					$this->response->mensagem = "Could not bind data. Error: " . $user->getError();
					return false;
				}
				
				if (!$user->save()) {
					//$this->response->mensagem = "Could not save user. Error: " . $user->getError();
					if($user->getError()=="JLIB_DATABASE_ERROR_EMAIL_INUSE"){
						$this->response->mensagem = "Este e-mail já está cadastrado!";
					}
					if($user->getError()=="JLIB_DATABASE_ERROR_USERNAME_INUSE"){
						$this->response->mensagem = "Este Documento já foi cadastrado!";
					}
					return false;
				} else {
					// Sucesso na Gravação do Usuário no Joomla
					$credentials = array();
					$credentials['username'] = $Documento;
					$credentials['password'] = $Senha;

					//perform the login action
					$error = $this->mainframe->login($credentials);
					$Id = $user->id;
				}
			}
			
			$obj = new Pessoa();
			$obj->setId($Id);
			$obj->setNomeCompleto($NomeCompleto);
			$obj->setNomeCracha($NomeCracha);
			$obj->setCpf($Cpf);
			$obj->setPassaporte($Passaporte);
			$obj->setEmail($Email);
			$obj->setSenha($Senha);
			$obj->setTelefone($Telefone);				
			$obj->setDataNascimento(Formatacao::formatarDataSQL($DataNascimento));
			$obj->setIdPais($Pais);		
			$obj->setIdEstado($Estado);			
			$obj->setIdCidade($Cidade);										
			$obj->setGraduacao($Graduacao);			
			$obj->setPosGraduacao(($PosGraduacao)? $PosGraduacao: null);			
			$obj->setMestrado(($Mestrado)? $Mestrado: null);			
			$obj->setDoutorado(($Doutorado)? $Doutorado: null);			
			$obj->setPosDoutorado(($PosDoutorado)? $PosDoutorado: null);		
			$obj->setColaborador($Colaborador);			
			$obj->setViceDiretoria(($ViceDiretoria)? $ViceDiretoria: null);				
			$obj->setEmpresa(($Empresa)? $Empresa: null);					
			$obj->setCargo(($Cargo)? $Cargo: null);			
			$obj->setResumo($Resumo);
		
			if ($DAO->salvar($obj)){ 
			
				/* A INSCRIÇÃO NO EVENTO NÃO SERÁ MAIS REALIZADA NA CRIAÇÃO DA CONTA 
				/*****INÍCIO - QUANDO FOR UMA ÚNICA INSCRIÇÃO (NO EVENTO PRINCIPAL) 
				//Evento Principal Ativo
				$DAOEvento = new EventoDAO();
				$objEvento = $DAOEvento->retornarEventoPrincipalAtivo();
				$IdEventoPrincipal = $objEvento->getIdEvento();	
				$DAOEvento->Close();				

				$DAOEP = new EventoParticipanteDAO();
				$objEP = new EventoParticipante();					
				$objEP->setIdParticipante($Id);	
				$objEP->setIdEvento($IdEventoPrincipal);
				$objEP->setIdTipoParticipante(1);  //Participante Expectador
				$objEP->setIdStatus(1);
				$DAOEP->salvar($objEP);	
				$DAOEP->Close();
				/*****FIM - QUANDO FOR UMA ÚNICA INSCRIÇÃO (NO EVENTO PRINCIPAL)
				*/
						
				/*****INÍCIO - QUANDO A INSCRIÇÃO FOR POR EVENTO (DIA)			
				//gravando os Eventos
				foreach($_POST["evento"] as $Evento){
					$DAOEP = new EventoParticipanteDAO();
					$objEP = new EventoParticipante();					
					$objEP->setIdParticipante($Id);	
					$objEP->setIdEvento($Evento);
					$objEP->setIdTipoParticipante(1);  //Participante Expectador
					$objEP->setIdStatus(1);
					$DAOEP->salvar($objEP);						
				}
				
				//retirado WorkShop que não será utilizado em 2017
				//gravando o WorkShop
				//$objEP->setIdParticipante($Id);	
				//$objEP->setIDEvento($WorkShop);
				//$DAOEP->salvar($objEP);					
				
				$DAOEP->Close();
				FIM - QUANDO A INSCRIÇÃO FOR POR EVENTO (DIA) *****/
				
				$Id = $obj->getId();
				
				$this->response->Id = $Id;
				$this->response->sucesso = 1;
				$this->response->mensagem = "O cadastro do(a) <b>'$NomeCompleto'</b> foi realizado com sucesso." ;
				$this->response->pagina = "../controller.php?modulo=minha-inscricao";
				
				//$this::enviarEmailIncluir($Email);

				//$user = JFactory::getUser();
				 
			} else {
				$this->response->mensagem = $DAO->getMensagem();
			}
			if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
				       
            $DAO->Close();
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
	
        return ($this->response->sucesso==1);
    }
	
		
    /**
     *  Método para enviar notificação de pré inscrição (inclusão)
     *
     * KELLEN NERY
     */    
    public function enviarEmailIncluir($p_mail) {	
	
		// enviar Email;
		$Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
		
		$DAOEmail = new PessoaDAO();
		$obj = $DAOEmail->retornarPorEmail($p_mail);
		
		if ($obj){		
			$Id    		= $obj->getId();
			$Nome  		= $obj->getNomeCompleto();
			$Cpf   		= $obj->getCpf();
			$Passaporte = $obj->getPassaporte();			
			$Documento 	= ($Cpf) ? $Cpf : $Passaporte;
			$Email 		= $obj->getEmail();
			$Data  		= $obj->getDataAcao();
		
			$Conteudo = "";
			$Conteudo .= "Prezado(a) <em>$Nome</em><br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "Sua solicitação de inscrição foi <u>cadastrada</u> em nossa base de dados em $Data <br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "Nº: $Id<br/>";
			$Conteudo .= "Nome: $Nome<br/>";
			$Conteudo .= "E mail: $Email<br/>";
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
			
            $Id = self::getVar('IdUsuario', FILTER_SANITIZE_NUMBER_INT);
            //$IdFederacao = self::getVar('IdFederacao', FILTER_SANITIZE_NUMBER_INT);
            //$IdEntidade = self::getVar('IdEntidade', FILTER_SANITIZE_NUMBER_INT);
            //$Chave = self::getVar('Chave');
            //$Matricula = self::getVar('Matricula');
            //$NotaOficial = self::getVar('NotaOficial');
            
            $Email = self::getVar('Email');
			$Email2 = self::getVar('Email2');
			$NomeCompleto = self::getVar('NomeCompleto');
			$NomeCracha = self::getVar('NomeCracha');
			$Senha = self::getVar('Senha');
			$Senha2 = self::getVar('Senha2');
			$Telefone = self::getVar('Telefone');
			$DataNascimento = self::getVar('DataNascimento'); 
			$Pais = self::getVar('IdPais', FILTER_SANITIZE_NUMBER_INT);
			$Estado = self::getVar('IdEstado', FILTER_SANITIZE_NUMBER_INT);
			$Cidade = self::getVar('IdCidade', FILTER_SANITIZE_NUMBER_INT);	
			$Graduacao = self::getVar('Graduacao');
			$PosGraduacao = self::getVar('PosGraduacao');
			$Mestrado = self::getVar('Mestrado');
			$Doutorado = self::getVar('Doutorado');
			$PosDoutorado = self::getVar('PosDoutorado');
						
			$OutraGraduacao = self::getVar('OutraGraduacao');
			$OutraPosGraduacao = self::getVar('OutraPosGraduacao');
			$OutroMestrado = self::getVar('OutroMestrado');
			$OutroDoutorado = self::getVar('OutroDoutorado');
			$OutroPosDoutorado = self::getVar('OutroPosDoutorado');				
						
			$Colaborador = self::getVar('Colaborador');
			$ViceDiretoria = self::getVar('Diretoria');
			$Empresa = self::getVar('Empresa');
			$Cargo = self::getVar('Cargo');
			$Resumo = self::getVar('Submeter');
			$WorkShop = self::getVar('WorkShop');
			
			$EditarNovaInscricao = self::getVar('EditarNovaInscricao');			
            
            $DAO = new PessoaDAO();
			
            // Validação
            if(!$Email) {
                $this->response->mensagem = "Erro: O campo <b>E-mail</b> é de preenchimento obrigatório.";
                return false;
            }				
			else{
				if($Email <> $Email2){
					$this->response->mensagem = "Erro: <b>E-mail</b> não confere!";
					return false;
				} 
			}	
			/*
            if(!$Senha) {
                $this->response->mensagem = "Erro: O campo <b>Senha</b> é de preenchimento obrigatório.";
                return false;
            }				
			else{
				if($Senha <> $Senha2){
					$this->response->mensagem = "Erro: <b>Senha</b> não confere!";
					return false;
				} 
			}	
			*/			
			
            if(!$NomeCompleto) {
                $this->response->mensagem = "Erro: O campo <b>Nome Completo</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$NomeCracha) {
                $this->response->mensagem = "Erro: O campo <b>Nome para o crachá</b> é de preenchimento obrigatório.";
                return false;
            }			

            if(!$Telefone) {
                $this->response->mensagem = "Erro: O campo <b>Telefone</b> é de preenchimento obrigatório.";
                return false;
            }
			
            if(!$DataNascimento) {
                $this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> é de preenchimento obrigatório.";
                return false;
            } else if (!Validacao::validarData($DataNascimento)){
                $this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                return false;
            }

            if(!$Pais) {
                $this->response->mensagem = "Erro: O campo <b>Pais</b> é de preenchimento obrigatório.";
                return false;
            }	
			
            if((!$Estado) && ($Pais == 76)) {
                $this->response->mensagem = "Erro: O campo <b>Estado</b> é de preenchimento obrigatório.";
                return false;
            }	

            if((!$Cidade) && ($Pais == 76)) {
                $this->response->mensagem = "Erro: O campo <b>Cidade</b> é de preenchimento obrigatório.";
                return false;
            }	

			if(!$Graduacao) {
				$this->response->mensagem = "Erro: O campo <b>Graduação</b> é de preenchimento obrigatório.";
				return false;					
			} else {
				if($Graduacao == "Outras (Especificar)"){
					if(!$OutraGraduacao){
						$this->response->mensagem = "Erro: O campo <b>Graduação</b> é de preenchimento obrigatório.";
						return false;							
					} else {
						$Graduacao = $OutraGraduacao;
					}
				}	
			}				
			
			if($PosGraduacao == "Outras (Especificar)") {
				$PosGraduacao = $OutraPosGraduacao;
            }							

			if($Mestrado == "Outras (Especificar)") {
				$Mestrado = $OutroMestrado;
            }

			if($Doutorado == "Outras (Especificar)") {
				$Doutorado = $OutroDoutorado;
            }

			if($PosDoutorado == "Outras (Especificar)") {
				$PosDoutorado = $OutroPosDoutorado;
            }						
			
			if(!$Colaborador) {
                $this->response->mensagem = "Erro: Deve ser selecionado uma opção para a pergunta <b>Colaborador de Bio-Manguinhos</b>.";
                return false;
            }	

            if($Colaborador == "N" ) { //não é colaborador
				if(!$Empresa) {
					$this->response->mensagem = "Erro: O campo <b>Empresa</b> é de preenchimento obrigatório.";
					return false;
				}
				if(!$Cargo) {
					$this->response->mensagem = "Erro: O campo <b>Cargo</b> é de preenchimento obrigatório.";
					return false;
				}
            } else {
				if(!$ViceDiretoria) {
					$this->response->mensagem = "Erro: O campo <b>Vice Diretoria</b> é de preenchimento obrigatório.";
					return false;
				}
            }
/*
			if(!$Resumo) {
                $this->response->mensagem = "Erro: Deve ser selecionado uma opção para a pergunta <b>Deseja Submeter Resumo</b>.";
                return false;
            }	*/			
			       
            // Proteção
            //    $Chave = ($Chave) ? $Chave : UUID::v4();
            //    $IdFederacao = ($IdFederacao) ? $IdFederacao : $this->Usuario->IdEmpresa;
            //    $CPF = ($CPF)? Formatacao::limparFormatacao($CPF): null;		

            $this->response->Id=$Id;
            if ($Id){  
                $obj = $DAO->retornar($Id);
                if ($obj){
					$obj->setEmail($Email);
                    $obj->setNomeCompleto($NomeCompleto);
                    $obj->setNomeCracha($NomeCracha);
					$obj->setSenha($Senha);
					$obj->setTelefone($Telefone);				
					$obj->setDataNascimento(Formatacao::formatarDataSQL($DataNascimento));
					$obj->setIdPais($Pais);
					$obj->setIdEstado($Estado);
					$obj->setIdCidade($Cidade);
					$obj->setGraduacao($Graduacao);
					$obj->setPosGraduacao(($PosGraduacao)? $PosGraduacao: null);					
					$obj->setMestrado(($Mestrado)? $Mestrado: null);
					$obj->setDoutorado(($Doutorado)? $Doutorado: null);
					$obj->setPosDoutorado(($PosDoutorado)? $PosDoutorado: null);				
					$obj->setColaborador($Colaborador);
					$obj->setViceDiretoria(($ViceDiretoria)? $ViceDiretoria: null);	
					$obj->setEmpresa(($Empresa)? $Empresa: null);	
					$obj->setCargo(($Cargo)? $Cargo: null);
					$obj->setResumo($Resumo);
					
					//Evento Principal Ativo
					$DAOEvento = new EventoDAO();
					$objEvento = $DAOEvento->retornarEventoPrincipalAtivo();
					$IdEventoPrincipal = $objEvento->getIdEvento();	
					$DAOEvento->Close();				

                    if ($DAO->atualizar($obj)){ 
					
						/* A INSCRIÇÃO NO EVENTO NÃO SERÁ MAIS REALIZADA NA CRIAÇÃO DA CONTA 
						/*****INÍCIO - QUANDO FOR UMA ÚNICA INSCRIÇÃO (NO EVENTO PRINCIPAL) 
						//buscar se o participante está inscrito no evento
						$DAOEP = new EventoParticipanteDAO();
						$listagem = $DAOEP->listar(null, null, 1, null, $IdEventoPrincipal, null, $Id, null);
						
						//se o participante NÃO está inscrito no evento atual
						if(!$listagem){ 
							$objEP = new EventoParticipante();					
							$objEP->setIdParticipante($Id);	
							$objEP->setIdEvento($IdEventoPrincipal);
							$objEP->setIdTipoParticipante(1);  //Participante Expectador
							$objEP->setIdStatus(1);
							$DAOEP->salvar($objEP);	
							$DAOEP->Close();
						}
						/*****FIM - QUANDO FOR UMA ÚNICA INSCRIÇÃO (NO EVENTO PRINCIPAL) 
						*/
						
						/*****INÍCIO - QUANDO A INSCRIÇÃO FOR POR EVENTO (DIA)
						//Eventos selecionados na alteração de cadastro
						$eventosNovos = array();
						foreach($_POST["evento"] as $Evento){
							$eventosNovos[] = $Evento;
							
						}
						
						//buscar todos os subeventos do evento principal do participante
						$DAOEP = new EventoParticipanteDAO();
						$listagem = $DAOEP->listar(null, null, 1, null, $IdEventoPrincipal, null, $Id, null);
						
						//se o participante já possui inscrições no evento atual
						if($listagem){   
							//para gravar os novos
							for ($i=0; $i < sizeof($eventosNovos); $i++){  
								$novo = 1;
								foreach($listagem as $item){ 
									if($eventosNovos[$i] == $item->getIdEvento()){
										$novo=0;
									}		
								}

								if($novo){ 
									$objEP = new EventoParticipante();					
									$objEP->setIdParticipante($Id);	
									$objEP->setIdEvento($eventosNovos[$i]);
									$objEP->setIdTipoParticipante(1);  //Participante Expectador
									$objEP->setIdStatus(1);
									$DAOEP->salvar($objEP);	
								}
							}	
							//para apagar somente os dias que foram desmarcados			
							foreach($listagem as $item){
								$desmarcado = 1;
								for ($i=0; $i < sizeof($eventosNovos); $i++){  
									if($item->getIdEvento() == $eventosNovos[$i]){
										$desmarcado=0;
									}		
								}

								if($desmarcado){ //apagar  		
									if( $DAOEP->excluirFisico($item->getId()) ){
										$this->response->mensagem = "Evento desmarcado";
									}else{
										$this->response->mensagem = "Erro na Alteração para desmarcar um evento existente";
									}
									
								}
							}	
						} else{ //caso seja uma inscrição Nova no evento atual
							foreach($_POST["evento"] as $Evento){
								$objEP = new EventoParticipante();					
								$objEP->setIdParticipante($Id);	
								$objEP->setIdEvento($Evento);
								$objEP->setIdTipoParticipante(1);  //Participante Expectador
								$objEP->setIdStatus(1);
								$DAOEP->salvar($objEP);						
							}								
						}
						
						//Atualizar o status do participante de acordo com as decisões dada no evento
						$listagem = $DAOEP->listar(null, null, 1, null, $IdEventoPrincipal, null, $Id, null);
						if($listagem){
							$decisao1 = 0;
							$decisao2 = 0;
							$decisao3 = 0;
							foreach($listagem as $item){
								if($item->getIdStatus() == 1){ //quantidade de decisões Pendentes
									$decisao1 += 1;
								}
								if($item->getIdStatus() == 2){ //quantidade de decisões Aprovadas
									$decisao2 += 1;
								}
								if($item->getIdStatus() == 3){ //quantidade de decisões Reprovadas
									$decisao3 += 1;
								}								
							}
						}
						$DAOInscricao = new InscricaoDAO();
						if( ($decisao1 > 0) && ($decisao2 == 0) && ($decisao3 == 0) ) {
							if ($DAOInscricao->atualizarCampo($Id, 'id_status', '1')){  //participante com status Pendente
								$this->response->sucesso = 1;
							}						
						}
						if( ($decisao1 > 0) && (($decisao2 != 0) || ($decisao3 != 0)) ) {
							if ($DAOInscricao->atualizarCampo($Id, 'id_status', '8')){  //participante com status Em Análise
								$this->response->sucesso = 1;
							}						
						}	
						if( $decisao1 == 0 ) {
							if ($DAOInscricao->atualizarCampo($Id, 'id_status', '10')){  //participante com status Concluído
								$this->response->sucesso = 1;
							}						
						}	
						
						$DAOInscricao->Close();

						//retirado WorkShop que não será utilizado em 2017
						//gravando o WorkShop
						//$objEP->setIDEvento(($WorkShop)? $WorkShop: null);						
						//if($WorkShop){
						//	$objEP->setIdParticipante($Id);	
						//	$DAOEP->salvar($objEP);					
						//}
						
						$DAOEP->Close();

						FIM - QUANDO A INSCRIÇÃO FOR POR EVENTO (DIA)****/

                        $this->response->sucesso = 1;
                        $this->response->mensagem = "O cadastro de <b>'$NomeCompleto'</b> foi atualizado com sucesso.";
						$this->response->pagina = "../controller.php?modulo=minha-inscricao";
						//$this->response->pagina = "../index.php/minha-inscricao";
						
						//if(!$EditarNovaInscricao){ 
						//	$this::enviarEmailIncluir($Email);
						//}else{
						//	$this::enviarEmailAlterar($Email);
						//}
						
                        if ($this->Config->Debug){
                            $this->response->mensagem .= $ERRO_NOTAS;
                        }
                    } else {
                        $this->response->mensagem = $DAO->getMensagem();
                    }
                    if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro com id: '$Id'.";
                }
            } else {
                $this->response->mensagem = "O identificador do registro é um parametro obrigatório.";
            }
            $DAO->Close();
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

    /**
     *  Método para enviar notificação de pré inscrição (alteração)
     *
     * KELLEN NERY
     */    
    public function enviarEmailAlterar($p_mail) {	
	
		// enviar Email;
		$Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
		
		$DAOEmail = new PessoaDAO();
		$obj = $DAOEmail->retornarPorEmail($p_mail);
		
		if ($obj){	
			$Id    		= $obj->getId();
			$Nome  		= $obj->getNomeCompleto();
			$Cpf   		= $obj->getCpf();
			$Passaporte = $obj->getPassaporte();			
			$Documento 	= ($Cpf) ? $Cpf : $Passaporte;
			$Email 		= $obj->getEmail();
			$Data  		= $obj->getDataAcao();
			$Status		= $this->_NomeStatus[$obj->getIdStatus()];
		
			$Conteudo = "";
			$Conteudo .= "Prezado(a) <em>$Nome</em><br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "Sua inscrição foi <u>Alterada</u> em nossa base de dados em $Data <br/>";
			$Conteudo .= "<br/>";
			$Conteudo .= "Nº: $Id<br/>";
			$Conteudo .= "Nome: $Nome<br/>";
			$Conteudo .= "E mail: $Email<br/>";
			$Conteudo .= "Login (CPF/Passaporte): $Documento<br/>";
			$Conteudo .= "Status da Inscrição: <b>$Status</b><br/>";
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
     * Método para Aprovar um registro
     * 
     * @param int Identificador do registro 
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function aprovar($p_Id=null){
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
                $DAO = new PessoaDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Nome = $obj->getNome();
                    if ($DAO->aprovar($obj)){
                        
                        // Registro ?
                        /*
                        $rDAO = new RegistroDAO();
                        $objRegistro = $rDAO->retornarPorPessoa($Id, null);
                        if (!$objRegistro) {
                            $objRegistro = new Registro();
                            $objRegistro->setIdPessoa($Id);
                            $objRegistro->setMatricula($obj->getMatricula());
                            $objRegistro->setIdFederacao($obj->getIdFederacao());
                            $objRegistro->setIdEntidade(($obj->getIdEntidade())? $obj->getIdEntidade(): null);
                            $objRegistro->setObservacao($obj->getObservacao());
                            $objRegistro->setRevisao(1);
                            $objRegistro->setIdStatus(2); // Registro Pendente
                            if ($rDAO->salvar($objRegistro)){
                                $ERRO_NOTAS .= "<br/>Registro Profissional: Cadastrado e aguardando conclusão.";
                            } else {
                                $ERRO_NOTAS .= "<br/>Registro Profissional: Erro ao cadastradar.";
                            }
                        }
                        $rDAO->Close();
                        */
                        $this->response->sucesso = 1;
                        $this->response->Matricula = $obj->getMatricula();
                        $this->response->mensagem = "O cadastro do Profissional <b>'".$obj->getNome()."'</b> foi aprovado com sucesso. ";
                        if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
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
                $DAO = new PessoaDAO();
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
            $aColumns = array(0=>'img', 1=>'p.matricula', 2=>'p.id_federacao', 3=>'p.nome', 4=>'p.data_nascimento', 5=>'s.nome', 6=>'p.data_acao', 7=>'p.critica' );
            $sOrder = "";
            if (self::getVar('iSortCol_0')){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = 'id_pessoa';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            // Parametros para o Filtro
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $Chave = self::getVar('Chave');
            $IdStatus = self::getVar('IdStatus');
            $IdFederacao = self::getVar('IdFederacao', FILTER_SANITIZE_NUMBER_INT);
            $IdEntidade = self::getVar('IdEntidade', FILTER_SANITIZE_NUMBER_INT);
            $Nome = self::getVar('Nome');
            $Email = self::getVar('Email', FILTER_SANITIZE_EMAIL);
            $Matricula = self::getVar('Matricula');
            $CPF = self::getVar('CPF');
            $DataNascimento = self::getVar('DataNascimento');
            $dtNascimento = '';
            $NascimentoDe = self::getVar('NascimentoDe');
            $NascimentoAte = self::getVar('NascimentoAte');
            
            $Ativo = self::getVar('Ativo');
            
            // Exibir Filtros
            $this->response->IdFederacao = $IdFederacao;
            $this->response->IdEntidade = $IdEntidade;
            
            // Proteção
                if ($IdStatus=='1'){ $IdProfissao = ''; } // Pendente de Cadastro, ainda não tem profissão
                $CPF = ($CPF)? Formatacao::limparFormatacao($CPF) : null;
                if ($Matricula) {
                    if (!is_numeric($Matricula)) {
                        $this->response->mensagem = "Erro: O campo <b>Matricula</b> está com valor inválido.";
                        return false;
                    }
                }
                if ($DataNascimento) {
                    if (Validacao::validarData($DataNascimento)){
                        $dtNascimento = Formatacao::formatarDataSQL($DataNascimento);
                    } else {
                        $this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                        return false;
                    }
                }
                if ($NascimentoDe){
                    if (!is_numeric($NascimentoDe)) {
                        $this->response->mensagem = "Erro: O campo <b>Ano de Nascimento - De</b> está com valor inválido. (Formato: 0000)";
                        return false;
                    }
                }
                if ($NascimentoAte){
                    if (!is_numeric($NascimentoAte)) {
                        $this->response->mensagem = "Erro: O campo <b>Ano de Nascimento - Até</b> está com valor inválido. (Formato: 0000)";
                        return false;
                    }
                }
                
            $DAO = new PessoaDAO();
            $listagem = $DAO->listar($page, $rows, $sidx, $sord, $Id, $Chave, $IdStatus, $IdFederacao, $IdEntidade, $Nome, $Email, $CPF, $dtNascimento, $Matricula, $Ativo, $NascimentoDe, $NascimentoAte);
            if ($listagem) {
                $this->response->page = ($DAO->getPaginaAtual()) ? $DAO->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($DAO->getTotalPaginas()) ? $DAO->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
                    $DataNascimento = ($item->getDataNascimento()) ? Formatacao::formatarDataSQL($item->getDataNascimento(), false) : '';
                    $DataAcao = ($item->getDataAcao()) ? Formatacao::formatarDataHoraSQL($item->getDataAcao(), false) : '';

                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." onclick="visualizar('.$item->getId().');"><span class="glyphicon glyphicon-search"></span></a>';
                    $bt_critica = '';
                    $Matricula = ($item->getMatricula() > 0)? '<span class="label label-success">'.str_pad($item->getMatricula(), 6, '0', STR_PAD_LEFT).'</span> ': '';                        
                    if ($item->getCritica() > 0){
                        $strCritica = '';
                        if (($item->getCritica() & 1)==1){ $strCritica .= 'Data de nascimento inválida'; }
                        if (($item->getCritica() & 2)==2){ $strCritica .= ($strCritica)? ', CFP inválido': 'CFP inválido'; }
                        if (($item->getCritica() & 4)==4){ $strCritica .= ($strCritica)? ', CFP duplicado': 'CFP duplicado'; }
                        if (($item->getCritica() & 8)==8){ $strCritica .= ($strCritica)? ', RG não preenchido .': 'sem RG'; }
                        if (($item->getCritica() & 16)==16){ $strCritica .= ($strCritica)? ', E-mail Duplicado': 'Email Duplicado'; }
                        $strCritica .= ($strCritica) ? '.': '';

                        $bt_critica = '<span class="glyphicon glyphicon-exclamation-sign red" title="'.$strCritica.'" data-toggle="popover" data-content="'.$strCritica.'" ></span>';
                    }
                    $this->response->aaData[$i] = array($bt_view, $Matricula, to_maiuscula($item->getNomeFederacao()), to_maiuscula($item->getNome()), $DataNascimento, $item->getNomeStatus(), $DataAcao, $bt_critica);
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
            //if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
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
        try {
            // Parametros para o Filtro
            $Id = self::getVar('Id');
            $Chave = self::getVar('Chave');
            $IdStatus = self::getVar('IdStatus');
            $IdFederacao = self::getVar('IdFederacao', FILTER_SANITIZE_NUMBER_INT);
            $IdEntidade = self::getVar('IdEntidade', FILTER_SANITIZE_NUMBER_INT);
            $Nome = self::getVar('Nome');
            $Email = self::getVar('Email', FILTER_SANITIZE_EMAIL);
            
            $DAO = new PessoaDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $Id, $Chave, $IdStatus, $IdFederacao, $IdEntidade, $Nome, $Email);
            if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $this->response->rows[$i]['value'] = intval($item->getId()); 
                    $this->response->rows[$i]['text'] = $item->getNome();
                    $i++;
                }
                $this->response->sucesso=1;
            }else{
                $this->response->records=0;
            }
            //if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    } 

    /**
     * Método para listar registros profissionais da Pessoa
     
     * @param int $IdPessoa O Identificador do registro da Pessoa
     *
     * @return array Retornar o array aaData[] = {{Link, Id, Sigla, Nome, Ativo},...}
     */    
    public function listarRegistros() {
        try {
            // Parametros para o Filtro
            $Id = self::getVar('Id');
            $Chave = self::getVar('Chave');
            $IdStatus = self::getVar('IdStatus');
            $IdFederacao = self::getVar('IdFederacao', FILTER_SANITIZE_NUMBER_INT);
            $IdEntidade = self::getVar('IdEntidade', FILTER_SANITIZE_NUMBER_INT);
            $IdProfissao = self::getVar('IdProfissao', FILTER_SANITIZE_NUMBER_INT);
            $IdProfissaoNivel = self::getVar('IdProfissaoNivel');
            $IdPessoa = self::getVar('IdPessoa', FILTER_SANITIZE_NUMBER_INT);
            $Matricula = self::getVar('Matricula');
            $CPF = self::getVar('CPF');
            $Nome = self::getVar('Nome');
            $Email = self::getVar('Email', FILTER_SANITIZE_EMAIL);
            $DataNascimento = filter_input(INPUT_GET, 'DataNascimento', FILTER_SANITIZE_STRING);
            $dtNascimento = '';
            $Sexo = self::getVar('Sexo');
            
            $arrCorStatus = array(0=>'glyphicon glyphicon-flag gray', 1=>'glyphicon glyphicon-flag gray', 2=>'glyphicon glyphicon-flag yellow', 3=>'glyphicon glyphicon-flag orange', 4=>'glyphicon glyphicon-flag orange', 5=>'glyphicon glyphicon-flag blue', 6=>'glyphicon glyphicon-flag gray', 7=>'glyphicon glyphicon-flag gray', 8=>'glyphicon glyphicon-flag gray', 9=>'glyphicon glyphicon-remove-circle red', 10=>'glyphicon glyphicon-ok green');
            $arrLinks = array(0=>'cadastro-pessoa', 1=>'registro-atleta-quadra', 2=>'registro-atleta-praia', 4=>'registro-tecnico', 8=>'registro-tecnico',16=>'registro-tecnico', 32=>'registro-medico', 32=>'registro-medico', 64=>'registro-medico', 128=>'registro-medico', 256=>'registro-arbitro', 512=>'registro-arbitro');
                
            // Proteção
                if ($IdStatus=='1'){ $IdProfissao = ''; } // Pendente de Cadastro, ainda não tem profissão
                $CPF = ($CPF)? Formatacao::limparFormatacao($CPF) : null;
                if ($Matricula) {
                    if (!is_numeric($Matricula)) {
                        $this->response->mensagem = "Erro: O campo <b>Matricula</b> está com valor inválido.";
                        return false;
                    }
                }
                if ($DataNascimento) {
                    if (Validacao::validarData($DataNascimento)){
                        $dtNascimento = Formatacao::formatarDataSQL($DataNascimento);
                    } else {
                        $this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                        return false;
                    }
                }
                
            $DAO = new RegistroDAO();
            $listagem = $DAO->listar(null, null, 'nome', 'asc', $IdFederacao, $IdEntidade, $IdProfissao, $IdProfissaoNivel, $IdStatus, $IdPessoa, $Matricula, $Nome, $CPF, $dtNascimento, $Sexo);
            if ($listagem) {
                $this->response->records = count($listagem);
                $i = 0;
                foreach ($listagem as $item){
                    $DataInicial = ($item->getFedDataInicial()) ? Formatacao::formatarDataSQL($item->getFedDataInicial(), false) : '';
                    $DataFinal = ($item->getFedDataFinal()) ? Formatacao::formatarDataSQL($item->getFedDataFinal(), false) : '';
                    $DataAcao = ($item->getDataAcao()) ? Formatacao::formatarDataHoraSQL($item->getDataAcao(), false) : '';
                    $bt_Modulo = ($item->getIdProfissao()) ? '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar registro." href="controller.php?mod='.$arrLinks[$item->getIdProfissao()].'&acao=listar&id='.$item->getId().'" target="_blank"><span class="glyphicon glyphicon-search blue"></span>': '';
                    $bt_view = ' <a class="btn btn-vazio btn-sm btn-grid" title="Visualizar impressão do registro." onclick="visualizarImpressaoRegistro('.$item->getId().');"><span class="glyphicon glyphicon-file brown"></span>';
                    $imgStatus = '<span class="'.$arrCorStatus[$item->getIdStatus()].'" title="'.$item->getNomeStatus().'"></span> '.$item->getNomeStatus();
                    
                    $this->response->aaData[$i] = array($bt_Modulo, $bt_view,  $item->getNomeFederacao(), ($item->getNomeProfissaoNivel())? $item->getNomeProfissaoNivel(): $item->getNomeProfissao(), "$DataInicial à $DataFinal", $DataAcao, $imgStatus);
                    $i++;
                }
                $this->response->sucesso=1;
                $this->response->iTotalRecords = $this->response->records;
                $this->response->iTotalDisplayRecords = $this->response->records;
            }else{
                $this->response->records=0;
            }
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    } 
    
    /**
     * Método para validar o CPF na base de pessoas
     *
     * @return bool true|false Se validado com sucesso
     */    
    public function conferirCPF() {
        $CPF = self::getVar('CPF');
        $Id = self::getVar('Id');
                
        try {
            $this->response->sucesso = 0;
            if(!$CPF) {
                $this->response->mensagem = "O campo <b>CPF</b> é de preenchimento obrigatório.";
            } else if (!Validacao::validarCPF($CPF)){
                $this->response->mensagem = "O campo <b>CPF</b> está com valor inválido.";
            } else {
                $CPF = Formatacao::limparFormatacao($CPF);

                $DAO = new PessoaDAO();
                $rows = $DAO->contar(null, null, null, null, $CPF);
                $this->response->rows = $rows;
                if ($rows > 1){
                    $this->response->mensagem = "O <b>CPF: $CPF</b> já foi utilizado por $rows pessoas.";
                } else if ($rows==1){
                    $obj1 = $DAO->retornarPorCPF($CPF);
                    if ($obj1){
                        if ($obj1->getId() != $Id){
                            $this->response->mensagem = "O <b>CPF: $CPF</b> já foi utilizado por outra pessoa. <br>Nome: <b>".$obj1->getNome()."</b>.";
                        } else {
                            $this->response->sucesso = 1;
                            $this->response->mensagem = "O <b>CPF: $CPF</b> só esta sendo utilizado por uma pessoa. <br>Nome: <b>".$obj1->getNome()."</b>.";
                        }
                    } else {
                        $this->response->mensagem = "Ao tentar localizar a pessoa que utiliza o <b>CPF: $CPF</b>.";
                    }
                } else {
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "O <b>CPF: $CPF</b> não esta sendo utilizado por outra pessoa.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            }
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        //return $this->outputJSON();
        return ($this->response->sucesso==1);
    } 
    
    /**
     * Método para validar o Email na base de pessoas
     *
     * @return bool true|false Se validado com sucesso
     */    
    public function conferirEmail(){
        $Email = self::getVar('Email');
        $Id = self::getVar('Id');

        try {
            if(!$Email) {
                $this->response->mensagem = "O campo <b>Email</b> é de preenchimento obrigatório.";
            } else if (!Validacao::validarEmail($Email)){
                $this->response->mensagem = "O campo <b>e-mail</b> está com valor inválido.";
            } else {

                $DAO = new PessoaDAO();
                $rows = $DAO->contar(null, null, null, null, null, $Email);
                $this->response->rows = $rows;
                if ($rows > 1){
                    $this->response->mensagem = "O <b>e-mail: $Email</b> já foi utilizado por $rows pessoas.";
                } else if ($rows==1){
                    $obj1 = $DAO->retornarPorEmail($Email);
                    if ($obj1){
                        if ($obj1->getId() != $Id){
                            $this->response->mensagem = "O <b>e-mail: $Email</b> já foi utilizado por outra pessoa. <br>Nome: <b>".$obj1->getNome()."</b>.";
                        } else {
                            $this->response->sucesso = 1;
                            $this->response->mensagem = "O <b>e-mail: $Email</b> só esta sendo utilizado por uma pessoa. <br>Nome: <b>".$obj1->getNome()."</b>.";
                        }
                    } else {
                        $this->response->mensagem = "Ao tentar localizar a pessoa que utiliza o <b>e-mail: $Email</b>.";
                    }
                } else {
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "O <b>e-mail: $Email</b> não esta sendo utilizado por outra pessoa.";
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
                $DAO->Close();
            }
        }catch (PDOExeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

    /**
     *  Método para retornar um Enderço da Pessoa pelo Tipo
     * 
     * @param int Identificador da Pessoa 
     * @param int Identificador do Tipo {1: "Residencial", 2: "Comercial"} 
     *
     * @return object Objeto strClass Endereço
     */    
    private function retornarEndereco($IdPessoa, $IdTipo=1) {
        
        // Endereço Residencial --------------------------------------------------
        $Endereco = new stdClass();
        $Endereco->Id = 0;
        
        $daoEndereco = new EnderecoDAO();
        $objEndereco = $daoEndereco->retornarPorPessoa($IdPessoa, $IdTipo);
        if ($objEndereco) {
            $Endereco->Id = $objEndereco->getId();
            $Endereco->Tipo = $objEndereco->getTipo();
            $Endereco->Descricao = $objEndereco->getDescricao();
            $Endereco->Logradouro = $objEndereco->getLogradouro();
            $Endereco->Numero = $objEndereco->getNumero();
            $Endereco->Complemento = $objEndereco->getComplemento();
            $Endereco->Bairro = $objEndereco->getBairro();
            $Endereco->CEP = $objEndereco->getCEP();
            $Endereco->IdCidade = $objEndereco->getIdCidade();
            $Endereco->Cidade = $objEndereco->getCidade();
            $Endereco->UF = $objEndereco->getUF();
            $Endereco->IdPais = $objEndereco->getIdPais();
            
            if ($this->response->Id < 290000){ // Tratar Registros Antigos
                if (!$Endereco->Numero) { 
                    if (strpos($Endereco->Logradouro, ',')) {
                        $arrTemp = explode(',' , trim($Endereco->Logradouro));
                        $Endereco->Logradouro = $arrTemp[0];
                        $Endereco->Numero = $arrTemp[1];
                        if (strpos($Endereco->Numero, '/')) {
                            $arrTemp = explode('/' , trim($Endereco->Numero));
                            $Endereco->Numero = $arrTemp[0];
                            $Endereco->Complemento .= $arrTemp[1];
                        } else if (strpos($Endereco->Numero, '-')) {
                            $arrTemp = explode('-' , trim($Endereco->Numero));
                            $Endereco->Numero = $arrTemp[0];
                            $Endereco->Complemento .= $arrTemp[1];
                        } else if (strpos($Endereco->Numero, ' ')) {
                            $arrTemp = explode(' ' , trim($Endereco->Numero));
                            $Endereco->Numero = $arrTemp[0];
                            $Endereco->Complemento .= $arrTemp[1];
                        }
                    } else if (strpos($Endereco->Logradouro, ' ')) {
                        $arrTemp = explode(' ' , $Endereco->Logradouro);
                        $Endereco->Logradouro = '';
                        for ($i=0;$i<count($arrTemp);$i++){
                            if (is_numeric($arrTemp[$i])){
                                $Endereco->Numero = $arrTemp[$i];
                                break;
                            } else {
                                $Endereco->Logradouro .= $arrTemp[$i].' ';
                            }
                        }
                        $Endereco->Logradouro = trim($Endereco->Logradouro);
                        $i++;
                        for ($j=$i;$j<count($arrTemp);$j++){
                            $Endereco->Complemento .= $arrTemp[$j].' ';
                        }
                        $Endereco->Complemento = trim($Endereco->Complemento);
                        /*
                        var_dump($arrTemp);
                        echo "Logradouro: ".$Endereco->Logradouro."\n";
                        echo "Numero: ".$Endereco->Numero."\n";
                        echo "Complemento: ".$Endereco->Complemento."\n";
                        exit;
                        // */
                    }
                }
            }
        }
        $daoEndereco->Close();
        return $Endereco;
    }
    
    /**
     * Método para Combinar (Merge) de registros 
     * 
     * @param int Identificador do registro da Pessoa 1 (de origem)
     * @param int Identificador do registro da Pessoa 1 (de destino)
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function combinar($p_Id=null){
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            
            // Coletar parametros
            //$Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $IdPessoa1 = self::getVar('IdPessoa1', FILTER_SANITIZE_NUMBER_INT);
            $IdPessoa2 = self::getVar('IdPessoa2', FILTER_SANITIZE_NUMBER_INT);
            $Id = $IdPessoa2;
            $ERRO_NOTAS = '';

            $this->response->Id = $Id;
            if (($IdPessoa1) && ($IdPessoa2)){
                $DAO = new PessoaDAO();
                $obj = $DAO->retornar($Id);
                if ($obj){
                    $this->response->Nome = $obj->getNome();
                    if ($this->editar()){ // Vamos atualizar o Registro Destino com as atualizações
                        
                        // Combinar Documentos
                        $dDAO = new DocumentoDAO();
                        $result = $dDAO->combinarPessoas($IdPessoa1, $IdPessoa2);
                        if ($result){
                            $ERRO_NOTAS .= "<br/>Documentos: $result documento(s) combinados.\n";
                        } else {
                            $ERRO_NOTAS .= "<br/>Documentos: Nenhum documento combinado.\n";
                        }
                        $dDAO->Close();

                        // Combinar Registro
                        $rDAO = new RegistroDAO();
                        $result = $rDAO->combinarPessoas($IdPessoa1, $IdPessoa2);
                        if ($result){
                            $ERRO_NOTAS .= "<br/>Registros: $result registro(s) combinados.\n";
                        } else {
                            $ERRO_NOTAS .= "<br/>Registros: Nenhum registro combinado.\n";
                        }
                        $rDAO->Close();
                        
                        $this->response->sucesso = 1;
                        $this->response->Matricula = $obj->getMatricula();
                        $this->response->mensagem = "Combinação com o registro <b>'".$obj->getNome()."'</b> foi realizada com sucesso. ".$ERRO_NOTAS;
                        if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
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
    public function relatorio() {
        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
        $sord = self::getVar('sord');
        //$sEcho = self::getVar('sEcho');
        
        try {
            $DAO = new PessoaDAO();

            /** Ordering */
            $aColumns = array(0=>'img', 1=>'p.matricula', 2=>'p.id_federacao', 3=>'p.nome', 4=>'p.data_nascimento', 5=>'s.nome', 6=>'p.data_acao', 7=>'p.critica' );
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
                $sidx = 'id_pessoa';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            // Parametros para o Filtro
            $Id = self::getVar('Id', FILTER_SANITIZE_NUMBER_INT);
            $Chave = self::getVar('Chave');
            $IdStatus = self::getVar('IdStatus');
            $IdFederacao = self::getVar('IdFederacao', FILTER_SANITIZE_NUMBER_INT);
            $IdEntidade = self::getVar('IdEntidade', FILTER_SANITIZE_NUMBER_INT);
            $Nome = self::getVar('Nome');
            $Email = self::getVar('Email', FILTER_SANITIZE_EMAIL);
            $Matricula = self::getVar('Matricula');
            $CPF = self::getVar('CPF');
            $DataNascimento = self::getVar('DataNascimento');
            $dtNascimento = '';
            $NascimentoDe = self::getVar('NascimentoDe');
            $NascimentoAte = self::getVar('NascimentoAte');
            
            $Ativo = self::getVar('Ativo');
            
			// Proteção
                if ($IdStatus=='1'){ $IdProfissao = ''; } // Pendente de Cadastro, ainda não tem profissão
                $CPF = ($CPF)? Formatacao::limparFormatacao($CPF) : null;
                if ($Matricula) {
                    if (!is_numeric($Matricula)) {
                        $this->response->mensagem = "Erro: O campo <b>Matricula</b> está com valor inválido.";
                        return false;
                    }
                }
				$dsNascimento = '';
                if ($DataNascimento) {
                    if (Validacao::validarData($DataNascimento)){
                        $dtNascimento = Formatacao::formatarDataSQL($DataNascimento);
                    } else {
                        $this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                        return false;
                    }
					$dsNascimento = $DataNascimento;
                }
                if ($NascimentoDe){
                    if (!is_numeric($NascimentoDe)) {
                        $this->response->mensagem = "Erro: O campo <b>Ano de Nascimento - De</b> está com valor inválido. (Formato: 0000)";
                        return false;
                    }
					$dsNascimento = $NascimentoDe;
                }
                if ($NascimentoAte){
                    if (!is_numeric($NascimentoAte)) {
                        $this->response->mensagem = "Erro: O campo <b>Ano de Nascimento - Até</b> está com valor inválido. (Formato: 0000)";
                        return false;
                    }
					$dsNascimento .= ($dsNascimento=='')? $NascimentoAte : ' até '.$NascimentoAte;
                }
				
				// Pegar o Nome da Federação
					$NomeFederacao = '';
					if ($IdFederacao){
						$fedDAO = new EmpresaDAO();
						$objFederacao = $fedDAO->retornar($IdFederacao);
						if ($objFederacao){
							$NomeFederacao = $objFederacao->getNome();
						}
					}
				// Pegar o Nome da Entidade
					$NomeEntidade = '';
					if ($IdEntidade){
						$fedDAO = new EmpresaDAO();
						$objEntidade = $fedDAO->retornar($IdEntidade);
						if ($objEntidade){
							$NomeEntidade = $objEntidade->getNome();
						}
					}

				// Pegar o Nome da Entidade
					$NomeStatus = '';
					if ($IdStatus){
						$sttDAO = new StatusDAO();
						$objStatus = $sttDAO->retornar($IdStatus);
						if ($objStatus){
							$NomeStatus = $objStatus->getNome();
						}
					}
				
            // Exibir Filtros
            $this->response->IdFederacao = $IdFederacao;
            $this->response->IdEntidade = $IdEntidade;
            
            $this->response->cabecalho='';
            $this->response->html='';
            
            // Cabeçalho 
                $this->_Pagina = 'A4';
                $this->response->cabecalho = (file_exists('views/cabecalho.'.$this->_Formato.'.html'))? file_get_contents('views/cabecalho.'.$this->_Formato.'.html'): '';
                $this->response->cabecalho = str_replace("{SISNOME}", $this->Config->Nome, $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{SISVERSAO}", $this->Config->Versao, $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{TITULO}", "Relatório de Países", $this->response->cabecalho);
                $this->response->cabecalho = str_replace("{TIMESTAMP}", date("j-m-Y H:m"), $this->response->cabecalho);
                // Filtros
                $strFiltro = '';
                $strFiltro .= ($NomeFederacao)? "Federação: <em>$NomeFederacao</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($NomeEntidade)? "Entidade: <em>$NomeEntidade</em> &nbsp;&nbsp;": ""; 
                $strFiltro .= ($NomeStatus)? "NomeStatus: <em>$NomeStatus</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($CPF)? "CPF: <em>$CPF</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($Matricula)? "Registro: <em>$Matricula</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($Nome)? "Nome: <em>$Nome</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= ($dsNascimento)? "Nascimento: <em>$dsNascimento</em> &nbsp;&nbsp;&nbsp;": ""; 
                $strFiltro .= (!$strFiltro)? "-x-": ""; 
                $this->response->cabecalho = str_replace("{FILTRO}", $strFiltro, $this->response->cabecalho);

            // Formato
            if (($this->_Formato=='excel') || ($this->_Formato=='pdf')){
                // Cabeçalho da Tabela
                $this->response->html.= "<table style='border: 0.5px solid #000000; font-family: arial; font-size: 8pt; vertical-align: top; ' cellspacing='0' cellpadding='5'>"
                                            ."<tr style='background-color: #ccc; '>"
                                            ."    <td width='30' style='border: 0.5px solid #000000;'><b>Registro</b></td>"
                                            ."    <td width='150' style='border: 0.5px solid #000000;'><b>Federação/Associação</b></td>"
                                            ."    <td width='200' style='border: 0.5px solid #000000;'><b>Nome</b></td>"
                                            ."    <td width='100' style='border: 0.5px solid #000000;'><b>Nascimento</b></td>"
                                            ."    <td width='80' style='border: 0.5px solid #000000;'><b>Status</b></td>"
                                            ."    <td width='80' style='border: 0.5px solid #000000;'><b>Ult. Atualização</b></td>"
                                            ."</tr>";
            }

            $listagem = $DAO->listar($page, $rows, $sidx, $sord, $Id, $Chave, $IdStatus, $IdFederacao, $IdEntidade, $Nome, $Email, $CPF, $dtNascimento, $Matricula, $Ativo, $NascimentoDe, $NascimentoAte);            
            if ($listagem) {
                $this->response->records = ($DAO->getTotalRegistros()) ? $DAO->getTotalRegistros(): count($listagem);
                
                $i = 0;
                foreach ($listagem as $item){
                    $cor = ($i%2==0? '#eee': '#fff');
                    
					$DataNascimento = ($item->getDataNascimento()) ? Formatacao::formatarDataSQL($item->getDataNascimento(), false) : '';
                    $DataAcao = ($item->getDataAcao()) ? Formatacao::formatarDataHoraSQL($item->getDataAcao(), false) : '';
                    $bt_critica = '';
                    $Matricula = ($item->getMatricula() > 0)? '<span class="label label-success">'.str_pad($item->getMatricula(), 6, '0', STR_PAD_LEFT).'</span> ': '';                        
                    if ($item->getCritica() > 0){
                        $strCritica = '';
                        if (($item->getCritica() & 1)==1){ $strCritica .= 'Data de nascimento inválida'; }
                        if (($item->getCritica() & 2)==2){ $strCritica .= ($strCritica)? ', CFP inválido': 'CFP inválido'; }
                        if (($item->getCritica() & 4)==4){ $strCritica .= ($strCritica)? ', CFP duplicado': 'CFP duplicado'; }
                        if (($item->getCritica() & 8)==8){ $strCritica .= ($strCritica)? ', RG não preenchido .': 'sem RG'; }
                        if (($item->getCritica() & 16)==16){ $strCritica .= ($strCritica)? ', E-mail Duplicado': 'Email Duplicado'; }
                        $strCritica .= ($strCritica) ? '.': '';

                        $bt_critica = '<span class="glyphicon glyphicon-exclamation-sign red" title="'.$strCritica.'" data-toggle="popover" data-content="'.$strCritica.'" ></span>';
                    }
                    $Ativo = ($item->getAtivo())? 'sim': 'não';
                    
                    $this->response->html.= "<tr style='background-color: $cor;'>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$Matricula."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".to_maiuscula($item->getNomeFederacao())."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".to_maiuscula($item->getNome())."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$DataNascimento."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$item->getNomeStatus()."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$DataAcao."</td>"
                                            ."    <td  style='border: 0.5px solid #000000; text-align:left;'>".$bt_critica."</td>"
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
            }
            
            $this->response->html.= "</table>";
            
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $DAO->_query; }
            $DAO->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
	
}