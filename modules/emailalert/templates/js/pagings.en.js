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
        idProperty: 'email_id',
        remoteSort: true,
        fields: [
            'email_id', 'address', 'auction_name', 'type_name', 'end_time' , 'bedroom_name', 'bathroom_name', 'land_size_name', 'car_space_name', 'car_port_name', 'agent_fullname' , 'active', 'Delete'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link
        })
    });
    store.setDefaultSort('email_id', 'ASC');  
	
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
		width:1140,
        height:500,
        title:'List Agent Register Email Alert',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'email_id',
            width: 50, 
			align: 'center',
            sortable: true 
          },{   
			header: "Type",
            dataIndex: 'type_name',
            width: 80,  
			align: 'left',
			sortable: true 
		  },{   
			header: "Suburb - State - Country",
            dataIndex: 'address',
            width: 400,  
			align: 'left'	
		  },{   
			header: "Bed",
            dataIndex: 'bedroom_name',
            width: 60,  
			align: 'left',
			sortable: true 
		  },{   
			header: "Bath",
            dataIndex: 'bathroom_name',
            width: 60,  
			align: 'left',
			sortable: true 
		  },{   
			header: "Land size",
            dataIndex: 'land_size_name',
            width: 70,  
			align: 'left',
			sortable: true 
		  },{   
			header: "Garage",
            dataIndex: 'car_space_name',
            width: 60,  
			align: 'left',	
		 	sortable: true 
		  },{   
			header: "Agent Name",
            dataIndex: 'agent_fullname',
            width: 100,  
			align: 'left'
		 },{   
			header: "Date Register",
            dataIndex: 'end_time',
            width: 115,  
			align: 'left'
		 },{   
			header: "Status",
            dataIndex: 'active',
            width: 70,  
			align: 'center',
			sortable: true 
		 },{            
            header: "Delete",
            dataIndex: 'Delete',
            width: 65,  
			align: 'center'
		 	
        }],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20,email_id :10}});
	//BY GOS:MOHA
	_store = store;
});

 