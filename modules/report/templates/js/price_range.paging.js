/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */
var store = null;
var chart;
Ext.onReady(function(){

    // create the Data Store
    store = new Ext.data.JsonStore({
 		root: 'topics',
        totalProperty: 'totalCount',
        idProperty: 'report_id',
        remoteSort: true,
        fields: [
            'state',
            'price_range',
            'property_number',
            'percent'
        ],

        // load using script tags for cross domain, if the data in on the same domain as
        // this page, an HttpProxy would be better
        proxy: new Ext.data.HttpProxy({
            url: session.action_link.replace('[1]','list-price_range')
        })
    });
    store.setDefaultSort('report_id', 'DESC');


    //COMBO STATE
    var state_store = new Ext.data.JsonStore({
            //autoLoad:true,
            root:'data',
            fields:['value','title'],
            method:"POST",
            url:session.action_link.replace('[1]','list-region&ot=state')
        })
    var state = new Ext.form.ComboBox({
        width:140,
        store: state_store,
        valueField:'value',
        displayField:'title',
        mode:'local',
        hideTrigger:false,
        triggerAction: 'all',
        emptyText:'Select a state...',
        selectOnFocus:false,
        listeners:{
            select:function(combo, value) {
               store_chart.reload({params:{start:0, limit:20, state:combo.value}});
              /* if (combo.value == 0){
                   barChart.destroy();
                   chart.render('container');
               }else {
                   chart.destroy();
                   barChart.render('container');
               }*/
               //chart.setSubTitle(value);
               store.reload({params:{start:0, limit:20,state:combo.value}});
               //main.doLayout();
            }
        }
    });

    //COMBO COUNTRY
    var country_store = new Ext.data.JsonStore({
            //autoLoad:true,
            root:'data',
            fields:['value','title'],
            method:"POST",
            url:session.action_link.replace('[1]','list-region&ot=country')
        })
    var country = new Ext.form.ComboBox({
        width:80,
        store: country_store
        ,valueField:'value'
        ,displayField:'title',
        hideTrigger:false,
        triggerAction: 'all',
        emptyText:'Select a country...',
        selectOnFocus:true,
        mode:'local'
    });
    state_store.load({params:{start:0, limit:20}});
    //country_store.load({params:{start:0, limit:20}});

    var grid = new Ext.grid.GridPanel({
        renderTo:'topic-grid',
		width:340,
        height:500,
        title:'Price Range',
        store: store,
        trackMouseOver:false,
        disableSelection:true,
        loadMask: true,
        //frame: true,
        // grid columns
        columns:[
          {
			header: "Price range",
            dataIndex: 'price_range',
            width: 80,
			align: 'left',
			sortable: true 
		  },{   
			header: "Property number",
            dataIndex: 'property_number',
            width: 50,
			align: 'center',
			sortable: true 
		  },{   
			header: "%",
            dataIndex: 'percent',
            width: 30,
			align: 'right'	
		  }],
        viewConfig: {
            forceFit : true,
            enableRowBody : true,
            showPreview : true,
            getRowClass : function(rec, rowIndex, p, store){
                return rowIndex % 2   == 0?'x-grid3-row-expanded':'x-grid3-row-expanded-ord';
            },
			stripeRows: true
        },
        tbar:['->','State',state]
    });

    // render it
    grid.render();
    // trigger the data store load
    store.load({params:{start:0, limit:20,state:0}});


//HIGHCHART
    var store_chart = new Ext.data.JsonStore({
        root: 'chart',
        //autoLoad : true,
        proxy: new Ext.data.HttpProxy({
                    url: session.action_link.replace('[1]','list-range')
                }),
        fields: ['name','y']
     });
    store_chart.load({params:{start:0, limit:20,state:0}});

    chart = new Ext.ux.HighChart({
      store: store_chart,
      series: [{
         type: 'pie',
         name: 'Test',
         categorieField: 'name',
         dataField: 'y'
       }],
       chartConfig: {
           chart: {
                 //renderTo: 'container',
                 plotBackgroundColor: null,
                 plotBorderWidth: null,
                 plotShadow: false,
                 margin: [80, 150, 0, 80]
              },
              title: {
                 text: 'iBB Price Range'
              },
              subtitle: {
                 text: 'bidRhino.com'
              },

              tooltip: {
                     formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2)+' %'
                 }
              },

              plotOptions: {
                 pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    showInLegend: false
                 }

              },
              legend:{
                layout: 'vertical',
                style: {
                    left: 'auto',
                    bottom: 'auto',
                    right: '10px',
                    top: '10px'
                }
              },
              credits: {enabled: false}
       }
   });

/*chart = new Ext.ux.HighChart({
      store: store_chart,
      series: [{
         type: 'pie',
         name: 'Test',
         categorieField: 'name',
         dataField: 'y'
       }],
       chartConfig: {
           chart: {
                 //renderTo: 'container',
                 plotBackgroundColor: null,
                 plotBorderWidth: null,
                 plotShadow: true,
                 margin: [50, 250, 60, 80]
              },
              title: {
                 text: 'iBB Price Range'
              },
              subtitle: {
                 text: 'bidRhino.com'
              },

              tooltip: {
                     formatter: function() {
                        return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2)+' % '+this.y+' properties'
                 }
              },

              plotOptions: {
                 pie: {
                    allowPointSelect: true,
                    cursor: 'pointer'
                    *//*dataLabels: {
                       enabled: true,
                       color: '#000000',
                       connectorColor: '#000000',
                       formatter: function() {
                          return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(2) +' %';
                       }
                    }*//*
                 }
              },
              legend:{
                layout: 'vertical',
                style: {
                    left: 'auto',
                    bottom: 'auto',
                    right: '10px',
                    top: 'auto'
                }
              },
              credits: {enabled: false}
       }
   });*/
     
/*var barChart = new Ext.ux.HighChart({
      store: store_chart,
      series: [{
         dataField:'name',
         categorieField: 'y',
         yField: 'y'

       }],
       chartConfig: {
           chart: {
                 //renderTo: 'container',
                 plotBackgroundColor: null,
                 plotBorderWidth: null,
                 //plotShadow: true,
                 margin: [100, 30, 30, 150],
                 defaultSeriesType: 'bar'
              },
              title: {
                 text: 'iBB Price Range'
              },
              subtitle: {
                 text: 'bidRhino.com'
              },

              tooltip: {
                     formatter: function() {
                        return '<b>'+this.x+'</b>: '+this.y+' properties';
                 }
              },
              yAxis: {
                 min: 0,
                 title: {
                    text: 'Property',
                    align: 'high'
                 }
              },
             xAxis: {
                 field: [],
                 title: {
                    text: 'Price range'
                 }
              },
              plotOptions: {
                bar: {
                    dataLabels: {
                       enabled: true
                    }
                }
              },
              legend:{
                enabled:false
              },
              credits: {enabled: false}
       }
   });*/
   //chart.render('container');
   var main = new Ext.Panel({
    title:'iBB Chart',
    renderTo:'container',
    width:800,
    height:500,
    items: [chart]
   });
    main.show();
});


