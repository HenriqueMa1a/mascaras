<?php
if(!class_exists('UsuarioDAO')){ require_once 'models/UsuarioDAO.class.php';}
if(!class_exists('UsuarioSenhaDAO')){ require_once 'models/UsuarioSenhaDAO.class.php';}
if(!class_exists('UsuarioPerfilDAO')){ require_once 'models/UsuarioPerfilDAO.class.php';}
if(!class_exists('PessoaDAO')){ require_once 'models/PessoaDAO.class.php';}
if(!class_exists('EmpresaDAO')){ require_once 'models/EmpresaDAO.class.php';}
if(!class_exists('EnderecoDAO')){ require_once 'models/EnderecoDAO.class.php';}
if(!class_exists('EstadoDAO')){ require_once 'models/EstadoDAO.class.php';}
/**
 *  Controle responsável pela módulo Usuario. 
 * 
 */
class UsuarioController extends Controller{
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */    
    public function __construct(){
        parent::__construct('cadastro-usuario');
    }
    
    /**
     * Método para gerar um senha (randomString())
     *
     * @param int Tamanho 
     * @return object Objeto do tipo Profissao
     */    
    protected function gerarSenha($p_Tamanho) {
        $base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
        $max=strlen($base)-1;
        $activatecode='';
        mt_srand((double)microtime()*1000000);
        while (strlen($activatecode)<$p_Tamanho+1){
            $activatecode.=$base{mt_rand(0,$max)};
        }
        $activatecode = substr($activatecode,0,$p_Tamanho);
        return $activatecode;
    }

    /**
     * Método para gerar um senha (randomString()) - MÉTODO ANTIGO
     *
     * @param string exto
     * @return object Objeto do tipo Profissao
     */      
    private function encriptar($texto){ 

        # Concateno a string auxiliar junto a texto
        $texto = strlen($texto) .'(S@o#2O10*'. $texto . 'sa0$)';

        # Calcula a hash da texto passada
        return hash( 'sha512', $texto );
     
    }
    
    /**
     * Método para retornar um registro
     *
     * @return object Objeto do tipo Profissao
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
                $daoUsuario = new UsuarioDAO();
                $obj = $daoUsuario->retornar($Id);
                if ($obj){
                    $this->response->Id = $obj->getId();
                    $this->response->IdUsuario = $obj->getId();
                    $this->response->IdTipo = $obj->getIdTipo();
                    $this->response->NomeTipo = $obj->getNomeTipo();
                    $this->response->IdStatus = $obj->getIdStatus();
                    $this->response->NomeStatus = $obj->getNomeStatus();
                    $this->response->IdPerfil = $obj->getIdPerfil();
                    $this->response->NomePerfil = $obj->getNomePerfil();
                    $this->response->Conta = $obj->getConta(); 
					$this->response->Senha = $obj->getSenha();
                    $this->response->Email = $obj->getEmail();
                    $this->response->CPF = ($obj->getCPF())? Formatacao::formatarCPF($obj->getCPF()) : '' ;
                    $this->response->Nome = $obj->getNome();
                    $this->response->DataNascimento = ($obj->getDataNascimento()) ? Formatacao::formatarDataSQL($obj->getDataNascimento(), false) : '';
                    $this->response->Observacao = $obj->getObservacao();
                    $this->response->Telefone = $obj->getTelefone();
                    $this->response->Celular = $obj->getCelular();
                    $this->response->Ativo = ($obj->getAtivo())? 1: 0;
                    $this->response->DataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '';
                    $this->response->IdUsuarioAcao = $obj->getIdUsuarioAcao();
                    $this->response->NomeUsuarioAcao = $obj->getNomeUsuarioAcao();
                    $this->response->DataAcao = ($obj->getDataAcao()) ? Formatacao::formatarDataHoraSQL($obj->getDataAcao(), false) : '';
					$this->response->Imagem = $obj->getImagem();
					$this->response->IdPosto = $obj->getIdPosto();
					
                    $this->response->sucesso = 1;
                    $this->response->erro = 0;
                    $this->response->mensagem = "O Registro com Id: '$Id' foi encontrado com sucesso ";
                } else {
                    $this->response->mensagem = "Erro ao localizar o registro de Id: '$Id'.";
                }
                //if (($this->Config->Debug) || ($this->Usuario->Id==1)) $this->response->query = $daoUsuario->_query;
                $daoUsuario->Close();
            } else {
                $this->response->mensagem = "O identificador do registro é parametros um parametro obrigatório.";
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     *  Método para criar um novo registro
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function incluir() {
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            
            // Coletar parametros
            $Id=0;
			$Ativo = self::getVar('ativo');
            $IdTipo = self::getVar('idTipo', FILTER_SANITIZE_NUMBER_INT);
            $IdPerfil = self::getVar('idPerfil', FILTER_SANITIZE_NUMBER_INT);
            $Cpf = self::getVar('CPF');
            $Nome = self::getVar('nome');
            $DataNascimento = self::getVar('dataNascimento');
			$Email = self::getVar('email', FILTER_SANITIZE_EMAIL);
            $Conta = self::getVar('conta');
			$Senha = self::getVar('senha');
			$Senha2 = self::getVar('senha2');
            $Telefone = self::getVar('telefone');
            $Celular = self::getVar('celular');
            $Observacao = self::getVar('obs');
			$Imagem = self::getVar('Fotografia');
            
            $daoUsuario = new UsuarioDAO();

            // Validação de Campos 
            if(!$Nome) {
                $this->response->passo = 2;
                $this->response->mensagem = "Erro: O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }			
			
            if(!$IdTipo) {
                $this->response->passo = 2;
                $this->response->mensagem = "Erro: O campo <b>Tipo</b> é de preenchimento obrigatório.";
                return false;
            }
            if(!$IdPerfil) {
                $this->response->passo = 2;
                $this->response->mensagem = "Erro: O campo <b>Perfil</b> é de preenchimento obrigatório.";
                return false;
            }

            if(!$Conta) {
                $this->response->passo = 2;
                $this->response->mensagem = "Erro: O campo <b>Conta</b> é de preenchimento obrigatório.";
                return false;
            }			
			
            // Validação Contra Duplicidade de Email 
            if(!$Email) {
                $this->response->passo = 2;
                $this->response->mensagem = "Erro: O campo <b>Email</b> é de preenchimento obrigatório.";
                return false;
            } else if(!Validacao::validarEmail($Email)){
                $this->response->passo = 3;
                $this->response->mensagem = "Erro: O campo <b>Email</b> esta com valor inválido.";
                return false;
            } 
			
            if($DataNascimento)
                if (!Validacao::validarData($DataNascimento)){
					$this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> está com valor inválido. (Formato: dd/mm/yyyy)";
					return false;
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

            // Tem CPF ?
            /*
			if($CPF){
                if (!Validacao::validarCPF($CPF)){
                    $this->response->mensagem = "Erro: O campo <b>CPF</b> está com valor inválido. <br>Favor conferir o número na cópia do documento.";
                    $this->response->CPF = $CPF;
                    return false;
                }
            }
			*/
            // Verificar se alterou campo Chaves
            $obj1 = $daoUsuario->retornarPorEmail($Email);
            if ($obj1){
                if ($obj1->getId() != $Id){
                    $this->response->mensagem = "Erro: Este <b>Email</b> já foi utilizado por outra usuário. <br>Nome: <b>".$obj1->getNome()."</b>.";
                    $this->response->Email =$Email;
                    return false;
                }
            }
            
            // Proteção contra Conta Duplicada
            if ($Conta) {
                $obj1 = $daoUsuario->retornarPorConta($Conta);
                if ($obj1){
                    if ($obj1->getId() != $Id){
                        $this->response->mensagem = "Erro: Esta <b>Conta</b> já foi utilizado por outra usuário. <br>Nome: <b>".$obj1->getNome()."</b>.";
                        return false;
                    }
                }
            }
            
            // Proteção contra CPF Duplicada    
            /*
			if ($CPF) {
                $obj1 = $daoUsuario->retornarPorCPF($CPF);
                if ($obj1){
                    if ($obj1->getId() != $Id){
                        $this->response->mensagem = "Erro: Este <b>CPF</b> já foi utilizado por outra usuário. <br>Nome: <b>".$obj1->getNome()."</b>.";
                        $this->response->CPF = $CPF;
                        return false;
                    }
                }
            }
			*/
            // Proteção contra Chave Duplicada
			$Chave = UUID::v4();
            if ($Chave){
                $obj1 = $daoUsuario->retornarPorChave($Chave); // 2. Tentativa 
                if ($obj1){
                    $Chave = UUID::v4();
                    $obj1 = $daoUsuario->retornarPorChave($Chave); // 3. Tentativa 
                    if ($obj1){
                        $Chave = UUID::v4();
                    }
                }
            }
			
            // Regra específica 
            /*
			if ($IdTipo==1) {       // 1:Matriz
                $IdEmpresa = ($IdEmpresa)? $IdEmpresa : $IdEmpresa;
            } else if ($IdTipo==2) { // 2:Filial
                $IdEmpresa = ($IdEmpresa)? $IdEmpresa : $IdEmpresa;
            } else if ($IdTipo==3) { // 3:Filial
                $IdEmpresa = ($IdEmpresa)? $IdEmpresa : $IdEmpresa;
            } else if ($IdTipo==4) { // 4:Filial
                $IdEmpresa = ($IdEntidade)? $IdEntidade : $IdEmpresa;
            } else if ($IdTipo==5) { // 5:Filial
                $IdEmpresa = ($IdEntidade)? $IdEntidade : $IdEmpresa;
            } else if ($IdTipo==6) { // Filial
                $IdEmpresa = ($IdEmpresa)? $IdEmpresa : $IdEmpresa;
            } else {
                $IdEmpresa = $IdEmpresa;
                if ($IdEmpresa==1) {
                    $IdTipo=1;
                } else if ($IdEmpresa==2) {
                    $IdTipo=2;
                } else {
                    $eDAO = new EmpresaDAO();
                    $objEmpresa = $eDAO->retornar($IdEmpresa);
                    if ($objEmpresa){
                        if (($objEmpresa->getIdTipo()==11) || ($objEmpresa->getIdTipo()==12)){
                            $IdTipo=3;
                        }else if (($objEmpresa->getIdTipo()==21) || ($objEmpresa->getIdTipo()==22) || ($objEmpresa->getIdTipo()==23) || ($objEmpresa->getIdTipo()==24)){
                            $IdTipo=4;
                        } else {
                            $IdTipo=6;
                        }
                    } else {
                        $IdTipo=3;
                    }
                    $eDAO->Close();
                }
            }
			*/
            // Preparar para DB
            /*
			if (!$IdTipo){ $IdTipo = 6; }// Usuário
            if (!$IdEmpresa){ $IdEmpresa = null;}
            if (!$IdPessoa){ $IdPessoa = null;}
            if (!$IdPerfil){ $IdPerfil = null;}
            if (!$IdStatus){ $IdStatus = 1;} // Rascunho
            if (!$Ativo){ $Ativo = 1;} // Ativo
            $CPF = ($CPF)? Formatacao::limparFormatacao($CPF): null;
			*/
			// Buscando a imagem da fotografia do usuário
			$error = $_FILES["myfile"]["error"];
			if($error == UPLOAD_ERR_OK) {
				$ext = strtolower(substr($_FILES['myfile']['name'],-4)); 
				$new_name = $Conta."_".date("Ymd") . $ext;
				$tmp_name = $_FILES["myfile"]["tmp_name"];
				$dir = '/var/www/html/sistemas/mascaras/fotos/'; //'C:/bio/controlemascaras/fotos/';  
				move_uploaded_file($tmp_name, $dir . $new_name);
			}else{
				$response->mensagem = utf8_encode ("");
				$erroMsg .= ' Imagem não carregada, erro(s): ' . strtolower($error);
			}
			$file = ($tmp_name) ? 'fotos/' . trim ($new_name) : 'foto-vazia.jpg';
			
