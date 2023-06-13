<?php
require_once "admin/includes/global.php";
require_once "admin/includes/private.php";
require_once "admin/includes/format.php";

$TXT_BUSCA = "";
$PAG_NUMERO = 1;

getDadosModulo ();

// IsOnLine();

getDadosUsuario ();

$Galeria = new stdClass ();

if ($_GET ['dia'] == '13') {
	$Galeria->Titulo = isset ( $_GET ['titulo'] ) ? limpa_sql_injection ( $_GET ['titulo'] ) : 'Fotos do Seminário -  Dia 13';
	$Galeria->Caminho = isset ( $_GET ['caminho'] ) ? limpa_sql_injection ( $_GET ['caminho'] ) : 'galeria13';
} else if ($_GET ['dia'] == '14') {
	$Galeria->Titulo = isset ( $_GET ['titulo'] ) ? limpa_sql_injection ( $_GET ['titulo'] ) : 'Fotos do Seminário -  Dia 14';
	$Galeria->Caminho = isset ( $_GET ['caminho'] ) ? limpa_sql_injection ( $_GET ['caminho'] ) : 'galeria14';
} else {
	$Galeria->Titulo = isset ( $_GET ['titulo'] ) ? limpa_sql_injection ( $_GET ['titulo'] ) : 'Fotos do Seminário';
	$Galeria->Caminho = isset ( $_GET ['caminho'] ) ? limpa_sql_injection ( $_GET ['caminho'] ) : 'galeria12';
}

$Galeria->Descricao = isset ( $_GET ['descricao'] ) ? limpa_sql_injection ( $_GET ['descricao'] ) : '';

/**
 * Retorna os nomes dos arquivos de um diretório
 * 
 * @author Rafael Wendel Pinheiro
 * @param String $dir
 *        	Caminho do diretório a ser utilizado
 * @return array
 *
 */
function get_files_dir($dir, $tipos = null) {
	if (file_exists ( $dir )) {
		$dh = opendir ( $dir );
		while ( false !== ($filename = readdir ( $dh )) ) {
			if ($filename != '.' && $filename != '..') {
				if (is_array ( $tipos )) {
					$extensao = get_extensao_file ( $filename );
					if (in_array ( $extensao, $tipos )) {
						$files [] = $filename;
					}
				} else {
					$files [] = $filename;
				}
			}
		}
		if (is_array ( $files )) {
			sort ( $files );
		}
		return $files;
	} else {
		return false;
	}
}
/**
 * Retorna a extensão de um arquivo
 * 
 * @author Rafael Wendel Pinheiro
 * @param String $nome
 *        	Nome do arquivo a se capturar a extensão
 * @return resource Caminho onde foi salvo o arquivo, ou false em caso de erro
 *        
 */
function get_extensao_file($nome) {
	$verifica = explode ( '.', $nome );
	return $verifica [count ( $verifica ) - 1];
}
function getArquivoTitulo($p_arquivo) {
	$titulo = '';
	$exif = exif_read_data ( $p_arquivo, 0, true );
	if (! empty ( $exif ['IFD0'] ['Title'] )) {
		$titulo = $exif ['IFD0'] ['Title'];
	}
	
	$titulo = str_replace ( "\0", "", $titulo );
	return $titulo;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include_once ('tags.php');
include_once ('estilos.php');
include_once ('javascripts.php');

include_once ('jquery.php');
if (file_exists ( 'modulos/' . $MOD_CLASSE . '.js.php' ))
	include_once ('modulos/' . $MOD_CLASSE . '.js.php');
?> 
<style type="text/css" rel="stylesheet">
#galleria {
	position: absolute;
	width: 650px;
	height: 400px;
	background: #595959;
}
</style>
<!--INCLUDES DE JAVASCRIPTS DO jQuery.Galleria -->
<script type="text/javascript" language="JavaScript"
	src="admin/jquery/jquery.galleria-1.2.9.min.js"></script>
<!--INCLUDES DE JAVASCRIPTS DO jQuery.Galleria -->
</head>
<body onload="inicializar();">
<?php include("cabecalho.php"); ?>
<div id="content">
<?php include("quadro_menu_vertical.php"); ?>
    <div id="posts" class="post">
	<?php include("quadro_mensagem.php"); ?>
	<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2><?php echo $Galeria->Titulo; ?></h2>
			<div class="" style="">
				<!--
             <p class="p_text">		
                     &nbsp;<a href="controller.php?modulo=galeria&dia=12">Dia 12</a>
                     &nbsp;
                     <input type="image" src="images/next.png" />
                     &nbsp;
                     <a href="controller.php?modulo=galeria&dia=13">Dia 13</a>
                     &nbsp;
                     &nbsp;
                     <input type="image" src="images/next.png" />
                     &nbsp;
                     <a href="controller.php?modulo=galeria&dia=14">Dia 14</a>
                     &nbsp;
             </p >
-->
				<p class="p_text">
				<?php echo $Galeria->Descricao; ?>
			</p>

				<p class="p_text">
					<br />
				</p>
				<p class="p_text">
					Confira as fotos do I Seminário:<br />
				</p>

			</div>
			<div class="cleardiv"></div>
			<div class="description" style="height: 450px;">
				<div id="galleria">
<?php

$extensoes = array (
		'jpg',
		'png' 
);
$nomes = get_files_dir ( $Galeria->Caminho, $extensoes );

if (is_array ( $nomes )) {
	foreach ( $nomes as $nome ) {
		echo '<img src="' . $Galeria->Caminho . '/' . $nome . '" alt="' . getArquivoTitulo ( $Galeria->Caminho . '/' . $nome ) . '"  />';
	}
}

?>

<a href="images/classificacao_resumo.jpg" rel="shadowbox"><img
						src="images/classificacao_resumo.jpg" width="200" height="200"
						style="cursor: pointer; border: solid 1px #000000;" /> </a>
				</div>
			</div>

			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
<?
/*
$exif = exif_read_data('fotos/akira-homma.jpg', 0, true);
echo "akira-homma.jpg:<br />\n";
foreach ($exif as $key => $section) {
    foreach ($section as $name => $val) {
        echo "$key.$name: $val<br />\n";
    }
}
*/	
?>
</body>
</html>