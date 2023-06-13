<?php
/**
 * Classe do Usuário do sistema no contexto
 */
class UsuarioContexto {
    
    /** @var int Identificado do Usuário do Contexto */
    public $Id;
    
    /** @var string Conta do Usuário */
    public $Conta;
    
    /** @var string Chave Usuário */
    public $Chave;
    
    /** @var string Nome do Usuário */
    public $Nome;
    
    /** @var int Identificado do Tipo do Usuário */
    public $IdTipo;
    
    /** @var string Nome do Tipo de Usuário */
    public $NomeTipo;
    
    /** @var int Identificado da Pessoa do Usuário */
    public $IdPessoa;
    
    /** @var int Identificado do Perfil do Usuário */
    public $IdPerfil; 
    
    /** @var string Nome do Perfil do Usuário */
    public $NomePerfil;
    
    /** @var int Identificado do Empresa do Usuário */
    public $IdEmpresa;
    
    /** @var int Identificado do Tipo de Empresa do Usuário */
    public $IdTipoEmpresa;

    /** @var string Nome da Empresa do Usuário */
    public $NomeEmpresa;
    
    /** @var string UF da Empresa do Usuário */
    public $UFEmpresa;
    
    /** @var string Imagem da Empresa do Usuário */
    public $ImagemEmpresa;

    /** @var int Identificado da Empresa Matriz */
    public $IdMatriz;
    
    /** @var string Nome da Empresa Matriz */
    public $NomeMatriz;

    /** @var int Identificado da Sessão do contexto do Usuário */
    public $IdSessao;
    
    /** @var string Nome do Contexto do Usuário */
    public $Contexto;
    
    /** @var string Nome do Usuário */
    public $Timestamp;
    
    /** Contrutor da classe */   
    function __construct(){
        $this->Id = 0;
        $this->IdSessao = session_id();
        
        $this->IP = filter_input(INPUT_SERVER, 'HTTP_CLIENT_IP', FILTER_SANITIZE_STRING);
        if(!$this->IP){ $this->IP = filter_input(INPUT_SERVER, 'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_STRING);}
        if(!$this->IP){ $this->IP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING);}
    }

}