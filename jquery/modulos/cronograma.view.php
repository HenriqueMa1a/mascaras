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
			<h2>Cronograma</h2>
			<div class="description">
				<p class="p_text">
					<u>Inscrições com aprovação das chefias e NIT :</u> De 10 de
					fevereiro a 27 de abril<br /> <u>Submissão de resumos:</u> De 1º de
					março a 31 de março<br /> <u>Avaliação da Comissão Científica:</u>
					De 1º de abril a 15 de abril<br /> <u>Retorno aos autores para
						correção (ajustes, se necessário):</u> Dia 16 de abril<br /> <u>Devolução
						pelos autores dos trabalhos corrigidos:</u> De 17 de abril a 25 de
					abril<br /> <u>Comunicação aos autores a aceitação ou não de seus
						trabalhos:</u> De 28 de abril a 30 de abril<br /> <u>Seleção dos
						trabalhos que serão apresentados oralmente:</u> De 28 de abril a
					15 de maio<br /> <u>Comunicação aos autores que foram selecionados
						para a apresentação oral:</u> Dia 16 de maio<br />
				</p>

				<p class="p_text">
					<br />
					<br /> <a href="images/cronograma.jpg" rel="shadowbox"><img
						src="images/cronograma.jpg" height="100"
						style="cursor: pointer; border: solid 0px #000000;" /> </a>

				</p>

			</div>

			<!-- MODULO CONTEUDO - FINAL *** //-->
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
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br />
		<br /> <br />
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
<?php include("rodape.php"); ?>
</body>
</html>