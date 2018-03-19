<?php
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/package/inc/package.php';

$option_country_ar = R_getOptions(0);

$option_country_str = '';
if (is_array($option_country_ar) & count($option_country_ar) > 0) {
	foreach ($option_country_ar as $key=>$val) {
		$selected = $key==COUNTRY_DEFAULT? 'selected' : '';
		$option_country_str .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
	}
}


//BEGIN PROPERTY NEW

    $rows = $property_cls->getRows('SELECT pe.title,count(*) as count
                                   FROM '.$property_cls->getTable().' AS pro
                                   INNER JOIN '.$property_entity_option_cls->getTable().' AS pe
                                   ON pro.type = pe.property_entity_option_id
                                   WHERE pro.pay_status IN ('.Property::PAY_PENDING.','.Property::PAY_COMPLETE.') AND pro.creation_date = \''.date('Y-m-d').'\'
                                   GROUP BY pe.title',true);
    $new = array();
    $sum = 0;
    if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $key=>$row) {
            $sum = $sum + $row['count'];
            $new[] = array('name'=>$row['title'],
                           'number'=>$row['count']);
        }
        $new[] = array('name'=>'<b>Total Property</b>',
                   'number'=>$sum);
	}else{
        $new[] = array('name'=>'No new property.');
    }


//END

//BEGIN PROPERTY SOLD
    $rows = array();
    $rows = $property_cls->getRows('SELECT pe.title,count(*) as count
                                   FROM '.$property_cls->getTable().' AS pro
                                   INNER JOIN '.$property_entity_option_cls->getTable().' AS pe
                                   ON pro.type = pe.property_entity_option_id
                                   WHERE pro.confirm_sold = 1 AND pro.creation_date = \''.date('Y-m-d').'\'
                                   GROUP BY pe.title',true);
    $sold = array();
    $sum = 0;
    if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $key=>$row) {
            $sum = $sum + $row['count'];
            $sold[] = array('name'=>$row['title'],
                           'number'=>$row['count']);
        }
        $sold[] = array('name'=>'<b>Total Property</b>',
                   'number'=>$sum);
	}else{
        $sold[] = array('name'=>'No property.');
    }


//END

//BEGIN PROPERTY PACKAGE

    $rows = $property_cls->getRows('SELECT package_id,
                                           COUNT(package_id) AS count
                                   FROM '.$property_cls->getTable().' AS pro
                                   WHERE pro.pay_status IN ('.Property::PAY_PENDING.','.Property::PAY_COMPLETE.') AND pro.creation_date = \''.date('Y-m-d').'\'
                                   GROUP BY package_id',true);
    $package = array();
    $total = 0;
    if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $key=>$row) {
          if (PA_getPackage($row['package_id']) != null){
              $package[] = array('name'=>PA_getPackage($row['package_id']),
                                 'number'=>$row['count']);
              $total += $row['count'];
          }
	    }
        $package[] = array('name'=>'<b>Total Property</b>',
                           'number'=>$total);
	}else{
        $package[] = array('name'=>'No property.');
    }

//END
$smarty->assign('property_new',$new);
$smarty->assign('property_sold',$sold);
$smarty->assign('property_package',$package);
$smarty->assign('option_country_str',$option_country_str);

?>