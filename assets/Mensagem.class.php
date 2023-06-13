<?
/**
* @description Classe de Formatação de campos. 
* @author Kellen Nery
*/

// Includes
require_once("phpmailer/class.phpmailer.php");

//set_time_limit(120);
// EnviaMail($arrLista[$i][2], $arrLista[$i][3], $EML_DOC_NOME, $EML_DOC_EMAIL, $EML_DOC_EMAIL_SENHA, $EML_DOC_ASSUNTO, $strHTMLEmail, "")

class Mensagem {

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
	*   @param string $FromName O Nome da pessoa a ser enviada a mensagem 
	*   @param string $FromAddress O Nome da pessoa a ser enviada a mensagem 
	*   @param string $FromPassword O Nome da pessoa a ser enviada a mensagem 
	*   @param string $Assunto O assunto da mensagem a ser enviada
	*   @param string $Conteudo O Conteudo da mensagem a ser enviada
	*   @param string $Anexo O Nome da pessoa a ser enviada a mensagem 
	*   @return boolean TRUE Se a mensagem de email for enviada com sucesso
	*/
	public static function enviar($ToName, $ToAddress, $FromName, $FromAddress, $FromPassword, $Assunto, $Conteudo, $Anexo = null, $CC = null){

		global $sisConfig;

		try {

			$mail = new PHPMailer();

			// CONFIGURAÇÃO DO SERVIDOR
			$mail->SetLanguage("br", "phpmailer/language/");
			$mail->Mailer = "smtp";             //Usando protocolo SMTP
			$mail->IsSMTP();                    // Falg de uso SMTP
			$mail->SMTPAuth = true;             // uso de SMTP authentication
			$mail->Host = $sisConfig->SmptHost;  	// "mail.".$EMP_URL;     // seu servidor SMTP
			$mail->Port = $sisConfig->SmptPort;  	// "mail.".$EMP_URL;     // seu servidor SMTP
			$mail->SMTPDebug  = true;
			$mail->CharSet = "UTF-8";
			$mail->Timeout = 20;

			//$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
			//$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
			//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			//$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
			
			// USUARIO E SENHA
			$mail->Username = $FromAddress;     // SMTP username
			$mail->Password = $FromPassword;    // SMTP password
			
			// DE:
			$mail->From = $FromAddress;
			$mail->FromName = $FromName;
			
			// PARA:
			$mail->AddAddress($ToAddress, $ToName); // name is optional
			if ($CC)
				$mail->AddCC($CC);
			// $mail->AddReplyTo("comercial@asasolucoes.com");

			$mail->WordWrap = 50;                                 // set word wrap to 50 characters
			//$mail->AddAttachment("/var/tmp/file.tar.gz");         // add attachments
			//$mail->AddAttachment($ANEXO1);    // optional name
			//$mail->AddAttachment($ANEXO2);    // optional name
			$mail->IsHTML(true);                                  // set email format to HTML

			$mail->Subject = $Assunto;
			$mail->Body    = $Conteudo;
			// $mail->AltBody = $strMensagem;

			if(!$mail->Send()) {
				//$ERRO_NOTAS = "Mailer Error: " . $mail->ErrorInfo . "(".$mail->Host.")(".$mail->Username.")(".$mail->Password.")"; // (mccDEBUG)
				throw new Exception("Mailer Error: " . $mail->ErrorInfo . "(".$mail->Host.")", 21);
				return false;
			} else {
				self::$_erro = 0;
				self::$_mensagem = "Mensagem enviar com sucesso para o email: $ToAddress\n";
				return true;
			}
			//*/

        }catch ( Exception $ex ){ self::$_mensagem = $ex->getMessage(); self::$_erro = $ex->getCode(); return false; }
			
	}

	public static function enviarGmail($ToName, $ToAddress, $FromName, $FromAddress, $FromPassword, $Assunto, $Conteudo, $Anexo = null){

		global $EMP_URL;
			
		try {
			//echo "SMTP=smtp.".$EMP_URL."<br/>";
		
			$mail = new PHPMailer();
			
			// CONFIGURAÇÃO DO SERVIDOR
			$mail->IsSMTP();                    // Falg de uso SMTP
			$mail->SetLanguage("br", "plugins/phpmailer/language/");
			//$mail->Host = "smtp.".$EMP_URL;   // seu servidor SMTP
			//$mail->Host = "gmail-smtp-in.l.google.com";       // servidor para google/apps

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

			$mail->SMTPAuth = true;             // uso de SMTP authentication
			//$mail->Timeout = 20;
			
			/* 
			// Configuração para Email do GMAIL.
			$mail->Host = "smtp.gmail.com"; // specify main and backup server
			$mail->SMTPAuth = true;   // turn on SMTP authentication
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
				return false;
			} else {
				self::$_erro = 0;
				self::$_mensagem = "Mensagem enviar com sucesso para o email: $ToAddress\n";
				return true;
			}
			//*/
        }catch ( Exception $ex ){ self::$_mensagem = $ex->getMessage(); self::$_erro = $ex->getCode(); return false; }

	}
	
}

?>