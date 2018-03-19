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
        idProperty: 'page_id',
        remoteSort: true,
        fields: [
            'page_id',
            'title',
            'creation_time' ,
            'update_time',
			'edit_link',
			'delete_link'
        ],
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=tourguide-view')
        })
    });
    //store.setDefaultSort('page_id', 'ASC');
	
    function renderMenu(val, i, rec) {
        var str = '';
        if (rec.data.page_id == '') {
            str = '<span class="grid_title" style="font-size:12px;font-weight: bold;">'+val+'</span>';
        } else {
            str += '<div style="float:left;">'+val+'</div>';
        }
        return str;
    };
    
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
        title : session.grid_title ,
		iconCls: 'grid_icon',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        frame:true,
        // grid columns
        columns:[
        sm,
        {
            id: 'page_id', // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
            header: "ID ",
            dataIndex: 'page_id',
            width: 40,
			align: 'center',
            sortable: true 
        },{
            header: "Title",
            dataIndex: 'title',
            width: 500,
            sortable: false,
			align: 'left',
            renderer: renderMenu
		},{
            header: "Creation time ",
            dataIndex: 'creation_time',
            width: 80,  
            sortable: false,
			align: 'center'
		},{
            header: "Update time ",
            dataIndex: 'update_time',
            width: 80,  
            sortable: false,
			align: 'center'
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
					,disableIndexes : ['sort_order','creation_time','update_time']
					,minChars : 3
					,autoFocus : true
					,position : 'top'
					,checkIndexes : ['page_id','title_frontend','type']
					,showSelectAll : true
					,width : 250
					,align : 'right'

				})]
	   ,
       tbar : [{
					text : 'Add Tour Guide Page/Action',
					icon : '/admin/resources/images/default/dd/drop-add.gif',
					cls : 'x-btn-text-icon',
					handler : function() {
						document.location = session.add_link;
					}
				},'-',
				{
					text : 'Delete Tour Guide Page/Action',
					icon : '/admin/resources/images/default/dd/delete.png',
					cls : 'x-btn-text-icon ',
					ref: '../removeButton',
					disabled: true,
					handler : function() {
						var sm = grid.getSelectionModel();
						var sel = sm.getSelected();
						if (sm.hasSelection()){
							var id_ar = [];
							var rows = sm.getSelections();
							for (i = 0; i < rows.length; i++){
								id_ar.push(rows[i].data.page_id);
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
       bbar : new Ext.PagingToolbar({
            pageSize : 20,
            store : store,
            displayInfo : true,
            displayMsg : 'Total CMS page <div id="cms-paging" style="display: none">{0} - {1} of </div> {2}',
            emptyMsg : "No CMS page to display",
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
			page_id : val
		},
		success : function ( result, request ) {
			var jsonData = Ext.util.JSON.decode(result.responseText);
			hideWaitBox();
			store.reload();
			//alert('alo');
			if (result.responseText && result.responseText.length > 0) {
				Ext.Msg.show({
					title:'Warning !'
					,msg:result.responseText
					,icon:Ext.Msg.WARNING
					,buttons:Ext.Msg.OK

				});
			}
			jQuery('#ext-gen36').hide();
			if (show == 'full') {
				jQuery('#ext-gen36').show();
			}
		},
		
		failure : function( result, request ) {
			alert('f');
			hideWaitBox();
		}
	});
}
