<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio JornadaTrabalho
 */
class JornadaTrabalho extends Modelo{

    private $_IdJornada;
    private $_Descricao;
    private $_QtdMascaras;
	private $_Deletado;
	private $_Acao;
	private $_DataAcao;
	private $_IdUsuarioAcao;
	private $_NomeUsuarioAcao;

    function __construct(){
        parent::__construct();
    }
    
    public function setIdJornada( $p_IdJornada ){ $this->_IdJornada = $p_IdJornada; }
    public function getIdJornada(){ return $this->_IdJornada; }

    public function setDescricao( $p_Descricao ){ $this->_Descricao = $p_Descricao; }
    public function getDescricao(){ return $this->_Descricao; }
	
    public function setQtdMascaras( $p_QtdMascaras ){ $this->_QtdMascaras = $p_QtdMascaras; }
    public function getQtdMascaras(){ return $this->_QtdMascaras; }	
	
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