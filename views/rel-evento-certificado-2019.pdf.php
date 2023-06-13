<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

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
                        $IdParticipante = $objEventoPresenca->getIdParticipante();
                        $NomeCracha = $objEventoPresenca->getNomeCracha();
						$NomeParticipante = $objEventoPresenca->getNomeParticipante();                   
                    
                        header("Expires: 0");
                        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
                        //header('Content-type: application/pdf');
                        $html = '';
                            
                        //Limpa o buffer jogando todo o HTML em uma variavel.
                        $html = ob_get_clean();
                        //$mpdf=new mPDF();
                            
                        // initiate FPDI
                        $pdf = new FPDI();
                        
						$pdf->AddFont('Swis721','I','Swis721_Cn_BT_Italic.php');
						$pdf->AddFont('Swis721','B','swiss 721 bold condensed bt.php');		
						$pdf->AddFont('TitilliumWeb','B','TitilliumWeb-SemiBold.php');							
						
                        // add a page
                        $pdf->AddPage('L');
                        $pdf->setSourceFile("templates//layout_certificado_2019.pdf");
                        // import page 1
                        $tplIdx = $pdf->importPage(1);
                        // use the imported page and place it at point 10,10 with a width of 100 mm
                        $pdf->useTemplate($tplIdx);
						
						//Texto do Certificado
						$texto = 'has attended the IV International Symposium on Immunobiologicals as participant.';
						$texto .='The IV ISI was organized by the Institute of Technology in Immunobiologicals (Bio-Manguinhos/Fiocruz) on May 7th, 8th and 9th, 2019, in Rio de Janeiro, Brazil, with 26 hours duration.';

						
						// Nome do Participante
                        $pdf->Ln(60);
                        $pdf->SetFont('Swis721', 'I', 53);
						$pdf->SetTextColor(29, 83, 148);
                        $pdf->Cell(36, 30, ' ', 0, 0, 'C');
                        $pdf->MultiCell(205, 20, utf8_decode($NomeParticipante), 0, 'C');						
						
						$pdf->Ln(5);
						$pdf->SetFont('TitilliumWeb', 'B', 14);
						$pdf->SetTextColor(0, 0, 0);	
						$pdf->Cell(30, 30, ' ', 0, 0, 'C');							
						$pdf->MultiCell(215, 6, utf8_decode($texto), 0, 'C');						
                        
                        // Chave
                        $pdf->Ln(40);
						$pdf -> SetY(180);
                        $pdf->SetFont('Arial', '', 5);
                        $pdf->SetTextColor(125, 125, 125);
                        $pdf->Cell(40, 5, ' ', 0, 0, 'C');
                        $pdf->MultiCell(200, 5, $Chave, 0, 'C');
                        
                        $pdf->Output();
                        exit;                    
                
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