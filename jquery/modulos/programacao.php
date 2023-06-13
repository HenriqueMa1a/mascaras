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
			<h2>Programação - dia 12</h2>
			<div class="description">
				<!--  <input type="image" style="margin-left:27px;" src="images/programacao12.png" />

             <p class="p_text"><br />		
                     &nbsp;&nbsp;&nbsp;&nbsp;<a href="controller.php?modulo=programacao13-08-2013">13/08</a>
                     &nbsp;
                     <input type="image" src="images/next.png" />
                     &nbsp;
                     <a href="controller.php?modulo=programacao14-08-2013">14/08</a>
                     &nbsp;
             </p >-->

				<p class="p_text">Conteúdo em Revisão!</p>
			</div>
			<div class="cleardiv"></div>
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>