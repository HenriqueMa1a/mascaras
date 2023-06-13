
// Função que exibe e oculta guia.

ultTab = '';
function tabGuia(nomTab)
{
	var img ="";

	// voltar a guia para o normal
	if (ultTab != ''){
		if (document.getElementById("IMG_" + ultTab)!= null){
			img = document.getElementById("IMG_" + ultTab).src;
			img = img.replace("_1.gif","_2.gif");
			document.getElementById("IMG_" + ultTab).src = img;
		} else {
			alert("Erro ao desabilitar a guia, o objeto 'GUIA_" + ultTab + "' não foi encontrado.");
		}
		if (document.getElementById("GUIA_" + ultTab)!= null){
			document.getElementById("GUIA_" + ultTab).style.display = "none";
		} else {
			alert("Erro ao desabilitar a guia, o objeto 'GUIA_" + ultTab + "' não foi encontrado.");
		}
	}
	ultTab = nomTab;

	// abre a guia escolhida
	if ((nomTab != "") && (nomTab != 'undefined')){
		if (document.getElementById("IMG_" + nomTab)!= null){
			img = document.getElementById("IMG_" + nomTab).src;
			img = img.replace("_2.gif","_1.gif");
			document.getElementById("IMG_" + nomTab).src = img;
			if (document.getElementById("GUIA_" + nomTab)!= null){
				document.getElementById("GUIA_" + nomTab).style.display = "";
			} else {
				alert("Erro ao habilitar a guia, o objeto 'GUIA_" + nomTab + "' não foi encontrado.");
			}
		} else {
			alert("Erro ao habilitar a guia, o objeto 'IMG_" + nomTab + "' não foi encontrado.");
		}
	}

}
