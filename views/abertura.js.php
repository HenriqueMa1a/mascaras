<link type="text/css" href="assets/css/morris.css" rel="stylesheet" />	
<script type="text/javascript" src="assets/js/morris.min.js"></script>
<script type="text/javascript" src="assets/js/raphael-min.js"></script>


<script src="assets/js/highcharts/highcharts.js"></script>
<script src="assets/js/highcharts/series-label.js"></script>
<script src="assets/js/highcharts/exporting.js"></script>
<script src="assets/js/highcharts/export-data.js"></script>
<script src="assets/js/highcharts/accessibility.js"></script>

<script src="assets/js/highcharts/data.js"></script>
<script src="assets/js/highcharts/drilldown.js"></script>

<script type="text/javascript">

    var bl_painel_contrato = '<?php //echo getPermissaoAcesso('/forms/medicao/relatorios/rel_painel_bordo.php', (isset($sisUsuario)) ? $sisUsuario->IdPerfil: 0); ?>';
    bl_painel_contrato = '1';
    uso_contrato = '';
    /*
    try {
        google.load("visualization", "1.1", {packages:["geochart"]});
	} catch(err) {
		console.log('google.load("visualization", "1.1", {packages:["geochart"]}) return error['+err.message+'];');
	} // */
        
/* JS JQUERY ************************************************************************************************************************************ */
jQuery(document).ready(function()
{
    $('[data-toggle=popover]').popover({trigger : 'hover', delay: {'show': 50, 'hide': 200}}).click(function(e) {
        if($(this).is('button') || ($(this).attr('data-type')=='data')) $(this).popover('hide');
    });
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);

    inicializar();

/////////////////GRÁFICO 1//////////////////////////////
var days = 86400000;
var hoje = new Date((new Date()) - 6 * days);
var dia = hoje.getDate();  
var mes = hoje.getMonth(); 
var ano = hoje.getFullYear(); 

Highcharts.chart('grafico1', {
  chart: {
    type: 'spline',
    scrollablePlotArea: {
      minWidth: 600,
      scrollPositionX: 1
    }
  },
  title: {
    text: 'Quantidade de máscaras distribuidas por dia',
    align: 'center'
  },
  xAxis: {
    type: 'datetime',
    labels: {
      overflow: 'justify'
    }
  },
  yAxis: {
    title: {
      text: 'Quantidade'
    },
    //minorGridLineWidth: 0,
    //gridLineWidth: 0,
    //alternateGridColor: null
  },
  //tooltip: {
  //  valueSuffix: ' m/s'
  //},
  plotOptions: {
    spline: {
      lineWidth: 4,
      states: {
        hover: {
          lineWidth: 5
        }
      },
      marker: {
        enabled: true
      },
      pointInterval: 86400000, // one day
      pointStart: Date.UTC(ano, mes, dia, 0, 0, 0)
    }
  },
  series: [{
    name: 'Qtd',
    data: [548, 758, 325, 74, 598, 485, 247]
  }],
  navigation: {
    menuItemStyle: {
      fontSize: '10px'
    }
  }
});
//////////////////////////////////////////
/////////////////GRÁFICO 2//////////////////////////////

Highcharts.chart('grafico2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Distribuição por UO'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Quantidade'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> do total<br/>'
    },

    series: [
        {
            name: "UO",
            colorByPoint: true,
            data: [
                {
                    name: "LAMEV",
                    y: 100,
                    drilldown: "LAMEV"
                },
                {
                    name: "DISEC",
                    y: 120,
                    drilldown: "DISEC"
                },
                {
                    name: "DISEG",
                    y: 54,
                    drilldown: "DISEG"
                },
                {
                    name: "DIMUT",
                    y: 75,
                    drilldown: "DIMUT"
                },
                {
                    name: "DIEVA-CTV",
                    y: 158,
                    drilldown: "DIEVA-CTV"
                }
            ]
        }
    ],
	
    drilldown: {
        series: [
            {
                name: "LAMEV",
                id: "LAMEV",
                data: [
                    [
                        "SECAL",
                        20
                    ],
                    [
                        "SEVAU",
                        8
                    ],
                    [
                        "SEVAC",
                        12
                    ],
                    [
                        "SEQES",
                        30
                    ],
                    [
                        "SEVAN",
                        25
                    ],
                    [
                        "SEVAP",
                        5
                    ]
                ]
            },
            {
                name: "DISEC",
                id: "DISEC",
                data: [
                    [
                        "SEAMO",
                        20
                    ],
                    [
                        "SEMEC",
                        35
                    ],
                    [
                        "SEPRM",
                        45
                    ],
                    [
                        "SEDOC",
                        20
                    ]
                ]
            },
            {
                name: "DISEG",
                id: "DISEG",
                data: [
                    [
                        "SEAPO",
                        14
                    ],
                    [
                        "SEPAT",
                        40
                    ]
                ]
            },
            {
                name: "DIMUT",
                id: "DIMUT",
                data: [
                    [
                        "SEMRE",
                        10
                    ],
                    [
                        "SELET",
                        15
                    ],
                    [
                        "SEOPE",
                        20
                    ],
                    [
                        "SEMAP",
                        5
                    ],
                    [
                        "SEMMA",
                        25
                    ]
                ]
            },
            {
                name: "DIEVA-CTV",
                id: "DIEVA-CTV",
                data: [
                    [
                        "SEDIL",
                        26
                    ],
                    [
                        "SEVLQ",
                        92
                    ],
                    [
                        "SEVLI",
                        40
                    ]
                ]
            }
        ]
    }
});
/////////////////////////
/////////////////GRÁFICO 3//////////////////////////////
Highcharts.setOptions({
  colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
    return {
      radialGradient: {
        cx: 0.5,
        cy: 0.3,
        r: 0.7
      },
      stops: [
        [0, color],
        [1, Highcharts.color(color).brighten(-0.3).get('rgb')] // darken
      ]
    };
  })
});

