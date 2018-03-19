<?php
	require '../../configs/config.inc.php';
	require ROOTPATH.'/includes/functions.php';
	include ROOTPATH.'/includes/model.class.php';

	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	
	if ($action == 'list') {	
		include_once ROOTPATH.'/modules/general/inc/regions.php';
		include_once ROOTPATH.'/modules/general/inc/options.php';
		include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
		include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
		include_once ROOTPATH.'/modules/agent/inc/agent.php';
		include_once 'inc/emailalert.php';
		
		include_once ROOTPATH.'/includes/checkingform.class.php';
		
			$start = (int)$_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'] ;
						$limit = (int)$_REQUEST['limit'] == 0 ? 20 : $_REQUEST['limit'] ;
						$sort_by = $_REQUEST['sort'] == '' ? 'pro.email_id' : $_REQUEST['sort'] ;
						$dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'] ;	
						$property_id = (int)$_REQUEST['email_id'];
						$search_query = isset($_REQUEST['search_query']) ? $_REQUEST['search_query']:'';
						$search_where = '';
						if (strlen($search_query) > 0) {
							$search_where = "WHERE (pro.address LIKE '%".$search_query."%' 
													OR pro.property_id = '".$search_query."'
													OR pro.postcode = '".$search_query."'
													OR pro.suburb LIKE '%".$search_query."%'
													OR pro.state = (SELECT reg1.region_id FROM ".$region_cls->getTable()." AS reg1 WHERE reg1.name= '".$search_query."')
													OR pro.country = (SELECT reg2.region_id FROM ".$region_cls->getTable()." AS reg2 WHERE reg2.name= '".$search_query."') )";
						}
						
						$rows = $email_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pro.email_id, pro.address, pro.postcode, pro.suburb, pro.property_type, 
										 					 pro.active, pro.bedroom, pro.bathroom,
										 					 pro.land_size, pro.car_space, pro.car_port, pro.end_time, agt.firstname, agt.lastname,
										 
										(SELECT reg1.name 
										FROM '.$region_cls->getTable().' AS reg1
										WHERE reg1.region_id = pro.state) AS state_name,
										
										(SELECT reg2.name 
										FROM '.$region_cls->getTable().' AS reg2
										WHERE reg2.region_id = pro.country) AS country_name,
										(SELECT pro_ent_opt2.title
										FROM '.$property_entity_option_cls->getTable().' AS pro_ent_opt2
										WHERE pro_ent_opt2.property_entity_option_id = pro.property_type) AS type_name,
		
										(SELECT pro_ent_opt3.title
										FROM '.$property_entity_option_cls->getTable().' AS pro_ent_opt3
										WHERE pro_ent_opt3.property_entity_option_id = pro.price_range) AS price_name,
		
										(SELECT pro_ent_opt4.title
										FROM '.$property_entity_option_cls->getTable().' AS pro_ent_opt4
										WHERE pro_ent_opt4.property_entity_option_id = pro.bedroom) AS bedroom_name,
		
										(SELECT pro_ent_opt5.title
										FROM '.$property_entity_option_cls->getTable().' AS pro_ent_opt5
										WHERE pro_ent_opt5.property_entity_option_id = pro.bathroom) AS bathroom_name,
		
										(SELECT pro_ent_opt6.title
										FROM '.$property_entity_option_cls->getTable().' AS pro_ent_opt6
										WHERE pro_ent_opt6.property_entity_option_id = pro.land_size) AS land_size_name,
		
										(SELECT pro_ent_opt7.title
										FROM '.$property_entity_option_cls->getTable().' AS pro_ent_opt7
										WHERE pro_ent_opt7.property_entity_option_id = pro.car_space) AS car_space_name,
		
										(SELECT pro_ent_opt8.title
										FROM '.$property_entity_option_cls->getTable().' AS pro_ent_opt8
										WHERE pro_ent_opt8.property_entity_option_id = pro.car_port) AS car_port_name
										
									FROM '.$email_cls->getTable().' AS pro
									LEFT JOIN '.$agent_cls->getTable().' AS agt ON pro.agent_id = agt.agent_id 
									'.$search_where.'
									ORDER BY '.$sort_by.' '.$dir.'
									LIMIT '.$start.','.$limit,true);	
						
					  
						$total = $email_cls->getFoundRows();
						$topics = array();
						if (is_array($rows) and count($rows) > 0) {
							foreach ($rows as $row) {
								//$row['price'] = number_format($row['price'],2,'.',',');
								$row['agent_fullname'] = $row['firstname'].' '.$row['lastname'];
								$row['address'] = $row['suburb'].', '.$row['state_name'].', '.$row['country_name'];
								
								if ($row['active'] == 0) {
									//$active_color = '#FF0000';
									//$active_label = 'Disabled';
									$row['active'] = '<a href="#" style="color:#FF0000; text-decoration:none; " >Pending </a> ';
									//$active_link = '/modules/property/action.admin.php?action=active-property&property_id='.$row['property_id'].'&token='.$token;
								} else {
									//$active_color = '#009900';
									//$active_label = 'Enabled';
									//$active_link = '/modules/property/action.admin.php?action=inactive-property&property_id='.$row['property_id'].'&token='.$token;
									$row['active'] = '<a href="#" style="color:#009900; text-decoration:none; " >Success</a> ';
								}
								//$row['active'] =  '<a style="cursor:pointer; color:'.$active_color.'" onclick ="activeItemF5(\''.$active_link.'\');" >'.$active_label.'</a>';
								
								
							//	$edit_link = '?module=property&action=edit&property_id='.$row['property_id'].'&token='.$token;
	//							$delete_link = '/modules/property/action.admin.php?action=delete-property&property_id='.$row['property_id'].'&token='.$token;
									
//								$row['edit_link'] = '<a href="'.$edit_link.'" style="color:#0000ff;text-decoration:none">'.$propertyLang['Edit'].'</a>'; 
							//	$row['delete_link'] = '<div style="cursor:pointer; color:#FF0000" onclick ="deleteItemF5(\''.$delete_link.'\') " >'.$propertyLang['Delete'].'</div>';
								if ($row['bedroom'] == 0) {
									$row['bedroom_name'] = 'Any';
 								}
								if ($row['bathroom'] == 0) {
									$row['bathroom_name'] = 'Any';
								}
								if ($row['land_size'] == 0) {
									$row['land_size_name'] = 'Any';
								}
								if ($row['car_space'] == 0) {
									$row['car_space_name'] = 'Any';
								}
								if ($row['car_port'] == 0) {
									$row['car_port_name'] = 'Any';
								}
								if ($row['property_type'] == 0) {
									$row['type_name'] = 'Any';
								}
								
								$row['Delete'] = '<a style="cursor:pointer; text-decoration:none; color:#FF0000" onclick ="deleteItemF5(\'../modules/emailalert/action.admin.php?action=delete&id='.$row['email_id'].'\');"> Delete </a>';		
								
								$topics[] = $row;
								
							}
						}		
						
						$result = array('totalCount' => $total, 'topics' => $topics);
						echo json_encode($result);				
	}
	if ($action == 'delete') {
			$id = (int)$_GET['id'];
			mysql_query("DELETE FROM `email_alert`
								WHERE `email_id` = $id"); 	
			$message = 'Deleted successful.';
			die($message);	
			
			
			
	}
	
?>