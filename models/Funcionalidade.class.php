<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Funcionalidade
 * 
 */
class Funcionalidade extends Modelo{

    private $_IdFuncionalidade;
    private $_IdModulo;
    private $_DescricaoModulo;
    private $_Operacao;
    private $_Funcao;
    private $_Nome;
    private $_Descricao;
    private $_Imagem;
    private $_Ordem;
    private $_Parametros;
    private $_Ativo;
	private $_Revisao;
    private $_Deletado;
    private $_Acao;
    private $_IdUsuarioAcao;
    private $_NomeUsuarioAcao;
    private $_DataAcao;

    function __construct(){
        parent::__construct();
    }

    public function setIdFuncionalidade( $p_IdFuncionalidade ){ $this->_IdFuncionalidade = $p_IdFuncionalidade; }
    public function getIdFuncionalidade(){ return $this->_IdFuncionalidade; }

    public function setIdModulo( $p_IdModulo ){ $this->_IdModulo = $p_IdModulo; }
    public function getIdModulo(){ return $this->_IdModulo; }

    public function setDescricaoModulo( $p_DescricaoModulo ){ $this->_DescricaoModulo = $p_DescricaoModulo; }
    public function getDescricaoModulo(){ return $this->_DescricaoModulo; }

    public function setOperacao( $p_Operacao ){ $this->_Operacao = $p_Operacao; }
    public function getOperacao(){ return $this->_Operacao; }

    public function setFuncao( $p_Funcao ){ $this->_Funcao = $p_Funcao; }
    public function getFuncao(){ return $this->_Funcao; }

    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }
	
    public function setDescricao( $p_Descricao ){ $this->_Descricao = $p_Descricao; }
    public function getDescricao(){ return $this->_Descricao; }

    public function setImagem( $p_Imagem ){ $this->_Imagem = $p_Imagem; }
    public function getImagem(){ return $this->_Imagem; }

    public function setOrdem( $p_Ordem ){ $this->_Ordem = $p_Ordem; }
    public function getOrdem(){ return $this->_Ordem; }

    public function setParametros( $p_Parametros ){ $this->_Parametros = $p_Parametros; }
    public function getParametros(){ return $this->_Parametros; }

    public function setAtivo( $p_Ativo ){ $this->_Ativo = $p_Ativo; }
    public function getAtivo(){ return $this->_Ativo; }

    public function setRevisao( $p_Revisao ){ $this->_Revisao = $p_Revisao; }
    public function getRevisao(){ return $this->_Revisao; }

    public function setDeletado( $p_Deletado ){ $this->_Deletado = $p_Deletado; }
    public function getDeletado(){ return $this->_Deletado; }

    public function setAcao( $p_Acao ){ $this->_Acao = $p_Acao; }
    public function getAcao(){ return $this->_Acao; }

    public function setIdUsuarioAcao( $p_IdUsuarioAcao ){ $this->_IdUsuarioAcao = $p_IdUsuarioAcao; }
    public function getIdUsuarioAcao(){ return $this->_IdUsuarioAcao; }	
	
    public function setNomeUsuarioAcao( $p_NomeUsuarioAcao ){ $this->_NomeUsuarioAcao = $p_NomeUsuarioAcao; }
    public function getNomeUsuarioAcao(){ return $this->_NomeUsuarioAcao; }	

    public function setDataAcao( $p_DataAcao ){ $this->_DataAcao = $p_DataAcao; }
    public function getDataAcao(){ return $this->_DataAcao; }	

}