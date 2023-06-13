<?php
/**
* @description Classe de negócio agenda. 
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright 
*/
class ProvaQuestao {
	private $_Id;
	private $_IdProva;
	private $_IdQuestao;
	private $_Ordem = 0;
	private $_Ativo = 0;
	public function __construct($p_Id = 0, $p_IdQuestao = 0, $p_IdProva = 0, $p_Ordem = '', $p_Ativo = 0) {
		$this->setId ( $p_Id );
		$this->setIdQuestao ( $p_IdQuestao );
		$this->setIdProva ( $p_IdProva );
		$this->setOrdem ( $p_Ordem );
		$this->setAtivo ( $p_Ativo );
	}
	public function setId($p_Id) {
		$this->_Id = $p_Id;
	}
	public function getId() {
		return $this->_Id;
	}
	public function setIdProva($p_IdProva) {
		$this->_IdProva = $p_IdProva;
	}
	public function getIdProva() {
		return $this->_IdProva;
	}
	public function setIdQuestao($p_IdQuestao) {
		$this->_IdQuestao = $p_IdQuestao;
	}
	public function getIdQuestao() {
		return $this->_IdQuestao;
	}
	public function setOrdem($p_Ordem) {
		$this->_Ordem = $p_Ordem;
	}
	public function getOrdem() {
		return $this->_Ordem;
	}
	public function setAtivo($p_Ativo) {
		$this->_Ativo = $p_Ativo;
	}
	public function getAtivo() {
		return $this->_Ativo;
	}
}
?>