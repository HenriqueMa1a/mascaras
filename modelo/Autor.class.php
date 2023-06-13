<?php
/**
* @description Classe de negócio Autor. 
* @author Rodolpho de Paula
* @date 22/01/2012
* @version 1.0
* @package MDS
* @copyright 
*/
class Autor {
	private $_IdAutor = 0;
	private $_IdResumo = 0;
	private $_Nome = '';
	private $_Intituicao = '';
	private $_email = '';
	private $_Justificativa = '';
	private $_FlagPrincipal = 0;
	private $_FlagApresentador = 0;
	private $_Datacadastro;
	public function __construct() {
	}
	public function setIdAutor($p_IdAutor) {
		$this->_IdAutor = $p_IdAutor;
	}
	public function getIdAutor() {
		return $this->_IdAutor;
	}
	public function setIdResumo($p_IdResumo) {
		$this->_IdResumo = $p_IdResumo;
	}
	public function getIdResumo() {
		return $this->_IdResumo;
	}
	public function setNome($p_Nome) {
		$this->_Nome = $p_Nome;
	}
	public function getNome() {
		return $this->_Nome;
	}
	public function setInstituicao($p_Instituicao) {
		$this->_Instituicao = $p_Instituicao;
	}
	public function getInstituicao() {
		return $this->_Instituicao;
	}
	public function setEmail($p_Email) {
		$this->_Email = $p_Email;
	}
	public function getEmail() {
		return $this->_Email;
	}
	public function setJustificativa($p_Justificativa) {
		$this->_Justificativa = $p_Justificativa;
	}
	public function getJustificativa() {
		return $this->_Justificativa;
	}
	public function setFlagPrincipal($p_FlagPrincipal) {
		$this->_FlagPrincipal = $p_FlagPrincipal;
	}
	public function getFlagPrincipal() {
		return $this->_FlagPrincipal;
	}
	public function setFlagApresentador($p_FlagApresentador) {
		$this->_FlagApresentador = $p_FlagApresentador;
	}
	public function getFlagApresentador() {
		return $this->_FlagApresentador;
	}
	public function setDatacadastro($p_Datacadastro) {
		$this->_Datacadastro = $p_Datacadastro;
	}
	public function getDatacadastro() {
		return $this->_Datacadastro;
	}
}

