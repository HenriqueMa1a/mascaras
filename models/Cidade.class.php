<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Cidade
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
 *          Criação do CRUD 
 *          #1.17
 */
class Cidade extends Modelo{

    private $_IdEstado;
    private $_SiglaEstado;
    private $_NomeEstado;
    private $_Codigo;
    private $_Sigla;
    private $_Nome;

    function __construct(){
        parent::__construct();
    }
    
    public function setIdEstado( $p_IdEstado ){ $this->_IdEstado = $p_IdEstado; }
    public function getIdEstado(){ return $this->_IdEstado; }

    public function setSiglaEstado( $p_SiglaEstado ){ $this->_SiglaEstado = $p_SiglaEstado; }
    public function getSiglaEstado(){ return $this->_SiglaEstado; }

    public function setNomeEstado( $p_NomeEstado ){ $this->_NomeEstado = $p_NomeEstado; }
    public function getNomeEstado(){ return $this->_NomeEstado; }

    public function setCodigo( $p_Codigo ){ $this->_Codigo = $p_Codigo; }
    public function getCodigo(){ return $this->_Codigo; }

    public function setSigla( $p_Sigla ){ $this->_Sigla = $p_Sigla;}
    public function getSigla(){ return $this->_Sigla; }

    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }
}