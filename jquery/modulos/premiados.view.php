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
<?php include("quadro_menu_vertical.php"); ?>
    <div id="posts" class="post">
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Premiados</h2>
			<div class="description">
				<p class="p_text" style="margin-left: 90px;">
					<img class="img_palestrante" src="images/foto-premiados.jpg" />
				</p>
				<p class="p_text">
					<b>1º lugar – Prêmio Oswaldo Cruz (R$ 10.000)</b> - Flavio Rocha da
					Silva – Tecnologista Sênior em Saúde Pública do Laboratório de
					Bioquímica, Proteínas e Peptídeos do IOC/Fiocruz. Estudo:
					“Bordetella pertussis: mapeamento e caracterização dos epítopos da
					toxina pertussis e pertactina”.<br />
					<br />
				</p>
				<p class="p_text">
					<b>2º lugar – Prêmio Carlos Chagas (R$ 6.000)</b> - Patricia
					Alvarez - Gerente de Projetos e Especialista em Saúde Pública -
					Lated/Bio-Manguinhos. Estudo: "Detecção de amostras em período de
					janela imunológica com kit NAT HIV/HCV Bio-Manguinhos, visando
					ampliar a segurança transfusional no Brasil”.<br />
					<br />
				</p>
				<br>
					<p class="p_text">
						<b>3º lugar – Prêmio Alcides Godoy (R$ 4.000)</b> - Katherine
						Antunes de Mattos - Tecnologista em Saúde - Bio-Manguinhos.
						Estudo: "Metabolômica aplicada na identificação de potenciais
						alvos de intervenção terapêutica nas doenças micobacterianas".<br />
						<br />
					</p> <br>
						<p class="p_text">
							<b>Jovem Talento até 26 anos de idade – Prêmio Evandro Chagas (R$
								3.000)</b> - Ingrid Pinheiro de Medeiros – Analista de Qualidade
							da Seção de Potência, do Laboratório de Controle Microbiológico,
							do Dequa/Bio-Manguinhos. Estudo: "Standardization and
							optimization of electrophoretic methods for the analysis of
							homogeneity and physicochemical characterization of recombinant
							human erythropoietin”.
						</p>
			
			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>