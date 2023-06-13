<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
ini_set('default_charset','UTF-8');

require_once '../assets/global.php';
require_once '../assets/Arquivo.class.php';
require_once '../assets/Formatacao.class.php';
require_once '../assets/Validacao.class.php';
require_once '../assets/DataHora.class.php';
require_once '../assets/UUID.class.php';
require_once '../models/EventoDAO.class.php';
require_once '../models/EventoParticipanteDAO.class.php';
require_once '../models/EventoPresencaDAO.class.php';
require_once '../models/InscricaoDAO.class.php';
require_once '../modelo/ResumoDAO.class.php';

// 1. Verifica o Usuário;

date_default_timezone_set("Brazil/East");

//Carregando a biblioteca fPDF
require_once "../assets/fpdf/fpdf.php";
require_once "../assets/fpdf/fpdi.php";

//Inicia o buffer, qualquer HTML que for sair agora sera capturado para o buffer
ob_start();

$response = new stdClass();
$response->inicio = date('Y-m-d H:i:s').' '.microtime(true);
$response->sucesso = 0;
$response->erro = 312;
$response->mensagem =  "Inicio do processamento";
$response->IdConteudo = 0;
   
$titulo = 'Certificado';

function trocarCarac($tituloTrab) {
	$texto = trim ( $tituloTrab );
	$texto = str_replace("&nbsp;", "", $texto);
	$texto = str_replace("<p>", "", $texto );
	$texto = str_replace("</p>", "", $texto );
	$texto = str_replace("&Aacute;", "Á", $texto);
	$texto = str_replace("&aacute;", "á", $texto);
	$texto = str_replace("&Acirc;" , "Â", $texto);
	$texto = str_replace("&acirc;" , "â", $texto);
	$texto = str_replace("&Agrave;", "À", $texto);
	$texto = str_replace("&agrave;", "à", $texto);
	$texto = str_replace("&Aring;" , "Å", $texto);
	$texto = str_replace("&aring;" , "å", $texto);
	$texto = str_replace("&Atilde;", "Ã", $texto);
	$texto = str_replace("&atilde;", "ã", $texto);
	$texto = str_replace("&Auml;"  , "Ä", $texto);
	$texto = str_replace("&auml;"  , "ä", $texto);
	$texto = str_replace("&AElig;" , "Æ", $texto);
	$texto = str_replace("&aelig;" , "æ", $texto);
	$texto = str_replace("&Eacute;", "É", $texto);
	$texto = str_replace("&eacute;", "é", $texto);
	$texto = str_replace("&Ecirc;" , "Ê", $texto);
	$texto = str_replace("&ecirc;" , "ê", $texto);
	$texto = str_replace("&Egrave;", "È", $texto);
	$texto = str_replace("&egrave;", "è", $texto);
	$texto = str_replace("&Euml;"  , "Ë", $texto);
	$texto = str_replace("&euml;"  , "ë", $texto);
	$texto = str_replace("&ETH;"   , "Ð", $texto);
	$texto = str_replace("&eth;"   , "ð", $texto);
	$texto = str_replace("&Iacute;", "Í", $texto);
	$texto = str_replace("&iacute;", "í", $texto);
	$texto = str_replace("&Icirc;" , "Î", $texto);
	$texto = str_replace("&icirc;" , "î", $texto);
	$texto = str_replace("&Igrave;", "Ì", $texto);
	$texto = str_replace("&igrave;", "ì", $texto);
	$texto = str_replace("&Iuml;"  , "Ï", $texto);
	$texto = str_replace("&iuml;"  , "ï", $texto);
	$texto = str_replace("&Oacute;", "Ó", $texto);
	$texto = str_replace("&oacute;", "ó", $texto);
	$texto = str_replace("&Ocirc;" , "Ô", $texto);
	$texto = str_replace("&ocirc;" , "ô", $texto);
	$texto = str_replace("&Ograve;", "Ò", $texto);
	$texto = str_replace("&ograve;", "ò", $texto);
	$texto = str_replace("&Oslash;", "Ø", $texto);
	$texto = str_replace("&oslash;", "ø", $texto);
	$texto = str_replace("&Otilde;", "Õ", $texto);
	$texto = str_replace("&otilde;", "õ", $texto);
	$texto = str_replace("&Ouml;"  , "Ö", $texto);
	$texto = str_replace("&ouml;"  , "ö", $texto);
	$texto = str_replace("&Uacute;", "Ú", $texto);
	$texto = str_replace("&uacute;", "ú", $texto);
	$texto = str_replace("&Ucirc;" , "Û", $texto);
	$texto = str_replace("&ucirc;" , "û", $texto);
	$texto = str_replace("&Ugrave;", "Ù", $texto);
	$texto = str_replace("&ugrave;", "ù", $texto);
	$texto = str_replace("&Uuml;"  , "Ü", $texto);
	$texto = str_replace("&uuml;"  , "ü", $texto);
	$texto = str_replace("&Ccedil;", "Ç", $texto);
	$texto = str_replace("&ccedil;", "ç", $texto);
	$texto = str_replace("&Ntilde;", "Ñ", $texto);
	$texto = str_replace("&ntilde;", "ñ", $texto);
	$texto = str_replace("&Yacute;", "Ý", $texto);
	$texto = str_replace("&yacute;", "ý", $texto);
	//str_replace("&quot;"  , """, $texto);
	$texto = str_replace("&lt;"    , "<", $texto);
	$texto = str_replace("&gt;"    , ">", $texto);
	$texto = str_replace("&amp;"   , "&", $texto);
	$texto = str_replace("&reg;"   , "®", $texto);
	$texto = str_replace("&copy;"  , "©", $texto);
	$texto = str_replace("&THORN;" , "Þ", $texto);
	$texto = str_replace("&thorn;" , "þ", $texto);
	$texto = str_replace("&szlig;" , "ß", $texto);
	
	return $texto;
}



