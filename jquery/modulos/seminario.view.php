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
			<h2>O Seminário</h2>
			<div class="description">
				<p class="p_text">O formato do evento destacará apresentação de
					pôsteres e mesas redondas, com representantes da Fiocruz, do
					Ministério da Saúde e instituições de destaque no cenário
					biofarmacêutico, durante os três dias.</p>
				<p class="p_text">
					<br /> Um grupo de pôsteres será selecionado pela Comissão
					Científica para apresentação oral. Ao todo, 24 pôsteres serão
					escolhidos e apresentados ao longo do seminário.
				</p>
				<p class="p_text">
					<br /> Os três melhores pôsteres, selecionados por uma Comissão de
					Premiação Independente, concorrerão aos Prêmios Oswaldo Cruz (1º
					lugar); Carlos Chagas (2º lugar); e Alcides Godoy (3º lugar). Além
					desses, três prêmios serão oferecidos para o melhor trabalho de
					Jovem Talento Científico (até 26 anos de idade): Prêmio Henrique de
					Azevedo Penna, Prêmio Evandro Chagas e Prêmio Sérgio Arouca.
				</p>
				<p class="p_text">
					<br /> Os resumos de todos os trabalhos aprovados para serem
					expostos no seminário serão distribuídos na abertura do evento. As
					publicações não serão revisadas, sendo publicadas exatamente como
					apresentadas na página do seminário. O primeiro autor é o
					responsável legal por todo o seu conteúdo (incluindo dados da
					pesquisa, nomes e instituições dos autores e demais informações). A
					Comissão Científica entenderá que os demais participantes
					(coautores) concordam com o mesmo.

				</p>
				<p class="p_text">
					<br /> Os autores dos trabalhos aprovados e apresentados receberão
					certificados de apresentação no seminário.
				</p>

			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>