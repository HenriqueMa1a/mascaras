/**
* @description Classe de negócio agenda. 
* @author Kellen Nery
* @date 26/05/2020
* @version 1.0
* @package MDS
* @copyright 
*/ 

function isExplorer(){
	return (navigator.appName == "Microsoft Internet Explorer");
}

function LTrim(str){
	var whitespace = new String(" \t\n\r ");
	var s = new String(str);
	if (whitespace.indexOf(s.charAt(0)) != -1) {
	    var j=0, i = s.length;
	    while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
		j++;
	    s = s.substring(j, i);
	}
	return s;
}

function RTrim(str){
	var whitespace = new String(" \t\n\r ");
	var s = new String(str);
	if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
	    var i = s.length - 1;       // Get length of string
	    while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
		i--;
	    s = s.substring(0, i+1);
	}
	return s;
}

function Trim(str){
	return RTrim(LTrim(str));
}

function Left(str, n){
	if (n <= 0)
	    return "";
	else if (n > String(str).length)
	    return str;
	else
	    return String(str).substring(0,n);
}

function Right(str, n){
    if (n <= 0)
       return "";
    else if (n > String(str).length)
       return str;
    else {
       var iLen = String(str).length;
       return String(str).substring(iLen, iLen - n);
    }
}

function RemoveHtml($txt){
	$txt = str_replace('<strong>' , ' ' , $txt );
	$txt = str_replace('</strong>' , ' ' , $txt );
	$txt = str_replace('<br/>' , ' ' , $txt );
	$txt = str_replace('<i>' , ' ' , $txt );
	$txt = str_replace('</i>' , ' ' , $txt );
	$txt = str_replace('&nbsp;' , ' ' , $txt );
	$txt = str_replace('<p>' , ' ' , $txt );
	$txt = str_replace('</p>' , ' ' , $txt );
	$txt = str_replace('</p>' , ' ' , $txt );
	$txt = str_replace('<em>' , ' ' , $txt );
	$txt = str_replace('</em>' , ' ' , $txt );
	return $txt; 
}


function desabilitarObjeto(idObjeto) {
	
	var obj = document.getElementById(idObjeto);
	if (obj!=null){
		if ( (obj.type == "input") || (obj.type == "password") || (obj.type == "radio") || (obj.type == "checkbox") || (obj.type == "select-one") || (obj.type == "select-multiple") )
			obj.disabled = true;
	}
	
}

function MM_findObj(n, d)
{
  var p,i,x;

  if(!d)
	d=document;
  if((p=n.indexOf("?"))>0&&parent.frames.length)
	{
	d=parent.frames[n.substring(p+1)].document;
	n=n.substring(0,p);
	}
  if(!(x=d[n])&&d.all)
	 x=d.all[n];
  for (i=0;!x&&i<d.forms.length;i++)
	  x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++)
	  x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById)
	 x=d.getElementById(n);
	 return x;
}

function clearCombo(cboNome){
    // while (obj.options.length)
    //    obj.remove(0);
    var objCombo = MM_findObj(cboNome);
    if (objCombo){
		objCombo.options.length = 0;
	}
}

function addItemCombo(cboNome, valor, descricao){
    var newElem;
    var where = (navigator.appName == "Microsoft Internet Explorer") ? -1 : null;

    var objCombo = MM_findObj(cboNome);
    if (objCombo){
		newElem = document.createElement("option");
		newElem.value = valor;
		newElem.text = descricao;
		objCombo.add(newElem, where);
	}
}

function setItemCombo(cboNome, valor){
    
    //var objCombo = document.getElementById(cboNome);
    var objCombo = MM_findObj(cboNome);
    if (objCombo){
        for (i=0; i<objCombo.options.length; i++){
            if (objCombo.options[i].value == valor){
                objCombo.options[i].selected = true;
                break;
            }
        }
    } else {
    	alert ('Não foi possível encontrar o objeto: '+cboNome);
    }
}

function ocultarMensagem(){
    var obj = MM_findObj('msg_quadro');
    if (obj != null){
        obj.style.display = 'none';
    }
}
function mostrarMensagem(tipo, mensagem){
    var obj =null ;
    
    obj = MM_findObj('msg_quadro');
    if (obj != null){
        obj.style.display = 'block';
        
        obj = MM_findObj('msg_icone');
        if (obj != null){
			obj.src = 'images/i_'+tipo+'.png';
        }
        var obj = MM_findObj('msg_texto');
        if (obj != null){
            obj.innerHTML = mensagem;
        }
    }
}



