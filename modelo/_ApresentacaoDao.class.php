<?php
require_once ("PDOConnectionFactory.class.php");
// require_once("Apresentacao.class.php");
require_once ('../admin/interface/iApresentacao.php');

/*
 * Programado por: Rodolpho de Paula 28/11/2013
 */
class ApresentacaoDao extends PDOConnectionFactory implements iApresentacao {
	
	// irá receber uma conexão
	private $_conexao = null;
	private $_mensagem = null;
	private $_erro = null;
	private $_idUsuario = null;
	
	/*
	 * //Construtor function __construct(){}
	 */
	
	// Destrutor
	function __destruct() {
		$this->_conexao = null;
	}
	
	// constructor
	function __construct() {
		try {
			$this->_conexao = PDOConnectionFactory::getConnection ();
			$this->_mensagem = '';
			$this->_idUsuario = (isset ( $_SESSION ['USO_ID'] )) ? $_SESSION ['USO_ID'] : 1;
		} catch ( PDOException $ex ) {
			echo "Erro: " . $ex->getMessage ();
		}
	}
	public function setMensagem($p_nome) {
		$this->_mensagem = $p_mensagem;
	}
	public function getMensagem() {
		return $this->_mensagem;
	}
	
	/**
	 * função interna para carregar objeto com os dados do registro.
	 *
	 * @param object $Item
	 *        	O Objeto do tipo Registro do Banco de Dados
	 * @return object $Modelo O Objeto do tipo do Modelo desta classe
	 */
	private static function carregarModelo($p_Item) {
		try {
			if ($p_Item) {
				$obj = new Apresentacao ();
				$obj->setIdApresentacao ( $p_Item ['id_apresentacao'] );
				$obj->setTitulo ( $p_Item ['titulo'] );
				$obj->setTitulo ( $p_Item ['conteudo'] );
				$obj->setTitulo ( $p_Item ['data_cadastro'] );
				$obj->setTitulo ( $p_Item ['ativo'] );
				
				return $obj;
			} else
				return null;
		} catch ( Exception $ex ) {
			throw new Exception ( $ex->getMessage (), $ex->getCode () );
		}
	}
	public function getApresentacaoName(Apresentacao $objApresentacao) {
		try {
			$query = "SELECT * FROM cad_apresentacao a
		                        WHERE a.ativo=1 and a.id_apresentacao=" . $objApresentacao->getIdApresentacao () . ";";
			
			// echo $query;
			$rs = $this->_conexao->query ( $query );
			if ($rs) {
				$listagem = array ();
				foreach ( $rs as $item ) {
					$listagem [] = self::carregarModelo ( $item );
				}
				return $listagem;
			} else {
				$this->_erro = $this->_conexao->errorInfo ();
				throw new PDOException ( '<b>Erro ao executar a Query.</b><br/>' . $this->_erro [2] );
			}
		} catch ( PDOException $ex ) {
			$this->_mensagem = $ex->getMessage ();
			return null;
		}
	}
}