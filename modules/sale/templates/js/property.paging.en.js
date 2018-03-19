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
        id : 'id',
        remoteSort : true,
        fields : [
            'id', 
			'property_id',
			'property_address',
			'banner_id', 
			'agent_id',
			'agent_name',
			'home',
			'home_price',
			'focus',
			'focus_price',
			'bid',
			'bid_price',
			'offer',
			'offer_price',
			'package_name',
			'package_price',
			'payment_type',
			'cc_transid',
			'amount',
			'cross',
			'creation_time',
			'is_paid'
        ],
        limit : 'limit',

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy : new Ext.data.HttpProxy({
            url : session.action_link.replace('[1]','action=list-' + session.action_type)
        })
    });
	
    store.setDefaultSort('id', 'DESC');
	
	function renderEdit(val,i,rec) {
		return '<a href = "'+session.url_link.replace('[1]','module=sale&action=edit-property&id='+rec.data.id)+'"><img src = "resources/images/default/dd/table_edit.png"></a>';
	}
	
	function renderDelete(val,i,rec) {
		return '<a href = "javascript:void(0)" onclick="outAction(\'delete\','+rec.data.id+')"><img src = "resources/images/default/dd/delete.png"></a>';
	}
	
	function renderAddress(val, i, rec) {
		str = jQuery.trim(rec.data.property_address).length > 0 ?  rec.data.property_address : 'Article unknown';
		
		if (rec.data.package_price > 0) {
			str += '<br/><i>&raquo; Package(' + rec.data.package_name + ')';
			if (rec.data.package_price > 0) {
				str += ': AU$ ' + rec.data.package_price;
			}
			str += '</i>';
		}
		
		if (rec.data.home > 0) {
			str += '<br/><i>&raquo; Home';
			if (rec.data.home_price > 0) {
				str += ': AU$ ' + rec.data.home_price;
			}
			str += '</i>';
		}

		if (rec.data.focus > 0) {
			str += '<br/><i>&raquo; Focus';
			if (rec.data.focus_price > 0) {
				str += ': AU$ ' + rec.data.focus_price;
			}
			str += '</i>';
		}
		
		if (rec.data.bid > 0) {
			str += '<br/><i>&raquo; Register bid';
			if (rec.data.bid_price > 0) {
				str += ': AU$ ' + rec.data.bid_price;
			}
			str += '</i>';
		}

		if (rec.data.offer > 0) {
			str += '<br/><i>&raquo; Offer';
			if (rec.data.offer_price > 0) {
				str += ': AU$ ' + rec.data.offer_price;
			}
			str += '</i>';
			
		}
		
		return str;
	}
	
	function renderPaymentType(val, i, rec) {
		str = val;
		if (rec.data.cc_transid.length > 0) {
			str += '<br/>TransId:' + rec.data.cc_transid;
		}
		return str;
	}
	
	function renderBool(val, i, rec) {
		return val == 1 ? 'Yes':'No';
	}
	
	function renderStatus(val, i, rec) {
		//rec.data.is_paid
		str = val == 1 ? 'Paid': '<a href="javascript:void(0)" onclick="outAction(\'multiactive\','+rec.data.id+')">Pending</a>';
		return str;
	}
	
	function renderCreationTime(val, i, rec) {
		return val;
	}

	function renderAction(val, i, rec) {
		//str = '<a href="">View</a> / <a href="">Delete</a>';
		str = '<a href="javascript:void(0)" onclick="outAction(\'delete\','+rec.data.id+')">Delete</a>';
		return str;
	}
	
	var sm = new Ext.grid.CheckboxSelectionModel({
		listeners: {
            // On selection change, set enabled state of the removeButton
            // which was placed into the GridPanel using the ref config
            selectionchange: function(sm) {
                if (sm.getCount()) {
                    grid.removeButton.enable();
					//Ext.getCmp('btnChange').enable();
					var l = sm.getCount();
					var s = l != 1 ? 's' : '';
					grid.setTitle(session.grid_title + ' <i>('+l+' item'+s+' selected)</i>');
                } else {
                    grid.removeButton.disable();
                    //Ext.getCmp('btnChange').disable();
					grid.setTitle(session.grid_title);
                }
            }
        }												 
	});

   /* var grid = new Ext.grid.GridPanel({*/
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
            dataIndex : 'id',
            width : 40, 
			align : 'center',
            sortable : true 
          },{
            header : "P Id",
            dataIndex : 'property_id',
            width : 40, 
			align : 'center',
            sortable : true 
          },{
            header : "Address",
            dataIndex : 'property_address',
            width : 350, 
			align : 'left',
            sortable : true,
			renderer : renderAddress
          },{
            header : "Agent Name",
            dataIndex : 'agent_name',
            width : 150, 
			align : 'left'//,
            //sortable : true 
          },{
            header : "Payment Type",
            dataIndex : 'payment_type',
            width : 100, 
			align : 'center',
			renderer : renderPaymentType
            //sortable : true 
          },{
            header : "Amount (AU$)",
            dataIndex : 'amount',
            width : 100, 
			align : 'center',
            sortable : true 
          },{
            header : "Cross (AU$)",
            dataIndex : 'cross',
            width : 100, 
			align : 'center',
            sortable : true 
          },{
            header : "Status",
            dataIndex : 'is_paid',
            width : 50, 
			align : 'center',
            sortable : true,
			renderer: renderStatus
          },{
            header : "Create time",
            dataIndex : 'creation_time',
            width : 100, 
			align : 'center',
            sortable : true,
			renderer: renderCreationTime
          },{
            header : "Action",
            dataIndex : 'action',
            width : 50, 
			align : 'center',
			renderer: renderAction
          }],
		sm: sm,
		viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store) {
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';				
            },
			stripeRows: true
        },		
		plugins:[new Ext.ux.grid.Search({
					iconCls : 'icon-zoom'
					,readonlyIndexes : ['note']
					,disableIndexes : ['property_id','banner_id','agent_id','agent_name','payment_type','amount','is_paid','action']
					,minChars : 3
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['id','property_address']
					,showSelectAll : true
					,width : 250
					,align : 'right'

				})]
		,
		tbar : [
            {
                text : 'Delete Property',
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
                            id_ar.push(rows[i].data.id);
                        }

                        if (id_ar.length > 0) {
                            outAction('multidelete',id_ar.join(','));
                        }
                    } else {
                        Ext.Msg.alert('Warning.','Please chose one row before deleting.');
                    }
                }
		    },
            {
                text : 'Export Register to Bid CSV with properties',
                icon : '/admin/resources/images/default/dd/drop-add.gif',
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
                            id_ar.push(rows[i].data.id);
                        }

                        if (id_ar.length > 0) {
                            outAction('exportCSV',id_ar.join(','));
                        }
                    } else {
                        Ext.Msg.alert('Warning.','Please chose one row before export.');
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
    //store.baseParams = {key: Ext.getCmp('cmbFilter').getValue()};
    store.on('beforeload', function(store){
	    //store.baseParams = {key: Ext.getCmp('cmbFilter').getValue()};
    });
    store.load({params : {start : 0, limit : 20}});
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
			id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			//var resultMessage = jsonData.data.result;
			hideWaitBox();
			store.reload({});
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

function confirmAdmin(action,property_id,type){
    if (type == true){//yes (show popup confirm)
        Ext.Msg.show({
				title :'Warning?'
				,msg :'Are you sure change property ?'
				,icon : Ext.Msg.QUESTION
				,buttons : Ext.Msg.YESNO
				,scope : this
				,fn : function(response) {
					if('yes' !== response) {
						return ;
					}
					outAction(action,id);
				}
			});
    }else{//no (show popup)
                var radio =  new Ext.form.RadioGroup({
                                            id:'rdConfirm',
                                           /* fieldLabel: 'Choose payment method',*/
                                            columns:2,
                                            autoHeight:true,
                                            collapsed: true
                                            //items: result.data
                                       });
                var options = new Ext.Window({
                   title:'Advance property',
                   bodyStyle:'padding:10px',
                   //width:400,
                   autoHeight:true,
                   width:330,
                   layout:'form',
                   closable:false,
                   items:radio,
                   buttons:[{text:'Save',
                             icon : '/admin/resources/images/default/dd/save.png',
                             handler:function(){
                                       var checkItem = Ext.getCmp('rdConfirm').getValue();
                                       if (checkItem == null){
                                           Ext.Msg.alert('Failure', 'Please choose a option !');
                                       }else{
                                           outAction(action,id);
                                       }
                                        radio.destroy();
                                        options.hide();
                             }},
                            {text:'Cancel',
                             icon : '/admin/resources/images/default/dd/cancel.png',
                             handler:function(){
                                   radio.destroy();
                                   options.hide();
                             }
                            }
                        ]

                });
                radio.items = [
                    { boxLabel: 'Payment', name: 'confirm', inputValue: 'payment'},
                    { boxLabel: 'Free', name: 'confirm', inputValue: 'free'}
                   /* { boxLabel: 'Cancel', name: 'confirm', inputValue: 'cancel'}*/
                ];
                options.show();
    }

}
