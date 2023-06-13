<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../assets/global.php';
require_once '../assets/Arquivo.class.php';
require_once '../assets/Formatacao.class.php';
require_once '../assets/Validacao.class.php';
require_once '../assets/DataHora.class.php';
require_once '../assets/UUID.class.php';
require_once '../modelo/ResumoDAO.class.php';
require_once '../models/InscricaoDAO.class.php';

date_default_timezone_set("Brazil/East");

//Carregando a biblioteca mPDF
//require_once '../assets/mpdf/mpdf.php';
require_once '/var/www/html/isi/vendor/autoload.php';

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
			$IdResumo = filter_input(INPUT_GET, 'IdResumo', FILTER_SANITIZE_NUMBER_INT);
			
			$x = 0;
			$xx = 0;
			try {
				
				$response->IdResumo = $IdResumo;
				$DAO = new ResumoDAO();
				$objResumo = $DAO->retorna($IdResumo);
				if ($objResumo) {
					
					$IdUsuario = $objResumo->getIdUsuario ();
					
					$DataInclusao = Formatacao::formatarDataHoraSQL($objResumo->getDataInclusao (), false);
					$Tipos = array (
							"" => "-",
							0 => "-",
							1 => "Biofármacos",
							2 => "Kits para diagnóstico",
							3 => "Vacinas",
							4 => "Outros",
                            9 => "Teste" 
					);
					$TipoResumo = $Tipos [$objResumo->getTipo ()];
					
					$DAO1 = new InscricaoDAO();
					$objUsuario = $DAO1->retornar($IdUsuario);
					if ($objUsuario) {
						$NomeUsuario = utf8_decode( $objUsuario->getNome () );
						// $response->Email = utf8_decode($objUsuario->getEmail());
					}
					$autor1 = $objResumo->getAutor1 ();
					$autor2 = $objResumo->getAutor2 ();
					$autor3 = $objResumo->getAutor3 ();
					$autor4 = $objResumo->getAutor4 ();
					$autor5 = $objResumo->getAutor5 ();
					$autor6 = $objResumo->getAutor6 ();
					$autor7 = $objResumo->getAutor7 ();
					$autor8 = $objResumo->getAutor8 ();
					$autor9 = $objResumo->getAutor9 ();
					$autor10 = $objResumo->getAutor10 ();
					$arrAutores = array (
							"autores" => array (
									1 => $autor1,
									2 => $autor2,
									3 => $autor3,
									4 => $autor4,
									5 => $autor5,
									6 => $autor6,
									7 => $autor7,
									8 => $autor8,
									9 => $autor9,
									10 => $autor10 
							) 
					);
					
					$Instituicao1 = $objResumo->getInstituicao1 ();
					$Instituicao2 = $objResumo->getInstituicao2 ();
					$Instituicao3 = $objResumo->getInstituicao3 ();
					$Instituicao4 = $objResumo->getInstituicao4 ();
					$Instituicao5 = $objResumo->getInstituicao5 ();
					$Instituicao6 = $objResumo->getInstituicao6 ();
					$Instituicao7 = $objResumo->getInstituicao7 ();
					$Instituicao8 = $objResumo->getInstituicao8 ();
					$Instituicao9 = $objResumo->getInstituicao9 ();
					$Instituicao10 = $objResumo->getInstituicao10 ();
					$arrInstituicao = array (
							"instituicao" => array (
									1 => $Instituicao1,
									2 => $Instituicao2,
									3 => $Instituicao3,
									4 => $Instituicao4,
									5 => $Instituicao5,
									6 => $Instituicao6,
									7 => $Instituicao7,
									8 => $Instituicao8,
									9 => $Instituicao9,
									10 => $Instituicao10 
							) 
					);
					$result = array_unique ( $arrInstituicao ["instituicao"] );
					
					// inicia o buffer
					ob_start ();
					
					// pega o conteudo do buffer, insere na variavel e limpa a memória
					$html = ob_get_clean ();
					$html = '';
					
					// Titulo
					// $html = '<strong>'.$html.trim($objResumo->getCodResumo()).' - </strong>'. $html.trim($objResumo->getTitulo());
					$html = $html . '<p align="justify" style="font-size:12pt;">' . limparHTML ( $objResumo->getTitulo () ) . "<br/>\n";
					function numInstituicao($Instituicao, $IdResumo) {
						$DAO = new ResumoDAO ();
						$objResumo = $DAO->retorna($IdResumo);
						$Instituicao1 = $objResumo->getInstituicao1 ();
						$Instituicao2 = $objResumo->getInstituicao2 ();
						$Instituicao3 = $objResumo->getInstituicao3 ();
						$Instituicao4 = $objResumo->getInstituicao4 ();
						$Instituicao5 = $objResumo->getInstituicao5 ();
						$Instituicao6 = $objResumo->getInstituicao6 ();
						$Instituicao7 = $objResumo->getInstituicao7 ();
						$Instituicao8 = $objResumo->getInstituicao8 ();
						$Instituicao9 = $objResumo->getInstituicao9 ();
						$Instituicao10 = $objResumo->getInstituicao10 ();
						$arrInstituicao = array (
								"instituicao" => array (
										1 => $Instituicao1,
										2 => $Instituicao2,
										3 => $Instituicao3,
										4 => $Instituicao4,
										5 => $Instituicao5,
										6 => $Instituicao6,
										7 => $Instituicao7,
										8 => $Instituicao8,
										9 => $Instituicao9,
										10 => $Instituicao10 
								) 
						);
						$result = array_unique ( $arrInstituicao ["instituicao"] );
						
						$v = 1;
						$valor = '';
						$retorno = 0;
						foreach ( $result as $p_r ) {
							if ($p_r != '' || $p_r != null) {
								if ($Instituicao == $p_r) {
									$valor = $p_r;
									$retorno = $v;
								}
							}
							$v ++;
						}
						return $retorno;
					}
					function statusApresentador($num, $id) {
						$DAO = new ResumoDAO ();
						$objValor = $DAO->retornaApresentador ( $id );
						$result = "";
						$arr = array (
								"apresentador" => array (
										1 => $objValor->getApresentador1 (),
										2 => $objValor->getApresentador2 (),
										3 => $objValor->getApresentador3 (),
										4 => $objValor->getApresentador4 (),
										5 => $objValor->getApresentador5 (),
										6 => $objValor->getApresentador6 (),
										7 => $objValor->getApresentador7 (),
										8 => $objValor->getApresentador8 (),
										9 => $objValor->getApresentador9 (),
										10 => $objValor->getApresentador10 () 
								) 
						);
						if ($arr ["apresentador"] [$num] == 1) {
							$result = " *";
						}
						return $result;
					}
					
					// Autores /Instituição
					//$html = $html . '<p align="justify">';
					$i = 1;
					$asterisco = '*';
					$arrInstCompare = array (
							"instCompare" => array (
									1 => $Instituicao1,
									2 => $Instituicao2,
									3 => $Instituicao3,
									4 => $Instituicao4,
									5 => $Instituicao5,
									6 => $Instituicao6,
									7 => $Instituicao7,
									8 => $Instituicao8,
									9 => $Instituicao9,
									10 => $Instituicao10 
							) 
					);
                    $linhaInstituicao='';
					foreach ( $result as $p_Instituicao ) {
						if ($i == 1) {
							$contador = 1;
                            $linhaAutores='';
							foreach ( $arrAutores ["autores"] as $p_Autores ) {
								if ($p_Autores != '' || $p_Autores != null) {
									
									if ($contador == 1) {
										if ($objResumo->getApresentador1 () == 1) {
											$linhaAutores.= trim ( $p_Autores ) . "<sup>1</sup>" . $asterisco . "; ";
										} else {    
											$linhaAutores.= trim ( $p_Autores ) . "<sup>1</sup>; ";
										}
									} else {
										if ($arrInstCompare != '' || $arrInstCompare != null) {
											$linhaAutores.= trim ( $p_Autores ) . "<sup>" . trim(numInstituicao ( $arrInstCompare ["instCompare"] [$contador], $IdResumo )) . "</sup>" . trim(statusApresentador ( $contador, $IdResumo )) . "; ";
										}
									}
								}
								$apresentador = "";
								
								$contador ++;
							}
                            $linhaAutores = substr(trim($linhaAutores),0, -1).'.';
							$html.= $linhaAutores. '<br/>';
						}
						
						if ($p_Instituicao != '' || $p_Instituicao != null) {
                            if ($linhaInstituicao!=''){$linhaInstituicao.= "<br/>";}
							$linhaInstituicao.= trim ( "<sup>" . $i . "</sup>" . $p_Instituicao ) . ";";
						}
						
						$i ++;
					}
                    $linhaInstituicao = substr(trim($linhaInstituicao),0, -1).'.';
					$html.= $linhaInstituicao;
                    
					//$html.= '</p>';
					$html.= '<br/><br/>';
					
					// Introdução
					//$html = $html . '<p align="justify"><strong>Introdução:</strong> ' . limparHTML ( $objResumo->getintroducao () ) . "</p>\n";
					$html = $html . '<strong>Introduction:</strong> ' . limparHTML ( $objResumo->getintroducao () ) . "<br/><br/>\n";
					
					// Objetivos
					//$html = $html . '<p align="justify"><strong>Objetivo:</strong> ' . limparHTML ( $objResumo->getObjetivo () ) . "</p>\n";
					$html = $html . '<strong>Objective:</strong> ' . limparHTML ( $objResumo->getObjetivo () ) . "<br/><br/>\n";

					// Metodologia
					//$html = $html . '<p align="justify"><strong>Metodologia:</strong> ' . limparHTML ( $objResumo->getMetodologia () ) . "</p>\n";
					$html = $html . '<strong>Methodology :</strong> ' . limparHTML ( $objResumo->getMetodologia () ) . "<br/><br/>\n";
					
					// Resultados
					//$html = $html . '<p align="justify"><strong>Resultados:</strong> ' . limparHTML ( $objResumo->getResultado () ) . "</p>\n";
					$html = $html . '<strong>Results:</strong> ' . limparHTML ( $objResumo->getResultado () ) . "<br/><br/>\n";
					
					// Conclusão
					//$html = $html . '<p align="justify"><strong>Conclusão:</strong> ' . limparHTML ( $objResumo->getConclusao () ) . "</p>\n";
					$html = $html . '<strong>Conclusion:</strong> ' . limparHTML ( $objResumo->getConclusao () ) . "<br/><br/>\n";
					
					// Palavras-Chave
					//$html = $html . '<p><strong>Palavras-Chave:</strong> ' . limparHTML ( utf8_decode($objResumo->getPalavraChave ()) ) . "</p>\n";
					$html = $html . '<strong>Keywords:</strong> ' . limparHTML ( $objResumo->getPalavraChave () ) . "<br/><br/></p>\n";
					
					/*
					 * //set it to writable location, a place for temp generated PNG files $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR; //html PNG location prefix $PNG_WEB_DIR = 'temp/'; //ofcourse we need rights to create temp dir if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR); //ofcourse we need rights to create temp dir $filename = $PNG_TEMP_DIR.'test.png'; $errorCorrectionLevel = 'L'; $matrixPointSize = 4; // user data $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png'; QRcode::png('http://sact.bio.fiocruz.br/desenvolvimento/admin/modulo/resumo/resumo.mpdf.php?acao=visualizar&IdResumo=31', $filename, $errorCorrectionLevel, $matrixPointSize, 2); //$html = $html.'<br/><br/>Código de Acesso: <img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>'; // benchmark QRtools::timeBenchmark();
					 */
					
					// converte o conteudo para uft-8
					$html = utf8_encode ( $html );
					
					// ob_clean(); // Limpar buffer de saida
					// exit($html);
					
					// cria o objeto
					// $mpdf=new mPDF();
					//$mpdf = new mPDF ( 'utf-8', 'A5', '12', 'Times New Roman', 15, 15, 10, 10 );
					$config = array('utf-8', 'A5', '12', 'Times New Roman', 15, 15, 10, 10, 9, 9, 'P');
					$mpdf = new \Mpdf\Mpdf ( $config );
					
					// permite a conversao (opcional)
					$mpdf->allow_charset_conversion = true;
					
					// converte todo o PDF para utf-8
					$mpdf->charset_in = 'utf-8';
					// $mpdf->charset_in='iso-8859-1';
					
					// escreve definitivamente o conteudo no PDF
					$mpdf->WriteHTML ( $html );

					// imprime
					$mpdf->Output();
					
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