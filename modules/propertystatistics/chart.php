<?php 
		/* 
			Author  : Steven Duc. 
			Company : Global OutSource Solution.
			Website : gos.com.vn.
			Email   : duc@gos.com.vn.
		*/
		require '../../configs/config.inc.php';
		require '../../includes/smarty/Smarty.class.php';
                require_once '../../includes/functions.php';
		$smarty = new Smarty;  
		 if(detectBrowserMobile()){ 
                    $smarty->compile_dir = ROOTPATH.'/m.templates_c/';
                }else{
                    $smarty->compile_dir = ROOTPATH.'/templates_c/';
                }
?>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="jslang/highcharts.js"></script>
        <script type="text/javascript" src="jslang/jquery.js"></script>
        <script type="text/javascript" src="jslang/jquery.simplemodal.js"></script>
        <script type="text/javascript" src="jslang/osx.js"></script>
        <link type='text/css' href='templates/css/css.css' rel='stylesheet' media='screen' />
        <link type='text/css' href='templates/css/osx.css' rel='stylesheet' media='screen' />

<?php 
		$dates = date('m');
		$sql = "Select po2.title as t,
				(Select sum(pro.stop_bid)
					from property_entity as pro inner join property_entity_option AS po2
						on pro.type = po2.property_entity_option_id 
							Where po2.title = 'House' and month(end_time) = '$dates') as t1,
				(Select sum(pro.stop_bid)  
					from property_entity as pro inner join property_entity_option AS po2
						on pro.type = po2.property_entity_option_id 
							Where po2.title = 'Flat' and month(end_time) = '$dates') as t2,
				(Select sum(pro.stop_bid)  
					from property_entity as pro inner join property_entity_option AS po2
						on pro.type = po2.property_entity_option_id 
							Where po2.title = 'Apartment' and month(end_time) = '$dates') as t3,
				(Select sum(pro.stop_bid)  
					from property_entity as pro inner join property_entity_option AS po2
						on pro.type = po2.property_entity_option_id 
							Where po2.title = 'Land estate' and month(end_time) = '$dates') as t4			
					from property_entity as pro inner join property_entity_option AS po2
						on pro.type = po2.property_entity_option_id Where Month(end_time) = '$dates' group by po2.title,  pro.stop_bid having pro.stop_bid >= 1 ";
	
		$result = mysql_query($sql);
		
		while ($row = mysql_fetch_array($result))
		{
			$data[] = array('type' =>'pie'  , 'data' => array((int)$row['t1'] , (int)$row['t2']));
			if ($row['t'] == 'House') {
				$title1 = $row['t'];
			}
			if ($row['t'] == 'Flat') {
				$title2 = $row['t'];
			}
			if ($row['t'] == 'Apartment') {
				$title3 = $row['t'];
			}
			if ($row['t'] == 'Land estate') {
				$title4 = $row['t'];
			}
			
			$row1 = (int)$row['t1'];
			$row2 = (int)$row['t2'];
			$row3 = (int)$row['t3'];
			$row4 = (int)$row['t4'];

		}
?>
 		
	
			<script type="text/javascript">
			
				var chart;
				$(document).ready(function() {
					chart = new Highcharts.Chart({
						chart: {
									renderTo: 'clayout1',
									plotBackgroundColor: null,
									plotBorderWidth: null,
									plotShadow: false
						},
						title: {
									text: ' <p style="color:#84B8D9; font-weight:bold "> Statistics Combinations Type Property Sell In Month '
							 
						},
						 subtitle: {
                            text: 'bidRhino.com '
                        },
						tooltip: {
							formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ this.y +' sales';
							}
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
									return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
								}
									},
									showInLegend: true
								}
						},
							
					   })
					   
					var data = [['<?php echo $title1 ?>' , <?php echo $row1 ?> ], ['<?php echo $title2 ?>' , <?php echo $row2 ?>]
								,['<?php echo $title3 ?>' , <?php echo $row3 ?>], ['<?php echo $title4 ?>' , <?php echo $row4 ?>]];        
						
						chart.options.title.text = 'Source Chart';   
						chart.addSeries(
											{
										   type: 'pie',
										   name: 'Browser share',
										   data: eval(data)
										}, true );
						chart.redraw();
						chart.updatePosition();
				
			});
			
     	   </script> 	<!-- End Chart Statistics Combinations Type Properties Sale With Month -->
    	
		<!-- Render Action Report Chart Statistics Combinations Type Properties Sale With Month -->
     <div id='logo'>  
     	 <h1 align="center">Analyze <span> Report </span> </h1>
     </div>
		<div id="clayout1" style="width: 700px; height: 580px; float:right; padding-right:100px;  margin: 30px auto"> </div>    

	<div id='container'>
		<div id='logo'>
			<span class='title' style="color:#84B8D9; font-weight:bold; font-size:16px;"> Statistics Report </span>
		</div>
	<div id='content'>
		<div id='osx-modal'>
        	<ul>
          	  <li> <a href='#' class='osx'>  Reports Statistics Property  Bad </a> </li>
              <li> <a href='#' class='osx2'> Statistics Compares Property Sell In Month  </a> </li>
              <li> <a href='#' class='osx3'> Statistics Profit Per Month </a> </li>                      
            </ul>     
		</div>

    <div id="osx-modal-content">	
		<!-- modal content -->
		<div id="osx-modal-content">
			<div id="osx-modal-title">Inspect Bid Buy Modal Dialog</div>
			<div class="close"><a href="#" class="simplemodal-close">x</a></div> 
			<div id="osx-modal-data">
                     
