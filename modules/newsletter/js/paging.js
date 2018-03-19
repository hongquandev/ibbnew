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
        idProperty: 'ID',
        remoteSort: true,
        fields: [
            'ID', 'EmailAddress', 'Source', 'Updated', 'Edit', 'Delete','real_id'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list')
        })
    });
    store.setDefaultSort('ID', 'desc');
    
	// pluggable renders
    function renderName(value, p, record){
        if (record.data.real_id.indexOf('lt') >= 0){
            return String.format(
                '<div style="cursor:text" onclick="$(\'#ID\').val(\'{1}\');$(\'#EmailAddress\').val(\'{0}\');Common.warningObject(\'#EmailAddress\',true);return !showPopup(\'nameFieldPopup\', event);">{0}</div>',
                value, record.data.ID);
        }else{
            return '<div>'+value+'</div>';
        }

    }

    var sm = new Ext.grid.CheckboxSelectionModel({
		listeners: {
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
        el:'vu-grid',
        width:1135,
        height:500,
        title:session.grid_title,
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        frame:true,
        // grid columns
        columns:[sm,
            {
            header: "ID",
            dataIndex: 'ID',
            width: 70, 
			align: 'center',
            sortable: true
        },{
            header: "Email Address",
            dataIndex: 'EmailAddress',
            width: 380,
			renderer: renderName,
            sortable: true
		},{
            header: "Source",
            dataIndex: 'Source',
            width: 310,
            //sortable: true,
            align:'center'
		},{
            header: "Updated",
            dataIndex: 'Updated',
            width: 230,
            //sortable: true,
            align:'center'
		},{            
            header: "Edit",
            dataIndex: 'Edit',
            width: 100,
			align: 'center'
		},{            
            header: "Delete",
            dataIndex: 'Delete',
            width: 100,  
			align: 'center'
		 	
        }],
        sm:sm,
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
					,disableIndexes : ['Delete','Edit','Updated']
					,minChars : 3
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['ID','EmailAddress','Source']
					,showSelectAll : true
					,width : 250
					,align : 'right'

				})]
		,
        tbar : [{
					text : 'Delete Emails',
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
								id_ar.push(rows[i].data.real_id);
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

    grid.render();
    store.load({params:{start:0, limit:20}});
});
    function ajaxAction(type,val,url) {
        showWaitBox();
        Ext.Ajax.request({
            url : url,
            params : {
                type : type,
                ID : val
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





 