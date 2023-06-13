<?php
require_once ('../admin/includes/global.php');
require_once ('../admin/funcoes/Formatacao.class.php');
require_once ('../admin/funcoes/Arquivo.class.php');

require_once ('../admin/modelo/ModuloDAO.class.php');
require_once ('../admin/modelo/UsuarioDAO.class.php');
require_once ('../admin/modelo/ConteudoDAO.class.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 152;
$response->mensagem = utf8_encode ( "inicio do processamento." );

$response->page = 0;
$response->total = 0;
$response->records = 0;

// IsOnLine();

// echo "B[SERVER['REQUEST_METHOD']:".$_SERVER['REQUEST_METHOD']."]<br/>";

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	// echo "[_GET['acao']:".$_GET['acao']."]";
	isset ( $_GET ['operacao'] ) ? $operacao = $_GET ['operacao'] : $operacao = '';
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
	isset ( $_POST ['page'] ) ? $page = $_POST ['page'] : $page = '';
	isset ( $_POST ['rows'] ) ? $rows = $_POST ['rows'] : $rows = '';
	isset ( $_POST ['sidx'] ) ? $sidx = $_POST ['sidx'] : $sidx = '';
	isset ( $_POST ['sord'] ) ? $sord = $_POST ['sord'] : $sord = '';
	if (! $sidx)
		$sidx = 1;
	
	switch ($acao) {
		
		case ("criar-resumo") :
			
			isset ( $_POST ['IdUsuario'] ) ? $IdUsuario = limpa_sql_injection ( $_POST ['IdUsuario'] ) : $IdUsuario = '0';
			// Resumo
			isset ( $_POST ['TipoResumo'] ) ? $TipoResumo = limpa_sql_injection ( $_POST ['TipoResumo'] ) : $TipoResumo = '1';
			isset ( $_POST ['TituloResumo'] ) ? $TituloResumo = limpa_sql_injection ( $_POST ['TituloResumo'] ) : $TituloResumo = '';
			isset ( $_POST ['ConteudoResumo'] ) ? $ConteudoResumo = limpa_sql_injection ( $_POST ['ConteudoResumo'] ) : $ConteudoResumo = '';
			isset ( $_POST ['AutoresResumo'] ) ? $AutoresResumo = limpa_sql_injection ( $_POST ['AutoresResumo'] ) : $AutoresResumo = '';
			isset ( $_POST ['InstituicaoResumo'] ) ? $InstituicaoResumo = limpa_sql_injection ( $_POST ['InstituicaoResumo'] ) : $InstituicaoResumo = '';
			isset ( $_POST ['FlagPolitica'] ) ? $FlagPolitica = limpa_sql_injection ( $_POST ['FlagPolitica'] ) : $FlagPolitica = '0';
			
			// echo "[IdUsuario:$IdUsuario][IdTipoUsuario:$IdTipoUsuario][IdStatusUsuario:$IdStatusUsuario][IdPais:$IdPais][IdEstado:$IdEstado][Nome:$Nome][Cpf:$Cpf][Email:$Email][Cidade:$Cidade][CanalComunicacao:$CanalComunicacao]<br/>";
			
			try {
				
				// Validação
				$IdStatus = '1'; // 1 = Cadastrado/Submetido
				$FlagResumo = '1';
				if (! $FlagPolitica)
					$FlagPolitica = '0';
				if (! $TipoResumo)
					$TipoResumo = 4; // Outros
				
				$obj = new Usuario ();
				$DAO = new UsuarioDAO ();
				
				$obj = $DAO->retorna ( $IdUsuario );
				if ($obj) {
					$Nome = $obj->getNome ();
					$Email = $obj->getEmail ();
					
					$DAO1 = new ConteudoDAO ();
					
					$Revisao = 1;
					$obj1 = new Conteudo ();
					$obj1->setIdUsuario ( $IdUsuario );
					$obj1->setTipo ( $TipoResumo );
					$obj1->setTitulo ( $TituloResumo );
					$obj1->setAutores ( $AutoresResumo );
					$obj1->setInstituicao ( $InstituicaoResumo );
					$obj1->setConteudo ( $ConteudoResumo );
					$obj1->setIdStatus ( $IdStatus );
					$obj1->setRevisao ( $Revisao );
					$obj1->setFlagPolitica ( $FlagPolitica );
					$obj1->setAtivo ( 1 );
					
					if ($DAO1->salva ( $obj1 )) {
						$IdConteudo = $obj1->getId ();
						$response->IdConteudo = $obj1->getId ();
						$response->FlagResumo = $FlagResumo;
						
						// Anexar Arquivo
						$NomeArquivo = 'Resumo ' . $IdConteudo;
						if (Arquivo::gravarArquivo ( 'Arquivo', $NomeArquivo, '../arquivos/' )) { // Foi feito upload da ?
							$NomeArquivo = Arquivo::getNome ();
							$DAO1->atualizarArquivo ( $IdConteudo, $NomeArquivo, $IdConteudo, $Revisao );
							$response->Arquivo = $NomeArquivo;
						} else {
							$response->sucesso = 1;
							$response->erro = Arquivo::getErro ();
							$response->mensagem = utf8_encode ( Arquivo::getMensagem () );
						}
						
						$Nome = utf8_decode ( $Nome );
						// enviar Email;
						$Conteudo = "";
						$Conteudo .= "Olá <em>$Nome</em>!<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Seu resumo foi enviado com sucesso. <br/> Assim que seja avaliado pela banca você receberá um email de contato.<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Atenciosamente,<br/>";
						$Conteudo .= "<b>Bio-Manguinhos</b><br/>";
						$Conteudo .= "www.bio.fiocruz.br<br/>";
						$Conteudo .= "";
						
						if ($ENVIAR_EMAIL) {
							if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
								$response->sucesso = 1;
								$response->erro = 172;
								$response->mensagem = "<b>$Nome</b>, o seu resumo com Titulo '$TituloResumo' foi enviado com sucesso.";
							} else {
								$response->erro = 164;
								$response->mensagem = "Erro no envio de email.";
							}
						} else {
							$response->sucesso = 1;
							$response->erro = 072;
							$response->mensagem = "<b>$Nome</b>, o seu resumo com o Titulo '$TituloResumo' foi enviado com sucesso.";
						}
					} else
						$response->mensagem = $DAO->getMensagem ();
				} else {
					$response->mensagem = utf8_encode ( "Usuário com identificador  <b>$IdUsuario</b> não foi encontrado na base de dados." );
				}
			} catch ( PDOException $ex ) {
				$response->mensagem = "Erro: " . $ex->getMessage ();
			}
			
			break;
		
		case ("alterar-resumo") :
			
			isset ( $_POST ['IdUsuario'] ) ? $IdUsuario = limpa_sql_injection ( $_POST ['IdUsuario'] ) : $IdUsuario = '0';
			isset ( $_POST ['IdConteudo'] ) ? $IdConteudo = limpa_sql_injection ( $_POST ['IdConteudo'] ) : $IdConteudo = '0';
			// Resumo
			isset ( $_POST ['TipoResumo'] ) ? $TipoResumo = limpa_sql_injection ( $_POST ['TipoResumo'] ) : $TipoResumo = '1';
			isset ( $_POST ['TituloResumo'] ) ? $TituloResumo = limpa_sql_injection ( $_POST ['TituloResumo'] ) : $TituloResumo = '';
			isset ( $_POST ['ConteudoResumo'] ) ? $ConteudoResumo = limpa_sql_injection ( $_POST ['ConteudoResumo'] ) : $ConteudoResumo = '';
			isset ( $_POST ['AutoresResumo'] ) ? $AutoresResumo = limpa_sql_injection ( $_POST ['AutoresResumo'] ) : $AutoresResumo = '';
			isset ( $_POST ['InstituicaoResumo'] ) ? $InstituicaoResumo = limpa_sql_injection ( $_POST ['InstituicaoResumo'] ) : $InstituicaoResumo = '';
			isset ( $_POST ['FlagPolitica'] ) ? $FlagPolitica = limpa_sql_injection ( $_POST ['FlagPolitica'] ) : $FlagPolitica = '0';
			
			// echo "[IdUsuario:$IdUsuario][IdTipoUsuario:$IdTipoUsuario][IdStatusUsuario:$IdStatusUsuario][IdPais:$IdPais][IdEstado:$IdEstado][Nome:$Nome][Cpf:$Cpf][Email:$Email][Cidade:$Cidade][CanalComunicacao:$CanalComunicacao]<br/>";
			
			try {
				
				// Validação
				$IdStatus = '1'; // 1 = Cadastrado/Submetido
				$FlagResumo = '1';
				if (! $FlagPolitica)
					$FlagPolitica = '0';
				if (! $TipoResumo)
					$TipoResumo = 4; // Outros
				
				$obj = new Usuario ();
				$DAO = new UsuarioDAO ();
				
				$obj = $DAO->retorna ( $IdUsuario );
				if ($obj) {
					$Nome = $obj->getNome ();
					$Email = $obj->getEmail ();
					
					$DAO1 = new ConteudoDAO ();
					
					$obj1 = new Conteudo ();
					$obj1 = $DAO1->retorna ( $IdConteudo );
					if ($obj1) {
						$IdOriginalConteudo = $IdConteudo;
						$Revisao = $obj1->getRevisao () + 1;
						$NomeArquivo = 'Resumo ' . $IdOriginalConteudo . ' (Revisao ' . $Revisao . ')';
						
						// Anexar Arquivo
						if (Arquivo::gravarArquivo ( 'Arquivo', $NomeArquivo, '../arquivos/' )) { // Foi feito upload da ?
							$NomeArquivo = Arquivo::getNome ();
							$DAO1->atualizarArquivo ( $IdConteudo, $NomeArquivo, $IdOriginalConteudo, $Revisao );
							$response->Arquivo = $NomeArquivo;
						} else {
							$response->sucesso = 1;
							$response->erro = Arquivo::getErro ();
							$response->mensagem = utf8_encode ( Arquivo::getMensagem () );
						}
						
						$Nome = utf8_decode ( $Nome );
						// enviar Email;
						$Conteudo = "";
						$Conteudo .= "Olá <em>$Nome</em>!<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Seu resumo foi enviado com sucesso. <br/> Assim que seja avaliado pela banca você receberá um email de contato.<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Atenciosamente,<br/>";
						$Conteudo .= "<b>Bio-Manguinhos</b><br/>";
						$Conteudo .= "www.bio.fiocruz.br<br/>";
						$Conteudo .= "";
						
						if ($ENVIAR_EMAIL) {
							if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
								$response->sucesso = 1;
								$response->erro = 172;
								$response->mensagem = "<b>$Nome</b>, o seu resumo com Titulo '$TituloResumo' foi enviado com sucesso.";
							} else {
								$response->erro = 164;
								$response->mensagem = "Erro no envio de email.";
							}
						} else {
							$response->sucesso = 1;
							$response->erro = 072;
							$response->mensagem = "<b>$Nome</b>, o seu resumo com o Titulo '$TituloResumo' foi enviado com sucesso.";
						}
					} else {
						$response->mensagem = utf8_encode ( "Resumo com identificador  <b>$IdResumo</b> não foi encontrado na base de dados." );
					}
				} else {
					$response->mensagem = utf8_encode ( "Usuário com identificador  <b>$IdUsuario</b> não foi encontrado na base de dados." );
				}
			} catch ( PDOException $ex ) {
				$response->mensagem = "Erro: " . $ex->getMessage ();
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