<?php
require_once ('../admin/includes/global.php');
require_once ('../admin/funcoes/Formatacao.class.php');

require_once ('../admin/modelo/ModuloDAO.class.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 152;
$response->mensagem = utf8_encode ( "inicio do processamento." );

$response->page = 0;
$response->total = 0;
$response->records = 0;

// IsOnLine();

// echo "B[SERVER['REQUEST_METHOD']:".$_SERVER['REQUEST_METHOD']."]<br/>";

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	// echo "[_GET['acao']:".$_GET['acao']."]";
	isset ( $_GET ['operacao'] ) ? $operacao = $_GET ['operacao'] : $operacao = '';
	isset ( $_GET ['acao'] ) ? $acao = $_GET ['acao'] : $acao = '';
	isset ( $_GET ['page'] ) ? $page = $_GET ['page'] : $page = '';
	isset ( $_GET ['rows'] ) ? $rows = $_GET ['rows'] : $rows = '';
	isset ( $_GET ['sidx'] ) ? $sidx = $_GET ['sidx'] : $sidx = '';
	isset ( $_GET ['sord'] ) ? $sord = $_GET ['sord'] : $sord = '';
	if (! $sidx)
		$sidx = 1;
	
	switch ($acao) {
		
		default :
			$response->mensagem = utf8_encode ( "Ação não encontrada para este controle. <br/>(metodo: GET, acao:'$acao')." );
			
			break;
	}
} else if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
	
	isset ( $_POST ['acao'] ) ? $acao = $_POST ['acao'] : $acao = '';
	isset ( $_POST ['page'] ) ? $page = $_POST ['page'] : $page = '';
	isset ( $_POST ['rows'] ) ? $rows = $_POST ['rows'] : $rows = '';
	isset ( $_POST ['sidx'] ) ? $sidx = $_POST ['sidx'] : $sidx = '';
	isset ( $_POST ['sord'] ) ? $sord = $_POST ['sord'] : $sord = '';
	if (! $sidx)
		$sidx = 1;
	
	switch ($acao) {
		
		default :
			$response->mensagem = utf8_encode ( "Ação não encontrada para este controle.<br/>(metodo: POST, acao:'$acao')" );
			
			break;
	}
} else {
	
	$response->mensagem = utf8_encode ( "Método de envio não identificado." );
}

echo json_encode ( $response );

?> 