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
	<?php include("quadro_mensagem.php"); ?>
	<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Convidados e Palestrantes</h2>


			<!--<div class="div_palestrante">
		  
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/carlos-augusto-grabois-gadelha.jpg" />
				<span class="palestrante_nome">Carlos Augusto Grabois Gadelha</span><br/>
				Economista e doutor em Economia pelo Instituto de Economia da Universidade Federal do Rio de Janeiro (UFRJ), Secretário de Ciência, Tecnologia e Insumos Estratégicos do Ministério da Saúde, Coordenador do Grupo de Pesquisa sobre Complexo Industrial e Inovação em Saúde (GIS) e Coordenador geral do Mestrado Profissional em Política e Gestão de Ciência, Tecnologia e Inovação em Saúde da Ensp/Fiocruz. Exerceu o cargo de Vice-presidente de Produção e Inovação em Saúde da Fundação Oswaldo Cruz, entre 2007 e 2010.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/paulo-gadelha.jpg" />
				<span class="palestrante_nome">Paulo Gadelha</span><br/>
				Presidente da Fundação Oswaldo Cruz, doutor em Saúde Pública pela Escola Nacional de Saúde Pública (Ensp),  presidiu a Associação de Médicos Residentes do Rio de Janeiro (Amererj) e a Associação Nacional de Médicos Residentes (ANMR). Com experiência em pesquisa e docência, foi responsável pela criação da Casa de Oswaldo Cruz (COC/Fiocruz). Implementou e coordenou o Museu da Vida, de 1985 a 1997. É um dos membros da rede internacional de pesquisa para combater a falta de medicamentos eficazes para doenças como malária, leishmaniose e mal de Chagas (DND-I).
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/pedro-lins-palmeira-filho.jpg" />
				<span class="palestrante_nome">Pedro Lins Palmeira Filho</span><br/>
				Graduado em engenharia química pela UFRJ, mestre em administração pela Pontifícia Universidade Católica (PUC/Rio) e doutor em gestão e inovação tecnológica pela UFRJ. Desempenhou as funções de chefe e gerente de setor na Bayer S.A., no Brasil e na Alemanha (1983 -1998).  Desde 1998 desenvolve suas atividades profissionais no Banco Nacional de Desenvolvimento Econômico e Social (BNDES), junto ao Complexo Industrial da Saúde, tendo a função de Chefe de Departamento na área industrial no Departamento de Produtos Intermediários Químicos e Farmacêuticos.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/artur-couto.jpg" />
				<span class="palestrante_nome">Artur Couto</span><br/>
				Diretor do Instituto de Tecnologia em Imunobiológicos (Bio-Manguinhos/Fiocruz), desde maio de 2009. Possui experiência em gestão de saúde pública, e planejamento e controle de produção. Graduado em administração com especialização em planejamento, programação e controle de produção e pós-graduação em administração pública pela Fundação Getúlio Vargas (FGV), mba executivo pela COPPEAD/UFRJ e mestrado em economia pela Universidade Candido Mendes (Ucam).
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/akira-homma.jpg" />
				<span class="palestrante_nome">Akira Homma</span><br/>
				Doutor em Ciências pelo Departamento de Medicina Preventiva da Faculdade de Medicina da Universidade de São Paulo (USP), graduado em Medicina Veterinária (UFF) e em Administração de Empresas pelo Instituto de Treinamento e Desenvolvimento de Executivos (IDCE). É pós-graduado em Virologia pela Baylor College of Medicine e membro dos comitês técnicos do Programa de Imunizações (OPAS/OMS), do PNI. Foi Diretor de Bio-Manguinhos por 23 anos em dois períodos, Presidente e Vice-presidente da Fiocruz, Ex-presidente e membro do Comitê Executivo do Developing Countries Vaccine Manufacturers Network (DCVMN). Foi Assessor Regional de Biológicos para a região das Américas pela OPAS. Atualmente, é Presidente do Conselho Político e Estratégico de Bio-Manguinhos/Fiocruz e Diretor-presidente do IBMP/Paraná e membro do Comitê Técnico-Científico da Hemobrás.
				<img src="images/tracejado.png" alt="" />
			</p>			
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/reinaldo-de-menezes-martins.jpg" />
				<span class="palestrante_nome">Reinaldo de Menezes Martins</span><br/>
				É médico pediatra, chefiou o Serviço de Pediatria do Hospital da Lagoa durante 15 anos. Foi Presidente da Sociedade Brasileira de Pediatria (SBP), membro do Comitê Técnico Assessor em Imunizações do Ministério da Saúde e da Secretaria de Saúde do Rio de Janeiro e do Grupo sobre Farmacovigilância de Vacinas do Council for International Organizations of Medical Sciences (CIOMS/WHO) e do Immunization Practices Advisory Committee (IPAC/WHO). Atualmente é Consultor Científico Sênior de Bio-Manguinhos/Fiocruz.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/claudio-maierovitch-pessanha-henriques.jpg" />
				<span class="palestrante_nome">Cláudio Maierovitch P. Henriques</span><br/>
				Gestor público do Ministério do Planejamento, médico, mestre em Medicina Preventiva e Social, dirige atualmente o Departamento de Vigilância de Doenças Transmissíveis da Secretaria de Vigilância em Saúde do Ministério da Saúde, foi secretário municipal de saúde de Santos, Diretor Presidente da Anvisa e coordenou a Comissão de Incorporação de Tecnologias do Ministério da Saúde.
				<img src="images/tracejado.png" alt="" />
			</p>			
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/carla-domingues.jpg" />
				<span class="palestrante_nome">Carla Domingues</span><br/>
				Coordena o Programa do Programa Nacional de Imunizações do Ministério da Saúde (PNI), responsável pela organização da política nacional de vacinação da população brasileira, desde junho de 2011. Foi diretora adjunta do Departamento de Vigilância Epidemiológica, de 2009 a 2012. Atua na área de saúde pública, com experiência na área vigilância, imunizações e doenças transmissíveis.
				<img src="images/tracejado.png" alt=""  />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/leonardo-paiva.jpg" style="float: left;height:150px;"/>
				<span class="palestrante_nome">Leonardo Paiva</span><br/>
				Pesquisador em Tecnologia e Inovação do Instituto Nacional de Metrologia, Normalização e Qualidade Industrial – INMETRO. Atualmente é o Secretário-Adjunto da Secretaria de Ciência, Tecnologia e Insumos Estratégicos do Ministério da Saúde. Possui mestrado em Tecnologia em Imunobiológicos por Bio-Manguinhos/Fundação Oswaldo Cruz, com ênfase em análise estratégica de indústrias, atuando principalmente nos seguintes temas: Complexo Industrial da Saúde, Desenvolvimento Tecnológico e Inovação.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/pedro-barbosa.jpg" />
				<span class="palestrante_nome">Pedro Barbosa</span><br/>
				Graduado em Medicina pela Universidade do Estado do Rio de Janeiro (1979), mestre em Administração pela Fundação Getúlio Vargas (1993) e doutor em Saúde Pública pela Escola Nacional de Saúde Pública (Ensp/Fiocruz). É Tecnologista Sênior da Fiocruz, atuando como professor, pesquisador e consultor. Entre as principais áreas de interesse e atuação encontram-se: gestão hospitalar, planejamento em saúde e gestão da inovação em saúde. Também é professor e pesquisador na área de Planejamento e Gestão em Saúde, Coordenador do curso de Especialização em Gestão Hospitalar,  Coordenador de Desenvolvimento e Gestão e Vice-presidente de Gestão e Desenvolvimento Institucional.
				<img src="images/tracejado.png" alt="" />
			</p>

			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/mario-santos-moreira.jpg" width="113" />
				<span class="palestrante_nome">Mario Santos Moreira</span><br/>
				Possui graduação em Administração de Empresas pela Universidade Gama Filho (1986), Pós-graduação em Administração Pública pela FGV - EBAPE (1993), em Marketing pela UFRJ COPPEAD (1997); Mestrado em Saúde Pública pela Fundação Oswaldo Cruz (2002) e Mestrado em Gestão da Inovação e Tecnologia pela Sussex University (2005). É Analista em C&T em Saúde da Fiocruz, ocupando os cargos de vice-diretor do Instituto Carlos Chagas (Fiocruz-PR), Coordenador de Gestão do Consórcio Tecpar - Hemobrás Fiocruz e Presidente do Conselho Curador da Fundação para o Desenvolvimento Científico e Tecnológico em Saúde - Fiotec.
				<img src="images/tracejado.png" alt="" />
			</p>			
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/carlos-medicis-morel.jpg" />
				<span class="palestrante_nome">Carlos Medicis Morel</span><br/>
				Membro titular da Academia Brasileira de Ciências, é médico pela UFPE e doutor em Ciências pelo Instituto de Biofísica Carlos Chagas Filho da UFRJ. Pesquisador da Fiocruz desde 1978, foi Diretor do IOC (1985-1989) e Presidente da Fiocruz (1993-1997). Foi Diretor do Programa Especial de Pesquisa e Treinamento em Doenças Tropicais (TDR) na Organização Mundial da Saúde em Genebra (1998 -2004).  Coordena atualmente a implantação do Centro de Desenvolvimento Tecnológico em Saúde (CDTS) da Fiocruz e é professor permanente do Programa de Pós-Graduação em Políticas Públicas, Estratégias e Desenvolvimento (PPED) do Instituto de Economia da UFRJ.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/marco-aurelio-krieger.jpg" />
				<span class="palestrante_nome">Marco Aurelio Krieger</span><br/>
				Graduado em Ciências Biológicas pela Universidade Federal do Paraná (1987), mestre em Ciências Biológicas (Biofísica) pela Universidade Federal do Rio de Janeiro (1989) e doutor  em Ciências Biológicas (Biofísica) pela mesma universidade (1997). Atualmente é pesquisador Titular da Fiocruz e Bolsista de Produtividade nível 1 do CNPq. Possuí oitenta publicações plenas em revistas indexadas, sendo atualmente  vice diretor do Instituto Carlos Chagas, (Fiocruz Paraná) e  Coordenador Técnico da Planta de Produção e Desenvolvimento de Insumos Para Diagnóstico Consórcio Fiocruz/Hemobrás/Tecpar,  além de coordenar a Rede de Insumos para Diagnóstico (RID) do Programa de Desenvolvimento Tecnológico de Insumos para Saúde (PDTIS) da Fundação. Tem experiência na área de Genética, com ênfase em Parasitologia Molecular, atuando principalmente nos seguintes temas: Trypanosoma cruzi, expressão gênica, genômica funcional, diferenciação celular e utilização de técnicas de Biologia Molecular para o desenvolvimento de insumos para testes de diagnóstico.
				<img src="images/tracejado.png" alt="" />
			</p>			
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/antonio-de-padua-barbosa.jpg" />
				<span class="palestrante_nome">Antônio de Pádua Barbosa</span><br/>
				Vice-diretor de Produção de Bio-Manguinhos/Fiocruz, é engenheiro químico pela Escola de Química da Universidade Federal do Rio de Janeiro (UFRJ) e especializado em microbiologia pela Universidade de Buenos Aires e mestre em Ciências pelo Programa de Tecnologia de Processos Químicos e Bioquímicos da Escola de Química da Universidade Federal do Rio de Janeiro. Também é doutor em Gestão e Inovação Tecnológica pela mesma universidade.
				<img src="images/tracejado.png" alt="" />
			</p>			
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/marcos-da-silva- freire.jpg" />
				<span class="palestrante_nome">Marcos da Silva Freire</span><br/>
				Vice-diretor de Desenvolvimento Tecnológico de Bio-Manguinhos/Fiocruz, graduado em medicina veterinária, especializado em produção e controle da vacina contra febre aftosa no Centro Pan-Americano Febre Aftosa (1987) e propriedades do vírus do sarampo “diagnóstico e aspectos da produção da vacina”, na London School of Hygiene Tropical Medicine (1989). Também é doutor em Biologia Parasitária pelo  Instituto Oswaldo Cruz (IOC/Fiocruz). Acumula experiência de mais de 28 anos em microbiologia, com ênfase na vacinologia.
				<img src="images/tracejado.png" alt="" />
			</p>			
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/isabella-ballalai.jpg" />
				<span class="palestrante_nome">Isabella Ballalai</span><br/>
				Presidente da Sociedade Brasileira de Imunizações (Rio de Janeiro) e Diretora da Sociedade Brasileira de Imunizações. Também é membro do Departamento de Imunizações da Sociedade Brasileira de Infectologia (SBI) e membro do Comitê Técnico Assessor em Imunizações do Estado do Rio de Janeiro (CTAI/RJ).
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/ogari-de-castro-pacheco.jpg" />
				<span class="palestrante_nome">Ogari de Castro Pacheco</span><br/>
				Médico, pós graduado pela Universidade de São Paulo (1964), Diretor-presidente do laboratório Cristália Produtos Químicos Farmacêuticos Ltda., desde a sua fundação, em 1972. Atualmente, exerce o cargo de Presidente da Associação Brasileira das Indústrias de Química Fina (Abifina) e conselheiro titular do Centro das Indústrias do Estado de São Paulo (Ciesp/ Regional Campinas) desde 2007 e conselheiro consultivo da Fundação Faculdade Medicina de São Paulo (FFM) desde 2008.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/rino-rappuoli.jpg" />
				<span class="palestrante_nome">Rino Rappuoli</span><br/>
				Chefe Global de Pesquisa de Vacinas da Novartis Vaccines and Diagnostics e fica baseado em Siena, Itália. Foi chefe de P&D da Sclavo e, em seguida, Chefe de Pesquisa de Vacinas e CSO da Chiron Corporation. Várias moléculas que trabalhou, tornaram-se parte de vacinas licenciadas, como a vacina de genoma derivado contra o meningococo B, que foi recentemente recomendada pela EMA (European Medicinal Agency) para uma autorização de comercialização e aprovada pela Comissão Europeia. Em 2013, ele foi nomeado a terceira pessoa mais influente em todo o mundo no campo das vacinas.
				<img src="images/tracejado.png" alt="" />
			</p>	
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/wim-degrave.jpg" />
				<span class="palestrante_nome">Wim Degrave</span><br/>
				Graduado em Química pela Rijksuniversiteit Gent, na Bélgica (1980) e doutorado em Biologia Molecular pela mesma universidade (1985). Atualmente é pesquisador titular do Instituto Oswaldo Cruz (IOC/ Fiocruz), no Laboratório de Genômica Funcional e Bioinformática. Desde 2002 é assessor da Vice-presidência de Pesquisa e Laboratórios de Referência na Fiocruz e coordenador do Programa de Desenvolvimento de Insumos para a Saúde (PDTIS). Tem curso de especialização e mestrado em Gestão de Projetos e certificação PMP desde 2005. Possui experiência em biotecnologia, genômica aplicada de microrganismos e parasitos e bioinformática.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/amilcar-tanuri.jpg" />
				<span class="palestrante_nome">Amilcar Tanuri</span><br/>
				Médico pela Universidade Federal do Rio de Janeiro (UFRJ) em 1982, mestre em Biofísica (1985) e doutor em Genética (1990) pela mesma universidade. Atualmente é professor Titular da UFRJ e é Chefe do Laboratório de Virologia Molecular. Trabalhou como Research Fellow no Center for Disease Control (CDC) em Atlanta (2003 a 2006), dentro do Global AIDS Program (GAP) atuando no combate ao HIV/AIDS na Africa Sub-Saariana em Mocambique,Angola, Rwanda, Nigeria, Ethiopia, Botswana, Africa do Sul, Tanzania, e RDC (Congo). Em 2005,  colaborou com o governo angolano no combate à epidemia de febre hemorrágica de Marburg. Em 2006, foi convidado para assumir uma posição de Associated Research Scientist na Mailman School of Public Health (Coulmbia University) para ajudar o programa ICAP no estabelecimento de laboratórios na Africa Sub-Saariana.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/antonio-gomes-p-ferreira.jpg" />
				<span class="palestrante_nome">Antonio Gomes P. Ferreira</span><br/>
				Mestre em Tecnologia de Imunobiológicos pela Fiocruz e Tecnologista Sênior da Fundação atuando há mais de 25 anos no segmento de Reagentes para Diagnóstico Laboratorial. Atualmente, coordena o Programa de Desenvolvimento de Reativos para Diagnóstico em Bio-Manguinhos.
				<img src="images/tracejado.png" alt="" />
			</p>	
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/claude-pirmez.jpg" />
				<span class="palestrante_nome">Claude Pirmez</span><br/>
				Médica, com residência e mestrado em anatomia patológica pela Universidade Federal do Rio de Janeiro (UFRJ). Cursou doutorado em ciências biológicas na UFRJ e  parte na Universidade da Califórnia (UCLA) nos Estados Unidos, e em seguida fez estágios em Berlim e Hamburgo. Em 2008, fez um MBA Executivo no Instituto de Pós-graduação e Pesquisa em Administração da Universidade Federal do Rio de Janeiro (Coppead/UFRJ). É  pesquisadora titular na Fiocruz, tendo exercido os cargos de Chefe do Departamento de Bioquímica e Biologia Molecular (2000-2003), Vice-diretora do Instituto Oswaldo Cruz (2005-2008) e Vice-presidente de Pesquisa e Laboratórios de Referência (2009-2013).
				<img src="images/tracejado.png" alt="" />
			</p>		
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/cristina-possas.jpg" />
				<span class="palestrante_nome">Cristina Possas</span><br/>
				Doutora em Saúde Pública pela Escola Nacional de Saúde Pública (Ensp/Fiocruz) e pós-doutora pela Universidade de Harvard, onde atuou como Cientista Visitante, Takemi Fellow e Fulbright Fellow. Atualmente é Assessora Científica Sênior, membro do Conselho Político Estratégico de Bio-Manguinhos e coordenadora do Programa de Pós-Graduação Stricto Sensu em Pesquisa Clínica (Mestrado/Doutorado) pelo Instituto de Pesquisa Clínica Evandro Chagas (Ipec/Fiocruz).
				<img src="images/tracejado.png" alt="" />
			</p>		
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/ellen-jessouroun.jpg" />
				<span class="palestrante_nome">Ellen Jessouroun</span><br/>
				Bióloga com Mestrado em microbiologia e  Doutorado em Biologia Celular e Molecular. Antes de ingressar na Fiocruz,  trabalhou em Microbiologia Industrial na Industria Cervejeira,  usinas de açúcar e álcool e empresa de controle de qualidade de água.   Trabalha desde 1992 em Bio-Manguinhos em desenvolvimento tecnológico de vacinas bacterianas com foco principal em vacinas contra o meningococo. Coordena atualmente o Programa de Desenvolvimento de Vacinas Bacterianas junto a Vice-diretoria de Desenvolvimento Tecnológico de Bio-Manguinhos.
				<img src="images/tracejado.png" alt="" />
			</p>			
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/ernesto-marques.jpg" />
				<span class="palestrante_nome">Ernesto Marques</span><br/>
				Médico graduado pela Universidade Federal de Pernambuco (UFPE) em 1993 e doutor em Farmacologia e Ciências Moleculares pela The Johns Hopkins University School of Medicine em (1999). Foi Professor Assistente do Departamento de Medicina da The Johns Hopkins University School of Medicine (2005 -2009). Atualmente é Pesquisador da Fiocruz, Professor associado da University of Pittsburgh e membro do Center for Vaccine Research.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/francisco-de-paula-pinheiro.jpg" />
				<span class="palestrante_nome">Francisco de Paula Pinheiro</span><br/>
				Médico (1958) e doutor (1974) pela Universidade Federal do Pará (UFPara). Research Fellow Yale University (1961-62), Chefe da Virologia (1963-1979) e Diretor (1979-1981) do Instituto Evandro Chagas (Ipec), em Belém. Também foi  Assessor Regional em Viroses da Pan American Health Organization (PAHO), em Washington (1981-1996). Atuou como consultor regional em viroses/enfermidades infecciosas emergentes na PAHO (1997 -1999). Possui 151 publicações científicas e capítulos de livros.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/helena-keico-sato.jpg" />
				<span class="palestrante_nome">Helena Keico Sato</span><br/>
				Diretora Técnica da Divisão de Imunização do Centro de Vigilância Epidemiológica (CVE/CCD/SES-SP) e Doutora em Pediatria pelo Departamento de Pediatria da FMUSP. Também é membro da Comissão Permanente de Assessoramento em Imunizações da Secretaria Estadual de Saúde (SES/SP) e do Comitê Técnico Assessor do PNI.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/joao-b-risi-junior.jpg" />
				<span class="palestrante_nome">João B Risi Junior</span><br/>
				Médico de carreira do Ministério da Saúde, especializado em vigilância epidemiológica no Centers for Disease Control (CDC). Coordenou a Campanha de Erradicação da Varíola nos Estados do Rio de Janeiro e da Guanabara. Participou do Plano Nacional de Controle da Poliomielite e da criação do Programa Nacional de Imunizações (PNI).
				<img src="images/tracejado.png" alt="" />
			</p>			
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/marcia-arissawa.jpg" />
				<span class="palestrante_nome">Marcia Arissawa</span><br/>
				Doutorado em Química pela PUC-RJ, pós-doutorado em Modelagem Molecular no CBPF, atualmente é responsável pelo Laboratório de Tecnologia de Anticorpos Monoclonais de Bio-Manguinhos.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/maria-cristina-c-brandileone.jpg" />
				<span class="palestrante_nome">Maria Cristina C. Brandileone</span><br/>
				Pesquisadora do Núcleo de Meningites, Pneumonias e Infecções Pneumocócicas do Instituto Adolfo Lutz (NMPI/ IAL), com experiência em bacteriologia das doenças de transmissão respiratória. Doutora em Ciência na Universidade Federal de São Paulo (Unifesp), é consultora da Organização Pan-Americana de Saúde (Opas)  e Organização Mundial da Saúde (OMS), e Coordenadora de Projetos e Programas Nacionais e Internacionais. Atualmente ocupa o cargo de Diretora do Centro de Bacteriologia (NMPI/ IAL).
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/maria-sotomi.jpg" />
				<span class="palestrante_nome">Maria Sotomi</span><br/>
				Graduada em Ciências Biomédicas (1981) e Doutora pela Pós-graduação de Imunologia do Instituto de Ciências Biomédicas da USP (1991). Cursou Pós-doutorado no Instituto Pasteur, na França (1992-1994). Ingressou em 2002 como Professora Doutora pelo Departamento de Dermatologia da Faculdade de Medicina da Universidade de São Paulo (FMUPS).  
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/mitemayer-galvao.jpg" />
				<span class="palestrante_nome">Mitemayer Galvão</span><br/>
				Graduado em medicina pela Escola Baiana de Medicina e Saúde Pública (1979), mestre em Patologia Humana pela Universidade Federal da Bahia (1986) e Doutor em Patologia Humana pela Universidade Federal da Bahia (1993). Atualmente é Pesquisador titular da Fundação Oswaldo Cruz, Professor associado nível III da Universidade Federal da Bahia, Professor titular da Escola Bahiana de Medicina e Saúde Pública e Professor Visitante associado da Universidade de Yale. É Pesquisador categoria 1A do Conselho Nacional de Desenvolvimento Científico e Tecnológico  (CNPq).
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/nadia-maria-batoreu.jpg" />
				<span class="palestrante_nome">Nadia Maria Batoreu</span><br/>
				Bióloga pela Universidade Federal Fluminense (Uff), com especialização em microbiologia pela Universidade Federal do Rio de Janeiro (UFRJ), mestre em ciências pelo curso de Biologia Celular e Molecular do Instituto Oswaldo Cruz (IOC/Fiocruz) e doutoranda em Vigilância Sanitária no Instituto Nacional de Controle de Qualidade em Saúde  (INCQS/Fiocruz). É Tecnologista Sênior em Bio-Manguinhos e Gerente do Programa de Biofármacos, da Vice-diretoria de Desenvolvimento Tecnológico.
				<img src="images/tracejado.png" alt="" />
			</p>
			<p class="p_palestrante">
				<img class="img_palestrante" src="fotos/paulo-dornelles-picon.jpg" />
				<span class="palestrante_nome">Paulo Dornelles Picon</span><br/>
				Mestre e doutor em cardiologia pela UFRGS. Professor titular de Farmacologia Clínica da Universidade de Passo Fundo e Professor associado do Departamento de Medicina Interna da UFRGS. Também  é Pesquisador dos Programas de Pós-graduação em Cardiologia e Ciências Médicas da UFRGS, idealizador e Coordenador do Projeto Nacional de Protocolos Clínicos e Diretrizes Terapêuticas do Ministério da Saúde e Pesquisador Coordenador Nacional do Projeto de Pesquisa Clínica BIP48. Membro da Health Technology Assessement International (HTAi).
  		       </p></div>-->
			<!-- ************************************************************************************************ -->
			<div class="description">
				<p class="p_text">Conteúdo em Revisão.</p>
				</br>
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />
				<br />

			</div>


		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>