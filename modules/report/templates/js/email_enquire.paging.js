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
        idProperty: 'message_id',
        remoteSort: true,
        fields: [
            'message_id', 'title', 'sender', 'receiver','sent_date','show'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link
        })
    });
    store.setDefaultSort('message_id', 'DESC');  
	
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
		
        title:'Email Enquire',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'message_id',
            width: 40, 
			align: 'center',
            sortable: true 
          },{   
			header: "Title",
            dataIndex: 'title',
            width: 500,  
			align: 'left',
			sortable: true 
		  },{   
			header: "Sender",
            dataIndex: 'sender',
            width: 200,  
			align: 'left'
		  },{   
			header: "Receiver",
            dataIndex: 'receiver',
            width: 200,  
			align: 'left'	
		  },{   
			header: "Sent date",
            dataIndex: 'sent_date',
            width: 100,  
			align: 'left'	
		  },{   
			header: "Action",
            dataIndex: 'show',
            width: 50,  
			align: 'left'	
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

 