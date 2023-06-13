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
			<h2>Conteúdo das palestras</h2>
			<p class="p_text">
				<br />
			</p>
			<div id="tabs">
				<ul>
					<li><a href="#tabs-1">28/05/2014</a></li>
					<li><a href="#tabs-2">29/05/2014</a></li>
					<li><a href="#tabs-3">30/05/2014</a></li>
					<!--  <li><a href="ajax/content2.html">Tab 2</a></li>
				    <li><a href="ajax/content3-slow.php">Tab 3 (slow)</a></li>
				    <li><a href="ajax/content4-broken.php">Tab 4 (broken)</a></li>-->
				</ul>
				<div id="tabs-1">
					<p>
						<span class="noticia_titulo">1º período</span>
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Novas Fronteiras da
							Vacinologia <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Ralf
								Clemens, MD PhD Bill & Melinda Gates Foundation Senior Advisor
								Senior Vice President Takeda Vaccines Fiocruz</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/28/manha/Novas_Fronteiras_da_Vacinologia_Ralf_Clemens.pdf"
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
							<span class="noticia_titulo">Título:</span> Polio Eradication and
							the “Endgame” <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Ralf Clemens,
								MD PhD Bill & Melinda Gates Foundation Senior Advisor Senior
								Vice President Takeda Vaccines Fiocruz</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/28/manha/Polio_End_Game_Ralf_Clemens.pdf"
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
							<span class="noticia_titulo">Título:</span> Poliomielite -
							recomendações atuais <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Reinaldo de
								Menezes Martins Consultor Científico de Bio-Manguinhos/Fiocruz</i>
							&nbsp;&nbsp; <a
								href="trabalhos/2014/28/manha/Poliomielite_recomendacoesatuais_Reinaldo_Menezes.pdf"
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
							<span class="noticia_titulo">Título:</span> Polio end Game <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Dr. Akira
								Homma Presidente, Conselho Politico e Estratégico</i>
							&nbsp;&nbsp; <a
								href="trabalhos/2014/28/manha/Polio_End_Game_Akira_Homma.pdf"
								TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<span class="noticia_titulo">2º período</span>
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span> Avaliação da
							imunogenicidade do componente caxumba da vacina tríplice viral na
							rotina do Programa Nacional de Imunizações <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Eliane Matos
								dos Santos, Bio-Manguinhos Presidente, Conselho Politico e
								Estratégico</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/28/tarde/Eliane_Matos_dos_Santos_.pdf"
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
							<span class="noticia_titulo">Título:</span> Duração da Imunidade
							Pós-vacinação contra Febre Amarela em Adultos <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Maria de
								Lourdes Sousa Maia, Bio-Manguinhos</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/28/tarde/Maria_de_Lourdes_de_Sousa_Maia.pdf"
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
							<span class="noticia_titulo">Título:</span> Epidemiology of group
							a rotavirus diarrhea in the context of universal Monovalent
							(G1p[8]) Vaccination in Brazil <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Eduardo de
								Mello Volotão*, Filipe Anibal Carvalho-Costa, Mariela Martínez
								Gómez, Marcelle Figueira Marques da Silva, Tatiana Lundgren
								Rose, Rosane Maria S. de Assis, Alexandre Madi Fialho, José
								Paulo Gagliardi Leite. Laboratório de Virologia Comparada e
								Ambiental, Instituto Oswaldo Cruz – Fiocruz / Rio de Janeiro </i>
							&nbsp;&nbsp; <a
								href="trabalhos/2014/28/tarde/Eduardo_de_Mello.pdf"
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
							<span class="noticia_titulo">Título:</span> Elaboração de
							Materiais de Referência in house para Vacina de Haemophilus
							influenzae tipo b e seus Produtos Intermediários <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Elô de
								Oliveira Rodrigues , ENSP. Jéssica Yukie dos Reis Nagashima,
								Bio-Manguinhos </i> &nbsp;&nbsp; <a
								href="trabalhos/2014/28/tarde/Elo_de_Oliveira_Rodrigues.pdf"
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
							<span class="noticia_titulo">Título:</span> CONSTELAÇÃO GÊNICA
							DOS GENÓTIPOS: Wa-like/DS-1-like/AU-1-like, DE ROTAVIRUS DO GRUPO
							A ANTES E APÓS A INTRODUÇÃO DA VACINA MONOVALENTE (G1P[8]) NO
							BRASIL <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Tatiana
								Lundgren Rose, Mariela Martínez Gómez, Filipe Anibal
								Carvalho-Costa, Eduardo de Mello Volotão, Marcelle Figueira
								Marques da Silva, Hugo Reis Resque, Alexandre Madi Fialho,
								Rosane Maria Santos de Assis, José Paulo Gagliardi Leite
								Laboratório de Virologia Comparada e Ambiental – IOC/Fiocruz </i>
							&nbsp;&nbsp; <a
								href="trabalhos/2014/28/tarde/Tatiana_Lundgren_Rose.pdf"
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
							<span class="noticia_titulo">Título:</span>Cost Comparison: From
							Pilot to Large Scale Manufacturing of the Brazilian Meningococcal
							C Conjugate Vaccine <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Renata Chagas
								Bastos, Bio-Manguinhos / Fiocruz - LAMAM – Laboratório de
								Macromoléculas </i> &nbsp;&nbsp; <a
								href="trabalhos/2014/28/tarde/Renata_Chagas_Bastos.pdf"
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
							<span class="noticia_titulo">Título:</span>Desenvolvimento e
							Validação do método de determinação de Fósforo no Polissacarídeo
							Meningocócico A (PSA) e no Polirribosil Ribitol Fosfato (PRRP)
							POR ICP-OES <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Lauro de
								Sena Laurentino - SEAPQ - LAFIQ - DEQUA - Bio-Manguinhos.
								Cláudio Dutra de Figueira - SEPFI – LAFIQ –DEQUA -
								Bio-Manguinhos</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/28/tarde/Lauro_Oliveira_Rodrigues.pdf"
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
							<span class="noticia_titulo">Título:</span>Vacina Febre Amarela
							de Subunidade em Plataforma Vegetal: imunogenicidade e proteção
							de camundongos contra desafio <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Rosane Cuber
								Guimarães, LATEV - Bio-Manguinhos / FIOCRUZ</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/28/tarde/Rosane_Cuber_Guimaraes.pdf"
								TARGET="_blank">Visualizar</a>
						</div>

					</p>
				</div>
				<div id="tabs-2">
					<p>
						<span class="noticia_titulo">1º período</span>
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span>Desenvolvimento
							Tecnológico, produção e suprimento de kits nacionais no Brasil:
							Lições aprendidas na implantação do NAT. <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Guilherme
								Genovez</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/manha/Producao_suprimento_kits_nacionais_Guilherme_Genovez.pdf"
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
							<span class="noticia_titulo">Título:</span>Desafios, estratégias
							e perspectivas para o PDP e mercado de reativos para diagnóstico
							laboratorial no Brasil <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Octavio
								Fernandes</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/manha/Desafios_reativos_diagnostico_Octavio_Fernandes.pdf"
								TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<span class="noticia_titulo">2º período</span>
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span>EFFECT OF ZINC ON THE
							STRUCTURAL STABILITY OF PNEUMOCOCCAL SURFACE ANTIGEN A (PsaA) <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>
								IzabellaButyda Silva Corrêa, VDTEC, LAMAM
								-Bio-Manguinhos-FIOCRUZ</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/tarde/Effect_of_Zinc_Izabella_Buty.pdf"
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
							<span class="noticia_titulo">Título:</span>INCORPORAÇÃO DO ALVO
							HBV NO KIT NAT BRASILEIRO PRODUZIDO POR BIO-MANGUINHOS <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Marcela
								Fontana do Carmo Machado Maurell Bio-Manguinhos/FIOCRUZ</i>
							&nbsp;&nbsp; <a
								href="trabalhos/2014/29/tarde/Incorporacao_alvo_HBV_Marcela_Fontana.pdf"
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
							<span class="noticia_titulo">Título:</span>Determinação e
							Comparação dos Pontos de Corte Ideais de Duas Metodologias para o
							Micro PRNT de Sarampo <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Marisol
								Simões, LATEV, Bio-Manguinhos</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/tarde/Micro_PRNT_de_Sarampo_Marisol_Simoes_.pdf"
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
							<span class="noticia_titulo">Título:</span>COMPARATIVE STUDY OF
							PHYSICO-CHEMICAL AND IMMUNOLOGICAL PROPERTIES OF THE MONOCLONAL
							ANTI-CD4 PRODUCED BY BIOREACTOR AND MURINE SOURCES <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Priscila
								Muniz da Paz, Laboratório de Macromoléculas/LAMAM
								Vice-diretoriade Desenvolvimento Tecnológico/VDTEC
								Bio-Manguinhos/ FIOCRUZ</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/tarde/Monoclonal_anti_CD4_Priscila_Paz.pdf"
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
							<span class="noticia_titulo">Título:</span>Plataforma Alternativa
							e Flexível para o Kit NAT Brasileiro <br />
							<br /> <span class="noticia_titulo">Autor:</span><i> Elisabete
								Ferreira de Andrade Bio-Manguinhos/FIOCRUZ</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/tarde/Plataforma_Alternativa_Flexivel_ KitNAT_Brasileiro_Elisabete_Andrade.pdf"
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
							<span class="noticia_titulo">Título:</span>Desenvolvimento de
							Estratégias para o Aperfeiçoamento da Produção do Conjugado
							Anti-IgGCanina/PeroxidaseUtilizado no Kit EIE/LVC <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>
								EdinéaPastroMendes Seção de Insumos, Conjugados e Apoio
								Departamento de Reativos para Diagnóstico Bio-Manguinhos,
								Fundação Oswaldo Cruz</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/tarde/Producao_Conjugado_Anti-IgG_Canina_Peroxidase_Edinea_Prado.pdf"
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
							<span class="noticia_titulo">Título:</span>Schistosoma mansoni
							antigens recognized by serological-proteomic approach as
							potentially able to distinguish the clinical status of endemic
							area residents <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Fernanda
								Ludolf Ribeiro, MSc / PhD Laboratório de Parasitologia Celular e
								Molecular Grupo de Genômica e Biologia Computacional Centro de
								Pesquisas René Rachou (CPqRR) - Fiocruz</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/tarde/Schistosoma_mansoni_antigens_ re_Fernanda_Ludolf.pdf"
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
							<span class="noticia_titulo">Título:</span>TESTE DE QUANTIFICAÇÃO
							DE CV HCV DESENVOLVIDO EM BIO-MANGUINHOS: AVALIAÇÃO DE DESEMPENHO
							FRENTE A AMOSTRAS DE PACIENTES EM TRATAMENTO COM ALFA
							PEG-INTERFERONA <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Daniele Ramos
								Rocha Bio-Manguinhos/Fiocruz</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/29/tarde/Teste_de_quantificacao_CV_HCV_.pdf"
								TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
				</div>
				<div id="tabs-3">
					<p>
						<span class="noticia_titulo">1º período</span>
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span>Desenvolvimento de
							Biofármacos para área de oncologia no Brasil: avanços da
							biotecnologia <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Martin
								Bonamino</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/30/manha/Desenvolvimento_Biofarmacos_Oncologia_Martin_ Bonamino.pdf"
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
							<span class="noticia_titulo">Título:</span>Desafios, Estratégias
							e Perspectivas para PDP & Mercado de Biofármacos no Brasil <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Ogari Pacheco</i>
							&nbsp;&nbsp; <a
								href="trabalhos/2014/30/manha/PDP_Biofarmacos_Brasil_Ogari_Pacheco.pdf"
								TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<span class="noticia_titulo">2º período</span>
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span>Clonagem e expressão
							em alta escala de transportadores ABC humanos em sistema
							Baculovírus/Célula de Inseto customizado para cristalografia de
							raio X <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Rafael O.
								Resende, Bio-Manguinhos/Fiocruz</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/30/tarde/Clonagem_Rafael_Resende.pdf"
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
							<span class="noticia_titulo">Título:</span>Complementarity
							Determining Regions(CDR)identification in monoclonal antibodies
							gene sequences <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Alexandre
								Bezerra Conde Figueiredo; Carlos Otavio Alves Viana; Márcia
								Arissawa - Laboratório de Tecnologia de Anticorpos Monoclonais
								-Bio-Manguinhos / FIOCRUZ. Laboratório de Tecnologia
								Recombinante -Bio-Manguinhos / FIOCRUZ</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/30/tarde/Complementarity_Determining Regions_AlexandreBezerra.pdf"
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
							<span class="noticia_titulo">Título:</span> Avaliação da
							expressão gênica de citocinas e polimorfismo da IL-28B em
							voluntários sadios após administração de IFN-a peguilado <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Andrea
								Marques Vieira da Silva, Bio-Manguinhos/ FIOCRUZ</i>
							&nbsp;&nbsp; <a
								href="trabalhos/2014/30/tarde/II_Seminario_ANDREA_MARQUES_.pdf"
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
							<span class="noticia_titulo">Título:</span> Análise da marcação
							do Anticorpo Monoclonal anti-PBP2a com 99m Tc para diagnóstico de
							Staphylococcus aureus resistente à meticilina (MRSA) <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Jânio da
								Silva</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/30/tarde/janio_da_silva.pdf"
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
							<span class="noticia_titulo">Título:</span> Proposta de um
							sistema integrado de identificação e investigação de
							micro-organismos no Controle de Qualidade em Indústrias
							Farmacêuticas <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Luciane
								Medeiros, Bio-Manguinhos/FIOCRUZ</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/30/tarde/Luciane_Martins.pdf"
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
							<span class="noticia_titulo">Título:</span>Investigação dos
							mecanismos moleculares pelos quais o PCA3 modula a sobrevivência
							de células de câncer de próstata. <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Ana Emília
								Goulart, LATER/ PBIO Bio-manguinhos/ FIOCRUZ</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/30/tarde/SACT_Bio_2014_Ana_Emilia_Goulart.pdf"
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
							<span class="noticia_titulo">Título:</span>Clonagem e expressão
							do hormônio do crescimento humano (hGH) em E. coli. <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Thiago Santos
								Chaves</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/30/tarde/SACT_Thiago.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>
					<p>
						<div class="post-content-image">
							<img class="img_palestrante" height="70px;"
								src="images/trabalhos-seminario.jpg">
						
						</div>
						<div class="post-info">
							<span class="noticia_titulo">Título:</span>Pesquisa e
							Desenvolvimento de Formulações Para Proteção de Protoxinas de
							Bacillus e Outras Bactérias Esporuladas <br />
							<br /> <span class="noticia_titulo">Autor:</span><i>Vera Cristina
								Pessoa de Lima</i> &nbsp;&nbsp; <a
								href="trabalhos/2014/30/tarde/Vera_Cristina.pdf" TARGET="_blank">Visualizar</a>

						</div>
						<img src="images/tracejado.png" alt="" />
					</p>

				</div>
			</div>
			<img src="images/tracejado.png" alt="" />
			<p class="p_text">
				<a href="controller.php?modulo=trabalho-apresentado_2013"
					style="color: #000000;">Conteúdo das palestras de 2013</a>
			</p>

			<div class="cleardiv"></div>
		</div>
		<!-- MODULO CONTEUDO - FINAL *** //-->
	</div>
<?php include("rodape.php"); ?>
</body>
</html>