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
        idProperty: 'banner_id',
        remoteSort: true,
        fields: [
            'banner_id',
            'banner_name',
            'fullname' ,
            'firstname',
            'lastname',
            'banner_file',
            'url' ,
            'position',
            'page_id' ,
            'title' ,
            'clicks' ,
            'views',
            'agent_id',
            'date_from',
            'date_to',
            'creation_time',
            'update_time',
            'status',
			'agent_status',
			'display',
			'pay_status'
        ],		
        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-' + session.action_type)
        })
    });
    store.setDefaultSort('banner_id', 'ASC');  
	
	// pluggable renders
    function renderName(value, p, record){
        return String.format(
                '<div style="cursor:text" onclick = "document.frmEdit.banner_id.value = \'{1}\'; return !showPopup(\'nameFieldPopup\', event);  " >{0}</div>',
                value, record.data.page_id);
    }
    function renderTitle(val,i,rec) {
		return '<b><font class="grid_title">' + val + '</font></b>';
	}
  
    var sm = new Ext.grid.CheckboxSelectionModel({
            listeners: {
                // On selection change, set enabled state of the removeButton
                // which was placed into the GridPanel using the ref config
                selectionchange: function(sm) {
                    if (sm.getCount()) {
                        grid.removeButton.enable();
                        Ext.getCmp('btnChangePay').enable();
                        var l = sm.getCount();
                        var s = l != 1 ? 's' : '';
                        grid.setTitle(session.grid_title + ' <i>('+l+' item'+s+' selected)</i>');
                    } else {
                        grid.removeButton.disable();
                        Ext.getCmp('btnChangePay').disable();
                        grid.setTitle(session.grid_title);
                    }
                }
            }
    });

    //payment
    var pay_data = new Ext.data.SimpleStore({
        fields : ['id', 'pay_status'],
		data : [['0','Pending'],
                ['1','Payment received'],
                ['2','Completed']

        ]
    });

    var grid = new Ext.grid.EditorGridPanel({
        el:'topic-grid',
        width:1135,
        height:500,
        title : session.grid_title,
		iconCls: 'grid_icon',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        frame : true,
        clickstoEdit: 1,
        // grid columns
        columns:[
        sm,
        {
            header: "ID ",
            dataIndex: 'banner_id',
            width: 40, 
			align: 'center',
            sortable: true 
        },{
            header: "Banner Name ",
            dataIndex: 'banner_name',
            width: 170,
            sortable: true,
            renderer:renderTitle
		},{
			header: "Agent Name",
            dataIndex: 'fullname',
            width: 80,
			align: 'center'
		},{
            header: "Position",
            dataIndex: 'position',
			align: 'center',
            width: 50,
            sortable: true
		},{
            header: "Clicks",
            dataIndex: 'clicks',
			align: 'center',
            width: 50,  
            sortable: true 			
		},{            
            header: "Views",
            dataIndex: 'views',
            width: 50,  
			align: 'center'
		},{            
            header: "Date From",
            dataIndex: 'date_from',
            width: 80,  
			align: 'center'
		},{
            header: "Date To",
            dataIndex: 'date_to',
            width: 80,
			align: 'center'
		},{
			header : "Pay Status",
            dataIndex : 'pay_status',
            width : 80,
			align : 'center',
			sortable : true,
            editor: new Ext.form.ComboBox({
               typeAhead: true,
               store: pay_data,
               displayField: 'pay_status',
               fieldLabel: 'pay_status',
               hiddenName:'cmbPay',
               valueField: 'pay_status',
               triggerAction: 'all',
               mode: 'local',
               lazyInit: false,
               listeners: {
                   click: function(obj) {
                            obj.expand();
                   },
                   change: function(combo,value){
                       var url = '../modules/banner/action.admin.php?action=change_pay-banner&token='+session.token;
                       var sm =  grid.getSelectionModel();
                       var sem = sm.getSelections();
                       $.post(url,{pay:value,banner_id:sem[0].get('banner_id')},function(data){
                               });
                   }
               }

            })
		 }],
        viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				var str = '<p class="grid_expand1" style="margin-left:75px;margin-top:10px">';
                str += '<span><strong>Display Pages: </strong>'+rec.data.title+'</span><br/>';
				str += rec.data.banner_file + '<br/>';
				str += '</p>';

				str += '<p class="grid_expand2" style="margin-left:75px">';
                if (rec.data.status == 1) {
					str += '<span><strong></strong></span> <a href = "javascript:void(0)" onclick="outAction(\'change-status\','+rec.data.banner_id+')">Active</a>';
				} else {
					str += '<span><strong></strong></span> <a class="grid_warn" href="javascript:void(0)" onclick="outAction(\'change-status\','+rec.data.banner_id+')">InActive</a>';
				}
				str += '<span>|</span>';
				if (rec.data.agent_status == 1) {
					str += '<span><strong></strong></span> <a href = "javascript:void(0)" onclick="outAction(\'change-agent\','+rec.data.banner_id+')">Online</a>';
				} else {
					str += '<span><strong></strong></span> <a class="grid_warn" href="javascript:void(0)" onclick="outAction(\'change-agent\','+rec.data.banner_id+')">Offline</a>';
				}
				
                str += '<span>|</span>';
                str += '<a href = "'+session.url_link.replace('[1]','module=banner&action=edit&id='+rec.data.banner_id)+'">Edit</a>';
                str += '<span>|</span>';
				str += '<a href = "javascript:void(0)" onclick="outAction(\'delete\','+rec.data.banner_id+')">Delete</a>';
				str += '<span>|</span>';
				if (rec.data.display == 1) {
					str += '<span><strong>Display Area : Right </strong></span>';
				} else {
					str += '<span><strong>Display Area : Center </strong></span>';
				}
				
				str += '</p>';
                p.body = str;
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },
        sm:sm,
        plugins:[new Ext.ux.grid.Search({
					iconCls : 'icon-zoom'
					,minChars : 3
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['banner_id','banner_name','url','fullname']
					,showSelectAll : true
					,width : 250
					,align : 'right'
				})],
        tbar : [{
					text : 'Add Banner',
					icon : '/admin/resources/images/default/dd/drop-add.gif',
					cls : 'x-btn-text-icon',
					handler : function() {
						document.location = session.add_link;
					}
				},'-',
				{
					text : 'Delete Banner',
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
								id_ar.push(rows[i].data.banner_id);
							}
							if (id_ar.length > 0) {
								outAction('multidelete',id_ar.join(','));
							}
						} else {
							Ext.Msg.alert('Warning.','Please chose one row before deleting.');
						}
					}
				}, '-',
				{
					text : 'Change Payment',
					icon : '/admin/resources/images/default/dd/order-icon.png',
					cls : 'x-btn-text-icon',
					disabled: true,
                    id:'btnChangePay',
                    menu:[
                        {text:'Pending',
                         handler:function(){
                                var sm = grid.getSelectionModel();
                                var sel = sm.getSelected();
                                if (sm.hasSelection()){
                                    var id_ar = [];
                                    var rows = sm.getSelections();
                                    for (var i = 0; i < rows.length; i++){
                                        id_ar.push(rows[i].data.banner_id);
                                    }
                                    changePayment(id_ar,'Pending');
                                }else {
                                    Ext.Msg.alert('Warning.','Please chose one row before deleting.');
                                }
                         }
                        },
                        {text:'Payment received',
                         handler:function(){
                                var sm = grid.getSelectionModel();
                                var sel = sm.getSelected();
                                if (sm.hasSelection()){
                                    var id_ar = [];
                                    var rows = sm.getSelections();
                                    for (var i = 0; i < rows.length; i++){
                                        id_ar.push(rows[i].data.banner_id);
                                    }
                                    changePayment(id_ar,'Payment received');
                                }else {
                                    Ext.Msg.alert('Warning.','Please chose one row before deleting.');
                                }
                         }
                        },
                        {text:'Completed',
                         handler:function(){
                                var sm = grid.getSelectionModel();
                                var sel = sm.getSelected();
                                if (sm.hasSelection()){
                                    var id_ar = [];
                                    var rows = sm.getSelections();
                                    for (var i = 0; i < rows.length; i++){
                                        id_ar.push(rows[i].data.banner_id);
                                    }
                                    changePayment(id_ar,'Completed');
                                }else {
                                    Ext.Msg.alert('Warning.','Please chose one row before deleting.');
                                }}
                        }
                    ],
                    handler:function(){
                        var sm = grid.getSelectionModel();
                        var sel = sm.getSelected();
                        if (sm.hasSelection()){
                            var id_ar = [];
                            var rows = sm.getSelections();
                            for (var i = 0; i < rows.length; i++){
                                id_ar.push(rows[i].data.banner_id);
                            }
                            return id_ar;
                        }else {
                            Ext.Msg.alert('Warning.','Please chose one row before deleting.');
                        }
                    }
				}
				
		],
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
			banner_id : val
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

function changePayment(id_ar,value){
	 if (id_ar.length > 0) {
		 var url = '../modules/banner/action.admin.php?action=multichange_pay-banner&token='+session.token;
		 $.post(url,{pay:value,banner_id:id_ar.join(',')},function(data){
			 var result = jQuery.parseJSON(data);
			 if (result == 'success'){
				store.reload();
			 }else{
				Ext.Msg.alert('Warning.','Error when process. Please try again !');
			 }
		 });
	 }
}
 