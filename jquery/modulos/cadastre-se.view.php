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
<div id="page">
		<div id="corpo">
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<div id="loading">
				<p>
					<img src="images/loading.gif" alt="aguarde" /> Aguarde . . .
				</p>
			</div>
			<div class="mod_titulo">
				<img src="images/titulo_cadastre-se.png" alt="" border="0" />
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

			<div class="mod_meio"><?php  // echo "E[USO_ID=".$_SESSION['USO_ID']."] [USO_ID=$USO_ID] [MOD_CLASSE=".$_SESSION['MOD_CLASSE']."] [MOD_CLASSE=$MOD_CLASSE]<BR/>"; ?>
            <div class="demo">
					<div
						style="width: 870px; margin-bottom: 5px; float: left; border-right: 1px;"
						style="display: none;">
						<form id="formCadastro" name="formCadastro" action="action.php"
							onSubmit="return false;" style="float: left;">
							<input type="hidden" id="acao" name="acao" value="cadastre-se" />
							<input type="hidden" id="Cidade" name="Cidade" value="" /> <input
								type="hidden" id="IdPais" name="IdPais" value="31" />

							<table width="870" align="center" border="0" cellpadding="0"
								cellspacing="0" style="float: left;">
								<tr>
									<td width="140" class="label_cadastro" align="left"><b>Tipo:&nbsp;</b><span
										class="label_obrigatorio">*</span><br /> <select
										class="input_cadastro" id="IdTipoUsuario" name="IdTipoUsuario"
										style="width: 150px;">
											<option value="1" selected>Estudante</option>
											<option value="2">Professor</option>
											<option value="3">Responsável</option>
									</select></td>
									<td width="20">&nbsp;</td>
									<td rowspan="12" valign="top" align="center"></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td class="label_cadastro" align="left"><b>Nome Completo:&nbsp;</b><span
										class="label_obrigatorio">*</span><br /> <input
										class="input_cadastro" type="text" maxlength="50" value=""
										id="Nome" name="Nome" style="width: 300px;" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td class="label_cadastro" align="left"><b>Email:&nbsp;</b><span
										class="label_obrigatorio">*</span><br /> <input
										class="input_cadastro" type="text" maxlength="50" value=""
										id="Email" name="Email" style="width: 300px;" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td class="label_cadastro" align="left"><b>Estado:&nbsp;</b><span
										class="label_obrigatorio">*</span><br />
										<div id="combo_estado"></div></td>
								</tr>
								<tr>
									<td class="label_dica" colspan="2">Importante para que possamos
										prestar um serviço personalizado para você!</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td class="label_cadastro" align="left"><b>Senha:&nbsp;</b><span
										class="label_obrigatorio">*</span><br /> <input
										class="input_cadastro" type="password" maxlength="10" value=""
										id="Senha" name="Senha" style="width: 80px;" /> <span
										class="label_dica">Mínimo de 5 e máximo de 10 caracteres.</span>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td class="label_cadastro" align="left"><b>Confirmação de
											senha:&nbsp;</b><span class="label_obrigatorio">*</span><br />
										<input class="input_cadastro" type="password" maxlength="10"
										value="" id="ConfirmacaoSenha" name="ConfirmacaoSenha"
										style="width: 80px;" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td class="label_cadastro" align="left" colspan="3"><b>Atualizações:&nbsp;</b><span
										class="label_obrigatorio">*</span><br /> <input
										type="checkbox" id="Novidade" name="Novidade" value="1" /> <span
										class="label_dica">Marque o campo se deseja receber e-mail com
											as atualizações do Bio-Manguinhos</span></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td valign="top" align="center"><img class="botao_cadastro"
										id="bt_enviar" src="images/bt_peq_cadastrar.png"
										onClick="enviar();" alt="Clique para enviar seu cadastro." /></td>
								</tr>
							</table>
						</form>
					</div>
					<div id="barra_usuario"
						style="width: 860px; margin-top: 1px; float: left; padding-top: 10px; border-top: 1px solid #CCCCCC; display: none;">
					</div>

				</div>

			</div>
			<!-- MODULO CONTEUDO - FINAL *** //-->

		</div>
		<div style="clear: both;">&nbsp;</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>