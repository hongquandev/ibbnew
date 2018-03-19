	/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store_faq = null;
Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'faq_id',
        remoteSort: true,
        fields: [
            'faq_id', 'title', 'create_date' , 'update_date' , 'active' , 'description', 'Edit', 'Delete'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/faq/action.admin.php'
        })
    });
    store.setDefaultSort('faq_id', 'DESC');  
	
	// pluggable renders
    function renderName(value, p, record){
        return String.format(
                '<div style="cursor:text" onclick = "document.frmEdit.page_id.value = \'{1}\'; return !showPopup(\'nameFieldPopup\', event);  " >{0}</div>',
                value, record.data.faq_id);
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
        title:'List Faq [<a href="?module=faq&action=add">Add Faq </a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            id: 'faq_id', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID ",
            dataIndex: 'faq_id',
            width: 80, 
			align: 'center',
            sortable: true 
        },{
            header: "Title ",
            dataIndex: 'title',
            width: 422,  
            sortable: true			
		},{
            header: "Description",
            dataIndex: 'description',
            width: 250,  
            sortable: true			
		},{
            header: "Creation Time ",
            dataIndex: 'create_date',
            width: 100,  
            sortable: true 			
		},{
            header: "Update Time ",
            dataIndex: 'update_date',
            width: 100,  
            sortable: true 			
		},{
            header: "Status ",
            dataIndex: 'active',
            width: 70,  
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
	store_faq = store;
});



 