<script type="text/javascript" src="../modules/general/templates/js/jquery.min.js"></script>
<script type="text/javascript" src="../modules/general/templates/js/highcharts.src.js"></script>

<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';

/*$option_country_ar = R_getOptions(0);

$option_country_str = '';
if (is_array($option_country_ar) & count($option_country_ar) > 0) {
	foreach ($option_country_ar as $key=>$val) {
		$selected = $key==COUNTRY_DEFAULT? 'selected' : '';
		$option_country_str .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
	}
}*/

$smarty->assign('option_country_str',R_reportCountry());
$smarty->assign('option_state_str',R_reportState());
?>
<?php
	include_once ROOTPATH.'/modules/general/inc/regions.php';
		include_once ROOTPATH.'/modules/property/inc/property.php';
		
		$start = (int)restrictArgs(getParam('start',0));
		$limit = (int)restrictArgs(getParam('limit',20));
		$sort_by = getParam('sort','pro.property_id');
		$dir = getParam('dir','ASC');	
		
		$date_begin = trim(getParam('date_begin'));
		$date_end = trim(getParam('date_end'));
		
		//BEGIN		
		$range_ar = array();
		$option_ar = optionsPrice();
		unset($option_ar[0]);
		
		$before = array();
		$data = array();
		foreach ($option_ar as $key => $val) {
			if (count($before) > 0) {
				list($_key,$_val) = each($before);
				$range_ar[] = array('min' => array($_key => $_val),'max' => array($key => $val));
			} else {
				$range_ar[] = array('min' => array(0 => '$0'),'max' => array($key => $val));
			}
			$before = array($key => $val);
		}
		list($_key,$_val) = each($before);
		$range_ar[] = array('min' => array($_key => $_val),'max' => array(0 => '>'));
		//END
		$total = 0;
		$topics = array();
		
		
		$region_rows = $region_cls->getRows('parent_id ='.COUNTRY_DEFAULT);
		$row = $property_cls->getRow('SELECT COUNT(*) AS num
					FROM '.$property_cls->getTable().' AS pro
					WHERE pro.country = '.COUNTRY_DEFAULT,true);
		$_num = 1;
		if (is_array($row) && count($row) > 0 && $row['num'] > 0) {
			$_num = $row['num'];			
		}
		
		if (is_array($region_rows) && count($region_rows) > 0) {
			foreach ($region_rows as $region_row) {
				$_row = array('state' => '<div class="col_special" style="padding:4px 0px 4px 10px">'.$region_row['name'].'</div>',
								'price_range' => '',
								'percent' => '');
				$topics[] = $_row;
				$total++;
			
				
				foreach ($range_ar as $item_ar) {
					list($min_key,$min_val) = each($item_ar['min']);
					list($max_key,$max_val) = each($item_ar['max']);
					
					$wh_str = '';
					if ($min_key > 0) {
						$wh_str .= ' AND pro.price > '.$min_key;
					}
					
					if ($max_key > 0) {
						$wh_str .= ' AND pro.price <= '.$max_key;
					}
					
					$row = $property_cls->getRow('SELECT COUNT(pro.property_id) AS num
								FROM '.$property_cls->getTable().' AS pro
								WHERE pro.state = '.$region_row['region_id'].$wh_str,true);
					
					$__num = 0;
					if (is_array($row) && count($row) > 0 && $row['num'] > 0) {

						$__num = $row['num'];
					}
					
					$_row = array('state' => '',
									'price_range' => $min_val.' - '.$max_val,
									'property_number' => $__num,
									'percent' => number_format(($__num*100)/$_num,2).'%');
									
					$pri_range = 'ABCDTEST';	
					$data[] = array('name' => 'DUCMINH' , 'data' => number_format(($__num*100)/$_num,2) );
					$topics[] = $_row;
					
				}
			}
		}
		
?>

<!-- DUC CODING SHOW CHART PRICE RANGE -->
<script type="text/javascript">
var chart;
$(document).ready(function() {
	chart = new Highcharts.Chart({
		chart: {
			renderTo: 'tab-pricerange',
			defaultSeriesType: 'column'
		},
		title: {
			  text: 'Report View Price Range Property'
		},
		subtitle: {
			 text: 'bidRhino.com'
		},
		xAxis: {
			
			title: {
				text: null
			}
		},
		yAxis: {
			min: 0,
			title: {
				text: ''
				//align: 'high'
			}
		},
		 tooltip: {
            formatter: function() {
                return ''+
                     this.series.name +': '+ this.y +' views';
            }
        },
		plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },       
		legend: {
			layout: 'vertical',
			backgroundColor: '#FFFFFF',
			align: 'right',
			verticalAlign: 'top',
			x: 0,
			y: 35,
			floating: true,
			shadow: true		
		},
		credits: {
			enabled: false
		},
		series:
			<?php echo json_encode($data) ?>
	});		
});
</script>
