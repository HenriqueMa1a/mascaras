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
<link href="shadowbox_js/shadowbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="shadowbox_js/jquery.js"></script>
<script type="text/javascript" src="shadowbox_js/shadowbox.js"></script>
<script type="text/javascript">
 Shadowbox.init({
 language: 'pt',
 player: ['img', 'html', 'swf','php','asp']
 });
</script>
</head>
<body>
<?php include("cabecalho.php"); ?>
<div id="content">
<?php
// include("quadro_menu_vertical.php");
include ("quadro_menu_vertical.php");

?>
        <div id="posts" class="post">
			<h2>Como elaborar o Resumo</h2>
			<div class="description">
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Não
					será aceita a inscrição do resumo via fax, correio, e-mail ou
					carta.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;O
					texto deverá seguir o padrão: Introdução, Objetivos, Metodologia,
					Resultados e Conclusão.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;O
					resumo é um texto de no máximo 450 palavras (sem contar título,
					autores e instituição). O sistema está programado para rejeitar o
					resumo que exceder a este limite.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;O
					título deve ser digitado em caixa baixa e negrito (Times New Roman
					- tamanho 14 ou 16), descrevendo concisamente a essência do
					assunto. – até 20 palavras.<br />Caso o título contenha algum termo
					científico, este deve estar em <i>itálico.</i>
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;A
					fonte do corpo do texto deverá ser Times New Roman  tamanho 12. Cor
					da fonte: preta.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Os
					nomes dos autores por extenso (ex: José de Souza Alves),
					instituição e texto do resumo deverão estar em caixa baixa.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;O
					nome do autor principal deverá vir, em primeiro lugar, e o nome do
					apresentador, deverá ser identificado com asterisco (*).
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Fornecer
					o e-mail do apresentador para contato na ficha de inscrição e
					abaixo do título.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;APRESENTADOR: 
					É o responsável por fazer a apresentação oral no dia do seminário
					(plenária).
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Os
					títulos e textos dos resumos devem estar alinhados à esquerda (não
					justificar).
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Usar
					espaçamento simples, margem de 2,5 cm à direita e esquerda e 2,0 cm
					superior e inferior.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;O
					resumo poderá ser digitado em inglês ou português.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;O
					resumo NÃO poderá conter figuras, gráficos ou tabelas.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Antes
					de escrever o resumo, o pesquisador deverá classificá-lo na
					categoria correspondente conforme abaixo:
				</p>
				<p align="center"">
					<br /> <a href="images/classificacao_resumo.jpg" rel="shadowbox"><img
						src="images/classificacao_resumo.jpg" width="200" height="200"
						style="cursor: pointer; border: solid 1px #000000;" /> </a>
					<!-- Duvidas Sobre shadowbox
					http://www.escolacompleta.com/desenvolvimento/jquery/efeito-light-box-utilizando-o-plugin-shadowbox
				 -->
					<br />
				</p>
				<br /> <br />
				<p class="p_text">
					<br />
					<strong>Importante: A forma do resumo é retrato (não poderá ser
						paisagem).</strong>
				</p>
				<br />
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Titulo:
					Até 20 palavras
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Autores:
					nome por extenso (inserir no máximo 7 autores, podendo
					excepcionalmente chegar até 10, desde que justificado e aceito pela
					Comissão Científica). Não colocar o título dos autores: Ex: Doutor,
					Professor, entre outros.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;O
					nome do autor principal deverá vir em primeiro lugar e o nome do
					apresentador, sinalizado com um asterisco (*) logo após.  Fornecer
					o e-mail do apresentador para contato na ficha de inscrição.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;A
					instituição deverá ser mencionada após o nome do autor, como
					exemplificado abaixo.
				</p>
				<p class="p_text">
					<input type="image" class="image_p" src="images/next.png" />&nbsp;Ao
					submeter o resumo, o autor deverá assinalar, dentre as opções
					propostas, em qual categoria seu trabalho é definido: biofármacos,
					vacinas, kits para diagnóstico ou outros temas relacionados.
				</p>
				<p class="p_text">
					<br /> <strong class="p_text">Exemplo 1: </strong> <span
						class="p_text">José Faria Gomes Pedro Moreira<sup> 1</sup>* ;
						Joaquim Silva<sup> 2</sup></span><br /> <span class="p_text">E-mail:
						jose.gomes@bio.fiocruz.br</span><br /> <span class="p_text"><sup>
							1</sup>Bio- Manguinhos  / Fiocruz </span><br /> <span
						class="p_text"><sup> 2</sup>UFRJ – Universidade  Federal  do  Rio
						de Janeiro</span><br /> <strong class="p_text">NESSE EXEMPLO,
						AUTOR E APRESENTADOR SÃO A MESMA PESSOA.</strong> <br />
					<br /> <strong class="p_text">Exemplo 2: </strong><span
						class="p_text">José Faria Gomes<sup> 1</sup>/Mauricio Ribeiro
						Pedrosa<sup> 1</sup>* ; Pedro Moreira<sup> 1</sup>; Joaquim Silva<sup>
							2</sup>;
					</span><br /> <span class="p_text">E-mail:
						mauricio.pedrosa@bio.fiocruz.br</span><br /> <span class="p_text"><sup>
							1</sup>Bio- Manguinhos / Fiocruz</span><br /> <span
						class="p_text"><sup> 2</sup>UFRJ – Universidade Federal do Rio de
						Janeiro</span><br /> <strong class="p_text">NESSE EXEMPLO, AUTOR E
						APRESENTADOR NÃO SÃO A MESMA PESSOA.</strong><br />
				</p>
			</div>
			<div class="cleardiv"></div>
		</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>