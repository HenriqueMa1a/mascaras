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
<link href="shadowbox_js/shadowbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="shadowbox_js/jquery.js"></script>
<script type="text/javascript" src="shadowbox_js/shadowbox.js"></script>
<script type="text/javascript">
 Shadowbox.init({
 language: 'pt',
 player: ['img', 'html', 'swf','php','asp']
 });
</script>
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
			<h2>II Oficina - Fotos</h2>
			<table cellpadding="5" cellspacing="5" border="0" width="100%">
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td valign="top"><a href="images/fotos_IIOficina/a1.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/a1.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>
					<td><a href="images/fotos_IIOficina/a2.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/a2.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
					<td valign="top"><a href="images/fotos_IIOficina/a3.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/a3.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>
					<td><a href="images/fotos_IIOficina/a4.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/a4.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
				</tr>
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td valign="top"><a href="images/fotos_IIOficina/a5.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/a5.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>
					<td><a href="images/fotos_IIOficina/a6.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/a6.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
					<td valign="top"><a href="images/fotos_IIOficina/a7.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/a7.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>
					<td><a href="images/fotos_IIOficina/a8.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/a8.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
				</tr>
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td><a href="images/fotos_IIOficina/a9.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/a9.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
					<td valign="top"><a href="images/fotos_IIOficina/b1.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/b1.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>
					<td><a href="images/fotos_IIOficina/b2.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/b2.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
					<td valign="top"><a href="images/fotos_IIOficina/b3.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/b3.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>

				</tr>
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td><a href="images/fotos_IIOficina/b4.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/b4.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
					<td valign="top"><a href="images/fotos_IIOficina/b5.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/b5.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>
					<td valign="top"><a href="images/fotos_IIOficina/b6.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/b6.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>
					<td valign="top"><a href="images/fotos_IIOficina/b7.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/b7.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>


				</tr>
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td><a href="images/fotos_IIOficina/b8.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/b8.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
					<td valign="top"><a href="images/fotos_IIOficina/b9.jpg"
						rel="shadowbox"><img src="images/fotos_IIOficina/b9.jpg"
							width="100" style="cursor: pointer; border: solid 1px #000000;" />
					</a></td>
					<td><a href="images/fotos_IIOficina/c1.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/c1.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
					<td><a href="images/fotos_IIOficina/c2.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/c2.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>


				</tr>
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td><a href="images/fotos_IIOficina/c3.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/c3.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>
					<td><a href="images/fotos_IIOficina/c4.jpg" rel="shadowbox"><img
							src="images/fotos_IIOficina/c4.jpg" width="100"
							style="cursor: pointer; border: solid 1px #000000;" /> </a></td>


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