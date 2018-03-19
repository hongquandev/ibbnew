
var chart_monthly = null;
var chart_daily = null;
var chart_weekly = null;
var chart_yearly = null;
var d = new Date();
var curr_date = d.getDate();
var curr_month = d.getMonth() + 1;
var curr_month_name = Date.monthNames[curr_month -1];
var curr_year = d.getFullYear();
/*var monthMask = null;
var yearMask = null;
var weekMask = null;
var dayMask = null;*/
Ext.onReady(function () {
    // BEGIN MONTHLY
    {

        var sold_passedin_filter_monthly = new Ext.form.ComboBox({
            store:new Ext.data.ArrayStore({
                autoDestroy:true,
                fields:['value', 'title'],
                data:[
                    ['sold', 'SOLD'],
                    ['all', 'Sold and Passed in'],
                    ['passedin', 'Passed In']
                ]
            }),
            displayField:'title',
            valueField:'value',
            typeAhead:true,
            mode:'local',
            forceSelection:true,
            triggerAction:'all',
            emptyText:'Select type... ',
            selectOnFocus:false,
            width:135,
            id:'cmdSoldPassedin_monthly',
            iconCls:'no-icon',
            listeners:{
                select:function (sold_passedin_filter_monthly, value) {
                    monthly(combo_year_monthly.getValue(), sold_passedin_filter_monthly.getValue());
                }
            }
        });
        /*Filter by year*/
        var filter_store_monthly = new Ext.data.JsonStore({
            root:'data',
            fields:['value', 'title'],
            method:"POST",
            url:session.option_year
        });
        filter_store_monthly.load({params:{year:curr_year}});
        var combo_year_monthly = new Ext.form.ComboBox({
            width:110,
            store:filter_store_monthly,
            valueField:'value',
            displayField:'title',
            mode:'local',
            hideTrigger:false,
            triggerAction:'all',
            emptyText:'Select Year...',
            selectOnFocus:true,
            id:'cmbYearFilter',
            listeners:{
                select:function (combo_year_monthly, value) {
                    monthly(combo_year_monthly.getValue(), sold_passedin_filter_monthly.getValue());
                }
            }
        });
        /*End*/
        new Ext.Panel({
            width:800,
            height:400,
            renderTo:'monthly-chart',
            //plugins: [new Ext.ux.plugin.VisibilityMode()],
            title:'Monthly Sold - Passed In Report',
            tbar:[
                {
                    text:'    '
                },
                combo_year_monthly,
                '->',
                sold_passedin_filter_monthly
            ],
            html:'<div id="graph-monthly" class="graph"></div>'
        });

        function monthly_chart(data, filter) {
            jQuery('#graph-monthly').html('');
            var myChart = new JSChart('graph-monthly', 'bar', 'f61b1a3df6065e242b1350f23e3df44e,c79c24b11a5fa131e5f3af9de0a95721');
            myChart.setDataArray(data);
            myChart.setTitle('Monthly Report');
            myChart.setTitleColor('#8E8E8E');
            myChart.setAxisNameX('');
            myChart.setAxisNameY('');
            myChart.setAxisNameFontSize(16);
            myChart.setAxisNameColor('#999');
            myChart.setAxisValuesAngle(30);
            myChart.setAxisValuesColor('#777');
            myChart.setAxisColor('#B5B5B5');
            myChart.setAxisWidth(1);
            myChart.setBarValuesColor('#656662');
            myChart.setAxisPaddingTop(60);
            myChart.setAxisPaddingBottom(60);
            myChart.setAxisPaddingLeft(45);
            myChart.setTitleFontSize(11);
            myChart.setBarColor('#A70000', 1);
            myChart.setBarColor('#FBE000', 2);
            myChart.setBarBorderWidth(0);
            myChart.setBarSpacingRatio(50);
            myChart.setBarOpacity(0.9);
            myChart.setFlagRadius(6);
            myChart.setLegendShow(true);
            myChart.setLegendPosition('top right');
            if (filter == 'all') {
                myChart.setLegendForBar(1, 'Sold');
                myChart.setLegendForBar(2, 'Passed In');
                /*myChart.setBarColor('#A70000', 1);
                myChart.setBarColor('#FBE000', 2);*/
                myChart.setBarColor('#2D6B96', 1);
                myChart.setBarColor('#9CCEF0', 2);

            } else {
                if (filter == 'sold') {
                    myChart.setLegendForBar(1, 'Sold');
                    myChart.setBarColor('#2D6B96', 1);
                } else {
                    myChart.setLegendForBar(1, 'Passed In');
                    myChart.setBarColor('#9CCEF0', 1);
                }
            }
            myChart.setSize(800, 360);
            myChart.setGridColor('#C6C6C6');
            chart_monthly = myChart;
            myChart.draw();
        }

        function monthly(year, filter) {
            if (filter == null || filter == "") {
                filter = 'all'
            }
            par = new Object();
            par.year = year;
            par.filter = filter;
            monthMask.show();
            jQuery.post(session.monthly_link, par, function (data) {
                monthMask.hide();
                var datajson = jQuery.parseJSON(data);
                var ar = new Array();
                for (var i in datajson.data) {
                    if (typeof datajson.data[i].month != 'undefined') {
                        var month_ = datajson.data[i].month;
                        if (filter == 'all') {
                            ar.push([month_.toString(), datajson.data[i].sold, datajson.data[i].passed]);
                        } else {
                            if (filter == 'sold') {
                                ar.push([month_.toString(), datajson.data[i].sold]);
                            } else {
                                ar.push([month_.toString(), datajson.data[i].passed]);
                            }
                        }
                    }
                }
                monthly_chart(ar, filter);
            }, 'html')
        }

        var monthMask = new Ext.LoadMask(Ext.get('graph-monthly'), {msg:"Please wait..."});
        monthly(curr_year, 'all');
    }
    // END Monthly

    // BEGIN YEARLY
    {
        var sold_passedin_filter_yearly = new Ext.form.ComboBox({
            store:new Ext.data.ArrayStore({
                autoDestroy:true,
                fields:['value', 'title'],
                data:[
                    ['sold', 'Sold'],
                    ['all', 'Sold And Passed In'],
                    ['passedin', 'Passed In']
                ]
            }),
            displayField:'title',
            valueField:'value',
            typeAhead:true,
            mode:'local',
            forceSelection:true,
            triggerAction:'all',
            emptyText:'Select Type...',
            selectOnFocus:true,
            width:135,
            id:'cmdSoldPassedin_yearly',
            iconCls:'no-icon',
            listeners:{
                select:function (sold_passedin_filter_yearly, value) {
                    yearly(sold_passedin_filter_yearly.getValue());
                }
            }
        });
        new Ext.Panel({
            width:1140 - 800,
            height:400,
            renderTo:'yearly-chart',
            title:'Yearly Sold - Passed In Report',
            tbar:[
                {
                    text:'    '
                },
                '->',
                sold_passedin_filter_yearly
            ],
            html:'<div id="graph-yearly" class="graph"></div>'
        });
        function yearly_chart(data, filter) {
            jQuery('#graph-yearly').html('');
            var myChart = new JSChart('graph-yearly', 'bar', 'f61b1a3df6065e242b1350f23e3df44e,c79c24b11a5fa131e5f3af9de0a95721');
            myChart.setDataArray(data);
            myChart.setTitle('Yearly Report');
            myChart.setTitleColor('#8E8E8E');
            myChart.setAxisNameX('');
            myChart.setAxisNameY('');
            myChart.setAxisNameFontSize(16);
            myChart.setAxisNameColor('#999');
            myChart.setAxisValuesAngle(30);
            myChart.setAxisValuesColor('#777');
            myChart.setAxisColor('#B5B5B5');
            myChart.setAxisWidth(1);
            myChart.setBarValuesColor('#2F6D99');
            myChart.setAxisPaddingTop(60);
            myChart.setAxisPaddingBottom(60);
            myChart.setAxisPaddingLeft(45);
            myChart.setTitleFontSize(11);
            //myChart.setBarColor('#2D6B96', 1);
            //myChart.setBarColor('#9CCEF0', 2);
            myChart.setBarBorderWidth(0);
            myChart.setBarSpacingRatio(50);
            myChart.setBarOpacity(0.9);
            myChart.setFlagRadius(6);
            myChart.setTooltipPosition('nw');
            myChart.setTooltipOffset(3);
            myChart.setLegendShow(true);
            myChart.setLegendPosition('top right');
            if (filter == 'all') {
                /*myChart.setBarColor('#009f3c', 1);
                myChart.setBarColor('#e8641b', 2);*/
                myChart.setBarColor('#2D6B96', 1);
                myChart.setBarColor('#9CCEF0', 2);
                myChart.setLegendForBar(1, 'Sold');
                myChart.setLegendForBar(2, 'Passed In');
            } else {
                if (filter == 'sold') {
                    myChart.setBarColor('#2D6B96', 1);
                    myChart.setLegendForBar(1, 'Sold');
                } else {
                    myChart.setBarColor('#9CCEF0', 1);
                    myChart.setLegendForBar(1, 'Passed In');
                }
            }
            myChart.setSize(1140 - 800, 370);
            myChart.setGridColor('#C6C6C6');
            myChart.draw();
        }

        function yearly(filter) {
            par = new Object();
            if (filter == null || filter == "") {
                filter = 'all'
            }
            par.filter = filter;
            yearMask.show();
            jQuery.post(session.yearly_link, par, function (data) {
                yearMask.hide();
                var datajson = jQuery.parseJSON(data);
                var ar = new Array();
                for (var i in datajson.data) {
                    if (typeof datajson.data[i].year != 'undefined') {
                        var year_ = datajson.data[i].year;
                        if (filter == 'all') {
                            ar.push([year_.toString(), datajson.data[i].sold, datajson.data[i].passed]);
                        } else {
                            if (filter == 'sold') {
                                ar.push([year_.toString(), datajson.data[i].sold]);
                            } else {
                                ar.push([year_.toString(), datajson.data[i].passed]);
                            }
                        }
                    }
                }
                yearly_chart(ar, filter);
            }, 'html')
        }

        var yearMask = new Ext.LoadMask(Ext.get('graph-yearly'), {msg:"Please wait..."});
        yearly('all');
    }
    //END YEARLY

    // BEGIN WEEKLY
    {
        /*Filter by Weekly - Year*/
        var filter_store_weekly_year = new Ext.data.JsonStore({
            root:'data',
            fields:['value', 'title'],
            method:"POST",
            url:session.option_year
        });
        filter_store_weekly_year.load({params:{start:0, limit:20}});
        var combo_weekly_year = new Ext.form.ComboBox({
            width:75,
            store:filter_store_weekly_year,
            valueField:'value',
            displayField:'title',
            mode:'local',
            hideTrigger:false,
            triggerAction:'all',
            emptyText:'Year...',
            selectOnFocus:true,
            id:'cmbWeeklyYearFilter',
            listeners:{
                select:function (combo, value) {
                    weekly(combo_weekly_year.getValue(), combo_weekly_month.getValue(), sold_passedin_filter_weekly.getValue());
                }
            }
        });

        /*Filter by Weekly - Monthly*/
        var combo_weekly_month = new Ext.form.ComboBox({
            width:110,
            store:new Ext.data.ArrayStore({
                autoDestroy:true,
                fields:['value', 'title'],
                data:generateMonthData()
            }),
            valueField:'value',
            displayField:'title',
            mode:'local',
            hideTrigger:false,
            triggerAction:'all',
            emptyText:'Select Month...',
            selectOnFocus:true,
            id:'cmbWeeklyMonthFilter',
            listeners:{
                select:function (combo, value) {
                    weekly(combo_weekly_year.getValue(), combo_weekly_month.getValue(), sold_passedin_filter_weekly.getValue());
                }
            }
        });
        var sold_passedin_filter_weekly = new Ext.form.ComboBox({
            store:new Ext.data.ArrayStore({
                autoDestroy:true,
                fields:['value', 'title'],
                data:[
                    ['sold', 'SOLD'],
                    ['all', "Sold And Passed In"],
                    ['passedin', 'Passed In']
                ]
            }),
            displayField:'title',
            valueField:'value',
            typeAhead:true,
            mode:'local',
            forceSelection:true,
            triggerAction:'all',
            emptyText:'Select Type...',
            selectOnFocus:true,
            width:135,
            id:'cmdSoldPassedin_weekly',
            iconCls:'no-icon',
            listeners:{
                select:function (combo, value) {
                    weekly(combo_weekly_year.getValue(), combo_weekly_month.getValue(), sold_passedin_filter_weekly.getValue());
                }
            }
        });
        /*End*/
        new Ext.Panel({
            width:1140 - 800,
            height:400,
            renderTo:'weekly-chart',
            plugins:[new Ext.ux.plugin.VisibilityMode()],
            title:'Weekly Sold - Passed In Report',
            html:'<div id="graph-weekly" class="graph"></div>',
            tbar:[
                {
                    text:'    '
                },
                combo_weekly_year,
                '-',
                combo_weekly_month,
                '->',
                sold_passedin_filter_weekly
            ]
        });
        function weekly_chart(data, filter) {
            jQuery('#graph-weekly').html('');
            var myChart = new JSChart('graph-weekly', 'bar', 'f61b1a3df6065e242b1350f23e3df44e,c79c24b11a5fa131e5f3af9de0a95721');
            myChart.setDataArray(data);
            myChart.setTitle('Weekly Report');
            myChart.setTitleColor('#8E8E8E');
            myChart.setAxisNameX('Weekly');
            myChart.setAxisNameY('');
            myChart.setAxisNameFontSize(16);
            myChart.setAxisNameColor('#999');
            myChart.setAxisValuesAngle(30);
            myChart.setAxisValuesColor('#777');
            myChart.setAxisColor('#B5B5B5');
            myChart.setAxisWidth(1);
            myChart.setBarValuesColor('#2F6D99');
            myChart.setAxisPaddingTop(60);
            myChart.setAxisPaddingBottom(60);
            myChart.setAxisPaddingLeft(45);
            myChart.setTitleFontSize(11);
            myChart.setBarBorderWidth(0);
            myChart.setBarSpacingRatio(50);
            myChart.setBarOpacity(0.9);
            myChart.setFlagRadius(6);
            myChart.setTooltipPosition('nw');
            myChart.setTooltipOffset(3);
            myChart.setLegendShow(true);
            myChart.setLegendPosition('top right');
            myChart.setBarColor('#0cd659', 1);
            myChart.setBarColor('#e0e00d', 2);
            if (filter == 'all') {
                myChart.setLegendForBar(1, 'Sold');
                myChart.setLegendForBar(2, 'Passed In');
                /*myChart.setBarColor('#0cd659', 1);
                myChart.setBarColor('#e0e00d', 2);*/
                myChart.setBarColor('#2D6B96', 1);
                myChart.setBarColor('#9CCEF0', 2);
            } else {
                if (filter == 'sold') {
                    myChart.setBarColor('#2D6B96', 1);
                    myChart.setLegendForBar(1, 'Sold');
                } else {
                    myChart.setBarColor('#9CCEF0', 1);
                    myChart.setLegendForBar(1, 'Passed In');
                }
            }

            myChart.setSize(1140 - 800, 370);
            myChart.setGridColor('#C6C6C6');
            myChart.draw();
        }

        function weekly(year, mothly, filter) {
            if (filter == null || filter == "") {
                filter = 'all'
            }
            par = new Object();
            par.year = year;
            par.month = mothly;
            par.filter = filter;
            weekMask.show();
            jQuery.post(session.weekly_link, par, function (data) {
                weekMask.hide();
                var datajson = jQuery.parseJSON(data);
                var ar = new Array();
                for (var i in datajson.data) {
                    if (typeof datajson.data[i].week != 'undefined') {
                        var week_ = datajson.data[i].week;
                        if (filter == 'all') {
                            ar.push([week_.toString(), datajson.data[i].sold, datajson.data[i].passed]);
                        } else {
                            if (filter == 'sold') {
                                ar.push([week_.toString(), datajson.data[i].sold]);
                            } else {
                                ar.push([week_.toString(), datajson.data[i].passed]);
                            }
                        }
                    }
                }
                weekly_chart(ar, filter);
            }, 'html')
        }

        var weekMask = new Ext.LoadMask(Ext.get('graph-weekly'), {msg:"Please wait..."});
        weekly(curr_year, curr_month, 'all');
    }
    // END Weekly

    // BEGIN DAILY
    {
        /*Filter by Weekly - Year*/
        var filter_store_daily_year = new Ext.data.JsonStore({
            root:'data',
            fields:['value', 'title'],
            method:"POST",
            url:session.option_year
        });
        filter_store_daily_year.load({params:{start:0, limit:20}});
        var combo_daily_year = new Ext.form.ComboBox({
            width:110,
            store:filter_store_daily_year,
            valueField:'value',
            displayField:'title',
            mode:'local',
            hideTrigger:false,
            triggerAction:'all',
            emptyText:'Select Year...',
            selectOnFocus:true,
            id:'cmbDailyYearFilter',
            listeners:{
                select:function (combo, value) {
                    daily(combo_daily_year.getValue(), combo_daily_month.getValue(), sold_passedin_filter_daily.getValue());
                }
            }
        });
        /*Filter by Weekly - Monthly*/
        var combo_daily_month = new Ext.form.ComboBox({
            width:110,
            store:new Ext.data.ArrayStore({
                autoDestroy:true,
                fields:['value', 'title'],
                data:generateMonthData()
            }),
            valueField:'value',
            displayField:'title',
            mode:'local',
            hideTrigger:false,
            triggerAction:'all',
            emptyText:'Select Month...',
            selectOnFocus:true,
            id:'cmbDailyMonthFilter',
            listeners:{
                select:function (combo, value) {
                    daily(combo_daily_year.getValue(), combo_daily_month.getValue(), sold_passedin_filter_daily.getValue());
                }
            }
        });
        /*End*/
        var sold_passedin_filter_daily = new Ext.form.ComboBox({
            store:new Ext.data.ArrayStore({
                autoDestroy:true,
                fields:['value', 'title'],
                data:[
                    ['all', 'Sold and Passed In'],
                    ['sold', 'Sold'],
                    ['passedin', 'Passed In']
                ]
            }),
            displayField:'title',
            valueField:'value',
            typeAhead:true,
            mode:'local',
            forceSelection:true,
            triggerAction:'all',
            emptyText:'Select Type...',
            selectOnFocus:true,
            width:135,
            id:'cmdSoldPassedin_daily',
            iconCls:'no-icon',
            listeners:{
                select:function (combo, value) {
                    daily(combo_daily_year.getValue(), combo_daily_month.getValue(), sold_passedin_filter_daily.getValue());
                }
            }
        });
        new Ext.Panel({
            width:800,
            plugins:[new Ext.ux.plugin.VisibilityMode()],
            defaults:{ hideMode:!Ext.isIE && !Ext.isSafari ? 'offsets' : 'display', animCollapse:false },
            height:400,
            renderTo:'daily-chart',
            title:'Daily Sold - Passed In Report',
            html:'<div id="graph-daily" class="graph"></div>',
            tbar:[
                {
                    text:'    '
                },
                combo_daily_year,
                '  ',
                combo_daily_month,
                '->',
                sold_passedin_filter_daily
            ]
        });
        function daily_chart(data, filter) {
            var myChart = new JSChart('graph-daily', 'bar', 'f61b1a3df6065e242b1350f23e3df44e,c79c24b11a5fa131e5f3af9de0a95721');
            myChart.setDataArray(data);
            myChart.setTitle('Daily Report');
            myChart.setTitleColor('#8E8E8E');
            myChart.setAxisNameX('');
            myChart.setAxisNameY('');
            myChart.setAxisNameFontSize(16);
            myChart.setAxisNameColor('#999');
            myChart.setAxisValuesAngle(30);
            myChart.setAxisValuesColor('#777');
            myChart.setAxisColor('#B5B5B5');
            myChart.setAxisWidth(1);
            myChart.setBarValuesColor('#2F6D99');
            myChart.setAxisPaddingTop(60);
            myChart.setAxisPaddingBottom(60);
            myChart.setAxisPaddingLeft(45);
            myChart.setTitleFontSize(11);
            myChart.setBarBorderWidth(0);
            myChart.setBarSpacingRatio(50);
            myChart.setBarOpacity(0.9);
            myChart.setFlagRadius(6);
            myChart.setTooltipPosition('nw');
            myChart.setTooltipOffset(3);
            myChart.setLegendShow(true);
            myChart.setLegendPosition('top');
            if (filter == 'all') {
                myChart.setBarColor('#2D6B96', 1);
                myChart.setBarColor('#9CCEF0', 2);
                /*myChart.setBarColor('#A70000', 1);
                myChart.setBarColor('#FBE000', 2);*/
                myChart.setLegendForBar(1, 'Sold');
                myChart.setLegendForBar(2, 'Passed In');
            } else {
                if (filter == 'sold') {
                    myChart.setBarColor('#2D6B96', 1);
                    myChart.setLegendForBar(1, 'Sold');
                } else {
                    myChart.setBarColor('#9CCEF0', 1);
                    myChart.setLegendForBar(1, 'Passed In');
                }
            }
            myChart.setSize(800, 365);
            myChart.setGridColor('#C6C6C6');
            myChart.draw();
        }

        function daily(year, month, filter) {
            dayMask.show();
            par = new Object();
            par.year = year;
            par.month = month;
            if (filter == null || filter == "") {
                filter = 'all'
            }
            par.filter = filter;
            jQuery.post(session.daily_link, par, function (data) {
                dayMask.hide();
                var datajson = jQuery.parseJSON(data);
                var ar = new Array();
                for (var i in datajson.data) {
                    if (typeof datajson.data[i].day != 'undefined') {
                        var year_ = datajson.data[i].day;
                        if (filter == 'all') {
                            ar.push([year_.toString(), datajson.data[i].sold, datajson.data[i].passed]);
                        } else {
                            if (filter == 'sold') {
                                ar.push([year_.toString(), datajson.data[i].sold]);
                            } else {
                                ar.push([year_.toString(), datajson.data[i].passed]);
                            }
                        }
                    }
                }
                daily_chart(ar, filter);
            }, 'html')
        }

        var dayMask = new Ext.LoadMask(Ext.get('graph-daily'), {msg:"Please wait..."});
        daily(curr_year, curr_month, 'all');
    }
    // END DAILY

    // Remove Img
    setInterval("closeimg_()",1000);
});

function closeimg_(){
    jQuery('img','.graph').each(function(){
        if(jQuery(this).attr("width") == 77){
            jQuery(this).hide();
        }
    });
}
function generateMonthData() {
    var data = [];
    for (var i = 0; i < 12; ++i) {
        data.push([i+1,Date.monthNames[i]]);
    }
    return data;
}
