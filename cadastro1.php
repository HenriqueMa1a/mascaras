<?php
error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 'on');
ini_set("error_log", "/tmp/php-error-".date("Y-m-d").".log");

require_once 'assets/global.php';
require_once 'assets/Email.class.php';
require_once 'assets/Formatacao.class.php';
require_once 'models/InscricaoDAO.class.php';

error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 'on');

	$x=0;
 	
    try{

        $IdUsuario = filter_input(INPUT_GET, 'IdUsuario', FILTER_SANITIZE_NUMBER_INT);
        if(!$IdUsuario){ $IdUsuario =filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);}
        
        if($IdUsuario){
            $DAO = new InscricaoDAO();
            $obj = $DAO->retornarPorUsuario($IdUsuario);
            if ($obj){
                $IdFormulario = $obj->getId();
                $Nome = $obj->getNome();
                $Email = $obj->getEmail();
                $IdUsuario = $obj->getIdUsuario();
                $IdStatus = $obj->getIdStatus();
                $NomeStatus = $obj->getNomeStatus();
                $DataCadastro = ($obj->getDataCadastro()) ? Formatacao::formatarDataHoraSQL($obj->getDataCadastro(), false) : '';
                $Campos = $obj->getCampos();
                
                    // enviar Email;
                    $Conteudo = "<font face=\"Arial\" size=\"2\">";
                    $Conteudo .= "Prezado(a) <em>".$Nome."</em>,<br/>";
                    $Conteudo .= "<br/>";
                    $Conteudo .= "<br/>";
                    $Conteudo .= "Sua solicitação de inscrição <b>'".$IdUsuario."'</b> foi cadastrada em nossa base de dados em ".$DataCadastro."<br/>";
                    $Conteudo .= "<br/>";
                    $Conteudo .= "Nº: <b>".$IdUsuario."</b><br/>";
                    $Conteudo .= "Nome: <b>".$Nome."</b><br/>";
                    $Conteudo .= "Email (login): <b>".$Email."</b><br/>";
                    $Conteudo .= "Status: <b><font color=\"black\">".$NomeStatus."</font></b><br/>";
                    $Conteudo .= "<br/>";
                    $Conteudo .= "Inscrição nos dias: <b>".$Campos->dias."</b><br/>";
                    if (isset($Campos->workshop)){
                        if ($Campos->workshop!=''){
                            $Conteudo .= "Workshop: <b>".$Campos->workshop."</b><br/>";
                        }
                    }
                    $Conteudo .= "<br/>";
                    $Conteudo .= "<b><em>A confirmação de inscrição será enviada posteriormente, via e-mail, considerando a disponibilidade de vagas e os critérios de participação no evento.</em></b><br/>";
                    $Conteudo .= "<br/>";
                    $Conteudo .= "<br/>";
                    $Conteudo .= "Atenciosamente,<br/>";
                    $Conteudo .= "<b>III Simpósio Internacional de Imunobiológicos</b><br/>";
                    $Conteudo .= "<b>Bio-Manguinhos | FIOCRUZ</b><br/>";
                    $Conteudo .= "http://simposio.bio.fiocruz.br<br/>";
                    $Conteudo .= "</font>";
                    
                    if (Email::enviar($Nome, $Email, 'mcastro@bio.fiocruz.br', "Cadastro no III Simpósio Internacional de Imunobiológicos – aguardando confirmação - (".$IdUsuario.")", $Conteudo)){
                        $sucesso = 1;
                        $erro = 0;
                        $mensagem = "O comunicado foi enviado com sucesso para <b>".$Nome."</b> <em>(".$Email.")</em>.";
                    } else {
                        $erro = 243;
                        $mensagem = "Erro ao enviar comunicado para <b>".$Nome."</b> <em>(".$Email.")</em>.";
                        $mensagem .= "[".Email::getErro()." - ".Email::getMensagem()."]";
                    }
                    header("Location: ../index.php/submissao-resumos-poster");
                    //echo $mensagem;
            } else {
                echo "Erro: Não foi possível localizar o registro. {IdUsuario:$IdUsuario} ";
            }
        } else {
            echo "Erro: Parametro obrigatório. {IdUsuario:$IdUsuario} ";
        }
    } catch (Exception $e) {
        echo 'Exceção capturada: ',  $e->getMessage(), "\n";
    }
