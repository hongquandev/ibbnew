//BEGIN FOR TIME
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
        idProperty: 'time',
        remoteSort: true,
        fields: [
            'time', 'num'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link
        })
    });
    store.setDefaultSort('time', 'DESC');  
	
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
        displayMsg: '{0} - {1} of {2}',
        emptyMsg: "No topics to display"          
    });


    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
        /*width:1135,*/
		width:300,
        height:500,
        title:'Property Report By Time',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "Time (Year-Month)",
            dataIndex: 'time',
            width: 195, 
			align: 'left',
            sortable: false 
          },{   
			header: "Property number",
            dataIndex: 'num',
            width: 100,  
			align: 'left',
			sortable: false 
		  }],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20}});
});

 