<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio de relacionamento Usuário x Perfil
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
class UsuarioPerfil extends Modelo{

    private $_IdUsuario = 0;
    private $_NomeUsuario = '';
    private $_IdPerfil = 0;
    private $_NomePerfil = '';

    function __construct(){
        parent::__construct();
    }

    public function setIdUsuario( $p_IdUsuario ){ $this->_IdUsuario = $p_IdUsuario; }
    public function getIdUsuario(){ return $this->_IdUsuario; }

    public function setNomeUsuario( $p_NomeUsuario ){ $this->_NomeUsuario = $p_NomeUsuario; }
    public function getNomeUsuario(){ return $this->_NomeUsuario; }

    public function setIdPerfil( $p_IdPerfil ){ $this->_IdPerfil = $p_IdPerfil; }
    public function getIdPerfil(){ return $this->_IdPerfil; }

    public function setNomePerfil( $p_NomePerfil ){ $this->_NomePerfil = $p_NomePerfil; }
    public function getNomePerfil(){ return $this->_NomePerfil; }
    
}