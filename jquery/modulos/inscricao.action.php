<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once ('../admin/includes/global.php');
require_once ("../admin/funcoes/Validacao.class.php");
require_once ("../admin/funcoes/Formatacao.class.php");
require_once ("../admin/funcoes/Mensagem.class.php");
require_once ('../admin/modelo/UsuarioDAO.class.php');
require_once ('../admin/modelo/ConteudoDAO.class.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 171;
$response->passo = 0;
$response->mensagem = utf8_encode ( "inicio da processamento." );

$ENVIAR_EMAIL = 1;
$MOD_TITULO = 'Confirmação de inscrição';
$MOD_EMAIL = 'sact@bio.fiocruz.br';
$MOD_SENHA = 's@ctb!0';

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
			case ("retornar") :
				$IdInscricao = isset ( $_GET['IdInscricao'] ) ? limpa_sql_injection ( $_GET['IdInscricao'] ) : 0;
				$IdUsuario = isset ( $_GET['IdUsuario'] ) ? limpa_sql_injection ( $_GET['IdUsuario'] ) : 0;
				
			break;
			
		default :
			$response->mensagem = utf8_encode ( "Ação não encontrada para este controle. <br/>(metodo: GET, acao:'$acao')." );
			
			break;
	}
} else if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
	isset ( $_POST ['acao'] ) ? $acao = $_POST ['acao'] : $acao = '';
	
	switch ($acao) {
		
		case ("cadastre-se") :
			
			isset ( $_POST ['IdTipoUsuario'] ) ? $IdTipoUsuario = limpa_sql_injection ( $_POST ['IdTipoUsuario'] ) : $IdTipoUsuario = '0';
			isset ( $_POST ['Nome'] ) ? $Nome = limpa_sql_injection ( $_POST ['Nome'] ) : $Nome = '';
			isset ( $_POST ['Email'] ) ? $Email = limpa_sql_injection ( $_POST ['Email'] ) : $Email = '';
			isset ( $_POST ['Senha'] ) ? $Senha = limpa_sql_injection ( $_POST ['Senha'] ) : $Senha = 'senha';
			isset ( $_POST ['Telefone'] ) ? $Telefone = limpa_sql_injection ( $_POST ['Telefone'] ) : $Telefone = '';
			
			isset ( $_POST ['FlagColaborador'] ) ? $FlagColaborador = limpa_sql_injection ( $_POST ['FlagColaborador'] ) : $FlagColaborador = '0';
			isset ( $_POST ['UnidadeExterna'] ) ? $UnidadeExterna = limpa_sql_injection ( $_POST ['UnidadeExterna'] ) : $UnidadeExterna = '';
			isset ( $_POST ['ViceDiretoria'] ) ? $ViceDiretoria = limpa_sql_injection ( $_POST ['ViceDiretoria'] ) : $ViceDiretoria = '';
			isset ( $_POST ['Departamento'] ) ? $Departamento = limpa_sql_injection ( $_POST ['Departamento'] ) : $Departamento = '';
			isset ( $_POST ['Divisao'] ) ? $Divisao = limpa_sql_injection ( $_POST ['Divisao'] ) : $Divisao = '';
			isset ( $_POST ['Secao'] ) ? $Secao = limpa_sql_injection ( $_POST ['Secao'] ) : $Secao = '';
			isset ( $_POST ['autorizadoPor'] ) ? $AutorizadoPor = limpa_sql_injection ( $_POST ['autorizadoPor'] ) : $AutorizadoPor = '0';
			isset ( $_POST ['chefiaImediata'] ) ? $NomeChefiaImediata = limpa_sql_injection ( $_POST ['chefiaImediata'] ) : $NomeChefiaImediata = '';
			isset ( $_POST ['gerenteDep'] ) ? $NomeGerenteDepartamento = limpa_sql_injection ( $_POST ['gerenteDep'] ) : $NomeGerenteDepartamento = '';
			isset ( $_POST ['viceDir'] ) ? $NomeViceDiretoria = limpa_sql_injection ( $_POST ['viceDir'] ) : $NomeViceDiretoria = '';
			
			isset ( $_POST ['AreaAtuacao'] ) ? $AreaAtuacao = limpa_sql_injection ( $_POST ['AreaAtuacao'] ) : $AreaAtuacao = '';
			isset ( $_POST ['FormacaoAcademica'] ) ? $FormacaoAcademica = limpa_sql_injection ( $_POST ['FormacaoAcademica'] ) : $FormacaoAcademica = '';
			
			isset ( $_POST ['FlagAscom'] ) ? $FlagAscom = limpa_sql_injection ( $_POST ['FlagAscom'] ) : $FlagAscom = '0';
			isset ( $_POST ['FlagIndicacao'] ) ? $FlagIndicacao = limpa_sql_injection ( $_POST ['FlagIndicacao'] ) : $FlagIndicacao = '0';
			isset ( $_POST ['FlagBioMural'] ) ? $FlagBioMural = limpa_sql_injection ( $_POST ['FlagBioMural'] ) : $FlagBioMural = '0';
			isset ( $_POST ['FlagBioDigital'] ) ? $FlagBioDigital = limpa_sql_injection ( $_POST ['FlagBioDigital'] ) : $FlagBioDigital = '0';
			isset ( $_POST ['FlagWebTV'] ) ? $FlagWebTV = limpa_sql_injection ( $_POST ['FlagWebTV'] ) : $FlagWebTV = '0';
			isset ( $_POST ['FlagCartazes'] ) ? $FlagCartazes = limpa_sql_injection ( $_POST ['FlagCartazes'] ) : $FlagCartazes = '0';
			isset ( $_POST ['FlagOutros'] ) ? $FlagOutros = limpa_sql_injection ( $_POST ['FlagOutros'] ) : $FlagOutros = '0';
			
			// Resumo
			isset ( $_POST ['FlagResumo'] ) ? $FlagResumo = limpa_sql_injection ( $_POST ['FlagResumo'] ) : $FlagResumo = '0';
			isset ( $_POST ['DataNascimento'] ) ? $DataNascimento = limpa_sql_injection ( $_POST ['DataNascimento'] ) : $DataNascimento = '';
			isset ( $_POST ['TipoResumo'] ) ? $TipoResumo = limpa_sql_injection ( $_POST ['TipoResumo'] ) : $TipoResumo = '1';
			isset ( $_POST ['TituloResumo'] ) ? $TituloResumo = limpa_sql_injection ( $_POST ['TituloResumo'] ) : $TituloResumo = '';
			isset ( $_POST ['ConteudoResumo'] ) ? $ConteudoResumo = limpa_sql_injection ( $_POST ['ConteudoResumo'] ) : $ConteudoResumo = '';
			isset ( $_POST ['AutoresResumo'] ) ? $AutoresResumo = limpa_sql_injection ( $_POST ['AutoresResumo'] ) : $AutoresResumo = '';
			isset ( $_POST ['InstituicaoResumo'] ) ? $InstituicaoResumo = limpa_sql_injection ( $_POST ['InstituicaoResumo'] ) : $InstituicaoResumo = '';
			isset ( $_POST ['FlagPolitica'] ) ? $FlagPolitica = limpa_sql_injection ( $_POST ['FlagPolitica'] ) : $FlagPolitica = '0';
			
			// echo "[IdUsuario:$IdUsuario][IdTipoUsuario:$IdTipoUsuario][IdStatusUsuario:$IdStatusUsuario][IdPais:$IdPais][IdEstado:$IdEstado][Nome:$Nome][Cpf:$Cpf][Email:$Email][Cidade:$Cidade][CanalComunicacao:$CanalComunicacao]<br/>";
			
			// Validação
			try {
				
				if (! Validacao::validarEmail ( $Email )) {
					$response->mensagem = utf8_encode ( "O campo email, <b>$Email</b>, está com o formato inválido." );
					break;
				}
				if (! Validacao::validarData ( $DataNascimento )) {
					$DataNascimento = null;
				}
				
				$Cpf = '';
				$IdStatusUsuario = '1'; // 1 = Pre-Inscrito;
				$IdEstado = '0';
				$IdPais = '0';
				if (! $FlagResumo)
					$FlagResumo = '0';
				if (! $FlagPolitica)
					$FlagPolitica = '0';
				if (! $TipoResumo)
					$TipoResumo = 4; // Outros
				$Cidade = '';
				$Cpf = str_replace ( "-", "", str_replace ( "/", "", str_replace ( ".", "", $Cpf ) ) );
				
				// CanalComunicacao: { 1: FlagAscom, 2: FlagIndicacao, 4: FlagBioMural, 8: FlagBioDigital, 16: FlagWebTV, 32: FlagCartazes, 64: FlagOutros}
				$CanalComunicacao = ($FlagAscom + $FlagIndicacao + $FlagBioMural + $FlagBioDigital + $FlagWebTV + $FlagCartazes + $FlagOutros);
				
				$obj = new Usuario ();
				$DAO = new UsuarioDAO ();
				
				$obj = $DAO->retornaPorEmail ( $Email );
				if ($obj) {
					// Usuário é do tipo 1=Poencial ?
					
					$response->mensagem = utf8_encode ( "Este email <b>$Email</b>, já faz parte de nosso cadastro. Favor efetuar o login para atualizar os seu dados." );
				} else {
					$objUsuario = new Usuario ();
					$objUsuario->setIdTipoUsuario ( $IdTipoUsuario );
					$objUsuario->setIdStatusUsuario ( $IdStatusUsuario ); // 1 = Pre-Inscrito
					$objUsuario->setIdPais ( $IdPais );
					$objUsuario->setIdEstado ( $IdEstado );
					$objUsuario->setNome ( utf8_decode ( $Nome ) );
					$objUsuario->setCpf ( $Cpf );
					
					if ($DataNascimento)
						$objUsuario->setDataNascimento ( Formatacao::formatarDataSQL ( $DataNascimento ) );
					
					$objUsuario->setViceDiretoria ( $ViceDiretoria );
					$objUsuario->setDepartamento ( $Departamento );
					$objUsuario->setDivisao ( $Divisao );
					$objUsuario->setSecao ( $Secao );
					$objUsuario->setEmail ( $Email );
					$objUsuario->setSenha ( $Senha );
					$objUsuario->setCidade ( $Cidade );
					$objUsuario->setTelefone ( $Telefone );
					
					$objUsuario->setFlagColaborador ( $FlagColaborador );
					// Usuário de Bio-Manguinho
					$objUsuario->setViceDiretoria ( $ViceDiretoria );
					$objUsuario->setDepartamento ( $Departamento );
					$objUsuario->setDivisao ( $Divisao );
					$objUsuario->setSecao ( $Secao );
					// Usuário Externo
					$objUsuario->setUnidadeExterna ( utf8_decode ( $UnidadeExterna ) );
					$objUsuario->setAreaAtuacao ( utf8_decode ( $AreaAtuacao ) );
					$objUsuario->setFormacaoAcademica ( utf8_decode ( $FormacaoAcademica ) );
					
					$objUsuario->setCanalComunicacao ( $CanalComunicacao );
					$objUsuario->setFlagResumo ( $FlagResumo );
					$objUsuario->setFlagPolitica ( $FlagPolitica );
					
					$objUsuario->setAtivo ( 1 );
					$objUsuario->setAutorizadoPor ( $AutorizadoPor );
					$objUsuario->setNomeChefiaImediata ( $_POST ['chefiaImediata'] );
					$objUsuario->setNomeGerenteDepartamento ( $_POST ['gerenteDep'] );
					$objUsuario->setNomeViceDiretoria ( $_POST ['viceDir'] );
					
					if ($DAO->salva ( $objUsuario )) {
						$IdUsuario = $objUsuario->getId ();
						
						$response->sucesso = 1;
						$response->IdUsuario = $IdUsuario;
						$response->FlagResumo = $FlagResumo;
						
						// enviar Email;
						$Conteudo = "";
						$Conteudo .= "Prezado(a) <em>$Nome</em>,<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Sua inscrição foi cadastrada com sucesso em nossa base de dados. A sua participação no Seminário será informada posteriormente através de e-mail.<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Segue os seus dados para acesso e envio de resumo:<br/>";
						$Conteudo .= " Email: $Email<br/>";
						$Conteudo .= " Senha: $Senha<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Obrigado,<br/>";
						$Conteudo .= "<b>Comissão Científica e Tecnológica do III Seminário Anual Científico e Tecnológico em Imunobiológicos</b><br/>";
						$Conteudo .= "<b>Bio-Manguinhos | FIOCRUZ</b><br/>";
						$Conteudo .= "https://sact.bio.fiocruz.br<br/>";
						$Conteudo .= "";
						
						if ($ENVIAR_EMAIL) {
							if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
								$response->erro = 252;
								$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram cadastrados com sucesso." );
							} else {
								$response->erro = 253;
								$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram cadastrados com sucesso.<br/>Mas tivemos um problema no envio de email.</b>" );
							}
						} else {
							$response->erro = 254;
							$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram cadastrados com sucesso." );
						}
						
						if ($response->sucesso) {
							// Autenticar Usuário cdadastrado;
							$USO_ID = $objUsuario->getId ();
							$USO_NOME = utf8_decode ( $Nome );
							$USO_EMAIL = $Email;
							$USO_POLITICA = 1;
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
						}
					} else
						$response->mensagem = utf8_encode ( $DAO->getMensagem () );
				}
			} catch ( PDOException $ex ) {
				$response->mensagem = utf8_encode ( "Erro: " . $ex->getMessage () );
			}
			
			break;
		
		case ("alterar") :
		//	alert();
			$response->passo = 1;
			$IdUsuario = isset ( $_POST ['IdUsuario'] ) ? limpa_sql_injection ( $_POST ['IdUsuario'] ) : 0;
			isset ( $_POST ['IdTipoUsuario'] ) ? $IdTipoUsuario = limpa_sql_injection ( $_POST ['IdTipoUsuario'] ) : $IdTipoUsuario = '0';
			isset ( $_POST ['Nome'] ) ? $Nome = limpa_sql_injection ( $_POST ['Nome'] ) : $Nome = '';
			isset ( $_POST ['Email'] ) ? $Email = limpa_sql_injection ( $_POST ['Email'] ) : $Email = '';
			isset ( $_POST ['Senha'] ) ? $Senha = limpa_sql_injection ( $_POST ['Senha'] ) : $Senha = 'senha';
			isset ( $_POST ['Telefone'] ) ? $Telefone = limpa_sql_injection ( $_POST ['Telefone'] ) : $Telefone = '';
			
			isset ( $_POST ['FlagColaborador'] ) ? $FlagColaborador = limpa_sql_injection ( $_POST ['FlagColaborador'] ) : $FlagColaborador = '0';
			isset ( $_POST ['UnidadeExterna'] ) ? $UnidadeExterna = limpa_sql_injection ( $_POST ['UnidadeExterna'] ) : $UnidadeExterna = '';
			isset ( $_POST ['ViceDiretoria'] ) ? $ViceDiretoria = limpa_sql_injection ( $_POST ['ViceDiretoria'] ) : $ViceDiretoria = '';
			isset ( $_POST ['Departamento'] ) ? $Departamento = limpa_sql_injection ( $_POST ['Departamento'] ) : $Departamento = '';
			isset ( $_POST ['Divisao'] ) ? $Divisao = limpa_sql_injection ( $_POST ['Divisao'] ) : $Divisao = '';
			isset ( $_POST ['Secao'] ) ? $Secao = limpa_sql_injection ( $_POST ['Secao'] ) : $Secao = '';
			isset ( $_POST ['autorizadoPor'] ) ? $AutorizadoPor = limpa_sql_injection ( $_POST ['autorizadoPor'] ) : $AutorizadoPor = '0';
			isset ( $_POST ['chefiaImediata'] ) ? $NomeChefiaImediata = limpa_sql_injection ( $_POST ['chefiaImediata'] ) : $NomeChefiaImediata = '';
			isset ( $_POST ['gerenteDep'] ) ? $NomeGerenteDepartamento = limpa_sql_injection ( $_POST ['gerenteDep'] ) : $NomeGerenteDepartamento = '';
			isset ( $_POST ['viceDir'] ) ? $NomeViceDiretoria = limpa_sql_injection ( $_POST ['viceDir'] ) : $NomeViceDiretoria = '';
			
			isset ( $_POST ['AreaAtuacao'] ) ? $AreaAtuacao = limpa_sql_injection ( $_POST ['AreaAtuacao'] ) : $AreaAtuacao = '';
			isset ( $_POST ['FormacaoAcademica'] ) ? $FormacaoAcademica = limpa_sql_injection ( $_POST ['FormacaoAcademica'] ) : $FormacaoAcademica = '';
			
			isset ( $_POST ['FlagAscom'] ) ? $FlagAscom = limpa_sql_injection ( $_POST ['FlagAscom'] ) : $FlagAscom = '0';
			isset ( $_POST ['FlagIndicacao'] ) ? $FlagIndicacao = limpa_sql_injection ( $_POST ['FlagIndicacao'] ) : $FlagIndicacao = '0';
			isset ( $_POST ['FlagBioMural'] ) ? $FlagBioMural = limpa_sql_injection ( $_POST ['FlagBioMural'] ) : $FlagBioMural = '0';
			isset ( $_POST ['FlagBioDigital'] ) ? $FlagBioDigital = limpa_sql_injection ( $_POST ['FlagBioDigital'] ) : $FlagBioDigital = '0';
			isset ( $_POST ['FlagWebTV'] ) ? $FlagWebTV = limpa_sql_injection ( $_POST ['FlagWebTV'] ) : $FlagWebTV = '0';
			isset ( $_POST ['FlagCartazes'] ) ? $FlagCartazes = limpa_sql_injection ( $_POST ['FlagCartazes'] ) : $FlagCartazes = '0';
			isset ( $_POST ['FlagOutros'] ) ? $FlagOutros = limpa_sql_injection ( $_POST ['FlagOutros'] ) : $FlagOutros = '0';
			
			// Resumo
			isset ( $_POST ['FlagResumo'] ) ? $FlagResumo = limpa_sql_injection ( $_POST ['FlagResumo'] ) : $FlagResumo = '0';
			isset ( $_POST ['DataNascimento'] ) ? $DataNascimento = limpa_sql_injection ( $_POST ['DataNascimento'] ) : $DataNascimento = '';
			isset ( $_POST ['TipoResumo'] ) ? $TipoResumo = limpa_sql_injection ( $_POST ['TipoResumo'] ) : $TipoResumo = '1';
			isset ( $_POST ['TituloResumo'] ) ? $TituloResumo = limpa_sql_injection ( $_POST ['TituloResumo'] ) : $TituloResumo = '';
			isset ( $_POST ['ConteudoResumo'] ) ? $ConteudoResumo = limpa_sql_injection ( $_POST ['ConteudoResumo'] ) : $ConteudoResumo = '';
			isset ( $_POST ['AutoresResumo'] ) ? $AutoresResumo = limpa_sql_injection ( $_POST ['AutoresResumo'] ) : $AutoresResumo = '';
			isset ( $_POST ['InstituicaoResumo'] ) ? $InstituicaoResumo = limpa_sql_injection ( $_POST ['InstituicaoResumo'] ) : $InstituicaoResumo = '';
			isset ( $_POST ['FlagPolitica'] ) ? $FlagPolitica = limpa_sql_injection ( $_POST ['FlagPolitica'] ) : $FlagPolitica = '0';
			
			// echo "[IdUsuario:$IdUsuario][IdTipoUsuario:$IdTipoUsuario][IdStatusUsuario:$IdStatusUsuario][IdPais:$IdPais][IdEstado:$IdEstado][Nome:$Nome][Cpf:$Cpf][Email:$Email][Cidade:$Cidade][CanalComunicacao:$CanalComunicacao]<br/>";
			
			// Validação
			try {
				
				if (! Validacao::validarEmail ( $Email )) {
					$response->mensagem = utf8_encode ( "O campo email, <b>$Email</b>, está com o formato inválido." );
					break;
				}
				if (! $IdUsuario ) {
					$response->mensagem = utf8_encode ( "O campo usuário, <b>$IdUsuario</b>, é obrigatório." );
					break;
				}
				if (! Validacao::validarData ( $DataNascimento )) {
					$DataNascimento = null;
				}
				
				$Cpf = '';
				$IdStatusUsuario = '1'; // 1 = Pre-Inscrito;
				$IdEstado = '0';
				$IdPais = '0';
				if (! $FlagResumo)
					$FlagResumo = '0';
				if (! $FlagPolitica)
					$FlagPolitica = '0';
				if (! $TipoResumo)
					$TipoResumo = 4; // Outros
				$Cidade = '';
				$Cpf = str_replace ( "-", "", str_replace ( "/", "", str_replace ( ".", "", $Cpf ) ) );
				
				// CanalComunicacao: { 1: FlagAscom, 2: FlagIndicacao, 4: FlagBioMural, 8: FlagBioDigital, 16: FlagWebTV, 32: FlagCartazes, 64: FlagOutros}
				$CanalComunicacao = ($FlagAscom + $FlagIndicacao + $FlagBioMural + $FlagBioDigital + $FlagWebTV + $FlagCartazes + $FlagOutros);
				
				$response->passo = 2;
				
				$DAO = new UsuarioDAO ();
				$objUsuario = $DAO->retorna( $IdUsuario);
				if ($objUsuario) {
					$response->passo = 3;
					$objUsuario->setIdTipoUsuario ( $IdTipoUsuario );
					$objUsuario->setIdStatusUsuario ( $IdStatusUsuario ); // 1 = Pre-Inscrito
					$objUsuario->setIdPais ( $IdPais );
					$objUsuario->setIdEstado ( $IdEstado );
					$objUsuario->setNome ( utf8_decode ( $Nome ) );
					$objUsuario->setCpf ( $Cpf );
					if ($DataNascimento)
						$objUsuario->setDataNascimento ( Formatacao::formatarDataSQL ( $DataNascimento ) );
					
					$objUsuario->setViceDiretoria ( $ViceDiretoria );
					$objUsuario->setDepartamento ( $Departamento );
					$objUsuario->setDivisao ( $Divisao );
					$objUsuario->setSecao ( $Secao );
					$objUsuario->setEmail ( $Email );
					$objUsuario->setSenha ( $Senha );
					$objUsuario->setCidade ( $Cidade );
					$objUsuario->setTelefone ( $Telefone );
					
					$objUsuario->setFlagColaborador ( $FlagColaborador );
					// Usuário de Bio-Manguinho
					$objUsuario->setViceDiretoria ( $ViceDiretoria );
					$objUsuario->setDepartamento ( $Departamento );
					$objUsuario->setDivisao ( $Divisao );
					$objUsuario->setSecao ( $Secao );
					// Usuário Externo
					$objUsuario->setUnidadeExterna ( utf8_decode ( $UnidadeExterna ) );
					$objUsuario->setAreaAtuacao ( utf8_decode ( $AreaAtuacao ) );
					$objUsuario->setFormacaoAcademica ( utf8_decode ( $FormacaoAcademica ) );
					
					$objUsuario->setCanalComunicacao ( $CanalComunicacao );
					$objUsuario->setFlagResumo ( $FlagResumo );
					$objUsuario->setFlagPolitica ( $FlagPolitica );
					
					$objUsuario->setAtivo ( 1 );
					$objUsuario->setAutorizadoPor ( $AutorizadoPor );
					$objUsuario->setNomeChefiaImediata ( $_POST ['chefiaImediata'] );
					$objUsuario->setNomeGerenteDepartamento ( $_POST ['gerenteDep'] );
					$objUsuario->setNomeViceDiretoria ( $_POST ['viceDir'] );
					$response->passo = 4;
					
					if ($DAO->atualiza ( $objUsuario )) {
						$response->passo = 5;
						$IdUsuario = $objUsuario->getId();
						
						$response->sucesso = 1;
						$response->IdUsuario = $IdUsuario;
						$response->FlagResumo = $FlagResumo;
						
						// enviar Email;
						$Conteudo = "";
						$Conteudo .= "Prezado(a) <em>$Nome</em>,<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Sua inscrição foi atualizada com sucesso em nossa base de dados. A sua participação no Seminário será informada posteriormente através de e-mail.<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Segue os seus dados para acesso e envio de resumo:<br/>";
						$Conteudo .= " Email: $Email<br/>";
						$Conteudo .= " Senha: $Senha<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Obrigado,<br/>";
						$Conteudo .= "<b>Comissão Científica e Tecnológica do III Seminário Anual Científico e Tecnológico em Imunobiológicos</b><br/>";
						$Conteudo .= "<b>Bio-Manguinhos | FIOCRUZ</b><br/>";
						$Conteudo .= "https://sact.bio.fiocruz.br<br/>";
						$Conteudo .= "";
						
						if ($ENVIAR_EMAIL) {
							$response->passo = 6;
							if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
								$response->erro = 252;
								$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram atualizados com sucesso." );
							} else {
								$response->erro = 253;
								$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram atualizados com sucesso.<br/>Mas tivemos um problema no envio de email.</b>" );
							}
						} else {
							$response->erro = 254;
							$response->mensagem = utf8_encode ( "<b>$Nome</b>, os seus dados foram atualizados com sucesso." );
						}
						$response->passo = 10;
						
					} else
						$response->mensagem = utf8_encode ( $DAO->getMensagem () );
				} else {
					$response->erro = 255;
					$response->mensagem = utf8_encode ( "Registro não encontrado com identificador <b>$IdUsuario</b>." );
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