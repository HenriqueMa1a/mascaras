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
			<p class="p_text">
				Confira as Notícias do I Seminário<br />
			</p>
			<div class="div_palestrante">
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">15/08/2013 -
						Seminário premia os melhores trabalhos</span><br /> O Seminário
					Anual Científico e Tecnológico de Bio-Manguinhos, que aconteceu de
					12 a 14 de agosto, no auditório do Museu da Vida, no Campus de
					Manguinhos, foi encerrado com a premiação dos três melhores resumos
					científicos apresentados, de um total de 85 avaliados por uma
					comissão externa composta por quatro especialistas... &nbsp;&nbsp;</br>
					<a href="noticias/15082013-sact8.pdf" TARGET="_blank">saiba mais</a>
					<img src="images/tracejado.png" alt="" />
				</p>
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">14/08/2013 -
						Trabalhar em rede é a solução</span><br /> No último debate do
					Seminário Anual Científico e Tecnológico de Bio-Manguinhos,
					realizado dia 14 de agosto, no Museu da Vida, o pesquisador
					categoria 1A do Conselho Nacional de Desenvolvimento Científico e
					Tecnológico (CNPq), Mitermayer Galvão, apresentou estudos
					realizados na população de comunidades no Nordeste, enfatizando a
					rede nesta região, além de propor ações futuras para que a Fiocruz
					ajude a melhorar o mercado de vacinas, biofármacos e reativos no
					Brasil... &nbsp;&nbsp; <a href="noticias/14082013-sact7.pdf"
						TARGET="_blank">saiba mais</a> <img src="images/tracejado.png"
						alt="" />
				</p>
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">14/08/2013 -
						Parcerias para o desenvolvimento da cadeia produtiva nacional</span><br />
					Incentivadas desde o início dos anos 90 por Bio-Manguinhos, as
					Parcerias para o Desenvolvimento Produtivo (PDP) foram um dos temas
					abordados na manhã do último dia do Seminário Científico e
					Tecnológico (14/08). O diretor do Instituto, Artur Roberto Couto,
					explicou como a utilização do poder de compras do estado pela
					unidade foi importante para o crescimento do portfólio de
					produtos... &nbsp;&nbsp; <a href="noticias/14082013-sact6.pdf"
						TARGET="_blank">saiba mais</a> <img src="images/tracejado.png"
						alt="" />
				</p>
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">13/08/2013 -
						Segundo dia do seminário abordou desafios e perspectivas para
						reativos e biofármacos</span><br /> O segundo dia do Seminário
					Anual Científico e Tecnológico de Bio-Manguinhos, que acontece de
					12 a 14 de agosto, no auditório do Museu da Vida, no Campus de
					Manguinhos, foi dedicado à discussão dos desafios, gargalos e
					perspectivas em desenvolvimento tecnológico e produção no Brasil de
					reativos para diagnóstico e biofármacos... &nbsp;&nbsp; <a
						href="noticias/13082013-sact5.pdf" TARGET="_blank">saiba mais</a>
					<img src="images/tracejado.png" alt="" />
				</p>
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">13/08/2013 - Mais
						desenvolvimento tecnológico e qualificação profissional</span><br />
					“Bio-Manguinhos é referência nacional em produção e inovação na
					área de biofármacos”. Essa foi uma das primeiras frases da
					apresentação do secretário-adjunto da Secretaria de Ciência,
					Tecnologia e Insumos Estratégicos do Ministério da Saúde, Leonardo
					Paiva, no dia 13 de agosto, no debate As perspectivas de
					desenvolvimento tecnológico e produção de biofármacos no Brasil...
					&nbsp;&nbsp; <a href="noticias/13082013-sact4.pdf" TARGET="_blank">saiba
						mais</a> <img src="images/tracejado.png" alt="" />
				</p>
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">13/08/2013 - Tetra
						viral é incluída no calendário vacinal</span><br /> Durante o
					Seminário Anual Científico Tecnológico, na palestra Desafios,
					gargalos e perspectivas em vacinas e vacinações no Brasil, ocorrida
					no dia 12 de agosto, a coordenadora do Programa Nacional de
					Imunizações (PNI), Carla Domingues apresentou não só as diversas
					ações e conquistas do programa, como a inclusão de novas vacinas no
					calendário das crianças, como a varicela (catapora)... &nbsp;&nbsp;
					<a href="noticias/13082013-sact3.pdf" TARGET="_blank">saiba mais</a>
					<img src="images/tracejado.png" alt="" />
				</p>
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">12/08/2013 -
						Desafios e perspectivas da vacinação do país</span><br /> Investir
					continuamente em tecnologia e pesquisa, capacitar mão de obra e
					cumprir as demandas do Sistema Único de Saúde (SUS). Assim, o
					diretor de Bio-Manguinhos, Artur Couto iniciou a apresentação da
					primeira mesa de debates na abertura do Seminário Anual Científico
					tecnológico, realizada na manhã de hoje (12/08), no auditório do
					Museu da Vida, no campus de Manguinhos... &nbsp;&nbsp; <a
						href="noticias/12082013-sact2.pdf" TARGET="_blank">saiba mais</a>
					<img src="images/tracejado.png" alt="" />
				</p>
				<p>
					<img class="img_palestrante" src="images/noticia-padrao.jpg"
						height="90px;" /> <span class="noticia_titulo">12/08/2013 -
						Especialistas do setor biofarmacêutico se reunirão em Seminário na
						Fiocruz</span><br /> Para apresentar os atuais desafios e
					perspectivas do desenvolvimento de insumos estratégicos no Brasil e
					construir um ambiente favorável à inovação tecnológica, através do
					estímulo à pesquisa, produção científica, troca de experiências e
					conhecimentos, Bio-Manguinhos promove, de 12 a 14 de agosto, o
					Seminário Anual Científico e Tecnológico... &nbsp;&nbsp; <a
						href="noticias/12082013-sact1.pdf" TARGET="_blank">saiba mais</a>
				</p>
			</div>
			<div class="cleardiv"></div>
		</div>
		<!-- MODULO CONTEUDO - FINAL *** //-->
	</div>
<?php include("rodape.php"); ?>
</body>
</html>