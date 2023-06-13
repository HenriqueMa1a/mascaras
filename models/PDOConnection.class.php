<?php
/**
 * Classe PDO para Conexao com Banco de Dados
 */
class PDOConnection{

    /**
     * O objecto da conexão com o banco de dados
     * @var object
     */
    protected $_conexao = null;
    
    /**
     * O identificado do usuário logado/autenticado no sistema
     * @var int
     */
    protected $_idUsuario = null;
    
    /**
     * O nome da tabela (*utilizado pela classe padrão)
     * @var string
     */
    protected $_nomeTabela = null;
    
    /**
     * O nome do campo chave primaria da tabela (*utilizado pela classe padrão)
     * @var object
     */
    protected $_chavePrimaria = null;
    
    /**
     * O nome do campo chave primaria da tabela (*utilizado pela classe padrão)
     * @var object
     */
    protected $_nomeContador = null;
    
    /**
     * O prefixo do nome das tabelas
     * @var string
     */
    const PREFIXO = 'cad_';

    /**
     * O prefixo do nome das tabelas
     * @var string
     */
    const NOW = 'NOW() ';

    /**
     * Valor constante para TRUE
     * @var string
     */
    const SIM = '1';

    /**
     * Valor constante para FALSE
     * @var string'
     */
    const NAO = '0';
    
    /**
     * A utlima query SQL executada pela classe
     * @var string
     */
    public $_query = '';
    
    // Parâmetros de conexão
    private $con = null;
    private $dbType = 'mysql'; // qual o banco de dados? {'mysql', 'pgsql', 'sqlsrv'}
    private $host = 'localhost'; //'BIO2102\SQLEXPRESS'; //'BIO2337\SQLEXPRESS';
    private $db = 'controlemascara';
    private $user = 'root';
    private $senha = 'root';
    private $charset = 'utf8';
    private $persistent = false; // seta a persistencia da conexão
    protected $_erro = '';
    protected $_mensagem = '';

    // Parâmetros de paginacao
    private static $_Identificador = 0;
    private static $_RegistroAtual = 0;
    private static $_TotalRegistros = 0;     
    private static $_PaginaAtual = 1; 
    private static $_TamanhoPagina = 20;
    private static $_TotalPaginas = 0; 
    private static $_Trace = 0; 

    public function getErro(){ return $this->_erro; }
    public function getMensagem(){ return $this->_mensagem; }
    
    /**
     *  função para retornar o Registro Atual
     *  
     *  @return int $_RegistroAtual Número do registro atual onde o ponteiro esta parado da ultima query executada
     */
    public static function getRegistroAtual(){ return (self::$_RegistroAtual + 1); }
    public static function setRegistroAtual( $p_RegistroAtual ){ self::$_RegistroAtual = $p_RegistroAtual; }

    /**
     *  função para retornar o total de Registro da Query
     *  @return int $_TotalRegistros Número total de registros da ultima query executada
     */
    public static function getTotalRegistros(){ return self::$_TotalRegistros; }
    public static function setTotalRegistros( $p_TotalRegistros ){ self::$_TotalRegistros = $p_TotalRegistros; }

    /**
     *  função para retornar o Página Atual
     *  @return int $_PaginaAtual Número da página atual onde o ponteiro esta parado na ultima query executada
     */
    public static function getPaginaAtual(){ return self::$_PaginaAtual; }
    
    /**
     *  função para retornar o tamanho Página 
     *  @return int $_TamanhoPagina O tamnho do página de registro da ultima query executada
     */
    public static function getTamanhoPagina(){ return self::$_TamanhoPagina; }
    
    /**
     *  função para retornar o Total de Páginas
     *  @return int $_TotalPaginas Número total de páginas na ultima query executada
     */
    public static function getTotalPaginas(){ return self::$_TotalPaginas; }
    
    /**
     *  função para retornar o Página Atual
     *  @return int $_Identificador Número do Identificado {PrimaryKey} do registro criado na ultima query executada
     */
    public static function getIdentificador(){ return self::$_Identificador; }

