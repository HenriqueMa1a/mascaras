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
<div id="content">
<?php include("quadro_menu_vertical.php"); ?>
    <div id="posts" class="post">
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<a name="a_titulo" /> <a name="PAG_TOPO" />
			<div id="loading">
				<p>
					<img src="images/loading.gif" alt="aguarde" /> Aguarde . . .
				</p>
			</div>
			<div id="resultado" style="display: none;"></div>
			<div id="msg_quadro" class="msg_quadro" style="display: none;">
				<img id="msg_icone" class="msg_icone" src="images/i_alerta.png"
					alt="Aviso" />&nbsp; <span id="msg_texto" class="msg_texto">Mensagem
					de Alerta</span> <img id="msg_botao" class="msg_botao"
					src="images/i_fechar.png" title="Fechar mensagem"
					alt="Fechar mensagem" onclick="ocultarMensagem();" />
			</div>

			<h2>Minha Inscrição</h2>

			<!-- Pacotes - INICIO -->
			<div id="bloco_inscricao">
				<table align="center" border="0" cellpadding="0" cellspacing="7">
					<tr>
						<td align="left" valign="top" colspan="3">
							<table cellpadding="0" cellspacing="3" border="0">
								<tr>
									<td align="left" valign="middle" width="35"><img
										src="images/i_ficha.png" alt="Minha Inscrição"
										class="botao_cadastro" /></td>
									<td align="left" valign="middle" width="400"><span
										class="label_subtitulo">Minha Inscrição</span><a
										name="MINHA_PAGINA" /></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td width="100"><img src="images/pixel.gif" alt="" /></td>
						<td width="100"><img src="images/pixel.gif" alt="" /></td>
						<td width="100"><img src="images/pixel.gif" alt="" /></td>
						<td width="100"><img src="images/pixel.gif" alt="" /></td>
						<td width="100"><img src="images/pixel.gif" alt="" /></td>
						<td width="100"><img src="images/pixel.gif" alt="" /></td>
					</tr>
					<tr>
						<td align="left" valign="top" colspan="3"><span
							class="label_campo">Nome:</span><br /> <span class="label_valor"
							id="label_Nome">&nbsp;</span></td>
						<td align="left" valign="top"><span class="label_campo">Nascimento:</span><br />
							<span class="label_valor" id="label_DataNascimento">&nbsp;</span>
						</td>
						<td align="left" valign="top" colspan="2"><span
							class="label_campo">Participação:</span><br /> <span
							class="label_valor" id="label_TipoUsuario">&nbsp;</span></td>
					</tr>
					<tr>
						<td align="left" valign="top" colspan="3"><span
							class="label_campo">Email:</span><br /> <span class="label_valor"
							id="label_Email">&nbsp;</span></td>
						<td align="left" valign="top" colspan="3"><span
							class="label_campo">Telefone:</span><br /> <span
							class="label_valor" id="label_Telefone">&nbsp;</span></td>
					</tr>
					<tr id="TR_COLABORADOR">
						<td align="left" valign="top"><span class="label_campo">Colaborador:</span><br />
							<span class="label_valor" id="label_Colaborador">Sim</span></td>
						<td align="left" valign="top"><span class="label_campo">ViceDiretoria:</span><br />
							<span class="label_valor" id="label_ViceDiretoria">&nbsp;</span>
						</td>
						<td align="left" valign="top"><span class="label_campo">Departamento:</span><br />
							<span class="label_valor" id="label_Departamento">&nbsp;</span></td>
						<td align="left" valign="top"><span class="label_campo">Divisao:</span><br />
							<span class="label_valor" id="label_Divisao">&nbsp;</span></td>
						<td align="left" valign="top"><span class="label_campo">Secao:</span><br />
							<span class="label_valor" id="label_Secao">&nbsp;</span></td>
					</tr>
					<tr id="TR_EXTERNO">
						<td align="left" valign="top" colspan="3"><span
							class="label_campo">Unidade Externa:</span><br /> <span
							class="label_valor" id="label_UnidadeExterna">&nbsp;</span></td>
						<td align="left" valign="top" colspan="3"><span
							class="label_campo">Formacao Academica:</span><br /> <span
							class="label_valor" id="label_FormacaoAcademica">&nbsp;</span></td>
					</tr>
					<tr>
						<td align="left" valign="top" colspan="2"><span
							class="label_campo">Area Atuação:</span><br /> <span
							class="label_valor" id="label_AreaAtuacao">&nbsp;</span></td>
						<td align="left" valign="top" colspan="2"><span
							class="label_campo">Status:</span><br /> <img class="img_icone"
							id="img_Status" src="images/espaco.gif" /><span
							class="label_valor" id="label_StatusUsuario">&nbsp;</span></td>
						<td align="left" valign="top" colspan="2"><span
							class="label_campo">Data Inscrição:&nbsp;</span><br /> <span
							class="label_valor" id="label_DataInclusao">0</span></td>
					</tr>
					<tr>
						<td align="left" valign="top" colspan="5"><span
							class="label_campo">Canal de Comunicação:</span><br /> <span
							class="label_valor" id="label_FlagAscom"><img class="img_icone"
								id="FlagAscom" src="images/checkbox_0.gif" />ASCOM&nbsp;&nbsp;</span>
							<span class="label_valor" id="label_FlagIndicacao"><img
								class="img_icone" id="FlagIndicacao" src="images/checkbox_0.gif" />Indicação&nbsp;&nbsp;</span>
							<span class="label_valor" id="label_FlagBioMural"><img
								class="img_icone" id="FlagBioMural" src="images/checkbox_0.gif" />BioMural&nbsp;&nbsp;</span>
							<span class="label_valor" id="label_FlagBioDigital"><img
								class="img_icone" id="FlagBioDigital"
								src="images/checkbox_0.gif" />BioDigital&nbsp;&nbsp;</span> <span
							class="label_valor" id="label_FlagWebTV"><img class="img_icone"
								id="FlagWebTV" src="images/checkbox_0.gif" />WebTV&nbsp;&nbsp;</span>
							<span class="label_valor" id="label_FlagCartazes"><img
								class="img_icone" id="FlagCartazes" src="images/checkbox_0.gif" />Cartazes&nbsp;&nbsp;</span>
							<span class="label_valor" id="label_FlagOutros"><img
								class="img_icone" id="FlagOutros" src="images/checkbox_0.gif" />Outros&nbsp;&nbsp;</span>
						</td>
						<td align="left" valign="top"><span class="label_campo">Enviar
								Resumo?</span><br /> <span class="label_valor"
							id="label_FlagResumo">&nbsp;</span></td>
					</tr>
				</table>
				<br />
			</div>
			<div>
				<form id="formCadastro" name="formCadastro" action="action.php"
					onSubmit="return false;">
					<input type="hidden" id="acao" name="acao" value="criar-resumo" />
					<input type="hidden" id="IdUsuario" name="IdUsuario" value="" /> <input
						type="hidden" id="IdConteudo" name="IdConteudo" value="" />
				</form>
			</div>

			<div class="cleardiv"></div>
			<div class="cleardiv"></div>
			<div class="cleardiv"></div>
			<!-- Pacotes - FINAL -->
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>