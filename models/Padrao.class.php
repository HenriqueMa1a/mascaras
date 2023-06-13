<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Padrão
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
 *          Melhoria no Framework 
 *          #1.17
 */
class Padrao extends Modelo{

    private $_Sigla;
    private $_Nome;
    private $_Quantidade;
    
    function __construct(){
        parent::__construct();
    }
    
    /** @var string Sigla */
    public function setSigla( $p_Sigla ){ $this->_Sigla = $p_Sigla;}
    public function getSigla(){ return $this->_Sigla; }

    /** @var string Nome */
    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }

    /** @var int Quantidade */
    public function setQuantidade( $p_Quantidade ){ $this->_Quantidade = $p_Quantidade;}
    public function getQuantidade(){ return $this->_Quantidade; }

}