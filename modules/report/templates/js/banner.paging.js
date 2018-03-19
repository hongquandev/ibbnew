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
        idProperty: 'report_id',
        remoteSort: true,
        fields: [
            'state', 'type', 'hightest_price','lowest_price','bed_room', 'bath_room'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link1
        })
    });
    store.setDefaultSort('report_id', 'DESC');  
	
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
		/*width:1140,*/
		width:840,
        height:500,
        title:'Property Report <div style="float:right">Select Country : '+select_box+'</div>',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {   
			header: "State",
            dataIndex: 'state',
            width: 290,  
			align: 'left',
			sortable: true 
		  },{   
			header: "Type",
            dataIndex: 'type',
            width: 100,  
			align: 'left',
			sortable: true 
		  },{   
			header: "Hightest Price",
            dataIndex: 'hightest_price',
            width: 100,  
			align: 'right'	
		  },{   
			header: "Lowest Price",
            dataIndex: 'lowest_price',
            width: 100,  
			align: 'right'	
		  },{   
			header: "Bed room",
            dataIndex: 'bed_room',
            width: 100,  
			align: 'center'	
		  },{   
			header: "Bath room",
            dataIndex: 'bath_room',
            width: 100,  
			align: 'center',
			sortable: true 
		  }],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20}});
	//BY GOS:MOHA
	_store = store;
});

//BEGIN FOR TIME
/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'time',
        remoteSort: true,
        fields: [
            'time', 'num'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link2
        })
    });
    store.setDefaultSort('time', 'DESC');  
	
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
        displayMsg: '{0} - {1} of {2}',
        emptyMsg: "No topics to display"          
    });


    var grid = new Ext.grid.GridPanel({
        el:'topic-grid2',
        /*width:1135,*/
		width:300,
        height:500,
        title:'Property Report By Time',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "Time (Year-Month)",
            dataIndex: 'time',
            width: 195, 
			align: 'left',
            sortable: false 
          },{   
			header: "Property number",
            dataIndex: 'num',
            width: 100,  
			align: 'left',
			sortable: false 
		  }],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20}});
});

 