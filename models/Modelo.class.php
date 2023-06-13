<?php
/**
 * Classe de negócio Modelo (contém os campos padrão do banco)
 * 
 * @package Model
 * @category Model
 * @since   2015-05-21
 * @version 2.0
 * @author  Kellen Nery
 * 
 * 
 * @edit    2016-01-19<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Melhoria no Framework 
 *          #1.17
 */
class Modelo{

    private $_Id;
    private $_Ativo=1;
    private $_Revisao=0;
    private $_Deletado;
    private $_IdUsuarioCadastro;
    private $_NomeUsuarioCadastro;
    private $_DataCadastro;
    private $_Acao;
    private $_IdUsuarioAcao;
    private $_NomeUsuarioAcao;
    private $_DataAcao;
    
    function __construct(){
        $this->_Id=0;
        $this->_Revisao=1;
        $this->_Deletado=0;
        $this->_DataCadastro=null;
        $this->_DataAcao=null;
    }
    
    /** @var int Identificador */
    public function setId( $p_Id ){ $this->_Id = $p_Id; }
    public function getId(){ return $this->_Id; }

    /** @var int Flag de Ativo */
    public function setAtivo( $p_Ativo ){ $this->_Ativo = $p_Ativo;}
    public function getAtivo(){ return $this->_Ativo; }
    
    /** @var int Número da Revisao do registro */
    public function setRevisao( $p_Revisao ){ $this->_Revisao = $p_Revisao;}
    public function getRevisao(){ return $this->_Revisao; }
    
    /** @var bool Flag de Excluído */
    public function setDeletado( $p_Deletado ){ $this->_Deletado = $p_Deletado;}
    public function getDeletado(){ return $this->_Deletado; }

    /** @var int Identificador do usuario que cadastrou o registro */
    public function setIdUsuarioCadastro( $p_IdUsuarioCadastro ){ $this->_IdUsuarioCadastro = $p_IdUsuarioCadastro; }
    public function getIdUsuarioCadastro(){ return $this->_IdUsuarioCadastro; }

    /** @var string Nome do usuario que cadastrou o registro */
    public function setNomeUsuarioCadastro( $p_NomeUsuarioCadastro ){ $this->_NomeUsuarioCadastro = $p_NomeUsuarioCadastro; }
    public function getNomeUsuarioCadastro(){ return $this->_NomeUsuarioCadastro; }

    /** @var string Data do cadastro do registro */
    public function setDataCadastro( $p_DataCadastro ){ $this->_DataCadastro = $p_DataCadastro; }
    public function getDataCadastro(){ return $this->_DataCadastro; }
    
    /** @var string Nome da ultima ação */
    public function setAcao( $p_Acao ){ $this->_Acao = $p_Acao; }
    public function getAcao(){ return $this->_Acao; }

    /** @var int Identificador do ultimo usuario que atualizou o registro */
    public function setIdUsuarioAcao( $p_IdUsuarioAcao ){ $this->_IdUsuarioAcao = $p_IdUsuarioAcao; }
    public function getIdUsuarioAcao(){ return $this->_IdUsuarioAcao; }

    /** @var string Nome do ultimo usuario que atualizou o registro */
    public function setNomeUsuarioAcao( $p_NomeUsuarioAcao ){ $this->_NomeUsuarioAcao = $p_NomeUsuarioAcao; }
    public function getNomeUsuarioAcao(){ return $this->_NomeUsuarioAcao; }

    /** @var string Data da ultima ação */
    public function setDataAcao( $p_DataAcao ){ $this->_DataAcao = $p_DataAcao; }
    public function getDataAcao(){ return $this->_DataAcao; }

}