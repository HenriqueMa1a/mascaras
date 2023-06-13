<?php
require_once ('../admin/includes/global.php');
require_once ("../admin/funcoes/Validacao.class.php");
require_once ("../admin/funcoes/Mensagem.class.php");
require_once ('../admin/modelo/UsuarioDAO.class.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 171;
$response->mensagem = utf8_encode ( "inicio da processamento." );

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
			$response->mensagem = utf8_encode ( "Ação não encontrada para este controle. <br/>(metodo: GET, acao:'$acao')." );
			
			break;
	}
} else if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
	isset ( $_POST ['acao'] ) ? $acao = $_POST ['acao'] : $acao = '';
	
	switch ($acao) {
		
		case ("cadastre-se") :
			
			isset ( $_POST ['IdTipoUsuario'] ) ? $IdTipoUsuario = limpa_sql_injection ( $_POST ['IdTipoUsuario'] ) : $IdTipoUsuario = '0';
			$IdStatusUsuario = '2'; // 2 = Cadastrado;
			isset ( $_POST ['Nome'] ) ? $Nome = limpa_sql_injection ( $_POST ['Nome'] ) : $Nome = '';
			isset ( $_POST ['Cpf'] ) ? $Cpf = limpa_sql_injection ( $_POST ['Cpf'] ) : $Cpf = '';
			isset ( $_POST ['Email'] ) ? $Email = limpa_sql_injection ( $_POST ['Email'] ) : $Email = '';
			isset ( $_POST ['Cidade'] ) ? $Cidade = limpa_sql_injection ( $_POST ['Cidade'] ) : $Cidade = '';
			isset ( $_POST ['IdEstado'] ) ? $IdEstado = limpa_sql_injection ( $_POST ['IdEstado'] ) : $IdEstado = '0';
			isset ( $_POST ['IdPais'] ) ? $IdPais = limpa_sql_injection ( $_POST ['IdPais'] ) : $IdPais = '';
			isset ( $_POST ['Novidade'] ) ? $Novidade = limpa_sql_injection ( $_POST ['Novidade'] ) : $Novidade = '0';
			isset ( $_POST ['Senha'] ) ? $Senha = limpa_sql_injection ( $_POST ['Senha'] ) : $Senha = 'senha';
			// echo "[IdUsuario:$IdUsuario][IdTipoUsuario:$IdTipoUsuario][IdStatusUsuario:$IdStatusUsuario][IdPais:$IdPais][IdEstado:$IdEstado][Nome:$Nome][Cpf:$Cpf][Email:$Email][Cidade:$Cidade][Novidade:$Novidade]<br/>";
			
			// Validação
			try {
				
				if (! Validacao::validarEmail ( $Email )) {
					$response->mensagem = utf8_encode ( "O campo email, <b>$Email</b>, está com o formato inválido." );
					break;
				}
				
				$obj = new Usuario ();
				$DAO = new UsuarioDAO ();
				
				$obj = $DAO->retornaPorEmail ( $Email );
				if ($obj) {
					// Usuário é do tipo 1=Poencial ?
					if ($obj->getIdStatusUsuario () == 1) {
						
						$obj->setIdTipoUsuario ( $IdTipoUsuario );
						$obj->setIdStatusUsuario ( $IdStatusUsuario );
						$obj->setIdPais ( $IdPais );
						$obj->setIdEstado ( $IdEstado );
						$obj->setNome ( $Nome );
						// $obj->setCpf($Cpf);
						$obj->setEmail ( $Email );
						$obj->setCidade ( $Cidade );
						$obj->setNovidade ( $Novidade );
						$obj->getIdStatusUsuario ( 2 ); // Cadastrado;
						$obj->setAtivo ( 1 );
						
						if ($DAO->atualiza ( $obj )) {
							
							// Atualizar a senha;
							$obj->setSenha ( $Senha );
							if ($DAO->atualizaSenha ( $obj )) {
								
								$Nome = utf8_decode ( $Nome );
								// enviar Email;
								$Conteudo = "";
								$Conteudo .= "Olá <em>$Nome</em>!<br/>";
								$Conteudo .= "<br/>";
								$Conteudo .= "Seu cadastro no <b>Bio-Manguinhos (www.bio.fiocruz.br)</b> foi criado. Abaixo estão seu e-mail e senha para acesso. Guarde-os em um local seguro.<br/>";
								$Conteudo .= "Email: $Email<br/>";
								$Conteudo .= "Senha: $Senha<br/>";
								$Conteudo .= "<br/>";
								$Conteudo .= "Atenciosamente,<br/>";
								$Conteudo .= "<b>Bio-Manguinhos</b><br/>";
								$Conteudo .= "www.bio.fiocruz.br<br/>";
								$Conteudo .= "";
								
								if ($ENVIAR_EMAIL) {
									if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
										$response->sucesso = 1;
										$response->erro = 173;
										$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram cadastrados com sucesso." );
									} else {
										$response->erro = 164;
										$response->mensagem = utf8_encode ( "Erro no envio de email." );
									}
								} else {
									$response->sucesso = 1;
									$response->erro = 073;
									$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram cadastrados com sucesso." );
								}
							} else
								$response->mensagem = utf8_encode ( $DAO->getMensagem () );
						} else
							$response->mensagem = utf8_encode ( $DAO->getMensagem () );
					} else
						$response->mensagem = utf8_encode ( "<b>" . $obj->getNome () . "</b>, você já faz parte de nosso cadastro. Favor efetuar o login para atualizar os seu dados." );
				} else {
					$obj = new Usuario ();
					$obj->setIdTipoUsuario ( $IdTipoUsuario );
					$obj->setIdStatusUsuario ( 2 ); // 2 = Cadastrado;
					$obj->setIdPais ( $IdPais );
					$obj->setIdEstado ( $IdEstado );
					$obj->setNome ( $Nome );
					// $obj->setCpf($Cpf);
					$obj->setEmail ( $Email );
					$obj->setSenha ( $Senha );
					$obj->setCidade ( $Cidade );
					$obj->setNovidade ( $Novidade );
					$obj->setAtivo ( 1 );
					
					if ($DAO->salva ( $obj )) {
						
						$Nome = utf8_decode ( $Nome );
						// enviar Email;
						$Conteudo = "";
						$Conteudo .= "Olá <em>$Nome</em>!<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Seu cadastro no <b>Bio-Manguinhos (www.bio.fiocruz.br)</b> foi criado. Abaixo estão seu e-mail e senha para acesso. Guarde-os em um local seguro.<br/>";
						$Conteudo .= "Email: $Email<br/>";
						$Conteudo .= "Senha: $Senha<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Atenciosamente,<br/>";
						$Conteudo .= "<b>Bio-Manguinhos</b><br/>";
						$Conteudo .= "www.bio.fiocruz.br<br/>";
						$Conteudo .= "";
						
						if ($ENVIAR_EMAIL) {
							if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
								$response->sucesso = 1;
								$response->erro = 172;
								$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram cadastrados com sucesso." );
							} else {
								$response->erro = 164;
								$response->mensagem = utf8_encode ( "Erro no envio de email." );
							}
						} else {
							$response->sucesso = 1;
							$response->erro = 072;
							$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram cadastrados com sucesso." );
						}
					} else
						$response->mensagem = utf8_encode ( $DAO->getMensagem () );
				}
			} catch ( PDOException $ex ) {
				$response->mensagem = utf8_encode ( "Erro: " . $ex->getMessage () );
			}
			
			break;
		
		case ("cadastrar-news") :
			
			$MOD_TITULO = 'Cadastro de newsletter';
			
			isset ( $_POST ['IdTipoUsuario'] ) ? $IdTipoUsuario = limpa_sql_injection ( $_POST ['IdTipoUsuario'] ) : $IdTipoUsuario = '0';
			$IdStatusUsuario = '1'; // Potencial;
			isset ( $_POST ['formNewsNome'] ) ? $Nome = limpa_sql_injection ( $_POST ['formNewsNome'] ) : $Nome = '';
			isset ( $_POST ['formNewsEmail'] ) ? $Email = limpa_sql_injection ( $_POST ['formNewsEmail'] ) : $Email = '';
			// echo "[IdUsuario:$IdUsuario][IdTipoUsuario:$IdTipoUsuario][IdStatusUsuario:$IdStatusUsuario][IdPais:$IdPais][IdEstado:$IdEstado][Nome:$Nome][Cpf:$Cpf][Email:$Email][Cidade:$Cidade][Novidade:$Novidade]<br/>";
			
			// Validação
			try {
				
				if (! Validacao::validarEmail ( $Email )) {
					$response->mensagem = utf8_encode ( "O campo email, <b>$Email</b>, está com o formato inválido." );
					break;
				}
				
				$obj = new Usuario ();
				$DAO = new UsuarioDAO ();
				
				$obj = $DAO->retornaPorEmail ( $Email );
				if ($obj) {
					
					$response->mensagem = utf8_encode ( "O email <b>" . $Email . "</b> já faz parte de nosso cadastro." );
				} else {
					$obj = new Usuario ();
					$obj->setIdTipoUsuario ( 4 ); // 4 = Outros
					$obj->setIdStatusUsuario ( 1 ); // 1 = Potencial;
					$obj->setIdPais ( 31 ); // 31 = Brasil
					$obj->setIdEstado ( 10 ); // 19 = Rio de Janeiro
					$obj->setNome ( $Nome );
					// $obj->setCpf($Cpf);
					$obj->setEmail ( $Email );
					// $obj->setCidade($Cidade);
					$obj->setNovidade ( 1 );
					$obj->setAtivo ( 1 );
					
					if ($DAO->salva ( $obj )) {
						
						$Nome = utf8_decode ( $Nome );
						// enviar Email;
						$Conteudo = "";
						$Conteudo .= "Olá <em>$Nome</em>!<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Seu cadastro no <b>Bio-Manguinhos (www.bio.fiocruz.br)</b> foi criado. Abaixo estão seu e-mail e senha para acesso. Guarde-os em um local seguro.<br/>";
						$Conteudo .= "Email: $Email<br/>";
						$Conteudo .= "Senha: $Senha<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Atenciosamente,<br/>";
						$Conteudo .= "<b>Bio-Manguinhos</b><br/>";
						$Conteudo .= "www.bio.fiocruz.br<br/>";
						$Conteudo .= "";
						
						if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
							$response->sucesso = 1;
							$response->erro = 175;
							$response->mensagem = utf8_encode ( "<b>$Nome</b>, seu email foi cadastrado com sucesso." );
						} else {
							$response->erro = 164;
							$response->mensagem = utf8_encode ( "Erro no envio de email." );
						}
					} else
						$response->mensagem = utf8_encode ( $DAO->getMensagem () );
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