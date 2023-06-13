<?php 
require_once 'phpmailer/PHPMailerAutoload.php';
/**
 * Classe de utilidades para envido de Emails
 * @author  Kellen Nery
 */
class Email {  

    private static $SMTPHost = 'correio.bio.fiocruz.br';
    private static $SMTPPort = '25'; // {25, ssl:465, tsl:587}
    private static $Email = 'isi@bio.fiocruz.br';	
	private static $SMTPAuth = false;
    private static $SMTPSecure = ''; // {'', ssl, tsl}
    private static $EmailNome = 'V International Symposium on Immunobiologicals de Bio-Manguinhos';
    private static $EmailUsuario = 'isi';// = 'sact';
    private static $EmailSenha = '123@senha';// = 'S@ctb!0p4ss';
    private static $_mensagem = null;
    private static $_erro = 0;

    public static function setErro( $p_erro ){ self::$_erro = $p_erro; }
    public static function getErro(){ return self::$_erro; }

    public static function setMensagem( $p_mensagem ){ self::$_mensagem = $p_mensagem; }
    public static function getMensagem(){ return self::$_mensagem; }
	
    /**
    *   função para enviar mensagem via email padrão 
    *
    *   @param string $ToName O Nome da pessoa a ser enviada a mensagem
    *   @param string $ToAddress O Email da pessoa a ser enviada a mensagem
    *   @param string $CC O Email da cópia a ser enviada a mensagem
    *   @param string $FromName O Nome da pessoa a ser enviada a mensagem 
    *   @param string $FromAddress O Nome da pessoa a ser enviada a mensagem 
    *   @param string $FromPassword O Nome da pessoa a ser enviada a mensagem 
    *   @param string $Assunto O assunto da mensagem a ser enviada
    *   @param string $Conteudo O Conteudo da mensagem a ser enviada
    *   @param string $Anexo O Nome da pessoa a ser enviada a mensagem 
    *   @return boolean TRUE Se a mensagem de email for enviada com sucesso
    */
    public static function enviar($ToName, $ToAddress, $CC='', $Assunto='', $Conteudo='', $FromName='', $FromAddress='', $FromPassword=''){

        try {

            $mail = new PHPMailer();
            $mail->SetLanguage("br", "phpmailer5.2.9/language/");
            //$mail->SMTPDebug  = 2;
            //$mail->Debugoutput = 'html';
            $mail->isSMTP();                    // Flag de uso SMTP
            $mail->SMTPAuth = self::$SMTPAuth;             // uso de SMTP authentication
            if (self::$SMTPHost){
                $mail->Host = self::$SMTPHost;
            }
            if (self::$SMTPPort){
                $mail->Port = self::$SMTPPort; // {25, ssl:465, tsl:587}
            }
            if (self::$SMTPSecure){
                $mail->SMTPSecure = self::$SMTPSecure;
            }
			
			$mail->isMail();                    // Flag de uso phpmail
			
            $mail->CharSet = "UTF-8";
            $mail->Timeout = 20;

       /*     // USUARIO E SENHA
            if ($FromAddress){
                $mail->Username = $FromAddress;     // SMTP username
                $mail->Password = $FromPassword;    // SMTP password
            } else {
                $mail->Username = self::$EmailUsuario;
                if (isset(self::$EmailSenha)){
                    $mail->Password = self::$EmailSenha;
                }
            }*/
            
            // DE:
            if ($FromAddress){
                $mail->From = $FromAddress;
                if ($FromName){
                    $mail->From = $FromName;
                }
            } else {
                if (isset(self::$Email)){
                    $mail->From = self::$Email;
                    $mail->FromName = self::$EmailNome;
                }
            } 
            
            // PARA:
            $mail->AddAddress($ToAddress, $ToName); // name is optional
            
			if ($CC){
                if (strpos($CC,',')) {
                    $arrCC = explode(',',$CC);
                    foreach ($arrCC as $emailCC){
                        $mail->AddCC($emailCC);
                    }
                } else if (strpos($CC,';')) {
                    $arrCC = explode(';',$CC);
                    foreach ($arrCC as $emailCC){
                        $mail->AddCC($emailCC);
                    }
                } else {
                    $mail->AddCC($CC);
                }
                
            }
			
			// cópia oculta
			$mail->AddBCC('kellen.nery@bio.fiocruz.br', 'Kellen Nery'); // Cópia Oculta
			

            $mail->WordWrap = 50;                                 // set word wrap to 50 characters
            $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $Assunto;
            $mail->Body    = $Conteudo;

            if(!$mail->Send()) {   
                // Limpa os destinatários e os anexos
                $mail->ClearAllRecipients();
                $mail->ClearAttachments();          

                //$ERRO_NOTAS = "Mailer Error: " . $mail->ErrorInfo . "(".$mail->Host.")(".$mail->Username.")(".$mail->Password.")"; // (mccDEBUG)
                //echo $ERRO_NOTAS; exit();
				throw new Exception("Mailer Error: " . $mail->ErrorInfo . "(".$mail->Host.")", 21);
            } else {  
                // Limpa os destinatários e os anexos
                $mail->ClearAllRecipients();
                $mail->ClearAttachments();          
            
                self::$_erro = 0;
                self::$_mensagem = "Mensagem enviar com sucesso para o email: $ToAddress\n";
                return true;
            }
            //*/
        }catch ( Exception $ex ){ self::$_mensagem = $ex->getMessage(); self::$_erro = $ex->getCode(); return false; }
    }
    
