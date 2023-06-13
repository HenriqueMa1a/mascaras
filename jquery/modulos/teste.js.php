<script type="text/javascript">

var mod_classe = '<?php echo $MOD_CLASSE; ?>';
var user = '<?php echo $USO_ID; ?>';
//alert(mod_classe);
var lastsel3;

jQuery(document).ready(function(){

	/* JQUERY.JDGRID ****************************************************************************************************************************** */
jQuery("#rowed6").jqGrid({
	///url : 'modulos/teste.action.php?acao=listar&IdUsuario='+user,
	///datatype: "json",
	datatype: "local",
   	colNames:['','Autor','Instituição','Email','Principal','Apresentador','Justificativa',''],
   	colModel:[
		{name:'codigo',index:'codigo', width:20, align:"left", editable:false,sortable:false},
		{name:'autor',index:'autor', width:108, align:"left", editable:true,sortable:true},
   		{name:'instituicao',index:'instituicao', width:108, align:"left", editable:true},
   		{name:'email',index:'email', width:128, align:"left",editable:true},
   		///{name:'Principal',index:'Principal', width:80, align:"left",editable:true},
   		{name:'principal',index:'principal', width:60, editable: true,edittype:"checkbox",editoptions: {value:"Sim:Não"}},
   		///{name:'Apresentador',index:'Apresentador', width:88,align:"left",editable:true},
   		{name:'apresentador',index:'apresentador', width:60, editable: true,edittype:"checkbox",editoptions: {value:"Sim:Não"}},
   		///{name:'Justificativa',index:'Justificativa', width:136,align:"left",editable:true}
   		{name:'justificativa',index:'justificativa', width:200, sortable:false,editable: true,edittype:"textarea", editoptions:{rows:"2",cols:"40"}},
   		{name:'act',index:'act', width:75,sortable:false},
   	],
   onSelectRow: function(id){
   	 if(id && id!==lastsel3){
   		  jQuery('#rowed6').jqGrid('restoreRow',lastsel3);
   	   	  jQuery('#rowed6').jqGrid('editRow',id,true,pickdates);
   	   	  var ids = jQuery("#rowed6").jqGrid('getDataIDs');
   	   		document.getElementById('jqg1_justificativa').style.display = 'none';
	   		document.getElementById('jqg2_justificativa').style.display = 'none';
	   		document.getElementById('jqg3_justificativa').style.display = 'none';
	   		document.getElementById('jqg4_justificativa').style.display = 'none';
	   		document.getElementById('jqg5_justificativa').style.display = 'none';
	   		document.getElementById('jqg6_justificativa').style.display = 'none';
	   		document.getElementById('jqg7_justificativa').style.display = 'none';
	   		document.getElementById('jqg8_justificativa').style.display = '';
	   		document.getElementById('jqg9_justificativa').style.display = '';
	   		document.getElementById('jqg10_justificativa').style.display = '';
	   		
   	   	  lastsel3=id; 
   	   
   	   		/*for(var i=0;i < ids.length;i++){
   	   			var cl = ids[i];
   	   			se = "<input style='height:22px;width:45px;background:#ffffff;' type='button' value='Salvar' onclick=\"jQuery('#rowed6').saveRow('"+cl+"');\" />";
   	   			jQuery("#rowed6").jqGrid('setRowData',ids[i],{act:se});
   	   	   		}*/
   	   	  } 
   	
	   },
   	width:651,
	height: 232,
	editurl: "server.php",
	caption: "Autores"
		
 });
var mydata3 = [
       		{codigo:"<strong>1º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ",apresentador:" ", justificativa:" "},
       		{codigo:"<strong>2º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ",apresentador:" ",justificativa:" "},
       		{codigo:"<strong>3º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ",apresentador:" ",justificativa:" "},
       		{codigo:"<strong>4º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ",ship:" ",justificativa:" "},
       		{codigo:"<strong>5º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ",apresentador:" ",justificativa:" "},
       		{codigo:"<strong>6º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ", apresentador:" ",justificativa:" "},
       		{codigo:"<strong>7º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ",apresentador:" ",justificativa:" "},
       		{codigo:"<strong>8º</strong>",autor:" ",instituicao:" ",email:"  ",principal:" ",apresentador:" ",justificativa:" "},
       		{codigo:"<strong>9º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ", apresentador:" ",justificativa:" "},
       		{codigo:"<strong>10º</strong>",autor:" ",instituicao:" ",email:" ",principal:" ", apresentador:" ",justificativa:" "}
       		];

for(var i=0;i < mydata3.length;i++)
	jQuery("#rowed6").jqGrid('addRowData',mydata3[i].id,mydata3[i]);
	
function pickdates(id){
	jQuery("#"+id+"_sdate","#rowed6").datepicker({dateFormat:"yy-mm-dd"})
}
///jQuery("#rowed6").jqGrid('navGrid',"#prowed6",{edit:true,add:true,del:true});


});

