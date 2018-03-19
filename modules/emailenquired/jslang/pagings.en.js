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
        idProperty: 'agent_id',
        remoteSort: true,
        fields: [
            'agent_id', 'email', 'sms', 'turnon'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/emailenquired/showlists.php'
        })
    });
	
	  store.setDefaultSort('agent_id', 'ASC');  
	
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
        width:1135,
        height:500,
       title:'List Notification Enquired ',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[     
       {
            header: "Notification Email Address",
            dataIndex: 'email',
			align: 'center',
            width: 300, 
            sortable: true			
        },{                     		
			header: "Notification SMS Number",
            dataIndex: 'sms',
            width: 300,  
			align: 'center',
			sortable: true		
		},{
            header: "Turn On SMS Notification ",
            dataIndex: 'turnon',
            width: 300,  
			align: 'center',
            sortable: true			
        }],
		
        // paging bar on the bottom
        bbar: pagingBar
		
    });
    // render it
    grid.render();
    // trigger the data store load
    store.load({params:{start:0, limit:25}});
});



 