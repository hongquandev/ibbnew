	/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store = null;
Ext.onReady(function(){

    // create the Data Store
    store = new Ext.data.JsonStore({
 		root : 'topics',
        totalProperty : 'totalCount',
        idProperty : 'comment_id',
        remoteSort : true,
        fields : [
            'comment_id',
			'title',
			'content',
			'property_id', 
			'name', 
			'email', 
			'created_date', 
			'active',
			'agent_id',
			'goto_property'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-' + session.action_type)
        })
    });
    store.setDefaultSort('comment_id', 'DESC');
	
	function renderTitle(val,i,rec) {
		return '<b><font class="grid_title">' + val + '</font></b>';
	}

	function renderDelete(val,i,rec) {
		return '<a href = "javascript:void(0)" onclick="outAction(\'delete\','+rec.data.comment_id+')"><img src = "resources/images/default/dd/delete.png"></a>';
	}


	var sm = new Ext.grid.CheckboxSelectionModel({
		listeners: {
            // On selection change, set enabled state of the removeButton
            // which was placed into the GridPanel using the ref config
            selectionchange: function(sm) {
                if (sm.getCount()) {
                    grid.removeButton.enable();
					
					var l = sm.getCount();
					var s = l != 1 ? 's' : '';
					grid.setTitle(session.grid_title + ' <i>('+l+' item'+s+' selected)</i>');
                } else {
                    grid.removeButton.disable();
					grid.setTitle(session.grid_title);
                }
            }
        }												 
	});

    var grid = new Ext.grid.GridPanel({
        renderTo : 'topic-grid',
        /*width:1135,*/
		width : 1140,
        height : 500,
        title : 'Comment List',
		iconCls: 'grid_icon',
		rowHeight : 19, 
        store : store,
        trackMouseOver : false,
        loadMask : true, 
		frame : true,
		clickstoEdit: 0,
        // grid columns
        columns:[
			sm,
		  {
            header : "ID",
            dataIndex : 'comment_id',
            width : 40, 
			align : 'center',
            sortable : true 
          },{   
			header : "Comment",
            dataIndex : 'title',
            width : 500,  
			align : 'left',
			renderer: renderTitle,
			sortable : true 
		  },{   
			header : "Time post",
            dataIndex : 'created_date',
            width : 120,  
			align : 'left',
			sortable : true 
		  },{   
			header : "Author email",
            dataIndex : 'email',
            width : 200,
			height :200,
			align : 'left',
			sortable : true 
		  }],
		sm : sm,
        viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				var str = '<p class="grid_expand1" style="margin-left:75px;margin-top:10px">';
				str += rec.data.content + '<br/>';
				str += '<i>(Author : '+rec.data.name + ')</i>';
				str += '</p>';
				
				str += '<p class="grid_expand2" style="margin-left:75px">';
				
				if (rec.data.agent_id > 0) {
					str += '<a href = "?module=agent&action=edit&agent_id='+rec.data.agent_id+'&token='+session.token+'" >Go to Customer (#'+rec.data.agent_id+')</a>';
					str += '<span>|</span>';
				}
				
				if (rec.data.goto_property == true) {
					str += '<a href = "?module=property&action=edit&property_id='+rec.data.property_id+'&token='+session.token+'" >Go to Property (#'+rec.data.property_id+')</a>';
					str += '<span>|</span>';
				}
				
				if (rec.data.active == 1) {
					str += '<a href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.comment_id+')">Approved</a>';
				} else {
					str += '<a class="grid_warn" href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.comment_id+')">Pending</a>';
				}
				str += '<span>|</span>';
				
				str += '<a href = "javascript:void(0)" onclick="outAction(\'delete\','+rec.data.comment_id+')">Delete</a>';
				str += '</p>';
				
				p.body = str;
				if (rec.data.stop_bid == 1) {
					return 'x-grid3-row-expanded-warning';
				}
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },		
		plugins:[new Ext.ux.grid.Search({
							iconCls : 'icon-zoom'
							,readonlyIndexes : ['note']
							,disableIndexes : ['created_date']
							,minChars : 3
							,autoFocus : true
							,position : 'top'
							,checkIndexes : ['comment_id','title']
							,showSelectAll : true
							,width : 250
							,align : 'right'

				})]
		,
		tbar : [{
					text : 'Delete Comment',
					icon : '/admin/resources/images/default/dd/delete.png',
					cls : 'x-btn-text-icon',
					ref: '../removeButton',
					disabled: true,					
					handler : function() {
						var sm = grid.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							var id_ar = [];
							var rows = sm.getSelections();
							for (i = 0; i < rows.length; i++){
								id_ar.push(rows[i].data.comment_id);
							}
							
							if (id_ar.length > 0) {
								outAction('multidelete',id_ar.join(','));
							}
						} else {
							Ext.Msg.alert('Warning.','Please chose one row before deleting.');	
						}
					}			
				}],
        // paging bar on the bottom
        bbar: new Ext.PagingToolbar({
            pageSize: 20,
            store: store,
            displayInfo: true,
            displayMsg: 'Displaying topics {0} - {1} of {2}',
            emptyMsg: "No topics to display",
            plugins : [new Ext.ux.plugin.PagingToolbarResizer( {options : [ 20, 50, 100, 200 ], prependCombo: true})]
        })
    });

    // render it
    grid.render();
    // trigger the data store load
    store.load({params:{start:0, limit:20}});
});



function ajaxAction(type,val,url) {
	showWaitBox()
	Ext.Ajax.request({
		url : url,
		params : {
			type : type,
			comment_id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			//var resultMessage = jsonData.data.result;
			hideWaitBox();
			store.reload();
			if (result.responseText && result.responseText.length > 0) {
				Ext.Msg.alert('Warning!', result.responseText);
			}
		},
		failure : function( result, request ) {
			hideWaitBox();
		}
	});		
} 