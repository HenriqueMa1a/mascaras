<?php
    $pathJS = '';
    if(file_exists('assets/js/bootstrap.min.js')){
        $pathJS = 'assets';
    }else if(file_exists('../assets/js/bootstrap.min.js')){
        $pathJS = '../assets';
    }else if(file_exists('../../assets/js/bootstrap.min.js')){
        $pathJS = '../../assets';
    }else if(file_exists('../../../assets/js/bootstrap.min.js')){
        $pathJS = '../../../assets';
    }
    echo "
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script type='text/javascript' src='$pathJS/js/jquery.min.js'></script>
	<script type='text/javascript' src='$pathJS/js/bootstrap.min.js'></script>
	<script type='text/javascript' src='$pathJS/js/bootbox.min.js'></script>
	<script type='text/javascript' src='$pathJS/js/bootstrap-treeview.min.js' ></script>
	<script type='text/javascript' src='$pathJS/js/scripts-mcc.js?dh=".date('YmdH')."'></script>
	<script type='text/javascript' src='$pathJS/js/jquery.form.min.js'></script>
	<script type='text/javascript' src='$pathJS/js/jquery.validate.min.js'></script>
	<script type='text/javascript' src='$pathJS/js/jquery.validate.add-mcc.js'></script>	

	<!-- Metis Menu Plugin JavaScript -->
	<script type='text/javascript' src='$pathJS/js/metisMenu.min.js'></script>

	<!-- Custom Theme JavaScript -->
	<script type='text/javascript' src='$pathJS/js/sb-admin-2.js'></script>

	<script type='text/javascript' src='$pathJS/js/jquery.mask.min.js'></script>	
	<script type='text/javascript' src='$pathJS/js/jquery.price_format.1.3.js' ></script>
	<script type='text/javascript' src='$pathJS/js/jquery-ui-1.10.0.custom.min.js'></script>
	<script type='text/javascript' src='$pathJS/js/ui.datepicker-pt-BR.js'></script>
	<script type='text/javascript' src='$pathJS/js/select2.js' ></script>
	<script type='text/javascript' src='$pathJS/js/select2_locale_pt-BR.js' ></script>
	<script type='text/javascript' src='$pathJS/js/jquery.dataTables.min.js'></script>
	<script type='text/javascript' src='$pathJS/js/jquery.dataTables.bootstrap.js'></script>
	<script type='text/javascript' src='$pathJS/js/jquery.dataTables.add-mcc.js'></script>
    ";
?>

<script type="text/javascript">
    // Variaveis Globais 
    var oUsuario = {Id: 0, Nome: '', IdPessoa: 0, IdTipo: 0, IdPerfil: 0, IdEmpresa: 0, IdTipoEmpresa: 0, NomeEmpresa: '', UFEmpresa: '', IdMatriz: 0, NomeMatriz: '', Contexto:'', IdSessao:'', IP:''};
    var oModulo = {Id: 0, Chave: '', Classe: '', Nome: '', Descricao: '', Grupo: {Id: 0, Chave: '', Nome: '', Descricao: ''}, Controle: '', Visao: '', Operacoes:{'visualizar': 0,'listar': 0, 'incluir': 0, 'editar': 0, 'excluir': 0, 'autorizar': 0, 'aprovar': 0, 'total': 0}};
    var oTable;
    <?php 
        if (isset($sisUsuario)) {
            echo (isset($sisUsuario->Id))? "oUsuario.Id='$sisUsuario->Id';\n": ''; 
            echo (isset($sisUsuario->IdTipo))? "oUsuario.IdTipo='$sisUsuario->IdTipo';\n": '';
            echo (isset($sisUsuario->Nome))? "oUsuario.Nome='$sisUsuario->Nome';\n": '';
            echo (isset($sisUsuario->IdEmpresa))? "oUsuario.IdEmpresa='$sisUsuario->IdEmpresa';\n": '';
            echo (isset($sisUsuario->IdTipoEmpresa))? "oUsuario.IdTipoEmpresa='$sisUsuario->IdTipoEmpresa';\n": '';
            echo (isset($sisUsuario->NomeEmpresa))? "oUsuario.NomeEmpresa='$sisUsuario->NomeEmpresa';\n": '';
            echo (isset($sisUsuario->UFEmpresa))? "oUsuario.UFEmpresa='$sisUsuario->UFEmpresa';\n": '';
            echo (isset($sisUsuario->IdMatriz))? "oUsuario.IdMatriz='$sisUsuario->IdMatriz';\n": '';
            echo (isset($sisUsuario->NomeMatriz))? "oUsuario.NomeMatriz='$sisUsuario->NomeMatriz';\n": '';
            echo (isset($sisUsuario->Contexto))? "oUsuario.Contexto='$sisUsuario->Contexto';\n": '';
            echo (isset($sisUsuario->IdPerfil))? "oUsuario.IdPerfil='$sisUsuario->IdPerfil';\n": '';
            echo (isset($sisUsuario->IdSessao))? "oUsuario.IdSessao='$sisUsuario->IdSessao';\n": ''; 
            echo (isset($sisUsuario->IP))? "oUsuario.IP='$sisUsuario->IP';\n": ''; 
        }
        if (isset($sisModulo)) {
            echo (isset($sisModulo->Id))? "oModulo.Id='$sisModulo->Id';\n": ''; 
            echo (isset($sisModulo->Chave))? "oModulo.Chave='$sisModulo->Chave';\n": ''; 
            echo (isset($sisModulo->Classe))? "oModulo.Classe='$sisModulo->Classe';\n": ''; 
            echo (isset($sisModulo->Nome))? "oModulo.Nome='$sisModulo->Nome';\n": ''; 
            echo (isset($sisModulo->Descricao))? "oModulo.Descricao='$sisModulo->Descricao';\n": ''; 
            echo (isset($sisModulo->Controle))? "oModulo.Controle='$sisModulo->Controle';\n": ''; 
            echo (isset($sisModulo->Visao))? "oModulo.Visao='$sisModulo->Visao';\n": ''; 
            echo (isset($sisModulo->Operacoes))? "oModulo.Operacoes=$sisModulo->Operacoes;\n": ''; 
        }
        //var_dump($sisModulo);
        if (isset($sisModulo->Grupo)) {
            echo (isset($sisModulo->Grupo->Id))? "oModulo.Grupo.Id='".$sisModulo->Grupo->Id."';\n": ''; 
            echo (isset($sisModulo->Grupo->Chave))? "oModulo.Grupo.Chave='".$sisModulo->Grupo->Chave."';\n": ''; 
            echo (isset($sisModulo->Grupo->Nome))? "oModulo.Grupo.Nome='".$sisModulo->Grupo->Nome."';\n": ''; 
            echo (isset($sisModulo->Grupo->Descricao))? "oModulo.Grupo.Descricao='".$sisModulo->Grupo->Descricao."';\n": ''; 
        }    
?>
    // Google Analytics 
    /*
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-63833398-1', 'auto');
        ga('send', 'pageview');
    // */
</script>
