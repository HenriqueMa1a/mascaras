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
	<?php //include("quadro_mensagem.php"); ?>
	<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Formato do evento</h2>
			<div class="description">
				<p class="p_text">O evento destaca apresentação de pôsteres e mesas
					redondas, com representantes da Fiocruz, do Ministério da Saúde e
					instituições de destaque no cenário biofarmacêutico, ao longo de
					três dias, como em 2013.</p>
				<p class="p_text">
					<br /> Para aumentar a participação, a Comissão Científica
					selecionará 24 pôsteres para apresentação oral – seis a mais dos
					que foram apresentados em 2013.
				</p>
				<p class="p_text">
					<br /> Uma Comissão de Premiação Independente selecionará os três
					melhores pôsteres para os prêmios Oswaldo Cruz (1º lugar); Carlos
					Chagas (2º lugar) e Alcides Godoy (3º lugar). Além desses, outros
					três prêmios são oferecidos para o melhor trabalho de Jovem Talento
					Científico (até 26 anos de idade): Prêmio Henrique de Azevedo
					Penna, Prêmio Evandro Chagas e Prêmio Sérgio  Arouca. Em 2013,
					apenas 1 trabalho foi premiado nesta categoria.
				</p>
				<p class="p_text">
					<br /> Os resumos de todos os trabalhos aprovados para exposição
					serão distribuídos na abertura do evento. As publicações não serão
					revisadas, sendo publicadas exatamente como apresentadas na página
					do seminário. O primeiro autor é o responsável legal por todo o seu
					conteúdo (incluindo dados da pesquisa, nomes e instituições dos
					autores e demais informações). A comissão científica entenderá  que
					os demais participantes (coautores) concordam com o mesmo.
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