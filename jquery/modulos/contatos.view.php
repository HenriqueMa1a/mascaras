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
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Contatos</h2>
			<div class="description">
				<p class="p_text">
					Para dúvidas, entrar em contato através<br /> do e-mail:<a
						href="mailto:sact@bio.fiocruz.br;" style="color: #000000;">sact@bio.fiocruz.br</a><br />
					Ou por telefone:<br /> Falar com Cassia Machado <br /> (secretária
					executiva do seminário) <br /> Tel.: 021 3882-7223 / Cel.: 021
					99146-5036
				</p>
			</div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
	<br />
<?php include("rodape.php"); ?>
</body>
</html>