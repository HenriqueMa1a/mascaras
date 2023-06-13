<?php
/**
 * Classe de negócio Distribuicao
 */
class Distribuicao extends Modelo{

	private $_IdDistribuicao;
	private $_Data;
	private $_IdFuncionario  ;
	private $_NomeFuncionario;
	private $_Modalidade;
	private $_TipoColaborador;
	
	private $_UoCodigo;
	private $_UoAlocacao;
	private $_UoNivel1;
	private $_UoNivel2;
	private $_UoNivel3;
	private $_UoNivel4;
	private $_UoNivel5;
	
	private $_JornadaTrabalho;
	private $_DescricaoJornada;
	
	private $_IdPosto;
	private $_DescricaoPosto;
	private $_Qtde;
	private $_Deletado;
	private $_Acao;
	private $_DataAcao;
	private $_IdUsuarioAcao; 
	private $_NomeUsuarioAcao;

    function __construct(){
        parent::__construct();
    }

    public function setIdDistribuicao( $p_IdDistribuicao ){ $this->_IdDistribuicao = $p_IdDistribuicao; }
    public function getIdDistribuicao(){ return $this->_IdDistribuicao; }
	
    public function setData( $p_Data ){ $this->_Data = $p_Data; }
    public function getData(){ return $this->_Data; }	

    public function setIdFuncionario( $p_IdFuncionario ){ $this->_IdFuncionario = $p_IdFuncionario; }
    public function getIdFuncionario(){ return $this->_IdFuncionario; }

    public function setNomeFuncionario( $p_NomeFuncionario ){ $this->_NomeFuncionario = $p_NomeFuncionario; }
    public function getNomeFuncionario(){ return $this->_NomeFuncionario; }

    public function setModalidade( $p_Modalidade ){ $this->_Modalidade = $p_Modalidade; }
    public function getModalidade(){ return $this->_Modalidade; }
	
    public function setTipoColaborador( $p_TipoColaborador ){ $this->_TipoColaborador = $p_TipoColaborador; }
    public function getTipoColaborador(){ return $this->_TipoColaborador; }

    public function setUoCodigo( $p_UoCodigo ){ $this->_UoCodigo = $p_UoCodigo; }
    public function getUoCodigo(){ return $this->_UoCodigo; }	
	
    public function setUoAlocacao( $p_UoAlocacao ){ $this->_UoAlocacao = $p_UoAlocacao; }
    public function getUoAlocacao(){ return $this->_UoAlocacao; }

    public function setUoNivel1( $p_UoNivel1 ){ $this->_UoNivel1 = $p_UoNivel1; }
    public function getUoNivel1(){ return $this->_UoNivel1; }
	
    public function setUoNivel2( $p_UoNivel2 ){ $this->_UoNivel2 = $p_UoNivel2; }
    public function getUoNivel2(){ return $this->_UoNivel2; }
	
    public function setUoNivel3( $p_UoNivel3 ){ $this->_UoNivel3 = $p_UoNivel3; }
    public function getUoNivel3(){ return $this->_UoNivel3; }

    public function setUoNivel4( $p_UoNivel4 ){ $this->_UoNivel4 = $p_UoNivel4; }
    public function getUoNivel4(){ return $this->_UoNivel4; }

    public function setUoNivel5( $p_UoNivel5 ){ $this->_UoNivel5 = $p_UoNivel5; }
    public function getUoNivel5(){ return $this->_UoNivel5; }	
	
    public function setJornadaTrabalho( $p_JornadaTrabalho ){ $this->_JornadaTrabalho = $p_JornadaTrabalho; }
    public function getJornadaTrabalho(){ return $this->_JornadaTrabalho; }	

    public function setDescricaoJornada( $p_DescricaoJornada ){ $this->_DescricaoJornada = $p_DescricaoJornada; }
    public function getDescricaoJornada(){ return $this->_DescricaoJornada; }		
	
    public function setIdPosto( $p_IdPosto ){ $this->_IdPosto = $p_IdPosto; }
    public function getIdPosto(){ return $this->_IdPosto; }  
	
    public function setDescricaoPosto( $p_DescricaoPosto ){ $this->_DescricaoPosto = $p_DescricaoPosto; }
    public function getDescricaoPosto(){ return $this->_DescricaoPosto; }  	
	
    public function setQtde( $p_Qtde ){ $this->_Qtde = $p_Qtde; }
    public function getQtde(){ return $this->_Qtde; }  	

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