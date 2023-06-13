<?php
/**
 * Classe de Configuração do Sistema
 * @author  Kellen Nery
 */
class Configuracao {
    
    /** @var bool Flag de Sistema em modo Debug */
    public $Debug = true;
    
    /** @var bool Flag de Sistema em modo Manutenção */
    public $Manutencao = false;
    
    /** @var string Nome do Sistema/Portal */
    public $IdEmpresa = 1900;
    
    /** @var string Nome do Sistema/Portal */
    public $Nome = 'SGO';
    
    /** @var string Titulo do Sistema/Portal */
    public $Titulo = 'Sistema de Gestão de Obras';
    
    /** @var string Titulo do Sistema/Portal */
    public $Icone = '<span class="fa fa-cube white"></span>';

    /** @var string Titulo do Sistema/Portal */
    public $Imagem = '<span class="fa fa-cube white"></span>';
    
    /** @var string URL do Sistema/Portal */
    public $URL = 'construtoramacadame.com.br';
    
    /** @var string Endereço do servidor SMTP */
    public $SMTPHost = 'smtp.construtoramacadame.com.br';
    
    /** @var string Porta de conexão do servidor SMTP */
    public $SMTPPort = '25'; // {25, ssl:465, tsl:587}
    
    /** @var string Tipo de Segurança do servidor SMTP */
    public $SMTPSecure = ''; // {'', ssl, tsl}
    
    /** @var string E-mail do Sistema/Portal */
    public $Email = 'sao@construtoramacadame.com.br';
    
    /** @var string Nome do e-mail do Sistema/Portal */
    public $EmailNome = 'SGO';
    
    /** @var string Senha do e-mail do Sistema/Portal */
    public $EmailSenha;
    
    /** @var string Caminho dos arquivos do Sistema/Portal */
    public $CaminhoArquivo = '../../../arquivos/';
    
    function __construct(){
        $this->EmailSenha = 'Maca2014';
        $this->CaminhoArquivo = '../../../arquivos/';
    }

    
}