<?php
require_once ('../../includes/global.php');
require_once ('../../funcoes/Formatacao.class.php');
require_once ('../../modelo/ResumoDAO.class.php');
require_once ('../../modelo/UsuarioDAO.class.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 312;
$response->mensagem = utf8_encode ( "Inicio do processamento: Resumo.action.php" );
$response->IdResumo = 0;

// IsOnLine();

// echo "B[SERVER['REQUEST_METHOD']:".$_SERVER['REQUEST_METHOD']."]<br/>";
date_default_timezone_set ( 'Brazil/East' );
$today = date ( "d/m/Y" ); // 03.10.01

$titulo = "Relatório de Cheques Emitidos"; // Titulo da impressão
                                           // ENDEREÇO DA BIBLIOTECA FPDF
$end_fpdf = "../../fpdf";
// NUMERO DE RESULTADOS POR PÁGINA
$por_pagina = 29;
$tam_pagina = 270;
// TIPO DO PDF GERADO
// F-> SALVA NO ENDEREÇO ESPECIFICADO NA VAR END_FINAL
// $tipo_pdf = "F";

/**
 * ************ NÃO MEXER DAQUI PRA BAIXO **************
 */
// VERIFICA SE RETORNOU ALGUMA LINHA
$nregs = 1;
$por_pagina = 1;

if (! $nregs) {
	echo "Não retornou nenhum registro";
	die ();
}

// CALCULA QUANTAS PÁGINAS VÃO SER NECESSÁRIAS
$paginas = ceil ( $nregs / $por_pagina );

// PREPARA PARA GERAR O PDF
define ( "FPDF_FONTPATH", "$end_fpdf/font/" );
require_once ("$end_fpdf/fpdf.php");
$pdf = new FPDF ( 'P', 'mm', 'A4' );

// INICIALIZA AS VARIÁVEIS
$inicio = 0;
function cabecalho($pdf, $xx, $paginas, $nome, $data) {
	global $today;
	
	$pdf->Open ();
	$pdf->AddPage ();
	
	// Logo da empresa
	// endereco da imagem,posicao X(horizontal),posicao Y(vertical), tamanho altura, tamanho largura
	// $pdf->Image("../../images/logo1.jpg", 11,11, 50);
	
	/*
	 * $pdf->SetFont("Arial", "", 7); $pdf->SetFillColor(255,255,255); $pdf->Cell(55, 18, " ", 1, 0, 'L', 0); $pdf->Cell(135, 18, " ", 1, 0, 'L', 0);
	 */
	
	// Cabeçalho do sistema
	/*
	 * $pdf->Ln(0); $pdf->Cell(55, 5, " ", 0, 0, 'C', 0); $pdf->Cell(30, 5, "DITIN", 0, 0, 'L', 0); $pdf->Cell(75, 5, "Data de Emissão: $today", 0, 0, 'C'); $pdf->Cell(30, 5, "Página: $xx ", 0, 0, 'R', 0);
	 */
	
	// Título
	/*
	 * $pdf->Ln(5); $pdf->SetFont("Arial", "B", 11); $pdf->Cell(55, 10, " ", 0, 0, 'C', 0); $pdf->Cell(135, 6, "1º Seminário Científico e Tecnológico de Bio-Manguinhos", 0, 0, 'C');
	 */
	
	// Parametros
	/*
	 * $pdf->Ln(8); $pdf->SetFont("Arial", "", 8); $pdf->Cell(55, 10, " ", 0, 0, 'C', 0); $pdf->Cell(93, 5, "Autor: $nome", 0, 0, 'L'); $pdf->Cell(45, 5, "Enviado: $data", 0, 0, 'L');
	 */
	
	// QUEBRA DE LINHA
	$pdf->Ln ( 7 );
	$pdf->SetFont ( "Arial", "B", 10 );
	// MONTA O CABEÇALHO
	$pdf->SetFillColor ( 190, 190, 190 );
	
	// $pdf->Cell(50, 7, "Empresa", 1, 0, 'C',1);
	$pdf->SetFont ( "Arial", "", 8 );
}

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
		case ("visualizar") :
			isset ( $_GET ['IdResumo'] ) ? $IdResumo = limpa_sql_injection ( trim ( ($_GET ['IdResumo']) ) ) : $IdResumo = '';
			
			$x = 0;
			$xx = 0;
			
			try {
				
				$response->IdResumo = $IdResumo;
				$DAO = new ResumoDAO ();
				$objResumo = $DAO->retornar($IdResumo);
				if ($objResumo) {
					
					$IdUsuario = $objResumo->getIdUsuario ();
					
					$DataInclusao = Formatacao::formatarDataHoraSQL ( $objResumo->getDataInclusao (), false );
					$Tipos = array (
							"" => "-",
							0 => "-",
							1 => "Biofármacos",
							2 => "Kits para diagnóstico",
							3 => "Vacinas",
							4 => "Outros" 
					);
					$TipoResumo = $Tipos [$objResumo->getTipo ()];
					
					$DAO1 = new UsuarioDAO ();
					$objUsuario = $DAO1->retornar($IdUsuario);
					if ($objUsuario) {
						$NomeUsuario = utf8_decode ( $objUsuario->getNome () );
						// $response->Email = utf8_decode($objUsuario->getEmail());
					}
					
					$xx ++;
					// Cabeçalho
					cabecalho ( $pdf, $xx, $paginas, $NomeUsuario, $DataInclusao );
					$pdf->SetLeftMargin ( 25 );
					$pdf->SetRightMargin ( 25 );
					
					// Parametros do PDF
					$pdf->SetAuthor ( $objResumo->getAutores () );
					$pdf->SetKeywords ( $TipoResumo );
					$pdf->SetSubject ( $TipoResumo );
					$pdf->SetTitle ( $objResumo->getTitulo () );
					
					// Principal
					$pdf->SetFont ( 'Times', '', 12 );
					$pdf->Ln ( 20 );
					
					$pdf->SetFont ( 'Times', 'B', 14 );
					$pdf->Write ( 5, trim ( $objResumo->getTitulo () ) );
					// $pdf->MultiCell(180, 10, utf8_encode(trim($objResumo->getTitulo())), 1, 'L', 0, 1);
					// $pdf->Cell(60, 5, utf8_encode("Titulo: ".trim($objResumo->getTitulo())) , 0, 1, 'L', 0);
					$pdf->Ln ( 10 );
					
					$pdf->SetFont ( 'Times', 'I', 12 );
					$pdf->Write ( 5, trim ( $objResumo->getAutores () ) );
					$pdf->Ln ( 7 );
					
					$pdf->Write ( 5, trim ( $objResumo->getInstituicao () ) );
					$pdf->Ln ( 10 );
					
					$pdf->SetFont ( 'Times', 'B', 12 );
					$pdf->Write ( 5, 'Objetivo' );
					$pdf->Ln ( 5 );
					$pdf->SetFont ( 'Times', '', 12 );
					$pdf->Write ( 5, trim ( $objResumo->getObjetivo () ) );
					$pdf->Ln ( 10 );
					
					$pdf->SetFont ( 'Times', 'B', 12 );
					$pdf->Write ( 5, 'Metodologia' );
					$pdf->Ln ( 5 );
					$pdf->SetFont ( 'Times', '', 12 );
					$pdf->Write ( 5, trim ( $objResumo->getMetodologia () ) );
					$pdf->Ln ( 10 );
					
					$pdf->SetFont ( 'Times', 'B', 12 );
					$pdf->Write ( 5, 'Resultado' );
					$pdf->Ln ( 5 );
					$pdf->SetFont ( 'Times', '', 12 );
					$pdf->Write ( 5, trim ( $objResumo->getResultado () ) );
					$pdf->Ln ( 10 );
					
					$pdf->SetFont ( 'Times', 'B', 12 );
					$pdf->Write ( 5, 'Conclusão' );
					$pdf->Ln ( 5 );
					$pdf->SetFont ( 'Times', '', 12 );
					$pdf->Write ( 5, trim ( $objResumo->getConclusao () ) );
					$pdf->Ln ( 10 );
					
					// Data e Assinatura
					$pdf->SetFont ( "Arial", "", 10 );
					
					// Rodape
					$pdf->Ln ( 4 );
					// $pdf->Cell(0, 5, "*.", 0, 1, 'L');
					
					// SAIDA DO PDF
					$pdf->Output ( "SACTBio 2013 - (IdResumo: $IdResumo) (Nome: $NomeUsuario).pdf", "I" );
				} else {
					echo "Resumo Não encontrato em nossa base de dados. (Id:$IdResumo)";
				}
			} catch ( PDOException $ex ) {
				echo utf8_encode ( $ex->getMessage () );
			}
			
			break;
		
		default :
			echo "Ação não encontrada para este controle.<br/>(metodo: GET, acao:'$acao')";
			
			break;
	}
} else {
	echo "Método de envio não identificado.";
}
?>