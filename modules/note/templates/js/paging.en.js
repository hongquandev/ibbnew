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
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'note_id',
        remoteSort: true,
        fields: [
            'note_id',
			'to',
			'link_to',
			'content',
			'author',
			'time',
			'type',
			'active',
			'property_id',
			'edit_link', 
			'delete_link'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-' + session.action_type)
        })
    });
    store.setDefaultSort('note_id', 'desc'); 

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
	
	function renderContent(val,i,rec) {
		return '<b>Note to : <a class="grid_title" href="' + rec.data.link_to + '">'  + rec.data.to + '</a></b>';
	}
	
	function renderAuthor(val,i,rec) {
		return '<a class = "grid_blue" href = "">' + val + '</a>';
	}
	
    var grid = new Ext.grid.GridPanel({
        renderTo : 'topic-grid',
        width : 1140,
        height : 500,
        title : 'Note List',
		iconCls : 'grid_icon',
        store : store,
        trackMouseOver : false,
        disableSelection : true,
        loadMask : true, 
		frame : true,
        // grid columns
        columns:[
		sm,		 
		{
            id: 'ID', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'note_id',
            width: 50, 
			align: 'center',
            sortable: true
		},{
            header: "Content",
            dataIndex: 'content',
            width: 650, 
			renderer : renderContent,
            sortable: true			
        },{
            header: "Author",
            dataIndex: 'author',
            width: 150, 
			align: 'left',
			renderer : renderAuthor,
            sortable: true			
        },{
            header: "Author type",
            dataIndex: 'type',
            width: 100, 
			align: 'left',
            sortable: true			
        }],
		sm : sm,
        viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				var str = '<p class="grid_expand1" style="margin-left:75px;margin-top:10px">';
				str += rec.data.content + '<br/>';
				str += '<i>Created at : ' + rec.data.time + '</i><br/>';
				str += '</p>';
				
				str += '<p class="grid_expand2" style="margin-left:75px">';
				if (rec.data.active == 1) {
					str += '<a href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.note_id+')">Approved</a>';
				} else {
					str += '<a class="grid_warn" href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.note_id+')">Pending</a>';
				}
				str += '<span>|</span>';
				//str += '<a href = "" >Edit</a>';
				//str += '<span>|</span>';
				str += '<a href = "javascript:void(0)" onclick="outAction(\'delete\','+rec.data.note_id+')">Delete</a>';
				
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
							,disableIndexes : ['created_date','type']
							,minChars : 3
							,autoFocus : true
							,position : 'top'
							,checkIndexes : ['note_id','content','author']
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
								id_ar.push(rows[i].data.note_id);
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
			note_id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			//var resultMessage = jsonData.data.result;
			hideWaitBox();
			store.reload();
			if (result.responseText && result.responseText.length > 0) {
				Ext.Msg.show({
                    title:'Warning !'
                    ,msg:result.responseText
                    ,icon:Ext.Msg.WARNING
                    ,buttons:Ext.Msg.OK

	            });
			}
		},
		failure : function( result, request ) {
			hideWaitBox();
		}
	});		
} 

 