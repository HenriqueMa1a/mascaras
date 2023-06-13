<?php
/**
 * Classe de Configuração do Sistema
 */
class Config {
    
    private $_Debug = true;
    private $_Manutencao = false;
    private $_IdEmpresa = 1;
    private $_Nome = 'Controle';
    private $_Titulo = 'Controle de Distribuição de Máscaras';
    private $_Icone = '<span class="fa fa-cube white"></span>';
    private $_Logotipo = 'logomascaras.png';
    private $_LogotipoImpressao = 'logomascaras.png';
	private $_LogotipoAbertura = 'logoMascarasAbertura.png';
    private $_URL = 'bio.fiocruz.br';
    private $_Email = 'isi@bio.fiocruz.br';
    private $_CaminhoArquivo = '../../../arquivos/';
    
    function __construct(){
        $this->_CaminhoArquivo = '../../../arquivos/';
    }
    
    public function __get($property) {
        // Verifica se propiedade existe ?
        if (property_exists($this, "_$property")) {
            $property = "_$property";
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        // Verifica se propiedade existe ?
        if (property_exists($this, "_$property")) {
            $property = "_$property";
            $this->$property = $value;
        }
    }
    
}