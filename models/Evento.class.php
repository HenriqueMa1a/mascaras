<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Evento
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
class Evento extends Modelo{

	private $_IdEvento;
    private $_IdEmpresa;
    private $_IdParente;
    private $_IdLocalizacao;
    private $_NomeLocalizacao;
    private $_IdTipoEvento;
    private $_NomeTipoEvento;
    private $_Sigla;
    private $_Nome;
	private $_Name;
    private $_Descricao;
    private $_Capacidade;
    private $_Solicitacoes=0;
    private $_Aprovados=0;
    private $_Reprovados=0;
    private $_Presentes=0;
    private $_DataInicial;
    private $_DataFinal;
    private $_CargaHoraria;
    private $_TextoCertificado;
    private $_Observacao;
    private $_IdStatus;
    private $_NomeStatus;

    public function setIdEvento( $p_IdEvento ){ $this->_IdEvento = $p_IdEvento; }
    public function getIdEvento(){ return $this->_IdEvento; }
    
    public function setIdEmpresa( $p_IdEmpresa ){ $this->_IdEmpresa = $p_IdEmpresa; }
    public function getIdEmpresa(){ return $this->_IdEmpresa; }

    public function setIdParente( $p_IdParente ){ $this->_IdParente = $p_IdParente; }
    public function getIdParente(){ return $this->_IdParente; }

    public function setIdTipoEvento( $p_IdTipoEvento ){ $this->_IdTipoEvento = $p_IdTipoEvento; }
    public function getIdTipoEvento(){ return $this->_IdTipoEvento; }

    public function setNomeTipoEvento( $p_NomeTipoEvento ){ $this->_NomeTipoEvento = $p_NomeTipoEvento; }
    public function getNomeTipoEvento(){ return $this->_NomeTipoEvento; }

    public function setIdLocalizacao( $p_IdLocalizacao ){ $this->_IdLocalizacao = $p_IdLocalizacao; }
    public function getIdLocalizacao(){ return $this->_IdLocalizacao; }
    
    public function setNomeLocalizacao( $p_NomeLocalizacao ){ $this->_NomeLocalizacao = $p_NomeLocalizacao; }
    public function getNomeLocalizacao(){ return $this->_NomeLocalizacao; }

    public function setSigla( $p_Sigla ){ $this->_Sigla = $p_Sigla;}
    public function getSigla(){ return $this->_Sigla; }

    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }
	
    public function setName( $p_Name ){ $this->_Name = $p_Name; }
    public function getName(){ return $this->_Name; }
    
    public function setDescricao( $p_Descricao ){ $this->_Descricao = $p_Descricao; }
    public function getDescricao(){ return $this->_Descricao; }

    public function setCapacidade( $p_Capacidade ){ $this->_Capacidade = $p_Capacidade; }
    public function getCapacidade(){ return $this->_Capacidade; }

    public function setSolicitacoes( $p_Solicitacoes ){ $this->_Solicitacoes = $p_Solicitacoes; }
    public function getSolicitacoes(){ return $this->_Solicitacoes; }
    
    public function setAprovados( $p_Aprovados ){ $this->_Aprovados = $p_Aprovados; }
    public function getAprovados(){ return $this->_Aprovados; }
    
    public function setReprovados( $p_Reprovados ){ $this->_Reprovados = $p_Reprovados; }
    public function getReprovados(){ return $this->_Reprovados; }
    
    public function setPresentes( $p_Presentes ){ $this->_Presentes = $p_Presentes; }
    public function getPresentes(){ return $this->_Presentes; }

    public function setDataInicial( $p_DataInicial ){ $this->_DataInicial = $p_DataInicial; }
    public function getDataInicial(){ return $this->_DataInicial; }

    public function setDataFinal( $p_DataFinal ){ $this->_DataFinal = $p_DataFinal; }
    public function getDataFinal(){ return $this->_DataFinal; }

    public function setCargaHoraria( $p_CargaHoraria ){ $this->_CargaHoraria = $p_CargaHoraria; }
    public function getCargaHoraria(){ return $this->_CargaHoraria; }

    public function setTextoCertificado( $p_TextoCertificado ){ $this->_TextoCertificado = $p_TextoCertificado; }
    public function getTextoCertificado(){ return $this->_TextoCertificado; }

    public function setObservacao( $p_Observacao ){ $this->_Observacao = $p_Observacao; }
    public function getObservacao(){ return $this->_Observacao; }
    
    public function setIdStatus( $p_IdStatus ){ $this->_IdStatus = $p_IdStatus; }
    public function getIdStatus(){ return $this->_IdStatus; }
    
    public function setNomeStatus( $p_NomeStatus ){ $this->_NomeStatus = $p_NomeStatus; }
    public function getNomeStatus(){ return $this->_NomeStatus; }
    
}