<?php 

/* INCLUDE de Conecção com o Banco de Dados; */
    include_once("config.php"); 

/* Funções Globais -------------------------------------------------------------------- */

    if (!(isset($APP_NAME))){
        $APP_NAME = 'Painel de Controle ASA';
        $APP_VERSAO = '1.0';    
        $ERRO_CODIGO = 10;    
        $ERRO_MENSAGEM = "x";    
        $ERRO_NOTAS = "";    
        $OPERACAO = "";    
        $FALG_IDIOMA = "";    
        $SITE_IDIOMA = "";
    }
/* --------------------------------------------------------------------------------------*/

/*  --------------------------------------------------------------------------------------*/
function Encripta_Senha($Senha){
    extract($GLOBALS);

    $function_ret="";
    $SenhaCrip="";
    $Senha=strtoupper(trim($Senha));
    $nSenha=strlen($Senha);

    for ($x=1; $x<=$nSenha; $x=$x+1)  {
        $cchar=substr($Senha,$x-1,1);
        $nchar=$nchar+ord($cchar); 
        $nTemp=$x+50;  
        $nchar=$nchar+$x; 
        $nchar=$nchar+$nTemp;  
        $nchar=$nchar+$nSenha;
        if ($nchar>126){
            while($nchar>126){
                $nchar=$nchar-63; 
            } 
        } else if ($nchar<33){        
            while($nchar<33){
                $nchar=$nchar+63;        
            }
        }
        $cchar=chr($nchar);
        if (0==0){
            $SenhaCrip=$SenhaCrip+$cchar;
        } else {
            $SenhaCrip=$SenhaCrip+" ";
        }
        return $SenhaCrip;
    }
    /*' / Estamos se protejendo por qualsa da MWDBfl.dll  */  
    $SenhaCrip=str_replace("#","¡",$SenhaCrip); /*' Chr(035) >> Chr(161) */  
    $SenhaCrip=str_replace("$","¢",$SenhaCrip); /*' Chr(036) >> Chr(162) */  
    $SenhaCrip=str_replace("%","£",$SenhaCrip); /*' Chr(037) >> Chr(163) */  
    $SenhaCrip=str_replace("*","¤",$SenhaCrip); /*' Chr(042) >> Chr(164) */  
    $SenhaCrip=str_replace(",","¥",$SenhaCrip); /*' Chr(044) >> Chr(165) */ 
    $SenhaCrip=str_replace(";","¦",$SenhaCrip); /*' Chr(059) >> Chr(166) */ 
    $SenhaCrip=str_replace("<","§",$SenhaCrip); /*' Chr(060) >> Chr(167) */ 
    $SenhaCrip=str_replace("=","¨",$SenhaCrip); /*' Chr(061) >> Chr(168) */ 
    $SenhaCrip=str_replace(">","©",$SenhaCrip); /*' Chr(062) >> Chr(169) */  
    $SenhaCrip=str_replace("|","æ",$SenhaCrip); /*' Chr(124) >> Chr(230) */
    /*  --------------------------------------------------------------------------------------*/ 
    $function_ret=$SenhaCrip;
    return $function_ret;
}

function Truncar($curValor, $intDecimais){
    extract($GLOBALS);
    /*  Trunca o Valor com os decimais desejados. */
    $curValor=intval($curValor*intval((10^$intDecimais)));
    $curValor=$curValor/intval((10^$intDecimais));
    $function_ret=$curValor;
    return $function_ret;
}
/*  --------------------------------------------------------------------------------------*/

function TrataCaracteres($Texto){
						
		$novoTexto = $Texto;
		$novoTexto = $novoTexto.str_replace("Ã€", "Á");
		$novoTexto = $novoTexto.str_replace("Ã‰", "É");
		$novoTexto = $novoTexto.str_replace("Ãš", "Ú");
		$novoTexto = $novoTexto.str_replace("Ã¡", "á");
		$novoTexto = $novoTexto.str_replace("Ã©", "é");
		$novoTexto = $novoTexto.str_replace("Ã³", "ó");
		$novoTexto = $novoTexto.str_replace("Ãº", "ú");
		$novoTexto = $novoTexto.str_replace("Ã§", "ç");
		$novoTexto = $novoTexto.str_replace("Ã£", "ã");
		$novoTexto = $novoTexto.str_replace("Ãµ", "õ");
		$novoTexto = $novoTexto.str_replace("Ã´", "ô");
		$novoTexto = $novoTexto.str_replace("Ã´", "ô");
		$novoTexto = $novoTexto.str_replace("Ã¢", "â");
		$novoTexto = $novoTexto.str_replace("Ãª", "ê");
		$novoTexto = $novoTexto.str_replace("Ã", "í");
		$novoTexto = $novoTexto.str_replace("Âº", "º");
		$novoTexto = $novoTexto.str_replace("Ã§", "ç");
		$novoTexto = $novoTexto.str_replace("Ã£", "ã");
		$novoTexto = $novoTexto.str_replace("Ã©", "é");
		$novoTexto = $novoTexto.str_replace("Ã³", "ó");
		$novoTexto = $novoTexto.str_replace("Ã³", "ó");
		$novoTexto = $novoTexto.str_replace("Ã", "á");
		
		return $novoTexto;
	}

