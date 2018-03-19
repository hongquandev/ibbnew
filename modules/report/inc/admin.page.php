<?php
include_once ROOTPATH.'/modules/property/inc/property.php';

$smarty->assign('daily',date($config_cls->getKey('general_date_format')));
$smarty->assign('weekly',beginWeek($config_cls->getKey('general_date_format')).' - '.endWeek($config_cls->getKey('general_date_format')));
$smarty->assign('monthly',beginMonth($config_cls->getKey('general_date_format')).' - '.endMonth($config_cls->getKey('general_date_format')));
$smarty->assign('yearly',date('Y'));

?>