<?php
$form_data = array();
//FOR LIVABILITY RATING
$options = array();
$livability_ratings = $rating_cls->getRows("parent_id = (SELECT b.rating_id FROM ".$rating_cls->getTable()." AS b WHERE b.code='livability_rating')");

if (is_array($livability_ratings) and count($livability_ratings)>0) {
	foreach ($livability_ratings as $row) {
		$options[$row['rating_id']] = $rating_cls->getOptionsByParentCode($row['code']);
		$form_data[$row['rating_id']] = 0;
	}
}

$smarty->assign('livability_ratings',$livability_ratings);
//END

//FOR GREEN RATING
$green_ratings = $rating_cls->getRows("parent_id = (SELECT b.rating_id FROM ".$rating_cls->getTable()." AS b WHERE b.code = 'green_rating')");

if (is_array($green_ratings) and count($green_ratings)>0) {
	foreach ($green_ratings as $row) {
		$options[$row['rating_id']] = $rating_cls->getOptionsByParentCode($row['code']);
		$form_data[$row['rating_id']] = 0;
	}
}
$smarty->assign('green_ratings',$green_ratings);
//END


$smarty->assign('options',$options);

$auction_arr = PEO_getAuctionSale();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (is_array(@$_POST['fields']) and count(@$_POST['fields'])>0) {

		foreach ($form_data as $key => $val) {
			if (isset($_POST['fields'][$key])) {
				$form_data[$key] = $_POST['fields'][$key];
			}
		}
		
		$str = '';
		foreach ($form_data as $key => $val) {
			$row = $property_rating_cls->getRow("property_id = ".$property_id." AND rating_parent_id = ".$key);
			$val = $property_rating_cls->escape($val);
			if (is_array($row) and count($row) > 0) {//FOR UPDATING
				$property_rating_cls->update(array('rating_id' => $val),'property_id = '.$property_id.' AND rating_parent_id = '.$key);
				
				// Write Logs					
				$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
						 'Action' => 'UPDATE',
						 'Detail' => "UPDATE PROPERTY RATINGS ID :". $property_id, 
						 'UserID' => $_SESSION['Admin']['EmailAddress'],
						 'IPAddress' =>$_SERVER['REMOTE_ADDR']
						  ));
								  
						
			} else {//FOR INSERTING
			
				$property_rating_cls->insert(array('property_id' => $property_id,
													'rating_parent_id' => $key,
													'rating_id' => $val,
													'active' => 1));

                if($row['auction_sale'] == $auction_arr['private_sale'])
                {
                    $property_cls->update(array('pay_status' => Property::PAY_COMPLETE),'property_id='.$property_id);
                }
				// Write Logs					
				$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
						 'Action' => 'INSERT',
						 'Detail' => "ADD PROPERTY RATINGS ID :". $property_id, 
						 'UserID' => $_SESSION['Admin']['EmailAddress'],
						 'IPAddress' =>$_SERVER['REMOTE_ADDR']
						  ));
															
			}
			
			if ($property_rating_cls->hasError()) {
				break;
			}
		}
		
		if (is_array($row) and count($row) > 0) { //FOR UPDATING
				// Write Logs					
				$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
						 'Action' => 'UPDATE',
						 'Detail' => "UPDATE PROPERTY RATINGS ID :". $property_id, 
						 'UserID' => $_SESSION['Admin']['EmailAddress'],
						 'IPAddress' =>$_SERVER['REMOTE_ADDR']
						  ));

			} else {//FOR INSERTING
				
				// Write Logs					
				$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
						 'Action' => 'INSERT',
						 'Detail' => "ADD PROPERTY RATINGS ID :". $property_id, 
						 'UserID' => $_SESSION['Admin']['EmailAddress'],
						 'IPAddress' =>$_SERVER['REMOTE_ADDR']
						  ));
															
			}
		
		
		if ($property_rating_cls->hasError()) {
			$message = 'Error during inserting/updating.';
		} else {
			$livability_mark = PRM_getRatingMark('livability_rating',$property_id);
			$green_mark = PRM_getRatingMark('green_rating',$property_id);

			$row = $property_rating_mark_cls->getRow('property_id = '.$property_id);
			if ($property_rating_mark_cls->hasError()) {
			
			} else if (is_array($row) and count($row) > 0) {
				//FOR UPDATING
				
				$property_rating_mark_cls->update(array('livability_rating_mark' => $livability_mark,
															'green_rating_mark' => $green_mark),
													'property_id = '.$property_id);
													
			} else {
				//FOR INSERTING
				$property_rating_mark_cls->insert(array('property_id' => $property_id,
														'livability_rating_mark' => $livability_mark,
														'green_rating_mark' => $green_mark));
			}
			
			$message = 'Added / Edited successful.';
			$auction_arr = PEO_getAuctionSale();
            $row = $property_cls->getRow('property_id = '.$property_id);
			if ($_POST['next'] == 1) {
                if ($row['auction_sale'] == $auction_arr['private_sale']){//sale

                   redirect(ROOTURL.'/admin/?module='.$module.'&action=list&token='.$token);
                }else{//auction
                   redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-term&property_id='.$property_id.'&token='.$token);
                }
				//redirect(ROOTURL.'/admin/?module='.$module.'&action=edit-term&property_id='.$property_id.'&token='.$token);
			}
		}
	}
	
} else {//FOR GET,BACK

	//TO SHOW TO FORM FIELD
	$rows = $property_rating_cls->getRows('property_id='.$property_id);
	if (is_array($rows) and count($rows)>0) {
		foreach ($rows as $row) {
			if (isset($form_data[$row['rating_parent_id']])) {
				$form_data[$row['rating_parent_id']] = $row['rating_id'];
			}
		}
	}
}


$smarty->assign('form_data',$form_data);
?>