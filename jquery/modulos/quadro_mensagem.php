<?php
require_once "admin/includes/global.php";
require_once "admin/includes/private.php";
require_once "admin/includes/format.php";

$TXT_BUSCA = "";
$PAG_NUMERO = 1;

getDadosModulo ();

// IsOnLine();

getDadosUsuario ();

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
</head>
<body>
<?php include("cabecalho.php"); ?>
<div id="content">
<?php include("quadro_menu_vertical.php"); ?>
    <div id="posts" class="post">
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Anais</h2>
			<p class="p_text">
				<br />
			</p>

			<div class="div_palestrante">
				<p>
					<img class="img_palestrante" src="images/anais_capa"
						style="border: solid 1px #CDC5BF;" height="90px;" />&nbsp;&nbsp; <span
						class="noticia_titulo">Anais do II Seminário Anual científico e
						Tecnológico em Imunobiológicos</span><br />
					&nbsp;&nbsp;&nbsp;Vacinas, Biofármacos, Reativos para diagnósticos
					e outros temas &nbsp;&nbsp;</br> &nbsp;&nbsp;&nbsp;<a
						href="anais/segundo_seminario_book.pdf" TARGET="_blank">saiba mais</a>
					<img src="images/tracejado.png" alt="" />
				</p>

			</div>
			<div class="cleardiv"></div>
		</div>
		<!-- MODULO CONTEUDO - FINAL *** //-->
	</div>
<?php include("rodape.php"); ?>
</body>
</html>