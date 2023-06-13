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
			<h2>Critérios para aceitação de resumos</h2>
			<div class="description">
				<p class="p_text">Somente poderão ser apresentados os pôsteres se os
					resumos respectivos forem aprovados pela Comissão Científica. São
					critérios para aprovação dos resumos:</p>

				<div class="wrap-rounded_corners">
					<div class="top_corners">
						<div></div>
					</div>
					<p class="p_text">
						<input type="image" class="image_p" src="images/next.png" />&nbsp;<strong>Apenas
							para colaboradores de Bio-Manguinhos:</strong><br /> Aprovação
						prévia pelas seguintes instâncias: chefia imediata, gerente de
						departamento, vice-diretoria e NIT (Núcleo de Inovação
						Tecnológica). Esta aprovação deve ser feita antes dos trabalhos
						serem submetidos à Comissão Científica.

					</p>
					<div class="bottom_corners"></div>
				</div>
				<!-- /wrap-rounded_corners -->

				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;
					Atendimento dos requisitos e formatação exigidos para confecção dos
					resumos;


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
					A importância do trabalho para a saúde brasileira.



				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					As questões e dúvidas relativas à submissão de resumos e
					apresentação de pôsteres serão decididos pela Comissão Científica
					do Seminário, que procurará atender as solicitações de forma
					criteriosa.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					As decisões da Comissão Científica sobre aceitação dos resumos
					serão soberanas e irrecorríveis.

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