function IsOnLine(){
    global $USO_ID, $USO_LOGIN, $USO_NOME, $USO_EMAIL, $USO_PERFIL, $USO_GERENTE, $USO_ADMIN, $USO_ALERTA;
    $intUsuario = 0;
    $strChave = "";

    if ((isset($_SESSION['USO_ID']))){
        $intUsuario = $_SESSION['USO_ID'];
        if ((isset($_SESSION['USO_CHAVE']))) $strChave = $_SESSION['USO_CHAVE'];
    } elseif ((isset($_COOKIE['USO_ID']))){
        $intUsuario = $_COOKIE['USO_ID'];
        if ((isset($_COOKIE['USO_CHAVE']))) $strChave = $_COOKIE['USO_CHAVE'];
    } elseif ((isset($_POST['boxUsoCodigo']))){
        $intUsuario = $_POST['boxUsoCodigo'];
        if ((isset($_POST['boxUsoChave'])))$strChave = $_POST['boxUsoChave'];
    } elseif ((isset($_GET['uso']))){
        $intUsuario = $_GET['uso'];
        if ((isset($_GET['key']))) $strChave = $_GET['key'];
    }

/*  echo "[".$intUsuario."]"."[".$strChave."]"; *//*  exit; */
    if ($intUsuario > 0){
        return true;
    } else {
        setcookie("USO_ID", "");
        limparUsuario();
        echo "<html><body>";
        echo "<b>001 - O usuário precisa está loga para utilizar esta área do sistema.</b><br/>";
        echo "Tente logar no sistema novamente.<br/>"; 
        echo "</body></html>"; 
        exit;
    }
    if (!(isset($_SESSION['USO_ID']))){
        $_SESSION['USO_ID'] = 0;
    }
    if (($_SESSION['USO_ID']>0)){ 
        if (isset($_SESSION['USO_TIMESTAMP'])){
            if ($_SESSION['USO_TIMESTAMP'] > (time()-600)){ 
                /* Tem mais de 600 segundos sem usar o sistema ? */ 
                $_SESSION['USO_TIMESTAMP'] = time(); /* Guarda o ultimo clique. */
                return true;
            } else {
                echo "<html><body>";      
                echo "<b>003 - Usuário off-line</b><br/>";   
                echo "Você ficou muito tempo ocioso.<br/>";
                echo "</body></html>";
                exit;
            }
        } else {
            echo "<html><body>";
            echo "<b>002 - Usuário off-line</b><br/>";      
            echo "Tente logar no sistema novamente.<br/>";  
            echo "</body></html>"; 
            exit; 
        }
    } else {
        echo "<html><body>";   
        echo "<b>001 - Usuário off-line</b><br/>";  
        echo "Tente logar no sistema novamente.<br/>";  
        echo "</body></html>"; 
        exit;
    }
}

