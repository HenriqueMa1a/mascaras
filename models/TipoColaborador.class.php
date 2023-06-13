<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio TipoColaborador
 */
class TipoColaborador extends Modelo{

    private $_IdTipoColaborador;
    private $_Descricao;
	private $_Ativo;
	private $_Deletado;
	private $_DataCadastro;
	private $_Acao;
	private $_DataAcao;
	private $_IdUsuarioAcao;

    function __construct(){
        parent::__construct();
    }
    
    public function setIdTipoColaborador( $p_IdTipoColaborador ){ $this->_IdTipoColaborador = $p_IdTipoColaborador; }
    public function getIdTipoColaborador(){ return $this->_IdTipoColaborador; }

    public function setDescricao( $p_Descricao ){ $this->_Descricao = $p_Descricao; }
    public function getDescricao(){ return $this->_Descricao; }
	
	public function setAtivo( $p_Ativo ){ $this->_Ativo = $p_Ativo; }
    public function getAtivo(){ return $this->_Ativo; }

	public function setDeletado( $p_Deletado ){ $this->_Deletado = $p_Deletado; }
    public function getDeletado(){ return $this->_Deletado; }	
	
	public function setDataCadastro( $p_DataCadastro ){ $this->_DataCadastro = $p_DataCadastro; }
    public function getDataCadastro(){ return $this->_DataCadastro; }

	public function setAcao( $p_Acao ){ $this->_Acao = $p_Acao; }
    public function getAcao(){ return $this->_Acao; }

	public function setDataAcao( $p_DataAcao ){ $this->_DataAcao = $p_DataAcao; }
    public function getDataAcao(){ return $this->_DataAcao; }

	public function setIdUsuarioAcao( $p_IdUsuarioAcao ){ $this->_IdUsuarioAcao = $p_IdUsuarioAcao; }
    public function getIdUsuarioAcao(){ return $this->_IdUsuarioAcao; }

}