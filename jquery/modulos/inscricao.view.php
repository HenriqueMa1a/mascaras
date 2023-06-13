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
	

<?php //include("cabecalho.php"); ?>
<!--   <div id="content">-->
<?php

// include("quadro_menu_vertical.php");
// include("quadro_menu_vertical.php");
?>
   <!--   <div id="posts" class="post">-->
	<!-- MODULO CONTEUDO - INICIO *** //-->
	<a name="PAG_TOPO"> </a>
	<div id="loading">
		<p>
			<img src="images/loading.gif" alt="aguarde" /> Aguarde . . .
		</p>
	</div>
	<div id="resultado" style="display: none;"></div>
	<div id="msg_quadro" class="msg_quadro" style="display: none;">
		<img id="msg_icone" class="msg_icone" src="images/i_alerta.png"
			alt="Aviso" />&nbsp; <span id="msg_texto" class="msg_texto">Menssagem
			de Alerta</span> <img id="msg_botao" class="msg_botao"
			src="images/i_fechar.png" title="Fechar mensagem"
			alt="Fechar mensagem" onclick="ocultarMensagem();" />
	</div>
		<?php  // echo "E[USO_ID=".$_SESSION['USO_ID']."] [USO_ID=$USO_ID] [MOD_CLASSE=".$_SESSION['MOD_CLASSE']."] [MOD_CLASSE=$MOD_CLASSE]<BR/>"; ?>

		<!--   <h2>Ficha de Inscrição</h2>-->

	<form id="formCadastro" name="formCadastro" action="action.php"
		onSubmit="return false;" style="float: left;">
		<p align="right">
			<a id="btn_login" href="controller.php?modulo=login"
				alt="Alterar Ficha"><img src='images/bt_alterar_ficha_cadastro.png' border='0'/></a>
		</p>


		<input type="hidden" id="acao" name="acao" value="<?php if($USO_ID != 0){echo 'alterar';}else{echo 'cadastre-se';} ?>" /><input
			type="hidden" id="IdUsuario" name="IdUsuario" value="0" /> <input
			type="hidden" id="IdPais" name="IdPais" value="31" /> <input
			type="hidden" id="IdEstado" name="IdEstado" value="19" /> <input
			type="hidden" id="Cidade" name="Cidade" value="" /> <input
			type="hidden" id="Novidade" name="Novidade" value="0" />

		<div class="divForm">
			<div class="cleardiv"></div>
			<!-- 
			<label class="form_label">Você é?</label><span
				class="label_obrigatorio">&nbsp;*</span> <br />
			<div class="panel-body">
				<input type="radio" name="IdTipoUsuario" id="IdTipoUsuario1"
					value="1" />&nbsp;Palestrante&nbsp;&nbsp; <input type="radio"
					name="IdTipoUsuario" id="IdTipoUsuario2" value="2" />&nbsp;Apresentador
				de pôster&nbsp;&nbsp; <input type="radio" name="IdTipoUsuario"
					id="IdTipoUsuario3" value="3" />&nbsp;Co-autor&nbsp;&nbsp; <input
					type="radio" name="IdTipoUsuario" id="IdTipoUsuario4" value="4" />&nbsp;Convidado&nbsp;&nbsp;
				<input type="radio" name="IdTipoUsuario" id="IdTipoUsuario5"
					value="5" />&nbsp;Participante
			</div> 
			<br /> <br />  --><label class="form_label">Nome completo: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="text"
				id="Nome" name="Nome" class="form_input" maxlength="100"
				style="width: 300px;" /> <span class="label_dica">&nbsp;(Informar
				nome completo)</span>
			<div class="cleardiv"></div>
			<br /> 
			<label class="form_label">Nome para crachá: </label> <br /> <input
				type="text" name="NomeCracha" id="NomeCracha" maxlength="100"
				class="form_input" style="width: 300px;" /> <span class="label_dica">&nbsp;(Informar
				nome para ser inserido no crachá completo)</span>
			<div class="cleardiv"></div>
			<br />	<label class="form_label">E-mail: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="text"
				id="Email" name="Email" class="form_input" maxlength="100"
				style="width: 300px;" />
			<div class="cleardiv"></div>
			<br />	<label class="form_label">Confirmação de e-mail: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="text"
				id="ConfirmaEmail" name="ConfirmaEmail" class="form_input" maxlength="100"
				style="width: 300px;" />
			<div class="cleardiv"></div>
			<br /> <label class="form_label">Data de Nascimento:</label><span
				class="label_obrigatorio">&nbsp;*</span> <br /> <input type="text"
				id="DataNascimento" name="DataNascimento" class="form_input_data"
				style="width: 100px;" readonly="readonly" /> <span
				class="label_dica">&nbsp;(até 26 anos para concorrer ao Prêmio Jovem
				Talento)</span>
			<div class="cleardiv"></div>
			<br /> <!-- <label class="form_label">Área de Atuação:</label> <br /> <input
				type="text" id="AreaAtuacao" name="AreaAtuacao" maxlength="100"
				class="form_input" />
			<div class="cleardiv"></div>
			<br /> <label class="form_label">Indique o canal de comunicação pelo
				qual tomou conhecimento do evento: </label><span
				class="label_obrigatorio">*</span> <br /> <br />
			&nbsp;&nbsp;&nbsp;&nbsp; <input type="checkbox" id="FlagAscom"
				name="FlagAscom" value="1" />&nbsp;ASCOM comunica&nbsp;&nbsp <input
				type="checkbox" id="FlagIndicacao" name="FlagIndicacao" value="2" />Indicação&nbsp;&nbsp;
			<input type="checkbox" id="FlagBioMural" name="FlagBioMural"
				value="4" />&nbsp;BioMural&nbsp;&nbsp <input type="checkbox"
				id="FlagBioDigital" name="FlagBioDigital" value="8" />&nbsp;BioDigital&nbsp;&nbsp
			<input type="checkbox" id="FlagWebTV" name="FlagWebTV" value="16" />&nbsp;WebTV&nbsp;&nbsp;
			<input type="checkbox" id="FlagCartazes" name="FlagCartazes"
				value="32" />&nbsp;Cartazes&nbsp;&nbsp; <input type="checkbox"
				id="FlagOutros" name="FlagOutros" value="64" />&nbsp;Outros

			<div class="cleardiv"></div>
			<br /> --> <label class="form_label">Telefone: </label> <br /> <input
				type="text" name="Telefone" id="Telefone" maxlength="100"
				class="form_input" style="width: 300px;" />
			<div class="cleardiv"></div>
			<br />
			<label class="form_label">Outro telefone: </label> <br /> <input
				type="text" name="OutroTelefone" id="OutroTelefone" maxlength="100"
				class="form_input" style="width: 300px;" />
			<div class="cleardiv"></div>
			<br /> <label class="form_label">CEP: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="text"
				class="form_input" id="Cep" name="Cep" maxlength="9"
				style="width: 140px;" /> <span class="label_dica">&nbsp;(CEP de onde reside)</span>
			<div class="cleardiv"></div>
			<br /> <label class="form_label">Rua: </label> <br /> 
				<input type="text" class="form_input" id="Rua" name="Rua" 
				maxlength="100"	style="width: 300px;" /> 
				<span class="label_dica">&nbsp;(Nome da rua aonde reside)</span>
			<div class="cleardiv"></div>
			<br /> <label class="form_label">Complemento: </label> <br /> 
				<input type="text" class="form_input" id="Complemento" name="Complemento" 
				maxlength="10"	style="width: 140px;" /> 
				<span class="label_dica">&nbsp;(Complemento do endereço aonde reside)</span>
			<div class="cleardiv"></div>
			<br /> <label class="form_label">Bairro: </label> <br /> 
				<input type="text" class="form_input" id="Bairro" name="Bairro" 
				maxlength="100"	style="width: 300px;" /> 
				<span class="label_dica">&nbsp;(Bairro aonde reside)</span>
			<div class="cleardiv"></div>
			<br /> <label class="form_label">Cidade: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="text"
				class="form_input" id="Cidade" name="Cidade" maxlength="100"
				style="width: 300px;" /> <span class="label_dica">&nbsp;(Cidade aonde reside)</span>
			<div class="cleardiv"></div>
			<br /> <label class="form_label">Estado: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="text"
				class="form_input" id="Estado" name="Estado" maxlength="2"
				style="width: 140px;" /> <span class="label_dica">&nbsp;(Estado aonde reside)</span>
			<div class="cleardiv"></div>
			<br /> <label class="form_label">País: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="text"
				class="form_input" id="Pais" name="Pais" maxlength="100"
				style="width: 300px;" /> <span class="label_dica">&nbsp;(País aonde reside)</span>
			<div class="cleardiv"></div>
			<br />
			
			
			<label class="form_label">Senha: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="password"
				class="form_input" value="" id="Senha" name="Senha" maxlength="10"
				style="width: 140px;" /> <span class="label_dica">&nbsp;(Mínimo de 5
				caracteres alfa-numérico)</span>
			<div class="cleardiv"></div>
			<br /> <label class="form_label">Confirmação da Senha: </label><span
				class="label_obrigatorio">*</span> <br /> <input type="password"
				class="form_input" value="" id="ConfirmacaoSenha"
				name="ConfirmacaoSenha" maxlength="10" style="width: 140px;" /> <span
				class="label_dica">&nbsp;(Mínimo de 5 caracteres alfa-numérico)</span>
			<div class="cleardiv"></div>
			<br />	<label class="form_label">Você é um colaborador de
				Bio-Manguinhos? </label><span class="label_obrigatorio">*</span> <br />
			<br />&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"
				id="FlagColaborador1" name="FlagColaborador" value="1"
				onclick="javascript:TipoColaborador();" />&nbsp;Sim
			&nbsp;&nbsp;&nbsp; <input type="radio" id="FlagColaborador0"
				name="FlagColaborador" value="0"
				onclick="javascript:TipoColaborador();" />&nbsp;Não <br />

			<div id="DivColaboradorBio" style="display: none;">
				<table width="100%" cellpadding="5" cellspacing="10" border="0">
					<tr>
						<td valign="top" width="70%"><label class="form_label">Vice-diretoria
								/ Assessoria: </label> </label><span class="label_obrigatorio">*</span>
							<br /> <input type="text" id="ViceDiretoria" name="ViceDiretoria"
							maxlength="100" class="form_input" style="width: 80px;" />
							<div class="cleardiv"></div> <br /> <label class="form_label">Departamento:</label>
							<br /> <input type="text" id="Departamento" name="Departamento"
							maxlength="100" class="form_input" style="width: 80px;" />
							<div class="cleardiv"></div> <br /> <label class="form_label">Divisão
								/ Laboratório:</label> <br /> <input type="text" id="Divisao"
							name="Divisao" maxlength="100" class="form_input"
							style="width: 80px;" />
							<div class="cleardiv"></div> <br /> <label class="form_label">Seção:</label>
							<br /> <input type="text" id="Secao" name="Secao" maxlength="100"
							class="form_input" style="width: 80px;" /></td>
						<td valign="top" width="30%"><label class="form_label"><strong>
									Autorizado por:</strong></label><span class="label_obrigatorio">*</span><br />
							<br /> <select id="autorizadoPor" name="autorizadoPor"
							class="form_input"
							onchange="exibeInputResponsavel(this.options[this.selectedIndex].value);"
							style="width: 300px;">
								<option value="">Selecione...</option>
								<option value="1">Chefia imediata</option>
								<option value="2">Gerente de departamento</option>
								<option value="3">Vice- Diretoria</option>
						</select> <br /> <br /> <br />
							<div id="DivchefiaImediata" style="display: none;">
								<label class='form_label' for='total'>Nome (Chefia imediata):</label><span
									class='label_obrigatorio'>*</span><br /> <input type='text'
									id='chefiaImediata' name='chefiaImediata' maxlength='100'
									class='form_input' style='width: 170px;' />
							</div>
							<div id="DivgerenteDep" style="display: none;">
								<label class='form_label' for='total'>Nome (Gerente de
									departamento):</label><span class='label_obrigatorio'>*</span><br />
								<input type='text' id='gerenteDep' name='gerenteDep'
									maxlength='100' class='form_input' style='width: 170px;' />
							</div>
							<div id="DivviceDir" style="display: none;">
								<label class='form_label' for='total'>Nome (Vice- Diretoria):</label><span
									class='label_obrigatorio'>*</span><br /> <input type='text'
									id='viceDir' name='viceDir' maxlength='100' class='form_input'
									style='width: 170px;' />
							</div></td>
					</tr>
				</table>
				<div class="cleardiv"></div>
			</div>

			<div id="DivColaboradorExterno" style="display: none;">
				<br /> <label class="form_label">Indique sua Instituição / Unidade:</label>
				<br /> <input type="text" id="UnidadeExterna" name="UnidadeExterna"
					maxlength="100" class="form_input" />
				<div class="cleardiv"></div>
				<br /> <label class="form_label">Formação acadêmica / Titulação:</label>
				<br /> <input type="text" id="FormacaoAcademica"
					name="FormacaoAcademica" maxlength="100" class="form_input" />
				<div class="cleardiv"></div>
				<br />
			</div>

			<br /> <label class="form_label">Deseja submeter um resumo? </label><span
				class="label_obrigatorio">*</span> <br /> <br />
			&nbsp;&nbsp;&nbsp;&nbsp;
			 <input type="radio" name="FlagResumo" id="FlagResumo1"	value="1" />&nbsp;Sim &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio"	name="FlagResumo" id="FlagResumo0" value="0" />&nbsp;Não <br /> <br />

			<div id="DivResumo" style="display: none;">
				<div class="cleardiv"></div>
				<br />
			</div>
			<img class="botao_cadastro" id="bt_enviar"
				src="images/bt_peq_cadastrar_novo.png" onClick="enviar();"
				alt="Envio da inscrição/Resumo" /> <img class="botao_cadastro"
				id="bt_alterar" src="images/bt_peq_alterar.png" onClick="enviar();"
				alt="Envio da inscrição/Resumo" style="display: none;" />
				
				<a href="acesso.controller.php?acao=sair"><img id="bt_cancelar" src="images/bt_peq_cancelar.png" border="0" alt="Sair do Sistema" style="display:none;"></a>

			<div class="cleardiv"></div>
			<div class="cleardiv"></div>
			<br />
		</div>
	</form>


	<!--   </div>-->
	<!-- MODULO CONTEUDO - FINAL *** //-->

	<!--</div> -->
	<div style="clear: both;">&nbsp;</div>
	<!-- </div> -->
<?php// include("rodape.php"); ?></body>
</html>