// Build the chart
Highcharts.chart('grafico3', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Distribuição por Posto de Entrega'
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage: 1.f}</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        //format: '<b>{point.name}</b>: {point.percentage: 1.f}',
        connectorColor: 'silver'
      }
    }
  },
  
  series: [{
    name: 'Qtde',
    data: [
      { name: 'Rocha Lima', y: 54.36 },
      { name: 'Rockfeller', y: 11.84 },
      { name: 'CTV1', y: 10.85 },
      { name: 'CTV2', y: 4.67 },
      { name: 'Recepção DEVIR', y: 4.18 },
      { name: 'Recepção LAFAM', y: 7.05 },
	  { name: 'Recepção CTKF', y: 7.05 }
    ]
  }]
});



    
});


/* JS NORMAIS ************************************************************************************************************************************ */


/* BLOBO CONTRATO ************************************************************************************************************************************ */
function carregarGridContratos(tecla){
	
    if(tecla==13){
		
		var urlAjax = 'actions/rel_painel_bordo.action.php?acao=listar&nu_empresa='+oUsuario.IdEmpresa+'&nu_contrato='+uso_contrato+'&st_contrato=1';

		myApp.showPleaseWait();
		if (typeof oTable == 'undefined') {	
			oTable = $('#tabListagemContratos').dataTable({
				"oLanguage": {"sUrl": "assets/js/jquery.dataTables.pt-br.txt"},
				"aaSorting": [[5, 'asc']],
				"aoColumnDefs": [
					{"aTargets": [0], "bSortable" : false, "bSearchable": false, "bVisible": false, "sWidth": "0%" },
					{"aTargets": [1], "bSortable" : false, "bSearchable": false, "bVisible": true, "sWidth": "3%", "sClass": "text-center" },
					{"aTargets": [2], "bSortable" : true, "bVisible": true, "sWidth": "20%", "sClass": "text-left" },
					{"aTargets": [3], "bSortable" : false, "bSearchable": false, "bVisible": false, "sWidth": "0%", "sClass": "text-left" },
					{"aTargets": [4], "bSortable" : false, "bSearchable": false, "bVisible": false, "sWidth": "0%", "sClass": "text-left" },
					{"aTargets": [5], "bSortable" : true, "bSearchable": false, "bVisible": true, "sWidth": "10%", "sClass": "text-right", "sType": "numeric-comma",},
					{"aTargets": [6], "bSortable" : true, "bSearchable": false, "bVisible": true, "sWidth": "7%", "sClass": "text-right", "sType": "numeric-comma",},
					{"aTargets": [7], "bSortable" : false, "bSearchable": false, "bVisible": false, "sWidth": "0%", "sClass": "text-right"},
					{"aTargets": [8], "bSortable" : false, "bSearchable": false, "bVisible": true, "sWidth": "3%", "sClass": "text-right" }
				],
				"bDestroy": true,	        
				"sAjaxSource": urlAjax,
				"bProcessing": true,
				"bServerSide": false,
				"bPaginate": true,
				"bFilter": false,
				"bInfo": true,
				"bSort" : true,
				//"sDom": 'lfrtip',
				//"sDom": 'T<"clear">lfrtip',
				"iDisplayLength": 10
			});
            
            $('#tabListagemContratos').on('draw.dt', function () {
                myApp.hidePleaseWait();
            });  
            
		} else {
			oTable.fnClearTable(0);
			var oSettings = oTable.fnSettings();
			oSettings.sAjaxSource = urlAjax;
			oTable.fnReloadAjax();
		} 
		myApp.hidePleaseWait();
	}
}

/* BLOBO ALERTAS ************************************************************************************************************************************ */


/* INICIALIZAR ************************************************************************************************************************************ */

function inicializar()
{

    if (oModulo.Grupo.Chave=='cadastro') { alert("teste"); // Cadastro 
    
        if (oUsuario.Id>0) { // Uauário autenticado
            
            // Contexto do Usuário
            if (oUsuario.IdTipo == 1) { // 1:Matriz
                
            } else if (oUsuario.IdTipo == 2){ // 2:Filial
                
            } else { // #:Outros
                
            }
            
        } else {
            $('#box-Indicadores').hide();
            $('#box-Resultado').hide();
            $('#box-Mapa').hide();
        }
        
        $('#boxGridContratos').hide();
        
    } else if ((oModulo.Grupo.Chave=='dashboard') || (oModulo.Grupo.Chave=='registro') || (oModulo.Grupo.Chave=='abertura') ){ // Cadastro
        if (bl_painel_contrato) { 
            //carregarGridContratos(13);
            $('#boxGridContratos').show();
        } else {
            $('#boxGridContratos').hide();
        }
    
    } else {
        console.log('indicadores [Grupo: '+oModulo.Grupo.Chave+'];');
        $('#box-Indicadores').hide();
        $('#box-Resultado').hide();
        $('#box-Mapa').hide();
        
        $('#boxGridContratos').hide();
    }
    

}



</script>
