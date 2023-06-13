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
			<h2>Institucional</h2>
			<div class="description">
				<p class="p_text">
					<strong> Fundação Oswaldo Cruz (Fiocruz)</strong><br /> É um órgão
					vinculado ao Ministério da Saúde e com papel central no Sistema
					Único de Saúde (SUS). A Fiocruz tem uma atuação diversificada –
					estudos clínicos, epidemiológicos e em ciências biológicas, humanas
					e sociais; expedições científicas; formação de recursos humanos do
					nível técnico ao doutorado; prestação de serviços hospitalares,
					ambulatoriais e de vigilância sanitária de referência; e fabricação
					de medicamentos, vacinas e outros insumos estratégicos, além dos
					subsídios às políticas públicas. Mantém centros de referência para
					diversas doenças e temas do campo da saúde pública, reconhecidos
					por entidades como a Organização Mundial de Saúde (OMS). Está
					presente em dez dos estados brasileiros, possuindo fora do Rio de
					Janeiro seis unidades finalísticas, nas cidades de Belo Horizonte,
					Curitiba, Manaus, Recife e Salvador, além de representação em
					Brasília. Como parte do projeto de expansão nacional, em atenção às
					políticas de desconcentração da pesquisa e formação de recursos
					humanos, promovidas pelo Governo Federal, estão em estruturação
					representações da Fundação nos estados do Ceará, Rondônia, Mato
					Grosso de Sul e Piauí.

				</p>
				<p class="p_text">
					<br /> <strong>Bio-Manguinhos/Fiocruz</strong><br /> O Instituto de
					Tecnologia em Imunobiológicos (Bio-Manguinhos) é a unidade da
					Fiocruz responsável pelo desenvolvimento tecnológico e pela
					produção de vacinas, reativos para diagnóstico e biofármacos. Sua
					missão é atender prioritariamente às demandas da saúde pública
					nacional. Em 2013, até novembro, mais de 92 milhões de doses de
					vacinas foram fornecidas para o PNI e também para organismos
					internacionais como a Organização Mundial da Saúde (OMS),
					Organização Pan-Americana da Saúde (OPAS) e o Fundo das Nações
					Unidas para a Infância (Unicef).

				</p>
			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>