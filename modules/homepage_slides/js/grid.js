/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store_faq = null;
Ext.onReady(function () {

    // create the Data Store
    store_faq = new Ext.data.JsonStore({
        root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'id',
        remoteSort: true,
        fields: [
            'id', 'image', 'text', 'position', 'date_creation', 'active','status'
        ],
        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','action=list-' + session.action_type)
        })
    });
    store_faq.setDefaultSort('position', 'ASC');
    function renderTitle(val, i, rec) {
        return '<b><font class="grid_title">' + val + '</font></b>';
    }
    function renderImage(val, i, rec) {
        return '<div><img src="'+ val +'" width="100px" height="100px" alt="Slide" /></div>';
    }
    var sm = new Ext.grid.CheckboxSelectionModel({
        listeners: {
            // On selection change, set enabled state of the removeButton
            // which was placed into the GridPanel using the ref config
            selectionchange: function (sm) {
                if (sm.getCount()) {
                    grid.removeButton.enable();
                    var l = sm.getCount();
                    var s = l != 1 ? 's' : '';
                    grid.setTitle(session.grid_title + ' <i>(' + l + ' item' + s + ' selected)</i>');
                } else {
                    grid.removeButton.disable();
                    grid.setTitle(session.grid_title);
                }
            }
        }
    });
    var grid = new Ext.grid.GridPanel({
        el: 'topic-grid',
        width: 1135,
        height: 500,
        title: session.grid_title,
        iconCls: 'grid_icon',
        store: store_faq,
        trackMouseOver: false,
        disableSelection: true,
        loadMask: true,
        frame: true,
        // grid columns
        columns: [
            sm,
            {
                // id assigned so we can apply custom css (e.g. .x-grid-col-topic b { color:#333 })
                header: "ID ",
                dataIndex: 'id',
                width: 40,
                align: 'center',
                sortable: true
            }, {
                header: "Image ",
                dataIndex: 'image',
                width: 150,
                renderer: renderImage,
                sortable: true
            }, {
                header: "Text ",
                dataIndex: 'text',
                width: 200,
                sortable: true
            }, {
                header: "Creation time ",
                dataIndex: 'date_creation',
                width: 100,
                sortable: true
            }, {
                header: "Status",
                dataIndex: 'status',
                width: 100,
                sortable: true
            }, {
                header: "Position",
                dataIndex: 'position',
                width: 50,
                align: 'center'
            }],
        sm: sm,
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            showPreview: true,
            getRowClass: function (rec, rowIndex, p, store) {
                var str = '<div class="grid_expand1" style="margin-left:75px;margin-top:10px">';
                str += '</div>';
                str += '<p class="grid_expand2" style="margin-left:75px">';
                str += '<a href = "' + session.url_link.replace('[1]', 'module=homepage_slides&action=edit&id=' + rec.data.id) + '">Edit</a>';
                str += '<span>|</span>';
                str += '<a href = "javascript:void(0)" onclick="outAction(\'delete\',' + rec.data.id + ')">Delete</a>';
                str += '<span>|</span>';
                if (rec.data.active == 1) {
                    str += '<a href = "javascript:void(0)" onclick="outAction(\'active\',' + rec.data.id + ')">Active</a>';
                } else {
                    str += '<a class="grid_warn" href = "javascript:void(0)" onclick="outAction(\'active\',' + rec.data.id + ')">InActive</a>';
                }
                str += '</p>';
                p.body = str;
                return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
            stripeRows: true
        },
        tbar: [{
            text: 'Add New Slide',
            icon: '/admin/resources/images/default/dd/drop-add.gif',
            cls: 'x-btn-text-icon',
            handler: function () {
                document.location = session.add_link;
            }
        }, '-',
            {
                text: 'Delete Slide',
                icon: '/admin/resources/images/default/dd/delete.png',
                cls: 'x-btn-text-icon',
                ref: '../removeButton',
                disabled: true,
                handler: function () {
                    var sm = grid.getSelectionModel();
                    var sel = sm.getSelected();
                    if (sm.hasSelection()) {
                        var id_ar = [];
                        var rows = sm.getSelections();
                        for (i = 0; i < rows.length; i++) {
                            id_ar.push(rows[i].data.id);
                        }
                        if (id_ar.length > 0) {
                            outAction('multidelete', id_ar.join(','));
                        }
                    } else {
                        Ext.Msg.alert('Warning.', 'Please chose one row before deleting.');
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
            plugins: [new Ext.ux.plugin.PagingToolbarResizer({options: [20, 50, 100, 200], prependCombo: true})]
        })
    });
    // render it
    grid.render();
    // trigger the data store load
    store_faq.load({params: {start: 0, limit: 20}});
});
function ajaxAction(type, val, url) {
    showWaitBox()
    Ext.Ajax.request({
        url: url,
        params: {
            type: type,
            id: val
        },
        success: function (result, request) {
            var jsonData = Ext.util.JSON.decode(result.responseText);
            //var resultMessage = jsonData.data.result;
            hideWaitBox();
            if (result.responseText && result.responseText.length > 0) {
                Ext.Msg.show({
                    title: 'Warning !'
                    , msg: result.responseText
                    , icon: Ext.Msg.WARNING
                    , buttons: Ext.Msg.OK
                });
            }
            store_faq.reload();
        },
        failure: function (result, request) {
            hideWaitBox();
        }
    });
}


 