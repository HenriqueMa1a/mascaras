<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Endereço
 * 
 * @package Model
 * @category Model
 * @since   2015-05-21
 * @version 1.6
 * @author  Kellen Nery
 * 
 * 
 * @edit    2020-12-01<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Implementação da Documentação
 *          #1.15
 */
class Endereco extends Modelo{
    
    private $_IdEmpresa = null;
    private $_NomeEmpresa;
    private $_IdPessoa = null;
    private $_NomePessoa;

    private $_Tipo;
    private $_Descricao;
    private $_Logradouro;
    private $_Numero;
    private $_Complemento;
    private $_Bairro;
    private $_CEP;
    private $_IdCidade = null;
    private $_Cidade;
    private $_UF;
    private $_IdPais = null;
    private $_NomePais;
    private $_Observacao;

    private $_IdStatus = null;
    private $_NomeStatus;
     
    public function __construct($p_IdEmpresa=null, $p_IdPessoa=null, $p_Tipo=null, $p_Descricao=null, $p_Logradouro=null, $p_Numero=null, $p_Complemento=null, $p_Bairro=null, $p_CEP=null, $p_IdCidade=null, $p_Cidade=null, $p_IdPais=null, $p_UF=null, $p_Observacao=null, $p_IdStatus=null)
    {
        parent::__construct();
        $this->_IdEmpresa = $p_IdEmpresa;
        $this->_IdPessoa = $p_IdPessoa;
        $this->_Tipo = $p_Tipo;
        $this->_Descricao = $p_Descricao;
        $this->_Logradouro = $p_Logradouro;
        $this->_Numero = $p_Numero;
        $this->_Complemento = $p_Complemento;
        $this->_Bairro = $p_Bairro;
        $this->_IdCidade = $p_IdCidade;
        $this->_Cidade = $p_Cidade;
        $this->_IdPais = $p_IdPais;
        $this->_UF = $p_UF;
        $this->_Observacao = $p_Observacao;
        $this->_IdStatus = $p_IdStatus;
    }
    
    public function setIdEmpresa( $p_IdEmpresa ){ $this->_IdEmpresa = $p_IdEmpresa; }
    public function getIdEmpresa(){ return $this->_IdEmpresa; }

    public function setNomeEmpresa( $p_NomeEmpresa ){ $this->_NomeEmpresa = $p_NomeEmpresa; }
    public function getNomeEmpresa(){ return $this->_NomeEmpresa; }

    public function setIdPessoa( $p_IdPessoa ){ $this->_IdPessoa = $p_IdPessoa; }
    public function getIdPessoa(){ return $this->_IdPessoa; }
    
    public function setNomePessoa( $p_NomePessoa ){ $this->_NomePessoa = $p_NomePessoa; }
    public function getNomePessoa(){ return $this->_NomePessoa; }

    public function setTipo( $p_Tipo ){ $this->_Tipo = $p_Tipo; }
    public function getTipo(){ return $this->_Tipo; }
    
    public function setDescricao( $p_Descricao ){ $this->_Descricao = $p_Descricao; }
    public function getDescricao(){ return $this->_Descricao; }

    public function setLogradouro( $p_Logradouro ){ $this->_Logradouro = $p_Logradouro;}
    public function getLogradouro(){ return $this->_Logradouro; }

    public function setNumero( $p_Numero ){ $this->_Numero = $p_Numero;}
    public function getNumero(){ return $this->_Numero; }

    public function setComplemento( $p_Complemento ){ $this->_Complemento = $p_Complemento;}
    public function getComplemento(){ return $this->_Complemento; }
    
    public function setBairro( $p_Bairro ){ $this->_Bairro = $p_Bairro;}
    public function getBairro(){ return $this->_Bairro; }

    public function setCEP( $p_CEP ){ $this->_CEP = $p_CEP;}
    public function getCEP(){ return $this->_CEP; }
    
    public function setIdCidade( $p_IdCidade ){ $this->_IdCidade = $p_IdCidade; }
    public function getIdCidade(){ return $this->_IdCidade; }
    
    public function setCidade( $p_Cidade ){ $this->_Cidade = $p_Cidade;}
    public function getCidade(){ return $this->_Cidade; }
    
    public function setIdPais( $p_IdPais ){ $this->_IdPais = $p_IdPais; }
    public function getIdPais(){ return $this->_IdPais; }

    public function setNomePais( $p_NomePais ){ $this->_NomePais = $p_NomePais; }
    public function getNomePais(){ return $this->_NomePais; }

    public function setUF( $p_UF ){ $this->_UF = $p_UF;}
    public function getUF(){ return $this->_UF; }

    public function setObservacao( $p_Observacao ){ $this->_Observacao = $p_Observacao;}
    public function getObservacao(){ return $this->_Observacao; }
    
    public function setIdStatus( $p_IdStatus ){ $this->_IdStatus = $p_IdStatus; }
    public function getIdStatus(){ return $this->_IdStatus; }
    
    public function setNomeStatus( $p_NomeStatus ){ $this->_NomeStatus = $p_NomeStatus; }
    public function getNomeStatus(){ return $this->_NomeStatus; }
   
}