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
        idProperty: 'role_id',
        remoteSort: true,
        fields: [
            'role_id', 'title', 'description', 'order', 'active', 'edit_link', 'delete_link'
			 
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-role')
        })
    });
    store.setDefaultSort('role_id', 'desc'); 


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
        el:'topic-grid',
        width:1140,
        height:500,
        title:session.grid_title,
        iconCls: 'grid_icon',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        frame:true,
        // grid columns
        columns:[sm,{
            id: 'ID', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'role_id',
            width: 50, 
			align: 'center',
            sortable: true
		},{
            header: "Title",
            dataIndex: 'title',
            width: 200,
            sortable: true			
        },{
            header: "Description",
            dataIndex: 'description',
            width: 600,
            sortable: true			
        },{
            header: "Order",
            dataIndex: 'order',
            width: 100,
            align:'center',
            sortable: true
		 },{
            header: "Edit",
            dataIndex: 'edit_link',
            width: 50,  
			align: 'center'	
		},{            
            header: "Delete",
            dataIndex: 'delete_link',
            width: 50,  
			align: 'center'
		}],
        sm:sm,
		tbar : [{
					text : 'Add Role',
					icon : '/admin/resources/images/default/dd/drop-add.gif',
					cls : 'x-btn-text-icon',
					handler : function() {
						document.location = session.add_link;
					}
				},'-',
				{
					text : 'Delete Role',
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
								id_ar.push(rows[i].data.role_id);
							}

							if (id_ar.length > 0) {
								outAction('multidelete',id_ar.join(','));
							}
						} else {
							Ext.Msg.alert('Warning.','Please chose one row before deleting.');
						}
					}
				}
		],
       // paging bar on the bottom
        bbar : new Ext.PagingToolbar({
            pageSize : 20,
            store : store,
            displayInfo : true,
            displayMsg : 'Displaying topics {0} - {1} of {2}',
            emptyMsg : "No topics to display",
            plugins : [new Ext.ux.plugin.PagingToolbarResizer( {options : [ 20, 50, 100, 200 ], prependCombo: true})]
        })

    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20}});
});
function ajaxAction(type,val,url) {
	showWaitBox();
	Ext.Ajax.request({
		url : url,
		params : {
			type : type,
			role_id : val
		},
		success : function ( result, request ) {
			hideWaitBox();
			store.reload();
			if (result.responseText && result.responseText.length > 0) {
				Ext.Msg.alert('Warning!', result.responseText);
			}
			
		},
		failure : function( result, request ) {
			alert('f');
			hideWaitBox();
		}
	});
}


 