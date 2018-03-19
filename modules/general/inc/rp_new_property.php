<?php 
	include_once ROOTPATH.'/modules/property/inc/property.php';
	include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
    //nh edit
    $rows = $property_cls->getRows('SELECT pe.title,count(*) as count
                                   FROM '.$property_cls->getTable().' AS pro
                                   INNER JOIN '.$property_entity_option_cls->getTable().' AS pe
                                   ON pro.type = pe.property_entity_option_id
                                   WHERE pro.pay_status IN ('.Property::PAY_PENDING.','.Property::PAY_COMPLETE.') AND pro.creation_date = \''.date('Y-m-d').'\'
                                   GROUP BY pe.title',true);
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

if (is_array($rows) and count($rows)>0) {
	foreach ($rows as $row)
	{	
        $data[$row['title']] = $row['count'];
	}

}
?>

<script type="text/javascript">
<?php 
$str = 'var dataNew = [';
foreach ($data as $k => $v) {
	$str .= '[\''.$k.'\','.$v.'],';
}
$str .= '];';
echo $str;
?>
</script> 	<!-- End Chart Statistics Combinations Type Properties Sell With Month -->
