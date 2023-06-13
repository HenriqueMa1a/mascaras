<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once ('../admin/includes/global.php');
require_once ("../admin/funcoes/Validacao.class.php");
require_once ("../admin/funcoes/Mensagem.class.php");
require_once ('../admin/modelo/UsuarioDAO.class.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 171;
$response->mensagem = "inicio da processamento.";

$ENVIAR_EMAIL = 0;
$MOD_TITULO = 'Cadastro de Usuário';
$MOD_EMAIL = 'contato@bio.fiocruz.br';
$MOD_SENHA = '123456'; // '';
                       
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
		
		default :
			$response->mensagem = "Ação não encontrada para este controle. <br/>(metodo: GET, acao:'$acao').";
			
			break;
	}
} else if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
	isset ( $_POST ['acao'] ) ? $acao = $_POST ['acao'] : $acao = '';
	
	switch ($acao) {
		
		case ("acesso") :
			
			isset ( $_POST ['Email'] ) ? $Email = limpa_sql_injection ( $_POST ['Email'] ) : $Email = '';
			isset ( $_POST ['Senha'] ) ? $Senha = limpa_sql_injection ( $_POST ['Senha'] ) : $Senha = 'senha';
			// echo "[IdUsuario:$IdUsuario][IdTipoUsuario:$IdTipoUsuario][IdStatusUsuario:$IdStatusUsuario][IdPais:$IdPais][IdEstado:$IdEstado][Nome:$Nome][Cpf:$Cpf][Email:$Email][Cidade:$Cidade][Novidade:$Novidade]<br/>";
			
			// Validação
			try {
				
				if (! Validacao::validarEmail ( $Email )) {
					$response->mensagem = "O campo email, <b>$Email</b>, está com o formato inválido.";
					break;
				}
				
				$objUsuario = new Usuario ();
				$DAO = new UsuarioDAO ();
				
				$objUsuario = $DAO->validaUsuario ( $Email, $Senha );
				if ($objUsuario) {
					
					// echo "passo 4<br/>";
					
					// Usuário validade e liberado para uso;
					$ERRO_CODIGO = 0;
					$USO_ID = $objUsuario->getId ();
					$USO_NOME = $objUsuario->getNome ();
					$USO_EMAIL = $objUsuario->getEmail ();
					$USO_POLITICA = 0; // $objUsuario->getPolitica();
					$USO_VENDEDOR = 1;
					$USO_TIMESTAMP = time ();
					
					$USO_PERFIL = $objUsuario->getPerfil (); // O Perfil do Usuario ?
					$objUsuario->getGerente () ? $USO_GERENTE = 1 : $USO_GERENTE = 0; // Eh Gerente ?
					$objUsuario->getAdmin () ? $USO_ADMIN = 1 : $USO_ADMIN = 0; // Eh Administrador ?
					
					$USO_CHAVE = time () + (60 * 20); // 20 minutos
					$USO_SESSAO = session_id ();
					$USO_CHAVE = dechex ( $USO_CHAVE ); // converte para hexdecimal
					                                 
					// echo "passo 2<br/>";
					
					isset ( $_SERVER ["REMOTE_HOST"] ) ? $REMOTE_HOST = $_SERVER ["REMOTE_HOST"] : $REMOTE_HOST = '';
					isset ( $_SERVER ["REMOTE_ADDR"] ) ? $REMOTE_ADDR = $_SERVER ["REMOTE_ADDR"] : $REMOTE_ADDR = '';
					
					$USO_VALIDADE = time () + (60 * 60 * 24 * 30);
					
					$_SESSION ['USO_ID'] = $USO_ID;
					$_SESSION ['USO_SESSAO'] = $USO_SESSAO;
					$_SESSION ['USO_CHAVE'] = $USO_CHAVE;
					$_SESSION ['USO_NOME'] = $USO_NOME;
					$_SESSION ['USO_EMAIL'] = $USO_EMAIL;
					$_SESSION ['USO_POLITICA'] = $USO_POLITICA;
					$_SESSION ['USO_ADMIN'] = $USO_ADMIN;
					$_SESSION ['USO_GERENTE'] = $USO_GERENTE;
					$_SESSION ['USO_PERFIL'] = $USO_PERFIL;
					$_SESSION ['USO_VALIDADE'] = $USO_VALIDADE;
					$SessionID = session_id ();
					
					// Registra o Acesso
					$DAO->registaAcesso ( $USO_ID );
					
					$response->sucesso = 1;
					$response->erro = 175;
					$response->mensagem = "<b>$USO_NOME</b>, você foi autenticado com sucesso.";
				}
			} catch ( Exception $ex ) {
				$response->mensagem = utf8_encode ( "Erro: " . $ex->getMessage () );
			}
			
			break;
		
		default :
			$response->mensagem = "Ação não encontrada para este controle.<br/>(metodo: POST, acao:'$acao')";
			
			break;
	}
} else {
	
	$response->mensagem = "Método de envio não identificado.";
}

echo json_encode ( $response );

?> 