if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //echo "[_GET['acao']:".$_GET['acao']."]";
    isset($_GET['acao']) ? $acao = $_GET['acao'] : $acao = '';
    isset($_GET['page']) ? $page = $_GET['page'] : $page = '';
    isset($_GET['rows']) ? $rows = $_GET['rows'] : $rows = '';
    isset($_GET['sidx']) ? $sidx = $_GET['sidx'] : $sidx = '';
    isset($_GET['sord']) ? $sord = $_GET['sord'] : $sord = '';
    if(!$sidx) $sidx = 1;

    switch($acao) {
        case("visualizar"):     
            
            try{
                
                $Id = filter_input(INPUT_GET, 'Id', FILTER_SANITIZE_NUMBER_INT);
                $Chave = filter_input(INPUT_GET, 'Chave', FILTER_SANITIZE_STRING);
                $IdEvento = filter_input(INPUT_GET, 'IdEvento', FILTER_SANITIZE_NUMBER_INT);
                $IdParticipante = filter_input(INPUT_GET, 'IdParticipante', FILTER_SANITIZE_NUMBER_INT);
				$IdResumo = filter_input(INPUT_GET, 'IdResumo', FILTER_SANITIZE_NUMBER_INT);
                
                $Dias = '';
                $CargaHoraria = '0';
                $NomeEvento = '';
                $TextoCertificado = '';
                $DataInicial = '';
                $DataFinal = '';
                
                $x=0;
                $xx=0;
                
                if ($Chave){
                    
                    $daoEventoPresenca = new EventoPresencaDAO();
                    $objEventoPresenca = $daoEventoPresenca->retornarPorChave($Chave);
                    if ($objEventoPresenca){
                        $Id = $objEventoPresenca->getId();
                        $IdEvento = $objEventoPresenca->getIdEvento();						
						
						$daoResumo = new ResumoDAO();
						$objResumo = $daoResumo->retornaResumoPorID($IdResumo);
						if($objResumo){ 
							//autores
							for($i=1; $i<11 ; $i++){								
								$autor = "getAutor{$i}"; ;
								if (!empty($objResumo->$autor())){
									$autores .= utf8_encode($objResumo->$autor()) . ', ';
								}
								
							}
							//titulo do trabalho
							//$titulo = strip_tags($objResumo->getTitulo());
							$tituloTrabalho = utf8_encode(strip_tags($objResumo->getTitulo()));
							
							/*//informações do evento, como texto padrão do certificado(será usado em 2017 apenas para certificado de posters)
							$daoEvento = new EventoDAO();
							$objEvento = $daoEvento->retornar($IdEvento);
							if ($objEvento){
								$NomeEvento = $objEvento->getNome();
								$DataInicial = $objEvento->getDataInicial();
								$DataFinal = $objEvento->getDataFinal();
								$CargaHoraria = $objEvento->getCargaHoraria();
								$TextoCertificado = $objEvento->getTextoCertificado();
							}							
							*/
							header("Expires: 0");
							header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
							//header('Content-type: application/pdf');
							$html = '';		

							//Limpa o buffer jogando todo o HTML em uma variavel.
							$html = ob_get_clean();
							//$mpdf=new mPDF();
								
							// initiate FPDI
							$pdf = new FPDI();
							$pdf->SetAuthor("Instituto de Tecnologia em Imunobiológicos Bio-Manguinhos |FIOCRUZ", true);
							$pdf->SetTitle("Certificado - $NomeEvento", true);
							$pdf->SetSubject("Certificado: $Chave", true);
							
							$pdf->AddFont('TwCenMT','','TCM_____.php'); 
							$pdf->AddFont('TwCenMT','I','TCMI____.php');
							$pdf->AddFont('TwCenMT','B','TCB_____.php');
							$pdf->AddFont('TwCenMT','BI','TCBI____.php');
							
							// add a page
							$pdf->AddPage('L');
							// set the source file
							$pdf->setSourceFile("templates//layout_certificado_2018.pdf");
							// import page 1
							$tplIdx = $pdf->importPage(1);
							// use the imported page and place it at point 10,10 with a width of 100 mm
							$pdf->useTemplate($tplIdx);
							
							//Texto do Certificado
							$texto1 = 'participaram como autores do pôster:';
							$texto2 = 'no VI Seminário Anual Científico e Tecnológico de Bio-Manguinhos, organizado pelo Instituto de Tecnologia em Imunobiológicos (Bio-Manguinhos/Fiocruz).';
							//$texto3 = 'foi aceito para a exposição de pôsteres e publicação nos anais do V Seminário Anual Científico e Tecnológico de Bio-Manguinhos, organizado pelo Instituto de Tecnologia em Imunobiológicos (Bio-Manguinhos/Fiocruz).';
							//$texto4 = 'Rio de Janeiro, 4 de maio de 2017.';
							
							// Montando o texto	
							$pdf->Ln(70);
							$pdf->SetFont('TwCenMT', '', 20);
							$pdf->SetTextColor(0, 0, 0);
							$pdf->Cell(30, 30, ' ', 0, 0, 'C');
							$pdf->MultiCell(215, 6, utf8_decode(substr($autores,0,-2)), 0, 'C');	

							$pdf->Ln(5);
							$pdf->SetFont('TwCenMT', '', 16);
							$pdf->SetTextColor(0, 0, 0);
							$pdf->Cell(30, 30, ' ', 0, 0, 'C');
							$pdf->MultiCell(215, 6, utf8_decode($texto1), 0, 'C');							
							
							$pdf->Ln(2);
							$pdf->SetFont('TwCenMT', 'B', 16);
							$pdf->SetTextColor(0, 0, 0);
							$pdf->Cell(30, 30, ' ', 0, 0, 'C');
							$pdf->MultiCell(215, 6, utf8_decode(trocarCarac($tituloTrabalho)), 0, 'C');
							
							$pdf->Ln(2);
							$pdf->SetFont('TwCenMT', '', 16);
							$pdf->SetTextColor(0, 0, 0);	
							$pdf->Cell(30, 30, ' ', 0, 0, 'C');							
							$pdf->MultiCell(215, 6, utf8_decode($texto2), 0, 'C');

							//$pdf->Ln(4);
							//$pdf->SetFont('Aller', '', 14);
							//$pdf->SetTextColor(0, 0, 0);
							//$pdf->Cell(30, 30, ' ', 0, 0, 'C');
							//$pdf->MultiCell(215, 6, utf8_decode($texto3), 0, 'C');							
							
							//$pdf -> SetY(145);
							//$pdf->SetFont('Aller', '', 14);
							//$pdf->SetTextColor(0, 0, 0);
							//$pdf->Cell(30, 30, ' ', 0, 0, 'C');
							//$pdf->MultiCell(215, 6, utf8_decode($texto4), 0, 'C');
														

							// Chave
							$pdf -> SetY(180);
							$pdf->SetFont('Arial', '', 5);
							$pdf->SetTextColor(125, 125, 125);
							$pdf->Cell(40, 5, ' ', 0, 0, 'C');
							$pdf->MultiCell(200, 5, $Chave, 0, 'C');
							
							$pdf->Output();
							exit; 
						}
                
                    } else {
                        echo utf8_decode("Erro ao localizar o registro com chave: '$Chave'.");
                    }            
                } else {
                    echo utf8_decode("O parametro <b>Chave</b> é de preenchimento obrigatório.<br/>(metodo: GET, chave:'$Chave')");
                }
            }catch ( Exception $ex ){ echo utf8_decode("Erro: ".$ex->getMessage()); }

        break;      
        
        default:
            echo utf8_decode("Ação não encontrada para este controle.<br/>(metodo: GET, acao:'$acao')");
        break;      
   }

} else {
    echo utf8_decode("Método de envio não identificado.");
}
?>