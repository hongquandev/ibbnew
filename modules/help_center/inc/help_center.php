<?php
/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 8:36 AM
 *
 */
include_once 'help_center.class.php';
include_once 'help_cat.class.php';

if (!isset($help_cls) || !($help_cls instanceof Help_center)) {
	$help_cls = new Help_center();
}

if (!isset($cat_cls) || !($cat_cls instanceof Help_cat)) {
	$cat_cls = new Help_cat();
}

function HC_getCategory(){
    global $cat_cls;
    $options = array();
    $rows = $cat_cls->getRows('');
    foreach ($rows as $row){
        $options[$row['catID']] = $row['title'];
    }
    return $options;
}
?>