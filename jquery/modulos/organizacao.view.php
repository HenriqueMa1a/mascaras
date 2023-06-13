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
			<h2>Quem Somos</h2>
			<table cellspacing="5" cellpadding="5" border="0">
				<tr>
					<td valign="top">
						<div class="description">
							<!-- <input type="image" src="images/comissao.jpg" /> -->
							<p class="p_text">
								<strong><u>Presidente de Honra</u></strong><br /> Paulo Ernani
								Gadelha Vieira<br />
								<br /> <strong><u>Coordenador Geral</u></strong><br /> Artur
								Roberto Couto<br />
								<br /> <strong><u>Coordenação Científica</u></strong><br />
								Akira Homma e Reinaldo Martins<br />
								<br /> <strong><u>Comissão Executiva</u></strong><br />
								Cristiane Frensch Pereira (Coordenação)<br /> Andrea Good Couto<br />
								Isabella Lira Figueiredo<br /> Maria de Lourdes Sousa Maia<br />
								Renata Ribeiro Gómez de Souza<br />
								<br /> <strong><u>Secretaria Executiva</u></strong><br /> Cassia
								Machado<br /> Patricia Pedroso Porto<br />
								<br />


							</p>
						</div>
						<br />

					</td>
					<td valign="top">
						<div class="description">
							<!-- <input type="image" src="images/comissao.jpg" /> -->
							<p class="p_text">
								<strong><u>Comissão Científica</u></strong><br /> Amílcar Tanuri<br />
								Antonio de Pádua Barbosa<br /> Antonio Gomes Pinto<br />
								Cristina de Albuquerque Possas<br /> Elaine Maria de Faria Teles<br />
								Elba Regina Sampaio de Lemos<br /> Elena Cristina Caride Campos<br />
								Elezer Monte Blanco<br /> Ellen Jessouroun<br /> José Antonio
								Pinto de Sá Ferreira<br /> José Godinho da Silva Junior<br />
								José Procópio Senna<br /> Marco Alberto Medeiros<br /> Marcos da
								Silva Freire<br /> Sheila Farage<br />
								<br /> <strong><u>Assessoria de Comunicação</u></strong><br />
								Renata Ribeiro (Coordenação)<br /> Alessandra Lopes<br />
								Bernardo Portella<br /> Danielle dos Santos<br /> Danielle
								Guedes<br /> Denyse Oliveira<br /> Gabriella Ponte<br /> Isabela
								Pimentel<br /> Lívia Maldonado<br /> Paulo Schueler<br />
								Rodrigo Pereira<br /> Talita Wodtke<br />
								<br /> <strong><u>Ditin</u></strong><br /> Marcelo Correa de
								Castro<br /> Rodolpho Silva de Paula<br />

							</p>
						</div>

					</td>
				</tr>

			</table>
			<div class="cleardiv"></div>
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>