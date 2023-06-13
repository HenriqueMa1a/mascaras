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
			<h2>Premiação de 2013</h2>
			<div class="description">
				<div class="wrap-rounded_corners">
					<div class="top_corners">
						<div></div>
					</div>
					<p class="p_text">
						Em 2013, o prêmio Oswaldo Cruz (1º lugar) foi conquistado por
						Flavio Rocha da Silva, do Laboratório de Bioquímica, Proteínas e
						Peptídeos do IOC/Fiocruz, que apresentou o estudo <strong>“Bordetella
							pertussis: mapeamento e caracterização dos epítopos da
							toxina pertussis e pertactina”. </strong> <br />
						<br />
					</p>
					<p class="p_text">
						<br />
					</p>
					<p class="p_text">
						A gerente do projeto KIT NAT HIV/HCV de Bio-Manguinhos, Patrícia
						Alvarez, ficou em 2º lugar (Prêmio Carlos Chagas) com o resumo <strong>
							"Detecção de amostras em período de janela imunológica com kit
							NAT HIV/HCV: Bio-Manguinhos, visando ampliar a segurança
							transfusional no Brasil”.</strong> Katherine de Mattos,
						tecnologista em saúde de Bio-Manguinhos, ganhou a 3º posição
						(Prêmio Alcides Godoy), com o trabalho <strong>“Metabolômica
							aplicada na identificação de potenciais alvos de intervenção
							terapêutica nas doenças micobacterianas"</strong>. <br />
						<br />
					</p>
					<p class="p_text">
						<br />
					</p>

					<p class="p_text">
						O Prêmio Evandro Chagas foi concedido a Ingrid Pinheiro, jovem
						talento que trabalha na Seção de Potência do Laboratório de
						Controle Microbiológico de Bio-Manguinhos. Ingrid apresentou o
						trabalho <strong>"Standardization and optimization of
							electrophoretic methods for the analysis of homogeneity and
							physicochemical characterization of recombinant human
							erythropoietin”</strong>.
					</p>
					<div class="bottom_corners"></div>
				</div>

				<p class="p_text">
					<a href="controller.php?modulo=premiacao" style="color: #000000;">Os
						vencedores de 2014</a>
				</p>
				<br />
				<br />

				<!--  <p class="p_text"><strong><span style="letter-spacing: 0.1em;font-size:13px;"> Os vencedores de 2014 ganharão:</span></strong><br/> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="image" class="image_p" src="images/next.png" />&nbsp;Prêmio Oswaldo Cruz (1º lugar); <br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="image" class="image_p" src="images/next.png" />&nbsp;Carlos Chagas (2º lugar); <br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="image" class="image_p" src="images/next.png" />&nbsp;Alcides Godoy (3º lugar).
					
			</p>
			 </div>
			 <div class="cleardiv"></div>
			<div class="description">
			<p class="p_text">Os melhores trabalhos de Jovem Talento Científico (até 26 anos de idade) receberão: <br/> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="image" class="image_p" src="images/next.png" />&nbsp;Prêmio Henrique de Azevedo Penna; <br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="image" class="image_p" src="images/next.png" />&nbsp;Prêmio Evandro Chagas; <br />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="image" class="image_p" src="images/next.png" />&nbsp;Prêmio Sérgio Arouca.
			</p> 
			<p class="p_text"><br/></p>
			<p class="p_text"><i style="font-size:11px;">*O Jovem Talento deverá ser o primeiro autor do trabalho para fazer jus ao prêmio.</i></p>   
			</div>-->
				<div class="cleardiv"></div>
				<!-- MODULO CONTEUDO - FINAL *** //-->
			</div>
		</div>
<?php include("rodape.php"); ?>


</body>
</html>