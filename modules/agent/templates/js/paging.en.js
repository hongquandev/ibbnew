/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store = null;
Ext.onReady(function(){
     Ext.QuickTips.init();
    // create the Data Store
    store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'agent_id',
        remoteSort: true,
        fields: [
            'agent_id',
            'full_name',
            'email_address',
            'mobilephone',
            'telephone',
            'address',
            'type',
            'type_name',
            'instance',
            'is_active',
            'edit_link',
            'delete_link',
            'parent_id',
            'parent_name',
            'creation_time',
            'activated_by'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        /*proxy: new Ext.data.HttpProxy({
            url: list_link
        })*/
         // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy : new Ext.data.HttpProxy({
            url : session.action_link.replace('[1]','action=list-' + session.action_type)
        })
    });
    store.setDefaultSort('agent_id', 'desc'); 

    /*Filter by*/
    var filter_store = new Ext.data.JsonStore({
            root:'data',
            fields:['value','title'],
            method:"POST",
            url:session.action_link.replace('[1]','action=list_type-agent')
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
        id:'cmbFilter',
        listeners:{
            select:function(combo, value) {
                store.reload({params:{start:0, limit:jQuery('#ext-comp-1015').val(), type:combo.value}});
            }
        }
    });
    /*End*/

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
                    Ext.getCmp('btnExportCsv').enable();
                } else {
                    grid.removeButton.disable();
					grid.setTitle(session.grid_title);
                    Ext.getCmp('btnExportCsv').disable();
                }
            }
        }
	});
    function renderStatus(val, i, rec){
        var str = '';
        if (rec.data.is_active == 1) {
            str = '<a class="grid_default" href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.agent_id+')">Enable</a>';
        } else {
            str = '<a class="grid_warn_" href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.agent_id+')">Disable</a>';
        }
        return str;
    }
    function renderType(value, metadata, record, rowIndex, colIndex, store){
        //metadata.attr = 'ext:qtip="' + value + '"';
        //return value;
       
       if (record.data.parent_id != 0){
            var tip = "Main account: "+ record.data.parent_name;
            metadata.attr = 'ext:qtip="' + tip + '"';
            value = '<span class="grid_default">'+value+'</span>';
       }
       return value;
    }


    var grid = new Ext.grid.GridPanel({
        renderTo :'topic-grid',
        width:1140,
        height:500,
        title : session.grid_title ,
		iconCls: 'grid_icon', 
        store: store,
        trackMouseOver:false,
        loadMask : true,
		frame : true,
		clickstoEdit: 0,

        // grid columns
        columns:[
        sm,
        {
            id: 'agent_id', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID",
            dataIndex: 'agent_id',
            width: 50,
			align: 'center',
            sortable: true
		},{
            header: "Full Name",
            dataIndex: 'full_name',
            width: 150,
            sortable: true
        },{
            header: "Email",
            dataIndex: 'email_address',
            width: 150,
            sortable: true
		},{
            header: "Mobilephone",
            dataIndex: 'mobilephone',
            width: 100,
            sortable: true
		 },{
            header: "Telephone",
            dataIndex: 'telephone',
            width: 100,
            sortable: true
		 },{
            header: "Address",
            dataIndex: 'address',
            width: 230,
			align: 'left'
		},{
            header: "Type",
            dataIndex: 'type_name',
            width: 150,
			align: 'left',
			sortable: true,
            renderer:renderType
		},{
            header: "Instance",
            dataIndex: 'instance',
            width: 150,
			align: 'left',
			sortable: true,
            renderer:renderType
		},{
            header: "Status",
            dataIndex: 'is_active',
            width: 70,
			align: 'left',
            renderer: renderStatus
		},{
            header: "Creation Time",
            dataIndex: 'creation_time',
            width: 70,
			align: 'left'
		},{
            header: "Activated By",
            dataIndex: 'activated_by',
            width: 70,
			align: 'left'
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
                            ,disableIndexes : ['edit_link','active_link']
							,minChars : 3
							,autoFocus : true
							,position : 'top'
							,checkIndexes : '[agent_id, full_name, email_address, telephone, mobilephone, address, type]'
							,showSelectAll : true
							,width : 250
							,align : 'right'

				})]
		,
        tbar : [{
					text : 'Add Customer',
					icon : '/admin/resources/images/default/dd/drop-add.gif',
					cls : 'x-btn-text-icon',
					handler : function() {
						document.location = session.add_link;
					}
				},'-',
				{
					text : 'Delete Customer',
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
								id_ar.push(rows[i].data.agent_id);
							}

							if (id_ar.length > 0) {
								outAction('delete',id_ar.join(','));
							}
						} else {
							Ext.Msg.alert('Warning.','Please chose one row before deleting.');
						}
					}
				}
                ,'-',
                {
                    text : 'Export CSV',
                    icon : '/admin/resources/images/default/dd/drop-yes.gif',
                    tooltip: 'Export Customer To Csv File',
                    cls : 'x-btn-text-icon',
                    disabled: true,
                    id:'btnExportCsv',
                    //ref: '../changeButton',
                    handler : function() {
                        var sm = grid.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            //Ext.getCmp('btnChange').disable();
                            var id_ar = [];
                            var rows = sm.getSelections();
                            for (i = 0; i < rows.length; i++){
                                id_ar.push(rows[i].data.agent_id);
                            }

                            if (id_ar.length > 0) {
                                outAction('exportCustomerCSV',id_ar.join(','));
                            }
                        } else {
                            Ext.Msg.alert('Warning.','Please chose one row before export CSV.');
                        }
                    }
                },
                '->','Filter by',filter
		],
        // paging bar on the bottom
        bbar: new Ext.PagingToolbar({
            pageSize: 20,
            store: store,
            displayInfo: true,
            displayMsg: 'Total topics <div style="display: none;">{0} - {1} </div> {2}',
            emptyMsg: "No topics to display",
            plugins : [new Ext.ux.plugin.PagingToolbarResizer( {options : [ 20, 50, 100, 200 ], prependCombo: true})]
        })
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params:{start:0, limit:20,type:Ext.getCmp('cmbFilter').getValue()}});
    store.on('beforeload', function(store){
	    store.baseParams['type'] = Ext.getCmp('cmbFilter').getValue();
    });
});

function ajaxAction(type,val,url) {
	showWaitBox()
	Ext.Ajax.request({
		url : url,
		params : {
			type : type,
			agent_id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			//var resultMessage = jsonData.data.result;
            //alert(jsonData);
			hideWaitBox();
			store.reload({params:{type:Ext.getCmp('cmbFilter').getValue()}});
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
			alert('f');
			hideWaitBox();
		}
	});
}



 