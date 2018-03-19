/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var _store = null;
Ext.onReady(function(){


   var store = new Ext.data.JsonReader({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'report_id',
        remoteSort: true,
        fields: [
            'state', 'type', 'hightest_price','lowest_price','bed_room', 'bath_room', 'num'
        ]
   });
    //store.setDefaultSort('report_id', 'DESC');

	var store2 = new Ext.data.GroupingStore({
            reader:store,
            groupField:'state',
            sortInfo: {
                field: 'state',
                direction: 'ASC'
            },
            proxy: new Ext.data.HttpProxy({
                url: list_link1
            })
     });
	
    /*Filter by*/
    var filter_store = new Ext.data.SimpleStore({
           fields : ['key', 'title'],
		    data : [
                ['0','All'],
                ['1','Commercial'],
                ['2','Residential'],
        ]
    });

    var filter = new Ext.form.ComboBox({
        width:110,
        store: filter_store,
        valueField:'key',
        displayField:'title',
        mode:'local',
        hideTrigger:false,
        triggerAction: 'all',
        emptyText:'Filter by...',
        selectOnFocus:false,
        id:'cmbFilter',
        listeners:{
            select:function(combo, value) {
                store2.reload({params:{start:0, limit: jQuery('#ext-comp-1016').val(), key:combo.value}});
            }
        }
    });
    /*End*/
	
    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
		width:664,
        height:500,
        title:'Property Report',
        store: store2,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        frame:true,
        // grid columns
        columns:[
         {  header: "State",
            dataIndex: 'state',
            width: 80,
			align: 'left',
			sortable: true
		  },
		 {  header: "Type",
            dataIndex: 'type',
            width: 100,
			align: 'left',
			sortable: true 
		 },{  header: "No.",
            dataIndex: 'num',
            width: 50,
			align: 'right',
			sortable: true
		 },{
			header: "Hightest Price",
            dataIndex: 'hightest_price',
            width: 150,
			align: 'right'
		 },{
			header: "Lowest Price",
            dataIndex: 'lowest_price',
            width: 150,
			align: 'right'
		 },{
			header: "Bed room",
            dataIndex: 'bed_room',
            width: 120,
			align: 'center'
		 },{
			header: "Bath room",
            dataIndex: 'bath_room',
            width: 130,
			align: 'center'
		 }],
		tbar:['->','Filter by',filter],
       
        view: new Ext.grid.GroupingView({
            enableGroupingMenu: false,	// don't show a grouping menu
            enableNoGroups: false,		// don't let the user ungroup
            hideGroupedColumn: true,	// don't show the column that is being used to create the heading
            showGroupName: false,		// don't show the field name with the group heading
            startCollapsed: false,
            forceFit:true
        })
    });

    grid.render();
    store2.load({params:{start:0, limit:20}});
    var hdmenu = grid.getView().hmenu;
        hdmenu.get('asc').hide();
        hdmenu.get('desc').hide();

        //hdmenu.items.removeAt(4);
        //hdmenu.items.removeAt(2);


});

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
            url: list_link2
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
        el:'topic-grid2',
        /*width:1135,*/
		width:223,
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
            width: 112,
			align: 'center',
            sortable: false 
          },{   
			header: "Property number",
            dataIndex: 'num',
            width: 111,  
			align: 'center',
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

 