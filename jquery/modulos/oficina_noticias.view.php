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
<?php 
// include("quadro_menu_vertical.php");
include ("quadro_menu_vertical.php");

?>
    <div id="posts" class="post">
	<?php //include("quadro_mensagem.php"); ?>
	<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>II Oficina - Notícias</h2>
			<div class="div_palestrante">
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">14/02/2014 - Com o
						objetivo de capacitar e preparar os colaboradores da comunidade
						Fiocruz a participarem de eventos e congressos
						técnico-científicos, foi promovida a II Oficina para elaboração de
						resumos e pôsteres. O evento ocorreu dia 14 de fevereiro, no
						auditório do Museu da Vida, e contou com cerca de 90 inscritos da
						Fundação e 80 de Bio-Manguinhos.... </span> &nbsp;&nbsp; <a
						href="noticias/Oficina-hotsite.pdf" TARGET="_blank">saiba mais</a>
					<img src="images/tracejado.png" alt="" />
				</p>


			</div>

			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>