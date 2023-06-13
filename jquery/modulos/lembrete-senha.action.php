<?php
require_once ('../admin/includes/global.php');
require_once ("../admin/funcoes/Validacao.class.php");
require_once ("../admin/funcoes/Mensagem.class.php");
require_once ('../admin/modelo/UsuarioDAO.class.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 161;
$response->mensagem = utf8_encode ( "inicio da processamento." );

$ENVIAR_EMAIL = 1;
$MOD_TITULO = 'Lembrete de Senha de acesso';
$MOD_EMAIL = 'sact@bio.fiocruz.br';
$MOD_SENHA = 's@ctb!0'; // '';
                        // IsOnLine();
                        
// echo "B[SERVER['REQUEST_METHOD']:".$_SERVER['REQUEST_METHOD']."]<br/>";

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	// echo "[_GET['acao']:".$_GET['acao']."]";
	isset ( $_GET ['acao'] ) ? $acao = $_GET ['acao'] : $acao = '';
	isset ( $_GET ['page'] ) ? $page = $_GET ['page'] : $page = '';
	isset ( $_GET ['rows'] ) ? $rows = $_GET ['rows'] : $rows = '';
	isset ( $_GET ['sidx'] ) ? $sidx = $_GET ['sidx'] : $sidx = '';
	isset ( $_GET ['sord'] ) ? $sord = $_GET ['sord'] : $sord = '';
	if (! $sidx)
		$sidx = 1;
	
	switch ($acao) {
		
		case ("enviar-senha") :
			$response->mensagem = utf8_encode ( "Esta Ação deve ser enviado pelo método POST." );
			
			break;
		
		default :
			$response->mensagem = utf8_encode ( "Ação não encontrada para este controle. <br/>(metodo: GET, acao:'$acao')." );
			
			break;
	}
} else if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
	isset ( $_POST ['acao'] ) ? $acao = $_POST ['acao'] : $acao = '';
	
	switch ($acao) {
		
		case ("enviar-senha") :
			
			isset ( $_POST ['Email'] ) ? $Email = limpa_sql_injection ( $_POST ['Email'] ) : $Email = '';
			
			try {
				if (Validacao::validarEmail ( $Email )) {
					$obj = new Usuario ();
					$DAO = new UsuarioDAO ();
					
					$obj = $DAO->retornaPorEmail ( $Email );
					if ($obj) {
						$Nome = $obj->getNome ();
						$Senha = $obj->getSenha ();
						
						$Conteudo = "";
						$Conteudo .= "Prezado(a) <em>$Nome</em>,<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Seu lembrete foi enviado com sucesso. Abaixo estão seu e-mail e senha para acesso. Guarde-os em um local seguro.<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Email: $Email<br/>";
						$Conteudo .= "Senha: $Senha<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Atenciosamente,<br/>";
						$Conteudo .= "<b>Comissão Científica e Tecnológica em Imunobiológicos</b><br/>";
						$Conteudo .= "<b>Bio-Manguinhos | FIOCRUZ</b><br/>";
						$Conteudo .= "http://sact.bio.fiocruz.br<br/>";
						$Conteudo .= "";
						
						if ($ENVIAR_EMAIL) {
							if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
								$response->sucesso = 1;
								$response->erro = 0;
								$response->mensagem = utf8_encode ( "<b>$Nome</b>, sua senha foi enviada com sucesso para o email <b>$Email</b>." );
							} else {
								$response->erro = 164;
								$response->mensagem = utf8_encode ( "Erro no envio de email. (" . Mensagem::getMensagem () . ")" );
							}
						} else {
							$response->sucesso = 1;
							$response->erro = 064;
							$response->mensagem = utf8_encode ( "<b>$Nome</b>, sua senha foi enviada com sucesso para o email <b>$Email</b>." );
						}
					} else {
						$response->erro = 163;
						$response->mensagem = utf8_encode ( "O email <b>$Email</b> não faz parte de nosso cadastro." );
					}
				} else {
					$response->erro = 152;
					$response->mensagem = utf8_encode ( "O email, <b>$Email</b>, está com o formato inválido." );
				}
			} catch ( PDOException $ex ) {
				$response->mensagem = utf8_encode ( "Erro: " . $ex->getMessage () );
			}
			
			break;
		
		default :
			$response->mensagem = utf8_encode ( "Ação não encontrada para este controle.<br/>(metodo: POST, acao:'$acao')" );
			
			break;
	}
} else {
	$response->mensagem = utf8_encode ( "Método de envio não identificado." );
}

echo json_encode ( $response );

?> 