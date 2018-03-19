/*!
 * Ext JS Library 3.4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
function generateData() {
    var data = [];
    for (var i = 0; i < 12; ++i) {
        data.push([Date.monthNames[i], 123]);
    }
    return data;
}

Ext.onReady(function () {

    var store = new Ext.data.ArrayStore({
        fields:['month', 'hits'],
        data:generateData()
    });

    var combo = new Ext.form.ComboBox({
        store:new Ext.data.ArrayStore({
            autoDestroy:true,
            fields:['initials', 'fullname'],
            data:[
                ['FF', 'Fred Flintstone'],
                ['BR', 'Barney Rubble']
            ]
        }),
        displayField:'fullname',
        typeAhead:true,
        mode:'local',
        forceSelection:true,
        triggerAction:'all',
        emptyText:'Select a name...',
        selectOnFocus:true,
        width:135,
        getListParent:function () {
            return this.el.up('.x-menu');
        },
        iconCls:'no-icon' //use iconCls if placing within menu to shift to right side of menu
    });

    var tb = new Ext.Toolbar({
        renderTo:document.body,
        width:600,
        height:50,
        items:[
            {
                // xtype: 'button', // default for Toolbars, same as 'tbbutton'
                text:'Button'
            },
            {
                xtype:'splitbutton', // same as 'tbsplitbutton'
                text:'Split Button'
            },
            // begin using the right-justified button container
            '->',
            // same as {xtype: 'tbfill'}, // Ext.Toolbar.Fill
            {
                xtype:'textfield',
                name:'field1',
                emptyText:'enter search term'
            },
            // add a vertical separator bar between toolbar items
            '-',
            // same as {xtype: 'tbseparator'} to create Ext.Toolbar.Separator
            'text 1',
            // same as {xtype: 'tbtext', text: 'text1'} to create Ext.Toolbar.TextItem
            {xtype:'tbspacer'},
            // same as ' ' to create Ext.Toolbar.Spacer
            'text 2',
            {xtype:'tbspacer', width:50},
            // add a 50px space
            'text 3'
        ]
    });
    // put ComboBox in a Menu

// add a Button with the menu
    tb.add(combo);
    //tb.doLayout();
    new Ext.Panel({
        width:700,
        height:400,
        renderTo:document.body,
        title:'Column Chart with Reload - Hits per Month',
        tbar:[
            {
                text:'Load new data set',
                handler:function () {
                    store.loadData(generateData());
                }
            }

        ],
        items:{
            xtype:'columnchart',
            store:store,
            yField:'hits',
            url:session.chart,
            xField:'month',
            xAxis:new Ext.chart.CategoryAxis({
                title:'Month'
            }),
            yAxis:new Ext.chart.NumericAxis({
                title:'Hits'
            }),
            extraStyle:{
                xAxis:{
                    labelRotation:-90
                }
            }
        }
    });
});
