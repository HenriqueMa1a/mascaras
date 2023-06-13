<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php
    include_once 'assets/meta.php';
    include_once 'assets/css.php';
    include_once 'assets/js.php';
    $jsEspecifico = str_replace('.view.php', '.js.php', $sisModulo->View);
    if (file_exists($jsEspecifico)){ include_once($jsEspecifico); };
?> 
</head>
<body>
<div class="wrapper">

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <h1 class="page-header"> <?php echo $sisModulo->Imagem .' '. $sisModulo->Descricao; ?></h1>
                </div>
            </div>
            <div id="alertDiv" class="clearfix"></div><!-- MENSAGEM DE ALERTA //-->