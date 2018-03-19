/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 8:54 AM
 * To change this template use File | Settings | File Templates.
 */
var store = null;
Ext.onReady(function(){

    // create the Data Store
    store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'helpID',
        remoteSort: true,
        fields: [
            'helpID',  'question' , 'answer' , 'create_time' , 'update_time', 'position','active','permission','cat_name','catID','intro'
        ],
        proxy: new Ext.data.HttpProxy({
             url: session.action_link.replace('[1]','action=list-center')
        })
    });
    store.setDefaultSort('helpID', 'DESC');

    /*Filter by*/
    var filter_store = new Ext.data.JsonStore({
            root:'data',
            fields:['value','title'],
            method:"POST",
            url:session.action_link.replace('[1]','action=list-category')
        });
    filter_store.load({params:{start:0, limit:20}});

    var filter = new Ext.form.ComboBox({
        width:200,
        store: filter_store,
        valueField:'value',
        displayField:'title',
        mode:'local',
        hideTrigger:false,
        triggerAction: 'all',
        emptyText:'Choose category...',
        selectOnFocus:false,
        id:'cmbFilter',
        listeners:{
            select:function(combo, value) {
                store.reload({params:{start:0, limit:20, catID:combo.value}});
            }
        }
    });
    /*End*/

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
        title : 'Help Center List',
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
            // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID ",
            dataIndex: 'helpID',
            width: 40,
			align: 'center',
            sortable: true
        },{
            header: "Question",
            dataIndex: 'question',
            width:  270,
            renderer:renderTitle,
            sortable: true
		},{
            header: "Category Name",
            dataIndex: 'cat_name',
            width: 200,
            align: 'center'
		},{
            header: "For permission",
            dataIndex: 'permission',
            width: 150,
            align: 'center'
		},{
            header: "Creation time ",
            dataIndex: 'create_time',
            width: 100,
            sortable: true
		},{
            header: "Update Time",
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
				str += rec.data.intro;
				str += '</div>';

				str += '<p class="grid_expand2" style="margin-left:75px">';
                str += '<a href = "'+session.url_link.replace('[1]','edit-center&id='+rec.data.helpID)+'">Edit</a>';
                str += '<span>|</span>';
				str += '<a href = "javascript:void(0)" onclick="outAction(\'delete\','+rec.data.helpID+')">Delete</a>';
                str += '<span>|</span>';
				if (rec.data.active == 1) {
                   str += '<a href = "javascript:void(0)" onclick="outAction(\'change-status\','+rec.data.helpID+')">Active</a>';
                } else {
                   str += '<a class="grid_warn" href = "javascript:void(0)" onclick="outAction(\'change-status\','+rec.data.helpID+')">InActive</a>';
                }

				str += '</p>';
                p.body = str;
				return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },
        plugins:[new Ext.ux.grid.Search({
					iconCls : 'icon-zoom'
					,disableIndexes : ['create_time','update_time']
					,minChars : 2
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['helpID','question','answer']
					,showSelectAll : true
					,width : 250
					,align : 'right'

				})]
		,
        tbar : [{
					text : 'Add Question',
					icon : '/admin/resources/images/default/dd/drop-add.gif',
					cls : 'x-btn-text-icon',
					handler : function() {
						document.location = session.url_link.replace('[1]','add-center')
					}
				},'-',
				{
					text : 'Delete',
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
								id_ar.push(rows[i].data.helpID);
							}
							if (id_ar.length > 0) {
								outAction('multidelete',id_ar.join(','));
							}
						} else {
							Ext.Msg.alert('Warning.','Please chose one row before deleting.');
						}
					}
				},'->','Category',filter
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
    store.load({params:{start:0, limit:20, catID:(catID == '')?Ext.getCmp('cmbFilter').getValue():catID}});
    store.on('beforeload', function(store){
        store.baseParams['catID'] = (catID == '')?Ext.getCmp('cmbFilter').getValue():catID;
    });


});
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