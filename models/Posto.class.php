<?php
/**
 * Classe de negócio Posto de Entrega
 */
class Posto extends Modelo{
	
	private $_IdPosto;
	private $_Descricao;
	private $_Responsavel;
	private $_DataCadastro;
	private $_Ativo;
	private $_Deletado;
	private $_Acao;
	private $_DataAcao;
	private $_IdUsuarioAcao;	
	private $_NomeUsuarioAcao;

    function __construct(){
        parent::__construct();
    }
    
	
    public function setIdPosto( $p_IdPosto ){ $this->_IdPosto = $p_IdPosto; }
    public function getIdPosto(){ return $this->_IdPosto; }
	
    public function setDescricao( $p_Descricao ){ $this->_Descricao = $p_Descricao; }
    public function getDescricao(){ return $this->_Descricao; }

    public function setResponsavel( $p_Responsavel ){ $this->_Responsavel = $p_Responsavel; }
    public function getResponsavel(){ return $this->_Responsavel; }	

    public function setDataCadastro( $p_DataCadastro ){ $this->_DataCadastro = $p_DataCadastro; }
    public function getDataCadastro(){ return $this->_DataCadastro; }

    public function setAtivo( $p_Ativo ){ $this->_Ativo = $p_Ativo; }
    public function getAtivo(){ return $this->_Ativo; }

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