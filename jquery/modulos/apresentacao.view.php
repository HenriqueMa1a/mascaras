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
<?php 
// include("quadro_menu_vertical.php");
include ("quadro_menu_vertical.php");

?>
    <div id="posts" class="post">
	<?php //include("quadro_mensagem.php"); ?>
	<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Apresentação</h2>
			<div class="description">
				<p class="p_text">O II Seminário Anual Científico e Tecnológico em
					Imunobiológicos acontece de 28 a 30 de maio de 2014, no Auditório
					do Museu da Vida, localizado no campus da Fiocruz, Rio de Janeiro.
					Esta edição acontece após a bem sucedida estreia em 2013, que
					contou com cerca de 350 participantes e 85 trabalhos inscritos.</p>
				<p class="p_text">
					<br /> O evento visa incentivar e motivar pesquisadores de
					instituições nacionais e internacionais, em especial os da Fiocruz
					e de Bio-Manguinhos, para a inovação e o desenvolvimento
					tecnológico de vacinas, reativos para diagnóstico laboratorial e
					biofármacos. Estimula a inovação com novos espaços e oportunidades
					para jovens talentos e para a interação entre profissionais de
					áreas afins.


				</p>
				<p class="p_text">
					<br /> Com mais esta iniciativa, Bio-Manguinhos mantém sua
					trajetória de criar condições propícias ao aperfeiçoamento e
					qualificação profissional nessas áreas de atuação, estimulando
					permanentemente novas abordagens, processos e tecnologias, além de
					identificar novos talentos e favorecer a participação de novos
					pesquisadores oriundos de outras instituições do país e do
					exterior.


				</p>
				<p class="p_text">
					<br /> Ao reunir profissionais da Fiocruz e de entidades de
					referência, ensino, pesquisa – além do Governo – o II Seminário
					Anual Científico e Tecnológico em Imunobiológicos favorece a
					sinergia pela consolidação de redes colaborativas de pesquisa
					científica e tecnológica, nos planos nacional e internacional.
					Participe!

				</p>

			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>