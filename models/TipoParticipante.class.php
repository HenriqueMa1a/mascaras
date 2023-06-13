<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Tipo do Participante 
 * 
 */
class TipoParticipante extends Modelo {
    private $_IdTipo;
    private $_Sigla;
    private $_Nome;
    
    public function setIdTipo( $p_IdTipo ){ $this->_IdTipo = $p_IdTipo; }
    public function getIdTipo(){ return $this->_IdTipo; }
    
    public function setSigla( $p_Sigla ){ $this->_Sigla = $p_Sigla; }
    public function getSigla(){ return $this->_Sigla; }

    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }
	
		
}