<?php
/**
* @description Classe de negócio agenda. 
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright 
*/
class Pais {
	private $_id;
	private $_idRegiao;
	private $_nome;
	private $_nomeRegiao;
	private $_sigla;
	private $_ativo;
	public function __construct($p_id = 0, $p_nome = '', $p_sigla = '', $p_ativo = 0) {
		$this->setId ( $p_id );
		$this->setNome ( $p_nome );
		$this->setSigla ( $p_sigla );
		$this->setAtivo ( $p_ativo );
	}
	public function setId($p_id) {
		$this->_id = $p_id;
	}
	public function getId() {
		return $this->_id;
	}
	public function setNome($p_nome) {
		$this->_nome = $p_nome;
	}
	public function getNome() {
		return $this->_nome;
	}
	public function setSigla($p_sigla) {
		$this->_sigla = $p_sigla;
	}
	public function getSigla() {
		return $this->_sigla;
	}
	public function setAtivo($p_ativo) {
		$this->_ativo = $p_ativo;
	}
	public function getAtivo() {
		return $this->_ativo;
	}
}
?>