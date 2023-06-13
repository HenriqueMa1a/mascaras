
var objListas = new Object();
var arrListas = new Array ();
function newLista(strLista)
{
    arrListas[arrListas.length] = strLista;
    objListas[strLista] = [];
}

newLista("all");
function isLista(strLista){
    var indLista = -1;
    for (i=0;i<arrListas.length;i++){
       if (arrListas[i]==strLista){
          indLista = i;
          i=arrListas.length + 1;
         }
    }
    if (indLista >= 0)
       return true;
    else
       return false;
}

function addItemLista(strLista, value, text){
    if (!isLista(strLista))
        strLista="all";

    obj = objListas[strLista];
    var id = obj.length;
    obj[id] = new Object();
    obj[id].value = value;
    obj[id].text=text;
}

function clearCombo(obj){
    // while (obj.options.length)
    //    obj.remove(0);
	obj.options.length = 0;
}

function setCombo(cboNome, strLista) {
    var newElem;
    var where = (navigator.appName == "Microsoft Internet Explorer") ? -1 : null;

    var objCombo = document.getElementById(cboNome);

    clearCombo(objCombo);

    var objLista = objListas[strLista];

    newElem = document.createElement("option");
//    newElem.value = "0";
//    newElem.text = "";
    objCombo.add(newElem, where);

    if (strLista != "") {
        for (var i = 0; i < objLista.length; i++) {
            newElem = document.createElement("option");
            newElem.value = objLista[i].value;
            newElem.text = objLista[i].text;
            objCombo.add(newElem, where);
        }
    }
}

newLista ("C");
	addItemLista ("C","=","igual")
	addItemLista ("C","<","menor que")
	addItemLista ("C",">","maior que")
	addItemLista ("C","<=","menor ou igual a")
	addItemLista ("C",">=","maior ou igual a")
	addItemLista ("C","<>","diferente")
	addItemLista ("C","LIKE","contenha")
	addItemLista ("C","LLIKE","começa com")
	addItemLista ("C","RLIKE","termina com")

newLista ("N");
	addItemLista ("N","=","igual")
	addItemLista ("N","<","menor que")
	addItemLista ("N",">","maior que")
	addItemLista ("N","<=","menor ou igual a")
	addItemLista ("N",">=","maior ou igual a")
	addItemLista ("N","<>","diferente")

newLista ("B");
	addItemLista ("B","=","igual")

newLista ("D");
	addItemLista ("D","=","igual")
	addItemLista ("D","<","menor que")
	addItemLista ("D",">","maior que")
	addItemLista ("D","<=","menor ou igual a")
	addItemLista ("D",">=","maior ou igual a")
	addItemLista ("D","<>","diferente")

	
function carregarCriterio(cboNome, strLista) {

	if (document.getElementById("FORM") != null){
		var num = Right(cboNome,1);
		if (document.getElementById("tmpValor"+num) != null){
			var objCampo = document.getElementById("tmpCampo"+num);
			if (objCampo != null){
				strTemp = objCampo.options[objCampo.selectedIndex].value
				var strTipo = strTemp.substr(0,1);
				var strCampo = strTemp.substr(2,strTemp.length);
				setCombo(cboNome, strTipo);
			}  else alert("Não foi possivel encontrar o campo 'boxSqlTipo"+num+"'.");
		} else alert("Não foi possivel encontrar o campo 'tmpValor"+num+"'.");
	} else alert("Não foi possivel encontrar o objeto 'FORM'.");
    /* if (document.getElementById(cboNome).length == 1)
        setCombo(cboNome, "all"); */
}

function limparFiltro(){

	var qtd = eval(document.getElementById("tmpQtdCriterios").value);
	if (qtd < 1) qtd = 1;

	for (i=qtd;i>1;i--)
		menosCriterio(i);

	// Limpo os Campos da Linha;
	limparCriterio(1);
		
	// Atualiza a quantidade;
	document.getElementById("tmpQtdCriterios").value = 1;
	
	// Passar o foco para o primeiro campo;
	document.getElementById("tmpCampo1").focus();
	
}

function aplicarFiltro(){
	
	var qtd = eval(document.getElementById("tmpQtdCriterios").value);
	if (qtd < 1) qtd = 1;

	// Criticar os Campos;
	for (i=1;i<=qtd;i++){
		if (!criticarCriterios(i)){
			return false;
		}
	}
	
	// moatar o Filtro SQL
	return montarFiltro();
	
}

function criticarCriterios(num){
	
	if (document.getElementById("tmpCampo"+num) != null){
		if (document.getElementById("tmpCampo"+num).value == "") {
			alert(" - O campo 'Campo "+num+"' é obrigatório.");
			document.getElementById("tmpCampo"+num).focus();
			return false;
		}
	} else {
		alert("Não foi possivel encontrar o campo 'tmpValor"+num+"'.");
		return false;
	}


	if (document.getElementById("tmpCriterio"+num) != null){
		if (document.getElementById("tmpCriterio"+num).value == "") {
			alert(" - O campo 'Critério "+num+"' é obrigatório.");
			document.getElementById("tmpCriterio"+num).focus();
			return false;
		}
	} else {
		alert("Não foi possivel encontrar o campo 'tmpCriterio"+num+"'.");
		return false;
	}

	if (document.getElementById("tmpValor"+num) != null){
		if (document.getElementById("tmpValor"+num).value == "") {
			alert(" - O campo 'Valor "+num+"' é obrigatório.");
			document.getElementById("tmpValor"+num).focus();
			return false;
		}
	} else {
		alert("Não foi possivel encontrar o campo 'tmpValor"+num+"'.");
		return false;
	}

	if (document.getElementById("tmpOrdenacao") != null){
		if (document.getElementById("tmpOrdenacao").value == "") {
			alert(" - O campo 'Ordenção' é obrigatório.");
			document.getElementById("tmpOrdenacao").focus();
			return false;
		}
	} else {
		alert("Não foi possivel encontrar o campo 'tmpOrdenacao'.");
		return false;
	}

	return true;
}