<?php 
		$dates = date('m');
	    $sql = "select a.property_id, 
					(select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 1
					) as t1, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 2
					) as t2, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 3
					) as t3, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 4
					) as t4,
				(select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 5
					) as t5, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 6
					) as t6, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 7
					) as t7, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 8
					) as t8, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 9
					) as t9, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 10
					) as t10, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 11
					) as t11, (select count(a.property_id) as Sum from property_entity as a 
				,bids as b where 
							a.property_id != b.property_id and Month(end_time) = 12
					) as t12  from property_entity as a ,bids as b 
				where a.property_id != b.property_id group by b.property_id ";
																
		$result = mysql_query($sql);
	
		while ($row = mysql_fetch_array($result))
		{
			$datass[] = array('data' => array((int)$row['t1'] , (int)$row['t2'], (int)$row['t3'] ,(int)$row['t4'],
											  (int)$row['t5'], (int)$row['t6'], (int)$row['t7'], (int)$row['t8'], (int)$row['t9'], (int)$row['t10'],
											  (int)$row['t11'], (int)$row['t12'] ));
		}	
?>
 
			<script type="text/javascript">
		
				var chart;
				$(document).ready(function() {
					chart = new Highcharts.Chart({
						chart: {
							renderTo: 'ct',
							defaultSeriesType: 'column',
							margin: [ 50, 50, 100, 80]
						},
						title: {
							text: ' <p style="color:#84B8D9; font-weight:bold "> Reports Statistics Property  Bad '
						},
					    subtitle: {
                            text: 'bidRhino.com'
                        },	
						xAxis: {
							categories: [
								'January', 
								'February', 
								'March', 
								'April', 
								'May',
								'June',
								'July',
								'August',
								'September',
								'October',
								'November',
								'December'						
							],
							labels: {
								rotation: -45,
								align: 'right',
								style: {
									 font: 'normal 13px Verdana, sans-serif'
								}
							}
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Monthly Statistics Bid'
							}
						},
						legend: {
							enabled: false
						},
						tooltip: {
							formatter: function() {
								return '<b>'+ this.x +'</b><br/>'+
									 'Statistics in month: ' + Highcharts.numberFormat(this.y, 1) +
									 ' not bid';
							}
						},
						plotOptions: {
							column: {
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
								}
						},
								
							series: 
							<?php echo json_encode($datass) ?>
					});
					
					
				});
			
     	   </script>
           
					<div id="ct" style="width: 700px; height: 600px; margin: 0 auto"> </div>
			</div>
		</div>

	
		<!-- modal content -->
		<div id="osx-modal-content2">
			<div id="osx-modal-title">Inspect Bid Buy Modal Dialog </div>
			<div class="close"><a href="#" class="simplemodal-close">x</a></div>
			<div id="osx-modal-data2">
				            
<?php 
		$dates = date('m');			
		// Count Property Sell & Compare Property sell with property not sell In Month 
		 $sql = "select sum(stop_bid) as Sales,
						(select count(stop_bid) as NotBid from property_entity where stop_bid = 0 and Month(end_time) = '$dates') as NotSales
							from property_entity where Month(end_time) = '$dates'"; 	
													
		$result = mysql_query($sql);
	
		while ($row = mysql_fetch_array($result))
		{
			$sales = $row['Sales'];
			$notsales = $row['NotSales'];
		}
