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
			<h2>II Oficina - Apresentações</h2>
			<table cellpadding="15" cellspacing="15" border="0" width="100%">
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td width="10%" valign="top"><img
						src="images/presentation-icon.png" class="media-object" alt="" /><br />
					</td>
					<td><span class="p_text">09:20</span><br /> <strong><span
							class="p_text">Dr. Reinaldo de M. Martins<br />Dra. Cristina
								Possas
						</span></strong><br /> <a href="arquivos/oficinaReinaldo.pptx"
						style="text-decoration: none; color: #000000;">Como classificar e
							elaborar Resumo / Como fazer a apresentação oral de pôsteres </a></td>
					<td width="10%" valign="top"><img
						src="images/presentation-icon.png" class="media-object" alt="" /><br />
					</td>
					<td><span class="p_text">09:20</span><br /> <strong><span
							class="p_text">Carina Duim</span></strong><br /> <a
						href="arquivos/oficinaCarina.pptx"
						style="text-decoration: none; color: #000000;">Regras para a
							Elaboração de resumos </a></td>

				</tr>
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td width="10%" valign="top"><img
						src="images/presentation-icon.png" class="media-object" alt="" /><br />
					</td>
					<td><span class="p_text">10:30</span><br /> <strong><span
							class="p_text">Paulo Roberto dos Santos <br />Ricardo Creton
						</span></strong><br /> <a href="arquivos/Oficina_Ricardo.pdf"
						style="text-decoration: none; color: #000000;">Como elaborar
							pôster </a></td>
					<td width="10%" valign="top"><img
						src="images/presentation-icon.png" class="media-object" alt="" /><br />
					</td>
					<td><span class="p_text">13:30</span><br /> <strong><span
							class="p_text">Marcelo Castro</span></strong><br /> <a
						href="arquivos/OficinaMarcelo.ppt"
						style="text-decoration: none; color: #000000;">Como fazer
							inscrição e submeter resumo no hotsite</a></td>

				</tr>
				<tr
					style="border-bottom: solid 1px #f4f4f4; width: 95%; margin-bottom: 10px;">
					<td width="10%" valign="top"><img
						src="images/presentation-icon.png" class="media-object" alt="" /><br />
					</td>
					<td><span class="p_text">15:00</span><br /> <strong><span
							class="p_text">Cintia Reis <br />Katia dos Reis
						</span></strong><br /> <a href="arquivos/oficinaNIT.pptx"
						style="text-decoration: none; color: #000000;">Como validar o
							trabalho científico ( contratos e patentes) </a></td>
					<td width="10%" valign="top"><img
						src="images/presentation-icon.png" class="media-object" alt="" /><br />
					</td>
					<td><span class="p_text"></span><br /> <strong><span class="p_text">Ricardo
								Creton <br />Dra. Cristina Possas
						</span></strong><br /> <a
						href="arquivos/Officina_RicardoCristina.pdf"
						style="text-decoration: none; color: #000000;">Atitudes e Técnicas</a></td>

				</tr>
			</table>
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>