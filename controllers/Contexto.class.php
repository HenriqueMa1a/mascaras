<?php
if(!class_exists('Config')){ require_once 'assets/Config.class.php';}
if(!class_exists('UsuarioContexto')){ require_once 'assets/UsuarioContexto.class.php';}
if(!class_exists('ModuloContexto')){ require_once 'assets/ModuloContexto.class.php';}
/**
 *  Controle responsável pela Roteamento entre Módulos
 * 
 * @package Controller
 * @category Controller
 * @since   2015-05-21
 * @version 2.0
 * @author  Kellen Nery
 * 
 * 
 * @edit    2016-01-19<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Melhoria no Framework
 *          #1.17
 */
class Contexto
{
    private static $arrLiberados = array('abertura', 'branco', 'sobre', 'contato', 'fale-conosco', 'mensagem', 'links', 'login', 'autenticacao', 'lembrete-senha');
    private static $arrLogin = array('logoff', 'login', 'autenticacao', 'autenticacao-cpf');
    
    private static $_Erro = 0;
    private static $_ErroTitulo = null;
    private static $_ErroMensagem = null;
    private static $_ErroNotas = null;

    public static function getErro(){ return self::$_Erro; }
    public static function getErroTitulo(){ return self::$_ErroTitulo; }
    public static function getErroMensagem(){ return self::$_ErroMensagem; }
    public static function getErroNotas(){ return self::$_ErroNotas; }
    
    /**
     * Função para verificar se o usuário esta autenticado no sistema
     *
     * @return bool true|false Se o usuário estiver autenticado 
     */
    public static function isLogged()
    {
        global $sisUsuario;
        $intUsuario = 0;

        if ((isset($_SESSION['USUARIO']))){
            $sisUsuario = unserialize($_SESSION['USUARIO']); 
            $intUsuario = $sisUsuario->Id;
        }    
        if ($intUsuario > 0){
            return true;
        } else {
            self::logoff();
            self::tratarErroJSON(11, "Controle de Acesso ", "O usuário precisa está logado para utilizar esta área do sistema.\n Tente logar no sistema novamente.");
        }
    }

    /**
     * Função para fazer sair/fechar a autenticação
     *
     * @return void
     */
    public static function logoff(){
        global $sisUsuario, $USO_ID;
        
        //session_destroy();
        if(isset($_SESSION["USUARIO"])){ unset($_SESSION['USUARIO']); }
        if(isset($_SESSION["USO_ID"])){ unset($_SESSION['USO_ID']); }
        if (!is_object($sisUsuario)) {
            $sisUsuario = new UsuarioContexto;
        }
        $sisUsuario->Id=0;
        $USO_ID=0;
    }

    public static function getUsuario(){
        global $sisUsuario, $USO_ID;
        
        if (isset($_SESSION['USUARIO'])){
            $sisUsuario = unserialize($_SESSION['USUARIO']);
            if (get_class($sisUsuario) === 'UsuarioContexto'){
                // SUCESSO
            } else {
                $sisUsuario = new UsuarioContexto;
            }
            $USO_ID = $sisUsuario->Id;
        } else {
            $USO_ID = (isset($_SESSION['USO_ID']))? $_SESSION['USO_ID']: 0;
        }
        return $USO_ID;
    }

    public static function iniciarModulo(){
        global $sisModulo;

        $sisModulo = new ModuloContexto();
        $sisModulo->Id = 0;
        $sisModulo->Chave = '';
        $sisModulo->Classe = '';
        $sisModulo->Nome = '';
        $sisModulo->Descricao = '';
        $sisModulo->Imagem = '';
        $sisModulo->Parametros = '{}';
        $sisModulo->View = '';
        $sisModulo->Operacoes = '{"listar": 0, "visualizar": 0, "incluir": 0, "editar": 0, "excluir": 0, "autorizar": 0, "aprovar": 0, "total": 0}';
        
        // 1. Pegrar o Grupo de Modulo
        $gm = filter_input(INPUT_GET, 'gm', FILTER_SANITIZE_STRING); // Grupo de Modulo
		
        if ($gm!=''){
            $sisModulo->Grupo = new ModuloContexto();
            $sisModulo->Grupo->Chave = $gm;
        } else {
            $sisModulo->Grupo = new ModuloContexto();
            $sisModulo->Grupo->Chave = 'registro';
        }
        if (!$sisModulo->Grupo->Chave){ $sisModulo->Grupo->Chave = 'registro';}        
        
        // 2. Pegrar o Modulo
        $mod = filter_input(INPUT_GET, 'mod', FILTER_SANITIZE_STRING); // Modulo
        if ($mod!=''){ 
            if (in_array($mod, self::$arrLogin)){
                self::logoff();
                $sisModulo->Chave = $mod;
                $sisModulo->Classe = 'autenticacao';
            } else if ($mod=='sair'){
                self::logoff();
                //$sisModulo->Chave = 'abertura';
                //$sisModulo->Classe = 'abertura';
				$sisModulo->Chave = 'branco';
                $sisModulo->Classe = 'branco';
            } else { 
                $sisModulo->Chave = $mod; 
            }
        } else { 
            $sisModulo->Chave = $sisModulo->Grupo->Chave; //$sisModulo->Chave = 'abertura';
        }
        
        // 2. Pegrar a Ação/Operação
        $acao = filter_input(INPUT_GET, 'acao', FILTER_SANITIZE_STRING); // Ação
        $sisModulo->Acao = ($acao)? $acao: '';
        
        return $sisModulo->Chave;
    }
    
    public static function moduloPublico(){
        global $sisModulo;
        if (in_array($sisModulo->Chave, self::$arrLiberados)){ // Modulos NÃO Cadastrados e NÃO precisam de permissão.
            $sisModulo->Classe = $sisModulo->Chave;
            $sisModulo->View = "views/".$sisModulo->Classe.".view.php";
            return true;
        } else {
            return false;
        }
    }
    
    public static function tratarErro($p_Codigo, $p_Mensagem, $p_Notas=null){
        global $sisUsuario, $USO_ID, $sisModulo;

        self::$_Erro = $p_Codigo; 
        self::$_ErroMensagem = $p_Mensagem;
        self::$_ErroNotas = $p_Notas;
    }

    public static function tratarErroJSON($p_Codigo, $p_Mensagem, $p_Notas=null){
        global $sisUsuario, $USO_ID, $sisModulo;
        
        $response = new stdClass();
        $response->sucesso = 0;
        $response->passo = 1;
        $response->erro = $p_Codigo;
        $response->mensagem = $p_Mensagem;
        $response->notas = $p_Notas;
        $response->rows = Array();
        $response->aaData = array();
        $response->records = 0;
        $response->iTotalRecords = 0;
        $response->iTotalDisplayRecords = 0;
        $response->IdUsuarioAcao = 0;

        // Response por JSON
        if(ob_get_length()>0){ob_end_clean();}
        header('Content-type: text/json');
        header('Content-type: application/json');
        exit(json_encode($response));
    }
    
}