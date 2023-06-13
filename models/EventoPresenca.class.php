<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio EventoPresencao
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
class EventoPresenca extends Modelo{

    private $_Id;
	private $_Chave;
    private $_IdEvento;
    private $_NomeEvento;
    private $_IdParticipante;
    private $_NomeParticipante;
    private $_Credencial;
    private $_NomeCracha;
    private $_Entrada;
    private $_Saida;
    private $_Observacao;
    private $_CargaHoraria;
    
    function __construct(){
        parent::__construct();
    }

	public function setId( $p_Id ){ $this->_Id = $p_Id; }
    public function getId(){ return $this->_Id; }
    
    public function setChave( $p_Chave ){ $this->_Chave = $p_Chave;}
    public function getChave(){ return $this->_Chave; }

    public function setIdEvento( $p_IdEvento ){ $this->_IdEvento = $p_IdEvento; }
    public function getIdEvento(){ return $this->_IdEvento; }

    public function setNomeEvento( $p_NomeEvento ){ $this->_NomeEvento = $p_NomeEvento; }
    public function getNomeEvento(){ return $this->_NomeEvento; }

    public function setIdParticipante( $p_IdParticipante ){ $this->_IdParticipante = $p_IdParticipante; }
    public function getIdParticipante(){ return $this->_IdParticipante; }

    public function setNomeParticipante( $p_NomeParticipante ){ $this->_NomeParticipante = $p_NomeParticipante; }
    public function getNomeParticipante(){ return $this->_NomeParticipante; }

    public function setCredencial( $p_Credencial ){ $this->_Credencial = $p_Credencial;}
    public function getCredencial(){ return $this->_Credencial; }

    public function setNomeCracha( $p_NomeCracha ){ $this->_NomeCracha = $p_NomeCracha; }
    public function getNomeCracha(){ return $this->_NomeCracha; }

    public function setEntrada( $p_Entrada ){ $this->_Entrada = $p_Entrada; }
    public function getEntrada(){ return $this->_Entrada; }

    public function setSaida( $p_Saida ){ $this->_Saida = $p_Saida; }
    public function getSaida(){ return $this->_Saida; }

    public function setObservacao( $p_Observacao ){ $this->_Observacao = $p_Observacao;}
    public function getObservacao(){ return $this->_Observacao; }

    public function setCargaHoraria( $p_CargaHoraria ){ $this->_CargaHoraria = $p_CargaHoraria; }
    public function getCargaHoraria(){ return $this->_CargaHoraria; }  

    //public function setRevisao( $p_Revisao ){ $this->_Revisao = $p_Revisao; }
    //public function getRevisao(){ return $this->_Revisao; }  

    //public function setDeletado( $p_Deletado ){ $this->_Deletado = $p_Deletado; }
    //public function getDeletado(){ return $this->_Deletado; }  	
	
}