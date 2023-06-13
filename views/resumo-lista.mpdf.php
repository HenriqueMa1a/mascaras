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
//require_once '/var/www/html/isi/vendor/mpdf/mpdf/src/Mpdf.php';
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
			$Titulo = filter_input(INPUT_GET, 'Titulo');
			$Nome = filter_input(INPUT_GET, 'Nome');
			$IdTipo = filter_input(INPUT_GET, 'IdTipo', FILTER_SANITIZE_NUMBER_INT);
			$IdStatus = filter_input(INPUT_GET, 'IdStatus', FILTER_SANITIZE_NUMBER_INT);
			$EventoPrincipal = filter_input(INPUT_GET, 'EventoPrincipal', FILTER_SANITIZE_NUMBER_INT);
			$ExibeAutor = filter_input(INPUT_GET, 'ExibeAutor');

			try {
				
				$DAO = new ResumoDAO();
				$listagem = $DAO->lista($page, $rows, 'Codigo', $sord, $EventoPrincipal, '', $IdTipo, $Titulo, $Nome, $IdStatus);

				if ($listagem) {
					
					//para cada resumo da listagem
					// inicia o buffer
					ob_start ();
					
					// pega o conteudo do buffer, insere na variavel e limpa a memória
					$html = ob_get_clean ();
					$html = '';	
					
					foreach ($listagem as $objResumo){

						$IdResumo = $objResumo->getId();
	
						$Tipos = array (
								"" => "-",
								0 => "-",
								1 => "V (Vacina)",
								2 => "B (Biofármaco) ",
								3 => "R (Reativo para diagnóstico)",
								4 => "OTR (Outros temas relacionados)",
								5 => "G (Gestão)" 
						);
						$TipoResumo = $Tipos [$objResumo->getTipo ()];

						//Tipo do Resumo
						//$html = $html . '<p align="center" style="font-size:14pt;">' . limparHTML ( $objResumo->getCodResumo() ) . "<br/>\n";						
						$html.= '<p align="center" style="font-size:14pt;"><font color="blue"><b>Summary Code: </b>' . strip_tags ( limparHTML($objResumo->getCodResumo()) ) . '</font> &nbsp;&nbsp;&nbsp;&nbsp;<font color="red"><b>Version: ' . $objResumo->getRevisao() . "</b></font><br><br>";
						// Titulo						
						$html = $html . '<p align="justify" style="font-size:12pt;"> <strong>' . limparHTML ( $objResumo->getTitulo () ) . "</strong><br/>\n";
						if ($ExibeAutor == 'N') 
							$html = $html . '<br/>';
						
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
								if ($ExibeAutor == 'S'){
									$html = $html . '<p align="justify">';
									$html.= $linhaAutores. '<br/>';
								}
							}
							
							if ($p_Instituicao != '' || $p_Instituicao != null) {
								if ($linhaInstituicao!=''){$linhaInstituicao.= "<br/>";}
								$linhaInstituicao.= trim ( "<sup>" . $i . "</sup>" . $p_Instituicao ) . ";";
							}
							
							$i ++;
						}

						$linhaInstituicao = substr(trim($linhaInstituicao),0, -1).'.';
						if ($ExibeAutor == 'S'){
							$html.= $linhaInstituicao;		
							$html = $html . '<br/><br/>';
						}
						
						// Introdução
						$html = $html . '<strong>Introduction:</strong> ' . limparHTML ( $objResumo->getintroducao () ) . "<br/><br/>\n";
						
						// Objetivos
						$html = $html . '<strong>Objective:</strong> ' . limparHTML ( $objResumo->getObjetivo () ) . "<br/><br/>\n";

						// Metodologia
						$html = $html . '<strong>Methodology:</strong> ' . limparHTML ( $objResumo->getMetodologia () ) . "<br/><br/>\n";
						
						// Resultados
						$html = $html . '<strong>Results:</strong> ' . limparHTML ( $objResumo->getResultado () ) . "<br/><br/>\n";
						
						// Conclusão
						$html = $html . '<strong>Conclusion:</strong> ' . limparHTML ( $objResumo->getConclusao () ) . "<br/><br/>\n";
						
						// Palavras-Chave
						$html = $html . '<strong>Keywords:</strong> ' . limparHTML ( $objResumo->getPalavraChave () ) . "<br/></p>\n";

						// Quebrar página
						$html = $html . '<p style="page-break-before: always;"></p>';
					
					}//fim de cada resumo

					
					// converte o conteudo para uft-8
					$html = utf8_encode ( $html );

					$config = array('utf-8', 'A5', '12', 'Times New Roman', 15, 15, 10, 10, 9, 9, 'P');
					$mpdf = new \Mpdf\Mpdf ( $config );
					// permite a conversao (opcional)
					$mpdf->allow_charset_conversion = true;
					
					// converte todo o PDF para utf-8
					$mpdf->charset_in = 'utf-8';
					
					// escreve definitivamente o conteudo no PDF
					$mpdf->WriteHTML ( $html );
					
					// imprime
					$mpdf->Output ();
					
					// finaliza o codigo
					exit ();
				} else {
					echo "Resumo Não encontrato em nossa base de dados.";
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

?>