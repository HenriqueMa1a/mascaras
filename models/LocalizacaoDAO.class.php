<?php
if(!class_exists('PadraoDAO')){ require_once 'PadraoDAO.class.php';}
if(!class_exists('Localizacao')){ require_once 'Localizacao.class.php';}
/**
 * Classe DAO de relacionamento Tipo x Pessoa herdada da PadraoDAO
 * 
 * @package Model.DAO
 * @category DAO
 * @since   2015-05-21
 * @version 1.6
 * @author  Kellen Nery
 * 
 * 
 * @edit    2012-07-08<br />
 *          Kellen Nery <kellen.nery@bio.fiocruz.br>
 *          Implementação da documentação 
 *          #1.06
 */
class LocalizacaoDAO extends PadraoDAO {
    
    /**
     *  contrutor da classe que constroi também a super classe PadraoDAO
     *
     *  @param string $p_nomeTabela O nome da tabela a ser mapeada
     *  @param string $p_chavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @return void
     */ 
    function __construct(){
        try{
            parent::__construct('localizacao', 'id_localizacao');
        } catch (PDOException $ex){ throw $ex; }
    }
}