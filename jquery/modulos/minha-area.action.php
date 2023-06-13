<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );

require_once ('../admin/includes/global.php');
require_once ('../admin/funcoes/Formatacao.class.php');
require_once ('../admin/funcoes/Arquivo.class.php');
require_once ("../admin/funcoes/Mensagem.class.php");

require_once ('../admin/modelo/ModuloDAO.class.php');
require_once ('../admin/modelo/UsuarioDAO.class.php');
// require_once('../admin/modelo/ConteudoDAO.class.php');
require_once ('../admin/modelo/ResumoDAO.class.php');
// require_once ('../admin/modulo/resumo/resumo.action.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 152;
$response->mensagem = utf8_encode ( "inicio do processamento." );

$ENVIAR_EMAIL = 0;
$MOD_TITULO = 'Confirmação de envio de resumo';
$MOD_EMAIL = 'sact@bio.fiocruz.br';
$MOD_SENHA = 's@ctb!0';

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
		
		case ("retornar") :
			isset ( $_GET ['IdUsuario'] ) ? $IdUsuario = trim ( trim ( ($_GET ['IdUsuario']) ) ) : $IdUsuario = '';
			
			try {
				$response->IdUsuario = $IdUsuario;
				
				$item = new Resumo ();
				$DAO = new ResumoDAO ();
				$item = $DAO->retornaResumo ( $IdUsuario );
				if ($item) {
					$response->idResumo = $item->getId ();
					$response->TipoResumo = $item->getTipo ();
					$response->TituloResumo = utf8_encode ( $item->getTitulo () );
					$response->autor1 = utf8_encode ( $item->getAutor1 () );
					$response->autor2 = utf8_encode ( $item->getAutor2 () );
					$response->autor3 = utf8_encode ( $item->getAutor3 () );
					$response->autor4 = utf8_encode ( $item->getAutor4 () );
					$response->autor5 = utf8_encode ( $item->getAutor5 () );
					$response->autor6 = utf8_encode ( $item->getAutor6 () );
					$response->autor7 = utf8_encode ( $item->getAutor7 () );
					$response->autor8 = utf8_encode ( $item->getAutor8 () );
					$response->autor9 = utf8_encode ( $item->getAutor9 () );
					$response->autor10 = utf8_encode ( $item->getAutor10 () );
					$response->instituicao1 = utf8_encode ( $item->getInstituicao1 () );
					$response->instituicao2 = utf8_encode ( $item->getInstituicao2 () );
					$response->instituicao3 = utf8_encode ( $item->getInstituicao3 () );
					$response->instituicao4 = utf8_encode ( $item->getInstituicao4 () );
					$response->instituicao5 = utf8_encode ( $item->getInstituicao5 () );
					$response->instituicao6 = utf8_encode ( $item->getInstituicao6 () );
					$response->instituicao7 = utf8_encode ( $item->getInstituicao7 () );
					$response->instituicao8 = utf8_encode ( $item->getInstituicao8 () );
					$response->instituicao9 = utf8_encode ( $item->getInstituicao9 () );
					$response->instituicao10 = utf8_encode ( $item->getInstituicao10 () );
					$response->email1 = $item->getEmail1 ();
					$response->email2 = $item->getEmail2 ();
					$response->email3 = $item->getEmail3 ();
					$response->email4 = $item->getEmail4 ();
					$response->email5 = $item->getEmail5 ();
					$response->email6 = $item->getEmail6 ();
					$response->email7 = $item->getEmail7 ();
					$response->email8 = $item->getEmail8 ();
					$response->email9 = $item->getEmail9 ();
					$response->email10 = $item->getEmail10 ();
					$response->apresentador1 = $item->getApresentador1 ();
					$response->apresentador2 = $item->getApresentador2 ();
					$response->apresentador3 = $item->getApresentador3 ();
					$response->apresentador4 = $item->getApresentador4 ();
					$response->apresentador5 = $item->getApresentador5 ();
					$response->apresentador6 = $item->getApresentador6 ();
					$response->apresentador7 = $item->getApresentador7 ();
					$response->apresentador8 = $item->getApresentador8 ();
					$response->apresentador9 = $item->getApresentador9 ();
					$response->apresentador10 = $item->getApresentador10 ();
					$response->justificativa8 = utf8_encode ($item->getJustificativa8 ());
					$response->justificativa9 = utf8_encode ($item->getJustificativa9 ());
					$response->justificativa10 = utf8_encode ($item->getJustificativa10 ());
					$response->Textointroducao = utf8_encode ($item->getintroducao ());
					$response->TextoObjetivo = utf8_encode ($item->getObjetivo ());
					$response->TextoMetodologia = utf8_encode ($item->getMetodologia ());
					$response->TextoResumo = utf8_encode ($item->getResultado ());
					$response->TextoConclusao = utf8_encode ($item->getConclusao ());
					$response->TextoPalavraChave = utf8_encode ( $item->getPalavraChave ());
					$response->OutroResumo = utf8_encode ( $item->getOutroResumo ());
					$response->Gest_Resumo = $item->getGest_Resumo ();
					$response->Est_Qualitativo = $item->getEst_Qualitativo ();
					$response->OutrosTemas = utf8_encode ( $item->getOutrosTemas ());
					
					$response->FlagPolitica = '';($item->getFlagPolitica())? true: false;
					$response->FlagPolitica1 = '';($item->getFlagPolitica1())? true: false;
					$response->FlagPolitica2 = '';($item->getFlagPolitica2())? true: false;
					$response->FlagPolitica3 = '';($item->getFlagPolitica3())? true: false;
					
					$response->sucesso = 1;
				} else {
					// $response->mensagem = utf8_encode("Resumo Não encontrato em nossa base de dados. (Id:$IdUsuario)");
				}
			} catch ( PDOException $ex ) {
				$response->mensagem = utf8_encode ( $ex->getMessage () );
			}
			
			break;
		
		case ("retornarPorID") :
			isset ( $_GET ['IdResumo'] ) ? $IdResumo = trim ( trim ( ($_GET ['IdResumo']) ) ) : $IdResumo = '';
			isset ( $_GET ['IdUsuario'] ) ? $IdUsuario = trim ( trim ( ($_GET ['IdUsuario']) ) ) : $IdUsuario = '';
			try {
				$response->IdResumo = $IdResumo;
				
				$item = new Resumo ();
				$DAO = new ResumoDAO ();
				$item = $DAO->retornaResumoPorID ( $IdResumo );
				
				if ($item) {
					
					$response->idResumo = $item->getId ();
					$response->TipoResumo = $item->getTipo ();
					$response->TituloResumo = utf8_encode ($item->getTitulo ());
					$response->autor1 = utf8_encode ( $item->getAutor1 () );
					$response->autor2 = utf8_encode ( $item->getAutor2 () );
					$response->autor3 = utf8_encode ( $item->getAutor3 () );
					$response->autor4 = utf8_encode ( $item->getAutor4 () );
					$response->autor5 = utf8_encode ( $item->getAutor5 () );
					$response->autor6 = utf8_encode ( $item->getAutor6 () );
					$response->autor7 = utf8_encode ( $item->getAutor7 () );
					$response->autor8 = utf8_encode ( $item->getAutor8 () );
					$response->autor9 = utf8_encode ( $item->getAutor9 () );
					$response->autor10 = utf8_encode ( $item->getAutor10 () );
					$response->instituicao1 = utf8_encode ( $item->getInstituicao1 () );
					$response->instituicao2 = utf8_encode ( $item->getInstituicao2 () );
					$response->instituicao3 = utf8_encode ( $item->getInstituicao3 () );
					$response->instituicao4 = utf8_encode ( $item->getInstituicao4 () );
					$response->instituicao5 = utf8_encode ( $item->getInstituicao5 () );
					$response->instituicao6 = utf8_encode ( $item->getInstituicao6 () );
					$response->instituicao7 = utf8_encode ( $item->getInstituicao7 () );
					$response->instituicao8 = utf8_encode ( $item->getInstituicao8 () );
					$response->instituicao9 = utf8_encode ( $item->getInstituicao9 () );
					$response->instituicao10 = utf8_encode ( $item->getInstituicao10 () );
					$response->email1 = $item->getEmail1 ();
					$response->email2 = $item->getEmail2 ();
					$response->email3 = $item->getEmail3 ();
					$response->email4 = $item->getEmail4 ();
					$response->email5 = $item->getEmail5 ();
					$response->email6 = $item->getEmail6 ();
					$response->email7 = $item->getEmail7 ();
					$response->email8 = $item->getEmail8 ();
					$response->email9 = $item->getEmail9 ();
					$response->email10 = $item->getEmail10 ();
					$response->apresentador1 = $item->getApresentador1 ();
					$response->apresentador2 = $item->getApresentador2 ();
					$response->apresentador3 = $item->getApresentador3 ();
					$response->apresentador4 = $item->getApresentador4 ();
					$response->apresentador5 = $item->getApresentador5 ();
					$response->apresentador6 = $item->getApresentador6 ();
					$response->apresentador7 = $item->getApresentador7 ();
					$response->apresentador8 = $item->getApresentador8 ();
					$response->apresentador9 = $item->getApresentador9 ();
					$response->apresentador10 = $item->getApresentador10 ();
					$response->justificativa8 = utf8_encode ($item->getJustificativa8 ());
					$response->justificativa9 = utf8_encode ($item->getJustificativa9 ());
					$response->justificativa10 = utf8_encode ($item->getJustificativa10 ());
					$response->Textointroducao = utf8_encode ($item->getintroducao ());
					$response->TextoObjetivo = utf8_encode ($item->getObjetivo ());
					$response->TextoMetodologia = utf8_encode ($item->getMetodologia ());
					$response->TextoResumo = utf8_encode ($item->getResultado ());
					$response->TextoConclusao = utf8_encode ($item->getConclusao ());
					$response->TextoPalavraChave = utf8_encode ( $item->getPalavraChave () );
					$response->OutroResumo = utf8_encode ( $item->getOutroResumo () );
					$response->Gest_Resumo = utf8_encode ( $item->getGest_Resumo () );
					$response->Est_Qualitativo = $item->getEst_Qualitativo ();
					$response->OutrosTemas = utf8_encode ( $item->getOutrosTemas () );
					
					$response->FlagPolitica = '';//($item->getFlagPolitica())? true: false;
					$response->FlagPolitica1 = '';($item->getFlagPolitica1())? true: false;
					$response->FlagPolitica2 = '';($item->getFlagPolitica2())? true: false;
					$response->FlagPolitica3 = '';($item->getFlagPolitica3())? true: false;
					
					$response->sucesso = 1;
				} else {
					// $response->mensagem = utf8_encode("Resumo Não encontrato em nossa base de dados. (Id:$IdUsuario)");
				}
			} catch ( PDOException $ex ) {
				$response->mensagem = utf8_encode ( $ex->getMessage () );
			}
			
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
	
	if ($acao == 'limpar') {
		$acao = 'criar-resumo';
	}
	$response->mensagem = $acao;
	
	switch ($acao) {
		
		case ("criar-resumo") :
			isset ( $_POST ['IdUsuario'] ) ? $IdUsuario = trim ( $_POST ['IdUsuario'] ) : $IdUsuario = '0';
			// Resumo
			isset ( $_POST ['TipoResumo'] ) ? $TipoResumo = trim ( $_POST ['TipoResumo'] ) : $TipoResumo = '1';
			isset ( $_POST ['TituloResumo'] ) ? $TituloResumo = trim ( $_POST ['TituloResumo'] ) : $TituloResumo = '';
			isset ( $_POST ['autor1'] ) ? $Autor1 = trim ( $_POST ['autor1'] ) : $Autor1 = '';
			isset ( $_POST ['autor2'] ) ? $Autor2 = trim ( $_POST ['autor2'] ) : $Autor2 = '';
			isset ( $_POST ['autor3'] ) ? $Autor3 = trim ( $_POST ['autor3'] ) : $Autor3 = '';
			isset ( $_POST ['autor4'] ) ? $Autor4 = trim ( $_POST ['autor4'] ) : $Autor4 = '';
			isset ( $_POST ['autor5'] ) ? $Autor5 = trim ( $_POST ['autor5'] ) : $Autor5 = '';
			isset ( $_POST ['autor6'] ) ? $Autor6 = trim ( $_POST ['autor6'] ) : $Autor6 = '';
			isset ( $_POST ['autor7'] ) ? $Autor7 = trim ( $_POST ['autor7'] ) : $Autor7 = '';
			isset ( $_POST ['autor8'] ) ? $Autor8 = trim ( $_POST ['autor8'] ) : $Autor8 = '';
			isset ( $_POST ['autor9'] ) ? $Autor9 = trim ( $_POST ['autor9'] ) : $Autor9 = '';
			isset ( $_POST ['autor10'] ) ? $Autor10 = trim ( $_POST ['autor10'] ) : $Autor10 = '';
			isset ( $_POST ['instituicao1'] ) ? $Instituicao1 = trim ( $_POST ['instituicao1'] ) : $Instituicao1 = '';
			isset ( $_POST ['instituicao2'] ) ? $Instituicao2 = trim ( $_POST ['instituicao2'] ) : $Instituicao2 = '';
			isset ( $_POST ['instituicao3'] ) ? $Instituicao3 = trim ( $_POST ['instituicao3'] ) : $Instituicao3 = '';
			isset ( $_POST ['instituicao4'] ) ? $Instituicao4 = trim ( $_POST ['instituicao4'] ) : $Instituicao4 = '';
			isset ( $_POST ['instituicao5'] ) ? $Instituicao5 = trim ( $_POST ['instituicao5'] ) : $Instituicao5 = '';
			isset ( $_POST ['instituicao6'] ) ? $Instituicao6 = trim ( $_POST ['instituicao6'] ) : $Instituicao6 = '';
			isset ( $_POST ['instituicao7'] ) ? $Instituicao7 = trim ( $_POST ['instituicao7'] ) : $Instituicao7 = '';
			isset ( $_POST ['instituicao8'] ) ? $Instituicao8 = trim ( $_POST ['instituicao8'] ) : $Instituicao8 = '';
			isset ( $_POST ['instituicao9'] ) ? $Instituicao9 = trim ( $_POST ['instituicao9'] ) : $Instituicao9 = '';
			isset ( $_POST ['instituicao10'] ) ? $Instituicao10 = trim ( $_POST ['instituicao10'] ) : $Instituicao10 = '';
			isset ( $_POST ['email1'] ) ? $Email1 = trim ( $_POST ['email1'] ) : $Email1 = '';
			isset ( $_POST ['email2'] ) ? $Email2 = trim ( $_POST ['email2'] ) : $Email2 = '';
			isset ( $_POST ['email3'] ) ? $Email3 = trim ( $_POST ['email3'] ) : $Email3 = '';
			isset ( $_POST ['email4'] ) ? $Email4 = trim ( $_POST ['email4'] ) : $Email4 = '';
			isset ( $_POST ['email5'] ) ? $Email5 = trim ( $_POST ['email5'] ) : $Email5 = '';
			isset ( $_POST ['email6'] ) ? $Email6 = trim ( $_POST ['email6'] ) : $Email6 = '';
			isset ( $_POST ['email7'] ) ? $Email7 = trim ( $_POST ['email7'] ) : $Email7 = '';
			isset ( $_POST ['email8'] ) ? $Email8 = trim ( $_POST ['email8'] ) : $Email8 = '';
			isset ( $_POST ['email9'] ) ? $Email9 = trim ( $_POST ['email9'] ) : $Email9 = '';
			isset ( $_POST ['email10'] ) ? $Email10 = trim ( $_POST ['email10'] ) : $Email10 = '';
			isset ( $_POST ['apresentador1'] ) ? $Apresentador1 = trim ( $_POST ['apresentador1'] ) : $Apresentador1 = '';
			isset ( $_POST ['apresentador2'] ) ? $Apresentador2 = trim ( $_POST ['apresentador2'] ) : $Apresentador2 = '';
			isset ( $_POST ['apresentador3'] ) ? $Apresentador3 = trim ( $_POST ['apresentador3'] ) : $Apresentador3 = '';
			isset ( $_POST ['apresentador4'] ) ? $Apresentador4 = trim ( $_POST ['apresentador4'] ) : $Apresentador4 = '';
			isset ( $_POST ['apresentador5'] ) ? $Apresentador5 = trim ( $_POST ['apresentador5'] ) : $Apresentador5 = '';
			isset ( $_POST ['apresentador6'] ) ? $Apresentador6 = trim ( $_POST ['apresentador6'] ) : $Apresentador6 = '';
			isset ( $_POST ['apresentador7'] ) ? $Apresentador7 = trim ( $_POST ['apresentador7'] ) : $Apresentador7 = '';
			isset ( $_POST ['apresentador8'] ) ? $Apresentador8 = trim ( $_POST ['apresentador8'] ) : $Apresentador8 = '';
			isset ( $_POST ['apresentador9'] ) ? $Apresentador9 = trim ( $_POST ['apresentador9'] ) : $Apresentador9 = '';
			isset ( $_POST ['apresentador10'] ) ? $Apresentador9 = trim ( $_POST ['apresentador10'] ) : $Apresentador10 = '';
			isset ( $_POST ['justificativa8'] ) ? $Justificativa8 = trim ( $_POST ['justificativa8'] ) : $Justificativa8 = '';
			isset ( $_POST ['justificativa9'] ) ? $Justificativa9 = trim ( $_POST ['justificativa9'] ) : $Justificativa9 = '';
			isset ( $_POST ['justificativa10'] ) ? $Justificativa10 = trim ( $_POST ['justificativa10'] ) : $Justificativa10 = '';
			isset ( $_POST ['ConteudoResumo'] ) ? $ConteudoResumo = trim ( $_POST ['ConteudoResumo'] ) : $ConteudoResumo = '';
			isset ( $_POST ['Textointroducao'] ) ? $Textointroducao = trim ( $_POST ['Textointroducao'] ) : $Textointroducao = '';
			isset ( $_POST ['TextoObjetivo'] ) ? $TextoObjetivo = trim ( $_POST ['TextoObjetivo'] ) : $TextoObjetivo = '';
			isset ( $_POST ['TextoMetodologia'] ) ? $TextoMetodologia = trim ( $_POST ['TextoMetodologia'] ) : $TextoMetodologia = '';
			isset ( $_POST ['TextoResumo'] ) ? $TextoResumo = trim ( $_POST ['TextoResumo'] ) : $TextoResumo = '';
			isset ( $_POST ['TextoConclusao'] ) ? $TextoConclusao = trim ( $_POST ['TextoConclusao'] ) : $TextoConclusao = '';
			// isset($_POST['TextoPalavraChave']) ? $TextoPalavraChave = trim($_POST['TextoPalavraChave']) : $TextoPalavraChave = '';
			$TextoPalavraChave = $_POST ['TextoPalavraChave'];
			isset ( $_POST ['InstituicaoResumo'] ) ? $InstituicaoResumo = trim ( $_POST ['InstituicaoResumo'] ) : $InstituicaoResumo = '';
			isset ( $_POST ['FlagPolitica'] ) ? $FlagPolitica = trim ( $_POST ['FlagPolitica'] ) : $FlagPolitica = '0';
			isset ( $_POST ['FlagPolitica1'] ) ? $FlagPolitica1 = trim ( $_POST ['FlagPolitica1'] ) : $FlagPolitica1 = '0';
			isset ( $_POST ['FlagPolitica2'] ) ? $FlagPolitica2 = trim ( $_POST ['FlagPolitica2'] ) : $FlagPolitica2 = '0';
			isset ( $_POST ['FlagPolitica2'] ) ? $FlagPolitica2 = trim ( $_POST ['FlagPolitica2'] ) : $FlagPolitica2 = '0';
			isset ( $_POST ['OutroResumo'] ) ? $OutroResumo = trim ( $_POST ['OutroResumo'] ) : $OutroResumo = '0';
			isset ( $_POST ['Gest_Resumo'] ) ? $Gest_Resumo = trim ( $_POST ['Gest_Resumo'] ) : $Gest_Resumo = '0';
			isset ( $_POST ['Est_Qualitativo'] ) ? $Est_Qualitativo = trim ( $_POST ['Est_Qualitativo'] ) : $Est_Qualitativo = '0';
			isset ( $_POST ['OutrosTemas'] ) ? $OutrosTemas = trim ( $_POST ['OutrosTemas'] ) : $OutrosTemas = '';
			// echo 'Palavra: '.$_POST['TextoPalavraChave'];
			try {
				
				// Validação
				$IdStatus = '1'; // 1 = Cadastrado/Submetido
				$FlagResumo = '1';
				if (! $FlagPolitica)
					$FlagPolitica = '0';
				if (! $FlagPolitica1)
					$FlagPolitica1 = '0';
				if (! $FlagPolitica2)
					$FlagPolitica2 = '0';
				if (! $TipoResumo)
					$TipoResumo = 4; // Outros
				
				$obj = new Usuario ();
				$DAO = new UsuarioDAO ();
				
				$obj = $DAO->retorna ( $IdUsuario );
				if ($obj) {
					$Nome = $obj->getNome ();
					$Email = $obj->getEmail ();
					
					// $DAO1 = new ConteudoDAO();
					$DAO1 = new ResumoDAO ();
					$Revisao = 1;
					// $obj1 = new Conteudo();
					$obj1 = new Resumo ();
					$obj1->setIdUsuario ( $IdUsuario );
					$obj1->setTipo ( $TipoResumo );
					$obj1->setTitulo ( $TituloResumo );
					$obj1->setAutor1 ( TrataCaracteres ( $Autor1 ) );
					$obj1->setAutor2 ( TrataCaracteres ( $Autor2 ) );
					$obj1->setAutor3 ( TrataCaracteres ( $Autor3 ) );
					$obj1->setAutor4 ( TrataCaracteres ( $Autor4 ) );
					$obj1->setAutor5 ( TrataCaracteres ( $Autor5 ) );
					$obj1->setAutor6 ( TrataCaracteres ( $Autor6 ) );
					$obj1->setAutor7 ( TrataCaracteres ( $Autor7 ) );
					$obj1->setAutor8 ( TrataCaracteres ( $Autor8 ) );
					$obj1->setAutor9 ( TrataCaracteres ( $Autor9 ) );
					$obj1->setAutor10 ( TrataCaracteres ( $Autor10 ) );
					$obj1->setInstituicao1 ( TrataCaracteres ( $Instituicao1 ) );
					$obj1->setInstituicao2 ( TrataCaracteres ( $Instituicao2 ) );
					$obj1->setInstituicao3 ( TrataCaracteres ( $Instituicao3 ) );
					$obj1->setInstituicao4 ( TrataCaracteres ( $Instituicao4 ) );
					$obj1->setInstituicao5 ( TrataCaracteres ( $Instituicao5 ) );
					$obj1->setInstituicao6 ( TrataCaracteres ( $Instituicao6 ) );
					$obj1->setInstituicao7 ( TrataCaracteres ( $Instituicao7 ) );
					$obj1->setInstituicao8 ( TrataCaracteres ( $Instituicao8 ) );
					$obj1->setInstituicao9 ( TrataCaracteres ( $Instituicao9 ) );
					$obj1->setInstituicao10 ( TrataCaracteres ( $Instituicao10 ) );
					$obj1->setEmail1 ( $Email1 );
					$obj1->setEmail2 ( $Email2 );
					$obj1->setEmail3 ( $Email3 );
					$obj1->setEmail4 ( $Email4 );
					$obj1->setEmail5 ( $Email5 );
					$obj1->setEmail6 ( $Email6 );
					$obj1->setEmail7 ( $Email7 );
					$obj1->setEmail8 ( $Email8 );
					$obj1->setEmail9 ( $Email9 );
					$obj1->setEmail10 ( $Email10 );
					$obj1->setApresentador1 ( $Apresentador1 );
					$obj1->setApresentador2 ( $Apresentador2 );
					$obj1->setApresentador3 ( $Apresentador3 );
					$obj1->setApresentador4 ( $Apresentador4 );
					$obj1->setApresentador5 ( $Apresentador5 );
					$obj1->setApresentador6 ( $Apresentador6 );
					$obj1->setApresentador7 ( $Apresentador7 );
					$obj1->setApresentador8 ( $Apresentador8 );
					$obj1->setApresentador9 ( $Apresentador9 );
					$obj1->setApresentador10 ( $Apresentador10 );
					$obj1->setintroducao ( $Textointroducao );
					$obj1->setInstituicao ( $InstituicaoResumo );
					// $obj1->setConteudo($ConteudoResumo);
					$obj1->setObjetivo ( $TextoObjetivo );
					$obj1->setMetodologia ( $TextoMetodologia );
					$obj1->setResultado ( $TextoResumo );
					$obj1->setConclusao ( $TextoConclusao );
					if ($TextoPalavraChave != "") {
						$obj1->setPalavraChave ( $TextoPalavraChave );
					}
					$obj1->setAno ( date ( "Y" ) );
					$obj1->setIdStatus ( $IdStatus );
					$obj1->setRevisao ( $Revisao );
					$obj1->setFlagPolitica ( $FlagPolitica );
					$obj1->setFlagPolitica1 ( $FlagPolitica1 );
					$obj1->setFlagPolitica2 ( $FlagPolitica2 );
					$obj1->setOutroResumo ( $OutroResumo );
					$obj1->setGest_Resumo ( $Gest_Resumo );
					$obj1->setEst_Qualitativo ( $Est_Qualitativo );
					$obj1->setOutrosTemas ( $OutrosTemas );
					$obj1->setAtivo ( 1 );
					// Inicio do IF Salvar
					if ($DAO1->salva ( $obj1 )) {
						$IdResumo = $obj1->getId ();
						
						$response->sucesso = 1;
						$response->IdResumo = $obj1->getId ();
						$response->FlagResumo = $FlagResumo;
						$response->msg = $obj1;
						
						// Anexar Arquivo
						/*
						 * * Essa Função foi utilizada no Seminário de 2013. $NomeArquivo = 'Resumo '.$IdResumo; if (Arquivo::gravarArquivo('Arquivo', $NomeArquivo, '../arquivos/')) { // Foi feito upload da ? $NomeArquivo = Arquivo::getNome(); $DAO1->atualizarArquivo($IdResumo, $NomeArquivo, $IdResumo, $Revisao); $response->Arquivo = $NomeArquivo; } else { $response->sucesso = 1; $response->erro = Arquivo::getErro(); $response->mensagem = utf8_encode(Arquivo::getMensagem()); }
						 */
						
						// enviar Email;
						$Conteudo = "";
						$Conteudo .= "Prezado(a) <em>$Nome</em>!<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Seu resumo '$TituloResumo' foi cadastrado com sucesso em nossa base de dados. Você será informado sobre a aceitação do mesmo pela Comissão Científica do Seminário .<br/>";
						$Conteudo .= "<br/>";
						$Conteudo .= "Atenciosamente,<br/>";
						$Conteudo .= "<b>Comissão Científica e Tecnológica do II Seminário Anual Científico e Tecnológico em Imunobiológicos</b><br/>";
						$Conteudo .= "<b>Bio-Manguinhos | FIOCRUZ</b><br/>";
						$Conteudo .= "https://sact.bio.fiocruz.br<br/>";
						$Conteudo .= "";
						
						if ($ENVIAR_EMAIL) {
							if (Mensagem::enviar ( $Nome, $Email, $EMP_NOME, $MOD_EMAIL, $MOD_SENHA, $MOD_TITULO, $Conteudo )) {
								$response->erro = 242;
								$response->mensagem = utf8_encode ( "<b>$Nome</b>, o seu resumo com Titulo '$TituloResumo' foi enviado com sucesso." );
							} else {
								$response->erro = 243;
								$response->mensagem = utf8_encode ( "<b>$Nome</b>, o seu resumo com o Titulo '$TituloResumo' foi enviado com sucesso.<br/>Mas tivemos problema no envio de seu email." );
							}
						} else {
							$response->erro = 244;
							$response->mensagem = utf8_encode ( "<b>$Nome</b>, o seu resumo com o Titulo '$TituloResumo' foi enviado com sucesso." );
						}
					} else {
						$response->erro = 245;
						$response->mensagem = utf8_encode ( 'Erro ao gravar: '.$DAO1->getMensagem () );
					}
					// Fim do IF Salvar
				} else {
					$response->erro = 246;
					$response->mensagem = utf8_encode ( "Usuário com identificador  <b>$IdUsuario</b> não foi encontrado na base de dados." );
				}
			} catch ( PDOException $ex ) {
				$response->erro = 247;
				$response->mensagem = utf8_encode ( "Erro: " . $ex->getMessage () );
			}
			
			break;
		
		case ("alterar-resumo") :
			
			isset ( $_POST ['IdUsuario'] ) ? $IdUsuario = trim ( $_POST ['IdUsuario'] ) : $IdUsuario = '0';
			isset ( $_POST ['IdResumo'] ) ? $IdResumo = trim ( $_POST ['IdResumo'] ) : $IdResumo = '0';
			// Resumo
			isset ( $_POST ['TipoResumo'] ) ? $TipoResumo = trim ( $_POST ['TipoResumo'] ) : $TipoResumo = '1';
			isset ( $_POST ['TituloResumo'] ) ? $TituloResumo = trim ( $_POST ['TituloResumo'] ) : $TituloResumo = '';
			isset ( $_POST ['autor1'] ) ? $Autor1 = trim ( $_POST ['autor1'] ) : $Autor1 = '';
			isset ( $_POST ['autor2'] ) ? $Autor2 = trim ( $_POST ['autor2'] ) : $Autor2 = '';
			isset ( $_POST ['autor3'] ) ? $Autor3 = trim ( $_POST ['autor3'] ) : $Autor3 = '';
			isset ( $_POST ['autor4'] ) ? $Autor4 = trim ( $_POST ['autor4'] ) : $Autor4 = '';
			isset ( $_POST ['autor5'] ) ? $Autor5 = trim ( $_POST ['autor5'] ) : $Autor5 = '';
			isset ( $_POST ['autor6'] ) ? $Autor6 = trim ( $_POST ['autor6'] ) : $Autor6 = '';
			isset ( $_POST ['autor7'] ) ? $Autor7 = trim ( $_POST ['autor7'] ) : $Autor7 = '';
			isset ( $_POST ['autor8'] ) ? $Autor8 = trim ( $_POST ['autor8'] ) : $Autor8 = '';
			isset ( $_POST ['autor9'] ) ? $Autor9 = trim ( $_POST ['autor9'] ) : $Autor9 = '';
			isset ( $_POST ['autor10'] ) ? $Autor10 = trim ( $_POST ['autor10'] ) : $Autor10 = '';
			isset ( $_POST ['instituicao1'] ) ? $Instituicao1 = trim ( $_POST ['instituicao1'] ) : $Instituicao1 = '';
			isset ( $_POST ['instituicao2'] ) ? $Instituicao2 = trim ( $_POST ['instituicao2'] ) : $Instituicao2 = '';
			isset ( $_POST ['instituicao3'] ) ? $Instituicao3 = trim ( $_POST ['instituicao3'] ) : $Instituicao3 = '';
			isset ( $_POST ['instituicao4'] ) ? $Instituicao4 = trim ( $_POST ['instituicao4'] ) : $Instituicao4 = '';
			isset ( $_POST ['instituicao5'] ) ? $Instituicao5 = trim ( $_POST ['instituicao5'] ) : $Instituicao5 = '';
			isset ( $_POST ['instituicao6'] ) ? $Instituicao6 = trim ( $_POST ['instituicao6'] ) : $Instituicao6 = '';
			isset ( $_POST ['instituicao7'] ) ? $Instituicao7 = trim ( $_POST ['instituicao7'] ) : $Instituicao7 = '';
			isset ( $_POST ['instituicao8'] ) ? $Instituicao8 = trim ( $_POST ['instituicao8'] ) : $Instituicao8 = '';
			isset ( $_POST ['instituicao9'] ) ? $Instituicao9 = trim ( $_POST ['instituicao9'] ) : $Instituicao9 = '';
			isset ( $_POST ['instituicao10'] ) ? $Instituicao10 = trim ( $_POST ['instituicao10'] ) : $Instituicao10 = '';
			isset ( $_POST ['email1'] ) ? $Email1 = trim ( $_POST ['email1'] ) : $Email1 = '';
			isset ( $_POST ['email2'] ) ? $Email2 = trim ( $_POST ['email2'] ) : $Email2 = '';
			isset ( $_POST ['email3'] ) ? $Email3 = trim ( $_POST ['email3'] ) : $Email3 = '';
			isset ( $_POST ['email4'] ) ? $Email4 = trim ( $_POST ['email4'] ) : $Email4 = '';
			isset ( $_POST ['email5'] ) ? $Email5 = trim ( $_POST ['email5'] ) : $Email5 = '';
			isset ( $_POST ['email6'] ) ? $Email6 = trim ( $_POST ['email6'] ) : $Email6 = '';
			isset ( $_POST ['email7'] ) ? $Email7 = trim ( $_POST ['email7'] ) : $Email7 = '';
			isset ( $_POST ['email8'] ) ? $Email8 = trim ( $_POST ['email8'] ) : $Email8 = '';
			isset ( $_POST ['email9'] ) ? $Email9 = trim ( $_POST ['email9'] ) : $Email9 = '';
			isset ( $_POST ['email10'] ) ? $Email10 = trim ( $_POST ['email10'] ) : $Email10 = '';
			isset ( $_POST ['apresentador1'] ) ? $Apresentador1 = trim ( $_POST ['apresentador1'] ) : $Apresentador1 = '';
			isset ( $_POST ['apresentador2'] ) ? $Apresentador2 = trim ( $_POST ['apresentador2'] ) : $Apresentador2 = '';
			isset ( $_POST ['apresentador3'] ) ? $Apresentador3 = trim ( $_POST ['apresentador3'] ) : $Apresentador3 = '';
			isset ( $_POST ['apresentador4'] ) ? $Apresentador4 = trim ( $_POST ['apresentador4'] ) : $Apresentador4 = '';
			isset ( $_POST ['apresentador5'] ) ? $Apresentador5 = trim ( $_POST ['apresentador5'] ) : $Apresentador5 = '';
			isset ( $_POST ['apresentador6'] ) ? $Apresentador6 = trim ( $_POST ['apresentador6'] ) : $Apresentador6 = '';
			isset ( $_POST ['apresentador7'] ) ? $Apresentador7 = trim ( $_POST ['apresentador7'] ) : $Apresentador7 = '';
			isset ( $_POST ['apresentador8'] ) ? $Apresentador8 = trim ( $_POST ['apresentador8'] ) : $Apresentador8 = '';
			isset ( $_POST ['apresentador9'] ) ? $Apresentador9 = trim ( $_POST ['apresentador9'] ) : $Apresentador9 = '';
			isset ( $_POST ['apresentador10'] ) ? $Apresentador9 = trim ( $_POST ['apresentador10'] ) : $Apresentador10 = '';
			isset ( $_POST ['justificativa8'] ) ? $Justificativa8 = trim ( $_POST ['justificativa8'] ) : $Justificativa8 = '';
			isset ( $_POST ['justificativa9'] ) ? $Justificativa9 = trim ( $_POST ['justificativa9'] ) : $Justificativa9 = '';
			isset ( $_POST ['justificativa10'] ) ? $Justificativa10 = trim ( $_POST ['justificativa10'] ) : $Justificativa10 = '';
			// isset($_POST['ConteudoResumo']) ? $ConteudoResumo = trim($_POST['ConteudoResumo']) : $ConteudoResumo = '';
			isset ( $_POST ['Textointroducao'] ) ? $Textointroducao = trim ( $_POST ['Textointroducao'] ) : $Textointroducao = '';
			isset ( $_POST ['TextoObjetivo'] ) ? $TextoObjetivo = trim ( $_POST ['TextoObjetivo'] ) : $TextoObjetivo = '';
			isset ( $_POST ['TextoMetodologia'] ) ? $TextoMetodologia = trim ( $_POST ['TextoMetodologia'] ) : $TextoMetodologia = '';
			isset ( $_POST ['TextoResumo'] ) ? $TextoResumo = trim ( $_POST ['TextoResumo'] ) : $TextoResumo = '';
			isset ( $_POST ['TextoConclusao'] ) ? $TextoConclusao = trim ( $_POST ['TextoConclusao'] ) : $TextoConclusao = '';
			// isset($_POST['$TextoPalavraChave']) ? $TextoPalavraChave = trim($_POST['$TextoPalavraChave']) : $TextoPalavraChave = '';
			$TextoPalavraChave = $_POST ['TextoPalavraChave'];
			// isset($_POST['InstituicaoResumo']) ? $InstituicaoResumo = trim($_POST['InstituicaoResumo']) : $InstituicaoResumo = '';
			isset ( $_POST ['FlagPolitica'] ) ? $FlagPolitica = trim ( $_POST ['FlagPolitica'] ) : $FlagPolitica = '0';
			isset ( $_POST ['FlagPolitica1'] ) ? $FlagPolitica1 = trim ( $_POST ['FlagPolitica1'] ) : $FlagPolitica1 = '0';
			isset ( $_POST ['FlagPolitica2'] ) ? $FlagPolitica2 = trim ( $_POST ['FlagPolitica2'] ) : $FlagPolitica2 = '0';
			isset ( $_POST ['OutroResumo'] ) ? $OutroResumo = trim ( $_POST ['OutroResumo'] ) : $OutroResumo = '0';
			isset ( $_POST ['Gest_Resumo'] ) ? $Gest_Resumo = trim ( $_POST ['Gest_Resumo'] ) : $Gest_Resumo = '0';
			isset ( $_POST ['Est_Qualitativo'] ) ? $Est_Qualitativo = trim ( $_POST ['Est_Qualitativo'] ) : $Est_Qualitativo = '0';
			isset ( $_POST ['OutrosTemas'] ) ? $OutrosTemas = trim ( $_POST ['OutrosTemas'] ) : $OutrosTemas = '';
			
			// echo "[IdUsuario:$IdUsuario][IdResumo:$IdResumo][TipoResumo:$TipoResumo][TituloResumo:$TituloResumo][Textointroducao:$Textointroducao][TextoObjetivo:$TextoObjetivo][TextoMetodologia:$TextoMetodologia][TextoResumo:$TextoResumo][TextoConclusao:$TextoConclusao][TextoConclusao:$TextoConclusao]<br/>";
			try {
				
				$response->passo = 1;
				// Validação
				$IdStatus = '1'; // 1 = Cadastrado/Submetido
				$FlagResumo = '1';
				if (! $FlagPolitica)
					$FlagPolitica = '0';
				if (! $FlagPolitica1)
					$FlagPolitica1 = '0';
				if (! $FlagPolitica2)
					$FlagPolitica2 = '0';
				if (! $TipoResumo)
					$TipoResumo = 4; // Outros
				
				$response->passo = 2;
				$obj = new Usuario ();
				$DAO = new UsuarioDAO ();
				
				$response->passo = 3;
				$obj = $DAO->retorna ( $IdUsuario );
				if ($obj) {
					$response->passo = 4;
					$Nome = $obj->getNome ();
					$Email = $obj->getEmail ();
					
					// $DAO1 = new ConteudoDAO();
					$DAO1 = new ResumoDAO ();
					
					$response->passo = 5;
					// $obj1 = new Conteudo();
					$obj1 = new Resumo ();
					$obj1 = $DAO1->retorna ( $IdResumo );
					if ($obj1) {
						$response->passo = 6;
						$IdOriginalConteudo = $IdResumo;
						$Revisao = $obj1->getRevisao () + 1;
						$NomeArquivo = 'Resumo ' . $IdOriginalConteudo . ' (Revisao ' . $Revisao . ')';
						
						if ($DAO1->atualiza ( $IdResumo, $TipoResumo, $TituloResumo, utf8_decode ( $Autor1 ), utf8_decode ( $Autor2 ), utf8_decode ( $Autor3 ), utf8_decode ( $Autor4 ), utf8_decode ( $Autor5 ), utf8_decode ( $Autor6 ), utf8_decode ( $Autor7 ), utf8_decode ( $Autor8 ), utf8_decode ( $Autor9 ), utf8_decode ( $Autor10 ), utf8_decode ( $Instituicao1 ), utf8_decode ( $Instituicao2 ), utf8_decode ( $Instituicao3 ), utf8_decode ( $Instituicao4 ), utf8_decode ( $Instituicao5 ), utf8_decode ( $Instituicao6 ), utf8_decode ( $Instituicao7 ), utf8_decode ( $Instituicao8 ), utf8_decode ( $Instituicao9 ), utf8_decode ( $Instituicao10 ), $Email1, $Email2, $Email3, $Email4, $Email5, $Email6, $Email7, $Email8, $Email9, $Email10, $Apresentador1, $Apresentador2, $Apresentador3, $Apresentador4, $Apresentador5, $Apresentador6, $Apresentador7, $Apresentador8, $Apresentador9, $Apresentador10, $Justificativa8, $Justificativa9, $Justificativa10, $Textointroducao, $TextoObjetivo, $TextoMetodologia, $TextoResumo, $TextoConclusao, utf8_decode ( $TextoPalavraChave ), $FlagPolitica, $OutroResumo, $Gest_Resumo, $Est_Qualitativo, utf8_decode ( $OutrosTemas ), $FlagPolitica1, $FlagPolitica2 )) {
							$response->passo = 7;
							$response->sucesso = 1;
							$response->mensagem = utf8_encode ( "<b>$Nome</b>, o seu resumo com o Titulo '$TituloResumo' foi enviado com sucesso." );
						} else {
							$response->erro = 349;
							$response->mensagem = utf8_encode ( 'Erro ao atualizar: '.$DAO1->getMensagem () );
						}
					} else {
						$response->erro = 350;
						$response->mensagem = utf8_encode ( "Resumo com identificador  <b>$IdResumo</b> não foi encontrado na base de dados." );
					}
				} else {
					$response->erro = 351;
					$response->mensagem = utf8_encode ( "Usuário com identificador  <b>$IdUsuario</b> não foi encontrado na base de dados." );
				}
			} catch ( PDOException $ex ) {
				$response->erro = 352;
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

ob_clean (); // Limpar buffer de saida
header ( 'Content-type: text/json' );
header ( 'Content-type: application/json' );
echo json_encode ( $response );

?>