<?php
/*
 * Programado por: Rodolpho de Paula 28/11/2013
 */
class Apresentacao {
	private $_Id = 0;
	private $_IdUsuario = 0;
	private $_Tipo = 0;
	private $_Titulo = '';
	private $_Conteudo = 0;
	private $_Ativo = 0;
	private $_DataInclusao;
	private $_DataAlteracao;
	public function __construct() {
	}
	public function setId($p_Id) {
		$this->_Id = $p_Id;
	}
	public function getId() {
		return $this->_Id;
	}
	public function setTipo($p_Tipo) {
		$this->_Tipo = $p_Tipo;
	}
	public function getTipo() {
		return $this->_Tipo;
	}
	public function setTitulo($p_Titulo) {
		$this->_Titulo = $p_Titulo;
	}
	public function getTitulo() {
		return $this->_Titulo;
	}
	public function setConteudo($p_Conteudo) {
		$this->_Conteudo = $p_Conteudo;
	}
	public function getConteudo() {
		return $this->_Conteudo;
	}
	public function setAtivo($p_Ativo) {
		$this->_Ativo = $p_Ativo;
	}
	public function getAtivo() {
		return $this->_Ativo;
	}
	public function setDataInclusao($p_DataInclusao) {
		$this->_DataInclusao = $p_DataInclusao;
	}
	public function getDataInclusao() {
		return $this->_DataInclusao;
	}
	public function setDataAlteracao($p_DataAlteracao) {
		$this->_DataAlteracao = $p_DataAlteracao;
	}
	public function getDataAlteracao() {
		return $this->_DataAlteracao;
	}
}
