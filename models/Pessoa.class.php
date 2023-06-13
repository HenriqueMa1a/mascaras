<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Pessoa PARA O NOVO MODELO DE FORMULÁRIO DE INSCRIÇÃO
 * 
 * @package Model
 * @category Model
 * @since   2016-10-24
 * @version 1.6
 * @author  Kellen Nery
 * 
 *       
 */
class Pessoa extends Modelo{
    
    private $_Id;
    private $_NomeCompleto;
    private $_NomeCracha;
    private $_Cpf;
	private $_Passaporte;	
    private $_Email;
    private $_Senha;
    private $_Telefone;
    private $_DataNascimento;
	private $_IdPais;
    private $_IdEstado;
    private $_IdCidade;
    private $_Graduacao;
    private $_PosGraduacao;
    private $_Mestrado;
    private $_Doutorado;
    private $_PosDoutorado;
    private $_Colaborador;
    private $_ViceDiretoria;
    private $_Empresa;
    private $_Cargo;
    private $_Resumo;
    private $_DataAcao;
    private $_Status;
    
    public function setId( $p_Id ){ $this->_Id = $p_Id; }
    public function getId(){ return $this->_Id; }
    
    public function setNomeCompleto( $p_NomeCompleto ){ $this->_NomeCompleto = $p_NomeCompleto; }
    public function getNomeCompleto(){ return $this->_NomeCompleto; }

    public function setNomeCracha( $p_NomeCracha ){ $this->_NomeCracha = $p_NomeCracha; }
    public function getNomeCracha(){ return $this->_NomeCracha; }

    public function setCpf( $p_Cpf ){ $this->_Cpf = $p_Cpf; }
    public function getCpf(){ return $this->_Cpf; }
	
    public function setPassaporte( $p_Passaporte ){ $this->_Passaporte = $p_Passaporte; }
    public function getPassaporte(){ return $this->_Passaporte; }

    public function setEmail( $p_Email ){ $this->_Email = $p_Email; }
    public function getEmail(){ return $this->_Email; }
	
    public function setEmail2( $p_Email2 ){ $this->_Email2 = $p_Email2; }
    public function getEmail2(){ return $this->_Email2; }	

    public function setSenha( $p_Senha ){ $this->_Senha = $p_Senha; }
    public function getSenha(){ return $this->_Senha; }
	
    public function setSenha2( $p_Senha2 ){ $this->_Senha2 = $p_Senha2; }
    public function getSenha2(){ return $this->_Senha2; }
    
    public function setTelefone( $p_Telefone ){ $this->_Telefone = $p_Telefone; }
    public function getTelefone(){ return $this->_Telefone; }
    
    public function setDataNascimento( $p_DataNascimento ){ $this->_DataNascimento = $p_DataNascimento; }
    public function getDataNascimento(){  return $this->_DataNascimento; }
	
    public function setIdPais( $p_IdPais ){ $this->_IdPais = $p_IdPais; }
    public function getIdPais(){  return $this->_IdPais; }	
	
    public function setNomePais( $p_NomePais ){ $this->_NomePais = $p_NomePais; }
    public function getNomePais(){  return $this->_NomePais; }

    public function setIdEstado( $p_IdEstado ){ $this->_IdEstado = $p_IdEstado; }
    public function getIdEstado(){  return $this->_IdEstado; }

    public function setNomeEstado( $p_NomeEstado ){ $this->_NomeEstado = $p_NomeEstado; }
    public function getNomeEstado(){  return $this->_NomeEstado; }

    public function setIdCidade( $p_IdCidade ){ $this->_IdCidade = $p_IdCidade; }
    public function getIdCidade(){ return $this->_IdCidade; }
	
    public function setNomeCidade( $p_NomeCidade ){ $this->_NomeCidade = $p_NomeCidade; }
    public function getNomeCidade(){ return $this->_NomeCidade; }	
    
    public function setGraduacao( $p_Graduacao ){ $this->_Graduacao = $p_Graduacao; }
    public function getGraduacao(){ return $this->_Graduacao; }
    
    public function setPosGraduacao( $p_PosGraduacao ){ $this->_PosGraduacao = $p_PosGraduacao; }
    public function getPosGraduacao(){ return $this->_PosGraduacao; }
    
    public function setMestrado( $p_Mestrado ){ $this->_Mestrado = $p_Mestrado;}
    public function getMestrado(){ return $this->_Mestrado; }

    public function setDoutorado( $p_Doutorado ){ $this->_Doutorado = $p_Doutorado; }
    public function getDoutorado(){ return $this->_Doutorado; }

    public function setPosDoutorado( $p_PosDoutorado ){ $this->_PosDoutorado = $p_PosDoutorado; }
    public function getPosDoutorado(){ return $this->_PosDoutorado; }

    public function setColaborador( $p_Colaborador ){ $this->_Colaborador = $p_Colaborador; }
    public function getColaborador(){ return $this->_Colaborador; }
    
    public function setViceDiretoria( $p_ViceDiretoria ){ $this->_ViceDiretoria = $p_ViceDiretoria; }
    public function getViceDiretoria(){ return $this->_ViceDiretoria; }
    
    public function setEmpresa( $p_Empresa ){ $this->_Empresa = $p_Empresa; }
    public function getEmpresa(){ return $this->_Empresa; }

    public function setCargo( $p_Cargo ){ $this->_Cargo = $p_Cargo; }
    public function getCargo(){ return $this->_Cargo; }

    public function setResumo( $p_Resumo ){ $this->_Resumo = $p_Resumo; }
    public function getResumo(){ return $this->_Resumo; }

    public function setCritica( $p_Critica ){ $this->_Critica = $p_Critica;}
    public function getCritica(){ return $this->_Critica; }    
	
    public function setDataAcao( $p_DataAcao ){ $this->_DataAcao = $p_DataAcao;}
    public function getDataAcao(){ return $this->_DataAcao; } 

    public function setIdStatus( $p_IdStatus ){ $this->_IdStatus = $p_IdStatus;}
    public function getIdStatus(){ return $this->_IdStatus; } 

    public function setNomeStatus( $p_NomeStatus ){ $this->_NomeStatus = $p_NomeStatus;}
    public function getNomeStatus(){ return $this->_NomeStatus; } 	

    public function setDataCadastro( $p_DataCadastro ){ $this->_DataCadastro = $p_DataCadastro;}
    public function getDataCadastro(){ return $this->_DataCadastro; } 
	
    public function setDataInscricao( $p_DataInscricao ){ $this->_DataInscricao = $p_DataInscricao;}
    public function getDataInscricao(){ return $this->_DataInscricao; } 	
}