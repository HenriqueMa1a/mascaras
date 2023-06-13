<?php
/**
* @description Classe de negócio Usuario. 
* @author Kellen Nery
* @date 22/03/2012
* @version 1.0
* @package MDS
* @copyright www.asasolucoes.com
*/
class Usuario {
	
	// Variaveis privadas
	private $_Id;
	private $_IdTipoUsuario;
	private $_NomeTipoUsuario;
	private $_IdStatusUsuario;
	private $_NomeStatusUsuario;
	private $_IdPais;
	private $_IdEstado;
	private $_NomeEstado;
	private $_Apelido;
	private $_Codigo;
	private $_Nome;
	private $_Descricao;
	private $_Cpf;
	private $_DataNascimento = '';
	private $_Email;
	private $_Senha;
	private $_FlagColaborador = 0;
	private $_UnidadeExterna;
	private $_ViceDiretoria;
	private $_Departamento;
	private $_Complemento;
	private $_Divisao;
	private $_Secao;
	private $_AreaAtuacao;
	private $_Cidade;
	private $_Uf;
	private $_Ddd;
	private $_Telefone;
	private $_CanalComunicacao = 0;
	private $_FlagPolitica = 0;
	private $_FlagPolitica1 = 0;
	private $_FlagPolitica2 = 0;
	private $_TotalAcesso = 0;
	private $_DataAcesso = '00:00:00';
	private $_FormacaoAcademica = 0;
	private $_FlagResumo = 0;
	private $_Politica = 0;
	private $_DataInclusao = '00:00:00';
	private $_Perfil = 0; /* Perfil:(1=Digitador, 2=Aprovador, 4= ... , 256=Gerente e 512=Administrador.) 1023=Todos os perfis */
	private $_Gerente = 0;
	private $_Admin = 0;
	private $_Ativo = 0;
	private $_AutorizadoPor = 0;
	private $_NomeChefiaImediata;
	private $_NomeGerenteDepartamento;
	private $_NomeViceDiretoria;
	public function __construct() {
	}
	public function __destruct() {
	}
	
