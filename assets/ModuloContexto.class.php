<?php
/**
 * Classe do Módulo do sistema no contexto
 */
class ModuloContexto {
    
    /** @var int Identificado do Módulo do Contexto */
    public $Id = 0;
    
    /** @var string Chave do Módulo */
    public $Chave = '';
    
    /** @var string Classe do Módulo */
    public $Classe = '';
    
    /** @var string Controle do Módulo */
    public $Controle = '';
    
    /** @var string Nome do Módulo */
    public $Nome = '';
    
    /** @var string Descrição do Módulo */
    public $Descricao = '';
    
    /** @var string Imagem do Módulo */
    public $Imagem = '';
    
    /** @var string Parametros do Módulo */
    public $Parametros = '{}';
    
    /** @var string Visão do Módulo */
    public $Visao = '';
    public $View = '';
    
    /** @var bool Flag se o Módulo é Público */
    public $Publico=0;
    
    /** @var array Array de Operações Módulo */
    public $Operacoes = '{"visualizar": 0, "listar": 0, "incluir": 0, "editar": 0, "excluir": 0, "autorizar": 0, "aprovar": 0, "total": 0}';
    
    /** @var int Identificador do Grupo do Módulo */
    public $IdGrupo;

    /** @var string Nome do Grupo do Módulo */
    public $NomeGrupo;

    /** @var string Descrição Grupo do Módulo */
    public $DescricaoGrupo;

    /** Contrutor da classe */   
    function __construct(){}
    
}