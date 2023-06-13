<?php
require_once "admin/includes/global.php";
require_once "admin/includes/private.php";
require_once "admin/includes/format.php";

$TXT_BUSCA = "";
$PAG_NUMERO = 1;
/*
getDadosModulo ();

// IsOnLine();

getDadosUsuario ();*/

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
<body onload="">
<?php //include("cabecalho.php"); ?>
<div id="content">
<?php

// include("quadro_menu_vertical.php");
// include("quadro_menu_vertical.php");

?>
    <div id="posts" class="post">
			<!-- MODULO CONTEUDO - INICIO *** //-->
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
        <!--  <h2>Submissão de Resumo</h2>-->
			<p class="p_text" style="margin-left: 14px;">&nbsp;Atenção! Para
				enviar um resumo você deve primeiro fazer a sua inscrição no
				Seminário. Se você já fez a sua incrição, informe o e-mail e a senha
				nos campos abaixo.</p>
			<form id="formAcesso" name="formAcesso" method="post" class="search"
				action="">
				<input type="hidden" id="acao" name="acao" value="acesso" />
				<div class="divForm" style="margin-left: 0;">
					<br /> <label class="form_label">E-mail:</label><span
						class="label_obrigatorio">&nbsp;*</span> <br /> <input type="text"
						id="Email" name="Email" class="form_input" maxlength="100"
						style="width: 300px;" />
					<div class="cleardiv"></div>
					<br />
					<div class="cleardiv"></div>

					<label class="form_label">Senha:</label><span
						class="label_obrigatorio">&nbsp;*</span> <br /> <input
						type="password" id="Senha" name="Senha" class="form_input"
						maxlength="10" style="width: 140px;" />
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input
						type="image" id="entrar" name="entrar" value="entrar"
						src="images/bt_peq_entrar.png" alt="Entrar" style="border: 0px;" />
					<div class="cleardiv"></div>
					<br /> <a href="controller.php?modulo=lembrete-senha"
						title="esqueci a senha"> <img
						src="images/bt_esqueci_minha_senha.png" alt="esqueci a senha" />
					</a>
				</div>
			</form>
		</div>
		<!-- MODULO CONTEUDO - FINAL *** //-->
	</div>
	<div style="clear: both;">&nbsp;</div>
	<div style="clear: both;">&nbsp;</div>
	<div style="clear: both;">&nbsp;</div>
<?php //include("rodape.php"); ?>
</body>
</html>