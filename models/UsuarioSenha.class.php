<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio de relacionamento Usuário x Senha
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
class UsuarioSenha extends Modelo{

    private $_IdUsuario;
    private $_NomeUsuario;
    private $_Senha;
    private $_Validade=null;
    private $_Tentativa=0;
    private $_Bloqueado;

    function __construct(){
        parent::__construct();
    }

    public function setIdUsuario( $p_IdUsuario ){ $this->_IdUsuario = $p_IdUsuario; }
    public function getIdUsuario(){ return $this->_IdUsuario; }

    public function setNomeUsuario( $p_NomeUsuario ){ $this->_NomeUsuario = $p_NomeUsuario; }
    public function getNomeUsuario(){ return $this->_NomeUsuario; }

    public function setSenha( $p_Senha ){ $this->_Senha = $p_Senha; }
    public function getSenha(){ return $this->_Senha; }

    public function setValidade( $p_Validade ){ $this->_Validade = $p_Validade; }
    public function getValidade(){ return $this->_Validade; }

    public function setTentativa( $p_Tentativa ){ $this->_Tentativa = $p_Tentativa;}
    public function getTentativa(){ return $this->_Tentativa; }

    public function setBloqueado( $p_Bloqueado ){ $this->_Bloqueado = $p_Bloqueado;}
    public function getBloqueado(){ return $this->_Bloqueado; }

}