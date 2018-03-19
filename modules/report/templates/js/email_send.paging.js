/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store_send = null;
Ext.onReady(function(){
    // create the Data Store
     store_send = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
       // idProperty: 'email_id',
        remoteSort: true,
        fields: [
            /*'total', 'bids', 'contact_vendor','makeof', 'send_friend' , 'alertemail' , 'register_agent' */
            'name',
            'number'
        ],
        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.email_send
        })
    });


    var grid_send = new Ext.grid.GridPanel({
        renderTo:'email_send',
		width:200,
        height:500,
        title:'Report Total Email System Sent ',
        store: store_send,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true, 
        // grid columns
        columns:[
            {
                header: "Description ",
                dataIndex: 'name',
                width: 180,
                align: 'center',
                sortable: true
            },
            {
                header: "Email Sent",
                dataIndex: 'number',
                width: 180,
                align: 'center',
                sortable: true
            }]
		  /*{
            header: "Total Email Send ",
            dataIndex: 'total',
            width: 180, 
			align: 'center', 
            sortable: true 
          },{	 
            header: "Send Bids",
            dataIndex: 'bids',
            width: 160, 
			align: 'center',
            sortable: true 
          },{	 
            header: "Send Register Agent",
            dataIndex: 'register_agent',
            width: 160, 
			align: 'center',
            sortable: true 
          },{	 
            header: "Send Contact Vendor",
            dataIndex: 'contact_vendor',
            width: 160, 
			align: 'center',
            sortable: true 
          },{
            header: "Send Make Offer",
            dataIndex: 'makeof',
            width: 160, 
			align: 'center',
            sortable: true 
          },{
            header: "Send Email To Friend",
            dataIndex: 'send_friend',
            width: 160, 
			align: 'center',
            sortable: true 
          },{
            header: "Send Email Alert",
            dataIndex: 'alertemail',
            width: 160, 
			align: 'center',
            sortable: true 
          }],*/
         

    });

    // render it
    grid_send.render();
    // trigger the data store load
    store_send.load();
});

 