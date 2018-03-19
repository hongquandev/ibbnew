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
        idProperty: 'tab_id',
        remoteSort: true,
        fields: [
            'tab_id', 'title','uri', 'order', 'parent',  'active_link', 'edit_link', 'delete_link'
			 
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link
        })
    });
    store.setDefaultSort('tab_id', 'desc'); 

 
    var pagingBar = new Ext.PagingToolbar({
        pageSize: 20,
        store: store,
        displayInfo: true,
        displayMsg: 'Displaying topics {0} - {1} of {2}',
        emptyMsg: "No topics to display"          
    });

    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
        width:1140,
        height:500,
        title:'Tabs [<a href="'+add_link+'" >Add Tab</a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            id: 'ID', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'tab_id',
            width: 50, 
			align: 'center',
            sortable: true
		},{
            header: "Title",
            dataIndex: 'title',
            width: 350, 
            sortable: true			
        },{
            header: "Route",
            dataIndex: 'uri',
            width: 300, 
            sortable: true			
        },{
            header: "Order",
            dataIndex: 'order',
            width: 50, 
            sortable: true
		 },{
            header: "Parent",
            dataIndex: 'parent',
            width: 200, 
            sortable: true	
		 },{
            header: "Status",
            dataIndex: 'active_link',
            width: 70, 
            sortable: true	
		},{            
            header: "Edit",
            dataIndex: 'edit_link',
            width: 50,  
			align: 'center'	
		},{            
            header: "Delete",
            dataIndex: 'delete_link',
            width: 50,  
			align: 'center'
		}],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20}});
	_store = store;
});



 