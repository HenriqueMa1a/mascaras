<?php
$node = ( integer ) $_REQUEST ["nodeid"];
// detect if here we post the data from allready loaded tree
// we can make here other checks
if ($node > 0) {
	$n_lft = ( integer ) $_REQUEST ["n_left"];
	$n_rgt = ( integer ) $_REQUEST ["n_right"];
	$n_lvl = ( integer ) $_REQUEST ["n_level"];
	
	$n_lvl = $n_lvl + 1;
	$SQL = "SELECT account_id, name, acc_num, debit, credit, balance, level, lft, rgt FROM accounts WHERE lft > " . $n_lft . " AND rgt < " . $n_rgt . " AND level = " . $n_lvl . " ORDER BY lft";
} else {
	// initial grid
	$SQL = "SELECT account_id, name, acc_num, debit, credit, balance, level, lft, rgt FROM accounts WHERE level=0 ORDER BY lft";
}
$result = mysql_query ( $SQL ) or die ( "Couldn t execute query." . mysql_error () );
if (stristr ( $_SERVER ["HTTP_ACCEPT"], "application/xhtml+xml" )) {
	header ( "Content-type: application/xhtml+xml;charset=utf-8" );
} else {
	header ( "Content-type: text/xml;charset=utf-8" );
}
$et = ">";
echo "<?xml version='1.0' encoding='utf-8'?$et\n";
echo "<rows>";
echo "<page>1</page>";
echo "<total>1</total>";
echo "<records>1</records>";
// be sure to put text data in CDATA
// while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
echo "<row>";
// echo "<cell>". $row[account_id]."</cell>";
echo "<cell>" . "Rodolpho de Paula" . "</cell>";
// echo "<cell>". $row[name]."</cell>";
echo "<cell>" . "Fiocruz" . "</cell>";
// echo "<cell>". $row[acc_num]."</cell>";
echo "<cell>" . "rodolpho.paula@bio.fiocruz.br" . "</cell>";
// echo "<cell>". $row[debit]."</cell>";
echo "<cell>" . "Sim" . "</cell>";
// echo "<cell>". $row[credit]."</cell>";
echo "<cell>" . "Sim" . "</cell>";
// echo "<cell>". $row[balance]."</cell>";
echo "<cell>" . "Apenas Teste" . "</cell>";
echo "<cell>" . $row [level] . "</cell>";
echo "<cell>" . $row [lft] . "</cell>";
echo "<cell>" . $row [rgt] . "</cell>";
if ($row [rgt] == $row [lft] + 1)
	$leaf = 'true';
else
	$leaf = 'false';
echo "<cell>" . $leaf . "</cell>";
echo "<cell>false</cell>";
echo "</row>";
// }
echo "</rows>";	