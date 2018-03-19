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
        idProperty: 'role_id',
        remoteSort: true,
        fields: [
            'role_id', 'title', 'description', 'order', 'active', 'edit_link', 'delete_link'
			 
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/role/action.admin.php?action=list-role-admin'
        })
    });
    store.setDefaultSort('role_id', 'desc'); 

 
    var pagingBar = new Ext.PagingToolbar({
        pageSize: 20,
        store: store,
        displayInfo: true,
        displayMsg: 'Displaying topics {0} - {1} of {2}',
        emptyMsg: "No topics to display"          
    });

    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
        width:1215,
        height:500,
        title:'Roles [<a href="?module=role&action=add" >Add Role</a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            id: 'ID', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'role_id',
            width: 50, 
			align: 'center',
            sortable: true
		},{
            header: "Title",
            dataIndex: 'title',
            width: 300, 
            sortable: true			
        },{
            header: "Description",
            dataIndex: 'description',
            width: 580, 
            sortable: true			
        },{
            header: "Order",
            dataIndex: 'order',
            width: 100, 
            sortable: true
		 },{
            header: "Status",
            dataIndex: 'active',
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
});



 