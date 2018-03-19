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
        idProperty: 'ID',
        remoteSort: true,
        fields: [
            'ID', 'FirstName', 'LastName', 'EmailAddress', 'Telephone', 'Level',  'Status', 'Edit', 'Delete'
			 
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/users/list.php'
        })
    });
    store.setDefaultSort('ID', 'desc'); 

 
    var pagingBar = new Ext.PagingToolbar({
        pageSize: 20,
        store: store,
        displayInfo: true,
        displayMsg: 'Displaying topics {0} - {1} of {2}',
        emptyMsg: "No topics to display"          
    });

    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
        width:778,
        height:500,
        title:'Users [<a href="#" onclick = " document.frmEdit.ID.value = \'\'; return !showPopup(\'nameFieldPopup\', event);  " >Add New</a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            id: 'ID', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'ID',
            width: 50, 
			align: 'center',
            sortable: true
		},{
            header: "Firstname",
            dataIndex: 'FirstName',
            width: 100, 
            sortable: true			
        },{
            header: "Lastename",
            dataIndex: 'LastName',
            width: 100, 
            sortable: true
		 },{
            header: "Telephone",
            dataIndex: 'Telephone',
            width: 100, 
            sortable: true	
		 },{
            header: "Username",
            dataIndex: 'EmailAddress',
            width: 100, 
            sortable: true	
		},{            
            header: "Level",
            dataIndex: 'Level',
            width: 100,  
			align: 'center'	
		},{            
            header: "Status",
            dataIndex: 'Status',
            width: 100,  
			align: 'center'
		},{            
            header: "Edit",
            dataIndex: 'Edit',
            width: 50,  
			align: 'center'
		},{            
            header: "Delete",
            dataIndex: 'Delete',
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



 