    /**
     * função que constrois a classe e carrega a variável do usuário logado
     * 
     * @param boolean $p_NomeTabela O Nome da tabela a ser perssistida
     * @param boolean $p_ChavePrimaria O Nome da Chave Primária da tabela
     * @param boolean $p_NomeContador O Nome do Contador utilizado pela Chave Primária
     *
     * @return void
     */
    public function __construct($p_NomeTabela=null, $p_ChavePrimaria=null, $p_NomeContador=null){
        try{
            $this->_nomeTabela = $this::PREFIXO.$p_NomeTabela;
            $this->_chavePrimaria = $p_ChavePrimaria;
            $this->_nomeContador = $p_NomeContador;

            $this->_conexao = self::getConnection();
            if (isset($_SESSION['USUARIO'])){
                $sisUsuario = unserialize($_SESSION['USUARIO']);
                if (isset($sisUsuario)) {
                    if ($sisUsuario instanceof UsuarioContexto){
                        $this->_idUsuario = (isset($sisUsuario->Id))? $sisUsuario->Id: null;
                    } else {
                        $this->_idUsuario = null;
                    }
                }
            }
        } catch (PDOException $ex){ throw $ex; }
    }
    
    /**
     *  função que destroi a classe, mas antes fecha a conexão com o banco de dados
     *  @return void
     */
    function __destruct(){
        $this->Close();
    }
    
