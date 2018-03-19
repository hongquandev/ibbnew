<?php
include_once 'inc/calendar.php';
include_once ROOTPATH.'/modules/general/inc/ics.class.php';


if (!isset($ics_cls) || !($ics_cls instanceof ICS)) {
	$ics_cls = new ICS();
}

$action = getParam('action');

switch ($action) {
	
	case 'export-calendar':
		$calendar_id = restrictArgs(getParam('calendar_id',0));
		if ($calendar_id > 0) {
			$row = $calendar_cls->getRow('calendar_id = '.$calendar_id);
			if (is_array($row) && count($row) > 0) {
				$file_name = $row['calendar_id'].'_calendar.ics';
				header('Content-Type: text/calendar; charset=utf-8');
				header('Content-Description: File Transfer');
				header('Content-Disposition: attachment; filename="'.$file_name.'"');
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');

				
				header('Content-Disposition: attachment; filename="'.$file_name.'";');				
				ob_clean();
				flush();
				
				$address = '';
				$property_row = $property_cls->getRow('SELECT pro.property_id, pro.address, pro.price, pro.suburb, pro.postcode, pro.auction_sale ,
															pro.agent_id, pro.description , pro.stop_bid,
														(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
														(SELECT reg2.code FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
														(SELECT reg3.name FROM '.$region_cls->getTable().' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
														(SELECT reg4.code FROM '.$region_cls->getTable().' AS reg4 WHERE reg4.region_id = pro.country) AS country_code
													FROM '.$property_cls->getTable()." AS pro
													WHERE pro.property_id = ".$row['property_id'],true);
					
				if (is_array($property_row) && count($property_row) > 0) {
					$address = $property_row['address'].' '.$property_row['suburb'].' '.$property_row['postcode'].' '.$property_row['state_name'].' '.$property_row['country_name'];
				}
				
				$location = str_replace('{address}',$address,$config_cls->getKey('calendar_location'));
				$title = str_replace('{address}',$address,$config_cls->getKey('calendar_summary'));
				$description = str_replace('{address}',$address,$config_cls->getKey('calendar_description'));
				
				$data = array('dtstart' => preg_replace('/[-:]/','',str_replace(' ','T',$row['begin'])).'Z',
							'dtend' => preg_replace('/[-:]/','',str_replace(' ','T',$row['end'])).'Z',
							'title' => $title,
							'description' => $description,
							'location' => $location);
				echo $ics_cls->getLayout($data);
				exit();
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