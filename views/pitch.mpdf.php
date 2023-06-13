<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../assets/global.php';
require_once '../assets/Arquivo.class.php';
require_once '../assets/Formatacao.class.php';
require_once '../assets/Validacao.class.php';
require_once '../assets/DataHora.class.php';
require_once '../assets/UUID.class.php';
require_once '../modelo/PitchDAO.class.php';
require_once '../models/InscricaoDAO.class.php';


date_default_timezone_set("Brazil/East");

//Carregando a biblioteca mPDF
require_once '../assets/mpdf/mpdf.php';
require_once '../assets/phpqrcode/qrlib.php';

//Inicia o buffer, qualquer HTML que for sair agora sera capturado para o buffer
ob_start();

$response = new stdClass();
$response->inicio = date('Y-m-d H:i:s').' '.microtime(true);


function limparHTML($html) {
	$texto = trim ( $html );
	$texto = str_replace ( "<p>", "<span>", $texto );
	$texto = str_replace ( "<p ", "<span ", $texto );
	$texto = str_replace ( "</p>", "</span>", $texto );
	
	return $texto;
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
			$IdPitch = filter_input(INPUT_GET, 'IdPitch', FILTER_SANITIZE_NUMBER_INT);		
			$x = 0;
			$xx = 0;
			try {
				$response->IdPitch = $IdPitch;
				$DAO = new PitchDAO();
				$objPitch = $DAO->retorna($IdPitch);

				if ($objPitch) {
					$IdUsuario = $objPitch->getIdParticipante ();
					$DataInclusao = Formatacao::formatarDataHoraSQL($objPitch->getDataAcao (), false);
					$Fases = array (
							"" => "-",
							0 => "-",
							1 => "É apenas uma ideia",
							2 => "Já possui um protótipo/piloto/produto mínimo viável (MVP)",
							3 => "O produto/serviço já foi validado",
							4 => "A solução já está sendo comercializada"
					);
					
					$DAO1 = new InscricaoDAO();
					$objUsuario = $DAO1->retornar($IdUsuario);
					if ($objUsuario) {
						$Nome = utf8_decode( $objUsuario->getNomeCompleto () );
						$Cpf = $objUsuario->getCpf ();
						$Passaporte = $objUsuario->getPassaporte ();
						if($Cpf){
							$Doc = $objUsuario->getCpf ();
						}else{
							$Doc = $objUsuario->getPassaporte ();
						}
						$Email = $objUsuario->getEmail ();
						$Tel = $objUsuario->getTelefone ();
					}
					
					// inicia o buffer
					ob_start ();
					
					// pega o conteudo do buffer, insere na variavel e limpa a memória
					$html = ob_get_clean ();
					$html = '';
					
					//Representante
					$html = $html . '<strong>Nome:</strong> ' . limparHTML ( $Nome ) . "<br/>";
					$html = $html . '<strong>Documento:</strong> ' . limparHTML ( $Doc ) . "<br/>";
					$html = $html . '<strong>E-mail:</strong> ' . limparHTML ( $Email ) . "<br/>";
					$html = $html . '<strong>Telefone:</strong> ' . limparHTML ( $Tel ) . "<br/>";
					$html.= '<br/>';
					 
					// Produto/Serviço
					$html = $html . '<span text-align:"center;" style="font-size:12pt;" >';
					$html = $html . '<strong>Produto/Serviço</strong> <br/>';
					$html.= '</scan>';
					$html = $html . '<span text-align:"justify;" style="font-size:10pt;" >';
					$html = $html . '<strong>Nome do Produto/Serviço:</strong> <br/>' . limparHTML ( $objPitch->getDescricao () ) . "<br/>";
					$html = $html . '<br/><strong>WebSite:</strong> <br/>' . limparHTML ( $objPitch->getWebsite () ) . "<br/>";
					$html = $html . '<br/><strong>Tipo de Solução:</strong> <br/>' . limparHTML ( $objPitch->getTipoSolucao () ) . "<br/>";
					$html = $html . '<br/><strong>Descreva o problema do mercado de saúde que o seu PRODUTO/SERVIÇO quer resolver:</strong> <br/>' . limparHTML ( $objPitch->getProblema () ) . "<br/>";
					$html = $html . '<br/><strong>Explique como o seu PRODUTO/SERVIÇO soluciona o problema apresentado acima de forma inovadora:</strong> <br/>' . limparHTML ( $objPitch->getSolucao () ) . "<br/>";
					$html = $html . '<br/><strong>Indique o tamanho do mercado potencial do seu PRODUTO/SERVIÇO e a relevância para a saúde pública:</strong> <br/>' . limparHTML ( $objPitch->getRelevancia () ) . "<br/>";
					$html = $html . '<br/><strong>Descreva em linhas gerais o modelo de negócios do seu PRODUTO/SERVIÇO:</strong> <br/>' . limparHTML ( $objPitch->getModeloNegocios () ) . "<br/>";						
					$html.= '<br/>';
					$html.= '</scan>';
					
					// Equipe
					$html = $html . '<span text-align:"center;" style="font-size:12pt;" >';
					$html = $html . '<br/><strong>Equipe</strong> <br/>';
					$html.= '</scan>';
					$html = $html . '<span text-align:"justify;" style="font-size:10pt;" >';
					$html = $html . '<strong>Descrição da Equipe:</strong> <br/>' . limparHTML ( $objPitch->getEquipe () ) . "<br/>";
					$html.= '<br/>';
					$html.= '</scan>';
					
					// Fase
					$html = $html . '<span text-align:"center;" style="font-size:12pt;" >';
					$html = $html . '<br/><strong>Em qual fase de desenvolvimento está o seu PRODUTO/SERVIÇO?</strong>';
					$html.= '</scan>';
					$html = $html . '<br/><span text-align:"justify;" style="font-size:10pt;" >';
					$html = $html . limparHTML ( $Fases [$objPitch->getFase()] ) . "<br/>";
					$html.= '<br/>';
					$html.= '</scan>';
					
					// Geral
					$html = $html . '<span text-align:"center;" style="font-size:12pt;" >';
					$html = $html . '<br/><strong>Geral</strong> <br/>';
					$html.= '</scan>';
					$html = $html . '<span text-align:"justify;" style="font-size:10pt;" >';
					$html = $html . '<strong>Descreva as principais metas e objetivos para 2019 da solução em desenvolvimento:</strong> <br/>' . limparHTML ( $objPitch->getMetas () ) . "<br/>";
					$html = $html . '<br/><strong>Destaque o que sua empresa procura no espaço Innovation Hub:</strong> <br/>' . limparHTML ( $objPitch->getInnovation () ) . "<br/>";
					$html.= '<br/>';
					$html.= '</scan>';
					
					// Links
					$html = $html . '<span text-align:"center;" style="font-size:12pt;" >';
					$html = $html . '<br/><strong>Links sobre o PRODUTO/SERVIÇO</strong> <br/>';
					$html.= '</scan>';
					$html = $html . '<span text-align:"justify;" style="font-size:10pt;" >';
					$html = $html . limparHTML ( $objPitch->getLinks () ) . "<br/>";
					$html.= '</scan>';

					/*
					 * //set it to writable location, a place for temp generated PNG files $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR; //html PNG location prefix $PNG_WEB_DIR = 'temp/'; //ofcourse we need rights to create temp dir if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR); //ofcourse we need rights to create temp dir $filename = $PNG_TEMP_DIR.'test.png'; $errorCorrectionLevel = 'L'; $matrixPointSize = 4; // user data $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png'; QRcode::png('http://sact.bio.fiocruz.br/desenvolvimento/admin/modulo/resumo/resumo.mpdf.php?acao=visualizar&IdResumo=31', $filename, $errorCorrectionLevel, $matrixPointSize, 2); //$html = $html.'<br/><br/>Código de Acesso: <img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>'; // benchmark QRtools::timeBenchmark();
					 */
					
					// converte o conteudo para uft-8
					$html = utf8_encode ( $html );
					
					// ob_clean(); // Limpar buffer de saida
					// exit($html);
					
					// cria o objeto
					// $mpdf=new mPDF();
					$mpdf = new mPDF ( 'utf-8', 'A4', '12', 'Times New Roman', 15, 15, 10, 10 );
					
					// permite a conversao (opcional)
					$mpdf->allow_charset_conversion = true;
					
					// converte todo o PDF para utf-8
					$mpdf->charset_in = 'utf-8';
					// $mpdf->charset_in='iso-8859-1';
					
					// escreve definitivamente o conteudo no PDF
					$mpdf->WriteHTML ( $html );
					
					// imprime
					$mpdf->Output ();
					
					// finaliza o codigo
					exit ();
					
				} else {
					echo "Resumo Não encontrato em nossa base de dados. (Id:$IdResumo)";
                    echo "<br/>[".$DAO->_query."]";
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