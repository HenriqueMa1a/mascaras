<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio UO
 */
class Uo extends Modelo{

    private $_IdUo;
    private $_Codigo;
    private $_Sigla;
    private $_Descricao;
	private $_Ativo;
	private $_DataCadastro;
	private $_Acao;
	private $_DataAcao;
	private $_IdUsuarioAcao;

    function __construct(){
        parent::__construct();
    }
    
    public function setIdUo( $p_IdUo ){ $this->_IdUo = $p_IdUo; }
    public function getIdUo(){ return $this->_IdUo; }

    public function setCodigo( $p_Codigo ){ $this->_Codigo = $p_Codigo; }
    public function getCodigo(){ return $this->_Codigo; }

    public function setSigla( $p_Sigla ){ $this->_Sigla = $p_Sigla; }
    public function getSigla(){ return $this->_Sigla; }

    public function setDescricao( $p_Descricao ){ $this->_Descricao = $p_Descricao; }
    public function getDescricao(){ return $this->_Descricao; }
	
	public function setAtivo( $p_Ativo ){ $this->_Ativo = $p_Ativo; }
    public function getAtivo(){ return $this->_Ativo; }

	public function setDataCadastro( $p_DataCadastro ){ $this->_DataCadastro = $p_DataCadastro; }
    public function getDataCadastro(){ return $this->_DataCadastro; }

	public function setAcao( $p_Acao ){ $this->_Acao = $p_Acao; }
    public function getAcao(){ return $this->_Acao; }

	public function setDataAcao( $p_DataAcao ){ $this->_DataAcao = $p_DataAcao; }
    public function getDataAcao(){ return $this->_DataAcao; }

	public function setIdUsuarioAcao( $p_IdUsuarioAcao ){ $this->_IdUsuarioAcao = $p_IdUsuarioAcao; }
    public function getIdUsuarioAcao(){ return $this->_IdUsuarioAcao; }

}