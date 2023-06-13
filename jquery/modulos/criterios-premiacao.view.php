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
			<h2>Critérios para premiação dos pôsteres</h2>
			<div class="description">
				<p class="p_text">Haverá uma Comissão de Premiação Independente,
					composta por pesquisadores de reconhecida excelência, não vinculada
					à Fiocruz, que avaliará os pôsteres para premiação.</p>
				<p class="p_text">
					<br /> Todos os pôsteres apresentados são candidatos à premiação,
					independentemente de sua seleção para apresentação oral. <br />São
					critérios para a premiação:
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Que a pesquisa tenha sido desenvolvida em território nacional;
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					A qualidade do resumo e do pôster apresentado;
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Que o trabalho não tenha sido públicado em revista ou anais de
					congresso e tenha afinidade com os temas abordados no Seminário;
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					A importância do trabalho para o desenvolvimento científico,
					tecnológico, produção, garantia da qualidade, gestão e regulação,
					na área de imunobiológicos;

				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					A importância do trabalho para a saúde pública brasileira.

				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					As decisões da Comissão de Premiação Independente serão soberanas e
					irrecorríveis.

				</p>

				<!--   <p class="p_text"><br />
			<a href="controller.php?modulo=criterios-selecao-resumos">Seleção de Resumos</a>
			&nbsp;&nbsp;
			<input type="image" src="images/next.png" />
			&nbsp;&nbsp;   
			<a href="controller.php?modulo=criterios-premiacao-posteres">Premiação dos Pôsteres</a><br />
		 </p >-->
			</div>
			<div class="cleardiv"></div>
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>