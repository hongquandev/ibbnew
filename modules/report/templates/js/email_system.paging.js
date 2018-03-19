/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store = null;
Ext.onReady(function () {
    // create the Data Store
    store = new Ext.data.JsonStore({
        root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'id',
        remoteSort: true,
        fields: [
            'id',
            'status',
            'from_name',
            'from',
            'to',
            'date_create',
            'message',
            'subject'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.email_log_system_link
        })
    });
    store.setDefaultSort('id', 'DESC');
    function renderStatus(val, i, rec) {
        if (val == 'Pending') {
            return '<span class="grid_warn">' + val + '</span>';
        }
        return '<span class="grid_default">' + val + '</span>';
    }

    function renderTitle(val, i, rec) {
        return '<b><font class="grid_title">' + val + '</font></b>';
    }

    function renderFrom(val, i, rec) {
        return '<b><font class="grid_title">' + val + '</font></b><br>From Email: ' + rec.data.from;
    }

    function renderMess(val, i, rec) {
        return '<b><font class="grid_title">' + rec.data.subject + '</font></b><br>'+'<div style="white-space: normal;" class="message_title">' + val + '</div>';
    }

    var grid = new Ext.grid.GridPanel({
        renderTo: 'topic-grid',
        width: '100%',
        height: 500,
        title: 'Log all email System ',
        iconCls: 'grid_icon',
        store: store,
        trackMouseOver: false,
        disableSelection: true,
        frame: true,
        loadMask: true,
        // grid columns
        columns: [
            {
                header: "ID",
                dataIndex: 'id',
                width: 40,
                align: 'center',
                sortable: true
            }, {
                header: "From name",
                dataIndex: 'from_name',
                width: 100,
                align: 'left',
                sortable: true,
                renderer: renderFrom
            }, {
                header: "To Email",
                dataIndex: 'to',
                width: 100,
                align: 'left',
                sortable: true,
                renderer: renderTitle
            }
            , {
                header: "Status",
                dataIndex: 'status',
                width: 50,
                align: 'left',
                sortable: true,
                renderer: renderStatus
            },
            {
                header: "Date Creation",
                dataIndex: 'date_create',
                width: 100,
                align: 'left',
                sortable: true,
                renderer: renderTitle
            }, {
                header: "Message",
                dataIndex: 'message',
                width: 400,
                align: 'left',
                sortable: true,
                renderer: renderMess
            }
        ],
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            showPreview: true,
            getRowClass: function (rec, rowIndex, p, store) {
                return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
            },
            stripeRows: true
        },


        // paging bar on the bottom
        bbar: new Ext.PagingToolbar({
            pageSize: 20,
            store: store,
            displayInfo: true,
            displayMsg: 'Displaying topics {0} - {1} of {2}',
            emptyMsg: "No topics to display",
            plugins: [new Ext.ux.plugin.PagingToolbarResizer({options: [20, 50, 100, 200], prependCombo: true})]
        })
    });
    grid.render();
    store.load({params: {start: 0, limit: 20}});
});

 