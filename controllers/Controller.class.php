<?php
require_once 'assets/global.php';
if(!class_exists('Arquivo')){ require_once 'assets/Arquivo.class.php';}
if(!class_exists('Formatacao')){ require_once 'assets/Formatacao.class.php';}
if(!class_exists('Validacao')){ require_once 'assets/Validacao.class.php';}
if(!class_exists('DataHora')){ require_once 'assets/DataHora.class.php';}
if(!class_exists('Criptografia')){ require_once 'assets/Criptografia.class.php';}
if(!class_exists('UUID')){ require_once 'assets/UUID.class.php';}
if(!class_exists('Email')){ require_once 'assets/Email.class.php';}
if(!class_exists('Config')){ require_once 'assets/Config.class.php';}
if(!class_exists('UsuarioContexto')){ require_once 'assets/UsuarioContexto.class.php';}
if(!class_exists('ModuloContexto')){ require_once 'assets/ModuloContexto.class.php';}
if(!class_exists('UsuarioDAO')){ require_once 'models/UsuarioDAO.class.php';}
if(!class_exists('ModuloDAO')){ require_once 'models/ModuloDAO.class.php';}
if(!class_exists('PerfilFuncionalidadeDAO')){ require_once 'models/PerfilFuncionalidadeDAO.class.php';}
if(!class_exists('LogAcaoDAO')){ require_once 'models/LogAcaoDAO.class.php';}
/**
 *  Classe modelo de Controle de Módulo
 * 
 * @package Controller
 * @category Controller
 * @since   2015-05-21
 * @version 2.0
 * @author  Kellen Nery
 * 
 * 
 * @edit    2020-05-22<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Melhoria no Framework
 *          #1.17
 */
class Controller{
    
    private static $_Erro = 0;
    private static $_ErroTitulo = null;
    private static $_ErroMensagem = null;
    private static $_ErroNotas = null;
    
    public static function getErro(){ return self::$_Erro; }
    public static function getErroTitulo(){ return self::$_ErroTitulo; }
    public static function getErroMensagem(){ return self::$_ErroMensagem; }
    public static function getErroNotas(){ return self::$_ErroNotas; }
    
    protected $_Method;
    
    protected $_Chave;
    protected $_Classe;
    protected $_Acao;
    protected $_Operacoes;
    protected $_Formato;
    protected $_Pagina;
    protected $response;

    /** @var Config Configuração do Sistema */
    public $Config;

    /** @var UsuarioContexto Usuário autenticado no contexto */
    public $Usuario;
    
    /**
     * Contrutor da Classe
     *
     * @return void
     */
    public function __construct($p_Chave=null){
        
        $this->Config = new Config();
        $this->Usuario = new UsuarioContexto();

        $this->_Chave = $p_Chave;
        $this->_Controle = self::getVar('controle');
        $this->_Acao = self::getVar('acao');
        $this->_Operacoes = '{"listar": 0 ,"visualizar": 0, "incluir": 0, "editar": 0, "excluir": 0, "autorizar": 0, "aprovar": 0, "total": 0}';
        if (self::getVar('formato')){
            $this->_Formato = self::getVar('formato');
        } else {
            $this->_Formato = 'json';
        }
        if (self::getVar('pagina')){
            $this->_Pagina = self::getVar('pagina');
        } else {
            $this->_Pagina = 'A4-L';
        }
        
        
        $this->response = new stdClass();
        $this->response->inicio = date('Y-m-d H:i:s').' '.microtime(true);
        $this->response->sucesso = 0;
        $this->response->erro = 152;
        $this->response->alerta = 0;
        $this->response->mensagem = "inicio do processamento.";
        $this->response->controle = $this->_Controle;
        $this->response->acao = $this->_Acao;
        $this->response->formato = $this->_Formato;
        $this->response->passo = 0;
        $this->response->rows = Array();
        $this->response->aaData = array();
        $this->response->records = 0;
        $this->response->iTotalRecords = 0;
        $this->response->iTotalDisplayRecords = 0;
        $this->response->IdUsuarioAcao = 0;
        $this->response->cabecalho = '';
        
        $this->isLogged();
    }
    
