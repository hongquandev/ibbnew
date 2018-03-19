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
            'ID', 'Updated', 'Action', 'Detail', 'UserID', 'IPAddress', 'Delete',  'delAll'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list')
        })
    });
    store.setDefaultSort('ID', 'DESC');


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
        el:'topic-grid',
        width:1135,
        height:500,
        title:session.grid_title,
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        frame:true,
         // grid columns
        columns:[
        sm,
        {
            header: "ID",
            dataIndex: 'ID',
            width: 80, 
			align: 'center',
            sortable: true
		},{
            header: "Action",
            dataIndex: 'Action',
            width: 100,
            sortable: true,
			align: 'center'
		},{
            header: "Detail",
            dataIndex: 'Detail',
            width: 550,
			sortable: true,
			align: 'left'
		},{
            header: "Date",
            dataIndex: 'Updated',
            width: 150,  
			align: 'center',
            sortable: true			
        },{
            header: "Username",
            dataIndex: 'UserID',
            width: 150,
			align: 'center',
		    sortable: true	
		},{            
            header: "Delete",
            dataIndex: 'Delete',
            width: 60,
			align: 'center',
		    sortable: false
		 
		 	
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
					,disableIndexes : ['Dele']
					,minChars : 3
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['Action','Updated','Detail','UserID']
					,showSelectAll : true
					,width : 250
					,align : 'right'

				})]
		,
        tbar : [{
					text : 'Delete Logs',
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
								id_ar.push(rows[i].data.ID);
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
                    text : 'Options',
					icon : '/admin/resources/images/default/dd/option.png',
					cls : 'x-btn-text-icon',
					handler:function(){
                        var url = session.action_link.replace('[1]','action=get-day');
                        $.post(url,{},function(data){
                            var result = jQuery.parseJSON(data);
                            Ext.getCmp('cmbAuto').setValue(result.auto);
                            if (result.auto == 'Yes'){
                                Ext.getCmp('txtDay').enable();
                            } else{
                                Ext.getCmp('txtDay').disable();
                            }

                            Ext.getCmp('txtDay').setValue(result.day);
                            options.show();
                        });


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

    //POPUP
    var data = ['Yes','No'];
    var options = new Ext.Window({
       title:'Log Options',
       bodyStyle:'padding:10px',
       width:300,
       height:150,
       layout:'form',
       closable:false,
       items:[
                new Ext.form.ComboBox({
                    id:'cmbAuto',
                    fieldLabel: 'Auto clear log',
                    store: data,
                    triggerAction: 'all',
                    editable:false,
                    width:140,
                    emptyText:'Select...',
                    hiddenName:'cmbDay',
                    listeners:{
                        select:function(combo,value){
                          if ($('input[name=cmbDay]').val() == 'No'){
                                Ext.getCmp('txtDay').disable();
                          } else{
                              Ext.getCmp('txtDay').enable();
                          }

                        }
                    }

                }),
                new Ext.form.TextField({
                    fieldLabel: 'Save days log',
                    width:140,
                    id: 'txtDay'
                })
       ],
       buttons:[{text:'Save',
                 icon : '/admin/resources/images/default/dd/save.png',
                    handler:function(){
                           var textbox = Ext.getCmp('txtDay');
                           if (isNaN(parseInt(textbox.getValue())) || textbox.getValue() > 14){
                               Ext.Msg.alert('Warning','Value invalid');
                               textbox.setValue('');
                           }else{
                               var url = session.action_link.replace('[1]','action=save-log');
                               showWaitBox();
                               $.post(url,{auto:$('input[name=cmbDay]').val(),day:textbox.getValue()},function(data){
                                    hideWaitBox();
			                        store.reload();
                                });

                           }
                            options.hide();
                 }},
                {text:'Cancel',
                 icon : '/admin/resources/images/default/dd/cancel.png',
                    handler:function(){
                       options.hide();
                 }
                }

            ]

    });

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


 