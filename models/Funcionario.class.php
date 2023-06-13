<?php
/**
 * Classe de negócio Funcionario
 */
class Funcionario extends Modelo{

    private $_IdFuncionario;
	private $_Cpf;
	private $_CodigoCartao;
	private $_IdTipoColaborador;
	private $_TipoColaborador;
	private $_TipoColaboradorAtivo;
	
	private $_NomeFuncionario;
    private $_Vinculo;
	private $_Modalidade;
	
	private $_OrigemUO;
    private $_IdUoAlocacao;
	private $_UoAlocacao;
	private $_UoAlocacaoAtivo;	
    private $_JornadaTrabalho;
	private $_DescricaoJornada;
	private $_QtdMascaras;
	private $_Horario;
	
	private $_Observacao;
   
    private $_DataCadastro;
	private $_Acao;
	private $_DataAcao;
	private $_IdUsuarioAcao;
	private $_NomeUsuarioAcao;
	private $_Ativo;
	private $_Deletado;

    function __construct(){
        parent::__construct();
    }
    
	
    public function setIdFuncionario( $p_IdFuncionario ){ $this->_IdFuncionario = $p_IdFuncionario; }
    public function getIdFuncionario(){ return $this->_IdFuncionario; }

    public function setCpf( $p_Cpf ){ $this->_Cpf = $p_Cpf; }
    public function getCpf(){ return $this->_Cpf; }

    public function setCodigoCartao( $p_CodigoCartao ){ $this->_CodigoCartao = $p_CodigoCartao; }
    public function getCodigoCartao(){ return $this->_CodigoCartao; }	

    public function setIdTipoColaborador( $p_IdTipoColaborador ){ $this->_IdTipoColaborador = $p_IdTipoColaborador; }
    public function getIdTipoColaborador(){ return $this->_IdTipoColaborador; }		
	
    public function setTipoColaborador( $p_TipoColaborador ){ $this->_TipoColaborador = $p_TipoColaborador; }
    public function getTipoColaborador(){ return $this->_TipoColaborador; }	
	
    public function setTipoColaboradorAtivo( $p_TipoColaboradorAtivo ){ $this->_TipoColaboradorAtivo = $p_TipoColaboradorAtivo; }
    public function getTipoColaboradorAtivo(){ return $this->_TipoColaboradorAtivo; }	
	
    public function setNomeFuncionario( $p_NomeFuncionario ){ $this->_NomeFuncionario = $p_NomeFuncionario; }
    public function getNomeFuncionario(){ return $this->_NomeFuncionario; }

    public function setVinculo( $p_Vinculo ){ $this->_Vinculo = $p_Vinculo; }
    public function getVinculo(){ return $this->_Vinculo; }

    public function setModalidade( $p_Modalidade ){ $this->_Modalidade = $p_Modalidade; }
    public function getModalidade(){ return $this->_Modalidade; }	

    public function setOrigemUO( $p_OrigemUO ){ $this->_OrigemUO = $p_OrigemUO; }
    public function getOrigemUO(){ return $this->_OrigemUO; }	

    public function setIdUoAlocacao( $p_IdUoAlocacao ){ $this->_IdUoAlocacao = $p_IdUoAlocacao; }
    public function getIdUoAlocacao(){ return $this->_IdUoAlocacao; }

    public function setUoAlocacao( $p_UoAlocacao ){ $this->_UoAlocacao = $p_UoAlocacao; }
    public function getUoAlocacao(){ return $this->_UoAlocacao; }

    public function setUoAlocacaoAtivo( $p_UoAlocacaoAtivo ){ $this->_UoAlocacaoAtivo = $p_UoAlocacaoAtivo; }
    public function getUoAlocacaoAtivo(){ return $this->_UoAlocacaoAtivo; }	
	
    public function setJornadaTrabalho( $p_JornadaTrabalho ){ $this->_JornadaTrabalho = $p_JornadaTrabalho; }
    public function getJornadaTrabalho(){ return $this->_JornadaTrabalho; }

    public function setDescricaoJornada( $p_DescricaoJornada ){ $this->_DescricaoJornada = $p_DescricaoJornada; }
    public function getDescricaoJornada(){ return $this->_DescricaoJornada; }	

    public function setQtdMascaras( $p_QtdMascaras ){ $this->_QtdMascaras = $p_QtdMascaras; }
    public function getQtdMascaras(){ return $this->_QtdMascaras; }	
	
    public function setHorario( $p_Horario ){ $this->_Horario = $p_Horario; }
    public function getHorario(){ return $this->_Horario; }
	
    public function setObservacao( $p_Observacao ){ $this->_Observacao = $p_Observacao;}
    public function getObservacao(){ return $this->_Observacao; }	

    public function setDataCadastro( $p_DataCadastro ){ $this->_DataCadastro = $p_DataCadastro; }
    public function getDataCadastro(){ return $this->_DataCadastro; }

    public function setAcao( $p_Acao ){ $this->_Acao = $p_Acao; }
    public function getAcao(){ return $this->_Acao; }

    public function setDataAcao( $p_DataAcao ){ $this->_DataAcao = $p_DataAcao; }
    public function getDataAcao(){ return $this->_DataAcao; }

    public function setIdUsuarioAcao( $p_IdUsuarioAcao ){ $this->_IdUsuarioAcao = $p_IdUsuarioAcao; }
    public function getIdUsuarioAcao(){ return $this->_IdUsuarioAcao; }	

    public function setNomeUsuarioAcao( $p_NomeUsuarioAcao ){ $this->_NomeUsuarioAcao = $p_NomeUsuarioAcao; }
    public function getNomeUsuarioAcao(){ return $this->_NomeUsuarioAcao; }		

    public function setAtivo( $p_Ativo ){ $this->_Ativo = $p_Ativo; }
    public function getAtivo(){ return $this->_Ativo; }

    public function setDeletado( $p_Deletado ){ $this->_Deletado = $p_Deletado; }
    public function getDeletado(){ return $this->_Deletado; }

}