function limparUsuario(){
    global $USO_ID, $USO_LOGIN, $USO_NOME, $USO_EMAIL, $USO_PERFIL, $USO_GERENTE, $USO_ADMIN, $USO_ALERTA, $EMP_ID, $EMP_NOME;
    $USO_ID = 0;
    $USO_LOGIN = "";
    $USO_NOME = "";
    $USO_PERFIL = 0;
    $USO_GERENTE = 0;
    $USO_ADMIN = 0;
    $USO_ALERTA = 0;
    $EMP_ID = 0;
    $EMP_NOME = "";
    if (isset($_SESSION["USO_ID"])) unset($_SESSION['USO_ID']);
    if (isset($_SESSION["USO_CHAVE"])) unset($_SESSION['USO_CHAVE']);
    if (isset($_SESSION["USO_NOME"])) unset($_SESSION['USO_NOME']);
    if (isset($_SESSION["USO_EMAIL"])) unset($_SESSION['USO_EMAIL']);
    if (isset($_SESSION["USO_POLITICA"])) unset($_SESSION['USO_POLITICA']);
    if (isset($_SESSION["USO_ADMIN"])) unset($_SESSION['USO_ADMIN']);
    if (isset($_SESSION["USO_GERENTE"])) unset($_SESSION['USO_GERENTE']);
    if (isset($_SESSION["USO_PERFIL"])) unset($_SESSION['USO_PERFIL']);
    if (isset($_SESSION["USO_VALIDADE"])) unset($_SESSION['USO_VALIDADE']);

    if (isset($_COOKIE["USO_ID"])) unset($_COOKIE['USO_ID']);
    if (isset($_COOKIE["USO_CHAVE"])) unset($_COOKIE['USO_CHAVE']);
    if (isset($_COOKIE["USO_NOME"])) unset($_COOKIE['USO_NOME']);
    if (isset($_COOKIE["USO_EMAIL"])) unset($_COOKIE['USO_EMAIL']);
    if (isset($_COOKIE["USO_POLITICA"])) unset($_COOKIE['USO_POLITICA']);
    if (isset($_COOKIE["USO_ADMIN"])) unset($_COOKIE['USO_ADMIN']);
    if (isset($_COOKIE["USO_GERENTE"])) unset($_COOKIE['USO_GERENTE']);
    if (isset($_COOKIE["USO_PERFIL"])) unset($_COOKIE['USO_PERFIL']);
    if (isset($_COOKIE["USO_VALIDADE"])) unset($_COOKIE['USO_VALIDADE']);

}
    
function getDadosUsuario(){
    global $USO_ID, $USO_LOGIN, $USO_NOME, $USO_EMAIL, $USO_PERFIL, $USO_GERENTE, $USO_ADMIN, $USO_ALERTA, $USO_CHAVE;

    if ((isset($_SESSION['USO_ID']))){
        $USO_ID = $_SESSION['USO_ID'];
        if ((isset($_SESSION['USO_LOGIN']))) $USO_LOGIN = $_SESSION['USO_LOGIN'];
        if ((isset($_SESSION['USO_NOME']))) $USO_NOME = $_SESSION['USO_NOME'];
		if ((isset($_SESSION['USO_EMAIL']))) $USO_EMAIL = $_SESSION['USO_EMAIL'];
        if ((isset($_SESSION['USO_PERFIL']))) $USO_PERFIL = $_SESSION['USO_PERFIL'];
        if ((isset($_SESSION['USO_GERENTE']))) $USO_GERENTE = $_SESSION['USO_GERENTE'];
        if ((isset($_SESSION['USO_ADMIN']))) $USO_ADMIN = $_SESSION['USO_ADMIN'];
        if ((isset($_SESSION['USO_ALERTA']))) $USO_ALERTA = $_SESSION['USO_ALERTA'];
        if ((isset($_SESSION['USO_CHAVE']))) $USO_CHAVE = $_SESSION['USO_CHAVE'];
        if ((isset($_SESSION['EMP_ID']))) $EMP_ID = $_SESSION['EMP_ID'];
        
    } 
}

function getDadosModulo(){

    global $MOD_CODIGO, $MOD_CLASSE, $MOD_VISAO;

    if ((isset($_SESSION['MOD_CODIGO']))){
        $MOD_CODIGO = $_SESSION['MOD_CODIGO'];

    } else  if ((isset($_POST['MOD_CODIGO']))){
        $MOD_CODIGO = $_POST['MOD_CODIGO'];

    } else  if ((isset($_GET['mod']))){
        $MOD_CODIGO = $_GET['mod'];

    } else  if ((isset($_COOKIE['MOD_CODIGO']))){
        $MOD_CODIGO = $_COOKIE['MOD_CODIGO'];

    } else {
        $MOD_CODIGO = '';
    }

    if ((isset($_SESSION['MOD_CLASSE']))){
        $MOD_CLASSE = $_SESSION['MOD_CLASSE'];

    } else  if ((isset($_POST['MOD_CLASSE']))){
        $MOD_CLASSE = $_POST['MOD_CLASSE'];

    } else  if ((isset($_GET['modulo']))){
        $MOD_CLASSE = $_GET['modulo'];

    } else  if ((isset($_COOKIE['MOD_CLASSE']))){
        $MOD_CLASSE = $_COOKIE['MOD_CLASSE'];

    } else {
        $MOD_CLASSE = '';
    }
    
    if ((isset($_SESSION['MOD_VISAO']))){
        $MOD_VISAO = $_SESSION['MOD_VISAO'];

    } else  if ((isset($_POST['MOD_VISAO']))){
        $MOD_VISAO = $_POST['MOD_VISAO'];

    } else  if ((isset($_GET['view']))){
        $MOD_VISAO = $_GET['view'];

    } else  if ((isset($_COOKIE['MOD_VISAO']))){
        $MOD_VISAO = $_COOKIE['MOD_VISAO'];

    } else {
        $MOD_VISAO = '';
    }

}

