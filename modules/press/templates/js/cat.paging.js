/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 8:55 AM
 * To change this template use File | Settings | File Templates.
 */
var store;
Ext.onReady(function(){

    // create the Data Store
    store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'catID',
        remoteSort: true,
        fields: [
            'cat_id',  'title' , 'active' , 'position', 'Edit', 'Delete', 'View', 'count'
        ],

        proxy: new Ext.data.HttpProxy({
             url: session.action_link.replace('[1]','action=list-cat')
        })
    });
   /* store.setDefaultSort('position', 'DESC');*/


    function renderStatus(val, i, rec){
        var str = '';
        if (rec.data.active == 1) {
            str = '<a class="grid_default" href = "javascript:void(0)" onclick="outAction(\'change-status\','+rec.data.cat_id+')">Active</a>';
        } else {
            str = '<a class="grid_warn_" href = "javascript:void(0)" onclick="outAction(\'change-status\','+rec.data.cat_id+')">InActive</a>';
        }
        return str;
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

                } else {
                    grid.removeButton.disable();

                }
            }
        }
	});
    var grid = new Ext.grid.GridPanel({
        el:'topic-grid',
        width:1135,
        height:500,
        title : 'Help Categories',
		iconCls: 'grid_icon',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        frame : true,

        // grid columns
        columns:[
            sm,
        {
            header: "ID ",
            dataIndex: 'cat_id',
            width: 40,
			align: 'center',
            sortable: true
        },{
            header: "Title ",
            dataIndex: 'title',
            width:  270,
            renderer:renderTitle,
            sortable: true
		},{
            header: "Position",
            dataIndex: 'position',
            width: 50,
			align: 'center'
		},{
            header: "The number of Article",
            dataIndex: 'count',
            width: 80,
			align: 'center'
		},{
            header: "Status",
            dataIndex: 'active',
            width: 50,
			align: 'center',
            renderer:renderStatus
		},{
            header: "Edit",
            dataIndex: 'Edit',
            width: 50,
			align: 'center'
		},{
            header: "Delete",
            dataIndex: 'Delete',
            width: 50,
			align: 'center'
		},{
            header: "View",
            dataIndex: 'View',
            width: 50,
			align: 'center'
		}

        ],
        sm:sm,
        viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
				if (rec.data.description != null){
                    var str = '<div class="grid_expand1" style="margin-left:75px;">';
                    str += rec.data.description;
                    str += '</div>';
                    p.body = str;
                }

				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },
       /* plugins:[new Ext.ux.grid.Search({
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
		,*/
       tbar : [{
                 text : 'Add Category',
			     icon : '/admin/resources/images/default/dd/drop-add.gif',
			     cls : 'x-btn-text-icon',
				 handler : function() {
				    document.location = session.url_link.replace('[1]','add-category');
			     }
				},'-',
                {
					text : 'Delete Category',
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
								id_ar.push(rows[i].data.cat_id);
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
            store: store,
            displayInfo: true,
            displayMsg: 'Displaying topics {0} - {1} of {2}',
            emptyMsg: "No topics to display",
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
			id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			hideWaitBox();
			if (result.responseText && result.responseText.length > 0) {
				Ext.Msg.show({
                        title:'Warning !'
                        ,msg:result.responseText
                        ,icon:Ext.Msg.WARNING
                        ,buttons:Ext.Msg.OK

                });
			}
            store.reload();

		},
		failure : function( result, request ) {
			hideWaitBox();
		}
	});
}