            $obj = new Usuario();
            $obj->setChave($Chave);
            $obj->setIdTipo($IdTipo);
            //$obj->setIdEmpresa($IdEmpresa);
           // $obj->setIdPessoa($IdPessoa);
            $obj->setConta($Conta);
            $obj->setNome($Nome);
            $obj->setCPF($Cpf);
            $obj->setEmail($Email);
            $obj->setDataNascimento(($DataNascimento)? Formatacao::formatarDataSQL($DataNascimento): null);
            $obj->setObservacao($Observacao);
            $obj->setTelefone($Telefone);
            $obj->setCelular($Celular);
            $obj->setIdPerfil($IdPerfil);
            $obj->setIdStatus(null);
            $obj->setAtivo($Ativo);
			$obj->setImagem($file);

            if ($daoUsuario->salvar($obj)){
                $IdUsuario = $obj->getId();

                //$daoUsuario->atualizarSenha($obj);
                // Cadastrar SENHA
                $usDAO = new UsuarioSenhaDAO();
                $objSenha = new UsuarioSenha();
                $objSenha->setIdUsuario($IdUsuario);
                $objSenha->setTentativa(0);
                $SenhaNova = $Senha;//$this->gerarSenha(6);
                $objSenha->setSenha(Criptografia::encode($SenhaNova));
                // Calcular Validade da Senha
                $DataAtual = date("d/m/Y");
                $Validade = DataHora::somaMes($DataAtual, 6); // Soma 6 meses a data atual 
                $Validade = Formatacao::formatarDataSQL($Validade, true). ' 23:59:59';
                $objSenha->setValidade($Validade);
                $objSenha->setBloqueado(0);
                $objSenha->setAtivo(1);
                $this->response->Validade = $Validade;
                if ($usDAO->salvar($objSenha)){
                    $sucessoSenha = 1;
                } else {
                    $sucessoSenha = 0;
                } 

				/*
                $Conteudo = "";
                $Conteudo .= "Olá <em>$Nome</em>!<br/>";
                $Conteudo .= "<br/>";
                $Conteudo .= "Seu cadastro foi realizado com sucesso. <br/>Abaixo estão seu e-mail e senha para acesso. <br/>Guarde-os em um local seguro.<br/>";
                $Conteudo .= "Email: $Email<br/>";
                $Conteudo .= "Senha: $SenhaNova<br/>";
                $Conteudo .= "<br/>";
                $Conteudo .= "Atenciosamente,<br/>";
                $Conteudo .= "<b>".$this->Config->Titulo."</b><br/>";
                $Conteudo .= $this->Config->URL."<br/>";
                $Conteudo .= "";
				*/
                if ($this->Config->Debug) {
                    $this->response->sucesso = 1;
                    $this->response->erro = 152;
                    $this->response->mensagem = "DEBUG: Usuário cadastrado com sucesso.";
                    if (!$sucessoSenha){
                        $this->response->mensagem .= "<br/> Mas ocorreu erro na criação da senha de acesso.";
                    }
                /*
				} else if ($Email) {
                    if (Email::enviar($Nome, $Email, '', 'Cadastro de usuário', $Conteudo)) {
                        $this->response->sucesso = 1;
                        $this->response->erro = 0;
                        $this->response->mensagem = "Usuário cadastrado com sucesso e senha foi enviada com sucesso para o email <b>$Email</b>.";
                        if (!$sucessoSenha){
                            $this->response->mensagem .= "<br/> Mas ocorreu erro na criação da senha de acesso.";                            
                        }
                    } else {
                        $this->response->sucesso = 1;
                        $this->response->erro = 164;
                        $this->response->mensagem = "Usuário cadastrado com sucesso, mas ocorreu erro no envio do email de senha.";
                        if (!$sucessoSenha){
                            $this->response->mensagem .= "<br/> Mas ocorreu erro na criação da senha de acesso.";                            
                        }
                        $this->response->mensagem .= "<br/>[".Email::getErro()." - ".Email::getMensagem()."]";
                    }
				*/
                } else {
                    $this->response->sucesso = 1;
                    $this->response->erro = 163;
                    $this->response->mensagem = "Usuário cadastrado com sucesso.";
                }
				
            } else {
                $this->response->mensagem = $daoUsuario->getMensagem();
            }
            $daoUsuario->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     * Método para editar um registro
     *
     * @return bool Se atualização relizada com sucesso
     */    
    public function editar() {
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
            
            $daoUsuario = new UsuarioDAO();
            //$daoPessoa = new PessoaDAO();

            // Coletar parametros
            $Id = self::getVar('IdUser', FILTER_SANITIZE_NUMBER_INT);
            $Ativo = (isset($_POST['ativo'])) ? 1 : 0;
			$IdTipo = self::getVar('idTipo', FILTER_SANITIZE_NUMBER_INT);
            $IdPerfil = self::getVar('idPerfil', FILTER_SANITIZE_NUMBER_INT);
			$Cpf = self::getVar('CPF');
            $Nome = self::getVar('nome');
            $DataNascimento = self::getVar('dataNascimento');
            $Email = self::getVar('email', FILTER_SANITIZE_EMAIL);
			$Conta = self::getVar('conta');
			$Senha = self::getVar('senha');
			$Senha2 = self::getVar('senha2');
            $Telefone = self::getVar('telefone');
            $Celular = self::getVar('celular');
            $Observacao = self::getVar('obs');
			
            $this->response->Id = $Id;
            $this->response->IdUsuarioAcao = self::getVar('IdUsuarioAcao', FILTER_SANITIZE_NUMBER_INT);			
			
			//$IdStatus = self::getVar('IdStatus', FILTER_SANITIZE_NUMBER_INT);
            //$IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            //$IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            //$IdEntidade = self::getVar('IdEntidade', FILTER_SANITIZE_NUMBER_INT);
            //$IdPessoa = self::getVar('IdPessoa', FILTER_SANITIZE_NUMBER_INT);
            //$Apelido = self::getVar('Apelido');
			//$Sexo = self::getVar('Sexo');
			//$Outro = self::getVar('Outro');			
            
            // Documentação das Pessoas
            /*
			$PIS = self::getVar('PIS');
            $RGNumero = self::getVar('RGNumero');
            $RGOrgao = self::getVar('RGOrgao');
            $RGData = self::getVar('RGData');
            $PassNumero = self::getVar('PassNumero');
            $PassValidade = self::getVar('PassValidade');
            $CRNumero = self::getVar('CRNumero');
            $CROrgao = self::getVar('CROrgao');
            $CRData = self::getVar('CRData');
            $BancoNumero = self::getVar('BancoNumero');
            $BancoAgencia = self::getVar('BancoAgencia');
            $BancoConta = self::getVar('BancoConta');
			*/
            
            // Validação de campos 
            if(!$Nome) {
                $this->response->passo = 2;
                $this->response->mensagem = "Erro: O campo <b>Nome</b> é de preenchimento obrigatório.";
                return false;
            }			
			
            if(!$Email) {
                $this->response->passo = 2;
                $this->response->mensagem = "Erro: O campo <b>Email</b> é de preenchimento obrigatório.";
                return false;
            } else if(!Validacao::validarEmail($Email)){
                $this->response->passo = 3;
                $this->response->mensagem = "Erro: O campo <b>Email</b> esta com valor inválido.";
                return false;
            } 

            if($DataNascimento) 
                if (!Validacao::validarData($DataNascimento)){
                $this->response->mensagem = "Erro: O campo <b>Data de Nascimento</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                return false;
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
                
            // Tem CPF ?
			/*
            if(!$CPF) {
                $this->response->mensagem = "Erro: O campo <b>CPF</b> é de preenchimento obrigatório.";
                $this->response->CPF = $CPF;
                return false;
            } else if (!Validacao::validarCPF($CPF)){
                $this->response->mensagem = "Erro: O campo <b>CPF</b> está com valor inválido. <br>Favor conferir o número na cópia do documento.";
                $this->response->CPF = $CPF;
                return false;
            }
            $CPF = Formatacao::limparFormatacao($CPF);
            $obj1 = $daoUsuario->retornarPorCPF($CPF);
            if ($obj1){
                if ($obj1->getId() != $Id){
                    $this->response->mensagem = "Erro: Este <b>CPF</b> já foi utilizado por outro usuário. <br>Nome: <b>".$obj1->getNome()."</b>.";
                    return false;
                }
            }
            $obj1 = null;
            */
            $obj = $daoUsuario->retornar($Id);
            if ($obj){

                // Verificar se alterou campo Chaves
                if ($Email != $obj->getEmail()){
                    $obj1 = $daoUsuario->retornarPorEmail($Email);
                    if ($obj1){
                        if ($obj1->getId() != $Id){
                            $this->response->mensagem = "Erro: Este <b>Email</b> já foi utilizado por outro usuário. <br>Nome: <b>".$obj1->getNome()."</b>.";
                            $this->response->Email =$Email;
                            return false;
                        }
                    }
                } 
                
                // Proteção contra Conta Duplicada
                if ($Conta) {
                    if ($Conta != $obj->getConta()){
                        $obj1 = $daoUsuario->retornarPorConta($Conta);
                        if ($obj1){
                            if ($obj1->getId() != $Id){
                                $this->response->mensagem = "Erro: Esta <b>Conta</b> já foi utilizado por outro usuário. <br>Nome: <b>".$obj1->getNome()."</b>.";
                                return false;
                            }
                        }
                    }
                }
                
                // Proteção contra CPF Duplicada
                /*
				if ($CPF) {
                    if ($CPF != $obj->getCPF()){
                        $obj1 = $daoUsuario->retornarPorCPF($CPF);
                        if ($obj1){
                            if ($obj1->getId() != $Id){
                                $this->response->mensagem = "Erro: Este <b>CPF</b> já foi utilizado por outro usuário. <br>Nome: <b>".$obj1->getNome()."</b>.";
                                $this->response->CPF = $CPF;
                                return false;
                            }
                        } else {
                            $obj1 = $daoPessoa->retornarPorCPF($CPF);
                            if ($obj1){
                                if ($obj1->getId() != $IdPessoa){
                                    $this->response->mensagem = "Erro: Este <b>CPF</b> já foi utilizado por outra pessoa. <br>Nome: <b>".$obj1->getNome()."</b>.";
                                    $this->response->CPF = $CPF;
                                    return false;
                                }
                            }                            
                        }
                    }
                }
				*/
                // Proteção contra Chave Duplicada
                if(!$obj->getChave()){
                    $Chave = UUID::v4();
                    if ($Chave){
                        $obj1 = $daoUsuario->retornarPorChave($Chave); // 2. Tentativa 
                        if ($obj1){
                            $Chave = UUID::v4();
                            $obj1 = $daoUsuario->retornarPorChave($Chave); // 3. Tentativa 
                            if ($obj1){
                                $Chave = UUID::v4();
                            }
                        }
                    }
                }
                /*
                $this->response->IdEmpresa = $IdEmpresa;
                // Regra específica 
                if ($IdTipo==1) {       // 1:Matriz
                    $IdEmpresa = ($IdEmpresa)? $IdEmpresa : $IdEmpresa;
                } else if ($IdTipo==2) { // 2:Filial
                    $IdEmpresa = ($IdEmpresa)? $IdEmpresa : $IdEmpresa;
                } else if ($IdTipo==3) { // 3:Filial
                    $IdEmpresa = ($IdEmpresa)? $IdEmpresa : $IdEmpresa;
                } else if ($IdTipo==4) { // 4:Filial
                    $IdEmpresa = ($IdEntidade)? $IdEntidade : $IdEmpresa;
                } else if ($IdTipo==5) { // 5:Filial
                    $IdEmpresa = ($IdEntidade)? $IdEntidade : $IdEmpresa;
                } else if ($IdTipo==6) { // Filial
                    $IdEmpresa = ($IdEmpresa)? $IdEmpresa : $IdEmpresa;
                } else {
                    $IdEmpresa = $IdEmpresa;
                    if ($IdEmpresa==1) {
                        $IdTipo=1;
                    } else if ($IdEmpresa==2) {
                        $IdTipo=2;
                    } else {
                        $eDAO = new EmpresaDAO();
                        $objEmpresa = $eDAO->retornar($IdEmpresa);
                        if ($objEmpresa){
                            if (($objEmpresa->getIdTipo()==11) || ($objEmpresa->getIdTipo()==12)){
                                $IdTipo=3;
                            }else if (($objEmpresa->getIdTipo()==21) || ($objEmpresa->getIdTipo()==22) || ($objEmpresa->getIdTipo()==23) || ($objEmpresa->getIdTipo()==24)){
                                $IdTipo=4;
                            } else {
                                $IdTipo=6;
                            }
                        } else {
                            $IdTipo=3;
                        }
                        $eDAO->Close();
                    }
                }
                
                $this->response->IdEmpresa2 = $IdEmpresa;
                // Preparar para o BD
                //if (!$Chave) $Chave = UUID::v4();
                if (!$IdTipo){ $IdTipo = 4;} // Atleta
                if (!$IdEmpresa){ $IdEmpresa = null;}
                if (!$IdPessoa){ $IdPessoa = null;}
                if (!$IdPerfil){ $IdPerfil = null;}
                if (!$IdStatus){ $IdStatus = 1; }// Rascunho
                if (!$Ativo){ $Ativo = 1; }// Ativo
                $CPF = ($CPF)? Formatacao::limparFormatacao($CPF): null;
				*/
                if(!$obj->getChave()) $obj->setChave($Chave);
                $obj->setIdTipo($IdTipo);
                //$obj->setIdEmpresa($IdEmpresa);
                //$obj->setIdPessoa($IdPessoa);
                $obj->setConta($Conta);
                $obj->setEmail($Email);
                $obj->setNome($Nome);
                $obj->setCPF($Cpf);
                $obj->setDataNascimento(($DataNascimento)? Formatacao::formatarDataSQL($DataNascimento): null);
                $obj->setObservacao($Observacao);
                $obj->setTelefone($Telefone);
                $obj->setCelular($Celular);
                $obj->setAtivo($Ativo);
				$obj->setIdStatus(null);

                if ($Id > 1){ // Gerente e Admin - NÃO ALTERA PERFIL
                    if ($IdPerfil>0){
                        $obj->setIdPerfil($IdPerfil);
                    }
                }
				//Verificar se trocou fotografia
				$error = $_FILES["myfile"]["error"];
				if($error == UPLOAD_ERR_OK) {
					$ext = strtolower(substr($_FILES['myfile']['name'],-4)); 
					$new_name = $Conta."_".date("YmdHis") . $ext;
					$tmp_name = $_FILES["myfile"]["tmp_name"];
					$dir = '/var/www/html/sistemas/mascaras/fotos/'; //'C:/bio/controlemascaras/fotos/';  
					move_uploaded_file($tmp_name, $dir . $new_name);
				}else{
					$response->mensagem = utf8_encode ("");
					$erroMsg .= ' Imagem não carregada, erro(s): ' . strtolower($error);
				}
				
				$file = ($tmp_name) ? 'fotos/' . trim ($new_name) : $obj->getImagem();
				$obj->setImagem($file);
				///////
				
				//Atualizar registro
                if ($daoUsuario->atualizar($obj)){
					$IdUsuario = $obj->getId();
					$usDAO = new UsuarioSenhaDAO();
					$objSenha = $usDAO->retornar($IdUsuario);
					if ($objSenha){
						//Verificar se trocou a senha
						if ($Senha <> $objSenha->getSenha()){
							$SenhaNova = $Senha;
							$objSenha->setSenha(Criptografia::encode($SenhaNova));
							if($usDAO->atualizar($objSenha)){
								$this->response->sucesso = 1;
							}else{
								$this->response->mensagem = "Senha não atualizado.";
							}								
							
						}
					}else{
						$this->response->mensagem = "Senha não encontrada.";
					}
					$usDAO->Close();
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "Usuário atualizado com sucesso.";
					
					/*
					$IdPessoa = $obj->getIdPessoa();
                    $ERRO_NOTAS = '';
                    $this->response->IdPessoa = $IdPessoa;
                    
                    if ($obj->getId()==$this->Usuario->Id) { // Esta atualizando seu próprios dados
                        
                        if ($obj->getIdPessoa()) {
                            // Critica exclusiva para Pessoas
                            // Validar outras Datas
                            if($RGData) {
                                if (!Validacao::validarData($RGData)){
                                    $this->response->mensagem = "Erro: O campo <b>Data de Emissão do RG</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                                    return false;
                                }
                            }
                            if($PassValidade) {
                                if (!Validacao::validarData($PassValidade)){
                                    $this->response->mensagem = "Erro: O campo <b>Data de Validade do Passaporte</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                                    return false;
                                }
                            }
                            if($CRData) {
                                if (!Validacao::validarData($CRData)){
                                    $this->response->mensagem = "Erro: O campo <b>Data de Emissão do Certificado de Reservista</b> está com valor inválido. (Formato: dd/mm/yyyy)";
                                    return false;
                                }
                            }
                            
                            $daoPessoa = new PessoaDAO();
                            $objPessoa = $daoPessoa->retornar($IdPessoa);
                            if ($objPessoa){                        

                                $IdNacionalidade = self::getVar('IdNacionalidade', FILTER_SANITIZE_NUMBER_INT);
                                $UFNaturalidade = self::getVar('UFNaturalidade');
                                $Naturalidade = self::getVar('Naturalidade');
                                $Mae = self::getVar('Mae');
                                $Pai = self::getVar('Pai');

                                $IdEscolaridade = self::getVar('IdEscolaridade', FILTER_SANITIZE_NUMBER_INT);
                                $Instituicao = self::getVar('Instituicao');
                                $Idioma = self::getVar('Idioma');
                                //$Observacao = self::getVar('Observacao');

                                // Proteção Residencial
                                $IdEndereco1 = self::getVar('IdEndereco1', FILTER_SANITIZE_NUMBER_INT);
                                $Tipo1 = self::getVar('Tipo1');
                                $Descricao1 = self::getVar('Descricao1'); // 'Residencial'
                                $Logradouro1 = self::getVar('Logradouro1');
                                $Numero1 = self::getVar('Numero1');
                                $Complemento1 = self::getVar('Complemento1');
                                $Bairro1 = self::getVar('Bairro1');
                                $IdCidade1 = self::getVar('IdCidade1', FILTER_SANITIZE_NUMBER_INT);
                                $Cidade1 = self::getVar('Cidade1');
                                $CEP1 = self::getVar('CEP1');
                                $UF1 = self::getVar('UF1');
                                $IdPais1 = self::getVar('IdPais1', FILTER_SANITIZE_NUMBER_INT);
                                $Observacao1 = self::getVar('Observacao1');

                                // Proteção Residencial
                                $IdEndereco2 = self::getVar('IdEndereco2', FILTER_SANITIZE_NUMBER_INT);
                                $Tipo2 = self::getVar('Tipo2');
                                $Descricao2 = self::getVar('Descricao2'); // 'Residencial'
                                $Logradouro2 = self::getVar('Logradouro2');
                                $Numero2 = self::getVar('Numero2');
                                $Complemento2 = self::getVar('Complemento2');
                                $Bairro2 = self::getVar('Bairro2');
                                $IdCidade2 = self::getVar('IdCidade2', FILTER_SANITIZE_NUMBER_INT);
                                $Cidade2 = self::getVar('Cidade2');
                                $CEP2 = self::getVar('CEP2');
                                $UF2 = self::getVar('UF2');
                                $IdPais2 = self::getVar('IdPais2', FILTER_SANITIZE_NUMBER_INT);
                                $Observacao2 = self::getVar('Observacao2');                           

                                // Proteção de Dados
                                if(!$Descricao1) {$Descricao1 = 'Residencial';}
                                if(!$IdCidade1) {$IdCidade1 = null;}
                                if(!$IdPais1) {$IdPais1 = null;}
                                if(!$Descricao2) {$Descricao2 = 'Residencial';}
                                if(!$IdCidade2) {$IdCidade2 = null;}
                                if(!$IdPais2) {$IdPais2 = null;}

                                // Atualizar Campos
                                $objPessoa->setNome($Nome);
                                $objPessoa->setApelido($Apelido);
                                $objPessoa->setSexo($Sexo);
                                $objPessoa->setDataNascimento(($DataNascimento) ? Formatacao::formatarDataSQL($DataNascimento) : null);
                                $objPessoa->setIdNacionalidade(($IdNacionalidade)? $IdNacionalidade: null);
                                $objPessoa->setUFNaturalidade(($UFNaturalidade)? $UFNaturalidade: null);
                                $objPessoa->setNaturalidade($Naturalidade);
                                $objPessoa->setMae($Mae);
                                $objPessoa->setPai($Pai);

                                $objPessoa->setTelefone($Telefone);
                                $objPessoa->setCelular($Celular);
                                $objPessoa->setOutro($Outro);
                                $objPessoa->setEmail($Email);

                                $objPessoa->setCPF(($CPF)? $CPF: null);
                                $objPessoa->setPIS($PIS);
                                $objPessoa->setRGNumero($RGNumero);
                                $objPessoa->setRGOrgao($RGOrgao);
                                $objPessoa->setRGData(($RGData) ? Formatacao::formatarDataSQL($RGData) : null);
                                $objPessoa->setPassNumero($PassNumero);
                                $objPessoa->setPassValidade(($PassValidade) ? Formatacao::formatarDataSQL($PassValidade) : null);
                                $objPessoa->setCRNumero($CRNumero);
                                $objPessoa->setCROrgao($CROrgao);
                                $objPessoa->setCRData(($CRData) ? Formatacao::formatarDataSQL($CRData) : null);

                                $objPessoa->setBancoNumero($BancoNumero);
                                $objPessoa->setBancoAgencia($BancoAgencia);
                                $objPessoa->setBancoConta($BancoConta);

                                $objPessoa->setIdEscolaridade(($IdEscolaridade)? $IdEscolaridade: null);
                                $objPessoa->setInstituicao($Instituicao);
                                $objPessoa->setIdioma($Idioma);
                                $objPessoa->setObservacao($Observacao);

                                // Atualizar Dados Principais
                                if ($daoPessoa->atualizar($objPessoa)){
                                    $ERRO_NOTAS .= "<br/>Dados Pessoais: Atualizado com sucesso.";

                                    $daoEndereco = new EnderecoDAO();
                                    // Endereço Residencial
                                    $objEndereco = $daoEndereco->retornar($IdEndereco1);
                                    if ($objEndereco) {
                                        //$objEndereco->setTipo($Tipo1);
                                        //$objEndereco->setDescricao($Descricao1);
                                        $objEndereco->setLogradouro($Logradouro1);
                                        $objEndereco->setNumero($Numero1);
                                        $objEndereco->setComplemento($Complemento1);
                                        $objEndereco->setBairro($Bairro1);
                                        $objEndereco->setCEP($CEP1);
                                        $objEndereco->setIdCidade(($IdCidade1)? $IdCidade1: null);
                                        $objEndereco->setCidade($Cidade1);
                                        $objEndereco->setIdPais(($IdPais1)? $IdPais1: null);
                                        $objEndereco->setUF(($UF1)? $UF1: null);
                                        if ($daoEndereco->atualizar($objEndereco)){
                                            $ERRO_NOTAS .= "<br/>Endereço Residencial: Atualizado com sucesso.";
                                        } else {
                                            $ERRO_NOTAS .= "<br/>Endereço Residencial: Erro ao atualizar.";
                                        }
                                    } else {
                                        $objEndereco = new Endereco();
                                        $objEndereco->setIdPessoa($Id);
                                        $objEndereco->setTipo(1);
                                        $objEndereco->setDescricao(($Descricao1)? $Descricao1: 'Residencial');
                                        $objEndereco->setLogradouro($Logradouro1);
                                        $objEndereco->setNumero($Numero1);
                                        $objEndereco->setComplemento($Complemento1);
                                        $objEndereco->setBairro($Bairro1);
                                        $objEndereco->setCEP($CEP1);
                                        $objEndereco->setIdCidade(($IdCidade1)? $IdCidade1: null);
                                        $objEndereco->setCidade($Cidade1);
                                        $objEndereco->setIdPais(($IdPais1)? $IdPais1: null);
                                        $objEndereco->setUF(($UF1)? $UF1: null);
                                        if ($daoEndereco->salvar($objEndereco)){
                                            $ERRO_NOTAS .= "<br/>Endereço Residencial: Cadastrado com sucesso.";
                                        } else {
                                            $ERRO_NOTAS .= "<br/>Endereço Residencial: Erro ao cadastradar.";
                                        }
                                    }

                                    // Endereço Comercial
                                    $objEndereco = $daoEndereco->retornar($IdEndereco2);
                                    if ($objEndereco) {
                                        //$objEndereco->setTipo($Tipo2);
                                        //$objEndereco->setDescricao($Descricao2);
                                        $objEndereco->setLogradouro($Logradouro2);
                                        $objEndereco->setNumero($Numero2);
                                        $objEndereco->setComplemento($Complemento2);
                                        $objEndereco->setBairro($Bairro2);
                                        $objEndereco->setCEP($CEP2);
                                        $objEndereco->setIdCidade(($IdCidade2)? $IdCidade2: null);
                                        $objEndereco->setCidade($Cidade2);
                                        $objEndereco->setIdPais(($IdPais2)? $IdPais2: null);
                                        $objEndereco->setUF(($UF2)? $UF2: null);
                                        if ($daoEndereco->atualizar($objEndereco)){
                                            $ERRO_NOTAS .= "<br/>Endereço Comercial: Atualizado com sucesso.";
                                        } else {
                                            $ERRO_NOTAS .= "<br/>Endereço Comercial: Erro ao atualizar.";
                                        }
                                    } else {
                                        $objEndereco = new Endereco();
                                        $objEndereco->setIdPessoa($Id);
                                        $objEndereco->setTipo(2);
                                        $objEndereco->setDescricao(($Descricao2)? $Descricao2: 'Comercial');
                                        $objEndereco->setLogradouro($Logradouro2);
                                        $objEndereco->setNumero($Numero2);
                                        $objEndereco->setComplemento($Complemento2);
                                        $objEndereco->setBairro($Bairro2);
                                        $objEndereco->setCEP($CEP2);
                                        $objEndereco->setIdCidade(($IdCidade2)? $IdCidade2: null);
                                        $objEndereco->setCidade($Cidade2);
                                        $objEndereco->setIdPais(($IdPais2)? $IdPais2: null);
                                        $objEndereco->setUF(($UF2)? $UF2: null);
                                        if ($daoEndereco->salvar($objEndereco)){
                                            $ERRO_NOTAS .= "<br/>Endereço Comercial: Cadastrado com sucesso.";
                                        } else {
                                            $ERRO_NOTAS .= "<br/>Endereço Comercial: Erro ao cadastradar.";
                                        }
                                    }
                                    $daoEndereco->Close();
                                } else {
                                    $ERRO_NOTAS .= "<br/>Dados Pessoais: ".$daoPessoa->getMensagem();
                                }                          
                            } else {
                                $ERRO_NOTAS .= "<br/>Mas ocorreu erro ao localizar o registro de IdPessoa: '$IdPessoa'.";
                            }
                            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->mensagem .= $ERRO_NOTAS;}
                        } else{
                            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->mensagem .= "<br/>(IdPessoa=$IdPessoa)";}
                        }
                    }
                    */    
                } else {
                    $this->response->mensagem = $daoUsuario->getMensagem();
                }
                //if ((isset($this->Config->Debug))&&(isset($this->Usuario->Id))){ if (($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $daoUsuario->_query; }}
            } else {
                $this->response->mensagem = "Erro ao localizar o registro de Id: '$IdUsuario'.";
            }
            $daoUsuario->Close();
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
                $DAO = new UsuarioDAO();
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
        // Parametros do DataTable
        $page = self::getVar('iDisplayStart');
        $rows = self::getVar('iDisplayLength');
        $sidx = self::getVar('sidx');
        $sord = self::getVar('sord');
        $sEcho = self::getVar('sEcho');
        
        try {
            /** Ordering */
            $aColumns = array(0=>'img', 1=>'id_usuario', 2=>'u.nome', 3=>'u.email', 4=>'t.nome', 5=>'u.id_perfil', 6=>'p.nome', 7=>'u.ativo' );
            $sOrder = "";
            if (isset($_GET['iSortCol_0'])){
                $iSortCol_0 = self::getVar('iSortCol_0');
                $bSortable = 'bSortable_'.$iSortCol_0;
                if (self::getVar($bSortable)=='true'){
                    $sidx = $aColumns[intval($iSortCol_0)];
                    $sord = self::getVar('sSortDir_0');
                } 
            } else {
                $sidx = 'id_usuario';
                $sord = 'desc';
            }
            $this->response->sidx = $sidx;
            $this->response->sord = $sord;
            $this->response->sOrder = $sOrder;
            
            // Parametros do Filtro
            $IdTipo = self::getVar('tipo', FILTER_SANITIZE_NUMBER_INT);
            $IdPerfil = self::getVar('perfil', FILTER_SANITIZE_NUMBER_INT);
            $Nome = self::getVar('nome');

            $daoUsuario = new UsuarioDAO();
            $listagem = $daoUsuario->listar($page, $rows, $sidx, $sord, $Nome, $IdTipo, $IdPerfil);
            if ($listagem) {
                $this->response->page = ($daoUsuario->getPaginaAtual()) ? $daoUsuario->getPaginaAtual(): 1; // 1; 
                $this->response->total = ($daoUsuario->getTotalPaginas()) ? $daoUsuario->getTotalPaginas(): 1; // 1; 
                $this->response->records = ($daoUsuario->getTotalRegistros()) ? $daoUsuario->getTotalRegistros(): count($listagem); // count($listagem);

                $i = 0;
                foreach ($listagem as $item){
                    $DataNascimento = ($item->getDataNascimento()) ? Formatacao::formatarDataSQL($item->getDataNascimento(), false) : '';
                    //$DataAcesso = ($item->getDataAcesso()) ? Formatacao::formatarDataHoraSQL($item->getDataAcesso(), false) : '';
                    $bt_view = '<a class="btn btn-vazio btn-sm btn-grid" title="Visualizar usuário: '.$item->getNome().'" onclick="visualizar('.$item->getId().');"><span class="glyphicon glyphicon-search"></span>';
					$email = ($item->getEmail()) ? '<span class="label label-default">'. $item->getEmail().'</span>': '';
					
                    $this->response->aaData[$i] = array($bt_view, $item->getId(), $item->getNome().'<br/>'.$email, $item->getNomeTipo(), $item->getNomePerfil(), ($item->getAtivo())? 'SIM': 'NÃO');
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
            if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $daoUsuario->_query; }
            $daoUsuario->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }

    /**
     * Método para listar registro para um ComboBox
     *
     * @return array Retornar o array rows[] = {{value:'', text:''},...}
     */    
    public function listarCombo() {
        try {
            $IdTipo = self::getVar('IdTipo', FILTER_SANITIZE_NUMBER_INT);
            $IdEmpresa = self::getVar('IdEmpresa', FILTER_SANITIZE_NUMBER_INT);
            $IdPessoa = self::getVar('IdPessoa', FILTER_SANITIZE_NUMBER_INT);
            $IdPerfil = self::getVar('IdPerfil', FILTER_SANITIZE_NUMBER_INT);
            $IdStatus = self::getVar('IdStatus', FILTER_SANITIZE_NUMBER_INT);
            
            $this->response->IdTipo = $IdTipo;
            $this->response->IdEmpresa = $IdEmpresa;
            $this->response->IdPessoa = $IdPessoa;
            $this->response->IdPerfil = $IdPerfil;
            $this->response->IdStatus = $IdStatus;
        
            $i = 0;
            if ($IdPerfil){
                $daoUsuario = new UsuarioPerfilDAO();
                $listagem = $daoUsuario->listar($page, $rows, $sidx, $sord, $IdTipo, $IdStatus, $IdEmpresa, $IdPessoa, '', '', '', '', $IdPerfil);
                if ($listagem) {
                    $this->response->records = count($listagem);
                    foreach ($listagem as $item){
                        $this->response->rows[$i]['value'] = intval($item->getId());
                        $this->response->rows[$i]['text'] = $item->getNomeUsuario();
                        $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                        $i++;
                    }
                    $this->response->sucesso=1;
                }else{
                    $this->response->records = 0;
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $daoUsuario->_query; }
                $daoUsuario->Close();
            } else {
                $daoUsuario = new UsuarioDAO();
                $listagem = $daoUsuario->listar('', '', 'nome', 'asc', $IdTipo, $IdStatus, $IdEmpresa, $IdPessoa, '', '', '', '', $IdPerfil);
                if ($listagem) {
                    $this->response->records = count($listagem);
                    foreach ($listagem as $item){
                        $this->response->rows[$i]['value'] = intval($item->getId());
                        $this->response->rows[$i]['text'] = $item->getNome().' ('.$item->getEmail().')';
                        $this->response->rows[$i]['activated'] = ($item->getAtivo())? 1: 0;
                        $i++;
                    }
                    $this->response->sucesso=1;
                }else{
                    $this->response->records = 0;
                }
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $daoUsuario->_query; }
                $daoUsuario->Close();
            }            
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
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

                $daoUsuario = new UsuarioDAO();
                $rows = $daoUsuario->contar(null, null, null, null, $CPF);
                $this->response->rows = $rows;
                if ($rows > 1){
                    $this->response->mensagem = "O <b>CPF: $CPF</b> já foi utilizado por $rows pessoas.";
                } else if ($rows==1){
                    $obj1 = $daoUsuario->retornarPorCPF($CPF);
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
                if ((isset($this->Config->Debug))&&(isset($this->Usuario->Id))){ if (($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $daoUsuario->_query; }}
                $daoUsuario->Close();
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
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
            $this->response->trace=1;
            if(!$Email) {
                $this->response->trace=2;
                $this->response->mensagem = "O campo <b>Email</b> é de preenchimento obrigatório.";
            } else if (!Validacao::validarEmail($Email)){
            //}else if (filter_var($Email, FILTER_VALIDATE_EMAIL) === false) {
                $this->response->trace=3;
                $this->response->mensagem = "O campo <b>e-mail</b> está com valor inválido.";
            } else {
                $this->response->trace=4;
                $daoUsuario = new UsuarioDAO();
                $rows = $daoUsuario->contar(null, null, null, null, null, $Email);
                $this->response->rows = $rows;
                if ($rows > 1){
                    $this->response->mensagem = "O <b>e-mail: $Email</b> já foi utilizado por $rows usuários.";
                } else if ($rows==1){
                    $obj1 = $daoUsuario->retornarPorEmail($Email);
                    if ($obj1){
                        if ($obj1->getId() != $Id){
                            $this->response->mensagem = "O <b>e-mail: $Email</b> já foi utilizado por outro usuário. (<b>".$obj1->getNome()."</b>)";
                        } else {
                            $this->response->sucesso = 1;
                            $this->response->mensagem = "O <b>e-mail: $Email</b> só esta sendo utilizado por um usuário. (<b>".$obj1->getNome().")";
                        }
                    } else {
                        $this->response->mensagem = "Ao tentar localizar o usuário que utiliza o <b>e-mail: $Email</b>.";
                    }
                } else {
                    $this->response->sucesso = 1;
                    $this->response->mensagem = "O <b>e-mail: $Email</b> não esta sendo utilizado por outro usuário.";
                }
                if ((isset($this->Config->Debug))&&(isset($this->Usuario->Id))){ if (($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $daoUsuario->_query; }}
                $daoUsuario->Close();
            }
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
       
    /**
     * Método para enviar uma Email com a senha do usuário
     *
     * @return bool true|false Se validado com sucesso
     */    
    public function enviarSenha(){
        try {
            $Email = self::getVar('Email', FILTER_SANITIZE_EMAIL);
            $DataNascimento = self::getVar('DataNascimento');

            if(Validacao::validarEmail($Email)){
                $this->response->passo = 0;

                if (Validacao::validarData($DataNascimento)){
                    $this->response->passo = 2;

                    $daoUsuario = new UsuarioDAO();
                    $obj = $daoUsuario->retornarPorEmail($Email);
                    if ($obj){
                        $this->response->passo = 3;

                        $dtNascimento = Formatacao::formatarDataSQL($obj->getDataNascimento(), false);
                        if ($DataNascimento == $dtNascimento) {
                            $this->response->passo = 4;
                            $IdUsuario = $obj->getId();
                            $Nome = $obj->getNome();
                            $Senha = ''; //$obj->getSenha();

                            $daoSenha = new UsuarioSenhaDAO();
                            $objUsuarioSenha = $daoSenha->retornarUltima($IdUsuario);
                            if ($objUsuarioSenha) {
                                $this->response->passo = 5;
                                $SenhaSecreta = $objUsuarioSenha->getSenha();
                                $Senha = Criptografia::decode($SenhaSecreta);
                                $this->response->SenhaSecreta = $SenhaSecreta;
                            } else {
                                $Senha = '[não encontrada]';
                            }
                            $daoSenha->Close();
                            $this->response->passo = 6;

                            $Conteudo = "";
                            $Conteudo .= "Olá <em>$Nome</em>!<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "Seu lembrete foi enviado com sucesso. Abaixo estão seu e-mail e senha para acesso. Guarde-os em um local seguro.<br/>";
                            $Conteudo .= "Email: $Email<br/>";
                            $Conteudo .= "Senha: $Senha<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "Atenciosamente,<br/>";
                            $Conteudo .= "<b>".$this->Config->Titulo."</b><br/>";
                            $Conteudo .= $this->Config->URL."<br/>";
                            $Conteudo .= "";

                            if ($this->Config->Debug) {
                                $this->response->sucesso = 1;
                                $this->response->erro = 0;
                                $this->response->mensagem = "DEBUG: Operação realizada com sucesso.";
                            } else {
                                if (Email::enviar($Nome, $Email, '', 'Lembrete', $Conteudo)) {
                                    $this->response->sucesso = 1;
                                    $this->response->erro = 0;
                                    $this->response->mensagem = "<b>$Nome</b>, sua senha foi enviada com sucesso para o e-mail: <b>$Email</b>";
                                } else {
                                    $this->response->erro = 55;
                                    $this->response->mensagem = "Erro no envio de e-mail: $Email";
                                    $this->response->mensagem .= "<br/>[".Email::getErro()." - ".Email::getMensagem()."]";
                                }
                            }
                        } else {
                            $this->response->erro = 56;
                            $this->response->mensagem = "A data de nascimento '<b>$DataNascimento</b>' não corresponde a este e-mail em nosso cadastro.";
                            //$this->response->mensagem .= "(DataNascimento=$DataNascimento) (dt=$dtNascimento)";
                            //if ((isset($this->Config->Debug))&&(isset($this->Usuario->Id))){ if (($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->mensagem .= "(DataNascimento=$DataNascimento) (dt=$dtNascimento)"; }}
                        }
                    } else {
                        $this->response->erro = 57;
                        $this->response->mensagem = "O e-mail '<b>$Email</b>' não faz parte de nosso cadastro.";
                    }
                    $daoUsuario->Close();
                } else {
                    $this->response->erro = 58;
                    $this->response->mensagem = "A data de nascimento '<b>$DataNascimento</b>' está com o formato inválido.";
                }
            } else {
                $this->response->erro = 59;
                $this->response->mensagem = "O e-mail '<b>$Email</b>' está com o formato inválido.";
            }
                
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     * Método para enviar uma Email com a senha do usuário
     *
     * @return bool true|false Se validado com sucesso
     */    
    public function enviarAtivacao(){
        try {
            $Email = self::getVar('Email', FILTER_SANITIZE_EMAIL);
            $DataNascimento = self::getVar('DataNascimento');

            if(Validacao::validarEmail($Email)){
                $this->response->passo = 0;

                if (Validacao::validarData($DataNascimento)){
                    $this->response->passo = 2;

                    $daoUsuario = new UsuarioDAO();
                    $obj = $daoUsuario->retornarPorEmail($Email);
                    if ($obj){
                        $this->response->passo = 3;

                        $dtNascimento = Formatacao::formatarDataSQL($obj->getDataNascimento(), false);
                        if ($DataNascimento == $dtNascimento){
                            $this->response->passo = 4;
                            $IdUsuario = $obj->getId();
                            $Chave = $obj->getChave();
                            $Nome = $obj->getNome();
                            $Senha = ''; //$obj->getSenha();

                            $daoSenha = new UsuarioSenhaDAO();
                            $objUsuarioSenha = $daoSenha->retornarUltima($IdUsuario);
                            if ($objUsuarioSenha) {
                                $this->response->passo = 5;
                                $SenhaSecreta = $objUsuarioSenha->getSenha();
                                $Senha = Criptografia::decode($SenhaSecreta);
                                $this->response->SenhaSecreta = $SenhaSecreta;
                            } else {
                                $Senha = '[não encontrada]';
                            }
                            $daoSenha->Close();
                            $this->response->passo = 6;

                            $Link = " https://www.".$this->Config->URL."/at.php?u=$IdUsuario&k=$Chave";
                            $Conteudo = "";
                            $Conteudo .= "Olá <em>$Nome</em>!<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "Seu cadastro foi realizado com sucesso. <br/>Abaixo estão seu e-mail e senha para acesso. <br/>Guarde-os em um local seguro.<br/>";
                            $Conteudo .= "Email: $Email<br/>";
                            $Conteudo .= "Senha: $Senha<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "Clique no link para ativar o sua conta: $Link";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "Atenciosamente,<br/>";
                            $Conteudo .= "<b>".$this->Config->Titulo."</b><br/>";
                            $Conteudo .= $this->Config->URL."<br/>";
                            $Conteudo .= "";

                            if ($this->Config->Debug) {
                                $this->response->sucesso = 1;
                                $this->response->erro = 0;
                                $this->response->mensagem = "DEBUG: Operação realizada com sucesso.";
                            } else {
                                if (Email::enviar($Nome, $Email, '', 'Ativação', $Conteudo)) {
                                    $this->response->sucesso = 1;
                                    $this->response->erro = 0;
                                    $this->response->mensagem = "<b>$Nome</b>, sua senha foi enviada com sucesso para o e-mail: <b>$Email</b>";
                                } else {
                                    $this->response->erro = 55;
                                    $this->response->mensagem = "Erro no envio de e-mail: $Email";
                                    $this->response->mensagem .= "<br/>[".Email::getErro()." - ".Email::getMensagem()."]";
                                }
                            }
                        } else {
                            $this->response->erro = 56;
                            $this->response->mensagem = "A data de nascimento '<b>$DataNascimento</b>' não corresponde a este e-mail em nosso cadastro.";
                            //$this->response->mensagem .= "(DataNascimento=$DataNascimento) (dt=$dtNascimento)";
                            //if ((isset($this->Config->Debug))&&(isset($this->Usuario->Id))){ if (($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->mensagem .= "(DataNascimento=$DataNascimento) (dt=$dtNascimento)"; }}
                        }
                    } else {
                        $this->response->erro = 57;
                        $this->response->mensagem = "O e-mail '<b>$Email</b>' não faz parte de nosso cadastro.";
                    }
                    $daoUsuario->Close();
                } else {
                    $this->response->erro = 58;
                    $this->response->mensagem = "A data de nascimento '<b>$DataNascimento</b>' está com o formato inválido.";
                }
            } else {
                $this->response->erro = 59;
                $this->response->mensagem = "O e-mail '<b>$Email</b>' está com o formato inválido.";
            }
                
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     * Método para uma Pessoa como Usuário do sistema
     *
     * @return bool true|false Se cadastrado com sucesso
     */    
    public function cadastrarPessoa(){
        try {
            $Email = self::getVar('Email', FILTER_SANITIZE_EMAIL);
            $CPF = self::getVar('CPF');
            $Matricula = self::getVar('Matricula');
            $DataNascimento = self::getVar('DataNascimento');
            
            // Validação dos formatos dos Campos 
            $CPF = ($CPF) ? Formatacao::limparFormatacao($CPF): null;
            $Matricula = (is_numeric($Matricula)) ? intval($Matricula): 0;
            
            if (($Email) || ($CPF)){
                if ($Email) {
                    if(!Validacao::validarEmail($Email)){
                        $this->response->passo = 0;
                        $this->response->erro = 59;
                        $this->response->mensagem = "O e-mail: '<b>$Email</b>' está com o formato inválido.";
                        return false;
                    }
                } else {
                    if(!Validacao::validarCPF($CPF)){
                        $this->response->passo = 0;
                        $this->response->erro = 57;
                        $this->response->mensagem = "O CPF: '<b>$Email</b>' está com o formato inválido.";
                        return false;
                    }
                }
                if (!Validacao::validarData($DataNascimento)){
                    $this->response->erro = 58;
                    $this->response->mensagem = "A data de nascimento '<b>$DataNascimento</b>' está com o formato inválido. (formato: dd/mm/aaaa)";
                    return false;
                }
                
                if (Validacao::validarData($DataNascimento)){
                    $this->response->passo = 2;

                    $daoUsuario = new UsuarioDAO();
                    if ($Email){
                        $obj = $daoUsuario->retornarPorEmail($Email);
                        $this->response->mensagem = "Já existe um usuário utilizando este Email. Caso não seja o você, favor entrar em contato para esclarer o ocorrido.";
                    } else {
                        $obj = $daoUsuario->retornarPorCPF($CPF);
                        $this->response->mensagem = "Já existe um usuário utilizando este CPF. Caso não seja o você, favor entrar em contato para esclarer o ocorrido.";
                    }
                    if ($obj){
                        $this->response->passo = 3;

                        $dtNascimento = Formatacao::formatarDataSQL($obj->getDataNascimento(), false);
                        if ($DataNascimento != $dtNascimento) {
                            $this->response->erro = 56;
                            $this->response->mensagem = "A data de nascimento '<b>$DataNascimento</b>' não corresponde com a do nosso cadastro.";
                            //$this->response->mensagem .= "(DataNascimento=$DataNascimento) (dt=$dtNascimento)";
                        //} else if ($Matricula != $obj->getMatricula()) {
                        //    $this->response->erro = 56;
                        //    $this->response->mensagem = "A data de nascimento, <b>$DataNascimento</b>, não corresponde com a do nosso cadastro.";
                        } else {
                            $this->response->passo = 4;
                            $IdUsuario = $obj->getId();
                            $Nome = $obj->getNome();

                            $Conteudo = "";
                            $Conteudo .= "Olá <em>$Nome</em>!<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "Foi realizada um tentativa de cadastro no sistema <b>".$this->Config->Titulo."</b> com os dados abaixo.<br/>";
                            $Conteudo .= "Email: '$Email'<br/>";
                            $Conteudo .= "Matricula: '$Matricula'<br/>";
                            $Conteudo .= "Data de Nascimento: '$DataNascimento'<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "Caso tenha sido o senhor acessar a opção 'Lembrete de Senha'.<br/>";
                            $Conteudo .= "<br/>";
                            $Conteudo .= "Atenciosamente,<br/>";
                            $Conteudo .= "<b>".$this->Config->Titulo."</b><br/>";
                            $Conteudo .= $this->Config->URL."<br/>";
                            $Conteudo .= "";

                            $this->response->sucesso = 1;
                            if ($this->Config->Debug) {
                                $this->response->erro = 0;
                                $this->response->trace = 220;
                                $this->response->mensagem = "DEBUG: ".$this->response->mensagem;
                            } else {
                                if (Email::enviar($Nome, $Email, '', 'Lembrete', $Conteudo)) {
                                    $this->response->sucesso = 1;
                                    $this->response->erro = 0;
                                    $this->response->trace = 221;
                                } else {
                                    $this->response->trace = 222;
                                    $this->response->erro = 55;
                                    $this->response->mensagem = "<br/>(trace:222)";
                                    $this->response->mensagem .= "<br/>[".Email::getErro()." - ".Email::getMensagem()."]";
                                }
                            }
                        }
                    } else {
                        $daoPessoa = new PessoaDAO();
                        if ($Email){
                            $objPessoa = $daoPessoa->retornarPorEmail($Email);
                        } else {
                            $objPessoa = $daoPessoa->retornarPorCPF($CPF);
                        }
                        if ($objPessoa){ // Localizei a Pessoa ?
                            $IdPessoa = $objPessoa->getId();
                            $this->response->IdPessoa = $objPessoa->getId();
                            $this->response->Chave = $objPessoa->getChave();
                            $this->response->Chave = $objPessoa->getMatricula();
                            
                            $dtNascimento = Formatacao::formatarDataSQL($objPessoa->getDataNascimento(), false);
                            if ($DataNascimento != $dtNascimento) {
                                $this->response->erro = 56;
                                $this->response->mensagem = "A data de nascimento '<b>$DataNascimento</b>' não corresponde com a do nosso cadastro.";
                                //$this->response->mensagem .= "<br/>(dtNascimento: $dtNascimento)";
                            } elseif (intval($Matricula) != intval($objPessoa->getMatricula())) {
                                $this->response->erro = 56;
                                $this->response->mensagem = "A matríclua '<b>$Matricula</b>' não corresponde com a do nosso cadastro.";
                                //$this->response->mensagem .= '<br/>(Matricula: '.$objPessoa->getMatricula().')';
                            } else {
                                //$this->response->mensagem = "Podemos cadastrar este profissional.";
                                // Proteção contra Chave Duplicada
                                $Chave = UUID::v4();
                                if ($Chave){
                                    $obj1 = $daoUsuario->retornarPorChave($Chave); // 2. Tentativa 
                                    if ($obj1){
                                        $Chave = UUID::v4();
                                        $obj1 = $daoUsuario->retornarPorChave($Chave); // 3. Tentativa 
                                        if ($obj1){
                                            $Chave = UUID::v4();
                                        }
                                    }
                                }                                
                                $obj = new Usuario();
                                $obj->setChave($Chave);
                                $obj->setIdTipo(6); // 5:Profissional, 6:Atleta
                                $obj->setIdEmpresa($objPessoa->getIdEmpresa());
                                $obj->setIdPessoa($objPessoa->getId());
                                $obj->setConta($objPessoa->getCPF());
                                $obj->setNome($objPessoa->getNome());
                                $obj->setCPF($objPessoa->getCPF());
                                $obj->setEmail($objPessoa->getEmail());
                                $obj->setDataNascimento($objPessoa->getDataNascimento());
                                $obj->setTelefone($objPessoa->getTelefone());
                                $obj->setCelular($objPessoa->getCelular());
                                //$obj->setObservacao($Observacao);
                                $obj->setIdPerfil(9); // 9:'Profissional do Volei'
                                $obj->setIdStatus(1); // Pendente - Aguardar e-mail de confirmação para Ativar
                                $obj->setAtivo(false); // Pendente - Aguardar e-mail de confirmação para Ativar
                                if ($daoUsuario->salvar($obj)){
                                    $IdUsuario = $obj->getId();
                                    //$daoUsuario->atualizarSenha($obj);
                                    // Cadastrar SENHA
                                    $usDAO = new UsuarioSenhaDAO();
                                    $objSenha = new UsuarioSenha();
                                    $objSenha->setIdUsuario($IdUsuario);
                                    $objSenha->setTentativa(0);
                                    $SenhaNova = $this->gerarSenha(6);
                                    $objSenha->setSenha(Criptografia::encode($SenhaNova));
                                    // Calcular Validade da Senha
                                    $DataAtual = date("d/m/Y");
                                    $Validade = DataHora::somaMes($DataAtual, 6); // Soma 6 meses a data atual 
                                    $Validade = Formatacao::formatarDataSQL($Validade, true). ' 23:59:59';
                                    $objSenha->setValidade($Validade);
                                    $objSenha->setBloqueado(false);
                                    $objSenha->setAtivo(true);
                                    $this->response->Validade = $Validade;
                                    if ($usDAO->salvar($objSenha)){
                                        $sucessoSenha = 1;
                                    } else {
                                        $sucessoSenha = 0;
                                    } 
                                    $Link = " https://www.".$this->Config->URL."/at.php?u=$IdUsuario&k=$Chave";
                                    $Conteudo = "";
                                    $Conteudo .= "Olá <em>$Nome</em>!<br/>";
                                    $Conteudo .= "<br/>";
                                    $Conteudo .= "Seu cadastro foi realizado com sucesso. <br/>Abaixo estão seu e-mail e senha para acesso. <br/>Guarde-os em um local seguro.<br/>";
                                    $Conteudo .= "Email: $Email<br/>";
                                    $Conteudo .= "Senha: $SenhaNova<br/>";
                                    $Conteudo .= "<br/>";
                                    $Conteudo .= "<br/>";
                                    $Conteudo .= "Clique no link para ativar o sua conta: $Link";
                                    $Conteudo .= "<br/>";
                                    $Conteudo .= "<br/>";
                                    $Conteudo .= "Atenciosamente,<br/>";
                                    $Conteudo .= "<b>".$this->Config->Titulo."</b><br/>";
                                    $Conteudo .= $this->Config->URL."<br/>";
                                    $Conteudo .= "";
                                    if ($this->Config->Debug) {
                                        $this->response->sucesso = 1;
                                        $this->response->erro = 152;
                                        $this->response->mensagem = "DEBUG: Usuário cadastrado com sucesso.";
                                        if (!$sucessoSenha){
                                            $this->response->mensagem .= "<br/> Mas ocorreu erro na criação da senha de acesso.";
                                        }
                                        $this->response->link .= "<br/>($SenhaNova)($Link)";
                                    } else if ($Email) {
                                        if (Email::enviar($Nome, $Email, '', 'Cadastro de usuário', $Conteudo)) {
                                            $this->response->sucesso = 1;
                                            $this->response->erro = 0;
                                            $this->response->mensagem = "Usuário cadastrado com sucesso e senha foi enviada com sucesso para o email <b>$Email</b>.";
                                            if (!$sucessoSenha){
                                                $this->response->mensagem .= "<br/> Mas ocorreu erro na criação da senha de acesso.";                            
                                            }
                                        } else {
                                            $this->response->sucesso = 1;
                                            $this->response->erro = 164;
                                            $this->response->mensagem = "Usuário cadastrado com sucesso, mas ocorreu erro no envio do email de senha.";
                                            if (!$sucessoSenha){
                                                $this->response->mensagem .= "<br/> Mas ocorreu erro na criação da senha de acesso.";                            
                                            }
                                            $this->response->mensagem .= "<br/>[".Email::getErro()." - ".Email::getMensagem()."]";
                                        }
                                    } else {
                                        $this->response->sucesso = 1;
                                        $this->response->erro = 163;
                                        $this->response->mensagem = "Usuário cadastrado com sucesso.";
                                    }
                                }
                            }
                        } else {
                            if ($Email){
                                $this->response->trace = 231;
                                $this->response->mensagem = "Não foi possível localizar o registro com e-mail: '$Email'.<br/> Favor entrar em contato.";
                            } else {
                                $this->response->trace = 232;
                                $this->response->mensagem = "Não foi possível localizar o registro com CPF: '$CPF'.<br/> Favor entrar em contato.";
                            }
                        }
                        //$this->response->mensagem .= "<br/>Query=".$daoPessoa->_query;
                    }
                    //if ((isset($this->Config->Debug))&&(isset($this->Usuario->Id))){ if (($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->mensagem .= " (dt=$dtNascimento)"; }}
                    $daoUsuario->Close();
                } else {
                    $this->response->erro = 58;
                    $this->response->mensagem = "A data de nascimento '<b>$DataNascimento</b>' está com o formato inválido.";
                }
            } else {
                $this->response->erro = 60;
                $this->response->mensagem = "É obrigatório o parametro Email ou CPF. <br/> (e-mail: $Email, CPF: $CPF)";
            }
                
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     * Método para ativar registro criado pelo próprio usuário
     *
     * @param int Identificador do Usuário
     * @param string Chave do Usuário
     * 
     * @return bool true|false Se validado com sucesso
     */    
    public function ativar($p_Id, $p_Chave){
        try {
            $Id = ($p_Id)? $p_Id : self::getVar('u', FILTER_SANITIZE_NUMBER_INT);
            $Chave = ($p_Chave)? $p_Chave : self::getVar('k');
            
            if($Chave){
                $this->response->passo = 0;

                if ($Id){
                    $this->response->passo = 2;

                    $daoUsuario = new UsuarioDAO();
                    $obj = $daoUsuario->retornarPorChave($Chave);
                    if ($obj){
                        $this->response->passo = 3;

                        if ($Id == $obj->getId()) {
                            $this->response->passo = 4;
                            $IdUsuario = $obj->getId();
                            $Nome = $obj->getNome();
                            $Senha = ''; //$obj->getSenha();
                            $obj->setIdStatus(10); // Aprovado
                            $obj->setAtivo(1);
                            if ($daoUsuario->ativar($Id, $Chave)){
                                $this->response->sucesso = 1;
                                $this->response->mensagem = "Seu usuário foi ativado com sucesso.<br/><small><small><small>$Chave</small></small></small>";
                            } else {
                                $this->response->mensagem = $daoUsuario->getMensagem();
                            }
                        } else {
                            $this->response->erro = 56;
                            $this->response->mensagem = "O identificador <b>$Id</b> não corresponde ao usuário <b>$Chave</b> .";
                        }
                    } else {
                        $this->response->erro = 57;
                        $this->response->mensagem = "O Usuário <b>$Chave</b> não faz parte de nosso cadastro.";
                    }
                    $daoUsuario->Close();
                } else {
                    $this->response->erro = 58;
                    $this->response->mensagem = "É obrigatório o parametro identificador. <br/> (id: $Id)";
                }
            } else {
                $this->response->erro = 59;
                $this->response->mensagem = "É obrigatório o parametro Chave. <br/> (chave: $Chave)";
            }
                
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
    /**
     * Método para enviar uma Autenticar Usuario
     *
     * @return bool true|false Se validado com sucesso
     */
    public function autenticar(){
        try {
            $Conta = self::getVar('Conta');
            if(!$Conta){$Conta=self::getVar('acessoConta');}
            $Email = self::getVar('Email', FILTER_SANITIZE_EMAIL);
            if(!$Email){$Email=self::getVar('acessoEmail');}
            $CPF = self::getVar('CPF');
            if(!$CPF){$CPF=self::getVar('acessoCPF');}
            $Senha = self::getVar('Senha');
            if(!$Senha){$Senha=self::getVar('acessoSenha');}
            
            $this->response->Conta = $Conta;
            $this->response->Email = $Email;
            $this->response->CPF = $CPF;
            
            $this->response->passo = 3;
            $objUsuario = null;
            $uDAO = new UsuarioDAO();

            if ($Conta){ 
                $this->response->trace = "Tentativa de acesso por Conta.";
            
                // Validação
                $this->response->passo = 2;
            
                // Localizar Conta do usuário
                $objUsuario = $uDAO->retornarPorConta($Conta);
            
            } else if ($Email){ 
                $this->response->trace = "Tentativa de acesso por Email.";
            
                // Validação
                $this->response->passo = 3;
                $this->response->Email = $Email;
                if(!Validacao::validarEmail($Email)){ 
                    $this->response->erro = 142;
                    $this->response->mensagem = "O campo email, <b>$Email</b>, está com o formato inválido.";
                    return false;
                }
                // Localizar Conta do usuário
                $objUsuario = $uDAO->retornarPorEmail($Email);
            
            } else if ($CPF){
                $this->response->trace = "Tentativa de acesso por CPF.";
            
                // Validação
                $this->response->passo = 4;
                if(!Validacao::validarCpf($CPF)){
                    $this->response->erro = 143;
                    $this->response->mensagem = "O campo CPF, <b>$CPF</b>, está com o formato inválido.";
                    return false;
                }
                $Conta = Formatacao::formatarCPF($CPF, false);
                $this->response->CPF = $Conta;
            
                // Localizar Conta do usuário
                $objUsuario = $uDAO->retornarPorCPF($Conta);
            
            } else {
                $this->response->trace = "Tentativa de acesso não definido.";
            
                $objUsuario = null;
                $this->response->erro = 149;
                $this->response->mensagem = "Erro: 158 - O usuário ou senha está incorreto.";
                return false;
            }
            
            // Verifica se Localizou o Usuário ?
            if ($objUsuario) {
                $this->response->passo = 13;
                $this->response->IdUsuario = $objUsuario->getId();
            
                if ($objUsuario->getAtivo()){
                    $usDAO = new UsuarioSenhaDAO();
                    $objUsuarioSenha = $usDAO->retornarUltima($objUsuario->getId());
                    if ($objUsuarioSenha) {
                        $this->response->passo = 14;
                        $SenhaSecreta = Criptografia::encode($Senha);
                        $SenhaSecretaAntiga = $this->encriptar($Senha);
                        
                        $this->response->SenhaSecreta = $SenhaSecreta;
                        $this->response->SenhaSecretaAntiga = $SenhaSecretaAntiga;
                        $this->response->objUsuarioSenha = $objUsuarioSenha->getSenha();
                        $this->response->objUsuarioSenhaOK = ($SenhaSecretaAntiga == $objUsuarioSenha->getSenha());
                        // */
                        
                        if (($SenhaSecreta == $objUsuarioSenha->getSenha()) || ($SenhaSecretaAntiga == $objUsuarioSenha->getSenha())){
                            $this->response->passo = 15;
                            //$this->response->Senha = $Senha;
                            $this->response->Bloqueado = $objUsuarioSenha->getBloqueado();

                            if (!$objUsuarioSenha->getBloqueado()){
                                $this->response->passo = 18;
            
                                // Usuário validade e liberado para uso;
                                $ERRO_CODIGO=0;
                                $sisUsuario = new UsuarioContexto();
                                $sisUsuario->IdSessao = session_id();
                                $sisUsuario->Id = $objUsuario->getId();
                                $sisUsuario->Conta = $objUsuario->getConta();
                                $sisUsuario->Chave = $objUsuario->getChave();
                                $sisUsuario->Nome = $objUsuario->getNome();
                                $sisUsuario->IdTipo = $objUsuario->getIdTipo();
                                //$sisUsuario->IdEmpresa = $objUsuario->getIdEmpresa();
                                //$sisUsuario->IdPessoa = $objUsuario->getIdPessoa();
                                $sisUsuario->IdPerfil = $objUsuario->getIdPerfil();
                                $sisUsuario->NomePerfil = $objUsuario->getNomePerfil();
                             /*   $sisUsuario->NomeEmpresa = '';
                                $sisUsuario->ImagemEmpresa = '';
                                $sisUsuario->IdMatriz = '';
                                $sisUsuario->NomeMatriz = '';
                                $sisUsuario->UFEmpresa = '';*/
                                $sisUsuario->Timestamp = time();
            
                                $sisUsuario->IP = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_SANITIZE_STRING);
                                if(!$sisUsuario->IP){ $sisUsuario->IP = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_STRING);}
                                if(!$sisUsuario->IP){ $sisUsuario->IP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING);}
            
								/*
                                if ($sisUsuario->IdEmpresa > 0) {
                                    $cDAOEmpresa = new EmpresaDAO();
                                    $objEmpresa = $cDAOEmpresa->retornar($sisUsuario->IdEmpresa);
                                    if ($objEmpresa){
                                        $sisUsuario->IdTipoEmpresa = $objEmpresa->getIdTipoEmpresa();
                                        $sisUsuario->NomeEmpresa = $objEmpresa->getNome();
                                        $sisUsuario->ImagemEmpresa = $objEmpresa->getImagem();
                                        $sisUsuario->IdMatriz = $objEmpresa->getIdMatriz();
                                        $sisUsuario->NomeMatriz = $objEmpresa->getNomeMatriz();
                                        $sisUsuario->UFEmpresa = $objEmpresa->getUF();
                                    }
                                }
								*/
                                if($sisUsuario->IdTipo==1){ $sisUsuario->Contexto = 'Administrador';
                                } elseif($sisUsuario->IdTipo==2){ $sisUsuario->Contexto = 'Usuario';
                                } elseif($sisUsuario->IdTipo==3){ $sisUsuario->Contexto = 'Usuario';
                                } elseif($sisUsuario->IdTipo==4){ $sisUsuario->Contexto = 'Usuario';
                                } elseif($sisUsuario->IdTipo==5){ $sisUsuario->Contexto = 'Usuario';
                                } elseif($sisUsuario->IdTipo==6){ $sisUsuario->Contexto = 'Usuario';
                                } elseif($sisUsuario->IdTipo==7){ $sisUsuario->Contexto = 'Usuario';
                                } else { $sisUsuario->Contexto = $sisUsuario->IdTipo; }
								
                                // Estatistica;
                                $uDAO->registarAcesso($sisUsuario->Id);
            
                                $_SESSION['USO_ID'] = $sisUsuario->Id;
                                $_SESSION['USUARIO'] = serialize($sisUsuario);
            
                                $this->response->sucesso = 1;
                                $this->response->Usuario = $sisUsuario;
                                $this->response->mensagem = "$sisUsuario->Nome, sua autenticação foi realizada com sucesso.";
                                //$this->response->pagina = "controller.php?gm=dashboard&mod=branco";
								$this->response->pagina = "controller.php?gm=dashboard&mod=abertura";
                                $this->response->passo = 98;
            
                                // Gravar LOG
                                $logDAO = new LogAcaoDAO();
                                $logDAO->salvar(new LogAcao(0, 'autenticacao', 'abertura', null, 'view', '{}', null, $sisUsuario->Id, $sisUsuario->IP));
                                $logDAO = null;
                                $this->response->passo = 99;
            
                            } else {
                                $this->response->erro = 154;
                                $this->response->mensagem = "Erro: 154 - O usuário ou senha esta incorreto.";
                            }
                        } else {
                            $this->response->erro = 155;
                            $this->response->mensagem = "Erro: 155 - O usuário ou senha esta incorreto.";
                        }
                    } else {
                        $this->response->erro = 156;
                        $this->response->mensagem = "Erro: 156 - O usuário ou senha esta incorreto.";
                        if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query2 = $usDAO->_query; }
                    }
                    $usDAO->close();
                } else {
                    $this->response->erro = 157;
                    $this->response->mensagem = "Erro: 157 - Usuário desativado. <br/>Favor entrar em contato com o administrador do sistema.";
                }
            } else {
                $this->response->erro = 158;
                $this->response->mensagem = "Erro: 158 - O usuário ou senha esta incorreto.";
                if(($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->query = $uDAO->_query; }
            }
            $uDAO->close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    

    /**
     * Método para editar Senho do Usuário
     *
     * @return bool Se atualização relizada com sucesso
     */
    public function editarSenha() {
        try {
            if (!parent::isLogged()){
                self::logOff();
                self::tratarErroJSON(11, "Controle de Acesso", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
            }
    
            $daoUsuario = new UsuarioDAO();
    
            // Coletar parametros
            $SenhaAtual = self::getVar("SenhaAtual");
            $SenhaNova = self::getVar("SenhaNova");
            $SenhaNova2 = self::getVar("SenhaNova2");
            $IdUsuario = $this->Usuario->Id;
            
            //
            $this->response->Id = $this->Usuario->Id;
            $this->response->IdUsuarioAcao = $this->Usuario->Id;
    
            if ($IdUsuario > 0){
                if ($SenhaAtual != $SenhaNova){
                    if ($SenhaNova == $SenhaNova2){
                        $this->response->passo = 2;
            
                        $obj = $daoUsuario->retornar($IdUsuario);
                        if ($obj){
                            $this->response->passo = 3;
                            $Nome = $obj->getNome();
                            $Email = $obj->getEmail();
            
                            $daoUsuarioSenha = new UsuarioSenhaDAO();
                            $objUsuarioSenha = $daoUsuarioSenha->retornarUltima($IdUsuario);
                            if ($objUsuarioSenha) {
                                $this->response->passo = 4;
                                $SenhaSecreta = Criptografia::encode($SenhaAtual);
                                $this->response->SenhaSecreta = $SenhaSecreta;
            
                                if ($SenhaSecreta == $objUsuarioSenha->getSenha()){
            
                                    $this->response->passo = 5;
                                    // Excluir as Senhas antigas Ativas
                                    $daoUsuarioSenha->excluirTodos($IdUsuario);
            
                                    $objSenha = new UsuarioSenha();
                                    $objSenha->setIdUsuario($IdUsuario);
                                    $objSenha->setTentativa(0);
                                    $objSenha->setSenha(Criptografia::encode($SenhaNova));
                                    // Calcular Validade da Senha
                                    $DataAtual = date("d/m/Y");
                                    $Validade = DataHora::somaMes($DataAtual, 3); // Soma 3 meses a data atual
                                    $Validade = Formatacao::formatarDataSQL($Validade, true). ' 23:59:59';
                                    $objSenha->setValidade($Validade);
                                    $this->response->Validade = $Validade;
            
                                    if ($daoUsuarioSenha->salvar($objSenha)){
            
                                        $this->response->passo = 6;
                                        $Conteudo = "";
                                        $Conteudo .= "Olá <em>$Nome</em>!<br/>";
                                        $Conteudo .= "<br/>";
                                        $Conteudo .= "Sua senha foi atualizado com sucesso. Abaixo estão seu e-mail e senha para acesso. Guarde-os em um local seguro.<br/>";
                                        $Conteudo .= "Email: $Email<br/>";
                                        $Conteudo .= "Senha: $SenhaNova<br/>";
                                        $Conteudo .= "<br/>";
                                        $Conteudo .= "Atenciosamente,<br/>";
                                        $Conteudo .= "<b>".$this->Config->Titulo."</b><br/>";
                                        $Conteudo .= $this->Config->Url."<br/>";
                                        $Conteudo .= "";
            
                                        if ($this->Config->Debug) {
                                            $this->response->sucesso = 1;
                                            $this->response->erro = 0;
                                            //$this->response->mensagem = "DEBUG: Operação realizada com sucesso. (Senha nova=$SenhaNova)";
											$this->response->mensagem = "Operação realizada com sucesso.";
                                        } else if($Email) {
                                            if (Email::enviar($Nome, $Email, '', 'Atualização de dados', $Conteudo)) {
                                                $this->response->sucesso = 1;
                                                $this->response->erro = 0;
                                                $this->response->mensagem = "<b>$Nome</b>, sua senha foi enviada com sucesso para o e-mail: <b>$Email</b>";
                                            } else {
                                                $this->response->erro = 53;
                                                $this->response->mensagem = "Operação realizada com sucesso, Mas ocorreu erro no envio do e-mail: $Email";
                                                $this->response->mensagem .= "<br/>[".Email::getErro()." - ".Email::getMensagem()."]";
                                            }
                                        } else {
                                            $this->response->sucesso = 1;
                                            $this->response->erro = 0;
                                            $this->response->mensagem = "Operação realizada com sucesso..";
                                        }
                                    } else {
                                        $this->response->erro = 54;
                                        $this->response->mensagem = utf8_encode($DAO->getMensagem());
                                    }
                                } else {
                                    $this->response->erro = 55;
                                    $this->response->mensagem = "A senha Atual não conferer com a que existe no cadastro.";
                                    //if ((isset($this->Config->Debug))&&(isset($this->Usuario->Id))){ if (($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->mensagem .= " (SenhaAtual=$SenhaAtual) (Senha=$Senha)"; }}
                                }
                            } else {
                                $this->response->erro = 56;
                                $this->response->mensagem = "Registro de sua senha não foi encontrada.";
                                //if ((isset($this->Config->Debug))&&(isset($this->Usuario->Id))){ if (($this->Config->Debug)||($this->Usuario->Id==1)){ $this->response->mensagem .= " (SenhaAtual=$SenhaAtual) (Senha=$Senha)"; }}
                            }
                        } else {
                            $this->response->erro = 57;
                            $this->response->mensagem = "O usuário ($IdUsuario) não faz parte de nosso cadastro.";
                        }
                    } else {
                        $this->response->erro = 57;
                        $this->response->mensagem = "A confirmação da Nova senha não convere com a Nova senha.";
                    }
                } else {
                    $this->response->erro = 57;
                    $this->response->mensagem = "A nova senha não pode ser igual a senha atual.";
                }
            } else {
                $this->response->erro = 58;
                $this->response->mensagem = "Usuário tem que esta autenticado para realizar esta operação.";
            }
            $daoUsuario->Close();
        }catch (Exeception $ex){ $this->response->mensagem = "Erro (".$ex->getCode()."): ".$ex->getMessage(); }
        return ($this->response->sucesso==1);
    }
    
}