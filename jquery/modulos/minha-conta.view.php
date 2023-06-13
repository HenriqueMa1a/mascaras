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
<body onload="inicializar();">
<?php include("cabecalho.php"); ?>
<div id="page">
		<div id="corpo">
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<div id="loading">
				<p>
					<img src="images/loading.gif" alt="aguarde" /> Aguarde . . .
				</p>
			</div>
			<div class="mod_titulo">
				<a name="a_titulo" /> <img src="images/titulo_minha_conta.png"
					alt="" border="0" />
			</div>
			<div id="resultado" style="display: none;"></div>
			<div id="msg_quadro" class="msg_quadro" style="display: none;">
				<img id="msg_icone" class="msg_icone" src="images/i_alerta.png"
					alt="Aviso" />&nbsp; <span id="msg_texto" class="msg_texto">Menssagem
					de Alerta</span> <img id="msg_botao" class="msg_botao"
					src="images/i_fechar.png" title="Fechar mensagem"
					alt="Fechar mensagem" onclick="ocultarMensagem();" />
			</div>
			<div id="popup_confirmacao" title="Confirmação de Exclusão?"
				style="display: none;">
				<br />
				<p>Tem certeza que deseja excluir o registro?</p>
			</div>

			<div class="mod_meio">
				<div class="demo">
				<?php include("bloco_minha_conta.php"); ?>
				<!-- Pacotes - INICIO -->
					<div id="bloco_dados_conta" style="">
						<div
							style="float: left; width: 165px; border-right: 1px solid #CCCCCC;">
							<table cellpadding="3" cellspacing="0" border="0">
								<tr>
									<td align="left" valign="middle"><img
										src="images/i_credito.png" alt="Meus Créditos"
										class="botao_cadastro" onclick="pesquisar_creditos();" /></td>
									<td align="left" valign="middle"><b>Meus Créditos</b></td>
								</tr>
								<tr>
									<td align="left" valign="middle">&nbsp;</td>
									<td align="left" valign="middle">&nbsp;</td>
								</tr>
								<tr>
									<td align="left" valign="middle">&nbsp;</td>
									<td align="left" valign="middle">&nbsp;<br />
									<br />
									<br />
									<br />
									<br />
									<br />
									<br />
									<br />
									<br />
									<br /></td>
								</tr>
							</table>
							<br />
							<br />
						</div>
						<div style="float: left; width: 780px; margin-left: 10px;">

							<div id="div_creditos"
								style="background: #D0DAE3; display: none;">
								<table cellpadding="5" cellspacing="0" border="0">
									<tr>
										<td align="left"><img src="images/i_credito.png"
											alt="Meus Créditos" /></td>
										<td class="label_desempenho" align="left"><b>Créditos
												ativos&nbsp;</b></td>
										<td class="label_desempenho" align="left">&nbsp;</td>
									</tr>
								</table>
								<table id="tab_creditos" style="margin: 10px;" cellpadding="2"
									cellspacing="0" border="0">
									<thead>
										<tr>
											<th class="label_desempenho" colspan="5" align="left"
												style="border-top: 1px solid #000000;"><img
												src="images/pixel.gif" width="1" height="1" alt="" /></th>
										</tr>
										<tr>
											<th class="label_desempenho" align="left" width="300">&nbsp;<b>Pacote</b></th>
											<th class="label_desempenho" align="center" width="60"
												style="border-left: 1px solid #000000;"><b>Quant.</b></th>
											<th class="label_desempenho" align="center" width="60"
												style="border-left: 1px solid #000000;"><b>Saldo</b></th>
											<th class="label_desempenho" align="center" width="160"
												style="border-left: 1px solid #000000;"><b>Validade</b></th>
										</tr>
										<tr>
											<th class="label_desempenho" colspan="5" align="left"
												style="border-bottom: 1px solid #000000;"><img
												src="images/pixel.gif" width="1" height="1" alt="" /></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
								<br />
							</div>


							<!-- Pacotes - FINAL -->
						</div>

					</div>
					<!-- MODULO CONTEUDO - FINAL *** //-->

				</div>
				<div style="clear: both;">&nbsp;</div>
			</div>
<?php include("rodape.php"); ?>


</body>
</html>