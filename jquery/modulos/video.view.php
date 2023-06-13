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
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9">
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
			<h2>Vídeos</h2>
			<div class="description">
				<p class="p_text">Confira todas os vídeos do II Sact:</p>
				</br>
				</br>

				<p class="p_text">
					<table cellpadding="10" cellspacing="5" border="0" width="100%">
						<tr>
							<td colspan="2"><b>Dia 28</b></td>

						</tr>
						<tr>
							<th>Abertura</th>
							<th>Trabalhos</th>
						</tr>
						<tr>
							<td style="background: #f2f2f2;"><video width="300" height="200"
									controls> <source src="videos/Dia_28_Abertura.mp4"
									type="video/mp4"></video></td>
							<td style="background: #f2f2f2;"><video width="300" height="200"
									controls> <source src="videos/Dia_28_Trabalhos.mp4"
									type="video/mp4"></video></td>

						</tr>
						<tr>
							<th>Polio EndGame</th>
							<th>Novas Fronteiras da Vacinologia</th>
						</tr>
						<tr>

							<td style="background: #f2f2f2;"><video width="300" height="200"
									controls> <source src="videos/Dia_28_02_Polio_EndGame.mp4"
									type="video/mp4"></video></td>
							<td style="background: #f2f2f2;"><video width="300" height="200"
									controls> <source
									src="videos/Dia_28_03_Novas_Fronteiras_da_Vacinologia.mp4"
									type="video/mp4"></video></td>

						</tr>
						<tr>
							<td colspan="2"><br />
							<b>Dia 29</b></td>

						</tr>
						<tr>
							<th>Trabalhos</th>
							<th>Desafios estratégias e perspectivas para as Parcerias para o
								Desenvolvimento Produtivo (Parte 01)</th>
						</tr>
						<tr>
							<td style="background: #f2f2f2;"><video width="300" height="200"
									controls> <source src="videos/Dia_29_Trabalhos.mp4"
									type="video/mp4"></video></td>
						</tr>
						<tr>
							<td style="background: #f2f2f2;"><video width="300" height="200"
									controls> <source
									src="videos/Dia_29_01_Desafios_estratégias_e_perspectivas_para_as_Parcerias_para_o_Desenvolvimento_Produtivo.mp4"
									type="video/mp4"></video></td>
						</tr>
						<tr>
							<th>Desenvolvimento tecnológico produção e suprimento de kits
								nacionais no Brasil (Parte 02)</th>
						</tr>
						<tr>
							<td style="background: #f2f2f2;"><video width="300" height="200"
									controls> <source
									src="videos/Dia_29_02_Desenvolvimento_tecnológico_produção_e_suprimento_de_kits_nacionais_no_Brasil.mp4"
									type="video/mp4"></video></td>
						</tr>


					</table>
				</p>
			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>