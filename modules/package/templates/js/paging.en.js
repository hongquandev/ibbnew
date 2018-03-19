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
        id : 'package_id',
        remoteSort : true,
        fields : [
            'package_id',
			'name',
			'is_active',
			'color',
			'order',
            'edit_link',
            'delete_link'
        ],
        limit : 'limit',

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy : new Ext.data.HttpProxy({
            url : session.action_link.replace('[1]','action=list-' + session.action_type)
        })
    });
	
    store.setDefaultSort('package_id', 'DESC');

	function renderTitle(val,i,rec) {
		var str = '<b style="white-space:normal">'+val+'</b>';
		return str;
	}

    function renderStatus(val, i, rec){
        var str = '';
        if (rec.data.is_active == 1) {
            str = '<a class="grid_default" href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.package_id+')">Active</a>';
        } else {
            str = '<a class="grid_warn_" href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.package_id+')">InActive</a>';
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
					Ext.getCmp('btnChange').enable();
					var l = sm.getCount();
					var s = l != 1 ? 's' : '';
					grid.setTitle(session.grid_title + ' <i>('+l+' item'+s+' selected)</i>');
                } else {
                    grid.removeButton.disable();
                    Ext.getCmp('btnChange').disable();
					grid.setTitle(session.grid_title);
                }
            }
        }
	});

	var grid = new Ext.grid.EditorGridPanel({
        renderTo : 'topic-grid',
        /*width:1135,*/
		width : 1140,
        height : 540,
        title : session.grid_title ,
		iconCls: 'grid_icon',
		frame : true,
        store : store,
        trackMouseOver : false,
        //disableSelection : true,
        loadMask : true,
		clickstoEdit: 1,
        id:"grid",
        // grid columns
        columns :[
			sm,		  
		  {
            header : "ID",
            dataIndex : 'package_id',
            width : 40, 
			align : 'center',
            sortable : true 
          },{
			header : "Title",
            dataIndex : 'name',
            width : 490,
			align : 'left',
			renderer : renderTitle
		  },{
            header: "Status",
            dataIndex: 'is_active',
            width: 70,
			align: 'left',
            renderer: renderStatus
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
		sm: sm,
        viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },
		
		plugins:[new Ext.ux.grid.Search({
					iconCls : 'icon-zoom'
					,readonlyIndexes : ['note']
					,disableIndexes : ['edit_link','is_active','delete_link']
					,minChars : 3
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['package_id','name']
					,showSelectAll : true
					,width : 250
					,align : 'right'

				})]
		,
		tbar : [{
					text : 'Add Package',
					icon : '/admin/resources/images/default/dd/drop-add.gif',
					handler : function() {
						document.location = session.add_link;
					}
				},'-',
				{
					text : 'Delete Package',
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
								id_ar.push(rows[i].data.package_id);
							}

							if (id_ar.length > 0) {
								outAction('multidelete',id_ar.join(','));
							}
						} else {
							Ext.Msg.alert('Warning.','Please chose one row before deleting.');
						}
					}
				},'-',
				{
					text : 'Change Status',
					icon : '/admin/resources/images/default/dd/drop-yes.gif',
                    tooltip: 'Change status the selected packages',
					cls : 'x-btn-text-icon',
					disabled: true,
                    id:'btnChange',
                    //ref: '../changeButton',
					handler : function() {
						var sm = grid.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
                            //Ext.getCmp('btnChange').disable();
							var id_ar = [];
							var rows = sm.getSelections();
							for (i = 0; i < rows.length; i++){
								id_ar.push(rows[i].data.package_id);
							}

							if (id_ar.length > 0) {
								outAction('multiactive',id_ar.join(','));
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
            displayMsg : 'Total topics <div style="display: none;">{0} - {1} </div> {2}',
            emptyMsg : "No topics to display",
            plugins : [new Ext.ux.plugin.PagingToolbarResizer( {options : [ 20, 50, 100, 200 ], prependCombo: true})]
        })

    });
    // render i

    grid.render();
    store.load({params:{start:0, limit:20}});
});


/**
@ function : outAction
@ type : focus, set_jump, active, agent_active, delete, multidelete
**/


function ajaxAction(type,val,url) {
	showWaitBox()
	Ext.Ajax.request({
		url : url,
		params : {
			type : type,
			package_id : val
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




