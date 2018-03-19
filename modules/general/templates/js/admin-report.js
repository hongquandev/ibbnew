$(document).ready(function() {
     $("#tabs").tabs({
         show: function(event, ui) {
             switch (ui.index){
                 case 1:
                    var chartPage = new Highcharts.Chart({
                        chart: {renderTo: 'tabs-1',defaultSeriesType: 'column'},
                        title: {text: 'Page Views Report'},
                        subtitle: {text: 'bidRhino.com'},
                        xAxis: {
                        },
                        yAxis: {min: 0,title: {text: ''}},
                        tooltip: {formatter: function() {
                                                return ''+this.series.name +': '+ this.y +' views';
                                             }
                        },
                        plotOptions: {
                            bar: {
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        },
                        legend: {layout: 'vertical', backgroundColor: '#FFFFFF', align: 'right',verticalAlign: 'top',x: 0,y: -10,floating: true, shadow: true},
                        credits: {enabled: false},
                        series: dataPage
                    });
                    break;
                 case 2:
                    var chartBanner = new Highcharts.Chart({
                        chart: {renderTo: 'tabs-2',defaultSeriesType: 'column'},
                        series: dataBanner,
                        title: {text: 'Top 15 Most Views Banner'},
                        subtitle: {text: 'bidRhino.com'},
                        xAxis: {/*categories: categories*/},
                        yAxis: {min: 0,title: {text: 'List banner'}},
                        tooltip: {formatter: function() {return ''+this.series.name +': '+ this.y +' views number';}},
                        plotOptions: {

                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            backgroundColor: '#FFFFFF',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -20,
                            y: 10,
                            floating: true,
                            shadow: true

                        },

                        credits: {
                            enabled: false
                        }
                    });
                    break;
                 case 3:
                    var chartAgent = new Highcharts.Chart({
                       chart: {renderTo: 'tabs-3',plotBackgroundColor: null,plotBorderWidth: null,plotShadow: false },
                       title: {text: 'Members Report'},
                       subtitle: {text: 'bidRhino.com '},
                       tooltip: {formatter: function() {
                                                   return '<b>'+ this.point.name +'</b>: '+ this.y +'members'
                                            }
                       },
                       legend: {layout: 'vertical',align: 'left',verticalAlign: 'top',x: 11, y: -10,floating: true,shadow: true},
                       plotOptions: {
                           pie: {
                               allowPointSelect: true,
                               cursor: 'pointer',
                               dataLabels: {
                                       enabled: true,
                                       color: '#000000',
                                       connectorColor: '#000000',
                                       formatter: function() {
                                           return '<b>'+ this.point.name +'</b>: '+ this.y +'members'
                                       }
                               },
                               showInLegend: true
                           }
                       }
                   });
                    chartAgent.addSeries({ type: 'pie',name: 'Agent',data: eval(dataAgent)}, true)
                    break;
                 case 4:
                    /*var chartBid = new Highcharts.Chart({
                        chart: {renderTo: 'tabs-4',plotBackgroundColor: null,plotBorderWidth: null,plotShadow: false},
                        title: {text: 'Property Bidding Report '},
                        subtitle: {text: 'bidRhino.com'},
                        tooltip: {formatter: function() {
                                              return '<b>'+ this.point.name +'</b>: '+ this.y +' bids';
                                             }
                                 },
                        legend: {layout: 'vertical',align: 'right',verticalAlign: 'top',x: 10,y: 10,floating: true,shadow: true },
                        plotOptions: {
                                pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            color: '#000000',
                                            connectorColor: '#000000',
                                            formatter: function() {
                                                return '<b>'+ this.point.name +'</b>: '+ this.y +'';
                                            }
                                        },
                                        showInLegend: true
                                    }
                        }
                    });
                    chartBid.addSeries({type: 'pie',name: 'Bids',data: eval(dataBids)}, true );*/
                    var chartBids = new Highcharts.Chart({
                          chart: {renderTo: 'tabs-4',defaultSeriesType: 'column', margin: [ 50, 50, 100, 80]},
                          title: {text: 'Bids report of live auction properties'},
                          subtitle: {text: 'bidRhino.com'},
                          xAxis: {
                             categories: categoriesBids,
                             labels: {rotation: -45,align: 'right',style: {font: 'normal 13px Verdana, sans-serif'}
                             }
                          },
                          yAxis: {
                             min: 0,
                             title: {
                                text: 'Bids number'
                             }
                          },
                          legend: {
                             enabled: false
                          },
                          tooltip: {
                             formatter: function() {
                                return '<b>'+ this.x +'</b><br/>'+
                                    'Bids: '+ Highcharts.numberFormat(this.y, 1);
                             }
                          },
                          series: [{
                             name: 'Bids',
                             data: dataBids,
                             dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                x: -3,
                                y: 10,
                                formatter: function() {
                                   return this.y;
                                },
                                style: {
                                   font: 'normal 13px Verdana, sans-serif'
                                }
                             }
                          }]
                       });
             
                    break;
                 case 5:
                    var chartSold = new Highcharts.Chart({
		                chart: {renderTo: 'tabs-5',plotBackgroundColor: null,plotBorderWidth: null,plotShadow: false},
		                title: {text: 'Sold Properties Report'},
		                subtitle: {text: 'bidRhino.com'},
		                tooltip: {formatter: function() {
					                return '<b>'+ this.point.name +'</b>: ' + 'sold ' + this.y ;
			                        }
		                },
		                legend: {layout: 'vertical',align: 'right',verticalAlign: 'top',x: 10,y: 10,floating: true,shadow: true},
		                plotOptions: {
                            pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        color: '#000000',
                                        connectorColor: '#000000',
                                        formatter: function() {
                                                return '<b>'+ this.point.name +'</b>: '+ this.y +' properties';
                                        }
                                    },
                                    showInLegend: true
                                  }
		                }

	                });
		            chartSold.addSeries({type: 'pie',name: 'Sold',data: eval(dataSold)}, true );

                 case 0:
                    var chartNew = new Highcharts.Chart({
                        chart: {renderTo: 'tabs-6',plotBackgroundColor: null,plotBorderWidth: null,plotShadow: false},
                        title: {text: 'New Properties Registration Today'},
                        subtitle: {text: 'bidRhino.com'},
                        tooltip: {formatter: function() {
                                                return '<b>'+ this.point.name +'</b>: ' + '' + this.y ;
                                             }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -15,
                            y: 70,
                            floating: true,
                            shadow: true

                        },
                        plotOptions: {
                            pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    dataLabels: {
                                        enabled: true,
                                        color: '#000000',
                                        connectorColor: '#000000',
                                formatter: function() {
                                    return '<b>'+ this.point.name +'</b>: '+ this.y +' properties'

                                }
                                    },
                                    showInLegend: true
                                }
                        }
                       });
                    chartNew.addSeries({type: 'pie',name: 'New',data: eval(dataNew)}, true );
                    break;

             }
         }
     });

});

