<?php
// // Funções de Formatação (Data, Texto, etc...) ----------------------------------------

// --------------------------------------------------------------------------------------
function getNomeMes($intMes) {
	extract ( $GLOBALS );
	
	switch ($intMes) {
		case 1 :
			$function_ret = "Janeiro";
			break;
		case 2 :
			$function_ret = "Fevereiro";
			break;
		case 3 :
			$function_ret = "Março";
			break;
		case 4 :
			$function_ret = "Abril";
			break;
		case 5 :
			$function_ret = "Maio";
			break;
		case 6 :
			$function_ret = "Junho";
			break;
		case 7 :
			$function_ret = "Julho";
			break;
		case 8 :
			$function_ret = "Agosto";
			break;
		case 9 :
			$function_ret = "Setembro";
			break;
		case 10 :
			$function_ret = "Outubro";
			break;
		case 11 :
			$function_ret = "Novembro";
			break;
		case 12 :
			$function_ret = "Dezembro";
			break;
		default :
			$function_ret = "";
			break;
	}
	return $function_ret;
}

// --------------------------------------------------------------------------------------
function getNomeDiaSemana($intDia) {
	extract ( $GLOBALS );
	
	if (! is_numeric ( $intDia )) {
		return $function_ret;
	}
	switch (intval ( $intDia )) {
		case 1 :
			$function_ret = "domingo";
			break;
		case 2 :
			$function_ret = "segunda-feira";
			break;
		case 3 :
			$function_ret = "terça-feira";
			break;
		case 4 :
			$function_ret = "quarta-feira";
			break;
		case 5 :
			$function_ret = "quinta-feira";
			break;
		case 6 :
			$function_ret = "sexta-feira";
			break;
		case 7 :
			$function_ret = "sabado";
			break;
		default :
			$function_ret = "";
			break;
	}
	return $function_ret;
}
function getNomeDiaSemanaAbreviado($intDia) {
	extract ( $GLOBALS );
	
	if (! is_numeric ( $intDia )) {
		return $function_ret;
	}
	switch (intval ( $intDia )) {
		case 1 :
			$function_ret = "dom";
			break;
		case 2 :
			$function_ret = "seg";
			break;
		case 3 :
			$function_ret = "ter";
			break;
		case 4 :
			$function_ret = "qua";
			break;
		case 5 :
			$function_ret = "qui";
			break;
		case 6 :
			$function_ret = "sex";
			break;
		case 7 :
			$function_ret = "sab";
			break;
		default :
			$function_ret = "";
			break;
	}
	return $function_ret;
}

// --------------------------------------------------------------------------------------
function FormatDate($dtaData, $strFormato) {
	extract ( $GLOBALS );
	
	/*
	 * if (!isDate[$dtaData]) { return $function_ret; }
	 */
	$dtaData = strtotime ( $dtaData );
	
	$strYYYY = (strftime ( "%Y", $dtaData ));
	
	$strMMMM = (strftime ( "%B", $dtaData ));
	$strMMM = (strftime ( "%b", $dtaData ));
	$strMM = (strftime ( "%m", $dtaData ));
	if (strlen ( $strMM ) == 1)
		$strMM = "0" . $strMM;
	
	$strDD = (strftime ( "%d", $dtaData ));
	if (strlen ( $strDD ) == 1)
		$strDD = "0" . $strDD;
	
	$strHH = (strftime ( "%H", $dtaData ));
	if (strlen ( $strHH ) == 1)
		$strHH = "0" . $strNN;
	
	$strNN = (strftime ( "%M", $dtaData ));
	if (strlen ( $strNN ) == 1)
		$strNN = "0" . $strNN;
	
	$strSS = (strftime ( "%S", $dtaData ));
	if (strlen ( $strSS ) == 1)
		$strSS = "0" . $strNN;
	
	$strData = strtolower ( $strFormato );
	$strData = str_replace ( "yyyy", $strYYYY, $strData );
	$strData = str_replace ( "yyy", $strYYYY, $strData );
	$strData = str_replace ( "yy", substr ( $strYYYY, strlen ( $strYYYY ) - (2) ), $strData );
	$strData = str_replace ( "y", substr ( $strYYYY, strlen ( $strYYYY ) - (2) ), $strData );
	$strData = str_replace ( "mmmm", $strMMMM, $strData );
	$strData = str_replace ( "mmm", $strMMM, $strData );
	$strData = str_replace ( "mm", $strMM, $strData );
	$strData = str_replace ( "m", $strMM, $strData );
	$strData = str_replace ( "dd", $strDD, $strData );
	$strData = str_replace ( "d", $strDD, $strData );
	$strData = str_replace ( "hh", $strHH, $strData );
	$strData = str_replace ( "h", $strHH, $strData );
	$strData = str_replace ( "nn", $strNN, $strData );
	$strData = str_replace ( "n", $strNN, $strData );
	$strData = str_replace ( "ss", $strSS, $strData );
	$strData = str_replace ( "s", $strSS, $strData );
	
	$function_ret = $strData;
	
	return $function_ret;
}

// --------------------------------------------------------------------------------------
function JustLeft($strTexto, $intTamanho) {
	extract ( $GLOBALS );
	
	if (strlen ( trim ( $strTexto ) ) >= $intTamanho) {
		$function_ret = substr ( $strTexto, 0, $intTamanho );
	} else {
		$function_ret = $strTexto . $Space [$intTamanho - strlen ( $strTexto )];
	}
	
	return $function_ret;
}

// --------------------------------------------------------------------------------------
function JustRight($strTexto, $intTamanho) {
	extract ( $GLOBALS );
	
	if (strlen ( $strTexto ) >= $intTamanho) {
		$function_ret = substr ( $strTexto, strlen ( $strTexto ) - ($intTamanho) );
	} else {
		$function_ret = $Space [$intTamanho - strlen ( $strTexto )] . $strTexto;
	}
	
	return $function_ret;
}

// --------------------------------------------------------------------------------------
function JustCenter($strTexto, $intTamanho) {
	extract ( $GLOBALS );
	
	if (strlen ( $cTexto ) >= $intTamanho) {
		$function_ret = substr ( $strTexto, 0, $intTamanho );
	} else {
		$cTexto = $Space [($intTamanho - strlen ( $strTexto )) % 2] . $strTexto . $Space [($intTamanho - strlen ( $strTexto )) % 2];
		$function_ret = $strTexto . $Space [$intTamanho - strlen ( $strTexto )];
	}
	
	return $function_ret;
}

// --------------------------------------------------------------------------------------
function getIdade($dtaNascimento) {
	extract ( $GLOBALS );
	
	$indDia = $Day [$dtaNascimento];
	$indMes = strftime ( "%m", $dtaNascimento );
	$indAno = strftime ( "%Y", $dtaNascimento );
	while ( ! $IsDate [$indDia . "/" . $indMes . "/" . strftime ( "%Y", time () )] ) {
		
		$indDia = $indDia - 1;
		if ($indDia < 0) {
			$function_ret = 0;
			return $function_ret;
		}
	}
	if ($CDate [$indDia . "/" . $indMes . "/" . strftime ( "%Y", time () )] <= time ()) {
		$function_ret = strftime ( "%Y", time () ) - $indAno;
	} else {
		$function_ret = strftime ( "%Y", time () ) - $indAno - 1;
	}
	
	return $function_ret;
}

?>
