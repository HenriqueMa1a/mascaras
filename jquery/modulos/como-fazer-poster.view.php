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
include ("quadro_menu_vertical_OLD1.php");
?>
    <div id="posts" class="post">
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Como fazer - Pôster</h2>
			<div class="cleardiv"></div>
			<div class="description">
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;
					O pôster apresentado deverá ser inédito, não tendo sido apresentado
					em congresso anterior.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O tamanho do pôster deverá ser 90 cm X 120 cm (largura x altura) –
					formato retrato.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O pôster é um recurso visual. Por isso deverá ser confeccionado
					utilizando-se um tamanho de fonte que permita a leitura do conteúdo
					a alguma distância (2 metros, por exemplo).
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					As fontes do título poderão ser: Arial, Calibri, ou Avant Garde.
					Tamanho: a partir do 50.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Para o texto, é recomendável que a letra seja Times New Roman.
					Tamanho: 30.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O fundo do pôster se for branco, as letras poderão ser mais
					escuras.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O fundo colorido, propicia a letra branca para que o contraste seja
					maior.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					É recomendável nunca usar fotos ao fundo para não dificultar a
					leitura (marca-dágua).
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O texto do pôster deverá ser lido facilmente. Por essa razão, não é
					aconselhável colocar um texto corrido. As informações pontuais
					acerca da pesquisa relatada causam um impacto maior e se tornam
					mais atrativas para a leitura.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O pôster deverá ser organizado da seguinte maneira:<br />
					<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Título no topo<br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome e instituição do(s)
					autor(es) logo abaixo do título<br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A seguir: Introdução,
					objetivos, metodologia, resultados e conclusões
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Os apresentadores poderão fornecer aos participantes, cópias de
					tamanho reduzido do pôster que será apresentado, como um handout.
					Nesse caso, os apresentadores devem trazer suas cópias já prontas.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Cada participante aprovado irá receber um e-mail com a data para
					exposição do trabalho. (entre os dias 12, 13 e 14 de agosto.)
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					No horário previsto para visita aos pôsteres o apresentador e
					coautores deverão estar presentes para esclarecimentos.
				</p>
				<p class="p_text">
					<br /> <a href="controller.php?modulo=como-fazer-resumo">Como fazer
						Resumo?</a><br />
				</p>
			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>