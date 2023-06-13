<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Usuário
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
class Usuario extends Modelo{
 
	private $_Id;
    private $_Chave;
    private $_IdTipo;
    private $_NomeTipo;
    private $_IdStatus;
    private $_NomeStatus;
    private $_Conta;
    private $_Nome;
    private $_DataNascimento = '00:00:00';
    private $_CPF;
    private $_Email;
    private $_Observacao;
    private $_Telefone;
    private $_Celular;
    private $_Imagem;	
    private $_TotalAcesso = 0;
    private $_DataAcesso = '00:00:00';
    private $_IdPerfil = 0;
    private $_NomePerfil;
    private $_Ativo; 
    private $_DataCadastro; 
    private $_Deletado; 
    private $_Acao; 
    private $_IdUsuarioAcao; 
    private $_DataAcao; 

	private $_IdPosto;
	private $_Senha;

    function __construct(){
        parent::__construct();
    }

    public function setId( $p_Id ){ $this->_Id = $p_Id; }
    public function getId(){ return $this->_Id; }

    public function setChave( $p_Chave ){ $this->_Chave = $p_Chave; }
    public function getChave(){ return $this->_Chave; }

	public function setIdTipo( $p_IdTipo ){ $this->_IdTipo = $p_IdTipo; }
    public function getIdTipo(){ return $this->_IdTipo; }

    public function setNomeTipo( $p_NomeTipo ){ $this->_NomeTipo = $p_NomeTipo; }
    public function getNomeTipo(){ return $this->_NomeTipo; }

    public function setIdStatus( $p_IdStatus ){ $this->_IdStatus = $p_IdStatus; }
    public function getIdStatus(){ return $this->_IdStatus; }

    public function setNomeStatus( $p_NomeStatus ){ $this->_NomeStatus = $p_NomeStatus; }
    public function getNomeStatus(){ return $this->_NomeStatus; }	
	
    public function setConta( $p_Conta ){ $this->_Conta = $p_Conta; }
    public function getConta(){ return $this->_Conta; }

    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }

    public function setDataNascimento( $p_DataNascimento ){ $this->_DataNascimento = $p_DataNascimento;}
    public function getDataNascimento(){ return $this->_DataNascimento; }
	
    public function setCPF( $p_CPF ){ $this->_CPF = $p_CPF; }
    public function getCPF(){ return $this->_CPF; }

    public function setEmail( $p_Email ){ $this->_Email = $p_Email;}
    public function getEmail(){ return $this->_Email; }

    public function setObservacao( $p_Observacao ){ $this->_Observacao = $p_Observacao;}
    public function getObservacao(){ return $this->_Observacao; }
	
    public function setTelefone( $p_Telefone ){ $this->_Telefone = $p_Telefone;}
    public function getTelefone(){ return $this->_Telefone; }

    public function setCelular( $p_Celular ){ $this->_Celular = $p_Celular;}
    public function getCelular(){ return $this->_Celular; }

    public function setImagem( $p_Imagem ){ $this->_Imagem = $p_Imagem;}
    public function getImagem(){ return $this->_Imagem; }

    public function setTotalAcesso( $p_TotalAcesso ){ $this->_TotalAcesso = $p_TotalAcesso;}
    public function getTotalAcesso(){ return $this->_TotalAcesso; }

    public function setDataAcesso( $p_DataAcesso ){ $this->_DataAcesso = $p_DataAcesso;}
    public function getDataAcesso(){ return $this->_DataAcesso; }

    public function setIdPerfil( $p_IdPerfil ){ $this->_IdPerfil = $p_IdPerfil;}
    public function getIdPerfil(){ return $this->_IdPerfil; }

    public function setNomePerfil( $p_NomePerfil ){ $this->_NomePerfil = $p_NomePerfil; }
    public function getNomePerfil(){ return $this->_NomePerfil; }

    public function setAtivo( $p_Ativo ){ $this->_Ativo = $p_Ativo; }
    public function getAtivo(){ return $this->_Ativo; }
	
    public function setDataCadastro( $p_DataCadastro ){ $this->_DataCadastro = $p_DataCadastro; }
    public function getDataCadastro(){ return $this->_DataCadastro; }	
	
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
	
    public function setIdPosto( $p_IdPosto ){ $this->_IdPosto = $p_IdPosto; }
    public function getIdPosto(){ return $this->_IdPosto; }	

    public function setSenha( $p_Senha ){ $this->_Senha = $p_Senha; }
    public function getSenha(){ return $this->_Senha; }			
}