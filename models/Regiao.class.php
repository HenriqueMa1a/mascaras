<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Região
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
class Regiao extends Modelo{

    private $_IdPais;
    private $_SiglaPais;
    private $_NomePais;
    private $_Codigo;
    private $_Sigla;
    private $_Nome;

    function __construct(){
        parent::__construct();
    }
    
    public function setIdPais( $p_IdPais ){ $this->_IdPais = $p_IdPais; }
    public function getIdPais(){ return $this->_IdPais; }

    public function setSiglaPais( $p_SiglaPais ){ $this->_SiglaPais = $p_SiglaPais; }
    public function getSiglaPais(){ return $this->_SiglaPais; }

    public function setNomePais( $p_NomePais ){ $this->_NomePais = $p_NomePais; }
    public function getNomePais(){ return $this->_NomePais; }

    public function setCodigo( $p_Codigo ){ $this->_Codigo = $p_Codigo; }
    public function getCodigo(){ return $this->_Codigo; }

    public function setSigla( $p_Sigla ){ $this->_Sigla = $p_Sigla;}
    public function getSigla(){ return $this->_Sigla; }

    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }
}