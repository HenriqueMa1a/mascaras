<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio de relacionamento Perfil x Funcionalidade
 */
class PerfilFuncionalidade extends Modelo{

    private $_Id;
	private $_IdPerfil = 0;
    private $_NomePerfil = '';
    private $_IdFuncionalidade = 0;
    private $_DescricaoFuncionalidade = '';
    private $_IdModulo = 0;
    private $_NomeModulo = '';
    private $_IdModuloPai = 0;
    private $_NomeModuloPai = '';

    function __construct(){
        parent::__construct();
    }

    public function setId( $p_Id ){ $this->_Id = $p_Id; }
    public function getId(){ return $this->_Id; }	
	
    public function setIdPerfil( $p_IdPerfil ){ $this->_IdPerfil = $p_IdPerfil; }
    public function getIdPerfil(){ return $this->_IdPerfil; }

    public function setNomePerfil( $p_NomePerfil ){ $this->_NomePerfil = $p_NomePerfil; }
    public function getNomePerfil(){ return $this->_NomePerfil; }

    public function setIdFuncionalidade( $p_IdFuncionalidade ){ $this->_IdFuncionalidade = $p_IdFuncionalidade; }
    public function getIdFuncionalidade(){ return $this->_IdFuncionalidade; }

    public function setDescricaoFuncionalidade( $p_DescricaoFuncionalidade ){ $this->_DescricaoFuncionalidade = $p_DescricaoFuncionalidade; }
    public function getDescricaoFuncionalidade(){ return $this->_DescricaoFuncionalidade; }
	
    public function setIdModulo( $p_IdModulo ){ $this->_IdModulo = $p_IdModulo; }
    public function getIdModulo(){ return $this->_IdModulo; }

    public function setNomeModulo( $p_NomeModulo ){ $this->_NomeModulo = $p_NomeModulo; }
    public function getNomeModulo(){ return $this->_NomeModulo; }	

    public function setIdModuloPai( $p_IdModuloPai ){ $this->_IdModuloPai = $p_IdModuloPai; }
    public function getIdModuloPai(){ return $this->_IdModuloPai; }

    public function setNomeModuloPai( $p_NomeModuloPai ){ $this->_NomeModuloPai = $p_NomeModuloPai; }
    public function getNomeModuloPai(){ return $this->_NomeModuloPai; }		
	
}