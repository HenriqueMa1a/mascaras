<?php
/*
 if($_SERVER['SERVER_PORT'] != '443') {
              header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
              exit();
      }
*/
error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 'on');
require_once("global.php");

ini_set("error_log", "/tmp/php-error-".date("Y-m-d").".log");

require_once("Validacao.class.php");
require_once("Formatacao.class.php");
require_once("DataHora.class.php");
require_once("UUID.class.php");
require_once("Email.class.php");

require_once("../models/EventoPresencaDAO.class.php");

error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 'on');

	$x=0;
 	$j=0;
    
    
    /*
        locale/
            en/                    <-- language
               LC_MESSAGES/        <-- category
                   messages.mo     <-- domain
                   brands.mo       <-- domain    
    */
    
    if($_GET['lang']){
        $language=$_GET['lang'];
    } else {
        $language="pt_BR";
    }
    define('LANG', $language);
    
    
    if (defined('LC_MESSAGES')) {
        setlocale(LC_MESSAGES, $language); // Linux
    } else {
        putenv("LC_ALL={$language}"); // windows
    }
    //setlocale(LC_ALL, $language);
    
    bindtextdomain("mensagens", "./language");
    bind_textdomain_codeset("mensagens", "UTF-8");    
    textdomain("mensagens");
    
    
    echo "[language:$language]\n<br>";
    echo "['".gettext("Monday")."']\n<br/>";
    echo "["._("Monday")."]\n<br>";
    //echo "['".dgettext("Sunday")."']\n<br/>";
    
    $i=0;
    $DAO = new EventoPresencaDAO();
    $listagem = $DAO->listar(null, null, '1', 'asc');
    if ($listagem) {
        foreach ($listagem as $item){
            echo $item->getId().' - '.$item->getChave().' - '.$item->getNomeCracha()."\n<br>";
            if (!$item->getChave()){
                //echo "UUID::v4:".UUID::v4()."<br/>";
                $item->setChave(UUID::v4());
                $DAO->atualizar($item);
            }
            $i++;
        }
    }
    
    
    exit();
    
    
