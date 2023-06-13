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
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<h2>Clipping</h2>
			<div class="description">
				<p class="p_text">Confira todas as matérias que repercutiram na
					mídia sobre o II Sact:</p>
				<p class="p_text">
					<table cellpadding="10" cellspacing="5" border="0" width="100%">
						<tr>
							<td><a
								href="http://www.brasil.gov.br/ciencia-e-tecnologia/2014/04/seminario-de-c-t-em-imunobiologicos-recebe-inscricoes/"
								target="_blank" style="cursor: pointer; color: #000000;">Portal
									Brasil </a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.unasus.gov.br/noticia/abertas-inscricoes-para-o-ii-seminario-anual-cientifico-e-tecnologico-em-imunobiologicos"
								target="_blank" style="cursor: pointer; color: #000000;">UNA-SUS
							</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.protec.org.br/noticias/pagina/31098/II-Seminario-Cientifico-e-Tecnologico-de-Bio-ManguinhosFiocruz-reune-especialistas-e-jovens-talentos"
								target="_blank" style="cursor: pointer; color: #000000;">Protec</a>
							</td>
						</tr>
						<tr>
							<td><a
								href="http://protec.org.br/farmacos-e-medicamentos/31132/ii-seminario-cientifico-e-tecnologico-de-bio-manguinhosfiocruz-reune-especialistas-e-jovens-talentos"
								target="_blank" style="cursor: pointer; color: #000000;">Protec
									(Pós-evento)</a></td>
						</tr>
						<tr>
							<td><a
								href="https://portal.fiocruz.br/pt-br/content/seminario-na-fundacao-aborda-tecnologia-em-imunobiologicos"
								target="_blank" style="cursor: pointer; color: #000000;">Fiocruz</a>
							</td>
						</tr>
						<tr>
							<td><a
								href="https://portal.fiocruz.br/pt-br/content/submissao-de-resumos-para-o-ii-seminario-em-imunobiologicos-segue-ate-254"
								target="_blank" style="cursor: pointer; color: #000000;">Fiocruz
									(prorrogação de submissão de resumos)</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.canal.fiocruz.br/video/index.php?v=Jornal-da-Saude-30052014-JDS-0729"
								target="_blank" style="cursor: pointer; color: #000000;">Canal
									Saúde</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.cnpq.br/web/guest/eventos?p_p_id=8&p_p_lifecycle=0&p_p_state=normal&p_p_mode=view&_8_struts_action=%2Fcalendar%2Fview_event&_8_eventId=1786171"
								target="_blank" style="cursor: pointer; color: #000000;">CNPq</a>
							</td>
						</tr>
						<tr>
							<td><a
								href="http://www.fiotec.fiocruz.br/institucional/index.php?option=com_content&view=article&id=2084:inscricoes-abertas-para-o-ii-seminario-anual-cientifico-e-tecnologico-em-imunobiologicos&catid=216:noticias2&Itemid=116&lang=pt"
								target="_blank" style="cursor: pointer; color: #000000;">Fiotec</a>
							</td>
						</tr>
						<tr>
							<td><a
								href="http://www.jornalbrasil.com.br/?pg=desc-noticias&id=119778&nome=Semin%E1rio%20na%20Funda%E7%E3o%20vai%20abordar%20tecnologia%20em%20imunobiol%F3gicos"
								target="_blank" style="cursor: pointer; color: #000000;">Jornal
									Brasil</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.jornalbrasil.com.br/?pg=desc-noticias&id=130735&nome=Submiss%E3o%20de%20resumos%20para%20o%20II%20Semin%E1rio%20em%20Imunobiol%F3gicos%20segue%20at%E9%2025/4"
								target="_blank" style="cursor: pointer; color: #000000;">Jornal
									Brasil (prorrogação de submissão de resumos)</a></td>
						</tr>
						<tr>
							<td><a
								href="http://spdbcfmusp.wordpress.com/2014/02/11/seminario-anual-cientifico-e-tecnologico-em-imunobiologicos/"
								target="_blank" style="cursor: pointer; color: #000000;">SPD
									FMUSP</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.labnetwork.com.br/2o-seminario-anual-cientifico-e-tecnologico-em-imunobiologicos/"
								target="_blank" style="cursor: pointer; color: #000000;">Lab
									Network</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.crf-rj.org.br/crf/noticia/4262/ii-seminaacuterio-anual-cientifico-e-tecnologico-em-imunobiologicos-acontece-em-maio.htm"
								target="_blank" style="cursor: pointer; color: #000000;">CRF-RJ</a>
							</td>
						</tr>
						<tr>
							<td><a
								href="http://www.eventos.ufrj.br/?event=ii-seminario-anual-cientifico-e-tecnologico-em-imunobiologicos-sactbio"
								target="_blank" style="cursor: pointer; color: #000000;">Eventos
									UFRJ</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.faperj.br/boletim_interna.phtml?obj_id=9843"
								target="_blank" style="cursor: pointer; color: #000000;">Faperj</a>
							</td>
						</tr>
						<tr>
							<td><a
								href="http://www.fjmontello.com.br/inscricoes-abertas-para-o-ii-seminario-anual-cientifico-e-tecnologico-em-imunobiologicos/"
								target="_blank" style="cursor: pointer; color: #000000;">Fundação
									Josué Montello</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.renastonline.org/aggregator/categories/1?page=3"
								target="_blank" style="cursor: pointer; color: #000000;">RenastOnline</a>
							</td>
						</tr>
						<tr>
							<td><a
								href="http://www.uezo.rj.gov.br/mais_noticias/2014/mar%C3%A7o/Seminario-bio-manguinhos-inscricoes-abertas.html"
								target="_blank" style="cursor: pointer; color: #000000;">Governo
									do Rio de Janeiro - Secretaria de Ciência e Tecnologia</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.passeiaki.com/noticias/seminario-c-t-imunobiologicos-recebe-inscricoes"
								target="_blank" style="cursor: pointer; color: #000000;">Passei
									Aki</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.revistafatorbrasil.com.br/ver_noticia.php?not=268162"
								target="_blank" style="cursor: pointer; color: #000000;">Revista
									Fator Brasil</a></td>
						</tr>
						<tr>
							<td><a
								href="http://www.ipd-farma.org.br/noticias/pagina/675/II-Seminario-Cientifico-e-Tecnologico-de-Bio-ManguinhosFiocruz-reune-especialistas-e-jovens-talentos"
								target="_blank" style="cursor: pointer; color: #000000;">IPD
									Farma</a></td>
						</tr>




					</table>


				</p>

			</div>
			<div class="cleardiv"></div>
			<!-- MODULO CONTEUDO - FINAL *** //-->
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>