<?php
/**
* @description Arquivo de configuração.
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright Bio-Manguinhos|Fiocruz
*/
// --------------------------------------------------------------------------------------
session_start ();
date_default_timezone_set ( "Brazil/East" );

$EMP_ID = 21;
$EMP_NOME = "V International Symposium on Immunobiologicals";
$EMP_TITULO = "V International Symposium on Immunobiologicals";
$EMP_URL = "isi.bio.fiocruz.br";
$EMP_EMAIL = "sact@bio.fiocruz.br";

if (! isset ( $USO_ID ))
	$USO_ID = 0;

if (! (isset ( $MOD_CODIGO ))) {
	
	$MOD_CODIGO = "";
	$MOD_VISAO = "";
	$MOD_CHAVE = "";
	$MOD_CLASSE = "";
	$MOD_DESCRICAO = "";
	$MOD_DIREITOS = 0;
	$PAG_NUMERO = 1;
	$PAG_TAMANHO = 20;
	$PAG_TOTAL = 0;
	
	$MOD_PREFIXO = "";
}

$ARQ_PATH = '../../../arquivos/';
$ARQ_NOME = '';
$ARQ_TIPO = '';
$ARQ_FORMATO = '';

?>