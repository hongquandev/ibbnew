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
            'agent_id', 'firstname', 'lastname', 'email_address', 'telephone', 'country_name', 'suburb_name','update_time',  'is_active', 'Edit', 'Delete'
			 
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/users/list.php'
        })
    });
    store.setDefaultSort('agent_id', 'asc'); 

 
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
        title:'Users [<a href="?module=users&action=adduser">Add New </a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            id: 'agent_id', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'agent_id',
            width: 50, 
			align: 'center',
            sortable: true
		},{
            header: "First Name",
            dataIndex: 'firstname',
			align: 'center',
            width: 122, 
            sortable: true			
        },{
            header: "Last Name",
            dataIndex: 'lastname',
			align: 'center',
            width: 130, 
            sortable: true
		 },{
            header: "Email",
            dataIndex: 'email_address',
			align: 'center',
            width: 150, 
            sortable: true	
		},{
            header: "Telephone",
            dataIndex: 'telephone',
			align: 'center',
            width: 130, 
            sortable: true	
		 },{            
            header: "Country",
            dataIndex: 'country_name',
			align: 'center',
            width: 90,  
			align: 'center'
		},{            
            header: "State",
            dataIndex: 'suburb_name',
			align: 'center',
            width: 155,  
			align: 'center'
		},{            
            header: "Updated",
            dataIndex: 'update_time',
			align: 'center',
            width: 115,  
			align: 'center'
		},{            
            header: "Status",
            dataIndex: 'is_active',
			align: 'center',
            width: 70,  
			align: 'center'
		},{            
            header: "Edit",
            dataIndex: 'Edit',
			align: 'center',
            width: 50,  
			align: 'center'
		},{            
            header: "Delete",
            dataIndex: 'Delete',
			align: 'center',
            width: 50,  
			align: 'center'
		 	
        }],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:25}});
});



 