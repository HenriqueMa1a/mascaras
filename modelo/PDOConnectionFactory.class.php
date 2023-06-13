<?php
/**
* @description Classe PDO para Conexao com Banco de Dados.
* @author Kellen Nery
* @date 26/05/2013
* @version 1.0
* @package MDS AsaSolucoes.com
* @copyright www.asasolucoes.com
*/
class PDOConnectionFactory {
	
	
	public $_query = '';
	//
	// recebe a conexуo
	// public $con = null;
	public $con = null;
	
	// qual o banco de dados?
	public $dbType = 'mysql';
	
	// parтmetros de conexуo
	// quando nуo for necessсrio deixe em branco apenas com as aspas duplas ""
	public $host = 'localhost';
	public $user = 'sedes'; // 'root';//'sedes'; // 'usuariosite'; //'root';
	public $senha = 'ALu2RpAWQTQ8Vz9t'; // '123456';//'123@senha'; // ''; //
	public $db = 'sact2017'; // 'sact_desenv'; // 'biosite'; //'seminario';
	                                
	// seta a persistъncia da conexуo
	public $persistent = false;
	
	// parтmetros de paginacao
	private static $_Identificador = 0;
	private static $_RegistroAtual = 0;
	private static $_TotalRegistros = 0;
	private static $_PaginaAtual = 1;
	private static $_TamanhoPagina = 20;
	private static $_TotalPaginas = 0;
	private static $_Trace = 0;
	
	
	/**
	 * funчѕes GET e SET
	 */
	public static function getRegistroAtual() {
		return (self::$_RegistroAtual + 1);
	}
	public static function setRegistroAtual($p_RegistroAtual) {
		self::$_RegistroAtual = $p_RegistroAtual;
	}
	public static function getTotalRegistros() {
		return self::$_TotalRegistros;
	}
	public static function setTotalRegistros($p_TotalRegistros) {
		self::$_TotalRegistros = $p_TotalRegistros;
	}
	public static function getPaginaAtual() {
		return self::$_PaginaAtual;
	}
	public static function getTamanhoPagina() {
		return self::$_TamanhoPagina;
	}
	public static function getTotalPaginas() {
		return self::$_TotalPaginas;
	}
	public static function getIdentificador() {
		return self::$_Identificador;
	}
	
	/**
	 * funчуo Construtor
	 */
	public function __construct($persistent = false) {
		// new PDOConnectionFactory( true ) <--- conexуo persistente
		// new PDOConnectionFactory() <--- conexao nуo persistente
		// verifico a persistъncia da conexao
		if ($persistent != false) {
			$this->persistent = true;
		}
	}
	
	/**
	 * funчуo para conectar a conexуo com o Banco de Dados
	 */
	public function getConnection() {
		try {
			// realiza a conexуo
			// $this->con = new PDO($this->dbType.":host=".$this->host.";dbname=".$this->db, $this->user, $this->senha,
			// array( PDO::ATTR_PERSISTENT => $this->persistent, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ) );
			$this->con = new PDO ( $this->dbType . ":host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->senha, array (
					PDO::ATTR_PERSISTENT => $this->persistent 
			) );
			// realizado com sucesso, retorna conectado
			return $this->con;
			// caso ocorra um erro, retorna o erro;
		} catch ( PDOException $ex ) {
			echo "Erro: " . $ex->getMessage ();
		}
	}
	
	/**
	 * funчуo para desconectar a conexуo com o Banco de Dados
	 */
	public function Close() {
		if ($this->con != null)
			$this->con = null;
	}
	
	/**
	 * funчуo para definir a paginaчуo dos registro
	 *
	 * @param string $p_Query
	 *        	A Query que serс executada no banco de dados
	 * @param int $p_Pagina
	 *        	A Pсgina que serс exibida
	 * @param int $p_TamanhoPagina
	 *        	A Quantidade de registro por pсgina
	 * @return string $Resultado Uma strig contendo o limite dos registro
	 */
	public static function definirPaginacao($p_Pagina, $p_TamanhoPagina = null) {
		if ($p_Pagina)
			self::$_PaginaAtual = $p_Pagina;
		if ($p_TamanhoPagina)
			self::$_TamanhoPagina = $p_TamanhoPagina;
		if (! self::$_PaginaAtual)
			self::$_PaginaAtual = 1;
		
		self::$_RegistroAtual = (self::$_PaginaAtual - 1) * self::$_TamanhoPagina;
		if (self::$_RegistroAtual > self::$_TotalRegistros)
			self::$_RegistroAtual = self::$_TotalRegistros; // self::$_RegistroAtual = 0;
		
		self::$_TotalPaginas = floor ( self::$_TotalRegistros / self::$_TamanhoPagina );
		if ((self::$_TotalRegistros % self::$_TamanhoPagina) > 0)
			self::$_TotalPaginas ++;
			
			// return ' LIMIT '. self::$_TamanhoPagina .' OFFSET '. self::$_RegistroAtual;
		return ' LIMIT ' . self::$_RegistroAtual . ', ' . self::$_TamanhoPagina;
	}
}
?>