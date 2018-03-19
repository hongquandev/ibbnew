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
        idProperty: 'user_id',
        remoteSort: true,
        fields: [
            'user_id', 'fullname', 'username', 'email','role', 'active', 'edit_link', 'delete_link'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-user')
        })
    });
    store.setDefaultSort('user_id', 'desc'); 

 
     function renderStatus(val, i, rec){
        var str = '';
        if (rec.data.active == 1) {
            str = '<a class="grid_default" href = "javascript:void(0)" onclick="outAction(\'change_status\','+rec.data.user_id+')">Active</a>';
        } else {
            str = '<a class="grid_warn_" href = "javascript:void(0)" onclick="outAction(\'change_status\','+rec.data.user_id+')">InActive</a>';
        }
        return str;
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
        el:'topic-grid',
        width:1140,
        height:500,
        title:session.grid_title,
        store: store,
        iconCls: 'grid_icon',
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        frame:true,
        // grid columns
        columns:[sm,{

            header: "ID",
            dataIndex: 'user_id',
            width: 50, 
			align: 'center',
            sortable: true
		},{
            header: "Full name",
            dataIndex: 'fullname',
            width: 300, 
            sortable: true			
        },{
            header: "Username",
            dataIndex: 'username',
            width: 200, 
            sortable: true			
        },{
            header: "Email",
            dataIndex: 'email',
            width: 212,
            sortable: true
		 },{
            header: "Role",
            dataIndex: 'role',
            width: 150, 
            sortable: true
		 },{
            header: "Status",
            dataIndex: 'active',
            width: 100,
            sortable: true,
            align:'center',
            renderer:renderStatus
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
        viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },
        sm:sm,
        plugins:[new Ext.ux.grid.Search({
					iconCls : 'icon-zoom'
					,readonlyIndexes : ['note']
					,disableIndexes : ['active','delete_link','edit_link']
					,minChars : 3
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['user_id','full_name','username','email','role']
					,showSelectAll : true
					,width : 250
					,align : 'right'

				})]
		,
		tbar : [{
					text : 'Add User',
					icon : '/admin/resources/images/default/dd/drop-add.gif',
					cls : 'x-btn-text-icon',
					handler : function() {
						document.location = session.add_link;
					}
				},'-',
				{
					text : 'Delete User',
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
								id_ar.push(rows[i].data.user_id);
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
			user_id : val
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



 