function limparErros(){ 
    global $ERRO_CODIGO, $ERRO_MENSAGEM, $ERRO_NOTAS, $ERRO_PAGINA, $ERRO_TITULO;
    $ERRO_CODIGO = 0;
    $ERRO_MENSAGEM = "";
    $ERRO_NOTAS = "";
    $ERRO_PAGINA = "";
    $ERRO_TITULO = "";
}

function verificarErros(){
    global $ERRO_CODIGO, $ERRO_MENSAGEM, $ERRO_NOTAS, $ERRO_PAGINA, $ERRO_TITULO;
    limparErros();
    if (isset($_GET['e_cod'])){ 
        $ERRO_CODIGO = $_GET['e_cod'];
        if (isset($_GET['e_msg'])) $ERRO_MENSAGEM = $_GET['e_msg'];
        if (isset($_GET['e_not'])) $ERRO_NOTAS = $_GET['e_not'];
        if (isset($_GET['e_pag'])) $ERRO_PAGINA = $_GET['e_pag'];
        if (isset($_GET['e_tit'])) $ERRO_TITULO = $_GET['e_tit'];
        return;
    }
    if (isset($_SESSION['ERRO_CODIGO'])){
        $ERRO_CODIGO = $_SESSION['ERRO_CODIGO'];
        if (isset($_SESSION['ERRO_MENSAGEM'])) $ERRO_MENSAGEM = $_SESSION['ERRO_MENSAGEM'];
        if (isset($_SESSION['ERRO_NOTAS']))    $ERRO_NOTAS = $_SESSION['ERRO_NOTAS'];
        if (isset($_SESSION['ERRO_PAGINA']))   $ERRO_PAGINA = $_SESSION['ERRO_PAGINA'];
        if (isset($_SESSION['ERRO_TITULO']))   $ERRO_TITULO = $_SESSION['ERRO_TITULO'];
        return;
    }
    if (isset($_COOKIE['ERRO_CODIGO'])){
        $ERRO_CODIGO = $_COOKIE['ERRO_CODIGO'];
        if (isset($_COOKIE['ERRO_MENSAGEM']))  $ERRO_MENSAGEM = $_COOKIE['ERRO_MENSAGEM'];
        if (isset($_COOKIE['ERRO_NOTAS']))     $ERRO_NOTAS = $_COOKIE['ERRO_NOTAS'];
        if (isset($_COOKIE['ERRO_PAGINA']))    $ERRO_PAGINA = $_COOKIE['ERRO_PAGINA'];
        if (isset($_COOKIE['ERRO_TITULO']))    $ERRO_TITULO = $_COOKIE['ERRO_TITULO'];
        return;
    }
}

function textoRandomico($len){
    $base='ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
	$max=strlen($base)-1;
    $activatecode='';
	mt_srand((double)microtime()*1000000);
    while (strlen($activatecode)<$len+1)
		$activatecode.=$base{mt_rand(0,$max)};
	$activatecode = substr($activatecode,0,$len);
    return $activatecode;
}

function limparDiretorio($dir){
    if(is_dir($dir)){        if($handle = opendir($dir)) {            while(($file = readdir($handle)) !== false) {                if($file != '.' && $file != '..'){                    unlink($dir.$file);                }            }        }    } else {        die("Erro ao abrir dir: $dir");    }    return 0;}

function apagarArquivo($name){
    if( is_file($name)){        /* echo "Arquivo existe:".$name."<br/>"; */        unlink($name);        return true;    } else {        /* echo "Arquivo não encontrado:".$name."<br/>"; */    }    return false;}

