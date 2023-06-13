// Função que abre a tela Consulta;
	function abrirConsulta(){
		window.open('../query.php', 'modQuery', 'top=120,left=100,width=650,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,maximized=no',true)
	}

// Função que abre a tela Consulta;
	function abrirFicha(){
		window.open('./ficha.php', 'modFicha', 'top=50,left=50,width=650,height=500,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,maximized=no',true)
	}

// Função que abre a tela Endereço;
	function abrirEndereco(empresa, codigo, tipo){
		window.open('../endereco.php?EMP_ID=' + empresa + '&END_ID=' + codigo + '&END_TIPO=' + tipo, 'modEndereco', 'top=120,left=100,width=650,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,maximized=no',true)
	}

// Função body onload;
    function _body_onload(){
        if (document.getElementById("loaderContainer") != null)
            document.getElementById("loaderContainer").style.display = "none";
    }

// Função body onunload;
    function _body_onunload(){
        if (document.getElementById("loaderContainer") != null)
            document.getElementById("loaderContainer").style.display = "";
    }

// Função Valida um Click no Form;
	var oneClick; 
	oneClick=false;
	function validaForm(frm) {

		if (oneClick == true)
			return false;

		oneClick = true
		_body_onunload();
		return true;

	}

// Função escolher a Operacao;
    function setOperacao($ope){
        if (document.getElementById("boxOperacao") != null)
            document.getElementById("boxOperacao").value = $ope;
    }

// Função escolher o registro ;
    function setRegistro($reg){
        if (document.getElementById("boxRegistro") != null)
            document.getElementById("boxRegistro").value = $reg;
    }

// Função escolher a Opção;
    function setOpcao($opc){
        if (document.getElementById("boxOpcao") != null)
            document.getElementById("boxOpcao").value = $opc;
    }

// Função Executar uma Operacao;
    function executarOperacao($ope, $reg, $opc){
		setOperacao($ope);
		setRegistro($reg);
		setOpcao($opc);
    }

// Função Executar um Link;
    function executarLink($ope, $reg, $opc){
		setOperacao($ope);
		setRegistro($reg);
		setOpcao($opc);
        if (document.getElementById("FORM") != null)
            document.getElementById("FORM").submit();
    }

// Função Executar uma consulta;
	function executarConsulta($opc){
		
		if ($opc == 1){
	        if (document.getElementById("divLista") != null)
	            document.getElementById("divLista").style.display = "none";
	        if (document.getElementById("divBusca") != null){
	            document.getElementById("divBusca").style.display = "";
			}
		} else {
	        if (document.getElementById("divLista") != null)
	            document.getElementById("divLista").style.display = "";
	        if (document.getElementById("divBusca") != null)
	            document.getElementById("divBusca").style.display = "none";
			if (document.getElementById("boxWhere") != null)
				document.getElementById("boxWhere").value = "";
			if (document.getElementById("boxOrder") != null)
				document.getElementById("boxOrder").value = "";
		}
		// window.open('../query.php', 'modQuery', 'top=120,left=100,width=650,height=250,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no,maximized=no',true)
	}
	
