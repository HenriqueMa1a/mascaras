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
// include_once('javascripts.php');

include_once ('jquery.php');
if (file_exists ( 'modulos/' . $MOD_CLASSE . '.js.php' ))
	include_once ('modulos/' . $MOD_CLASSE . '.js.php');
?> 
	<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/jquery.ease.js"></script>
<script type="text/javascript" src="js/jcarousellite_1.0.2.min.js"></script>
<script type="text/javascript" src="js/carrossel.js"></script>

</head>
<body>
<?php include("cabecalho.php"); ?>
<div id="content">
<?php
// include("quadro_menu_vertical.php");
include ("quadro_menu_vertical.php");

?>
        <div id="posts" class="post">
			<h2>Programação</h2>
			<div class="description">
				<p class="p_text">
					<div id="thumbImagens">
						<ul>
							<li><a rel="img/001.jpg">28/05</a></li>
							<li><a rel="img/002.jpg">29/05</a></li>
							<li><a rel="img/003.jpg">30/05</a></li>
						</ul>
					</div>
					<div class="img-grande">
						<img src="img/001.jpg" />
						<!--  <a href="img/001.jpg" class="abre-foto">
				        <img src="img/001.jpg" />
				    </a>-->
					</div>

				</p>
			</div>
			<h2>Convidados e palestrantes</h2>
			<div style="display: none;">
				<a href="#" class="prev"><img src="img/anterior.png" border="0" /></a>
			</div>

			<div id="carrossel" class="carousel imageSliderExt"
				style="float: left; width: 577px; padding-top: 15px;">
				<div id="areaConvidados">
					<img class="1" src="images/convidados/carlos_augusto.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 1" />
					<img class="2" src="images/convidados/paulo_gadelha.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 2" />
					<img class="3" src="images/convidados/artur_couto.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 3" />
					<img class="4" src="images/convidados/akira_homma.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 4" />
					<img class="5" src="images/convidados/reinaldo_menezes.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 5" />
					<img class="6" src="images/convidados/maria_luz.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 6" />
					<img class="7" src="images/convidados/antonio_padua.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 7" />
					<img class="8" src="images/convidados/marcos_silva.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 8" />
					<img class="9" src="images/convidados/ciro_quadros.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 9" />
					<img class="10" src="images/convidados/ralf_clemens.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 10" />
					<img class="11" src="images/convidados/octavio_fernandes.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 11" />
					<img class="12" src="images/convidados/ogari_castro.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 12" />
					<img class="13" src="images/convidados/guilherme_genovez.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 13" />
					<img class="14" src="images/convidados/martin_bonamino.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 13" />
					<img class="15" src="images/convidados/paulo_dornelles.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 14" />
					<img class="16" src="images/convidados/antonio_gomes.png"
						style="cursor: pointer; width: 64px; height: 64px;" alt="Foto 15" />
				</div>
				<br />

				<ul>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/carlos_augusto.png"
									style="width: 135px; height: 126px;" alt="Foto 1" /></td>
								<td><label class="nomeConvidado">Carlos Augusto Grabois Gadelha</label>
									<br /> Economista e doutor em Economia pelo Instituto de
									Economia da Universidade Federal do Rio de Janeiro (UFRJ),
									Secretário de Ciência, Tecnologia e Insumos Estratégicos do
									Ministério da Saúde, Coordenador do Grupo de Pesquisa sobre
									Complexo Industrial e Inovação em Saúde (GIS) e Coordenador
									geral do Mestrado Profissional em Política e Gestão de Ciência,
									Tecnologia e Inovação em Saúde da Ensp/Fiocruz. Exerceu o cargo
									de Vice-presidente de Produção e Inovação em Saúde da Fundação
									Oswaldo Cruz, entre 2007 e 2010.<br />
								<br />
								<br />
								<br /></td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/paulo_gadelha.png"
									style="width: 136px; height: 126px;" alt="Foto 2" /></td>
								<td><label class="nomeConvidado">Paulo Gadelha</label><br />
									Presidente da Fundação Oswaldo Cruz, doutor em Saúde Pública
									pela Escola Nacional de Saúde Pública (Ensp), presidiu a
									Associação de Médicos Residentes do Rio de Janeiro (Amererj) e
									a Associação Nacional de Médicos Residentes (ANMR). Com
									experiência em pesquisa e docência, foi responsável pela
									criação da Casa de Oswaldo Cruz (COC/Fiocruz). Implementou e
									coordenou o Museu da Vida, de 1985 a 1997. É um dos membros da
									rede internacional de pesquisa para combater a falta de
									medicamentos eficazes para doenças como malária, leishmaniose e
									mal de Chagas (DND-I).</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/artur_couto.png"
									style="width: 137px; height: 126px;" alt="Foto 3" /></td>
								<td><label class="nomeConvidado">Artur Couto</label><br />
									Diretor do Instituto de Tecnologia em Imunobiológicos
									(Bio-Manguinhos/Fiocruz), desde maio de 2009. Possui
									experiência em gestão de saúde pública, e planejamento e
									controle de produção. Graduado em administração com
									especialização em planejamento, programação e controle de
									produção e pós-graduação em administração pública pela Fundação
									Getúlio Vargas (FGV), mba executivo pela COPPEAD/UFRJ e
									mestrado em economia pela Universidade Candido Mendes (Ucam).</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/akira_homma.png"
									style="width: 135px; height: 125px;" alt="Foto 4" /></td>
								<td><label class="nomeConvidado">Akira Homma</label><br />
									Doutor em Ciências pelo Departamento de Medicina Preventiva da
									Faculdade de Medicina da Universidade de São Paulo (USP),
									graduado em Medicina Veterinária (UFF) e em Administração de
									Empresas pelo Instituto de Treinamento e Desenvolvimento de
									Executivos (IDCE). É pós-graduado em Virologia pela Baylor
									College of Medicine e membro dos comitês técnicos do Programa
									de Imunizações (OPAS/OMS), do PNI. Foi Diretor de Bio-
									Manguinhos por 23 anos em dois períodos, Presidente e
									Vice-presidente da Fiocruz, Ex-presidente e membro do Comitê
									Executivo do Developing Countries Vaccine Manufacturers Network
									(DCVMN). Foi Assessor Regional de Biológicos para a região das
									Américas pela OPAS. Atualmente, é Presidente do Conselho
									Político e Estratégico de Bio-Manguinhos/ Fiocruz e
									Diretor-presidente do IBMP/Paraná e membro do Comitê
									Técnico-Científico da Hemobrás.</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img
									src="images/convidados/reinaldo_menezes.png"
									style="width: 135px; height: 127px;" alt="Foto 5" /></td>
								<td><label class="nomeConvidado">Reinaldo de Menezes Martins</label><br />
									É médico pediatra, chefiou o Serviço de Pediatria do Hospital
									da Lagoa durante 15 anos. Foi Presidente da Sociedade
									Brasileira de Pediatria (SBP), membro do Comitê Técnico
									Assessor em Imunizações do Ministério da Saúde e da Secretaria
									de Saúde do Rio de Janeiro e do Grupo sobre Farmacovigilância
									de Vacinas do Council for International Organizations of
									Medical Sciences (CIOMS/WHO) e do Immunization Practices
									Advisory Committee (IPAC/WHO). Atualmente é Consultor
									Científico Sênior de Bio-Manguinhos/Fiocruz.</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/maria_luz.png"
									style="width: 134px; height: 125px;" alt="Foto 6" /></td>
								<td><label class="nomeConvidado">Maria da Luz F. Leal</label><br />
									Mestre em Gestão de Ciência e Tecnologia em Saúde pela Fundação
									Oswaldo Cruz, vice-diretora de Qualidade de Bio-Manguinhos.
									Ex-diretora (1997 a 1999), vice-diretora de Produção
									(1999-2006) e gerente de produção de vacinas (1989 a 1997) de
									Bio-Manguinhos. Possui especializações pelo Instituto de
									Pesquisa de Poliomielite do Japão (JPRI, na sigla em inglês) e
									pela Merck Sharp Dhome Research Laboratories).</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/antonio_padua.png"
									style="width: 137px; height: 127px;" alt="Foto 7" /></td>
								<td><label class="nomeConvidado">Antônio de Pádua Barbosa</label><br />
									Vice-diretor de Produção de Bio-Manguinhos/Fiocruz, é
									engenheiro químico pela Escola de Química da Universidade
									Federal do Rio de Janeiro (UFRJ) e especializado em
									microbiologia pela Universidade de Buenos Aires e mestre em
									Ciências pelo Programa de Tecnologia de Processos Químicos e
									Bioquímicos da Escola de Química da Universidade Federal do Rio
									de Janeiro. Também é doutor em Gestão e Inovação Tecnológica
									pela mesma universidade.</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/marcos_silva.png"
									style="width: 137px; height: 127px;" alt="Foto 8" /></td>
								<td><label class="nomeConvidado">Marcos da Silva Freire</label><br />
									Vice-diretor de Desenvolvimento Tecnológico de
									Bio-Manguinhos/Fiocruz, graduado em medicina veterinária,
									especializado em produção e controle da vacina contra febre
									aftosa no Centro Pan-Americano Febre Aftosa (1987) e
									propriedades do vírus do sarampo “diagnóstico e aspectos da
									produção da vacina”, na London School of Hygiene Tropical
									Medicine (1989). Também é doutor em Biologia Parasitária pelo
									Instituto Oswaldo Cruz (IOC/Fiocruz). Acumula experiência de
									mais de 28 anos em microbiologia, com ênfase na vacinologia.</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/ciro_quadros.png"
									style="width: 137px; height: 127px;" alt="Foto 9" /></td>
								<td><label class="nomeConvidado">Ciro de Quadros</label><br />
									Médico, vice-presidente Executivo do Instituto Sabin.
									Ex-epidemiologista-chefe do Programa de Erradicação da Varíola
									da Organização Mundial da Saúde (OMS) e ex-diretor do
									Departamento de Vacinas da Organização Pan-Americana da Saúde
									(Opas). Participou do lançamento dos programas de erradicação
									da poliomielite, do sarampo e da rubéola nas Américas.</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/ralf_clemens.png"
									style="width: 135px; height: 127px;" alt="Foto 10" /></td>
								<td><label class="nomeConvidado">Ralf Clemens</label><br />
									Pós-Doutor em Medicina, vice-presidente Sênior da Takeda
									Vaccines, conselheiro independente da Fundação Bill & Melinda
									Gates. Liderou o desenvolvimento global de mais de 25 vacinas
									na GSK e Novartis. Foi membro do International Vaccine
									Institute</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img
									src="images/convidados/octavio_fernandes.png"
									style="width: 135px; height: 125px;" alt="Foto 11" /></td>
								<td><label class="nomeConvidado">Octavio Fernandes</label><br />
									Pós-doutor em Gestão de Projetos na International Atomoc Energy
									Agency (ONU, Viena), vice-presidente de Operações da
									Diagnósticos da América S/A (DASA).</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/ogari_castro.png"
									style="width: 135px; height: 127px;" alt="Foto 12" /></td>
								<td><label class="nomeConvidado">Ogari de Castro Pacheco</label><br />
									Médico pós-graduado pela Universidade de São Paulo (USP),
									preside o laboratório Cristália. Conselheiro Titular do CIESP
									(Reg. Campinas) desde 2007 e Conselheiro Consultivo da Fundação
									Faculdade Medicina de São Paulo desde 2008, é presidente da
									Abifina.</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img
									src="images/convidados/guilherme_genovez.png"
									style="width: 137px; height: 125px;" alt="Foto 13" /></td>
								<td><label class="nomeConvidado">Guilherme Genovez</label><br />
									Hematologista e Hemoterapeuta, diretor do Centro de Hemoterapia
									e Hematologia de Stª Catarina, HEMOSC e ex-diretor da Hemorrede
									de Santa Catarina (2003-2007). Membro do Grupo de
									Assessoramento Técnico no desenvolvimento do teste NAT no
									Brasil, implantou o Programa Nacional de Qualidade na Hemorrede
									e o NAT na Hemorrede Pública Nacional.</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img
									src="images/convidados/martin_bonamino.png"
									style="width: 138px; height: 127px;" alt="Foto 13" /></td>
								<td><label class="nomeConvidado">Martin Bonamino</label><br />
									Biomédico e doutor em Química Biológica pelo Instituto de
									Bioquímica Médica da Universidade Federal do Rio de Janeiro
									(UFRJ), desenvolve projetos em Imunoterapia do Câncer, Terapia
									Gênica e Diagnóstico Molecular. Pesquisador do Instituto
									Nacional do Câncer (Inca).</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img
									src="images/convidados/paulo_dornelles.png"
									style="width: 137px; height: 125px;" alt="Foto 14" /></td>
								<td><label class="nomeConvidado">Paulo Dornelles Picon</label><br />
									Doutor em Cardiologia pela Universidade Federal do Rio Grande
									do Sul (UFRGS), pesquisador dos Programas de Pós Graduação em
									Cardiologia e Ciências Médicas da UFRGS. Coordenador do Núcleo
									de Investigação Clínica em Medicamentos(NUCLIMED) e da Comissão
									de Medicamentos Excepcionais e de Fontes Limitadas (COMEX) do
									HCPA, Coordenador Nacional do Projeto de Pesquisa Clínica BIP48
									de Bio-Manguinhos/Fiocruz e membro do Health Technology
									Assessement International (HTAi).</td>
							</tr>
						</table>
					</li>
					<li>
						<table cellpadding="5" cellspacing="10" border="0">
							<tr>
								<td valign="top"><img src="images/convidados/antonio_gomes.png"
									style="width: 136px; height: 126px;" alt="Foto 15" /></td>
								<td><label class="nomeConvidado">Antonio Gomes P. Ferreira</label><br />
									Mestre em Tecnologia de Imunobiológicos pela Fiocruz e
									Tecnologista Sênior da Fundação atuando há mais de 25 anos no
									segmento de Reagentes para Diagnóstico Laboratorial.
									Atualmente, coordena o Programa de Desenvolvimento de Reativos
									para Diagnóstico em Bio-Manguinhos.</td>
							</tr>
						</table>
					</li>
				</ul>
			</div>
			<div style="display: none;">
				<a href="#" class="next"><img src="img/proximo.png" border="0" /></a>

			</div>

		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>