<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once "admin/includes/global.joomla.php";
require_once "admin/includes/private.php";
require_once "admin/includes/format.php";

$TXT_BUSCA = "";
$PAG_NUMERO = 1;

getDadosModulo();

getDadosUsuario();

// usuario logado, vai pra página de enviar resumo !!!

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php
include_once ('tags.php');
include_once ('estilos.php');
include_once ('javascripts.php');
include_once ('bootstrap.php');

include_once ('jquery.php');
if (file_exists ( 'modulos/' . $MOD_CLASSE . '.js.php' ))
	include_once ('modulos/' . $MOD_CLASSE . '.js.php');
?> 
</head>
<body style="width:100%;">

	<div id="content">
		<form id="formCadastro" name="formCadastro" method="post"
			action="action.php" onsubmit="return false;">
			<!--  <form id="formCadastro" name="formCadastro" method="post" action="modulos/minha-area.action.php" onsubmit="return false;" >-->
	<?php
	
	// include("quadro_menu_vertical.php");
	// include("quadro_menu_vertical.php");
	
	?>
	
	    <div id="posts" class="post">
				<div>
				<?php
				
				if ($USO_ID > 0) {					
					$arr = explode ( ' ', $USO_NOME );
					$USO_PRIMEIRO_NOME = $arr [0];
					echo "<div id='boxUsuarioAtual'><div id='lb_nome_usuario'>Usuário:&nbsp;<b>$USO_NOME</b></div></div>";
				}
				?>
