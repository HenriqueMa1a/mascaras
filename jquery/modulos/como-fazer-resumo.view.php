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
			<h2>Como fazer - Resumo</h2>
			<div class="cleardiv"></div>
			<div class="description">
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;
					O resumo deverá conter o padrão: <strong>Objetivo, Metodologia,
						Resultado e Conclusão.</strong>
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Não será aceito a entrega do resumo via fax, correio, e-mail ou
					carta.
					<!--O único modo para submeter o resumo 
							é clicando no menu <a href="controller.php?modulo=enviar-resumo">Enviar resumo</a>.  -->
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O título deverá conter até 20 palavras e ser digitado em caixa
					alta, (Times New Roman - tamanho 14) centralizado, descrevendo
					concisamente a essência do assunto.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O resumo é um texto de no máximo 450 palavras (sem contar título,
					autores e instituição).
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					A fonte do corpo do texto deverá ser Times New Roman tamanho 12.
					Cor da fonte: preto.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Usar espaçamento simples, margem de 2,5 cm à direita e esquerda e
					2,0 cm superior e inferior.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O resumo poderá ser digitado em Inglês ou Português.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O resumo NÃO poderá conter figuras, gráficos ou tabelas.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					A forma do resumo é retrato e não poderá ser paisagem.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Os nomes dos autores devem estar escritos por extenso em caixa
					baixa. (Ex: Jose de Souza Alves), instituição e texto do resumo.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O nome do autor principal deverá vir, em primeiro lugar e o nome do
					apresentador deverá estar sublinhado.
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					Autores: nome por extenso (inserir no máximo 7 autores), não
					colocar o título dos autores: Ex: Doutor, Professor....
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					O apresentador é o responsável por fazer a apresentação oral no dia
					do Seminário, caso seja selecionado. (plenária)
				</p>
				<!--
					<p class="p_text"><br />
					  <input type="image" class="image_p" src="images/next.png" />&nbsp;    
					  O nome do autor principal, em primeiro lugar e o nome do apresentador deverá vir sinalizado com um asterisco logo após. 
					  Fornecer o e-mail do apresentador para contato na ficha de inscrição.
					</p>
		-->
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />
					<a href="controller.php?modulo=modelo-resumo">Veja um modelo de
						Resumo</a><br />
				</p>
				<p class="p_text">
					<br /> <input type="image" class="image_p" src="images/next.png" />&nbsp;
					A instituição de ensino deverá ser mencionada após o nome do
					autor/apresentador através de um número. Logo em seguida, o numero
					deverá estar com o nome da instituição correspondente.
				</p>
				<p class="p_text">
					<br /> <a href="controller.php?modulo=como-fazer-poster">Como fazer
						Pôster?</a>
				</p>
			</div>
			<div class="cleardiv"></div>
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>