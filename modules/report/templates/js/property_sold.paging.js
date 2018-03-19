/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var _store = null;
Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
       // idProperty: 'email_id',
        remoteSort: true,
        fields: [
            'total', 'house', 'apartment','land', 'flat', 'total_sold' 
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link
        })
    });
    store.setDefaultSort('total', 'DESC');  
	
	// pluggable renders
    function renderName(value, p, record){
        return String.format(
                '<div style="cursor:text" onclick = "document.frmEdit.banner_id.value = \'{1}\'; return !showPopup(\'nameFieldPopup\', event);  " >{0}</div>',
                value, record.data.page_id);
    }

  
    var pagingBar = new Ext.PagingToolbar({
        pageSize: 20,
        store: store,
        displayInfo: true,
        displayMsg: 'Displaying topics {0} - {1} of {2}',
        emptyMsg: "No topics to display"          
    });


    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
        /*width:1135,*/
		width:1140,
        height:500,
        title:'Report Property Sold ',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		 {
            header: "Total Property",
            dataIndex: 'total',
            width: 180, 
			align: 'center',
            sortable: true 
          }, {	 
            header: "House Sold ",
            dataIndex: 'house',
            width: 150, 
			align: 'center',
            sortable: true 
          },{
            header: "Apartment Sold ",
            dataIndex: 'apartment',
            width: 150, 
			align: 'center',
            sortable: true 
          },{
            header: "Land Estate Sold ",
            dataIndex: 'land',
            width: 150, 
			align: 'center',
            sortable: true 
          },{
            header: "Flat Sold ",
            dataIndex: 'flat',
            width: 150, 
			align: 'center',
            sortable: true 
          },{
            header: "Total Property Sold ",
            dataIndex: 'total_sold',
            width: 165, 
			align: 'center',
            sortable: true 
          }],
         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20,property_id :10}});
	//BY GOS:MOHA
	_store = store;
});

 