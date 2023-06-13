<?php
function printModuloControles() {
	global $MOD_CODIGO, $MOD_CHAVE, $MOD_CLASSE, $MOD_DESCRICAO, $MOD_DIREITOS, $PAG_NUMERO, $USO_NOME, $USO_EMAIL, $USO_ID, $USO_NOME, $USO_CHAVE, $Operacao, $Registro, $Opcao;
	
	print '<input type="hidden" id="boxModuloCodigo" name="boxModuloCodigo" value="' . $MOD_CODIGO . '" />' . "\n";
	print '<input type="hidden" id="boxModuloChave" name="boxModuloChave" value="' . $MOD_CHAVE . '" />' . "\n";
	print '<input type="hidden" id="boxModuloClasse" name="boxModuloClasse" value="' . $MOD_CLASSE . '" />' . "\n";
	print '<input type="hidden" id="boxModuloDescricao" name="boxModuloDescricao" value="' . $MOD_DESCRICAO . '" />' . "\n";
	print '<input type="hidden" id="boxModuloDireitos" name="boxModuloDireitos" value="' . $MOD_DIREITOS . '" />' . "\n";
	print '<input type="hidden" id="boxPaginaNumero" name="boxPaginaNumero" value="' . $PAG_NUMERO . '" />' . "\n";
	print '<input type="hidden" id="boxUsuarioId" name="boxUsuarioId" value="' . $USO_ID . '" />' . "\n";
	print '<input type="hidden" id="boxUsuarioNome" name="boxUsuarioNome" value="' . $USO_NOME . '" />' . "\n";
	print '<input type="hidden" id="boxUsuarioChave" name="boxUsuarioChave" value="' . $USO_CHAVE . '" />' . "\n";
	print '<input type="hidden" id="boxOperacao" name="boxOperacao" value="' . $Operacao . '" />' . "\n";
	print '<input type="hidden" id="boxRegistro" name="boxRegistro" value="' . $Registro . '" />' . "\n";
	print '<input type="hidden" id="boxOpcao" name="boxOpcao" value="' . $Opcao . '" />' . "\n";
}
function getModuloControles() {
	global $MOD_CODIGO, $MOD_CHAVE, $MOD_CLASSE, $MOD_DESCRICAO, $MOD_DIREITOS, $PAG_NUMERO, $USO_NOME, $USO_ID, $USO_NOME, $USO_CHAVE, $Operacao, $Registro, $Opcao;
	
	if (isset ( $_POST ["boxModuloCodigo"] ))
		$MOD_CODIGO = $_POST ["boxModuloCodigo"];
	
	if (isset ( $_POST ["boxModuloChave"] ))
		$MOD_CHAVE = $_POST ["boxModuloChave"];
	
	if (isset ( $_POST ["boxModuloClasse"] ))
		$MOD_CLASSE = $_POST ["boxModuloClasse"];
	
	if (isset ( $_POST ["boxModuloDescricao"] ))
		$MOD_DESCRICAO = $_POST ["boxModuloDescricao"];
	
	if (isset ( $_POST ["boxModuloDireitos"] ))
		$MOD_DIREITOS = $_POST ["boxModuloDireitos"];
	
	if (isset ( $_POST ["boxPaginaNumero"] ))
		$PAG_NUMERO = $_POST ["boxPaginaNumero"];
	
	if (isset ( $_POST ["boxUsuarioId"] ))
		$USO_ID = $_POST ["boxUsuarioId"];
	
	if (isset ( $_POST ["boxUsuarioNome"] ))
		$USO_NOME = $_POST ["boxUsuarioNome"];
	
	if (isset ( $_POST ["boxUsuarioChave"] ))
		$USO_CHAVE = $_POST ["boxUsuarioChave"];
	
	if (isset ( $_POST ["boxOperacao"] ))
		$Operacao = $_POST ["boxOperacao"];
	
	if (isset ( $_POST ["boxRegistro"] ))
		$Registro = $_POST ["boxRegistro"];
	
	if (isset ( $_POST ["boxOpcao"] ))
		$Opcao = $_POST ["boxOpcao"];
}
function getModuloPagina() {
	global $PAG_NUMERO;
	
	if (isset ( $_GET ["pag"] )) {
		$PAG_NUMERO = $_GET ["pag"];
		setcookie ( "PAG_NUMERO", $PAG_NUMERO );
	} elseif (isset ( $_POST ["pag"] )) {
		$PAG_NUMERO = $_POST ["pag"];
		
		setcookie ( "PAG_NUMERO", $PAG_NUMERO );
	} elseif (isset ( $_POST ['boxPaginaNumero'] )) {
		$PAG_NUMERO = $_POST ['boxPaginaNumero'];
		setcookie ( "PAG_NUMERO", $PAG_NUMERO );
	} elseif (isset ( $_COOKIE ['PAG_NUMERO'] )) {
		$PAG_NUMERO = $_COOKIE ['PAG_NUMERO'];
	} else
		$PAG_NUMERO = 1;
}
function getModuloBusca() {
	global $TXT_BUSCA, $PAG_NUMERO;
	
	if (isset ( $_GET ["busca"] )) {
		$TXT_BUSCA = $_GET ["busca"];
	} elseif (isset ( $_POST ['busca'] )) {
		$TXT_BUSCA = $_POST ['busca'];
	} elseif (isset ( $_POST ['boxBusca'] )) {
		$TXT_BUSCA = $_POST ['boxBusca'];
		
		// } elseif (isset($_COOKIE['TXT_BUSCA'])){
		// $TXT_BUSCA = $_COOKIE['TXT_BUSCA'];
	} else
		$TXT_BUSCA = "";
	
	if (isset ( $_GET ["pag"] )) {
		$PAG_NUMERO = $_GET ["pag"];
	} elseif (isset ( $_POST ['pag'] )) {
		$PAG_NUMERO = $_POST ['pag'];
	} elseif (isset ( $_POST ['boxPagina'] )) {
		$PAG_NUMERO = $_POST ['boxPagina'];
		
		// } elseif (isset($_COOKIE['PAG_NUMERO'])){
		$PAG_NUMERO = $_COOKIE ['PAG_NUMERO'];
	} else
		$PAG_NUMERO = 1;
}
function setModuloBusca() {
	global $TXT_BUSCA, $PAG_NUMERO;
	setcookie ( "TXT_BUSCA", $TXT_BUSCA );
	setcookie ( "PAG_NUMERO", $PAG_NUMERO );
}
function printModuloAguarde() {
	print '<table border="0" cellspacing="0" cellpadding="0" id="loaderContainer" onClick="return false;"><tr><td id="loaderContainerWH"><div id="loader"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td><p><img src="images/loading.gif" height="32" width="32" alt=""/><strong>Please wait.<br/>Loading ...</strong></p></td></tr></table></div></td></tr></table>' . "\n";
}
function descricaoOperacao($intOperacao) {
	switch ($intOperacao) {
		case 1 :
			return "criar um novo regitro";
		
		case 2 :
			return "editar o regitro";
		
		case 12 :
			return "editar o regitro";
		
		case 3 :
			return "excluir o regitro";
		
		case 13 :
			return "excluir a foto";
		
		default :
			return "";
	}
}
function printDivAguardeAjax($idDiv) {
	print '<div id="' . $idDiv . '" style="display:none;text-align:center; vertical-align:top;"><table cellspacing="0" cellpadding="0" border="0" style="border: 1px solid #555555"><tr><td class="guia_branco"><table cellspacing="5" cellpadding="0" border="0"><tr><td width="20" align="center" valign="middle"><img src="images/aguarde.gif" border="0" alt="" /></td><td width="100">Aguarde . . .</td></tr></table></td></tr></table></div>';
}

?>