try{
	$x++;
	
    $num = 123; echo "ctype_digit($num)=".ctype_digit($num)."\n<br/>";
    $num = 12.3; echo "ctype_digit($num)=".ctype_digit($num)."\n<br/>";
    $num = -1; echo "ctype_digit($num)=".ctype_digit($num)."\n<br/>";
    $num = ''; echo "ctype_digit('$num')=".ctype_digit($num)."\n<br/>";
    $num = '123456789011'; echo "ctype_digit('$num')=".ctype_digit($num)."\n<br/>";
    $num = '123'; echo "ctype_digit('$num')=".ctype_digit($num)."\n<br/>";
    $num = '12.3'; echo "ctype_digit('$num')=".ctype_digit($num)."\n<br/>";
    $num = '-1'; echo "ctype_digit('$num')=".ctype_digit($num)."\n<br/>";
    $num = null; echo "ctype_digit('$num')=".ctype_digit($num)."\n<br/>";
    
    $num = 123; echo "is_int($num)=".is_int($num)."\n<br/>";
    $num = 12.3; echo "is_int($num)=".is_int($num)."\n<br/>";
    $num = -1; echo "is_int($num)=".is_int($num)."\n<br/>";
    $num = ''; echo "is_int('$num')=".is_int($num)."\n<br/>";
    $num = '123456789011'; echo "is_int('$num')=".is_int($num)."\n<br/>";
    $num = '123'; echo "is_int('$num')=".is_int($num)."\n<br/>";
    $num = '123'; echo "is_int('$num')=".is_int($num)."\n<br/>";
    $num = '12.3'; echo "is_int('$num')=".is_int($num)."\n<br/>";
    $num = '-1'; echo "is_int('$num')=".is_int($num)."\n<br/>";
    $num = null; echo "is_int('$num')=".is_int($num)."\n<br/>";
    
    $num = 123; echo "is_float($num)=".is_float($num)."\n<br/>";
    $num = 12.3; echo "is_float($num)=".is_float($num)."\n<br/>";
    $num = -1; echo "is_float($num)=".is_float($num)."\n<br/>";
    $num = ''; echo "is_float('$num')=".is_float($num)."\n<br/>";
    $num = '123456789011'; echo "is_float('$num')=".is_float($num)."\n<br/>";
    $num = '12,34,56,78,90,11'; echo "is_float('$num')=".is_float($num)."\n<br/>";
    $num = '123'; echo "is_float('$num')=".is_float($num)."\n<br/>";
    $num = '12.3'; echo "is_float('$num')=".is_float($num)."\n<br/>";
    $num = '-1'; echo "is_float('$num')=".is_float($num)."\n<br/>";
    $num = null; echo "is_float('$num')=".is_float($num)."\n<br/>";

	
    $num = 123; echo "is_numeric($num)=".is_numeric($num)."\n<br/>";
    $num = 12.3; echo "is_numeric($num)=".is_numeric($num)."\n<br/>";
    $num = -1; echo "is_numeric($num)=".is_numeric($num)."\n<br/>";
    $num = ''; echo "is_numeric('$num')=".is_numeric($num)."\n<br/>";
    $num = '123456789011'; echo "is_numeric('$num')=".is_numeric($num)."\n<br/>";
    $num = '12,34,56,78,90,11'; echo "is_numeric('$num')=".is_numeric($num)."\n<br/>";
    $num = '123'; echo "is_numeric('$num')=".is_numeric($num)."\n<br/>";
    $num = '12.3'; echo "is_numeric('$num')=".is_numeric($num)."\n<br/>";
    $num = '-1'; echo "is_numeric('$num')=".is_numeric($num)."\n<br/>";
    $num = null; echo "is_numeric('$num')=".is_numeric($num)."\n<br/>";

    
    /* // 
	//$b = $x / $j;
	$DataNascimento = '26/06/1977';
	echo "DataHora::diferencaData($DataNascimento, '', 'a'): ".DataHora::diferencaData($DataNascimento, '', 'A')."<br/>";
	echo "DataHora::getIdade($DataNascimento): ".DataHora::getIdade($DataNascimento)."<br/><br/>";

	$DataNascimento = '1977-06-26';
	echo "DataHora::getIdade($DataNascimento): ".DataHora::getIdade($DataNascimento)."<br/><br/>";
	
	$DataNascimento = '30/11/1977';
	echo "DataHora::diferencaData($DataNascimento, '', 'a'): ".DataHora::diferencaData($DataNascimento, '', 'A')."<br/>";
	echo "DataHora::getIdade($DataNascimento): ".DataHora::getIdade($DataNascimento)."<br/><br/>";

	$DataNascimento = '05/12/2014';
	echo "DataHora::diferencaData($DataNascimento, '', 'a'): ".DataHora::diferencaData($DataNascimento, '', 'A')."<br/>";
	echo "DataHora::getIdade($DataNascimento): ".DataHora::getIdade($DataNascimento)."<br/><br/>";
	
	$Data = '26/06/2013'; echo "DataHora::diferencaData($Data, '', 'm'): ".DataHora::diferencaData($Data, '', 'm')."<br/>";
	$Data = '26/06/2013'; echo "DataHora::diferencaData($Data, '', 'M'): ".DataHora::diferencaData($Data, '', 'M')."<br/>";
	$Data = '01/12/2013'; echo " DataHora::diferencaData($Data, '', 'd'): ".DataHora::diferencaData($Data, '', 'd')."<br/>";
	$Data = '01/12/2013'; echo " DataHora::diferencaData($Data, '', 'M'): ".DataHora::diferencaData($Data, '', 'M')."<br/>";
	$Data = '01/12/2013'; echo " DataHora::diferencaData($Data, '', 'm'): ".DataHora::diferencaData($Data, '', 'm')."<br/><br/>";

	//$DataHora = '26/11/2014 08:00:00'; echo "DataHora::diferencaDataHora($DataHora, '', 'h'): ".DataHora::diferencaDataHora($DataHora, '', 'h')."<br/><br/>";
	
	//throw new Exception('Division by zero.');
    $email = 'mcastro@bio.fiocruz.br';
    echo "Email: validarEmail($email):".Validacao::validarEmail($email)."<br/>";

    $tel = '6068-2113';
    echo "Telefone: validarTelefone($tel):".Validacao::validarTelefone($tel)."<br/>";
    $tel = '60682113'; echo "CPF: formatarTelefone($tel): ".Formatacao::formatarTelefone($tel)."<br/>";
    $tel = '6068-2113'; echo "CPF: formatarTelefone($tel,false): ".Formatacao::formatarTelefone($tel,false)."<br/>";
    $tel = '21 60682113'; echo "CPF: formatarTelefone($tel): ".Formatacao::formatarTelefone($tel)."<br/>";
    $tel = '(21) 6068-2113'; echo "CPF: formatarTelefone($tel,false): ".Formatacao::formatarTelefone($tel,false)."<br/><br/>";

    $cep = '60608-211';
    echo "CEP: validarCEP($cep):".Validacao::validarCEP($cep)."<br/>";
    
	$cep = '60608211';
    echo "CEP: formatarCEP($cep):".Formatacao::formatarCEP($cep)."<br/>";
    $cep = '60608-211';
    echo "CEP: formatarCEP($cep,false):".Formatacao::formatarCEP($cep,false)."<br/><br/>";

    $data = '00/00/0000'; echo "data: validarData($data):".Validacao::validarData($data)."<br/>";
    $data = '30/02/2000'; echo "data: validarData($data):".Validacao::validarData($data)."<br/>";
    $data = '32/01/2000'; echo "data: validarData($data):".Validacao::validarData($data)."<br/>";
    $data = '31/01/0000'; echo "data: validarData($data):".Validacao::validarData($data)."<br/>";
    $data = '12/13/2000'; echo "data: validarData($data):".Validacao::validarData($data)."<br/>";
    $data = '29/02/2000'; echo "data: validarData($data):".Validacao::validarData($data)."<br/>";
    echo "<br/>";

    $cpf = '111.444.777-35'; echo "CPF: validarCPF($cpf): ".Validacao::validarCPF($cpf)."<br/>";
    $cpf = '11144477735'; echo "CPF: formatarCPF($cpf): ".Formatacao::formatarCPF($cpf)."<br/>";
    $cpf = '111.444.777-35'; echo "CPF: formatarCPF($cpf,false): ".Formatacao::formatarCPF($cpf,false)."<br/><br/>";
	
	$cpf = '09999013970'; echo "CPF: validarCPF($cpf): ".Validacao::validarCPF($cpf)."<br/>";
    $cpf = '09999013970'; echo "CPF: formatarCPF($cpf,false): ".Formatacao::formatarCPF($cpf)."<br/><br/>";
 
    $cnpj = '00.038.166/0002-88';
    echo "CNPJ: validarCNPJ($cnpj):".Validacao::validarCNPJ($cnpj)."<br/>";
    $cnpj = '11144477735'; echo "CPF: formatarCNPJ($cnpj): ".Formatacao::formatarCNPJ($cnpj)."<br/>";
    $cnpj = '111.444.777-35'; echo "CPF: formatarCNPJ($cnpj,false): ".Formatacao::formatarCNPJ($cnpj,false)."<br/><br/>";

	
	// Named-based UUID.
	$v3uuid = UUID::v3('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString');
	$v5uuid = UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString');
// Pseudo-random UUID
	$v4uuid = UUID::v4();
   
   echo "UUID::v3:".UUID::v3('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString')."<br/>";
   echo "UUID::v3:".UUID::v3('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString')."<br/>";
   echo "UUID::v3:".UUID::v3('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString')."<br/>";

   echo "UUID::v4:".UUID::v4()."<br/>";
   echo "UUID::v4:".UUID::v4()."<br/>";
   echo "UUID::v4:".UUID::v4()."<br/>";
   
   echo "UUID::v5:".UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString')."<br/>";
   echo "UUID::v5:".UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString')."<br/>";
   echo "UUID::v5:".UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString')."<br/>";

      */
    /*
    $Conteudo = "";
    $Conteudo .= "Olá!<br/><br/>";
    $Conteudo .= "Este é um teste de email.<br/><br/>";
    $Conteudo .= "Timestamp: ".date("Y-m-d-His-u")."<br/>";
    $Conteudo .= "<br/>";
    $Conteudo .= "Atenciosamente,<br/>";
    $Conteudo .= "<b>".$sisConfig->Titulo."</b><br/>";
    $Conteudo .= $sisConfig->URL."<br/>";
    $Conteudo .= "";
    
    
    //echo (extension_loaded('openssl')?'SSL loaded':'SSL not loaded')."\n<br>";
    echo "host:".gethostbyname('smtp.office365.com')."\n<br>";
    
    //require_once 'phpmailer/PHPMailerAutoload.php';
    
    echo "timestamp:".date('Y-m-d-His.u')."-".microtime(true)."<br>";
    echo "Envio de email:".Email::enviar('Marcelo', 'kellen.nery@bio.fiocruz.br', '', 'teste de envio: '.date("Y-m-d-His-u"), $Conteudo, null, null, null, 3, 60);
    echo "timestamp:".date('Y-m-d-His.u')."-".microtime(true)."<br>";
    echo "[".Email::getErro()." - ".Email::getMensagem()."]";
    // */
    
    /*
    $oMail = new SendEmail(array('protocol'=>'smtp' , 'smtp_hostname'=>'tls://smtp.office365.com' , 'smtp_username'=>'cbvolei@volei.org.br' , 'smtp_password'=>'!@3nMv0l3i' , 'smtp_port'=>587 , 'smtp_timeout'=>60));
    
    $oMail->setHtml(true);
    $oMail->setFrom('cbvolei@volei.org.br');
    $oMail->setTo('kellen.nery@bio.fiocruz.br');
    $oMail->setSender('cbvolei@volei.org.br');
    $oMail->setSubject('teste SendMail: '.date("Y-m-d-His-u"));
    $oMail->setText($Conteudo);
    $oMail->setHTML($Conteudo);
    
    echo "send=". $oMail->send();
   // */
   
} catch (Exception $e) {
 	$x++;
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
    //echo "erro:$x<br/>";
     
}

	//$x++;
     //echo "x:$x<br/>";

 
?>