	/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store;
Ext.onReady(function(){

    // create the Data Store
    store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'setting_id',
        remoteSort: true,
        fields: [
            'setting_id',
            'title',
            'setting_value' , 
            'Edit'
        ],
        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list')
        })
    });
    store.setDefaultSort('setting_value', 'ASC');  

  
    function renderStatus(val, i, rec){
        var str = '';
        if (rec.data.status == 1) {
            str = '<a class="grid_default" href = "javascript:void(0)" onclick="outAction(\'change-status\','+rec.data.menu_id+')">Active</a>';
        } else {
            str = '<a class="grid_warn_" href = "javascript:void(0)" onclick="outAction(\'change-status\','+rec.data.menu_id+')">InActive</a>';
        }
        return str;
    }
    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
        width:1135,
        height:500,
        title:'List Configuration Show Banner',
        iconCls: 'grid_icon',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        frame:true,
        // grid columns
        columns:[{
            id: 'setting_id', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID ",
            dataIndex: 'setting_id',
            width: 80, 
			align: 'center',
            sortable: true 
        },{
            header: "Title ",
            dataIndex: 'title',
            width: 500,
            sortable: true			
		},{
            header: "Number Property ",
            dataIndex: 'setting_value',
            width: 150,  
            sortable: true,
			align: 'center'
		},{            
            header: "Edit",
            dataIndex: 'Edit',
            width: 82,
			align: 'center'
		}],
         viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				return (rowIndex % 2 == 0) ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        }


    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:25}});
});
