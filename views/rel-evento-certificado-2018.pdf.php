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
   
$titulo = 'Certificado';


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
                    //$objEventoPresenca = $daoEventoPresenca->retornarPorEventoParticipante($IdEvento, $IdParticipante);
                    $objEventoPresenca = $daoEventoPresenca->retornarPorChave($Chave);
                    if ($objEventoPresenca){
                        $Id = $objEventoPresenca->getId();
                        $IdEvento = $objEventoPresenca->getIdEvento();
                        $IdParticipante = $objEventoPresenca->getIdParticipante();
                        $NomeCracha = $objEventoPresenca->getNomeCracha();
                        
                        $daoEvento = new EventoDAO();
                        $objEvento = $daoEvento->retornar($IdEvento);
                        if ($objEvento){
                            $NomeEvento = $objEvento->getNome();
                            $DataInicial = $objEvento->getDataInicial();
                            $DataFinal = $objEvento->getDataFinal();
                            $CargaHoraria = $objEvento->getCargaHoraria();
                            $TextoCertificado = $objEvento->getTextoCertificado();
                        }
                        $CargaHoraria = str_replace(':00', '', $CargaHoraria); // Remover os minutos se for Hora exata;
                        if (substr($CargaHoraria,0,1)=='0') { $CargaHoraria = substr($CargaHoraria, 1); } // Remover o Zero a esquerda;

                        if (($IdEvento==2) || ($IdEvento==3) || ($IdEvento==4) || ($IdEvento==5)){ // Eventos Agrupado no mesmo Certificado
                            $Horas=0;
                            $Minutos=0;
                            $listagem = $daoEventoPresenca->listar(null, null, '1', 'asc', '2,3,4,5', null, $IdParticipante);
                            if ($listagem) {
                                foreach ($listagem as $item){
                                    $arrHoras = explode(':', $objEvento->getCargaHoraria());
                                    $Horas+= intval($arrHoras[0]);
                                    $Minutos+= intval($arrHoras[1]);
                                    
                                    if ($item->getEntrada()){
                                        $tmpData = ($item->getEntrada()) ? Formatacao::formatarDataSQL($item->getEntrada(), false) : '';
                                        $arrData = explode('/', $tmpData);
                                        $Dias .= ($Dias)? ', '.$arrData[0]: $arrData[0];
                                    }
                                }
                            }
                            if ($Minutos>60){ // Tem mais de 60 minutos ?
                                $Horas += intval($Minutos/60);
                                $Minutos = ($Minutos % 60); // Somente o resto dos minutos;
                            } 
                            if ($Minutos>0){
                                $CargaHoraria = $Horas.':'.$Minutos;
                            } else {
                                $CargaHoraria = $Horas;
                            }
                            
                        }
                                                
                        $daoEventoParticipante = new EventoParticipanteDAO();
                        $objEventoParticipante = $daoEventoParticipante->retornarPorEventoParticipante($IdEvento, $IdParticipante);
                        if ($objEventoParticipante){
                            $IdEventoParticipante = $objEventoParticipante->getId();
                            $NomeParticipante = $objEventoParticipante->getNomeParticipante();
                        } else {
                            $IdEventoParticipante = 0;
                            $NomeParticipante = '';
                        }
                        
                        // sUBSTITUIR vARIÁVEIS
                        $TextoCertificado = str_replace('{EVENTO}', $NomeEvento, $TextoCertificado);
                        $TextoCertificado = str_replace('{DIAS}', $Dias, $TextoCertificado);
                        $TextoCertificado = str_replace('{CARGAHORARIA}', $CargaHoraria, $TextoCertificado);
                    
                    
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
                        $pdf->setSourceFile("templates//layout_certificado_2018.pdf");
                        // import page 1
                        $tplIdx = $pdf->importPage(1);
                        // use the imported page and place it at point 10,10 with a width of 100 mm
                        $pdf->useTemplate($tplIdx);
						
						//Texto do Certificado
						$texto = 'participou do VI Seminário Anual Científico e Tecnológico de Bio-Manguinhos, que aconteceu de 8 a 10 de maio de 2018, com carga horária de 19 horas, organizado pelo Instituto de Tecnologia em Imunobiológicos (Bio-Manguinhos/Fiocruz).';
						
						// Nome do Participante
                        $pdf->Ln(80);
                        $pdf->SetFont('TwCenMT', '', 48);
						$pdf->SetTextColor(0, 0, 0);
                        $pdf->Cell(36, 30, ' ', 0, 0, 'C');
                        $pdf->MultiCell(205, 13, utf8_decode($NomeParticipante), 0, 'C');						
						
						$pdf->Ln(10);
						$pdf->SetFont('TwCenMT', '', 17);
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