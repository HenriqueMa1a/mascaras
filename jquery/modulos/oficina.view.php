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
			<h2>II Oficina</h2>
			<br />
			<br />
			<br />
			<br />
			<table cellpadding="5" cellspacing="5" border="0" width="100%">
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td width="10%" valign="top"><img src="images/Apresentacao.png"
						class="media-object" alt="" /><br /></td>
					<td><br /> <strong><a
							href="controller.php?modulo=oficina_apresentacao"
							style="text-decoration: none; color: #000000;"><span
								class="p_text">Apresentações</span></a></strong><br /></td>
					<td width="10%" valign="top"><img src="images/noticias.png"
						class="media-object" alt="" /><br /></td>
					<td><br /> <strong><a href="controller.php?modulo=oficina_noticias"
							style="text-decoration: none; color: #000000;"><span
								class="p_text">Notícias</span></a></strong><br /></td>
					<td width="10%" valign="top"><img src="images/fotos.png"
						class="media-object" alt="" /><br /></td>
					<td><br /> <strong><a href="controller.php?modulo=oficina_fotos"
							style="text-decoration: none; color: #000000;"><span
								class="p_text">Fotos</span></a></strong><br /></td>
				</tr>

			</table>
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