<?php
/**
 * Arquivo para gerenciar rotas do MVC
 * @version 2.0
 * @author  Kellen Nery7
 */
error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 'on');
/*
    $response = new stdClass();
    $response->sucesso = 0;
    $response->passo = 1;
    $response->controle = $_REQUEST['controle'];
    $response->acao = $_REQUEST['acao'];
    $response->method = $_SERVER['REQUEST_METHOD'];

    // Response por JSON
    if(ob_get_length()>0){ob_end_clean();}
    //header('Content-type: text/json');
    header('Content-type: application/json');
    exit(json_encode($response));
*/
require_once 'assets/global.php';
if(!class_exists('Contexto')){ require_once 'controllers/Contexto.class.php';}
if(!class_exists('Controller')){ require_once 'controllers/Controller.class.php';}
if(!class_exists('ModuloDAO')){ require_once 'models/ModuloDAO.class.php';}
if(!class_exists('FuncionalidadeDAO')){ require_once 'models/FuncionalidadeDAO.class.php';}
if(!class_exists('LogAcaoDAO')){ require_once 'models/LogAcaoDAO.class.php';}
error_reporting(E_ALL & ~E_STRICT);
ini_set('display_errors', 'on');

if ($_SERVER['REQUEST_METHOD']==='POST'){
    $controle = filter_input(INPUT_POST, 'controle', FILTER_SANITIZE_STRING);
    $acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
    $formato = filter_input(INPUT_POST, 'formato', FILTER_SANITIZE_STRING);
} else{
    $controle = filter_input(INPUT_GET, 'controle', FILTER_SANITIZE_STRING);
    $acao = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_STRING);
    $formato = filter_input(INPUT_GET, 'formato', FILTER_SANITIZE_STRING);
}

/* 1. Verifica se o arquivo de controle existe na pasta controle */
if (file_exists("controllers/{$controle}.controller.php")) {
    require_once "controllers/{$controle}.controller.php";
    $controle .= "Controller";
} else {
    $controle = "Controller";
}

try{ 
    /* Instancia o controle */
    $objControle = new $controle();

    // Verifica se o método existe no objeto controle
    if (method_exists($objControle, $acao)) {
        // se existir, executa o método
        if ($objControle->$acao()){
            //
        } else {
            
        }
        if ($objControle->getFormato()=='excel'){
            $objControle->outputExcel();
        } else if ($objControle->getFormato()=='word'){
            $objControle->outputWord();			
        } else if ($objControle->getFormato()=='pdf'){
            $objControle->outputPDF();
        } else if ($objControle->getFormato()=='json'){
            $objControle->outputJSON();
        } else {
            $objControle->outputJSON();
        }
    } else {
        Contexto::tratarErroJSON(28, "O controle não encontrou a ação solicitada. <br/>(metodo: '".$_SERVER['REQUEST_METHOD']."', controle: '$controle', acao: '$acao')");
    }
    
}catch (Exeception $ex){
    Contexto::tratarErroJSON(29, utf8_encode("Erro (".$ex->getCode()."): ".$ex->getMessage()));
}

