<?php
	$pathCSS = '';
	if(file_exists('assets/css/bootstrap.min.css')){
		$pathCSS = 'assets';
	}else if(file_exists('../assets/css/bootstrap.min.css')){
		$pathCSS = '../assets';
	}else if(file_exists('../../assets/css/bootstrap.min.css')){
		$pathCSS = '../../assets';
	}else if(file_exists('../../../assets/css/bootstrap.min.css')){
		$pathCSS = '../../../assets';
	}
	echo "
    <!-- Bootstrap -->
    <link type='text/css' href='$pathCSS/css/bootstrap.min.css' rel='stylesheet' />
    <link type='text/css' href='$pathCSS/css/bootstrap-theme.min.css' rel='stylesheet' />

    <!-- MetisMenu CSS -->
    <link href='$pathCSS/css/metisMenu.css' rel='stylesheet'>
    <!-- sb-admin -->
    <link href='$pathCSS/css/sb-admin-2.css' rel='stylesheet'>
    
    <link type='text/css' href='$pathCSS/css/font-awesome.min.css' rel='stylesheet' />
	<link type='text/css' href='$pathCSS/css/ace.min.css' rel='stylesheet' />

    <link type='text/css' href='$pathCSS/css/sb-admin-2-mcc.css?dh=".date('YmdH')."' rel='stylesheet' />
    <link type='text/css' href='$pathCSS/css/bootstrap-mcc.css?dh=".date('YmdH')."' rel='stylesheet' />
    
    <!--
    <link type='text/css' href='$pathCSS/css/bootstrap-mcc.css?dh=".date('YmdH')."' rel='stylesheet' />
    <link type='text/css' href='$pathCSS/css/bootstrap-mcc-multiselect.css?dh=".date('YmdH')."' rel='stylesheet' />
    <link type='text/css' href='$pathCSS/css/bootstrap-mcc-navbar.css?dh=".date('YmdH')."' rel='stylesheet' />
    -->
    <link type='text/css' href='$pathCSS/css/bootstrap-mcc-navtabs.css?dh=".date('YmdH')."' rel='stylesheet' />
    <link type='text/css' href='$pathCSS/css/bootstrap-mcc-steps.css?dh=".date('YmdH')."' rel='stylesheet' />
    <link type='text/css' href='$pathCSS/css/bootstrap-mcc-datatables.css?dh=".date('YmdH')."' rel='stylesheet' />
    
    <link type='text/css' media='screen' href='$pathCSS/ui/css/redmond/jquery-ui-1.10.3.custom.min.css' rel='stylesheet' />

    <link type='text/css' href='$pathCSS/css/select2.css' rel='stylesheet' />
    <link type='text/css' href='$pathCSS/css/select2-bootstrap.css' rel='stylesheet' />
    <link type='text/css' href='$pathCSS/css/bootstrap-treeview.min.css' rel='stylesheet' />
    
    <!-- Fav and touch icons -->
    <link rel='apple-touch-icon-precomposed' sizes='144x144' href='$pathCSS/img/apple-touch-icon-144-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' sizes='114x114' href='$pathCSS/img/apple-touch-icon-114-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' sizes='72x72' href='$pathCSS/img/apple-touch-icon-72-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' href='$pathCSS/img/apple-touch-icon-57-precomposed.png'>
    <link rel='shortcut icon' href='$pathCSS/img/favicon.ico'>
	";
?>