    /**
     *  Método estático usado para recuperar uma informação de dentro requisição GET ou POST
     *
     *  @param string $p_Key Chave da variável
     *  @param int $p_Filter Types of Filter
     *  @return string|int|float
     */
    public static function getVar($p_Key, $p_Filter=FILTER_SANITIZE_STRING){
        
        if ($_SERVER['REQUEST_METHOD']==='GET'){
            return filter_input(INPUT_GET, $p_Key, $p_Filter);
        } else if ($_SERVER['REQUEST_METHOD']==='POST'){
            return filter_input(INPUT_POST, $p_Key, $p_Filter);
        } else { 
            return '';
        }
    }

    /**
     *  Método usado para saída de dados REPONSE 
     *
     *  @return strClass
     */
    public function getResponse(){
        // Response por JSON
        return $this->response;
    }
    
    /**
     *  Método usado para saída de dados REPONSE type JSON
     *
     *  @return void
     */
    public function outputJSON(){
        try{
            // Response por JSON
            if(ob_get_length()>0){ob_end_clean();}
            //header('Content-type: text/json; charset=utf-8');
            //header('Content-type: application/json; charset=utf-8');
            header('Content-type: application/json');
            $this->response->final = date('Y-m-d H:i:s').' '.microtime(true);
            exit(json_encode($this->response));
        } catch (PDOException $ex){ var_dump($ex); }
    }
    
