<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Empresa
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
class Empresa extends Modelo{

    private $_IdMatriz;
    private $_NomeMatriz;
    private $_IdTipoEmpresa;
    private $_NomeTipoEmpresa;
    private $_Chave;
    private $_Sigla;
    private $_Nome;
    private $_Imagem;
    private $_RazaoSocial;
    private $_CNPJ;
    private $_Endereco;
    private $_Numero;
    private $_Complemento;
    private $_Bairro;
    private $_CEP;
    private $_Cidade;
    private $_IdEstado;
    private $_UF;
    private $_NomeEstado;
    private $_IdPais;
    private $_NomePais;
    private $_DDD;
    private $_Telefone;
    private $_Fax;
    private $_Outro;
    private $_Email;
    private $_Site;
    private $_Executivo;
    private $_ExecutivoTelefone;
    private $_ExecutivoEmail;
    private $_Contato;
    private $_ContatoTelefone;
    private $_ContatoEmail;
    private $_Observacao;
    
    function __construct(){
        parent::__construct();
    }
    
    public function setIdTipoEmpresa( $p_IdTipoEmpresa ){ $this->_IdTipoEmpresa = $p_IdTipoEmpresa; }
    public function getIdTipoEmpresa(){ return $this->_IdTipoEmpresa; }

    public function setNomeTipoEmpresa( $p_NomeTipoEmpresa ){ $this->_NomeTipoEmpresa = $p_NomeTipoEmpresa; }
    public function getNomeTipoEmpresa(){ return $this->_NomeTipoEmpresa; }
    
    public function setIdMatriz( $p_IdMatriz ){ $this->_IdMatriz = $p_IdMatriz; }
    public function getIdMatriz(){ return $this->_IdMatriz; }

    public function setNomeMatriz( $p_NomeMatriz ){ $this->_NomeMatriz = $p_NomeMatriz; }
    public function getNomeMatriz(){ return $this->_NomeMatriz; }
    
    public function setChave( $p_Chave ){ $this->_Chave = $p_Chave; }
    public function getChave(){ return $this->_Chave; }

    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }
    
    public function setImagem( $p_Imagem ){ $this->_Imagem = $p_Imagem; }
    public function getImagem(){ return $this->_Imagem; }

    public function setSigla( $p_Sigla ){ $this->_Sigla = $p_Sigla;}
    public function getSigla(){ return $this->_Sigla; }
    
    public function setRazaoSocial( $p_RazaoSocial ){ $this->_RazaoSocial = $p_RazaoSocial;}
    public function getRazaoSocial(){ return $this->_RazaoSocial; }
    
    public function setCNPJ( $p_CNPJ ){ $this->_CNPJ = $p_CNPJ;}
    public function getCNPJ(){ return $this->_CNPJ; }

    public function setEndereco( $p_Endereco ){ $this->_Endereco = $p_Endereco;}
    public function getEndereco(){ return $this->_Endereco; }

    public function setNumero( $p_Numero ){ $this->_Numero = $p_Numero;}
    public function getNumero(){ return $this->_Numero; }

    public function setComplemento( $p_Complemento ){ $this->_Complemento = $p_Complemento;}
    public function getComplemento(){ return $this->_Complemento; }
    
    public function setBairro( $p_Bairro ){ $this->_Bairro = $p_Bairro;}
    public function getBairro(){ return $this->_Bairro; }

    public function setCEP( $p_CEP ){ $this->_CEP = $p_CEP;}
    public function getCEP(){ return $this->_CEP; }
    
    public function setCidade( $p_Cidade ){ $this->_Cidade = $p_Cidade;}
    public function getCidade(){ return $this->_Cidade; }

    public function setIdEstado( $p_IdEstado ){ $this->_IdEstado = $p_IdEstado; }
    public function getIdEstado(){ return $this->_IdEstado; }

    public function setUF( $p_UF ){ $this->_UF = $p_UF; }
    public function getUF(){ return $this->_UF; }
    
    public function setNomeEstado( $p_NomeEstado ){ $this->_NomeEstado = $p_NomeEstado; }
    public function getNomeEstado(){ return $this->_NomeEstado; }

    public function setIdPais( $p_IdPais ){ $this->_IdPais = $p_IdPais; }
    public function getIdPais(){ return $this->_IdPais; }
    
    public function setNomePais( $p_NomePais ){ $this->_NomePais = $p_NomePais; }
    public function getNomePais(){ return $this->_NomePais; }
    
    public function setDDD( $p_DDD ){ $this->_DDD = $p_DDD;}
    public function getDDD(){ return $this->_DDD; }
    
    public function setTelefone( $p_Telefone ){ $this->_Telefone = $p_Telefone;}
    public function getTelefone(){ return $this->_Telefone; }
    
    public function setFax( $p_Fax ){ $this->_Fax = $p_Fax;}
    public function getFax(){ return $this->_Fax; }

    public function setEmail( $p_Email ){ $this->_Email = $p_Email;}
    public function getEmail(){ return $this->_Email; }
    
    public function setOutro( $p_Outro ){ $this->_Outro = $p_Outro;}
    public function getOutro(){ return $this->_Outro; }
    
    public function setSite( $p_Site ){ $this->_Site = $p_Site;}
    public function getSite(){ return $this->_Site; }

    public function setContato( $p_Contato ){ $this->_Contato = $p_Contato;}
    public function getContato(){ return $this->_Contato; }

    public function setContatoTelefone( $p_ContatoTelefone ){ $this->_ContatoTelefone = $p_ContatoTelefone;}
    public function getContatoTelefone(){ return $this->_ContatoTelefone; }
    
    public function setContatoEmail( $p_ContatoEmail ){ $this->_ContatoEmail = $p_ContatoEmail;}
    public function getContatoEmail(){ return $this->_ContatoEmail; }
    
    public function setExecutivo( $p_Executivo ){ $this->_Executivo = $p_Executivo;}
    public function getExecutivo(){ return $this->_Executivo; }

    public function setExecutivoTelefone( $p_ExecutivoTelefone ){ $this->_ExecutivoTelefone = $p_ExecutivoTelefone;}
    public function getExecutivoTelefone(){ return $this->_ExecutivoTelefone; }
    
    public function setExecutivoEmail( $p_ExecutivoEmail ){ $this->_ExecutivoEmail = $p_ExecutivoEmail;}
    public function getExecutivoEmail(){ return $this->_ExecutivoEmail; }
    
    public function setObservacao( $p_Observacao ){ $this->_Observacao = $p_Observacao;}
    public function getObservacao(){ return $this->_Observacao; }
    
}