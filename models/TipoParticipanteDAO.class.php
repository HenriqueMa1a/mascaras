<?php
if(!class_exists('PDOConnection')){ require_once 'PDOConnection.class.php';}
if(!class_exists('TipoParticipante')){ require_once 'TipoParticipante.class.php';}
/**
 * Classe DAO para Acesso do TipoParticipante
 */
class TipoParticipanteDAO extends PDOConnection {
    
    /**
     *  contrutor da classe que constroi também a super classe PadraoDAO
     *
     *  @param string $p_nomeTabela O nome da tabela a ser mapeada
     *  @param string $p_chavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @return void
     */ 
    function __construct(){
        try{
            parent::__construct('tipo_participante', 'id_tipo_participante');
        } catch (PDOException $ex){ throw $ex; }
    }
}