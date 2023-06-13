<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio EventoParticipante
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
class EventoParticipante extends Modelo{

    private $_IdEvento;
    private $_NomeEvento;
	private $_IdParente;
	private $_NameEvent;
    private $_IdParticipante;
    private $_NomeParticipante;
	private $_IdTipoParticipante;	
    private $_Nome;
    private $_Observacao;
    private $_IdStatus;
    private $_NomeStatus;
    private $_DataCadastro;
    private $_IdUsuarioAprovacao;
    private $_NomeUsuarioAprovacao;
    private $_DataAprovacao;
    private $_Capacidade=0;
    private $_Solicitacoes=0;
    private $_Aprovados=0;
    private $_Saldo=0;
    private $_IdTipoEvento;
    private $_DataInicial;
    private $_DataFinal;	
	private $_EventoAtivo;
	
    function __construct(){
        parent::__construct();
    }
    
    public function setIdEvento( $p_IdEvento ){ $this->_IdEvento = $p_IdEvento; }
    public function getIdEvento(){ return $this->_IdEvento; }
	
    public function setIdParente( $p_IdParente ){ $this->_IdParente = $p_IdParente; }
    public function getIdParente(){ return $this->_IdParente; }	

    public function setNomeEvento( $p_NomeEvento ){ $this->_NomeEvento = $p_NomeEvento; }
    public function getNomeEvento(){ return $this->_NomeEvento; }
	
    public function setNameEvent( $p_NameEvent ){ $this->_NameEvent = $p_NameEvent; }
    public function getNameEvent(){ return $this->_NameEvent; }

    public function setIdParticipante( $p_IdParticipante ){ $this->_IdParticipante = $p_IdParticipante; }
    public function getIdParticipante(){ return $this->_IdParticipante; }

    public function setNomeParticipante( $p_NomeParticipante ){ $this->_NomeParticipante = $p_NomeParticipante; }
    public function getNomeParticipante(){ return $this->_NomeParticipante; }
		
    public function setIdTipoParticipante( $p_IdTipoParticipante ){ $this->_IdTipoParticipante = $p_IdTipoParticipante; }
    public function getIdTipoParticipante(){ return $this->_IdTipoParticipante; }
	
    public function setNomeTipo( $p_NomeTipo ){ $this->_NomeTipo = $p_NomeTipo; }
    public function getNomeTipo(){  return $this->_NomeTipo; }		

    public function setObservacao( $p_Observacao ){ $this->_Observacao = $p_Observacao;}
    public function getObservacao(){ return $this->_Observacao; }
    
    public function setIdStatus( $p_IdStatus ){ $this->_IdStatus = $p_IdStatus; }
    public function getIdStatus(){ return $this->_IdStatus; }

    public function setNomeStatus( $p_NomeStatus ){ $this->_NomeStatus = $p_NomeStatus; }
    public function getNomeStatus(){ return $this->_NomeStatus; }

    public function setDataCadastro( $p_DataCadastro ){ $this->_DataCadastro = $p_DataCadastro; }
    public function getDataCadastro(){ return $this->_DataCadastro; }

    public function setIdUsuarioAprovacao( $p_IdUsuarioAprovacao ){ $this->_IdUsuarioAprovacao = $p_IdUsuarioAprovacao; }
    public function getIdUsuarioAprovacao(){ return $this->_IdUsuarioAprovacao; }
    
    public function setNomeUsuarioAprovacao( $p_NomeUsuarioAprovacao ){ $this->_NomeUsuarioAprovacao = $p_NomeUsuarioAprovacao; }
    public function getNomeUsuarioAprovacao(){ return $this->_NomeUsuarioAprovacao; }

    public function setDataAprovacao( $p_DataAprovacao ){ $this->_DataAprovacao = $p_DataAprovacao; }
    public function getDataAprovacao(){ return $this->_DataAprovacao; }

    public function setCapacidade( $p_Capacidade ){ $this->_Capacidade = $p_Capacidade; }
    public function getCapacidade(){ return $this->_Capacidade; }
    
    public function setSolicitacoes( $p_Solicitacoes ){ $this->_Solicitacoes = $p_Solicitacoes; }
    public function getSolicitacoes(){ return $this->_Solicitacoes; }
    
    public function setAprovados( $p_Aprovados ){ $this->_Aprovados = $p_Aprovados; }
    public function getAprovados(){ return $this->_Aprovados; }
    
    public function setReprovados( $p_Reprovados ){ $this->_Reprovados = $p_Reprovados; }
    public function getReprovados(){ return $this->_Reprovados; }

    public function setSaldo( $p_Saldo ){ $this->_Saldo = $p_Saldo; }
    public function getSaldo(){ return $this->_Saldo; }
	
    public function setIdTipoEvento( $p_IdTipoEvento ){ $this->_IdTipoEvento = $p_IdTipoEvento; }
    public function getIdTipoEvento(){ return $this->_IdTipoEvento; } 
	
    public function setDataInicial( $p_DataInicial ){ $this->_DataInicial = $p_DataInicial; }
    public function getDataInicial(){ return $this->_DataInicial; } 
	
    public function setDataFinal( $p_DataFinal ){ $this->_DataFinal = $p_DataFinal; }
    public function getDataFinal(){ return $this->_DataFinal; } 	
	
    public function setCpf( $p_Cpf ){ $this->_Cpf = $p_Cpf; }
    public function getCpf(){ return $this->_Cpf; } 	
	
    public function setPassaporte( $p_Passaporte ){ $this->_Passaporte = $p_Passaporte; }
    public function getPassaporte(){ return $this->_Passaporte; } 		
	
    public function setEmail( $p_Email ){ $this->_Email = $p_Email; }
    public function getEmail(){ return $this->_Email; }    

    public function setEventoAtivo( $p_EventoAtivo ){ $this->_EventoAtivo = $p_EventoAtivo; }
    public function getEventoAtivo(){ return $this->_EventoAtivo; } 	
    
}