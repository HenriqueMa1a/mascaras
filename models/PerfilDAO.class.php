<?php
if(!class_exists('PadraoDAO')){ require_once 'PadraoDAO.class.php';}
if(!class_exists('Perfil')){ require_once 'Perfil.class.php';}
/**
 * Classe DAO de acesso a dados TipoDocumento herdada da PadraoDAO
 * 
 * @package Model.DAO
 * @category DAO
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
class PerfilDAO extends PadraoDAO {

    /**
     *  contrutor da classe que constroi também a super classe PadraoDAO
     *
     *  @param string $p_nomeTabela O nome da tabela a ser mapeada
     *  @param string $p_chavePrimaria O nome da chave primária da tabela a ser mapeada
     *  @return void
     */ 
    function __construct(){
        try{
            parent::__construct('perfil', 'id_perfil');
        } catch (PDOException $ex){ throw $ex; }
    }
}