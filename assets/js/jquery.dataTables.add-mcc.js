
jQuery.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
    // check that we have a column id
    if ( typeof iColumn == "undefined" ) return [];
      
    // by default we only wany unique data
    if ( typeof bUnique == "undefined" ) bUnique = true;
      
    // by default we do want to only look at filtered data
    if ( typeof bFiltered == "undefined" ) bFiltered = true;
      
    // by default we do not wany to include empty values
    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
      
    // list of rows which we're going to loop through
    var aiRows;
      
    // use only filtered rows
    if (bFiltered == true) aiRows = oSettings.aiDisplay;
    // use all rows
    else aiRows = oSettings.aiDisplayMaster; // all row numbers
  
    // set up data array   
    var asResultData = new Array();
      
    for (var i=0,c=aiRows.length; i<c; i++) {
        iRow = aiRows[i];
        var sValue = this.fnGetData(iRow, iColumn);
          
        // ignore empty values?
        if (bIgnoreEmpty == true && sValue.length == 0) continue;
  
        // ignore unique values?
        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
          
        // else push the value onto the result data array
        else asResultData.push(sValue);
    }
      
    return asResultData;
};

$.fn.dataTableExt.oApi.fnGetColumnIndex = function ( oSettings, sCol )
{
    var cols = oSettings.aoColumns;
    for ( var x=0, xLen=cols.length ; x<xLen ; x++ )
    {
        if ( cols[x].sTitle.toLowerCase() == sCol.toLowerCase() )
        {
            return x;
        };
    }
    return -1;
};

$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    // DataTables 1.10 compatibility - if 1.10 then versionCheck exists.
    // 1.10s API has ajax reloading built in, so we use those abilities
    // directly.
    if ( $.fn.dataTable.versionCheck ) {
        var api = new $.fn.dataTable.Api( oSettings );
 
        if ( sNewSource ) {
            api.ajax.url( sNewSource ).load( fnCallback, !bStandingRedraw );
        }
        else {
            api.ajax.reload( fnCallback, !bStandingRedraw );
        }
        return;
    }
 
    if ( sNewSource !== undefined && sNewSource !== null ) {
        oSettings.sAjaxSource = sNewSource;
    }
 
    // Server-side processing should just call fnDraw
    if ( oSettings.oFeatures.bServerSide ) {
        this.fnDraw();
        return;
    }
 
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];
 
    this.oApi._fnServerParams( oSettings, aData );
 
    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable( oSettings );
 
        /* Got the data - add it to the table */
        var aData =  (oSettings.sAjaxDataProp !== "") ?
            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
 
        for ( var i=0 ; i<aData.length ; i++ )
        {
            that.oApi._fnAddData( oSettings, aData[i] );
        }
         
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
 
        that.fnDraw();
 
        if ( bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd( oSettings );
            that.fnDraw( false );
        }
 
        that.oApi._fnProcessingDisplay( oSettings, false );
 
        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback !== null )
        {
            fnCallback( oSettings );
        }
    }, oSettings );
};

jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "numeric-comma-pre": function (a) {
        var x = (a == "-") ? 0 : a.replace(/,/, ".");
        return parseFloat(x);
    },

        "numeric-comma-asc": function (a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

        "numeric-comma-desc": function (a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },
        'us_date-asc': function (a, b) {
        var x = new Date(a),
            y = new Date(b);
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    },
    'us_date-desc' : function (a, b) {
        var x = new Date(a),
            y = new Date(b);
        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
    }
});
