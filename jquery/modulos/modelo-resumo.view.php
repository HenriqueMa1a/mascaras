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
			<h2>Como fazer? - Modelo de Resumo</h2>
			<div class="description">
				<p class="p_text">
					&nbsp;<strong>Fonte do resumo: Final programme & abstracts IPNC
						2008</strong> <br />
					<br />
				</p>
				<input type="image" style="margin-left: 17px;" class="image_p"
					src="images/modelo_resumo.png" />
				<p class="p_text">
					<br /> <a href="controller.php?modulo=como-fazer-resumo">Voltar -
						Como fazer Resumo?</a>
				</p>
			</div>
			<div class="cleardiv"></div>
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>