<?php
/**
* @description Classe de negócio Conteudo. 
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright 
*/
class Conteudo {
	private $_Id = 0;
	private $_IdUsuario = 0;
	private $_NomeUsuario;
	private $_Tipo = 0;
	private $_Titulo = '';
	private $_Autores = '';
	private $_Instituicao = '';
	private $_Conteudo = '';
	private $_Arquivo = '';
	private $_IdUsuarioAprovacao = 0;
	private $_NomeUsuarioAprovacao = '';
	private $_DataAprovacao;
	private $_ObsAprovacao = '';
	private $_Nota = 0;
	private $_IdStatus = 0;
	private $_IdOriginal = 0;
	private $_Revisao = 0;
	private $_FlagPolitica = 0;
	private $_Ativo = 0;
	private $_IdUsuarioInclusao = 0;
	private $_DataInclusao;
	private $_IdUsuarioAlteracao = 0;
	private $_DataAlteracao;
	public function __construct() {
	}
	public function setId($p_Id) {
		$this->_Id = $p_Id;
	}
	public function getId() {
		return $this->_Id;
	}
	public function setIdUsuario($p_IdUsuario) {
		$this->_IdUsuario = $p_IdUsuario;
	}
	public function getIdUsuario() {
		return $this->_IdUsuario;
	}
	public function setNomeUsuario($p_NomeUsuario) {
		$this->_NomeUsuario = $p_NomeUsuario;
	}
	public function getNomeUsuario() {
		return $this->_NomeUsuario;
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
	public function setAutores($p_Autores) {
		$this->_Autores = $p_Autores;
	}
	public function getAutores() {
		return $this->_Autores;
	}
	public function setInstituicao($p_Instituicao) {
		$this->_Instituicao = $p_Instituicao;
	}
	public function getInstituicao() {
		return $this->_Instituicao;
	}
	public function setConteudo($p_Conteudo) {
		$this->_Conteudo = $p_Conteudo;
	}
	public function getConteudo() {
		return $this->_Conteudo;
	}
	public function setArquivo($p_Arquivo) {
		$this->_Arquivo = $p_Arquivo;
	}
	public function getArquivo() {
		return $this->_Arquivo;
	}
	public function setNota($p_Nota) {
		$this->_Nota = $p_Nota;
	}
	public function getNota() {
		return $this->_Nota;
	}
	public function setIdStatus($p_IdStatus) {
		$this->_IdStatus = $p_IdStatus;
	}
	public function getIdStatus() {
		return $this->_IdStatus;
	}
	public function setIdOriginal($p_IdOriginal) {
		$this->_IdOriginal = $p_IdOriginal;
	}
	public function getIdOriginal() {
		return $this->_IdOriginal;
	}
	public function setRevisao($p_Revisao) {
		$this->_Revisao = $p_Revisao;
	}
	public function getRevisao() {
		return $this->_Revisao;
	}
	public function setFlagPolitica($p_FlagPolitica) {
		$this->_FlagPolitica = $p_FlagPolitica;
	}
	public function getFlagPolitica() {
		return $this->_FlagPolitica;
	}
	public function setAtivo($p_Ativo) {
		$this->_Ativo = $p_Ativo;
	}
	public function getAtivo() {
		return $this->_Ativo;
	}
	public function setIdUsuarioAprovacao($p_IdUsuarioAprovacao) {
		$this->_IdUsuarioAprovacao = $p_IdUsuarioAprovacao;
	}
	public function getIdUsuarioAprovacao() {
		return $this->_IdUsuarioAprovacao;
	}
	public function setNomeUsuarioAprovacao($p_NomeUsuarioAprovacao) {
		$this->_NomeUsuarioAprovacao = $p_NomeUsuarioAprovacao;
	}
	public function getNomeUsuarioAprovacao() {
		return $this->_NomeUsuarioAprovacao;
	}
	public function setDataAprovacao($p_DataAprovacao) {
		$this->_DataAprovacao = $p_DataAprovacao;
	}
	public function getDataAprovacao() {
		return $this->_DataAprovacao;
	}
	public function setObsAprovacao($p_ObsAprovacao) {
		$this->_ObsAprovacao = $p_ObsAprovacao;
	}
	public function getObsAprovacao() {
		return $this->_ObsAprovacao;
	}
	public function setIdUsuarioInclusao($p_IdUsuarioInclusao) {
		$this->_IdUsuarioInclusao = $p_IdUsuarioInclusao;
	}
	public function getIdUsuarioInclusao() {
		return $this->_IdUsuarioInclusao;
	}
	public function setDataInclusao($p_DataInclusao) {
		$this->_DataInclusao = $p_DataInclusao;
	}
	public function getDataInclusao() {
		return $this->_DataInclusao;
	}
	public function setIdUsuarioAlteracao($p_IdUsuarioAlteracao) {
		$this->_IdUsuarioAlteracao = $p_IdUsuarioAlteracao;
	}
	public function getIdUsuarioAlteracao() {
		return $this->_IdUsuarioAlteracao;
	}
	public function setDataAlteracao($p_DataAlteracao) {
		$this->_DataAlteracao = $p_DataAlteracao;
	}
	public function getDataAlteracao() {
		return $this->_DataAlteracao;
	}
}
?>