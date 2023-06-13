<?php
require_once "admin/includes/private.php";
require_once "admin/includes/format.php";

$TXT_BUSCA = "";
$PAG_NUMERO = 1;

getDadosModulo ();

// IsOnLine();

getDadosUsuario ();

?>
<!DOCTYPE html>
<html lang="en">
<head>

<style>
#carousel-639099 {
	display: none;
}
</style>
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
<?php //include("cabecalho.php"); ?>
<div id="content">
<?php //include("quadro_menu_vertical.php"); ?>
    <div id="posts" class="post">
	<?php include("quadro_mensagem.php"); ?>
	<!-- MODULO CONTEUDO - INICIO *** //-->
			<a name="a_titulo" /> <a name="PAG_TOPO" />
			<div id="loading" style="display:none;">
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

			<!--  <h2>Recuperação de Senha</h2>-->
			<div class="description">
				<form id="formCadastro" name="formCadastro"
					action="lembrete-senha.action.php" onsubmit="return false;">
					<input type="hidden" id="acao" name="acao" value="enviar-senha" />

					<p class="p_text">
						Infome o email cadastrado na inscrição do seminário e clique em
						enviar para recuperar sua senha. <br />
						<br />
					</p>


					<p class="p_text">
						<label class="form_label">Informe seu Email:</label> <br /> <input
							class="form_input" type="text" maxlength="50" value="" id="Email"
							name="Email" style="width: 250px;" /> <br /> <img
							class="botao_cadastro" id="bt_enviar-senha"
							src="images/bt_peq_enviar-senha.png" onclick="enviar();" alt="" />


					</p>
				</form>
				<div class="cleardiv"></div>
			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php // include("rodape.php"); ?>
</body>
</html>