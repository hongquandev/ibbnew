	/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
 
var store_pagereport = null;
Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'page_id',
        remoteSort: true,
        fields: [
            'title', 'views' , 'dateviews', 'search'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: '../modules/pagestatistics/showlists.php'
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
       	title: 'List View Page [<a  href="#"  onclick="return wow(\'../modules/pagestatistics/chart.php\',600,1100)" > Analyze Chart Reports </a>]',
	 	//title: '[<a href="?module=pagestatistics&action=test">Test </a>]',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 

        // grid columns
        columns:[{
            header: "Title ",
            dataIndex: 'title',
            width: 540,  
            sortable: true			
		},{
            header: "Views Number ",
            dataIndex: 'views',
            width: 150,  
			align: 'center',
            sortable: true 			
		},{
            header: " Last Date Views ",
            dataIndex: 'dateviews',
            width: 200,  
			align: 'center',
            sortable: true 			
		},{
            header: "Search Date ",
            dataIndex: 'search',
            width: 100,  
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
	store_pagereport = store;
});



 