?>

			<script type="text/javascript">
			
				var chart;
				$(document).ready(function() {
					chart = new Highcharts.Chart({
						chart: {
									renderTo: 'ct2',
									plotBackgroundColor: null,
									plotBorderWidth: null,
									plotShadow: false
						},
						title: {
									text: ' <p style="color:#84B8D9; font-weight:bold ">  Statistics Compares Properties Sell In Month '				
						},
						 subtitle: {
                            text: 'bidRhino.com'
                        },
						tooltip: {
							formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ this.y +' sales';
							}
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
									return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
								}
									},
									
								}
						},
							
					   })
					   
						var data = [['<?php echo 'Sales' ?>' , <?php echo $sales ?>], ['<?php echo 'Not Sales'?>' , <?php echo $notsales ?>]];        
						
						chart.options.title.text = 'Source Chart';   
						chart.addSeries(
											{
										   type: 'pie',
										   name: 'Browser share',
										   data: eval(data)
										}, true );
						chart.redraw();
						chart.updatePosition();
				
			});
			
     	   </script> 
    	
				<!-- Render Action Report Chart Statistics Combinations Type Properties Sale With Month -->
				<div id="ct2" style="width: 650px; height: 600px; margin: 0 auto"> </div>
			</div>
		</div>

		<!-- modal content -->
		<div id="osx-modal-content3">
			<div id="osx-modal-title">Inspect Bid Buy Modal Dialog </div>
			<div class="close"><a href="#" class="simplemodal-close">x</a></div>
			<div id="osx-modal-data3">
				   
<?php 
		$dates = date('m');			
		
		$sql = "SELECT stop_bid,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 1  and stop_bid = 1) as Month1,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 2  and stop_bid = 1) as Month2,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 3  and stop_bid = 1) as Month3,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 4  and stop_bid = 1) as Month4,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 5  and stop_bid = 1) as Month5,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 6  and stop_bid = 1) as Month6,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 7  and stop_bid = 1) as Month7,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 8  and stop_bid = 1) as Month8,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 9  and stop_bid = 1) as Month9,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 10 and stop_bid = 1) as Month10,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 11 and stop_bid = 1) as Month11,
								(SELECT sum(price) from property_entity WHERE Month(end_time) = 12 and stop_bid = 1) as Month12
				 				 FROM property_entity GROUP BY stop_bid HAVING stop_bid = 1"; 	
													
		$result = mysql_query($sql);
	
		while ($row = mysql_fetch_array($result))
		{
				$dataprice[] = array('data' => 	array((int)$row['Month1'], (int)$row['Month2'], (int)$row['Month3'], (int)$row['Month4'],
											 	  (int)$row['Month5'], (int)$row['Month6'], (int)$row['Month7'], (int)$row['Month8'],
											 	  (int)$row['Month9'], (int)$row['Month10'], (int)$row['Month11'], (int)$row['Month12']));
				$dataLabels = array('enabled' =>true, 'rotation' => -90, 'x' => -3, 'y' => '10');							
										
		}
?>
			<script type="text/javascript">
            
                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'ct3',
                            defaultSeriesType: 'column',
                            margin: [ 50, 50, 100, 80]
                        },
                        title: {
                            text: '<p style="color:#84B8D9; font-weight:bold "> Statistics Profit Per Month '
                        },
					    subtitle: {
                            text: 'bidRhino.com'
                        },
                        xAxis: {
                            categories: [
                              'January', 
								'February', 
								'March', 
								'April', 
								'May',
								'June',
								'July',
								'August',
								'September',
								'October',
								'November',
								'December'		
                            ],
                            labels: {
                                rotation: -45,
                                align: 'right',
                                style: {
                                     font: 'normal 13px Verdana, sans-serif'
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Profit Per Month'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            formatter: function() {
                                return '<b>'+ this.x +'</b><br/>'+
                                     'Profit per month: '+ Highcharts.numberFormat(this.y, 1) +
                                     ' dollar';
                            }
                        },
						plotOptions: {
							column: {
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
								}
						},
							
                         series: 
								<?php echo json_encode($dataprice) ?>	
				});				
			});
                    
            </script>
				<!-- Render Action Report Chart Statistics Combinations Type Properties Sale With Month -->
				<div id="ct3" style="width: 700px; height: 600px; margin: 0 auto"> </div>
			</div>
		</div>