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
			<h2>Considerações finais</h2>
			<div class="description">
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Caso
					o apresentador tenha algum impedimento para a apresentação oral na
					data previamente marcada pela Comissão Científica, ele deverá
					apontar seu substituto e as formas de contato, através de e-mail.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;Bio-Manguinhos
					não arcará com os custos das despesas do pôster. Esse gasto é de
					responsabilidade do(s) autor(es) do trabalho.

				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />
					A Comissão Científica informará ao autor do trabalho se o mesmo foi
					aceito, recusado ou está com pendências até o dia 16 de abril.

				</p>

				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;Para
					os resumos com pendência, a ressubmissão à Comissão Científica será
					entre os dias 17 e 27 de abril.

				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;A
					Comissão Científica irá receber todos os resumos e, através de uma
					seleção, indicará os 24 trabalhos que serão apresentados oralmente.

				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;Os
					trabalhos selecionados para apresentação oral deverão também ser
					colocados na exposição de pôsteres.

				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;Os
					prêmios aos melhores trabalhos serão decididos pela Comissão de
					Premiação Independente, conforme regulamento, e poderão incluir
					trabalhos não apresentados oralmente.

				</p>

			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>