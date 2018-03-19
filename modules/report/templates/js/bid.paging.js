var store2 = null;
var grid2 = null;
Ext.onReady(function(){
    // create the Data Store
    var store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'property_id',
        remoteSort: true,
        fields: [
            'property_id', 'address', 'suburb', 'postcode', 'state_name', 'country_name', 'num'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link1
        })
    });
    //store.setDefaultSort('property_id', 'DESC'); 
	
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

	function renderAddress(val, i, rec) {
		var str = getAddress(rec);
		if (rec.data.stop_bid == 1) {
			str += '(Bidding stopped)';
		}
		return str;
	}
	
	function renderAction(val, i, rec) {
		var address = getAddress(rec);
		return '<a href="javascript:void(0)" onclick="inspect(\'' + rec.data.property_id + '\',\'' + address + '\')">Inspect</a>';
	}
	
    var grid = new Ext.grid.GridPanel({
        el:'topic-grid1',
        /*width:1135,*/
		width:630,
        height:500,
        title:'Property',
		 
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
		frame:true,
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'property_id',
            width: 50,
			align: 'center',
            sortable: true 
          },				 
		  {
            header: "Address",
            dataIndex: 'address',
            width: 400,
			align: 'left',
            sortable: true ,
			renderer : renderAddress
          },{   
			header: "No.bid",
            dataIndex: 'num',
            width: 70,  
			align: 'center',
			sortable: true 
		  },
		  {   
			header: "Action",
            dataIndex: 'num',
            width: 70,  
			align: 'center',
			sortable: false ,
			renderer : renderAction
		  }],
			plugins:[new Ext.ux.grid.Search({
						iconCls : 'icon-zoom'
						,readonlyIndexes : ['property_id']
						,disableIndexes : ['address', 'suburb', 'postcode', 'state_name', 'country_name', 'num']
						,minChars : 1
						,autoFocus : true
						,position : 'top'
						,checkIndexes : ['property_id']
						,showSelectAll : true
						,width : 250
						,align : 'right'
	
			})]
			,
			tbar: [{}],
		
 			viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },
         
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20, property_id:2}});
});


Ext.onReady(function(){
    // create the Data Store
    store2 = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'i',
        remoteSort: true,
        fields: [
            'agent_id', 'agent_name', 'step', 'price','time','stop_bid'
        ],
        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link2
        })
    });
    //store2.setDefaultSort('agent_id', 'DESC');  
	
    var pagingBar = new Ext.PagingToolbar({
        pageSize: 20,
        store: store2,
        displayInfo: true,
        displayMsg: '{0} - {1} of {2}',
        emptyMsg: "No topics to display"          
    });
	
	function renderName(val, i, rec) {
		if (jQuery.trim(rec.data.agent_name).length == 0) {
			return '<i>Deleted</i>';
		}
		return rec.data.agent_name;
	};
	
    grid2 = new Ext.grid.GridPanel({
        el:'topic-grid2',
		width:500,
        height:500,
        title:'Bid history : All',
        store: store2,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        frame:true,
        // grid columns
        columns:[
         {  header: "ID",
            dataIndex: 'agent_id',
            width: 50,
			align: 'center',
			sortable: true
		  },
		  {  header: "Agent name",
            dataIndex: 'agent_name',
			width: 160,
			align: 'left',
			sortable: true ,
			renderer : renderName
		 },
		 {  header: "Step (AU$)",
            dataIndex: 'step',
            width: 70,
			align: 'center',
			sortable: true
		 },
		 {
			header: "Price (AU$)",
            dataIndex: 'price',
            width: 70,
			align: 'center',
			sortable: true
		 },
		 {
			header: "Time",
            dataIndex: 'time',
            width: 120,
			align: 'center',
			sortable: true
		 }],
 		viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },		
        // paging bar on the bottom
        bbar: pagingBar
    });

    grid2.render();
    store2.load({params:{start:0, limit:20}});
});

function inspect(property_id, address) {
	store2.load({params : {start : 0, limit : 20, property_id : property_id}});
	grid2.setTitle('Bid history : ' + address);
	store2.baseParams['property_id'] = property_id;
}

function getAddress(rec) {
	return rec.data.address + ' ' + rec.data.suburb + ' ' + rec.data.postcode + ' ' + rec.data.state_name + ' ' + rec.data.country_name
}
 