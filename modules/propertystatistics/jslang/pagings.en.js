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
        idProperty: 'property_id',
        remoteSort: true,
        fields: [
            'property_id', 'views', 'address', 'auction_name', 'type_name', 'postcode', 'region_name' , 'price_name' , 'agent_fullname' , 'Edit', 'Delete'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/propertystatistics/showlists.php'
        })
    });
    store.setDefaultSort('property_id', 'ASC');  
	
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
        title:'List View Property [<a  href="#"  onclick="return wow(\'../modules/propertystatistics/chart.php\',700,1200)" > Analyze Chart Reports </a>]',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[{
            header: "ID",
            dataIndex: 'property_id',
            width: 70, 
			align: 'center',
            sortable: true 
          },{   
			header: "Auction Sale",
            dataIndex: 'auction_name',
            width: 100,  
			align: 'center',
			sortable: true 
		  },{   
			header: "Type",
            dataIndex: 'type_name',
            width: 100,  
			align: 'center',
			sortable: true 	
		  },{   
			header: "Address",
            dataIndex: 'address',
            width: 150,  
			align: 'center',
		    sortable: true 	
		  },{   
			header: "Post Code",
            dataIndex: 'postcode',
            width: 80,  
			align: 'center',
			sortable: true 
		  },{   
			header: "Country",
            dataIndex: 'region_name',
            width: 100,  
			align: 'center',
			sortable: true 
		  },{   
			header: "Price Range",
            dataIndex: 'price_name',
            width: 140,  
			align: 'center',
		    sortable: true 	
		  },{   
			header: "Agent Name",
            dataIndex: 'agent_fullname',
            width: 130,  
			align: 'center',
			sortable: true 
		  },{   
			header: "View Number",
            dataIndex: 'views',
            width: 80,  
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



 