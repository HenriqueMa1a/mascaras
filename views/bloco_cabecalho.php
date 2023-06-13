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

    <!-- CABEÇALHO - Inicio //-->
    <!-- Navigation -->
        <nav id="" class="navbar navbar-mcc navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="controller.php"><span class="fa fa-cube white"></span> <?php echo $sisConfig->Titulo; ?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown" style="display: none;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                
<?php  if ($sisUsuario->Id>0) { ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="<?php echo "Perfil: ".$sisUsuario->NomePerfil; ?>">
                        <i class="fa fa-user fa-fw" ></i> &nbsp; <?php echo $sisUsuario->Nome; ?> &nbsp; <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><!--<a href="controller.php?gm=dashboard&mod=meus-dados" title="Visualizar meus dados"  >--><i class="fa fa-user fa-fw"></i> Meus Dados</a></li>
                        <!--<li><a href="controller.php?gm=dashboard&mod=cadastro-senha" title="Alterar minha senha" ><i class="fa fa-key fa-fw"></i> Alterar Senha</a></li>-->
                        <!-- <li><a href="#"><i class="fa fa-gear fa-fw"></i> Config</a></li> -->
                        <li class="divider"></li>
                        <li><a href="controller.php?mod=sair" title="Sair do sistema. (logoff)" ><i class="fa fa-sign-out fa-fw"></i> Sair</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
<?php } else {?>
            <!--RETIRAR QUANDO O LOGIN FOR PELO PORTAL *** início -->
				<li class="">
                    <a href="controller.php?mod=autenticacao" title="Login para acesso ao conteúdo restrito.">Login </a>
                </li>
			<!--
                <li class="<?php  if ($sisModulo->Classe=='lembrete-senha') echo 'active'; ?>">
                    <a href="controller.php?mod=lembrete-senha" title="Lembrete de Senha">Lembrete de Senha</a>
                </li>
			  *** fim -->
                <!-- <li class="">
                    <a href="controller.php?mod=criar-conta" title="Criar uma conta">Criar uma Conta</a>
                </li> -->
<?php } ?>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div id="navLareral" class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li id="navLareralLogo">
                            <a href="controller.php?mod=abertura">
                            <?php
							
							
							if($sisUsuario->Id<>0) {
							
                                if ($sisConfig->Logotipo){
                                    echo '<img id="imgLareralLogo" src="images/'.$sisConfig->Logotipo.'" 
									width="230" height="130" style="border-radius: 10px;"
									alt="Logotipo: '.$sisConfig->Nome.'" />';
                                } else {
                                    echo 'Dashboard';
                                }
							}
							
							
                            ?>
                            </a>
                        </li>
                        
