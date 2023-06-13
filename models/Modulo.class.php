<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio Módulo
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
class Modulo extends Modelo{

    private $_IdModuloPai;
    private $_NomeModuloPai;
    private $_Chave;
    private $_Visao;
    private $_Controle;
    private $_Classe; /* Depreciada */
    private $_Nome;
    private $_Descricao;
    private $_Imagem;
    private $_Nivel = 0;
    private $_Ordem = 0;
    private $_Publico;
    private $_Visitas = 0;
    private $_Parametros;
    private $_Funcoes = 0;

    function __construct(){
        parent::__construct();
    }

    public function setIdModuloPai( $p_IdModuloPai ){ $this->_IdModuloPai = $p_IdModuloPai; }
    public function getIdModuloPai(){ return $this->_IdModuloPai; }

    public function setNomeModuloPai( $p_NomeModuloPai ){ $this->_NomeModuloPai = $p_NomeModuloPai; }
    public function getNomeModuloPai(){ return $this->_NomeModuloPai; }
    
    public function setChave( $p_Chave ){ $this->_Chave = $p_Chave; }
    public function getChave(){ return $this->_Chave; }

    public function setVisao( $p_Visao ){ $this->_Visao = $p_Visao; }
    public function getVisao(){ return $this->_Visao; }

    public function setControle( $p_Controle ){ $this->_Controle = $p_Controle; }
    public function getControle(){ return $this->_Controle; }

    public function setClasse( $p_Classe ){ $this->_Classe = $p_Classe; }
    public function getClasse(){ return $this->_Classe; }

    public function setNome( $p_Nome ){ $this->_Nome = $p_Nome; }
    public function getNome(){ return $this->_Nome; }

    public function setDescricao( $p_Descricao ){ $this->_Descricao = $p_Descricao; }
    public function getDescricao(){ return $this->_Descricao; }

    public function setImagem( $p_Imagem ){ $this->_Imagem = $p_Imagem; }
    public function getImagem(){ return $this->_Imagem; }

    public function setNivel( $p_Nivel ){ $this->_Nivel = $p_Nivel; }
    public function getNivel(){ return $this->_Nivel; }

    public function setOrdem( $p_Ordem ){ $this->_Ordem = $p_Ordem;}
    public function getOrdem(){ return $this->_Ordem; }

    public function setPublico( $p_Publico ){ $this->_Publico = $p_Publico;}
    public function getPublico(){ return $this->_Publico; }

    public function setVisitas( $p_Visitas ){ $this->_Visitas = $p_Visitas;}
    public function getVisitas(){ return $this->_Visitas; }

    public function setParametros( $p_Parametros ){ $this->_Parametros = $p_Parametros;}
    public function getParametros(){ return $this->_Parametros; }

    public function setFuncoes( $p_Funcoes ){ $this->_Funcoes = $p_Funcoes; }
    public function getFuncoes(){ return $this->_Funcoes; }
		
}