	// Funçoes publicas (GET e SET)
	public function setId($p_Id) {
		$this->_Id = $p_Id;
	}
	public function getId() {
		return $this->_Id;
	}
	public function setIdTipoUsuario($p_IdTipoUsuario) {
		$this->_IdTipoUsuario = $p_IdTipoUsuario;
	}
	public function getIdTipoUsuario() {
		return $this->_IdTipoUsuario;
	}
	public function setNomeTipoUsuario($p_NomeTipoUsuario) {
		$this->_NomeTipoUsuario = $p_NomeTipoUsuario;
	}
	public function getNomeTipoUsuario() {
		return $this->_NomeTipoUsuario;
	}
	public function setIdStatusUsuario($p_IdStatusUsuario) {
		$this->_IdStatusUsuario = $p_IdStatusUsuario;
	}
	public function getIdStatusUsuario() {
		return $this->_IdStatusUsuario;
	}
	public function setNomeStatusUsuario($p_NomeStatusUsuario) {
		$this->_NomeStatusUsuario = $p_NomeStatusUsuario;
	}
	public function getNomeStatusUsuario() {
		return $this->_NomeStatusUsuario;
	}
	public function setIdPais($p_IdPais) {
		$this->_IdPais = $p_IdPais;
	}
	public function getIdPais() {
		return $this->_IdPais;
	}
	public function setIdEstado($p_IdEstado) {
		$this->_IdEstado = $p_IdEstado;
	}
	public function getIdEstado() {
		return $this->_IdEstado;
	}
	public function setNomeEstado($p_NomeEstado) {
		$this->_NomeEstado = $p_NomeEstado;
	}
	public function getNomeEstado() {
		return $this->_NomeEstado;
	}
	public function setCodigo($p_Codigo) {
		$this->_Codigo = $p_Codigo;
	}
	public function getCodigo() {
		if (! $this->_Codigo)
			$this->_Codigo = 'uso_' . substr ( '000000' . $this->_Id, strlen ( '000000' . $this->_Id ) - (6) );
		return $this->_Codigo;
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
	public function setApelido($p_Apelido) {
		$this->_Apelido = $p_Apelido;
	}
	public function getApelido() {
		return $this->_Apelido;
	}
	public function setCpf($p_Cpf) {
		$this->_Cpf = $p_Cpf;
	}
	public function getCpf() {
		return $this->_Cpf;
	}
	public function setDataNascimento($p_DataNascimento) {
		$this->_DataNascimento = $p_DataNascimento;
	}
	public function getDataNascimento() {
		return $this->_DataNascimento;
	}
	public function setEmail($p_Email) {
		$this->_Email = $p_Email;
	}
	public function getEmail() {
		return $this->_Email;
	}
	public function setSenha($p_Senha) {
		$this->_Senha = $p_Senha;
	}
	public function getSenha() {
		return $this->_Senha;
	}
	public function setFlagColaborador($p_FlagColaborador) {
		$this->_FlagColaborador = $p_FlagColaborador;
	}
	public function getFlagColaborador() {
		return $this->_FlagColaborador;
	}
	public function setViceDiretoria($p_ViceDiretoria) {
		$this->_ViceDiretoria = $p_ViceDiretoria;
	}
	public function getViceDiretoria() {
		return $this->_ViceDiretoria;
	}
	public function setUnidadeExterna($p_UnidadeExterna) {
		$this->_UnidadeExterna = $p_UnidadeExterna;
	}
	public function getUnidadeExterna() {
		return $this->_UnidadeExterna;
	}
	public function setDepartamento($p_Departamento) {
		$this->_Departamento = $p_Departamento;
	}
	public function getDepartamento() {
		return $this->_Departamento;
	}
	public function setComplemento($p_Complemento) {
		$this->_Complemento = $p_Complemento;
	}
	public function getComplemento() {
		return $this->_Complemento;
	}
	public function setDivisao($p_Divisao) {
		$this->_Divisao = $p_Divisao;
	}
	public function getDivisao() {
		return $this->_Divisao;
	}
	public function setSecao($p_Secao) {
		$this->_Secao = $p_Secao;
	}
	public function getSecao() {
		return $this->_Secao;
	}
	public function setAreaAtuacao($p_AreaAtuacao) {
		$this->_AreaAtuacao = $p_AreaAtuacao;
	}
	public function getAreaAtuacao() {
		return $this->_AreaAtuacao;
	}
	public function setCidade($p_Cidade) {
		$this->_Cidade = $p_Cidade;
	}
	public function getCidade() {
		return $this->_Cidade;
	}
	public function setUf($p_Uf) {
		$this->_Uf = $p_Uf;
	}
	public function getUf() {
		return $this->_Uf;
	}
	public function setDdd($p_Ddd) {
		$this->_Ddd = $p_Ddd;
	}
	public function getDdd() {
		return $this->_Ddd;
	}
	public function setTelefone($p_Telefone) {
		$this->_Telefone = $p_Telefone;
	}
	public function getTelefone() {
		return $this->_Telefone;
	}
	public function setTotalAcesso($p_TotalAcesso) {
		$this->_TotalAcesso = $p_TotalAcesso;
	}
	public function getTotalAcesso() {
		return $this->_TotalAcesso;
	}
	public function setDataAcesso($p_DataAcesso) {
		$this->_DataAcesso = $p_DataAcesso;
	}
	public function getDataAcesso() {
		return $this->_DataAcesso;
	}
	public function setCanalComunicacao($p_CanalComunicacao) {
		$this->_CanalComunicacao = $p_CanalComunicacao;
	}
	public function getCanalComunicacao() {
		return $this->_CanalComunicacao;
	}
	public function setFlagPolitica($p_FlagPolitica) {
		$this->_FlagPolitica = $p_FlagPolitica;
	}
	public function getFlagPolitica() {
		return $this->_FlagPolitica;
	}
	public function setFlagPolitica1($p_FlagPolitica1) {
		$this->_FlagPolitica1 = $p_FlagPolitica1;
	}
	public function getFlagPolitica1() {
		return $this->_FlagPolitica1;
	}
	public function setFlagPolitica2($p_FlagPolitica2) {
		$this->_FlagPolitica2 = $p_FlagPolitica2;
	}
	public function getFlagPolitica2() {
		return $this->_FlagPolitica2;
	}
	public function setFormacaoAcademica($p_FormacaoAcademica) {
		$this->_FormacaoAcademica = $p_FormacaoAcademica;
	}
	public function getFormacaoAcademica() {
		return $this->_FormacaoAcademica;
	}
	public function setFlagResumo($p_FlagResumo) {
		$this->_FlagResumo = $p_FlagResumo;
	}
	public function getFlagResumo() {
		return $this->_FlagResumo;
	}
	public function setPolitica($p_Politica) {
		$this->_Politica = $p_Politica;
	}
	public function getPolitica() {
		return $this->_Politica;
	}
	public function setDataInclusao($p_DataInclusao) {
		$this->_DataInclusao = $p_DataInclusao;
	}
	public function getDataInclusao() {
		return $this->_DataInclusao;
	}
	public function setPerfil($p_Perfil) {
		$this->_Perfil = $p_Perfil;
	}
	public function getPerfil() {
		return $this->_Perfil;
	}
	public function setGerente($p_Gerente) {
		$this->_Gerente = $p_Gerente;
	}
	public function getGerente() {
		return $this->_Gerente;
	}
	public function setAdmin($p_Admin) {
		$this->_Admin = $p_Admin;
	}
	public function getAdmin() {
		return $this->_Admin;
	}
	public function setAtivo($p_Ativo) {
		$this->_Ativo = $p_Ativo;
	}
	public function getAtivo() {
		return $this->_Ativo;
	}
	public function setAutorizadoPor($p_AutorizadoPor) {
		$this->_AutorizadoPor = $p_AutorizadoPor;
	}
	public function getAutorizadoPor() {
		return $this->_AutorizadoPor;
	}
	public function setNomeChefiaImediata($p_NomeChefiaImediata) {
		$this->_NomeChefiaImediata = $p_NomeChefiaImediata;
	}
	public function getNomeChefiaImediata() {
		return $this->_NomeChefiaImediata;
	}
	public function setNomeGerenteDepartamento($p_NomeGerenteDepartamento) {
		$this->_NomeGerenteDepartamento = $p_NomeGerenteDepartamento;
	}
	public function getNomeGerenteDepartamento() {
		return $this->_NomeGerenteDepartamento;
	}
	public function setNomeViceDiretoria($p_NomeViceDiretoria) {
		$this->_NomeViceDiretoria = $p_NomeViceDiretoria;
	}
	public function getNomeViceDiretoria() {
		return $this->_NomeViceDiretoria;
	}
}
?>