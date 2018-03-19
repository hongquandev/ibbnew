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
        idProperty: 'page_id',
        remoteSort: true,
        fields: [
            'page_id', 'title', 'content', 'creation_time' , 'update_time', 'is_active' , 'sort_order' , 'Edit', 'Delete'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/cms/showlists.php'
        })
    });
    store.setDefaultSort('page_id', 'ASC');  
	
	// pluggable renders
    function renderName(value, p, record){
        return String.format(
                '<div style="cursor:text" onclick = "document.frmEdit.page_id.value = \'{1}\'; return !showPopup(\'nameFieldPopup\', event);  " >{0}</div>',
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
        title:'List Page [<a href="?module=cms&action=addpage">Add Page </a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            id: 'page_id', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID ",
            dataIndex: 'page_id',
            width: 60, 
			align: 'center',
            sortable: true 
        },{
            header: "Title ",
            dataIndex: 'title',
            width: 200,  
            sortable: true			
		},{
            header: "Content ",
            dataIndex: 'content',
            width: 380,  
            sortable: true 
		},{
            header: "Creation Time ",
            dataIndex: 'creation_time',
            width: 120,  
            sortable: true 			
		},{
            header: "Update Time ",
            dataIndex: 'update_time',
            width: 120,  
            sortable: true 			
		},{
            header: "Status ",
            dataIndex: 'is_active',
			align: 'center',
            width: 100,  
            sortable: true 			
		},{
            header: "Position",
            dataIndex: 'sort_order',
			align: 'center',
            width: 50,  
            sortable: true 			
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



 