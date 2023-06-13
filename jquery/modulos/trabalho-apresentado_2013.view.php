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
			<h2>Conteúdo das palestras de 2013</h2>
			<p class="p_text">
				<br />
			</p>
			<div id="tabulador">
				<ul>
					<li><a href="#tabulador-1">12/08/2013</a></li>
					<li><a href="#tabulador-2">13/08/2013</a></li>
					<li><a href="#tabulador-3">14/08/2013</a></li>
					<!--  <li><a href="ajax/content2.html">Tab 2</a></li>
				    <li><a href="ajax/content3-slow.php">Tab 3 (slow)</a></li>
				    <li><a href="ajax/content4-broken.php">Tab 4 (broken)</a></li>-->
				</ul>
				<div id="tabulador-1">
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Células-tronco
							adultas humanas para ensaios de citotoxicidade: uma alternativa
							aos ensaios animais <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Alessandra
								Melo de Aguiar, Instituto Carlos Chagas, FIOCRUZ-PR</i>
							&nbsp;&nbsp; <a href="trabalhos/12-alessandra-aguiar.pdf"
								TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> ESTUDO COMPARATIVO DE
							IMUNOGENICIDADE DA VACINA TRÍPLICE VIRAL (TVV), NAS APRESENTAÇÕES
							MONODOSE E MULTIDOSE <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Ana Luiza
								Braz Pavão, Assessoria Clínica, Bio-Manguinhos, Fiocruz</i>
							&nbsp;&nbsp; <a href="trabalhos/12-ana-pavao.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> ESTUDO VISANDO AO
							AUMENTO DO PRAZO DE VALIDADE DA VACINA FEBRE AMARELA 05 E 10
							DOSES DE 24 PARA 36 MESES. <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Paulo Dick,
								Departamento de Controle de Qualidade Bio-Manguinhos / FIOCRUZ</i>
							<br /> <span class="noticia_titulo"><br />
							<i>Bordetella pertussis:</i></span> <b>MAPEAMENTO E
								CARACTERIZAÇÃO DOS EPITOPOS DA TOXINA PERTUSSIS E PERTACTINA</b></br>
							<i><u>Flávio Rocha da Silva</u><sup>1</sup>, Luiz A.L. Teixeira
								Pinto<sup>1</sup>, Alexandre de Oliveira Saísse<sup>1</sup>,
								Luciano Pinho Gomes<sup>1</sup>, Salvatore Giovanni De Simone<sup>1e2</sup>
								Laboratório de Bioquímica Proteína e Peptídeo- Instituto Oswaldo
								Cruz/Fiocruz.Instituto Nacional de Ciência e Tecnologia de
								Inovação em Doenças Negligenciadas ((INCT-IDN)/Centro de
								Desenvolvimento</i> &nbsp;&nbsp; <a
								href="trabalhos/12-paulo-dick.pdf" TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Desafios, gargalos e
							perspectivas em vacinas e vacinações no Brasil <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Carla Magda
								A. S. Domingues Coordenação Geral do Programa Nacional de
								Imunizações Secretaria de Vigilância em Saúde – Ministério da
								Saúde</i> &nbsp;&nbsp; <a
								href="trabalhos/12-carla-domingues.pdf" TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Caracterização
							fenotípica e molecular dos vírus quiméricos febre amarela /
							dengue candidatos a uma vacina tetravalente recombinante contra
							dengue <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Luiz Gustavo
								Almeida Mendes, Bio-Manguinhos - FIOCRUZ</i> &nbsp;&nbsp; <a
								href="trabalhos/12-luiz-gustavo.pdf" TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> ANÁLISE DA
							IMUNOGENICIDADE E GRAU DE PROTEÇÃO DE UMA VACINA INATIVADA PARA
							FEBRE AMARELA EM MODELO MURINO <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Renata
								Carvalho Pereira, Bio-Manguinhos</i> &nbsp;&nbsp; <a
								href="trabalhos/12-renata-carvalho.pdf" TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Tendências
							tecnológicas em produção de vacinas <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Rino
								Rappuoli, Diretor da Novartis</i> &nbsp;&nbsp; <a
								href="trabalhos/12-rino-rappuoli.pdf" TARGET="_blank">Visualizar</a>
						</div>

					</p>
				</div>
				<div id="tabulador-2">
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> DIGESTÃO ENZIMÁTICA
							DE ANTICORPOS MONOCLONAIS MURINOS ANTI-PBP2a DE <i>Staphylococcus
								aureus</i> RESISTENTES À METICILINA (MRSA) PARA OBTENÇÃO DE
							FRAGMENTOS F(ab')2 <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Anna Erika
								Vieira de Araújo Bio-Manguinhos, Programa de Biofármacos,
								VDTEC/LATER</i> &nbsp;&nbsp; <a
								href="trabalhos/13-ana-erika.pdf" TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> ENSAIO REAL TRIPLEX
							PARA HBV E DENGUE, VISANDO AMPLIAÇÃO DE ALVOS DO KIT NAT HIV/HCV
							BIO-MANGUINHOS <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Antonio G.
								P. Ferreira GPRED/VDTEC/Bio-Manguinhos/Fiocruz</i> &nbsp;&nbsp;
							<a href="trabalhos/13-antonio-pinto.pdf" TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> CONSTRUÇÃO DE UM
							VETOR PARA RECOMBINAÇÃO DE INTEGRASES DO HIV-1 <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Bianca
								Duarte</i> &nbsp;&nbsp; <a href="trabalhos/13-bianca-duarte.pdf"
								TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Desafios, gargalos e
							perspectivas para o diagnóstico laboratorial das doenças
							transmissíveis no Brasil <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Claudio
								Maierovitch Pessanha Henriques Departamento de Vigilância de
								Doenças Transmissíveis</i> &nbsp;&nbsp; <a
								href="trabalhos/13-claudio-maierovitch.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> METABOLÔMICA APLICADA
							NA IDENTIFICAÇÃO DE POTENCIAIS ALVOS DE INTERVENÇÃO TERAPÊUTICA
							NAS DOENÇAS MICOBACTERIANAS <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Katherine
								Antunes de Mattos<sup>1,2</sup>, Viviane Carneiro Gonçalves
								Oliveira<sup>1</sup>, Luiz Caetano Martha Antunes<sup>³</sup>,
								Euzenir Nunes Sarno<sup>1</sup>, Patricia Torres Bozza<sup>1</sup>,
								Georgia Correa Atella<sup>4</sup> e Maria Cristina Vidal
								Pessolani<sup>1</sup>. <sup>1</sup>Instituto Oswaldo Cruz, <sup>²</sup>Instituto
								de Tecnologia em Imunobiológicos Bio-Manguinhos, <sup>³</sup>The
								University of British Columbia e <sup>4</sup>Universidade
								Federal do Rio de Janeiro.
							</i> &nbsp;&nbsp; <a href="trabalhos/13-katherine-antunes.pdf"
								TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Desafios, gargalos e
							perspectivas de desenvolvimento tecnológico e produção de
							biofármacos no Brasil <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Leonardo
								Batista Paiva Secretário-adjuntode Ciência, Tecnologiae Insumos
								Estratégicos Ministérioda Saúde</i> &nbsp;&nbsp; <a
								href="trabalhos/13-leonardo-batista.pdf" TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Desenvolvimento de
							sistema de expressão em plataforma de célula eucariota para a
							produção de anticorpos monoclonais RECOMBINANTES <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Luis Vidal
								Conde Bio-Manguinhos, Programa de Biofármacos, VDTEC/LATER</i>
							&nbsp;&nbsp; <a href="trabalhos/13-luis-vidal.pdf"
								TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> DESENVOLVIMENTO DO
							TESTE DE IMUNOFENOTIPAGEM PARA A CONTAGEM DE LINFÓCITOS TCD4+. <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Marli Sidoni
								Bio-Manguinhos/Fiocruz</i> &nbsp;&nbsp; <a
								href="trabalhos/13-marli-sidoni.pdf" TARGET="_blank">Visualizar</a>
						</div>

					</p>
				</div>
				<div id="tabulador-3">
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> New approaches for
							standardization and validation of qRT-PCR assays for quantitation
							of yellow fever on clinical samples with high quality parameters.
							<br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Alice Gomes
								Fernandes, Bio-manguinhos</i> &nbsp;&nbsp; <a
								href="trabalhos/14-alice-gomes.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> COMPARAÇÃO DE
							METODOLOGIAS DE ACOPLAMENTO UTILIZADAS NA PLATAFORMA DE
							MICROARRANJOS LÍQUIDOS <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Bernardo
								Oliveira Loureiro, Bio-Manguinhos/Fiocruz</i> &nbsp;&nbsp; <a
								href="trabalhos/14-bernardo-oliveira.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Avaliação de uma
							fração proteica de 38 a 40 kDa isolada de <i>Acinetobacter
								baumannii</i> como alvo para imunoterapia <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Lucas
								Machado, Programa de Biofármacos, Bio-manguinhos</i>
							&nbsp;&nbsp; <a href="trabalhos/14-lucas-machado.pdf"
								TARGET="_blank">Visualizar</a>
						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Purificação e
							caracterização de asparaginase de <i>Saccharomyces cerevisiae</i>
							clonada em <i>Pichia pastoris</i>: estudo de um possível fármaco
							antileucêmico <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Luciana
								Facchinetti de Castro Girão, UFRJ/ IOC/ Farmanguinhos</i>
							&nbsp;&nbsp; <a href="trabalhos/14-luciana-facchinetti.pdf"
								TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Comparação
							farmacocinética e farmacodinâmica de duas formulações de
							alfapeginterferona em voluntários sadios <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Marisa Boff
								Costa Hospital de Clínicas de Porto Alegre</i> &nbsp;&nbsp; <a
								href="trabalhos/14-marisa-boff.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Integração das
							atividades de inovação tecnológica na Fiocruz e no Brasil:
							desafios, gargalos e perspectivas <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Mitermayer
								Galvão dos Reis, Pesquisador Titular da Fundação Oswaldo Cruz,
								Bahia/ Presidente da Sociedade Brasileira de Medicina Tropical e
								Coordenador Executivo da Rede Nordeste de Biotecnologia
								(RENORBIO)</i> &nbsp;&nbsp; <a
								href="trabalhos/14-mitermayer-galvao.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Desafios para a
							Inovação Tecnológica: o Papel das Parcerias Público-Privadas <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Dr. Ogari
								Pacheco, Cristália Prod. Quim. Farm. Ltda</i> &nbsp;&nbsp; <a
								href="trabalhos/14-ogari-pacheco.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Detecção de amostras
							em períodos de janela imunobiológica com kit NAT HIV/HCV
							Bio-Manguinhos visando ampliar a segurança transfusional no
							Brasil <br />
							<br /> <span class="noticia_titulo">Autor:</span> <i>Patrícia
								Alvarez, LATED/VDTEC/Bio-Manguinhos/Fiocruz</i> &nbsp;&nbsp; <a
								href="trabalhos/14-patricia-alvarez.pdf" TARGET="_blank">Visualizar</a>

						</div>

					</p>
				</div>

			</div>
			<img src="images/tracejado.png" alt="" />
			<p class="p_text">
				<a href="controller.php?modulo=trabalho-apresentado"
					style="color: #000000;">Conteúdo das palestras de 2014</a>
			</p>

			<div class="cleardiv"></div>
		</div>
		<!-- MODULO CONTEUDO - FINAL *** //-->
	</div>
<?php include("rodape.php"); ?>
</body>
</html>