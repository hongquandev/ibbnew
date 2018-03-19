<?php
include_once '../../configs/config.inc.php';
include_once ROOTPATH.'/includes/functions.php';
include_once ROOTPATH.'/modules/property/inc/property.class.php';
if (!isset($property_cls) || !($property_cls instanceof Property)) {
	$property_cls = new Property();
}

$action = getParam('action');

switch ($action) {
	case 'rating':
		$rows = $property_cls->getRows();
		
		if (is_array($rows) && count($rows) > 0) {
			foreach ($rows as $row) {
				$r_row = $property_cls->getRow('SELECT livability_rating_mark,
															green_rating_mark 
												     FROM '.$property_cls->getTable('property_rating_mark').' 
													 WHERE property_id = '.$row['property_id'], true);
												 
				if (is_array($r_row) && count($r_row) > 0) {									 
					$property_cls->update(array('livability_rating_mark' => $r_row['livability_rating_mark'], 
											'green_rating_mark' => $r_row['green_rating_mark']),'property_id = '.$row['property_id']);
					echo $property_cls->sql;					
				}							
			}
		}
	break;
    default:
        Report_pageRemove(Report_parseUrl());
        //redirect(ROOTURL.'/notfound.html');
		redirect('/notfound.html');
        break;

}
?>