/*
var lastsel3;
jQuery("#rowed6").jqGrid({

	datatype: "local",
	height: 250,
	colNames:['ID Number','Last Sales','Name', 'Stock', 'Ship via','Notes'], 
	colModel:[
				{name:'id',index:'id', width:90, sorttype:"int", editable: true},
				{name:'sdate',index:'sdate',width:90, editable:true, sorttype:"date"},
				{name:'name',index:'name', width:150,editable: true,editoptions:{size:"20",maxlength:"30"}},
				{name:'stock',index:'stock', width:60, editable: true,edittype:"checkbox",editoptions: {value:"Yes:No"}},
				{name:'ship',index:'ship', width:90, editable: true,edittype:"select",editoptions:{value:"FE:FedEx;IN:InTime;TN:TNT;AR:ARAMEX"}},
				{name:'note',index:'note', width:200, sortable:false,editable: true,edittype:"textarea", editoptions:{rows:"2",cols:"10"}}
			],
	onSelectRow: function(id){
	if(id && id!==lastsel3){
		jQuery('#rowed6').jqGrid('restoreRow',lastsel3);
		jQuery('#rowed6').jqGrid('editRow',id,true,pickdates);
		lastsel3=id;
	}
},
	editurl: "server.php",
	caption: "Date Picker Integration"
				
});
	var mydata3 = [
		{id:"12345",name:"Desktop Computer",note:"note",stock:"Yes",ship:"FedEx", sdate:"2007-12-03"},
		{id:"23456",name:"Laptop",note:"Long text ",stock:"Yes",ship:"InTime",sdate:"2007-12-03"},
		{id:"34567",name:"LCD Monitor",note:"note3",stock:"Yes",ship:"TNT",sdate:"2007-12-03"},
		{id:"45678",name:"Speakers",note:"note",stock:"No",ship:"ARAMEX",sdate:"2007-12-03"},
		{id:"56789",name:"Laser Printer",note:"note2",stock:"Yes",ship:"FedEx",sdate:"2007-12-03"},
		{id:"67890",name:"Play Station",note:"note3",stock:"No", ship:"FedEx",sdate:"2007-12-03"},
		{id:"76543",name:"Mobile Telephone",note:"note",stock:"Yes",ship:"ARAMEX",sdate:"2007-12-03"},
		{id:"87654",name:"Server",note:"note2",stock:"Yes",ship:"TNT",sdate:"2007-12-03"},
		{id:"98765",name:"Matrix Printer",note:"note3",stock:"No", ship:"FedEx",sdate:"2007-12-03"}
		];
	for(var i=0;i < mydata3.length;i++)
		jQuery("#rowed6").jqGrid('addRowData',mydata3[i].id,mydata3[i]);
	function pickdates(id){
		jQuery("#"+id+"_sdate","#rowed6").datepicker({dateFormat:"yy-mm-dd"});
		
}
*/


//post-submit callback 
function showResponse(data) { 

	if (data.sucesso) {
	
			mostrarMensagem('sucesso', data.mensagem);
		
			habilitaForm('true');
			limpaForm();

			//pesquisar_conteudo(13);
			
	} else {                
		mostrarMensagem('erro', data.mensagem);
	} 
	hideLoading();
			
} 

function showLoading(){
	$.blockUI({ theme: true, title: 'Bio-Manguinhos', message: '<p>Por favor aguarde . . . </p>'}); 
}

function hideLoading(){
	$.unblockUI();
}
</script>