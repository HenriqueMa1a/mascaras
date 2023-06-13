<?php
/**
 * Classe de variaveis Globais
 */
ob_start();
if(!isset($_SESSION)){ session_start(); }
date_default_timezone_set("Brazil/East");

/** Padrões de Exibição de Erros;
*   Default Value: E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED
*   Development Value: E_ALL
*   Production Value: E_ALL & ~E_DEPRECATED & ~E_STRICT
*/
error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 'on');

if(!class_exists('Config')){ require_once 'Config.class.php';}
if(!class_exists('ModuloContexto')){ require_once 'ModuloContexto.class.php';}
if(!class_exists('UsuarioContexto')){ require_once 'UsuarioContexto.class.php';}

$sisConfig = new Config();

$sisUsuario = new UsuarioContexto();

$sisModulo = new ModuloContexto();

/* Funções Globais -------------------------------------------------------------------- */
define("LATIN1_UC_CHARS", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ");
define("LATIN1_LC_CHARS", "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý");

function to_maiuscula($texto) {
	$texto = trim(strtoupper(strtr($texto, LATIN1_LC_CHARS, LATIN1_UC_CHARS)));
	return $texto;
    //return strtr($str, array("ß" => "SS"));
}

function to_minuscula($texto) {
	$texto = trim(strtolower(strtr($texto, LATIN1_UC_CHARS, LATIN1_LC_CHARS)));
    return $texto;
}

function sortByQuantidade($obj1, $obj2) {
   return $obj1->Quantidade - $obj2->Quantidade;
}

function sortByQuantidadeDESC($obj1, $obj2) {
   return $obj2->Quantidade - $obj1->Quantidade;
}

?>