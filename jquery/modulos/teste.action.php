<?php
require_once ('../admin/includes/global.php');
require_once ('../admin/funcoes/Formatacao.class.php');
require_once ('../admin/funcoes/Arquivo.class.php');
// require_once("../admin/funcoes/Mensagem.class.php");

require_once ('../admin/modelo/ModuloDAO.class.php');
require_once ('../admin/modelo/UsuarioDAO.class.php');
// require_once('../admin/modelo/ConteudoDAO.class.php');
require_once ('../admin/modelo/ResumoDAO.class.php');
require_once ('../admin/modelo/AutorDAO.class.php');
// require_once ('../admin/modulo/resumo/resumo.action.php');

$response = new stdClass ();
$response->sucesso = 0;
$response->erro = 312;
$response->mensagem = utf8_encode ( "Inicio do processamento: teste.action.php" );
$response->IdAutor = 0;

if ($_SERVER ['REQUEST_METHOD'] == 'GET') {
	
	// echo "[_GET['acao']:".$_GET['acao']."]";
	isset ( $_GET ['operacao'] ) ? $operacao = $_GET ['operacao'] : $operacao = '';
	isset ( $_GET ['acao'] ) ? $acao = $_GET ['acao'] : $acao = '';
	isset ( $_GET ['page'] ) ? $page = $_GET ['page'] : $page = '';
	isset ( $_GET ['rows'] ) ? $rows = $_GET ['rows'] : $rows = '';
	isset ( $_GET ['sidx'] ) ? $sidx = $_GET ['sidx'] : $sidx = '';
	isset ( $_GET ['sord'] ) ? $sord = $_GET ['sord'] : $sord = '';
	if (! $sidx)
		$sidx = 1;
	
	switch ($acao) {
		
		case ("listar") :
			
			isset ( $_GET ['IdUsuario'] ) ? $IdUsuario = limpa_sql_injection ( trim ( ($_GET ['IdUsuario']) ) ) : $IdUsuario = '';
			isset ( $_GET ['IdStatus'] ) ? $IdStatus = limpa_sql_injection ( trim ( ($_GET ['IdStatus']) ) ) : $IdStatus = '';
			isset ( $_GET ['Titulo'] ) ? $Titulo = limpa_sql_injection ( trim ( ($_GET ['Titulo']) ) ) : $Titulo = '';
			
			$response->IdUsuario = $IdUsuario;
			
			$DAO = new AutorDAO ();
			
			try {
				
				$listagem = $DAO->lista ( $page, $rows, $sidx, $sord, $IdUsuario );
				if ($listagem) {
					
					$response->page = 1;
					$response->total = 1;
					$response->records = count ( $listagem );
					
					$i = 0;
					$j = 0;
					foreach ( $listagem as $item ) {
						// json
						$response->rows [$i] ['id_autor'] = $i + 1;
						$response->rows [$i] ['cell'] = array (
								$item->getNome (),
								$item->getInstituicao (),
								$item->getEmail (),
								$item->getFlagPrincipal (),
								$item->getFlagApresentador (),
								$item->getJustificativa () 
						);
						$i ++;
					}
					echo json_encode ( $response );
					$response->sucesso = 1;
				} else {
					$response->page = 0;
					$response->total = 0;
					$response->records = 0;
				}
			} catch ( PDOException $ex ) {
				echo utf8_encode ( $ex->getMessage () );
			}
			
			break;
		
		default :
			$response->mensagem = utf8_encode ( "Ação não encontrada para este controle. <br/>(metodo: GET, acao:'$acao')." );
			
			break;
		
		case ("adicionar") :
			
			isset ( $_GET ['IdResumo'] ) ? $IdResumo = limpa_sql_injection ( trim ( ($_GET ['IdResumo']) ) ) : $IdResumo = '';
			isset ( $_GET ['Autor'] ) ? $Autor = limpa_sql_injection ( trim ( ($_GET ['Autor']) ) ) : $Autor = '';
			isset ( $_GET ['Instituicao'] ) ? $Instituicao = limpa_sql_injection ( trim ( ($_GET ['Instituicao']) ) ) : $Instituicao = '';
			isset ( $_GET ['Email'] ) ? $Email = limpa_sql_injection ( trim ( ($_GET ['Email']) ) ) : $Email = '';
			isset ( $_GET ['Principal'] ) ? $Principal = limpa_sql_injection ( trim ( ($_GET ['Principal']) ) ) : $Principal = '';
			isset ( $_GET ['Apresentador'] ) ? $Apresentador = limpa_sql_injection ( trim ( ($_GET ['Apresentador']) ) ) : $Apresentador = '';
			isset ( $_GET ['Justificativa'] ) ? $Justificativa = limpa_sql_injection ( trim ( ($_GET ['Justificativa']) ) ) : $Justificativa = '';
			
			$obj = new Autor ();
			$DAO = new AutorDAO ();
			
			if ($IdResumo) {
				$response->IdResumo = $IdResumo;
				
				$obj = $DAO->salva ( $IdResumo, $Autor, $Instituicao, $Email, $Principal, $Apresentador, $Justificativa );
				if ($obj) {
					$response->sucesso = 1;
				}
			}
			
			break;
		
		default :
			$response->mensagem = utf8_encode ( "Ação não encontrada para este controle. <br/>(metodo: GET, acao:'$acao')." );
			
			break;
	}
}



/*



$node = (integer)$_REQUEST["nodeid"];
// detect if here we post the data from allready loaded tree
// we can make here other checks


if( $node >0) {
	$n_lft = (integer)$_REQUEST["n_left"];
	$n_rgt = (integer)$_REQUEST["n_right"];
	$n_lvl = (integer)$_REQUEST["n_level"];

	$n_lvl = $n_lvl+1;
   	$SQL = "SELECT account_id, name, acc_num, debit, credit, balance, level, lft, rgt FROM accounts WHERE lft > ".$n_lft." AND rgt < ".$n_rgt." AND level = ".$n_lvl." ORDER BY lft";
} else { 
	// initial grid
   	$SQL = "SELECT account_id, name, acc_num, debit, credit, balance, level, lft, rgt FROM accounts WHERE level=0 ORDER BY lft";
}
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
header("Content-type: text/xml;charset=utf-8");
}
$et = ">";
echo "<?xml version='1.0' encoding='utf-8'?$et\n";
   echo "<rows>";
echo "<page>1</page>";
echo "<total>1</total>";
echo "<records>1</records>";
// be sure to put text data in CDATA
//while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
	echo "<row>";			
	/*echo "<cell>". $row[account_id]."</cell>";
	echo "<cell>". $row[name]."</cell>";
	echo "<cell>". $row[acc_num]."</cell>";
	echo "<cell>". $row[debit]."</cell>";
	echo "<cell>". $row[credit]."</cell>";
	echo "<cell>". $row[balance]."</cell>";
	echo "<cell>". $row[level]."</cell>";
	echo "<cell>". $row[lft]."</cell>";
	echo "<cell>". $row[rgt]."</cell>";
	if($row[rgt] == $row[lft]+1) $leaf = 'true';else $leaf='false';
	echo "<cell>".$leaf."</cell>";
	echo "<cell>false</cell>";
	echo "</row>";*/
//}
//echo "</rows>";	

