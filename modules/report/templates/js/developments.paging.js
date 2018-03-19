/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var _store = null;
Ext.onReady(function () {

    // create the Data Store
    var store = new Ext.data.JsonStore({
        root: 'topics',
        totalProperty: 'totalCount',
        // idProperty: 'email_id',
        remoteSort: true,
        fields: [
            'development_id', 'first_name', 'last_name', 'email_address', 'postcode', 'describes', 'interested', 'interested_project'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: list_link
        })
    });
    store.setDefaultSort('development_id', 'DESC');


    var pagingBar = new Ext.PagingToolbar({
        pageSize: 20,
        store: store,
        displayInfo: true,
        displayMsg: 'Displaying topics {0} - {1} of {2}',
        emptyMsg: "No topics to display"
    });


    var grid = new Ext.grid.GridPanel({
        el: 'topic-grid',
        /*width:1135,*/
        width: 1140,
        height: 500,
        title: 'Report Developments Listing',

        store: store,
        trackMouseOver: false,
        disableSelection: true,
        loadMask: true,
        // grid columns
        columns: [
            {
                header: "ID",
                dataIndex: 'development_id',
                width: 30,
                align: 'center',
                sortable: true
            }, {
                header: "First Name",
                dataIndex: 'first_name',
                width: 310,
                align: 'center',
                sortable: true
            }, {
                header: "Last Name",
                dataIndex: 'last_name',
                width: 310,
                align: 'center',
                sortable: true
            }, {
                header: "Email Address",
                dataIndex: 'email_address',
                width: 400,
                align: 'center',
                sortable: true
            }/*, {
                header: "Postcode",
                dataIndex: 'postcode',
                width: 70,
                align: 'center',
                sortable: true
            }, {
                header: "What best describes you?",
                dataIndex: 'describes',
                width: 200,
                align: 'center',
                sortable: true
            }, {
                header: "What are you interested in?",
                dataIndex: 'interested',
                width: 200,
                align: 'center',
                sortable: true
            }, {
                header: "Are you interested in a project?",
                dataIndex: 'interested_project',
                width: 200,
                align: 'center',
                sortable: true
            }*/
        ],
        tbar: [
            {
                text : 'Export CSV',
                icon : '/admin/resources/images/default/dd/drop-yes.gif',
                tooltip: 'Export to Csv File',
                cls : 'x-btn-text-icon',
                disabled: false,
                id:'btnExportCsv',
                handler : function() {
                    document.location = ROOTURL + '/fixit/?module=report&action=view-developments_CSV&token='+ token;
                    return true;
                }
            }
        ],
        // paging bar on the bottom
        bbar: pagingBar
    });

    // render it
    grid.render();

    // trigger the data store load
    store.load({params: {start: 0, limit: 20}});
    //BY GOS:MOHA
    _store = store;
});

 