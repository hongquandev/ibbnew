/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
Ext.onReady(function(){
    // create the Data Store
    var store_alert = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'email_id',
        remoteSort: true,
        fields: [
            'email_id',
            'status',
            'name_email',
            'type_name',
            'email_address',
            'as_name',
            'minprice',
            'maxprice',
            'full_address',
            'bedroom_value',
            'bathroom_value',
            'land_size_min',
            'land_size_max',
            'unit',
            'car_space_value',
            'car_port_value',
            'last_cron'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.alert_link
        })
    });
    store_alert.setDefaultSort('email_id', 'DESC');
    function renderStatus(val,i,rec) {
		if (val == 'Pending'){
            return '<span class="grid_warn">'+val+'</span>';
        }
        return '<span class="grid_default">'+val+'</span>';
	}
    function renderTitle(val,i,rec) {
		return '<b><font class="grid_title">' + val + '</font></b>';
	}

    //EMAIL SEND
     var store_send = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        fields: [
            'name',
            'number'
        ],
        proxy: new Ext.data.HttpProxy({
            url: session.send_link
        })
    });

    var grid = new Ext.grid.GridPanel({
        renderTo:'topic-grid',
        /*width:1135,*/
		width:804,
        height:500,
        title:'Email Alert',
		iconCls: 'grid_icon',
        store: store_alert,
        trackMouseOver:false,
        disableSelection:true,
        //frame : true,
        loadMask: true,
        // grid columns
        columns:[
		  {
            header: "ID",
            dataIndex: 'email_id',
            width: 40, 
			align: 'center',
            sortable: true 
          },{
            header: "Status",
            dataIndex: 'status',
            width: 50,
			align: 'left',
            sortable: true,
            renderer: renderStatus
          },            {
            header: "Sent to Email",
            dataIndex: 'email_address',
            width: 100,
			align: 'left',
            sortable: true,
            renderer:renderTitle
          },{
            header: "Name",
            dataIndex: 'name_email',
            width: 300,
			align: 'left',
            sortable: true,
            renderer:renderTitle
          }/*,{
            header: "Type",
            dataIndex: 'type_name',
            width: 100, 
			align: 'left',
            sortable: true 
          },{
            header: "Auction/Sale",
            dataIndex: 'as_name',
            width: 70, 
			align: 'left',
            sortable: true 
          },{
            header: "Minprice",
            dataIndex: 'minprice',
            width: 80, 
			align: 'left',
            sortable: true 
          },{
            header: "Maxprice",
            dataIndex: 'maxprice',
            width: 80, 
			align: 'left',
            sortable: true 
          },{
            header: "Address",
            dataIndex: 'full_address',
            width: 200, 
			align: 'left',
            sortable: true 
          },{
            header: "Bed room",
            dataIndex: 'bedroom_value',
            width: 60, 
			align: 'left',
            sortable: true 
          },{
            header: "Bath room",
            dataIndex: 'bathroom_value',
            width: 60, 
			align: 'left',
            sortable: true 
          },{
            header: "Car space",
            dataIndex: 'car_space_value',
            width: 60, 
			align: 'left',
            sortable: true 
          },{
            header: "Car port",
            dataIndex: 'car_port_value',
            width: 60, 
			align: 'left',
            sortable: true 
          },{
            header: "Land size min",
            dataIndex: 'land_size_min',
            width: 60, 
			align: 'left',
            sortable: true 
          },{
            header: "Land size max",
            dataIndex: 'land_size_max',
            width: 60,
			align: 'left',
            sortable: true
          },{
            header: "Unit",
            dataIndex: 'unit',
            width: 60,
			align: 'left',
            sortable: true
          }*/
        ],
        viewConfig: {
                    forceFit : true,
                    enableRowBody : true,
                    showPreview : true,
                    getRowClass : function(rec, rowIndex, p, store){
                        var str = '<p class="grid_expand1" style="margin-left:65px">';

                        //str += '<i>';
                        str += '<span>Auction/Sale: '+rec.data.as_name + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Type : '+rec.data.type_name + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Minprice : '+rec.data.minprice + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Maxprice : '+rec.data.maxprice + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Bedroom : '+rec.data.bedroom_value + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Bathroom : '+rec.data.bathroom_value + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Car space : '+rec.data.car_space_value + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Car port : '+rec.data.car_port_value + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Land size min : '+rec.data.land_size_min + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Land size max : '+rec.data.land_size_max + '</span>';
                        str += '<span>|</span>';
                        str += '<span>Unit : '+rec.data.unit + '</span>';

                        str += '</p>';
                        str += '<p class="grid_expand1" style="margin-left:65px">';
                        str += '<span>Address : '+rec.data.full_address + '</span>';
                        str += '</p>';

                        p.body = str;
                        return rowIndex % 2 ? 'x-grid3-row-expanded' : 'x-grid3-row-expanded-ord';
                    },
                    stripeRows: true
                },

         
        // paging bar on the bottom
        bbar : new Ext.PagingToolbar({
            pageSize : 20,
            store : store_alert,
            displayInfo : true,
            displayMsg : 'Displaying topics {0} - {1} of {2}',
            emptyMsg : "No topics to display",
            plugins : [new Ext.ux.plugin.PagingToolbarResizer( {options : [ 20, 50, 100, 200 ], prependCombo: true})]
        })
    });
   /* var grid_send = new Ext.grid.GridPanel({
        renderTo:'email-send',
		width:335,
        height:500,
        title:'Report Total Email System Send ',
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
                align: 'left',
                sortable: true
            },
            {
                header: "Email Sent",
                dataIndex: 'number',
                width: 200,
                align: 'center',
                sortable: true
            }],
            viewConfig: {
                forceFit : true,
                enableRowBody : true,
                showPreview : true,
                getRowClass : function(rec, rowIndex, p, store){
                    return rec.data.name == '<span style="font-weight: bold;">Total Email send</span>' ? 'x-grid3-row-expanded-sum' : 'x-grid3-row-expanded';
                },
                stripeRows: true
            }
    });

    store_send.load({params:{start:0, limit:20}});
    grid_send.render();*/
    grid.render();
    store_alert.load({params:{start:0, limit:20,property_id :10}});


});

 