    public static function enviarGmail($ToName, $ToAddress, $FromName, $FromAddress, $FromPassword, $Assunto, $Conteudo, $Anexo = null){

        global $sisConfig;

        try {
                $mail = new PHPMailer();

                // CONFIGURAÇÃO DO SERVIDOR
                $mail->isSMTP();                    // Falg de uso SMTP
                $mail->SetLanguage("br", "phpmailer/language/");
                //$mail->Host = "smtp.".$EMP_URL;   // seu servidor SMTP
                //$mail->Host = "gmail-smtp-in.l.google.com";       // servidor para google/apps
                $mail->CharSet = "UTF-8";

                /* 
                $mail->Host = "tls://smtp.gmail.com";
                $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
                $mail->Port       = 587;                   // set the SMTP port for the GMAIL server
                // */

                $mail->Host = "smtp.gmail.com";
                $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
                $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
                // */

                // $mail->SMTPDebug = 1; // enables SMTP debug information (for testing)
                // 1 = errors and messages
                // 2 = messages only 

                $mail->SMTPAuth = self::$SMTPAuth;             // uso de SMTP authentication
                //$mail->Timeout = 20;

                /* 
                // Configuração para Email do GMAIL.
                $mail->Host = "smtp.gmail.com"; // specify main and backup server
                $mail->SMTPAuth = self::$SMTPAuth;   // turn on SMTP authentication
                $mail->SMTPSecure= "ssl"; //  Used instead of TLS when only POP mail is selected
                $mail->Port = 465;        //  Used instead of 587 when only POP mail is selected
                */

                // USUARIO E SENHA
                $mail->Username = $FromAddress;     // SMTP username
                $mail->Password = $FromPassword;    // SMTP password


                // DE:
                $mail->From = $FromAddress;
                $mail->FromName = $FromName;

                // PARA:
                $mail->AddAddress($ToAddress, $ToName);
                // $mail->AddAddress("comercial@asasolucoes.com");                  // name is optional
                // $mail->AddReplyTo("comercial@mustmodels.com");

                $mail->WordWrap = 50;                                 // set word wrap to 50 characters
                //$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
                //$mail->AddAttachment($ANEXO1);    // optional name
                //$mail->AddAttachment($ANEXO2);    // optional name
                $mail->IsHTML(true);                                  // set email format to HTML

                $mail->Subject = $Assunto;
                $mail->Body    = $Conteudo;
                // $mail->AltBody = $strMensagem;

                if(!$mail->Send()) {
                    throw new Exception("Mailer Error: " . $mail->ErrorInfo . "(".$mail->Host.")", 21);
                } else {
                    self::$_erro = 0;
                    self::$_mensagem = "Mensagem enviar com sucesso para o email: $ToAddress\n";
                    return true;
                }
                //*/
        }catch ( Exception $ex ){ self::$_mensagem = $ex->getMessage(); self::$_erro = $ex->getCode(); return false; }
    }

}