<?php 
	include_once ROOTPATH.'/modules/property/inc/property.php';

    $rows = $property_cls->getRows('SELECT peo.title,count(pro.property_id) as count
                                 FROM '.$property_cls->getTable().' AS pro
                                 INNER JOIN '.$property_entity_option_cls->getTable().' AS peo
                                 ON pro.type = peo.property_entity_option_id
                                 WHERE pro.confirm_sold = 1
                                 GROUP BY peo.title',true);
	$data = array();
	$ar1 = PEO_getOptions('property_type');
	$ar2 = PEO_getOptions('property_type_commercial');								   
	
	if (count($ar1) > 0) {
		foreach ($ar1 as $k => $v) {
			$data[$v] = 0;
		}
	}
	
	if (count($ar2) > 0) {
		foreach ($ar2 as $k => $v) {
			$data[$v] = 0;
		}
	}
	$data_str = '';							 
	if (is_array($rows) and count($rows)>0) {
		foreach ($rows as $row) {
            //$data[] = "['{$row['title']}',{$row['count']}]";
			$data[$row['title']] = $row['count'];
		}
	}
?>

<script type="text/javascript">
   //var dataSold = [<?php echo $data_str; ?>]
<?php 
$str = 'var dataSold = [';
foreach ($data as $k => $v) {
	$str .= '[\''.$k.'\','.$v.'],';
}
$str .= '];';
echo $str;
?>
   
</script> 	<!-- End Chart Statistics Combinations Type Properties Sell With Month -->
