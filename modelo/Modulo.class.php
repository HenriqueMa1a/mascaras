<?php
/**
* @description Classe de negócio agenda. 
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright 
*/
class Modulo {
	private $_Id;
	private $_IdModuloPai;
	private $_Chave;
	private $_Nome;
	private $_Descricao;
	private $_Imagem;
	private $_Nivel = 0;
	private $_Ordem = 0;
	private $_TotalVisitas = 0;
	private $_Ativo;
	public function __construct() {
	}
	public function setId($p_Id) {
		$this->_Id = $p_Id;
	}
	public function getId() {
		return $this->_Id;
	}
	public function setIdModuloPai($p_IdModuloPai) {
		$this->_IdModuloPai = $p_IdModuloPai;
	}
	public function getIdModuloPai() {
		return $this->_IdModuloPai;
	}
	public function setChave($p_Chave) {
		$this->_Chave = $p_Chave;
	}
	public function getChave() {
		return $this->_Chave;
	}
	public function setNome($p_Nome) {
		$this->_Nome = $p_Nome;
	}
	public function getNome() {
		return $this->_Nome;
	}
	public function setDescricao($p_Descricao) {
		$this->_Descricao = $p_Descricao;
	}
	public function getDescricao() {
		return $this->_Descricao;
	}
	public function setImagem($p_Imagem) {
		$this->_Imagem = $p_Imagem;
	}
	public function getImagem() {
		return $this->_Imagem;
	}
	public function setNivel($p_Nivel) {
		$this->_Nivel = $p_Nivel;
	}
	public function getNivel() {
		return $this->_Nivel;
	}
	public function setOrdem($p_Ordem) {
		$this->_Ordem = $p_Ordem;
	}
	public function getOrdem() {
		return $this->_Ordem;
	}
	public function setTotalVisitas($p_TotalVisitas) {
		$this->_TotalVisitas = $p_TotalVisitas;
	}
	public function getTotalVisitas() {
		return $this->_TotalVisitas;
	}
	public function setAtivo($p_Ativo) {
		$this->_Ativo = $p_Ativo;
	}
	public function getAtivo() {
		return $this->_Ativo;
	}
}
?>