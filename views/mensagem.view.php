            <!-- MODULO CONTEUDO - INICIO *** //-->
            <div class="row clearfix">
                <div class="col-md-10 column col-md-offset-1 mt-20">
                <?php
                    if (Contexto::getErro()==0) {
                        echo '<div class="jumbotron alert-info">';
                        echo '<h2><span class="glyphicon glyphicon-info-sign"></span> Alerta</h2>';
                        echo "<p>".Contexto::getErroMensagem()."</p>\n";
                        echo '<p class="text-center"><br/><a href="controller.php?gm=dashboard&mod=abertura" class="btn btn-default"> Voltar </a></p>';
                        echo '</div>';
                    } else {
                        echo '<div class="jumbotron alert-danger">';
                        echo "<h2><span class=\"glyphicon glyphicon-exclamation-sign\"></span> Erro: ".Contexto::getErro()." - ".Contexto::getErroMensagem()."</h2>";
                        echo "<p></p>\n";
                    if (Contexto::getErroNotas()){
                        echo "<p class=''>".Contexto::getErroNotas()."</p>\n";
                    }
                    //if (($sisConfig->Debug) || ($sisUsuario->Id==1)){
                        echo "<p class=''><small>Contexto: {view:'".$sisModulo->View."', modulo:'".$sisModulo->Chave."', acao:'".$sisModulo->Acao."', usuario:'".$sisUsuario->Id."', perfil:'".$sisUsuario->IdPerfil."'}</small></p>\n";
                    //}
                        echo '<p class="text-center"><br/><a href="controller.php?gm=dashboard&mod=abertura" class="btn btn-default"><span class="glyphicon glyphicon-chevron-left"></span> Voltar </a></p>';
                        echo '</div>';
                    }
                    //limparErros();
                ?>			
                </div>
            </div><!-- MODULO CONTEUDO - FINAL *** //-->