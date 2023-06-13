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
<?php include("quadro_menu_vertical.php"); ?>
    <div id="posts" class="post">
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Notícias</h2>
			<p class="p_text">
				<br />
			</p>
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">Notícias de 2014</a></li>
					<li><a href="#tabs-2">Notícias de 2013</a></li>
					<!--  <li><a href="ajax/content2.html">Tab 2</a></li>
				    <li><a href="ajax/content3-slow.php">Tab 3 (slow)</a></li>
				    <li><a href="ajax/content4-broken.php">Tab 4 (broken)</a></li>-->
				</ul>
				<div id="tabs-1">
					<p>
						<div class="post-content-date">
							<span>06</span>jun
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Bio reconhece seus pesquisadores
								dando visibilidade aos trabalhos científicos</span><br /> Dos 58
							trabalhos aceitos pela Comissão Científica do II Seminário
							Científico e Tecnológico em Imunobiológicos, ocorrido no Museu da
							Vida de 28 a 30 de maio, 24 foram apresentados oralmente e seis,
							premiados... &nbsp;&nbsp;</br> <a
								href="noticias/2014/Bio_reconhece_seus_pesquisadores_dando_visibilidade_aos_trabalhos_científicos.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>30</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Seminário debate diferentes
								estratégias para biofármacos</span><br /> Na manhã dessa
							sexta-feira, o II Seminário Anual Científico e Tecnológico (SACT)
							de Bio-Manguinhos foi dominado pelo tema dos biofármacos e as
							diferentes estratégias que podem ser derivadas do relacionamento
							com cada paciente... &nbsp;&nbsp;</br> <a
								href="noticias/2014/diferentes-estrategias-biofarmacos.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>30</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Tema com maior número de trabalhos
								selecionados, biofármacos é debatido na conclusão das
								apresentações</span><br /> O II Seminário Anual Científico e
							Tecnológico (SACT) de Bio-Manguinhos teve sua parte de
							apresentações orais concluídas na tarde dessa sexta-feira, quando
							oito trabalhos foram apresentados ao público... &nbsp;&nbsp;</br>
							<a href="noticias/2014/biofarmacos_debatido_apresentacoes.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>29</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Da bancada para o pôster</span><br />
							O espaço para apresentação de trabalhos no Seminário Cientifico e
							Tecnológico de Bio-Manguinhos é uma oportunidade para divulgar
							diversas pesquisas de dentro e fora do Instituto e de
							parceiros... &nbsp;&nbsp;</br> <a
								href="noticias/2014/Da_bancada_para_o_poster.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>29</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Trabalhos sobre reativos fecham
								tarde do segundo dia do II SactBio</span><br /> Iniciando as
							apresentações orais dos trabalhos selecionados sobre reativos
							para diagnóstico no segundo dia do II Seminário Anual Científico
							e Tecnológico em Imunobiológicos de Bio-Manguinhos (SACT),
							Fernanda Ludoulf... &nbsp;&nbsp;</br> <a
								href="noticias/2014/Trabalhos_sobre_reativos_fecham_tarde_do_segundo_dia_do_II_SactBio.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>29</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Setores público e privado discutem
								desafios dos reativos para diagnóstico</span><br /> Para debater
							os principais desafios do desenvolvimento de reativos para
							diagnóstico no país, o segundo dia do II Seminário Anual
							Científico e Tecnológico em Imunobiológicos de
							Bio-Manguinhos/Fiocruz (SACT), 29 de maio, dedicou um dia
							inteiramente ao tema... &nbsp;&nbsp;</br> <a
								href="noticias/2014/Setores_publico_e_privado_discutem_desafios_dos_reativos_para_diagnostico.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>

					<p>
						<div class="post-content-date">
							<span>28</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Luta pela erradicação da pólio no
								mundo</span><br /> Abrindo a programação do II Seminário Anual
							Científico e Tecnológico em Imunobiológicos de
							Bio-Manguinhos/Fiocruz (SACT), na manhã do dia 28/5...
							&nbsp;&nbsp;</br> <a
								href="noticias/2014/Luta_pela_erradicacao_na_polio_no_mundo.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>28</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Apresentações sobre vacinas de febre
								amarela, meningococo e rotavírus são maioria no primeiro dia do
								II SACT</span><br /> Dos 58 trabalhos dos participantes do II
							Seminário Anual Científico e Tecnológico em Imunobiológicos de
							Bio-Manguinhos/Fiocruz (SACT)... &nbsp;&nbsp;</br> <a
								href="noticias/2014/Apresentacoes_sobre_vacinas_de_febre_amarela_mening_coco_e_rotavírus_sao_maioria_no_primeiro_dia_do_II_SACT.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>28</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Incentivando jovens a pensar em
								ciência, tecnologia e inovação</span><br /> Com jovens talentos
							em busca do reconhecimento e especialistas em temas que dominam a
							pauta da saúde pública global, o II Seminário Anual Científico e
							Tecnológico em Imunobiológicos de Bio-Manguinhos (SACT) foi
							aberto hoje (28/5)... &nbsp;&nbsp;</br> <a
								href="noticias/2014/Incentivando_jovens_a_pensar_em ciência_tecnologia_e_inovação.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>21</span>mai
						</div>
						<div class="post-info">
							<span class="noticia_titulo">II Seminário Científico e
								Tecnológico de Bio-Manguinhos/Fiocruz reúne especialistas e
								jovens talentos</span><br /> Com jovens talentos em busca do
							reconhecimento e especialistas em temas que dominam a pauta da
							saúde pública global, o II Seminário Científico e Tecnológico
							(SACT).... &nbsp;&nbsp; <a href="noticias/2014/bio-sact.pdf"
								TARGET="_blank">saiba mais</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
				</div>
				<div id="tabs-2">
					<p>
						<div class="post-content-date">
							<span>15</span>ago
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Seminário premia os melhores
								trabalhos</span><br /> O Seminário Anual Científico e
							Tecnológico de Bio-Manguinhos, que aconteceu de 12 a 14 de
							agosto, no auditório do Museu da Vida, no Campus de Manguinhos,
							foi encerrado com a premiação dos três melhores resumos
							científicos apresentados, de um total de 85 avaliados por uma
							comissão externa composta por quatro especialistas...
							&nbsp;&nbsp;</br> <a href="noticias/15082013-sact8.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>14</span>ago
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Trabalhar em rede é a solução</span><br />
							No último debate do Seminário Anual Científico e Tecnológico de
							Bio-Manguinhos, realizado dia 14 de agosto, no Museu da Vida, o
							pesquisador categoria 1A do Conselho Nacional de Desenvolvimento
							Científico e Tecnológico (CNPq), Mitermayer Galvão, apresentou
							estudos realizados na população de comunidades no Nordeste,
							enfatizando a rede nesta região, além de propor ações futuras
							para que a Fiocruz ajude a melhorar o mercado de vacinas,
							biofármacos e reativos no Brasil... &nbsp;&nbsp; <a
								href="noticias/14082013-sact7.pdf" TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>14</span>ago
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Parcerias para o desenvolvimento da
								cadeia produtiva nacional</span><br /> Incentivadas desde o
							início dos anos 90 por Bio-Manguinhos, as Parcerias para o
							Desenvolvimento Produtivo (PDP) foram um dos temas abordados na
							manhã do último dia do Seminário Científico e Tecnológico
							(14/08). O diretor do Instituto, Artur Roberto Couto, explicou
							como a utilização do poder de compras do estado pela unidade foi
							importante para o crescimento do portfólio de produtos...
							&nbsp;&nbsp; <a href="noticias/14082013-sact6.pdf"
								TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>13</span>ago
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Segundo dia do seminário abordou
								desafios e perspectivas para reativos e biofármacos</span><br />
							O segundo dia do Seminário Anual Científico e Tecnológico de
							Bio-Manguinhos, que acontece de 12 a 14 de agosto, no auditório
							do Museu da Vida, no Campus de Manguinhos, foi dedicado à
							discussão dos desafios, gargalos e perspectivas em
							desenvolvimento tecnológico e produção no Brasil de reativos para
							diagnóstico e biofármacos... &nbsp;&nbsp; <a
								href="noticias/13082013-sact5.pdf" TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>13</span>ago
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Mais desenvolvimento tecnológico e
								qualificação profissional</span><br /> “Bio-Manguinhos é
							referência nacional em produção e inovação na área de
							biofármacos”. Essa foi uma das primeiras frases da apresentação
							do secretário-adjunto da Secretaria de Ciência, Tecnologia e
							Insumos Estratégicos do Ministério da Saúde, Leonardo Paiva, no
							dia 13 de agosto, no debate As perspectivas de desenvolvimento
							tecnológico e produção de biofármacos no Brasil... &nbsp;&nbsp; <a
								href="noticias/13082013-sact4.pdf" TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>

					<p>
						<div class="post-content-date">
							<span>13</span>ago
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Tetra viral é incluída no calendário
								vacinal</span><br /> Durante o Seminário Anual Científico
							Tecnológico, na palestra Desafios, gargalos e perspectivas em
							vacinas e vacinações no Brasil, ocorrida no dia 12 de agosto, a
							coordenadora do Programa Nacional de Imunizações (PNI), Carla
							Domingues apresentou não só as diversas ações e conquistas do
							programa, como a inclusão de novas vacinas no calendário das
							crianças, como a varicela (catapora)... &nbsp;&nbsp; <a
								href="noticias/13082013-sact3.pdf" TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>12</span>ago
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Desafios e perspectivas da vacinação
								do país</span><br /> Investir continuamente em tecnologia e
							pesquisa, capacitar mão de obra e cumprir as demandas do Sistema
							Único de Saúde (SUS). Assim, o diretor de Bio-Manguinhos, Artur
							Couto iniciou a apresentação da primeira mesa de debates na
							abertura do Seminário Anual Científico tecnológico, realizada na
							manhã de hoje (12/08), no auditório do Museu da Vida, no campus
							de Manguinhos... &nbsp;&nbsp; <a
								href="noticias/12082013-sact2.pdf" TARGET="_blank">saiba mais</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-date">
							<span>12</span>ago
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Especialistas do setor
								biofarmacêutico se reunirão em Seminário na Fiocruz</span><br />
							Para apresentar os atuais desafios e perspectivas do
							desenvolvimento de insumos estratégicos no Brasil e construir um
							ambiente favorável à inovação tecnológica, através do estímulo à
							pesquisa, produção científica, troca de experiências e
							conhecimentos, Bio-Manguinhos promove, de 12 a 14 de agosto, o
							Seminário Anual Científico e Tecnológico... &nbsp;&nbsp; <a
								href="noticias/12082013-sact1.pdf" TARGET="_blank">saiba mais</a>
						</div>
					</p>
				</div>
			</div>

			<div class="cleardiv"></div>
		</div>
		<!-- MODULO CONTEUDO - FINAL *** //-->
	</div>
<?php include("rodape.php"); ?>
</body>
</html>