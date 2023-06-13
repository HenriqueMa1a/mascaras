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
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9">
<?php
include_once ('tags.php');
include_once ('estilos.php');
include_once ('javascripts.php');

include_once ('jquery.php');
if (file_exists ( 'modulos/' . $MOD_CLASSE . '.js.php' ))
	include_once ('modulos/' . $MOD_CLASSE . '.js.php');
?> 
<style>
.stack {
	display: inline-block;
	line-height: 1px;
	position: relative;
	z-index: 10;
}

.stack>img {
	border: 6px solid #FFFFFF;
	border-radius: 3px;
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	box-sizing: border-box;
}

.no-boxshadow .stack>img {
	border-color: #CFCFCF;
}

.margin-bottom {
	margin-bottom: 16px !important;
}

.stack:before, .stack:after {
	background: none repeat scroll 0 0 #808080;
	border: 6px solid #FFFFFF;
	border-radius: 3px;
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
	box-sizing: border-box;
	content: "";
	height: 100%;
	left: 0;
	position: absolute;
	transition: all 0.3s ease-out 0s;
	width: 100%;
}

.stack:before {
	top: 4px;
	z-index: -10;
}

.stack:after {
	top: 8px;
	z-index: -20;
}

.stack.rotated:before {
	transform: rotate(2deg);
	transform-origin: left bottom 0;
}

.stack.rotated:after {
	transform: rotate(4deg);
	transform-origin: left bottom 0;
}

.stack.twisted:before {
	transform: rotate(4deg);
}

.stack.twisted:after {
	transform: rotate(-4deg);
}

.stack.rotated-left:before {
	transform: rotate(-3deg);
	transform-origin: left bottom 0;
}

.stack.rotated-left:after {
	transform: rotate(-6deg);
	transform-origin: left bottom 0;
}

.stack:hover:before, .stack:hover:after {
	transform: rotate(0deg);
}
</style>

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
			<h2>Álbum de Fotos</h2>
			<br />
			<br />
			<br />
			<br />

			<table cellpadding="5" cellspacing="5" border="0" width="100%">
				<tr>
					<th align="left">
						<h3>
							<strong>Fotos - 2014</strong>
						</h3>
					</th>
					<th align="left"><h3>
							<strong>Fotos - 2013</strong>
						</h3></th>
				</tr>
				<tr>
					<td valign="top">
						<table cellpadding="5" cellspacing="5" border="0" width="40%">
							<tr
								style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
								<td width="10%" valign="top">
									<div class="margin-bottom">
										<span class="stack rotated"> <img
											src="images/seminario2014/28/mini/DSC_0004.jpg"></span>
									</div>
								</td>
								<td><br /> <strong><a
										href="controller.php?modulo=album_28052014"
										style="text-decoration: none; color: #000000;"><span
											class="p_text">28/05/2014</span></a></strong><br /></td>

							</tr>
							<tr
								style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
								<td width="10%" valign="top">
									<div class="margin-bottom">
										<span class="stack rotated"> <img
											src="images/seminario2014/29/mini/DSC_0016.jpg"></span>
									</div>
								</td>
								<td><br /> <strong><a
										href="controller.php?modulo=album_29052014"
										style="text-decoration: none; color: #000000;"><span
											class="p_text">29/05/2014</span></a></strong><br /></td>

							</tr>
							<tr
								style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
								<td width="10%" valign="top">
									<div class="margin-bottom">
										<span class="stack rotated"> <img
											src="images/seminario2014/30/mini/DSC_0006.jpg"></span>
									</div>
								</td>
								<td><br /> <strong><a
										href="controller.php?modulo=album_30052014"
										style="text-decoration: none; color: #000000;"><span
											class="p_text">30/05/2014</span></a></strong><br /></td>

							</tr>

						</table>
					</td>
					<td valign="top">
						<table cellpadding="5" cellspacing="5" border="0" width="60%">
							<tr
								style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
								<td width="10%" valign="top">
									<div class="margin-bottom">
										<span class="stack rotated"> <img src="galeria12/mini/a1.jpg"></span>
									</div> <br />
								<strong><a href="controller.php?modulo=album_2013"
										style="text-decoration: none; color: #000000;"><span
											class="p_text">Agosto de 2013</span></a></strong><br />
								</td>

							</tr>
						</table>

					</td>

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