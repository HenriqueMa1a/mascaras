<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio TipoUsuario
 */
class PerfilAcesso extends Modelo{

    private $_IdPerfil;
    private $_Sigla;
    private $_Nome;
	private $_Ativo;
	private $_Revisao;
	private $_Deletado;
	private $_Acao;
	private $_DataAcao;
	private $_IdUsuarioAcao;
	private $_NomeUsuarioAcao;

    function __construct(){
        parent::__construct();
    }
    
    public function setIdPerfil( $p_IdPerfil ){ $this->_IdPerfil = $p_IdPerfil; }
    public function getIdPerfil(){ return $this->_IdPerfil; }

    public function setSigla( $p_Sigla ){ $this->_Sigla = $p_Sigla; }
    public function getSigla(){ return $this->_Sigla; }
	
    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }	

	public function setAtivo( $p_Ativo ){ $this->_Ativo = $p_Ativo; }
    public function getAtivo(){ return $this->_Ativo; }
	
	public function setRevisao( $p_Revisao ){ $this->_Revisao = $p_Revisao; }
    public function getRevisao(){ return $this->_Revisao; }	
	
    public function setDeletado( $p_Deletado ){ $this->_Deletado = $p_Deletado; }
    public function getDeletado(){ return $this->_Deletado; }

	public function setAcao( $p_Acao ){ $this->_Acao = $p_Acao; }
    public function getAcao(){ return $this->_Acao; }

	public function setDataAcao( $p_DataAcao ){ $this->_DataAcao = $p_DataAcao; }
    public function getDataAcao(){ return $this->_DataAcao; }

	public function setIdUsuarioAcao( $p_IdUsuarioAcao ){ $this->_IdUsuarioAcao = $p_IdUsuarioAcao; }
    public function getIdUsuarioAcao(){ return $this->_IdUsuarioAcao; }

    public function setNomeUsuarioAcao( $p_NomeUsuarioAcao ){ $this->_NomeUsuarioAcao = $p_NomeUsuarioAcao; }
    public function getNomeUsuarioAcao(){ return $this->_NomeUsuarioAcao; }	
}