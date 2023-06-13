<?php
if(!class_exists('Modelo')){ require_once 'Modelo.class.php';}
/**
 * Classe de negócio LogAcao
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
class LogAcao extends Modelo{

	private $_IdModulo;
	private $_NomeModulo;
	private $_Chave;
	private $_Classe;
	private $_IdFuncionalidade;
	private $_NomeFuncionalidade;
	private $_Acao;
	private $_Parametros;
	private $_Identificador;
	private $_IP;
	
	public function __construct($p_IdModulo=null, $p_Chave=null, $p_Classe=null, $p_IdFuncionalidade=null, $p_Acao=null, $p_Parametros=null, $p_Identificador=null, $p_IdUsuarioAcao=null, $p_IP=null){
		$this->_IdModulo = $p_IdModulo;
		$this->_Chave = $p_Chave;
		$this->_Classe = $p_Classe;
		$this->_IdFuncionalidade = $p_IdFuncionalidade;
		$this->_Acao = $p_Acao;
		if (is_object($p_Parametros)){
			$this->_Parametros = json_encode($p_Parametros);
		} else {
			$this->_Parametros = $p_Parametros;
		}
		$this->_IdUsuarioAcao = $p_IdUsuarioAcao;
		$this->_IP = $p_IP;
	}
	
	public function setIdModulo( $p_IdModulo ){ $this->_IdModulo = $p_IdModulo; }
	public function getIdModulo(){ return $this->_IdModulo; }

	public function setNomeModulo( $p_NomeModulo ){ $this->_NomeModulo = $p_NomeModulo; }
	public function getNomeModulo(){ return $this->_NomeModulo; }

    public function setChave( $p_Chave ){ $this->_Chave = $p_Chave; }
    public function getChave(){ return $this->_Chave; }

    public function setClasse( $p_Classe ){ $this->_Classe = $p_Classe; }
    public function getClasse(){ return $this->_Classe; }
    
	public function setIdFuncionalidade( $p_IdFuncionalidade ){ $this->_IdFuncionalidade = $p_IdFuncionalidade; }
	public function getIdFuncionalidade(){ return $this->_IdFuncionalidade; }
	
	public function setNomeFuncionalidade( $p_NomeFuncionalidade ){ $this->_NomeFuncionalidade = $p_NomeFuncionalidade; }
	public function getNomeFuncionalidade(){ return $this->_NomeFuncionalidade; }
	
    public function setAcao( $p_Acao ){ $this->_Acao = $p_Acao; }
    public function getAcao(){ return $this->_Acao; }	

	public function setParametros( $p_Parametros ){ $this->_Parametros = $p_Parametros;}
	public function getParametros(){ return $this->_Parametros; }

	public function setIdentificador( $p_Identificador ){ $this->_Identificador = $p_Identificador;}
	public function getIdentificador(){ return $this->_Identificador; }

	public function setIP( $p_IP ){ $this->_IP = $p_IP;}
	public function getIP(){ return $this->_IP; }
	
}