<?php  if ($sisUsuario->Id>0) { ?>                        
                        <li>
                            <div id="navLateralAtalhos">
                                <!-- <button type="button" class="btn btn-default" onclick="window.location.href='controller.php?gm=financeiro&mod=abertura'"><span class="fa fa-money green"></span></button> -->
                                <!-- <button type="button" class="btn btn-default" onclick="window.location.href='controller.php?gm=contrato&mod=abertura'"><span class="fa fa-university"></span></button> -->
                                <!-- <button type="button" class="btn btn-default" onclick="window.location.href='controller.php?gm=contrato&mod=abertura'"><span class="fa fa-briefcase brown"></span></button> -->
                                <!-- <button type="button" class="btn btn-default" onclick="window.location.href='controller.php?gm=relatorio&mod=abertura'"><span class="fa fa-bar-chart blue"></span></button> -->
                                <!-- <button type="button" class="btn btn-default" onclick="window.location.href='controller.php?gm=dashboard&mod=abertura'"><span class="fa fa-pencil-square-o black"></span></button> -->
                            </div>
                        </li>
                        <li class="sidebar-search" style="display: none;">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="controller.php?gm=dashboard&mod=abertura"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
<?php
        }

            if ($sisUsuario->IdPerfil>0) {
                $moduloDAO = new ModuloDAO();
                $listagem = $moduloDAO->listarPorPerfil($sisUsuario->IdPerfil, '1', $sisModulo->Grupo->Id);
                if (($sisConfig->Debug)||($sisUsuario->Id==1)){ echo "<!-- moduloDAO->listarPorPerfil('".$sisUsuario->IdPerfil."', '1', ".$sisModulo->Grupo->Id."); {query: '".$moduloDAO->_query."'}; -->";}
                if ($listagem){
                    foreach ($listagem as $item){
                        $Funcoes = 0;
                        // 2. Nivel ?
                        //$listagem1 = $moduloDAO->listar('1', '1000', 'ordem', 'asc', '', $item->getId());
                        $listagem1 = $moduloDAO->listarPorPerfil($sisUsuario->IdPerfil, '', $item->getId());

						echo "<!-- moduloDAO->listarPorPerfil('".$sisUsuario->IdPerfil."', '', ".$item->getId()."); {query: '".$moduloDAO->_query."'}; -->";
						
                        foreach ($listagem1 as $item1){
                                $Funcoes += 1;
                        }
                        //echo "<!-- [".$moduloDAO->_query."] -->";
                        if (($listagem) && (($Funcoes>0) || ($sisUsuario->IdTipoEmpresa==1))) {
                            $imagem = ($item->getImagem())? $item->getImagem(): '';
                            echo '    <li class="">' ;
                            echo '        <a href="#" class=""  title="'.$item->getDescricao().' ('.$Funcoes.')">'.$imagem.' '.$item->getNome().'<span class="fa arrow"></span></a>';
                            echo '        <ul class="nav nav-second-level">';
                            $numLink=0;
                            foreach ($listagem1 as $item1){
                                if (($item1->getClasse() == 'separador')  || ($item1->getClasse() == 'divider')){
                                    if ($numLink > 0){
                                            echo '<li class="divider"></li>';
                                    }
                                    $numLink=0;
                                } else {
                                    $active = ($sisModulo->Chave==$item1->getChave())? 'active': '';
                                    if ($item1->getPublico()){
                                        if (($item1->getChave() != 'autenticacao') && ($item1->getChave() != 'autenticacao-cpf')) {
                                            $numLink++;
                                            echo '            <li class="'.$active.'">';
                                            //echo ($item1->getImagem())? $item1->getImagem(): '';
                                            echo '                <a href="controller.php?gm='.$sisModulo->Grupo->Chave.'&mod='.$item1->getChave().'" title="'.$item1->getDescricao().'" >'.$item1->getNome().'</a>';
                                            echo '                </li>';
                                        }
                                    }else if ($Funcoes > 0){  //($item1->getFuncoes() > 0){
                                        $numLink++;
                                        echo '            <li class="'.$active.'"><a href="controller.php?gm='.$sisModulo->Grupo->Chave.'&mod='.$item1->getChave().'" title="'.$item1->getDescricao().'" >'.$item1->getNome().'</a></li>';
                                    //} else if ($sisUsuario->IdTipoEmpresa==1){
                                        //$numLink++;
                                        //echo '            <li class="'.$active.'"><span>'.$item1->getNome().'</span></li>';
                                    } else {

                                    }
                                }
                            }
                            echo '        </ul>';
                            echo '    </li>';
                        } else if ($Funcoes > 0){
                            echo ($sisModulo->Chave==$item->getChave())? '<li class="active">': '<li class="">';
                            echo ($item->getImagem())? $item->getImagem(): '';
                            echo '    <a href="controller.php?mod='.$item->getChave().'" title="'.$item->getDescricao().' ('.$Funcoes.')">'.$item->getNome().'</a>';
                            echo '</li>';
                        } else {

                        }
                    }
                }
                $moduloDAO = null;
            }
?>                        
                        <!--
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li> -->
                    </ul>
                    <ul id="navRodape" class="nav shift" >
                        <?php 
                            echo '<li>';
                            echo '<a class="" href="controller.php?mod=sobre" title="Conheça tudo sobre o sistema '.$sisConfig->Titulo.'" ><span class="fa fa-life-ring fa-fw"></span> Sobre o '.$sisConfig->Nome.'</a>';
                            echo '</li>';
                        ?>
                     </ul>   
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
    <!-- CABEÇALHO - Final //-->
        
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <h1 class="page-header"> <?php echo $sisModulo->Imagem .' '. $sisModulo->Descricao; ?></h1>
                </div>
            </div>
            <div id="alertDiv" class="clearfix"></div><!-- MENSAGEM DE ALERTA //-->