</div>
				<!-- MODULO CONTEUDO - INICIO *** //-->
				<a name="a_titulo" ></a> <a name="PAG_TOPO" ></a>
				<div id="resultado" style="display: none;"></div>
				<div id="msg_quadro" class="msg_quadro" style="display: none;">
					<img id="msg_icone" class="msg_icone" src="images/i_alerta.png"
						alt="Aviso" />&nbsp; <span id="msg_texto" class="msg_texto">Mensagem
						de Alerta</span> <img id="msg_botao" class="msg_botao"
						src="images/i_fechar.png" title="Fechar mensagem"
						alt="Fechar mensagem" onclick="ocultarMensagem();" />
				</div>

				<!--  <h2>Submissão de Resumo</h2>-->

				<!-- Pacotes - INICIO --> 
				<div id="bloco_inscricao" style="display: none;">
					<table align="center" border="0" cellpadding="0" cellspacing="7">
						<tr>
							<td align="left" valign="top" colspan="3">
								<table cellpadding="0" cellspacing="3" border="1">
									<tr>
										<td align="left" valign="middle" width="35"><img
											src="images/i_ficha.png" alt="Minha Inscrição"
											class="botao_cadastro" /></td>
										<td align="left" valign="middle" width="400"><span
											class="label_subtitulo">Minha Inscrição</span><a
											name="MINHA_PAGINA" ></a></td>
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
								class="label_campo">Email:</span><br /> <span
								class="label_valor" id="label_Email">&nbsp;</span></td>
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
								<span class="label_valor" id="label_Departamento">&nbsp;</span>
							</td>
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
									class="img_icone" id="FlagIndicacao"
									src="images/checkbox_0.gif" />Indicação&nbsp;&nbsp;</span> <span
								class="label_valor" id="label_FlagBioMural"><img
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

				<div id="bloco_resumo">

					<input type="hidden" id="acao" name="acao" value="criar-resumo" />
					<input type="hidden" id="IdUsuario" name="IdUsuario" value="" />
					<input type="hidden" id="IdResumo" name="IdResumo" value="" />
				</div>

				<table align="left" border="0" cellpadding="0" cellspacing="7"
					width="100%">

					<tr>
						<td align="left" valign="top" colspan="3">
							<table cellpadding="0" cellspacing="3" border="0">
								<tr>
									<td align="left" valign="middle" width="35"><img
										src="images/i_poster.png" alt="Meus Resumos"
										class="botao_cadastro" /></td>
									<td align="left" valign="middle" width="250"><span
										class="label_subtitulo">Meu(s) Resumo(s)</span><a name="MEU_RESUMO" ></a></td>
								</tr>
							</table>
						</td>
						<td valign="middle" colspan="3" align="right">
						
						<div class="btn-group btn-group" role="group">
							<a id="bt-_enviar-resumo" alt="Enviar Resumos" type="button" onclick="abrirFormResumo();" class="btn btn-success" style="display: none;">
							<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							Novo Resumo</a>
                            <a id="bt-MinhaInscricao" href="../index.php/minha-inscricao" target="_top" alt="Minha Inscrição" type="button" class="btn btn-info"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Minha Inscrição </a>
							<a id="bt-AlterarFicha" href="../index.php/2015-10-20-17-09-48/ficha-de-inscricao" target="_top" alt="Alterar Cadastro" type="button" class="btn btn-warning" style="display: none;">
							<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
							Alterar Cadastro</a>
							<?php  
                            
							$userToken = JSession::getFormToken();
							
							//formando url de retorno após logout
							$redirectUrl = "index.php?option=com_users&view=login";
							//url codificada
							$redirectUrlencoded = urlencode(base64_encode($redirectUrl));
							echo '<a class="btn btn-danger" href="../index.php?option=com_users&task=user.logout&' .
							$userToken . '=1&return='.$redirectUrlencoded.'" target="_top">'.'<span class="glyphicon glyphicon-off" aria-hidden="true"></span> Sair'.'</a>';
							
							
							
							
							?>
							</div>
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
						<td align="left" valign="top" colspan="6"><span
							class="label_valor" id="lista_Resumos">&nbsp;</span>
							<table class="table table-hover" id="tab_resumo">
								<thead>
									<tr>
										<th><b>Código</b></th>
										<th><b>Titulo do Resumo</b></th>
										<th><b>Classif.</b></th>
										<th><b>Status</b></th>
										<th><b>Data</b></th>
										<th><b>Ação</b></th>
									</tr>
									
								</thead>
								<tbody>
								</tbody>
							</table></td>
					</tr>
					<tr>
						<td align="left" valign="top" colspan="6">

							<div id="DivFormResumo" style="display: none;">

								<a name="a_box_resumo" ></a>
								<table cellpadding="0" cellspacing="3" border="0">
									<tr>
										<td align="left" valign="middle" width="250"><span
											class="label_subtitulo">Enviar Resumo:</span></td>
										<td align="right" valign="middle" width="250">
										</td>
									</tr>
								</table>
								<br /> <br />
								<div class="boxInfo"
									style="left: -8px; display: none; right: 140px;" id="infoClass">
									<div class="contInfo"
										style="background: #f6f2d2; padding: 5px 10px; border: solid 1px #fff; font-size: 10px; margin: 0; line-height: 10px; width: 300px;">
										<h3>Classifique seu resumo:</h3>
										<br /> - Ao submeter o resumo, o autor deverá assinalar,
										dentre as opções propostas, em qual categoria seu trabalho é
										definido: biofármacos, vacinas, kits para diagnóstico ou
										outros temas relacionados.<br />

										<div class="pontaInfo">
											<div></div>
										</div>

									</div>
								</div>
								<img src="images/ico_info2.gif" style="cursor: pointer;"
									onmouseover="document.getElementById('infoClass').style.display = '';"
									onmouseout="document.getElementById('infoClass').style.display = 'none';" />&nbsp;&nbsp;&nbsp;<label
									class="form_label"><strong> Classifique seu resumo:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span> <br /> <br />&nbsp;&nbsp;&nbsp;&nbsp;

								<!--  <input type="radio" id="TipoResumo" name="TipoResumo" value="1" />&nbsp;Biofármacos&nbsp;&nbsp;&nbsp;
												<input type="radio" id="TipoResumo" name="TipoResumo" value="2" />&nbsp;Kits para diagnóstico&nbsp;&nbsp;&nbsp;
												<input type="radio" id="TipoResumo" name="TipoResumo" value="3" />&nbsp;Vacinas&nbsp;&nbsp;&nbsp;
												<input type="radio" id="TipoResumo" name="TipoResumo" value="4" />&nbsp;Outros
												-->
								<input type="radio" id="TipoResumo1" name="TipoResumo" value="1" />&nbsp;V (Vacina)&nbsp;&nbsp; 
								<input type="radio" id="TipoResumo2" name="TipoResumo" value="2" />&nbsp;B (Biofármaco)&nbsp;&nbsp; 
								<input type="radio" id="TipoResumo3" name="TipoResumo" value="3" />&nbsp;R (Reativo para diagnóstico)&nbsp;&nbsp; 
								<input type="radio" id="TipoResumo5" name="TipoResumo" value="5" />&nbsp;G (Gestão)&nbsp;&nbsp; 
								<input type="radio" id="TipoResumo4" name="TipoResumo" value="4" />&nbsp;OTR (Outros temas relacionados)&nbsp;&nbsp;
								<input type="hidden" id="OutrosTemas" name="OutrosTemas" value="" />
								<p style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>
								<div class="title">
									<h1></h1>
								</div>
								<!-- Inicio do Titulo -->

								<div class="boxInfo"
									style="left: -8px; display: none; right: 140px;"
									id="infoEmail1">
									<div class="contInfo"
										style="background: #f6f2d2; padding: 5px 10px; border: solid 1px #fff; font-size: 10px; margin: 0; line-height: 10px; width: 300px;">
										<h3>Título:</h3>
										<br /> - O título deve ser digitado em caixa baixa e negrito
										(Times New Roman - tamanho 14 ou 16), descrevendo concisamente
										a essência do assunto. – até 20 palavras.<br /> - Caso o
										título contenha algum termo científico, este deve estar em
										itálico.<br /> - Os títulos e textos dos resumos devem estar
										alinhados à esquerda (não justificar).<br /> <br />

										<div class="pontaInfo">
											<div></div>
										</div>

									</div>
								</div>
								<img src="images/ico_info2.gif" style="cursor: pointer;"
									onmouseover="document.getElementById('infoEmail1').style.display = '';"
									onmouseout="document.getElementById('infoEmail1').style.display = 'none';" />&nbsp;&nbsp;&nbsp;<label
									class="form_label"><strong>Título:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <label
									class="form_label" style="display: none;"><strong>Límite de 20
										palavras</strong></label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

								<div style="display: none;">
									<span class="label_obrigatorio">Total de Palavras: <span
										id="PalavrasTitulo">0</span> / 20
									</span>
								</div>
								<br />
								<textarea rows="3" cols="10" id="TituloResumo"
									name="TituloResumo" style="width: 100%; margin-bottom: 10px;"
									class="tinymce2"
									onkeyup="document.getElementById('PalavrasTitulo').innerHTML=ContarPalavras(this);"></textarea>
								<br />
								<div class="cleardiv"></div>
								<!-- Fim do Titulo -->

								<p
									style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>

								<!-- Inicio dos Autores -->
								<div class="boxInfo"
									style="left: -8px; display: none; right: 140px;"
									id="infoAutores">
									<div class="contInfo"
										style="background: #f6f2d2; padding: 5px 10px; border: solid 1px #fff; font-size: 10px; margin: 0; line-height: 10px; width: 300px;">
										<h3>Autores:</h3>
										<br /> - Autores: nome por extenso (inserir no máximo 7
										autores, podendo excepcionalmente chegar até 10, desde que
										justificado e aceito pela Comissão Científica).<br /> - Não
										colocar o título dos autores: Ex: Doutor, Professor, entre
										outros.<br /> - O nome do autor principal deverá vir em
										primeiro lugar e o nome do apresentador, sinalizado com um
										asterisco (*) logo após.<br /> <br /> - A instituição deverá
										ser mencionada após o nome do autor, como exemplificado
										abaixo.<br />

										<div class="pontaInfo">
											<div></div>
										</div>

									</div>
								</div>
								<img src="images/ico_info2.gif" style="cursor: pointer;"
									onmouseover="document.getElementById('infoAutores').style.display = '';"
									onmouseout="document.getElementById('infoAutores').style.display = 'none';" />&nbsp;&nbsp;&nbsp;<label
									class="form_label"><strong>Autores / Instituições:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a class="btn btn-success" type="button" id="addScnt">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								Adicionar novo Autor</a>
								<br />
								<br />						
								<table id="tabelaAutores" class="bordered" width="100%">
									<tr style="height:20px;">
										<th></th>
										<th>Autor</th>
										<th>Instituição</th>
										<th>E-mail</th>
										<th>Principal</th>
										<th>Apresentador</th>
										<th></th>


									</tr>
						
									<tr id="tr_1">
										<td><strong>1º</strong></td>
										<td><input type="text" id="autor1" name="autor1"
											style="font-size: 13px;" size="25" /></td>
										<td><input type="text" id="instituicao1"
											style="font-size: 13px;" size="20" name="instituicao1" /></td>
										<td><input type="text" id="email1"
											style="font-size: 13px; display: none;" name="email1"
											size="25" /></td>
										<td align="center"><input type="hidden" id="principal1"
											name="principal1" checked="checked" value="1"
											disabled="disabled" />
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span></td>
										<td align="center"><input type="checkbox" id="apresentador1"
											onclick="DesabilitaChcBox(1);" name="apresentador1" value="0" /></td>
										<td></td>

									</tr>
									<tr id="tr_2" style="display: none;">
										<td><strong>2º</strong></td>
										<td><input type="text" id="autor2" name="autor2"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao2"
											style="font-size: 10px;" size="20" name="instituicao2" /></td>
										<td><input type="text" id="email2"
											style="font-size: 10px; display: none;" name="email2"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador2"
											name="apresentador2" onclick="DesabilitaChcBox(2);" value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(2);" /></td>

									</tr>
									<tr id="tr_3" style="display: none;">
										<td><strong>3º</strong></td>
										<td><input type="text" id="autor3" name="autor3"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao3"
											style="font-size: 10px;" size="20" name="instituicao3" /></td>
										<td><input type="text" id="email3"
											style="font-size: 10px; display: none;" name="email3"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador3"
											name="apresentador3" onclick="DesabilitaChcBox(3);" value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(3);" /></td>

									</tr>
									<tr id="tr_4" style="display: none;">
										<td><strong>4º</strong></td>
										<td><input type="text" id="autor4" name="autor4"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao4"
											style="font-size: 10px;" size="20" name="instituicao4" /></td>
										<td><input type="text" id="email4"
											style="font-size: 10px; display: none;" name="email4"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador4"
											name="apresentador4" onclick="DesabilitaChcBox(4);" value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(4);" /></td>

									</tr>
									<tr id="tr_5" style="display: none;">
										<td><strong>5º</strong></td>
										<td><input type="text" id="autor5" name="autor5"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao5"
											style="font-size: 10px;" size="20" name="instituicao5" /></td>
										<td><input type="text" id="email5"
											style="font-size: 10px; display: none;" name="email5"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador5"
											name="apresentador5" onclick="DesabilitaChcBox(5);" value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(5);" /></td>

									</tr>
									<tr id="tr_6" style="display: none;">
										<td><strong>6º</strong></td>
										<td><input type="text" id="autor6" name="autor6"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao6"
											style="font-size: 10px;" size="20" name="instituicao6" /></td>
										<td><input type="text" id="email6"
											style="font-size: 10px; display: none;" name="email6"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador6"
											onclick="DesabilitaChcBox(6);" name="apresentador6" value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(6);" /></td>

									</tr>
									<tr id="tr_7" style="display: none;">
										<td><strong>7º</strong></td>
										<td><input type="text" id="autor7" name="autor7"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao7"
											style="font-size: 10px;" size="20" name="instituicao7" /></td>
										<td><input type="text" id="email7"
											style="font-size: 10px; display: none;" name="email7"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador7"
											onclick="DesabilitaChcBox(7);" name="apresentador7" value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(7);" /></td>

									</tr>
									<tr id="tr_8" style="display: none;">
										<td><strong>8º</strong></td>
										<td><input type="text" id="autor8" name="autor8"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao8"
											style="font-size: 10px;" size="20" name="instituicao8" /></td>
										<td><input type="text" id="email8"
											style="font-size: 10px; display: none;" name="email8"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador8"
											name="apresentador8" onclick="DesabilitaChcBox(8);" value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(8);" /></td>
									</tr>
									<tr id="tr_8_" style="display: none;">
										<td colspan="6" valign="top"><strong> Justificativa: </strong><br />
											<input id="justificativa8" name="justificativa8"
											style="font-size: 10px; resize: none;" size="100"
											maxlength="95" /></td>
									</tr>
									<tr id="tr_8__" style="display: none;">
										<td><br /></td>
									</tr>
									<tr id="tr_9" style="display: none;">
										<td><strong>9º</strong></td>
										<td><input type="text" id="autor9" name="autor9"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao9"
											style="font-size: 10px;" size="20" name="instituicao9" /></td>
										<td><input type="text" id="email9"
											style="font-size: 10px; display: none;" name="email9"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador9"
											name="apresentador9" onclick="DesabilitaChcBox(9);" value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(9);" /></td>
									</tr>
									<tr>
										<td><br /></td>
									</tr>
									<tr id="tr_9_" style="display: none;">
										<td colspan="6" valign="top"><strong> Justificativa: </strong><br />
											<input id="justificativa9" name="justificativa9"
											style="font-size: 10px; resize: none;" size="100"
											maxlength="95" /><br /></td>
									</tr>
									<tr id="tr_9__" style="display: none;">
										<td><br /></td>
									</tr>
									<tr id="tr_10" style="display: none;">
										<td><strong>10º</strong></td>
										<td><input type="text" id="autor10" name="autor10"
											style="font-size: 10px;" size="25" /></td>
										<td><input type="text" id="instituicao10"
											style="font-size: 10px;" size="20" name="instituicao10" /></td>
										<td><input type="text" id="email10"
											style="font-size: 10px; display: none;" name="email10"
											size="25" /></td>
										<td></td>
										<td align="center"><input type="checkbox" id="apresentador10"
											name="apresentador10" onclick="DesabilitaChcBox(10);"
											value="0" /></td>
										<td><img src="images/i_fechar.png" onclick="limparAutor(10);" /></td>
									</tr>
									<tr id="tr_10_" style="display: none;">
										<td colspan="6" valign="top"><strong> Justificativa: </strong><br />
											<input id="justificativa10" name="justificativa10"
											style="font-size: 10px; resize: none;" size="100"
											maxlength="95" /><br /></td>
									</tr>
								</table>


								<!-- Fim do Autores -->

								<p
									style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>

								<!-- Inicio dos introducao -->
								<label class="form_label"><strong>Introdução:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
									class="form_label" style="display: none;"><strong>Límite de 300
										palavras</strong></label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div style="display: none;">
									<span class="label_obrigatorio">Total de Palavras: <span
										id="Palavrasintroducao">0</span> / 300
									</span>
								</div>
								<br />
								<textarea rows="5" cols="50" id="Textointroducao"
									name="Textointroducao" class="tinymce"
									style="width: 100%; margin-bottom: 10px;"
									onkeyup="document.getElementById('Textointroducao').innerHTML=ContarPalavras(this);"></textarea>
								<br />
								<div class="cleardiv"></div>
								<!-- Fim dos introducao -->
								<p
									style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>
								<!-- Inicio do Objetivo -->
								<label class="form_label"><strong>Objetivo:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
									class="form_label" style="display: none;"><strong>Límite de 300
										palavras</strong></label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div style="display: none;">
									<span class="label_obrigatorio">Total de Palavras: <span
										id="PalavrasObjetivo">0</span> / 300
									</span>
								</div>
								<br />
								<textarea rows="5" cols="50" id="TextoObjetivo"
									name="TextoObjetivo" class="tinymce"
									style="width: 100%; margin-bottom: 10px;"
									onKeyUp="document.getElementById('TextoObjetivo').innerHTML=ContarPalavras(this);"></textarea>
								<br />
								<div class="cleardiv"></div>
								<!-- Fim da Metodologia -->
								<p
									style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>
								<!-- Inicio do Objetivo -->
								<label class="form_label"><strong>Metodologia:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
									class="form_label" style="display: none;"><strong>Límite de 300
										palavras</strong></label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div style="display: none;">
									<span class="label_obrigatorio">Total de Palavras: <span
										id="PalavrasMetodologia">0</span> / 300
									</span>
								</div>
								<br />
								<textarea rows="5" cols="50" id="TextoMetodologia"
									name="TextoMetodologia" class="tinymce form_input"
									style="width: 100%; margin-bottom: 10px;"
									onKeyUp="document.getElementById('TextoMetodologia').innerHTML=ContarPalavras(this);"></textarea>
								<br />
								<div class="cleardiv"></div>
								<!-- Fim da Metodologia -->
								<p
									style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>
								<!-- Inicio da Resumo -->
								<div class="boxInfo"
									style="left: -8px; display: none; right: 140px;"
									id="infoEmail3">
									<div class="contInfo"
										style="background: #f6f2d2; padding: 5px 10px; border: solid 1px #fff; font-size: 10px; margin: 0; line-height: 10px; width: 300px;">
										<h3>Resultado:</h3>
										<br /> - O resumo é um texto de no máximo 450 palavras (sem
										contar título, Autores e instituição).<br /> - O resumo poderá
										ser digitado em Inglês ou Português.<br /> - O resumo NÃO
										poderá conter figuras, gráficos ou tabelas.<br /> - A forma do
										resumo é retrato e não poderá ser paisagem.<br /> <br />

										<div class="pontaInfo">
											<div></div>
										</div>

									</div>
								</div>
								<img src="images/ico_info2.gif"
									style="cursor: pointer; display: none;"
									onmouseover="document.getElementById('infoEmail3').style.display = '';"
									onmouseout="document.getElementById('infoEmail3').style.display = 'none';" />&nbsp;&nbsp;&nbsp;<label
									class="form_label"><strong>Resultado:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;<label class="form_label"
									style="display: none;"><strong>Límite de 450 palavras</strong></label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div style="display: none;">
									<span class="label_obrigatorio">Total de Palavras: <span
										id="PalavrasResumo">0</span> / 450
									</span>
								</div>
								<br />
								<textarea rows="5" cols="50" id="TextoResumo" name="TextoResumo"
									class="tinymce" style="width: 100%; margin-bottom: 10px;"
									onKeyUp="document.getElementById('TextoResumo').innerHTML=ContarPalavras(this);"></textarea>
								<br />
								<div class="cleardiv"></div>
								<!-- Fim do Resumo -->
								<p
									style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>

								<!-- Inicio da Conclusao -->
								<label class="form_label"><strong>Conclusão:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
									class="form_label" style="display: none;"><strong>Límite de 300
										palavras</strong></label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div style="display: none;">
									<span class="label_obrigatorio">Total de Palavras: <span
										id="PalavrasConclusao">0</span> / 300
									</span>
								</div>
								<br />
								<textarea rows="5" cols="50" id="TextoConclusao"
									name="TextoConclusao" class="tinymce"
									style="width: 100%; margin-bottom: 10px;"
									onKeyUp="document.getElementById('TextoConclusao').innerHTML=ContarPalavras(this);"></textarea>
								<br />
								<div class="cleardiv"></div>
								<!-- Fim do Conclusão -->
								<p
									style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>
								<!-- Inicio da Palavras Chaves -->
								<div class="boxInfo"
									style="left: -8px; display: none; right: 140px;"
									id="infoPalavras">
									<div class="contInfo"
										style="background: #f6f2d2; padding: 5px 10px; border: solid 1px #fff; font-size: 10px; margin: 0; line-height: 10px; width: 300px;">
										<h3>Palavras-chave:</h3>
										<br /> - Devem ser fornecidas três a cinco palavras chave. <br />

										<div class="pontaInfo">
											<div></div>
										</div>

									</div>
								</div>
								<img src="images/ico_info2.gif" style="cursor: pointer;"
									onmouseover="document.getElementById('infoPalavras').style.display = '';"
									onmouseout="document.getElementById('infoPalavras').style.display = 'none';" />&nbsp;&nbsp;&nbsp;
								<label class="form_label"><strong>Palavras-chave:</strong></label><span
									class="label_obrigatorio">&nbsp;*</span>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label
									class="form_label" style="display: none;"><strong>Límite de 300
										palavras</strong></label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div style="display: none;">
									<span class="label_obrigatorio">Total de Palavras: <span
										id="PalavrasPalavrasChaves">0</span> / 300
									</span>
								</div>
								<br /> <input type="text" id="TextoPalavraChave"
									name="TextoPalavraChave" value="" class="form_input"
									maxlength="255" style="width: 300px;" /> <br />
								<div class="cleardiv"></div>
								<!-- Fim do Palavras Chaves -->
								<p
									style="border-bottom: solid 1px #f2f2f2; width: 95%; margin-bottom: 10px;"></p>

								<input type="checkbox" id="FlagPolitica" name="FlagPolitica"
									value="1" />&nbsp;Declaro que o meu trabalho não foi publicado
								em revista ou anais de congresso e tem afinidade com os temas
								abordados no Seminário.<br /> <br /> <input type="checkbox"
									id="FlagPolitica1" name="FlagPolitica1" value="1" />&nbsp;Declaro
								que li o regulamento do III Seminário Anual Científico e
								Tecnológico em Imunobiológicos e as informações fornecidas nesta
								ficha de inscrição são verdadeiras.<br /> <br /> <input
									type="checkbox" id="FlagPolitica2" name="FlagPolitica2"
									value="1" />&nbsp;Declaro que o trabalho foi aprovado previamente pelo 
									NIT (Núcleo de Inovação Tecnológica) para divulgação. 
									(Obs: a passagem do trabalho pelo NIT é obrigatória para a aprovação do resumo, mas,
									 caso não tenha sido feita previamente, poderá ainda ser feita e comunicada à assessoria do evento até o dia 25 de março pelo
									  e-mail gisa@bio.fiocruz.br). <br />
								<br /> <!--  <input type="checkbox" id="FlagPolitica3"
									name="FlagPolitica3" value="1" /> Declaro que meu trabalho foi
								desenvolvido no Brasil e que este é um dos critérios para que o
								mesmo concorra à premiação.<br />-->
								<div class="cleardiv"></div>
								
								<br />
								<p align="center">
								<a id="bt_enviar" alt="Enviar Resumo" type="button" onclick="enviar();return false;" class="btn btn-success btn-lg">
							<span class="glyphicon glyphicon-send" aria-hidden="true"></span>
							Enviar Resumo</a>
							<a id="bt_cancelar" alt="Cancelar Envio de Resumo" type="button" onclick="cancelar();" class="btn btn-danger btn-lg">
							<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							Cancelar</a>
								</p>
							</div>
							</div>
						</td>
					</tr>
				</table>

				<div class="cleardiv"></div>

			</div>
			<div class="cleardiv"></div>
			<div class="cleardiv"></div>
			<!-- Pacotes - FINAL -->
			<!-- MODULO CONTEUDO - FINAL *** //-->
	
	</div>
	</form>
	</div>
</body>
</html>