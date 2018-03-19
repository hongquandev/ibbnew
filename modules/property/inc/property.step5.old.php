<?php
$form_data = array();
$step = (int)getParam('step',0);

$options = array();
$livability_ratings = $rating_cls->getRows("parent_id = (SELECT b.rating_id FROM ".$rating_cls->getTable()." AS b WHERE b.code = 'livability_rating')");
$green_ratings = $rating_cls->getRows("parent_id = (SELECT b.rating_id FROM ".$rating_cls->getTable()." AS b WHERE b.code = 'green_rating')");

if (is_array($livability_ratings) && count($livability_ratings) > 0) {
	foreach ($livability_ratings as $row) {
	
		$property_rating_cls->addValid(array('field' => $row['rating_id'], 'label' => $row['title'], 'fnc' => array('isInt' => null)));
									
		$options[$row['rating_id']] = $rating_cls->getOptionsByParentCode($row['code']);
		$form_data[$row['rating_id']] = 0;
	}
}

if (is_array($green_ratings) && count($green_ratings) > 0) {
	foreach ($green_ratings as $row) {
		$options[$row['rating_id']] = $rating_cls->getOptionsByParentCode($row['code']);
		$form_data[$row['rating_id']] = 0;
	}
}

$smarty->assign(array('green_ratings' => $green_ratings,
			'livability_ratings' => $livability_ratings,
			'options' => $options));


if (isSubmit()) {
	$data = getPost('fields');
	if (is_array($data) && count($data) > 0) {

		foreach ($form_data as $key => $val) {
			if (isset($data[$key])) {
				$form_data[$key] = $data[$key];
			}
		}
		
		try {
			if (!$property_rating_cls->isValid($data)) {
				throw new Exception(implode("<br/>",$property_rating_cls->getErrorsValid()));
			}
			//print_r($form_data);die();
			foreach ($form_data as $key => $val) {
				$val = $property_rating_cls->escape($val);
				$row = $property_rating_cls->getRow("property_id = ".$_SESSION['property']['id']." AND rating_parent_id = ".$key);
				if (is_array($row) && count($row) > 0) {//FOR UPDATING
					$property_rating_cls->update(array('rating_id' => $val),
												'property_id = '.$_SESSION['property']['id'].' 
												AND rating_parent_id = '.$key);
				} else {//FOR INSERTING
					$property_rating_cls->insert(array('property_id' => $_SESSION['property']['id'],
												'rating_parent_id' => $key,
												'rating_id' => $val,
												'active' => 1));
				}
				
				if ($property_rating_cls->hasError()) {
					throw new Exception('Error during inserting/updating.');
				}
			}
			
			$livability_mark = PRM_getRatingMark('livability_rating', $_SESSION['property']['id']);
			$green_mark = PRM_getRatingMark('green_rating', $_SESSION['property']['id']);
			
			/*
			$row = $property_rating_mark_cls->getRow('property_id = '.$_SESSION['property']['id']);
			
			if ($property_rating_mark_cls->hasError()) {
				throw new Exception('Error');
			} else if (is_array($row) && count($row) > 0) {
				
				//FOR UPDATING
				$property_rating_mark_cls->update(array('livability_rating_mark' => (float)$livability_mark,
												'green_rating_mark' => (float)$green_mark),
												'property_id = '.$_SESSION['property']['id']);
			} else {
				//FOR INSERTING
				$property_rating_mark_cls->insert(array('property_id' => $_SESSION['property']['id'],
												'livability_rating_mark' => (float)$livability_mark,
												'green_rating_mark' => (float)$green_mark));
				
			}
			*/
			
			$property_cls->update(array('livability_rating_mark' => (float)$livability_mark,
										'green_rating_mark' => (float)$green_mark), 'property_id = '.$_SESSION['property']['id']);								

			
			$_SESSION['property']['step'] = $step;
			$track = (int)getPost('track');
			if ($track == 1) {
				$message = 'Saved successfully.';
				$property_cls->update(array('step' => $step),'property_id = '.$_SESSION['property']['id']);				
			} else {
                if(PE_isAuction($_SESSION['property']['id']))
                {
                    $step_ = $step + 1;
                }
                else {
                    $step_ = $step + 2;
                }
				redirect(ROOTURL.'?module='.$module.'&action=register&step='.($step_));
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
		}
	}
}

//TO SHOW TO FORM FIELD
$rows = $property_rating_cls->getRows('property_id = '.$_SESSION['property']['id']);
if (is_array($rows) and count($rows)>0) {
	foreach ($rows as $row) {
		if (isset($form_data[$row['rating_parent_id']])) {
			$form_data[$row['rating_parent_id']] = $row['rating_id'];
		}
	}
}

$smarty->assign('form_data',$form_data);
?>