    /**
     *  função para conectar a conexão com o Banco de Dados
     *
     *  @return object $con Objeto PDO conectado ao banco
     */    
    public function getConnection(){
        try{
            // PDO::ATTR_ERRMODE {PDO::ERRMODE_SILENT, PDO::ERRMODE_WARNING, PDO::ERRMODE_EXCEPTION}
            // realiza a conexão
            //$this->con = new PDO($this->dbType.":host=".$this->host.";dbname=".$this->db, $this->user, $this->senha, array( PDO::ATTR_PERSISTENT => $this->persistent, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ) );
            //$this->con = new PDO($this->dbType.":host=".$this->host.";dbname=".$this->db, $this->user, $this->senha, array( PDO::ATTR_PERSISTENT => $this->persistent ) );
            //$this->con = new PDO($this->dbType.":host=".$this->host.";dbname=".$this->db.";charset=".$this->charset, $this->user, $this->senha, array( PDO::ATTR_PERSISTENT => $this->persistent, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".$this->charset ) );
            //$this->con = new PDO($this->dbType.":host=".$this->host.";dbname=".$this->db, $this->user, $this->senha, $options);
            
            if ($this->dbType=='sqlsrv') {
                $options = array(
                    //PDO::ATTR_PERSISTENT => true, 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                );
                $this->con = new PDO($this->dbType.":Server=".$this->host.";Database=".$this->db, $this->user, $this->senha, $options); // PDO_SQLSRV
                
            } else if ($this->dbType=='odbc') {
                $options = array(
                    PDO::ATTR_PERSISTENT => $this->persistent, 
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                );
                //$this->con = new PDO($this->dbType.":".$this->db, $this->user, $this->senha, $options); // PDO_ODBC
                $this->con = new PDO($this->dbType.":Driver={SQL Server};Server=".$this->host.";Database=".$this->db.";Uid=". $this->user.";Pwd=".$this->senha, $this->user, $this->senha, $options); // PDO_ODBC >> SQLSERVER
                
            } else if ($this->dbType=='mysql') {
                $options = array(
                    //PDO::ATTR_PERSISTENT => true, 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_PERSISTENT => $this->persistent,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                );
                $this->con = new PDO($this->dbType.":host=".$this->host.";dbname=".$this->db, $this->user, $this->senha, $options);			
                
            } else {
                $options = array(
                    //PDO::ATTR_PERSISTENT => true, 
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                );
                $this->con = new PDO($this->dbType.":host=".$this->host.";dbname=".$this->db, $this->user, $this->senha, $options);
                
            }
            return $this->con;
    
        }catch ( PDOException $ex ){ 
            $response = new stdClass();
            $response->sucesso = 0;
            $response->erro = $ex->getCode();
            $response->dbType = $this->dbType;
            $response->dbhost = $this->host;
            $response->dbname = $this->db;
            $response->mensagem = utf8_encode($ex->getMessage());
            //$response->notas = utf8_encode($ex->getTraceAsString());

            // Response por JSON
            if(ob_get_length()>0){ob_end_clean();}
            header('Content-type: text/json; charset=utf-8');
            header('Content-type: application/json; charset=utf-8');
            exit(json_encode($response));            
        }
     
    }

    /**
     *  função para desconectar a conexão com o Banco de Dados
     * 
     *  @return void
     */
    public function Close(){
        if($this->con != null){
            $this->con = null;
        }
    }

    /**
     *  função para definir a Paginação da lista de registro
     *
     *  @param int $p_Pagina O número da página que sera exibida
     *  @param int $p_TamanhoPagina A quantidade de registro por página
     * 
     *  @return string $Resultado Uma strig contendo o limite dos registro
     */
    public static function definirPaginacao($p_Pagina, $p_TamanhoPagina = null){    

            if ($p_Pagina){ self::$_PaginaAtual = $p_Pagina;}
            if ($p_TamanhoPagina){ self::$_TamanhoPagina = $p_TamanhoPagina;}
            if (!self::$_PaginaAtual){ self::$_PaginaAtual = 1;}

            self::$_RegistroAtual = (self::$_PaginaAtual - 1) * self::$_TamanhoPagina;
            if (self::$_RegistroAtual > self::$_TotalRegistros){ self::$_RegistroAtual = self::$_TotalRegistros; } //self::$_RegistroAtual = 0;

            self::$_TotalPaginas = floor(self::$_TotalRegistros / self::$_TamanhoPagina);
            if ((self::$_TotalRegistros % self::$_TamanhoPagina) > 0){
                self::$_TotalPaginas++;
            }

            //return ' LIMIT '. self::$_TamanhoPagina .' OFFSET '. self::$_RegistroAtual;
            //return ' LIMIT '. self::$_RegistroAtual .', '. self::$_TamanhoPagina;
            return ' LIMIT '. self::$_TamanhoPagina .' OFFSET '. self::$_RegistroAtual;
    }

    /**
     *  função para consumir um Contador
     *
     *  @param string $p_Chave A Chave do contador que deverá ser consumido
     * 
     *  @return string $contador Retorno o número do Contador passado por parametro
     * 
     *  @example <br />
     *  $proxMatricula = PDOConnection::getContador('matricula');<br />
     * 
     */    
    public function getContador($p_Chave){
        try{

            $contador = 0;
            if (!$this->_conexao){ $this->_conexao = $this->getConnection(); }// Verificar conexão
            
            // Iniciar Transação
            //$this->_conexao->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
            $this->_conexao->beginTransaction();
            if ($this->dbType=='pgsql'){

                $p_Chave = self::PREFIXO.$p_Chave.'_seq';

                // Pegar ultimo Contador
                $stmt = $this->_conexao->prepare("SELECT nextval('$p_Chave') AS contador");
                $stmt->execute();
                $rs = $stmt->fetch(PDO::FETCH_ASSOC);
                if($rs){
                    $contador = $rs['contador'];
                } else {
                    $contador = 0;
                }

            }else if ($this->dbType=='mysql'){
                // Pegar ultimo Contador
                $stmt = $this->_conexao->prepare("SELECT contador FROM ".self::PREFIXO."contador WHERE chave='$p_Chave' LOCK IN SHARE MODE");
                $stmt->execute();
                $rs = $stmt->fetch(PDO::FETCH_ASSOC);
                if($rs){
                    $contador = $rs['contador'];
                } 
                $contador++;

                // Incrementa o Contador
                $stmt = $this->_conexao->prepare("INSERT INTO ".self::PREFIXO."contador (chave, contador) VALUES ('$p_Chave', (@contador:=1)) ON DUPLICATE KEY UPDATE contador = (@contador:=contador+1)");
                $stmt->execute();
                
            }else if (($this->dbType=='sqlsrv') || ($this->dbType=='odbc')){ 
                // Pegar ultimo Contador
                $stmt = $this->_conexao->prepare("SELECT contador FROM ".self::PREFIXO."contador WHERE chave='$p_Chave'");
                //$stmt = $this->_conexao->prepare("SELECT NextId as contador FROM Nextid WHERE name='$p_Chave'"); // SGO
                $stmt->execute();
                $rs = $stmt->fetch(PDO::FETCH_ASSOC);
                if($rs){
                    $contador = $rs['contador'];
                } 
                $contador++;

                // Incrementa o Contador
                $stmt = $this->_conexao->prepare("UPDATE ".self::PREFIXO."contador SET data_acao=".$this::NOW.", acao='incrementar', id_usuario_acao=".$this->_idUsuario.", contador=$contador WHERE chave='$p_Chave'");
                //$stmt = $this->_conexao->prepare("UPDATE NextId SET Nextid=$contador WHERE name='$p_Chave'");
                $stmt->execute();
                
            }else { // MYSQL
                // Pegar ultimo Contador
                $stmt = $this->_conexao->prepare("SELECT contador FROM ".self::PREFIXO."contador WHERE chave='$p_Chave' LOCK IN SHARE MODE");
                $stmt->execute();
                $rs = $stmt->fetch(PDO::FETCH_ASSOC);
                if($rs){
                    $contador = $rs['contador'];
                } 
                $contador++;

                // Incrementa o Contador
                $stmt = $this->_conexao->prepare("INSERT INTO ".self::PREFIXO."contador (chave, contador) VALUES ('$p_Chave', (@contador:=1)) ON DUPLICATE KEY UPDATE contador = (@contador:=contador+1)");
                $stmt->execute();
            }
            
            // Executar a Transação Completa
            $this->_conexao->commit();
            //$this->_conexao->setAttribute(PDO::ATTR_AUTOCOMMIT, TRUE);
            
            return $contador;
            
            // caso ocorra um erro, retorna o erro;
        }catch ( PDOException $ex ){ 
            // Desfazer a Transação caso ocorra erro.
            $this->_conexao->rollBack();
            //throw new PDOException("PDO Failed: " . $ex->getMessage(), $ex->getCode());
            throw new Exception($ex);
        }
     
    }

    /**
     *  função para dar suporte a lastInsertId aos drives: (ODBC)
     *
     *  @param string $p_Chave A Chave do contador que deverá ser consumido caso seja diferente do padrão.
     * 
     *  @return string $contador Retorno o número do Contador passado por parametro
     * 
     *  @example <br />
     *  $Indentificador = 'cad_usuario_id_usuario_seq';<br />
     *  $Indentificador = 'id_usuario_seq';<br />
     * 
     */    
    public function getInsertId($p_Chave=null){
        try{
            $Identificador = 0;

            // Verifica o Drive que esta sendo utilizado
            if ($this->dbType=='pgsql'){
                if (!$p_Chave){
                    $p_Chave = $this->_nomeTabela.'_'.$this->_chavePrimaria.'_seq';
                }
                $Identificador = $this->_conexao->lastInsertId($p_Chave);

            }else if ($this->dbType=='mysql'){
                //$query = " SELECT SCOPE_IDENTITY() AS ".$this->_chavePrimaria.";";
                
                $Identificador = $this->_conexao->lastInsertId();

            }else if ($this->dbType=='sqlsrv'){
                $Identificador = $this->_conexao->lastInsertId();

            }else if ($this->dbType=='odbc'){ 
                $query = " SELECT @@IDENTITY AS ".$this->_chavePrimaria.";";
                $stmt = $this->_conexao->query($query);
                //$stmt->execute();
                $rs = $stmt->fetch(PDO::FETCH_ASSOC);
                $Identificador = $rs[$this->_chavePrimaria];
                
            }else { // Outros
            
            }
            return $Identificador;
            
        } catch (PDOException $ex){ throw $ex; }     
    }

}