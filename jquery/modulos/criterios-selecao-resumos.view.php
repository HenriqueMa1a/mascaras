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
			<h2>Critérios - Seleção de Resumos</h2>
			<div class="description">
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />
					Somente poderão ser apresentados os pôsteres, se os resumos
					respectivos forem aprovados pela Comissão Cientifica.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					São critérios para aprovação dos resumos:
				</p>
				<p class="p_text_margin">
					<br /> I - Atendimento dos requisitos e formatação exigidos para
					confecção dos resumos ver <a
						href="controller.php?modulo=como-fazer">Como fazer Resumo?</a>.
				</p>
				<p class="p_text_margin">
					<br /> II - Que o trabalho seja inédito, que não tenha sido
					apresentado ou publicado, e tenha afinidade com os temas abordados
					no Seminário.
				</p>
				<p class="p_text_margin">
					<br /> III - A importância do trabalho para o desenvolvimento
					cientifico, tecnológico, produção, garantia da qualidade, gestão e
					regulação, na área de imunobiológicos.
				</p>
				<p class="p_text_margin">
					<br /> IV - A importância do trabalho para a saúde publica
					brasileira.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					As questões e duvidas relativas à submissão de resumos e
					apresentação de pôsteres serão decididas pela Comissão Cientifica
					do Seminário, que procurará atender as solicitações de forma
					criteriosa.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Os membros da Comissão Científica estarão impedidos de avaliarem
					seus próprios trabalhos.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />
					Se houver um numero de pôsteres aceitos acima da capacidade de
					apresentação e exposição, ainda sim, os mesmos serão publicados.
				</p>
				<p class="p_text">
					<br /> <a href="controller.php?modulo=criterios-inscricao">Inscrição
						no Seminário</a> &nbsp;&nbsp; <input type="image"
						src="images/next.png" /> &nbsp;&nbsp; <a
						href="controller.php?modulo=criterios-premiacao-posteres">Premiação
						dos Pôsteres</a><br />
				</p>
			</div>
			<div class="cleardiv"></div>
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>