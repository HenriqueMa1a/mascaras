<?php
/**
* @description Classe DAO para a tabela agenda. Data Access Object que irá fazer operações na tabela Agenda (básica: Insert, Update, Delete e Lista)
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright Bio-Manguinhos|Fiocruz
*/
require_once ("PDOConnectionFactory.class.php");
require_once ("Ano.class.php");
class AnoDAO extends PDOConnectionFactory {
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
	
	// realiza uma inserção
	public function salva($obj) {
	}
	
	// realiza um Select
	public function retorna($id) {
	}
	
	// realiza um Update
	public function atualiza($obj) {
	}
	
	// remove um registro
	public function remove($id) {
	}
	
	// desativa um registro
	public function desativa($id) {
	}
	
	// retorna uma lista de objetos
	public function lista($IdRegiao = null, $IdEstado = null, $IdInstituicao = null) {
		try {
			$filtro = '';
			if ($IdRegiao)
				$filtro .= " AND q.id_regiao=$IdRegiao ";
			if ($IdEstado)
				$filtro .= " AND q.id_estado=$IdEstado ";
			if ($IdInstituicao)
				$filtro .= " AND q.id_instituicao=$IdInstituicao ";
			
			$query = "SELECT DISTINCT q.ano 
                        FROM cad_questao q
                        WHERE q.fl_ativo=1 $filtro
                        ORDER BY ano;";
			// echo $query;
			$rs = $this->_conexao->query ( $query );
			
			if ($rs) {
				$listagem = array ();
				foreach ( $rs as $item ) {
					$obj = new Ano ();
					$obj->setNumero ( $item ["ano"] );
					// echo $obj->getNome()." - ".$obj->getSigla()."<br/>";
					$listagem [] = $obj;
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
?>