function tratarAcentos($texto){
    $strTexto = $texto;    if ($strTexto == "")        return "";
    $strTexto = str_replace("á","&aacute;",$strTexto);    $strTexto = str_replace("â","&acirc;" ,$strTexto);    $strTexto = str_replace("à","&agrave;",$strTexto);    $strTexto = str_replace("ã","&atilde;",$strTexto);    $strTexto = str_replace("ç","&ccedil;",$strTexto);    $strTexto = str_replace("é","&eacute;",$strTexto);    $strTexto = str_replace("ê","&ecirc;" ,$strTexto);    $strTexto = str_replace("í","&iacute;",$strTexto);    $strTexto = str_replace("ó","&oacute;",$strTexto);    $strTexto = str_replace("ô","&ocirc;" ,$strTexto);    $strTexto = str_replace("õ","&otilde;",$strTexto);    $strTexto = str_replace("ú","&uacute;",$strTexto);    $strTexto = str_replace("ü","&uuml;"  ,$strTexto);    $strTexto = str_replace("Á","&Aacute;",$strTexto);    $strTexto = str_replace("Â","&Acirc;" ,$strTexto);    $strTexto = str_replace("À","&Agrave;",$strTexto);    $strTexto = str_replace("Ã","&Atilde;",$strTexto);    $strTexto = str_replace("Ç","&Ccedil;",$strTexto);    $strTexto = str_replace("É","&Eacute;",$strTexto);    $strTexto = str_replace("Ê","&Ecirc;" ,$strTexto);    $strTexto = str_replace("Í","&Iacute;",$strTexto);    $strTexto = str_replace("Ó","&Oacute;",$strTexto);    $strTexto = str_replace("Ô","&Ocirc;" ,$strTexto);    $strTexto = str_replace("Õ","&Otilde;",$strTexto);    $strTexto = str_replace("Ú","&Uacute;",$strTexto);    $strTexto = str_replace("Ü","&Uuml;"  ,$strTexto);
   return $strTexto;
}

function w($a = ''){
    if (empty($a)) return array();
    return explode(' ', $a);
}

function _browser($a_browser = false, $a_version = false, $name = false){
        $browser_list = 'msie firefox chrome konqueror safari netscape navigator opera mosaic lynx amaya omniweb avant camino flock seamonkey aol mozilla gecko';
        $user_browser = strtolower($_SERVER['HTTP_USER_AGENT']);
        $this_version = $this_browser = '';
        
        $browser_limit = strlen($user_browser);
        foreach (w($browser_list) as $row){
                $row = ($a_browser !== false) ? $a_browser : $row;
                $n = stristr($user_browser, $row);
                if (!$n || !empty($this_browser)) continue;
                
                $this_browser = $row;
                $j = strpos($user_browser, $row) + strlen($row) + 1;
                for (; $j <= $browser_limit; $j++){
                        $s = trim(substr($user_browser, $j, 1));
                        $this_version .= $s;
                        
                        if ($s === '') break;
                }
        }
        
        if ($a_browser !== false){
                $ret = false;
                if (strtolower($a_browser) == $this_browser){
                        $ret = true;
                        if ($a_version !== false && !empty($this_version)){
                                $a_sign = explode(' ', $a_version);
                                if (version_compare($this_version, $a_sign[1], $a_sign[0]) === false){
                                        $ret = false;
                                }
                        }
                }
                return $ret;
        }
        
        $this_platform = '';
        if (strpos($user_browser, 'linux')){
                $this_platform = 'linux';
        }
        elseif (strpos($user_browser, 'macintosh') || strpos($user_browser, 'mac platform x')){
                $this_platform = 'mac';
        }
        else if (strpos($user_browser, 'windows') || strpos($user_browser, 'win32')){
                $this_platform = 'windows';
        }
        
        if ($name !== false){
                return $this_browser . ' ' . $this_version;
        }
        
        return array(
                "browser"         => $this_browser,
                "version"         => $this_version,
                "platform"       => $this_platform,
                "useragent"     => $user_browser
        );
}

function limpa_sql_injection($sql) {

// remove palavras que contenham sintaxe sql
  // Remove palavras que contenham sintaxe sql
  $sql = trim($sql); //limpa espaços vazio
 
  // $sql = strip_tags($sql); //tira tags html e php
  
 //$sql = addslashes($sql);
  //$pattern = "/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\|\"|\')/";
  $pattern = "/(from|select|insert |delete|where|drop table|show tables|--)/";
  $match = preg_match($pattern,$sql);
  if($match){
      echo "<script>alert('ERRO. SQL Inject detectado. [$sql]'); history.back();</script>";
      exit;
  }
  return $sql;
  
}
?>