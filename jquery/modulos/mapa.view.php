<?php
require_once 'admin/includes/global.php';
require_once 'admin/includes/private.php';
require_once 'admin/includes/format.php';
require_once 'admin/funcoes/Validacao.class.php';
require_once 'admin/funcoes/Mensagem.class.php';
require_once 'admin/modelo/ModuloDAO.class.php';

$TXT_BUSCA = "";
$PAG_NUMERO = 1;

getDadosModulo ();

// IsOnLine();

getDadosUsuario ();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include_once ('tags.php');
include_once ('estilos.php');
include_once ('javascripts.php');

include_once ('jquery.php');
if (file_exists ( 'modulos/' . $MOD_CLASSE . '.js.php' ))
	include_once ('modulos/' . $MOD_CLASSE . '.js.php');
?> 
</head>
<body>
<?php include("cabecalho.php"); ?>
<div id="content">
<?php include("quadro_menu_vertical.php"); ?>
    <div id="posts" class="post">
			<!-- MODULO CONTEUDO - INICIO *** //-->
			<div id="loading">
				<p>
					<img src="images/loading.gif" alt="aguarde" /> Aguarde . . .
				</p>
			</div>
			<div id="resultado" style="display: none;"></div>
			<div id="msg_quadro" class="msg_quadro" style="display: none;">
				<img id="msg_icone" class="msg_icone" src="images/i_alerta.png"
					alt="Aviso" />&nbsp; <span id="msg_texto" class="msg_texto">Menssagem
					de Alerta</span> <img id="msg_botao" class="msg_botao"
					src="images/i_fechar.png" title="Fechar mensagem"
					alt="Fechar mensagem" onclick="ocultarMensagem();" />
			</div>
			<div id="popup_confirmacao" title="Confirmação de Exclusão?"
				style="display: none;">
				<br />
				<p>Tem certeza que deseja excluir o registro?</p>
			</div>

			<h2>Mapa do site</h2>

			<div class="mod_meio">
				<div class="demo">
					<!-- MAPA - INICIO -->

					<div style="margin-left: 30px;">
						<ul id="arvore" class="filetree treeview-famfamfam">
<?php

try {
	
	$DAO = new ModuloDAO ();
	// 0. Nivel
	$listagem = $DAO->lista ( '1', '1000', 'Ordem', 'asc', '1' );
	foreach ( $listagem as $item ) {
		$Visitas = ((($USO_PERFIL & 256) == 256) || (($USO_PERFIL & 512) == 512)) ? ' <em>(Visitas: ' . $item->getTotalVisitas () . ')</em>' : '';
		echo '<li><span class="' . $item->getImagem () . '"><b>' . $item->getNome () . '</b>' . $Visitas . '</span>';
		
		// 1. Nivel
		$listagem1 = $DAO->lista ( '1', '1000', 'Ordem', 'asc', '', $item->getId () );
		if ($listagem1) {
			echo '<ul>';
			foreach ( $listagem1 as $item1 ) {
				$Visitas = ((($USO_PERFIL & 256) == 256) || (($USO_PERFIL & 512) == 512)) ? ' <em>(Visitas: ' . $item1->getTotalVisitas () . ')</em>' : '';
				echo '<li><span class="' . $item1->getImagem () . '"><b>' . $item1->getNome () . '</b>' . $Visitas . '</span>';
				
				// 2. Nivel
				$listagem2 = $DAO->lista ( '1', '1000', 'Ordem', 'asc', '', $item1->getId () );
				if ($listagem2) {
					echo '<ul>';
					foreach ( $listagem2 as $item2 ) {
						$Visitas = ((($USO_PERFIL & 256) == 256) || (($USO_PERFIL & 512) == 512)) ? ' <em>(Visitas: ' . $item2->getTotalVisitas () . ')</em>' : '';
						echo '<li><span class="' . $item2->getImagem () . '"><b>' . $item2->getNome () . '</b>' . $Visitas . '</span>';
						
						// 3. Nivel
						$listagem3 = $DAO->lista ( '1', '1000', 'Ordem', 'asc', '', $item2->getId () );
						if ($listagem3) {
							echo '<ul>';
							foreach ( $listagem3 as $item3 ) {
								$Visitas = ((($USO_PERFIL & 256) == 256) || (($USO_PERFIL & 512) == 512)) ? ' <em>(Visitas: ' . $item3->getTotalVisitas () . ')</em>' : '';
								echo '<li><span class="' . $item3->getImagem () . '"><b>' . $item3->getNome () . '</b>' . $Visitas . '</span>';
								echo '</li>';
							}
							echo '</ul>';
						}
						echo '</li>';
					}
					echo '</ul>';
				}
			}
			echo '</ul>';
		}
		echo '</li>';
	}
} catch ( PDOException $ex ) {
	$response->mensagem = "Erro: " . $ex->getMessage ();
}

?>			
</ul>
					</div>
					<!-- MAPA - FINAL -->
				</div>
				<div class="cleardiv"></div>
				<div class="cleardiv"></div>
				<div class="cleardiv"></div>
				<div class="cleardiv"></div>
				<div class="cleardiv"></div>
			</div>
			<!-- MODULO CONTEUDO - FINAL *** //-->

		</div>
		<div style="clear: both;">&nbsp;</div>
	</div>
<?php include("rodape.php"); ?>
</body>
</html>