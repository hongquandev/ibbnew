/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var _store1 = null;
var _store2 = null;
var _store3 = null;
var _store4 = null;

//BEGIN FOR DAILY
Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'page_log_id',
        remoteSort: true,
        fields: [
            'page_log_id', 'title', 'view'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.list_link1
        })
    });
    store.setDefaultSort('view', 'DESC');
	
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
        el:'topic-grid1',
        width:570,
		height:500,
		
        title:'Daily <div style="float:right">'+session.title1+'</div>',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'page_log_id',
            width: 40, 
			align: 'center',
            sortable: true
          },{   
			header: "Page",
            dataIndex: 'title',
            width: 400,  
			align: 'left',
			sortable: true
		  },{   
			header: "View",
            dataIndex: 'view',
            width: 110,  
			align: 'left',
            sortable: true
		  }],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20}});
	//BY GOS:MOHA
	_store1 = store;
});
//END

//BEGIN FOR WEEKLY
Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'page_log_id',
        remoteSort: true,
        fields: [
            'page_log_id', 'title', 'view'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.list_link2
        })
    });
    store.setDefaultSort('view', 'DESC');
	
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
        el:'topic-grid2',
        width:570,
		height:500,
		
        title:'Weekly <div style="float:right">'+session.title2+'</div>',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'page_log_id',
            width: 40, 
			align: 'center',
            sortable: true
          },{   
			header: "Page",
            dataIndex: 'title',
            width: 400,  
			align: 'left',
			sortable: true
		  },{   
			header: "View",
            dataIndex: 'view',
            width: 110,  
			align: 'left',
            sortable: true
		  }],

         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20}});
	//BY GOS:MOHA
	_store2 = store;
});
//END

//BEGIN FOR MONTHLY
Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'page_log_id',
        remoteSort: true,
        fields: [
            'page_log_id', 'title', 'view'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.list_link3
        })
    });
    store.setDefaultSort('view', 'DESC');
	
	// pluggable renders
    function renderName(value, p, record){
        return String.format(
                '<div style="cursor:text" onclick = "document.frmEdit.banner_id.value = \'{1}\'; return !showPopup(\'nameFieldPopup\', event);  " >{0}</div>',
                value, record.data.page_id);
    }

    /*Filter by*/
    var filter_store = new Ext.data.JsonStore({
            root:'data',
            fields:['value','title'],
            method:"POST",
            url:session.option_month
        });
    filter_store.load({params:{start:0, limit:20}});
    var filter = new Ext.form.ComboBox({
        width:110,
        store: filter_store,
        valueField:'value',
        displayField:'title',
        mode:'local',
        hideTrigger:false,
        triggerAction: 'all',
        emptyText:'Filter by...',
        selectOnFocus:false,
        id:'cmbMonthFilter',
        listeners:{
            select:function(combo, value) {
                _store3.reload({params:{start:0, limit:20, time_at:combo.value}});
            }
        }
    });
    /*End*/
  
    var pagingBar = new Ext.PagingToolbar({
        pageSize: 20,
        store: store,
        displayInfo: true,
        displayMsg: 'Displaying topics {0} - {1} of {2}',
        emptyMsg: "No topics to display"          
    });


    var grid = new Ext.grid.GridPanel({
        el:'topic-grid3',
        width:570,
		height:500,
		
        title:'Monthly ',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'page_log_id',
            width: 40, 
			align: 'center',
            sortable: true
          },{   
			header: "Page",
            dataIndex: 'title',
            width: 400,  
			align: 'left',
			sortable: true
		  },{   
			header: "View",
            dataIndex: 'view',
            width: 110,  
			align: 'left',
            sortable: true
		  }],

         
        // paging bar on the bottom
		tbar:['->','Select month :',filter],
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    //store.load({params:{start:0, limit:20}});
    store.on('beforeload', function(store){
	    //store.baseParams = {key: Ext.getCmp('cmbFilter').getValue()};
        store.baseParams['time_at'] = Ext.getCmp('cmbMonthFilter').getValue();
    });
    store.load({params : {start : 0, limit : 20, time_at:Ext.getCmp('cmbMonthFilter').getValue()}});
	
	//BY GOS:MOHA
	_store3 = store;
});
//END

//BEGIN FOR YEARLY
Ext.onReady(function(){

    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'page_log_id',
        remoteSort: true,
        fields: [
            'page_log_id', 'title', 'view'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.list_link4
        })
    });
    store.setDefaultSort('view', 'DESC');  
    /*Filter by*/
    var filter_store = new Ext.data.JsonStore({
            root:'data',
            fields:['value','title'],
            method:"POST",
            url:session.option_year
        });
    filter_store.load({params:{start:0, limit:20}});
    var filter = new Ext.form.ComboBox({
        width:110,
        store: filter_store,
        valueField:'value',
        displayField:'title',
        mode:'local',
        hideTrigger:false,
        triggerAction: 'all',
        emptyText:'Filter by...',
        selectOnFocus:false,
        id:'cmbYearFilter',
        listeners:{
            select:function(combo, value) {
                _store4.reload({params:{start:0, limit:20, time_at:combo.value}});
            }
        }
    });
    /*End*/	
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
        el:'topic-grid4',
        width:570,
		height:500,
		
        title:'Yearly',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'page_log_id',
            width: 40, 
			align: 'center',
            sortable: true
          },{   
			header: "Page",
            dataIndex: 'title',
            width: 400,  
			align: 'left',
			sortable: true
		  },{   
			header: "View",
            dataIndex: 'view',
            width: 110,  
			align: 'left',
            sortable: true
		  }],

         
        // paging bar on the bottom
		tbar:['->','Select year :',filter],
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    //store.load({params:{start:0, limit:20}});
    store.on('beforeload', function(store){
	    //store.baseParams = {key: Ext.getCmp('cmbFilter').getValue()};
        store.baseParams['time_at'] = Ext.getCmp('cmbYearFilter').getValue();
    });
    store.load({params : {start : 0, limit : 20, time_at:Ext.getCmp('cmbYearFilter').getValue()}});
	
	//BY GOS:MOHA
	_store4 = store;
});
//END
 