    /**
     *  Método usado para saída de dados REPONSE type EXCEL
     *
     *  @return void
     */    
    public function outputExcel($nomeArquivo=null){
        // Response por EXCEL
        if(ob_get_length()>0){ob_end_clean();}
        $nomeArquivo = ($nomeArquivo) ? $nomeArquivo."-".date('Y-m-d-His-u'): "mcc-relatorio-".date('Y-m-d-His-u');
        
        header("Expires: 0");
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Content-type: application/vnd.ms-excel");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=$nomeArquivo.xls");
        header("Pragma: no-cache");
        exit(utf8_decode($this->response->cabecalho . $this->response->html));
    }
	
    /**
     *  Método usado para saída de dados REPONSE type WORD
     *
     *  @return void
     */    
    public function outputWord($nomeArquivo=null){
        // Response por WORD
        if(ob_get_length()>0){ob_end_clean();}
        $nomeArquivo = ($nomeArquivo) ? $nomeArquivo."-".date('Y-m-d-His-u'): "mcc-relatorio-".date('Y-m-d-His-u');
        
        header("Expires: 0");
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Content-type: application/vnd.ms-word");
        header("Content-type: application/force-download");
        header("Content-Disposition: attachment; filename=$nomeArquivo.doc");
        header("Pragma: no-cache");
        exit(utf8_decode($this->response->cabecalho . $this->response->html));	

    }	

    /**
     *  Método usado para saída de dados REPONSE type PDF
     *
     *  @return void
     */    
    public function outputPDF($nomeArquivo=null){
        // Response por PDF
        if(ob_get_length()>0){ob_end_clean();}
        $nomeArquivo = ($nomeArquivo) ? $nomeArquivo."-".date('Y-m-d-His-u'): "mcc-relatorio-".date('Y-m-d-His-u');
        
        header("Expires: 0");
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Pragma: no-cache");
        //exit($this->response->html);
        
        //Carregando a biblioteca mPDF
        if (file_exists("assets/mpdf/mpdf.php")){
            require_once "assets/mpdf/mpdf.php";
        } else {
            require_once "../../assets/mpdf/mpdf.php";
        }
        
       // exit ($this->response->cabecalho . $this->response->html);
        
        //Limpa o buffer jogando todo o HTML em uma variavel.
        $html = ob_get_clean();
					
        $mpdf=new mPDF('c', $this->_Pagina,'','',10,10,40,40,10,10, 'L'); 
        //$mpdf->useOddEven = 0;        
        
        $header = $this->response->cabecalho;
        $mpdf->SetHTMLHeader($header);
        
        $html = $this->response->html;
        $mpdf->WriteHTML($html);
        
        //Colocando o rodape
        $footer = 'Emitido em: {DATE d/m/Y H:i:s}|Página: {PAGENO} de {nb}|'.$this->Config->Titulo;
        $mpdf->SetFooter($footer);
        
        $mpdf->Output();
        exit;
    }
    
    /**
     * Get Chave do Controle
     * @return string Retorna a Chave do Controle
     */
    public function getChave(){ return $this->_Chave; }
    
    /**
     * Get Classe do Controle
     * @return string Retorna a Classe do Controle
     */
    public function getClasse(){ return $this->_Classe; }
    
    /**
     * Get a Acao do Controle
     * @return string Retorna a Açao a ser executada pelo Controle
     */
    public function getAcao(){ return $this->_Acao; }

    /**
     * Get Formato de saída do Controle
     * @return string Retorna o Formato da saida {json, pdf, excel}
     */
    public function getFormato(){ return $this->_Formato; }

    /**
     * Get Tipo de Pagina de saída do Controle
     * @return string Retorna a Pagina de saída {"A4-L", "A4-P"}
     */
    public function getPagina(){ return $this->_Pagina; }

    /**
     * Função para verificar se o usuário esta autenticado no sistema
     *
     * @return bool true|false Se o usuário estiver autenticado 
     */
    protected function isLogged(){
        global $sisUsuario, $USO_ID;
        try{
            if (isset($_SESSION['USUARIO'])){
                $sisUsuario = unserialize($_SESSION['USUARIO']);
                if (get_class($sisUsuario) === 'UsuarioContexto'){
                    $this->Usuario = $sisUsuario;
                } else {
                    $this->Usuario = new UsuarioContexto;
                }
                $USO_ID = $this->Usuario->Id;
                return ($this->Usuario->Id>0);
            } else {
                $USO_ID = (isset($_SESSION['USO_ID']))? $_SESSION['USO_ID']: 0;
                return ($USO_ID > 0);
            }
            return $USO_ID;
 
        } catch (Exception $ex) {
            self::logOff();
            self::tratarErroJSON(9, "Erro (".$ex->getCode()."): ".$ex->getMessage());
            return false;
        }
    }

    /**
     * Função para fazer sair/fechar a autenticação
     *
     * @return void
     */
    protected function logOff(){
        global $sisUsuario, $USO_ID;
        
        //session_destroy();
        if(isset($_SESSION["USUARIO"])){ unset($_SESSION['USUARIO']); }
        if(isset($_SESSION["USO_ID"])){ unset($_SESSION['USO_ID']); }
        if (!is_object($this->Usuario)) {
            $this->Usuario = new UsuarioContexto;
        }
        $sisUsuario = $this->Usuario;
        $USO_ID = $this->Usuario->Id;
    }

    /**
     *   Função para tratar retorno de erro para exibição em tela
     *
     *  @param object $p_Codigo O código do erro
     *  @param object $p_Mensagem A mensagem do erro
     *  @param object $p_Notas O detalhamento do erro
     * 
     *  @return string $Page Redireciona a saída para página de erro
     */
    public static function tratarErro($p_Codigo, $p_Mensagem, $p_Notas=null){
        global $sisModulo;

        self::$_Erro = $p_Codigo; 
        self::$_ErroMensagem = $p_Mensagem;
        self::$_ErroNotas = $p_Notas;
        
        $this->Modulo->Id = 0;
        $this->Modulo->Classe = 'mensagem';
        require_once('views/mensagem.view.php');
        exit();
    }

    /**
     *   Função para tratar retorno de erro para requisições feitas por AJAX/JSON
     *
     *  @param object $p_Codigo O código do erro
     *  @param object $p_Mensagem A mensagem do erro
     *  @param object $p_Notas O detalhamento do erro
     * 
     *  @return string $Page Redireciona a saída para página de erro
     */
    public static function tratarErroJSON($p_Codigo, $p_Mensagem, $p_Notas=null){
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
        //header('Content-type: text/json');
        header('Content-type: application/json');
        exit(json_encode($response));
    }
    
    /**
     *   função para retornar Perfil do Usuario tem permissão a Ação do Controle/Modulo
     *
     *   @return int Retorna o identificadodo da permissão PerfilFuncionalidade (Perfil x Modulo x Funcionalidade)
     */
    protected function verificarPermissao($p_IPerfil, $p_ChaveModulo, $p_ChaveFuncionalidade){
        $retorno = 0;
        $daoPF = new PerfilFuncionalidadeDAO();
        $objPF = $daoPF->retornarPorChave($p_IPerfil, $p_ChaveModulo, $p_ChaveFuncionalidade);
        if ($objPF) {
            $retorno = $objPF->getId();
        }
        $daoPF->Close();
        return $retorno;
    }
    
}