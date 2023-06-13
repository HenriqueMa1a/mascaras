<?php

// importando arquivos
@require ("regiaoDAO.class.php");

// instancio a classe Agenda
$regiao = new Regiao ();

// instancio a classe Data Access Object para Agenda
$DAO = new RegiaoDAO ();

// para listar nome e email de todos os contatos
/*
 * foreach ($DAO->lista() as $contato){ echo $contato["nome"]." - ".$contato["sigla"]."<br/>"; } //
 */

foreach ( $DAO->lista () as $contato ) {
	echo "nome:" . $contato->getNome () . " - Sigla:" . $contato->getSigla () . "<br/>";
}

unset ( $DAO )?>

