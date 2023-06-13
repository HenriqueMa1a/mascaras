<?php
/**
* @description Classe de negócio Perfil. 
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* 
*/
class Perfil {
	private $_id;
	private $_nome;
	private $_ativo;
	public function __construct($p_id = 0, $p_nome = '', $p_ativo = 0) {
		$this->setId ( $p_id );
		$this->setNome ( $p_nome );
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
	public function setAtivo($p_ativo) {
		$this->_ativo = $p_ativo;
	}
	public function getAtivo() {
		return $this->_ativo;
	}
}
?>