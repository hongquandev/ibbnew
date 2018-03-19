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
        idProperty: 'type_id',
        remoteSort: true,
        fields: [
            'type_id', 'agent_type', 'total', 'note_email','note_sms','active', 'inactive'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link
        })
    });
    store.setDefaultSort('type_id', 'DESC');  
	
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
        title:'Client Report',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'type_id',
            width: 40, 
			align: 'center',
            sortable: true 
          },{   
			header: "Member Type",
            dataIndex: 'agent_type',
            width: 290,  
			align: 'left',
			sortable: true 
		  },{   
			header: "Total",
            dataIndex: 'total',
            width: 100,  
			align: 'center',
			sortable: true 
		  },{   
			header: "No.email",
            dataIndex: 'note_email',
            width: 100,  
			align: 'center'	
		  },{   
			header: "No.sms",
            dataIndex: 'note_sms',
            width: 100,  
			align: 'center'	
		  },{   
			header: "Active",
            dataIndex: 'active',
            width: 100,  
			align: 'center'	
		  },{   
			header: "InActive",
            dataIndex: 'inactive',
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
    store.load({params:{start:0, limit:20,property_id :10}});
	//BY GOS:MOHA
	_store = store;
});

//BEGIN FOR TIME
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
        title:'Client Report By Time',
		 
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
			header: "Client number",
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

 