	/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store_faq = null;
Ext.onReady(function(){

    // create the Data Store
    store_faq = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'content_id',
        remoteSort: true,
        fields: [
            'content_id',  'question' , 'answer' , 'create_time' , 'update_time',  'update_date', 'position', 'Edit', 'Delete','active'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
             url: session.action_link.replace('[1]','action=list-' + session.action_type)
        })
    });
    store_faq.setDefaultSort('position', 'DESC');
	
	// pluggable renders
    function renderName(value, p, record){
        return String.format(
                '<div style="cursor:text" onclick = "document.frmEdit.page_id.value = \'{1}\'; return !showPopup(\'nameFieldPopup\', event);  " >{0}</div>',
                value, record.data.faq_id);
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
        title : session.grid_title,
		iconCls: 'grid_icon',
        store: store_faq,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        frame : true,

        // grid columns
        columns:[
            sm,
        {
            // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID ",
            dataIndex: 'content_id',
            width: 40,
			align: 'center',
            sortable: true 
        },{
            header: "Question ",
            dataIndex: 'question',
            width:  270,
            renderer:renderTitle,
            sortable: true			
		},{
            header: "Creation time ",
            dataIndex: 'create_time',
            width: 100,  
            sortable: true 			
		},{
            header: "Update Time ",
            dataIndex: 'update_time',
            width: 100,  
            sortable: true 			
		},{            
            header: "Position",
            dataIndex: 'position',
            width: 50,  
			align: 'center'
		}],
        sm:sm,
        viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				var str = '<div class="grid_expand1" style="margin-left:75px;margin-top:10px">';
				str += rec.data.answer;
				str += '</div>';

				str += '<p class="grid_expand2" style="margin-left:75px">';
                str += '<a href = "'+session.url_link.replace('[1]','module=contentfaq&action=edit&id='+rec.data.content_id)+'">Edit</a>';
                str += '<span>|</span>';
				str += '<a href = "javascript:void(0)" onclick="outAction(\'delete\','+rec.data.content_id+')">Delete</a>';
                str += '<span>|</span>';
				if (rec.data.active == 1) {
                   str += '<a href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.content_id+')">Active</a>';
                } else {
                   str += '<a class="grid_warn" href = "javascript:void(0)" onclick="outAction(\'active\','+rec.data.content_id+')">InActive</a>';
                }

				str += '</p>';
                p.body = str;
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },
        plugins:[new Ext.ux.grid.Search({
					iconCls : 'icon-zoom'
					,disableIndexes : ['create_time','update_time','faq_id']
					,minChars : 2
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['content_id','question','answer']
					,showSelectAll : true
					,width : 250
					,align : 'right'

				})]
		,
        tbar : [{
					text : 'Add FAQ',
					icon : '/admin/resources/images/default/dd/drop-add.gif',
					cls : 'x-btn-text-icon',
					handler : function() {
						document.location = session.add_link;
					}
				},'-',
				{
					text : 'Delete FAQ',
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
								id_ar.push(rows[i].data.content_id);
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
        bbar: new Ext.PagingToolbar({
            pageSize: 20,
            store: store_faq,
            displayInfo: true,
            displayMsg: 'Displaying topics {0} - {1} of {2}',
            emptyMsg: "No topics to display",
            plugins : [new Ext.ux.plugin.PagingToolbarResizer( {options : [ 20, 50, 100, 200 ], prependCombo: true})]
        })
    });

    // render it
    grid.render();

    // trigger the data store load
    store_faq.load({params:{start:0, limit:20}});
});
function ajaxAction(type,val,url) {
	showWaitBox()
	Ext.Ajax.request({
		url : url,
		params : {
			type : type,
			faq_id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			//var resultMessage = jsonData.data.result;
			hideWaitBox();
			if (result.responseText && result.responseText.length > 0) {
				Ext.Msg.show({
                        title:'Warning !'
                        ,msg:result.responseText
                        ,icon:Ext.Msg.WARNING
                        ,buttons:Ext.Msg.OK

                });
			}
            store_faq.reload();
			
		},
		failure : function( result, request ) {
			hideWaitBox();
		}
	});		
}


 