function montarFiltro(){

	var strSQL='';
	var strORDER='';
	
	
	// Vamos montar os Critérios;
	var qtd = eval(document.getElementById("tmpQtdCriterios").value);
	if (qtd < 1) qtd = 1;

	for (i=1;i<=qtd;i++)
		strSQL = strSQL + "(";
		
	for (i=1;i<=qtd;i++){
		if (i>1) {
			var objCombina = document.getElementById("tmpCombina"+i);
			if (objCombina != null){
				strSQL = strSQL + " " + objCombina.options[objCombina.selectedIndex].value + " ";
			} else return false;
		}
		strSQL = strSQL + getCriterio(i) + ")";
	}
	
	// Vamos montar a Arodenação;
	strORDER = document.getElementById("tmpOrdenacao").value + " " + document.getElementById("tmpDirecao").value;
	
	// Vamos passar o parametros para o FORM ;
	document.getElementById("boxSqlWhere").value = strSQL;
	document.getElementById("boxSqlOrder").value = strORDER;
	
	carregarLista(1);
	
}

function getCriterio(ind){

	var strSQL='';
	var strTipo = '';
	var strCampo = '';
	var strCampoNome = '';
	
	if (criticarCriterios(ind)){
		
		var objCampo = document.getElementById("tmpCampo"+ind);
		if (objCampo != null){
			strTemp = objCampo.options[objCampo.selectedIndex].value;
			strTipo = strTemp.substr(0,1);
			strCampo = strTemp.substr(2,strTemp.length);
			strCampoNome = objCampo.options[objCampo.selectedIndex].text;
		}
		var cbo = document.getElementById("tmpCriterio"+ind);
		var strCriterio = cbo[cbo.selectedIndex].value;
		var strValor = document.getElementById("tmpValor"+ind).value.replace("'","''");

		if (strTipo == "C"){
			if (strCriterio == "LIKE"){
				strSQL = strCampo + " LIKE '#PER#" + strValor + "#PER#'";

			} else if (strCriterio == "LLIKE") {
				strSQL = strCampo + " LIKE '" + strValor + "#PER#'";
			
			} else if (strCriterio == "RLIKE"){
				strSQL = strCampo + " LIKE '#PER#" + strValor + "'";
			
			} else {
				strSQL = strCampo + " " + strCriterio + "'" +  strValor + "'";
			}
		} else if (strTipo == "N") {
			strSQL = strCampo + strCriterio +  strValor;

		} else if (strTipo == "B") {
			strSQL = strCampo + strCriterio +  strValor;
			
		} else if (strTipo == "D") {
			strSQL = strCampo + " " + strCriterio + "#" +  strValor + "#";
			
		} else {
			strSQL = " AND 0=0";
			alert('tipo='+strTipo);
		}
		return strSQL;
		
	}

}


function maisCriterio(num){

	var objImg = document.getElementById("IMG_DEL_"+num);
	if (objImg != null) objImg.style.display = "none";
	
	var objImg = document.getElementById("IMG_ADD_"+num);
	if (objImg != null) objImg.style.display = "none";
	
	num = eval(num+1);
	
	var objLinha = document.getElementById("TD_CAMPO_"+num);
	if (objLinha != null) objLinha.style.display = "";

	var objQtd = document.getElementById("tmpQtdCriterios");
	if (objQtd != null) objQtd.value = num;
	
}

function menosCriterio(num){

	// Atulaizo a quantidade de critérios;
	var objQtd = document.getElementById("tmpQtdCriterios");
	if (objQtd != null)
		objQtd.value = eval(num-1);
	
	// Limpo os Campos da Linha;
	limparCriterio(num);

	// Oculto a Linha dos campos;
	var objLinha = document.getElementById("TD_CAMPO_"+num);
	if (objLinha != null)
		objLinha.style.display = "none";

	num = eval(num-1);
		
	var objImg = document.getElementById("IMG_ADD_"+num);
	if (objImg != null) objImg.style.display = "";

	var objImg = document.getElementById("IMG_DEL_"+num);
	if (objImg != null) objImg.style.display = "";
	
}

function limparCriterio(num){

	if (document.getElementById("tmpCombina"+num) != null) document.getElementById("tmpCombina"+num).selectedIndex = 0;
	if (document.getElementById("tmpCampo"+num) != null) document.getElementById("tmpCampo"+num).selectedIndex = -1;
	if (document.getElementById("tmpCriterio"+num) != null) document.getElementById("tmpCriterio"+num).selectedIndex = -1;
	if (document.getElementById("tmpValor"+num) != null) document.getElementById("tmpValor"+num).value = "";
	
}
