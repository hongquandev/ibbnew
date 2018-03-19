<?php
include_once ROOTPATH.'/modules/configuration/inc/configuration.php';
$form_data = $property_cls->getFields();
$form_data[$property_cls->id] = $property_id;
$is_auction = true;

//BEGIN for change agent combobox
$agent_id = isset($_GET['agent_id']) ? $_GET['agent_id']:0;
$agent_id = (int)preg_replace('/[^0-9]/','',$agent_id);
$form_data['agent_id'] = $agent_id;


$row = $agent_cls->getRow('SELECT agt.firstname, agt.lastname, agt.parent_id, agt.agent_id, ag.*
                           FROM '.$agent_cls->getTable().' AS agt
                           LEFT JOIN '.$agent_cls->getTable('agent_type').' AS ag
                           ON agt.type_id = ag.agent_type_id
                           WHERE agt.agent_id = \''.$agent_id.'\'',true);
$smarty->assign('error',$config_cls->getKey('restrict_property'));
$smarty->assign('restrict_area',$config_cls->getKey('restrict_area'));
if (is_array($row) and count($row) > 0){
    $form_data['agent_name'] = $row['firstname'].' '.$row['lastname'];
    $smarty->assign('type',$row['title']);
    $proBlock = PE_isTheBlock($property_id);
    $isBlock = ($row['title'] == 'theblock' || $proBlock)? 1: 0;
    $isAgent = ($row['title'] == 'agent' || PE_isTheBlock($property_id,'agent'))? 1: 0;
    $smarty->assign('isBlock',$isBlock);
    if ($row['title'] == 'agent'){
        /*$package_arr = PA_getCurrentPackage($row['agent_id']);
        if (is_array($package_arr) and count($package_arr) > 0) {
        } else {
            $smarty->assign('restrict_register', 1);
        }*/
    }
}
//END
$auction_sale_ar = PEO_getAuctionSale();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $auction_sale=PE_isAuction($form_data[$property_cls->id]);
	
	$check->arr = array('auction_sale','type','address','suburb','postcode','country','price_from','price_to','car_space','car_port');

	if (isset($_POST['fields'])) {
		$data = $form_data;
		if (is_array($_POST['fields']) and count($_POST['fields']) > 0) {
			foreach ($data as $key => $val) {
				if (isset($_POST['fields'][$key])) {
					$data[$key] = $property_cls->escape($_POST['fields'][$key]);
					//$form_data[$key] = $_POST['fields'][$key];
				} else {
					unset($data[$key]);
				}
			}
            $data['auction_sale'] = isset($_POST['fields']['auction_sale'])?$_POST['fields']['auction_sale']:$auction_sale_ar['auction'];
            
            //$data['package_id'] = 0;
            if($data['auction_sale'] != $auction_sale_ar['auction']){
                //$data['package_id'] = 1;
            }
	        //$package_ar = getPost('package_id');
            //print_r($package_ar);
            /*$package_arr = PA_getCurrentPackage($data['agent_id']);
            //print_r($package_arr);
	        if (is_array($package_ar) and count($package_ar) > 0) {
		        $data['package_id'] = $package_ar[0];
	        }elseif (is_array($package_arr) and count($package_arr) > 0){
                $data['package_id'] = $package_arr['package_id'];
            }*/

			$data['description'] = scanContent($data['description']);
            $data['creation_date'] = date('Y-m-d H:i:s');
            $data['land_size_number'] = $_POST['fields']['land_size_number'];
            $data['unit'] = $_POST['fields']['unit'];
            $row = $property_cls->getRow('SELECT * FROM '.$property_cls->getTable('property_entity_option').'
                                            WHERE property_entity_option_id = '.$data['unit'],true);
            if ($data['land_size_number'] > 0){
                $data['land_size'] = $data['land_size_number'].' '.$row['title'];
            }else{
                $data['land_size'] = '';
            }
            $data['price_on_application'] = isset($_POST['fields']['price_on_application']) && (int)$data['price'] == 0?1:0;
            $data['suburb'] = trim($data['suburb']);
			
			if ($_SESSION['admin']['agent']['id'] !== $data['agent_id']) {
				$_SESSION['admin']['agent']['id'] = $data['agent_id'];
			}
			
			$data_ = array('open_for_inspection','open_time','auction_blog','contact_by_bidder','focus','feature','active','set_jump');
			foreach ($data_ as $val) {
				if (isset($_POST['fields'][$val])) {
					$data[$val] = 1;
				} else {
					$data[$val] = 0;
				}
			}
			
			/*
			if (!($property_id > 0)) {
				$data['end_time'] = date('Y-m-d H:i:s');
			}
			if ( $data['end_time'] > date('Y-m-d H:i:s')){
				$data['stop_bid'] = 0;
			}*/
			
			if ((int)@$_POST['fields']['restart_bid'] > 0) {
				$dt = date('Y-m-d H:i:s');
				$data['end_time'] = date('Y-m-d H:i:s',(strtotime($dt) + (int)$_POST['fields']['restart_bid']));
				$data['stop_bid'] = 0;
			}
			
			$error = false;
            $data['agent_type'] = AgentType_getTypeAgent($data['agent_id']);

//            if ($data['package_id'] /*&& $data['agent_type'] != 'agent'*/){
//                if ($data['auction_sale'] != $auction_sale_ar['private_sale']) {
//                    $row = $package_cls->getRow('package_id = '.$data['package_id'].' AND property_type = '.$data['auction_sale']);
//                    if (!is_array($row) || count($row) == 0) {
//                        $row = $package_cls->getRow('property_type = '.$data['auction_sale'].' ORDER BY `order` ASC');
//                        if (is_array($row) && count($row) > 0) {
//                            $data['package_id'] = $row['package_id'];
//                        }
//                    }
//
//                    if ((int)$data['package_id'] == 0) {
//                        $error = true;
//                        $message = 'Please select the package for this property.';
//                    }
//                } else {
//                    $row = $package_cls->getRow('property_type = '.$auction_sale_ar['private_sale']);
//                    if ((int)$data['package_id'] == 0 && is_array($row) && count($row) > 0) {
//                        $data['package_id'] = $row['package_id'];
//                    }
//                }
//            }

			if (!$error) {
		        if ($property_cls->invalidRegion(trim($data['suburb']).' '.trim($data['state']).' '.trim($data['postcode']))) {
                    //print_r($sql);
                    $error = true;
			        $message = 'Wrong suburb/postcode or state';
		        }
	        }

            if (!$error) {
                $region = explode(',',$config_cls->getKey('restrict_area'));
                if (is_array($region) && count($region)> 0 && in_array($data['state'],$region) && $data['agent_type'] != 'agent'){
                    $error = true;
			        $message = $config_cls->getKey('restrict_property');;
                }
	        }
            /*if($data['auction_sale'] == $auction_sale_ar['private_sale'] || $data['agent_type'] == 'theblock'
               || ($data['agent_type'] == 'agent' && $data['auction_sale'] == $auction_sale_ar['auction']))
            {//private sale OR the block
                if ((int)$data['price'] <= 0 AND $data['price_on_application'] == 0)
                {
                    $error = true;
                    $message = 'Please fill price or POA (price on application) information';
                }
            }
            else{
                if($data['price'] <= 0 OR $data['price'] == '') {
                    $error = true;
                    $message = 'Please fill price information';
                }
            }*/

            /*if( $data['auction_sale'] == $auction_sale_ar['ebidda30'] && ($data['buynow_price'] <= 0 OR $data['buynow_price'] == '')) {
                $error = true;
                $message = 'Please fill Buy Now price';
            }*/

			if (!$check->checkForm() or ($data['auction_sale']*$data['type']*$data['state']*$data['country']*$data['car_space']*$data['car_port'])==0) {
				$error = true;
			}


            $set_count_arr = $property_cls->getCRow(array('set_count'),'property_id = '.$form_data[$property_cls->id]);
            $set_count = is_array($set_count_arr) and count($set_count_arr) > 0?$set_count_arr['set_count']:'';
            /*if (($data['agent_type'] == 'theblock' || ($data['agent_type'] == 'agent' && $data['auction_sale'] == $auction_sale_ar['auction'])) && $set_count == '') {
                $data['set_count'] = 'Waiting for Auctioneer';
                $data['lock_bid'] = 1;
                if ($data['agent_type'] == 'agent') $data['show_agent_logo'] = 1;
            }*/
            if ($data['agent_type'] == 'agent' && $data['auction_sale'] != $auction_sale_ar['auction'] && $set_count != '') {
                $data['set_count'] = '';
                $data['lock_bid'] = 0;
            }
            if ($error) {//error
				$form_data = $data;	
				extractDateTime($form_data['end_time'],$form_data);
			} else {//not error
				unset($data[$property_cls->id]);
				$switch = false;
                if ($form_data[$property_cls->id] > 0) {//edit
                    // Quan: check change Data when submit
                    $pro_row = $property_cls->getRow('property_id='.$form_data[$property_cls->id]);
                    $changed_data = false;
                    foreach($data as $key => $val)
                    {
                        if(isset($pro_row[$key]))
                        {
                            if($data[$key] != $pro_row[$key])
                            {
                                $changed_data = true;
                                //break;
                            }
                            if($data[$key] != $pro_row[$key] && $key == 'auction_sale'){
                                $switch = true;
                            }
                        }
                    }
                    if($changed_data)
                    {
                        $data['last_update_time'] = date('Y-m-d H:i:s');
                    }
                    //end


                    $row_ = $property_cls->getRow('property_id = '.$form_data[$property_cls->id]);
                    $agent_id_= $agent_id;
                    if (is_array($row) and count($row) > 0){
                        $agent_id_ = $row_['agent_id'];
                    }
                    /*if ($switch) { // SALE Pro is switch to Auction
                        include_once ROOTPATH.'/modules/payment/inc/payment.php';
                        $payment_store_cls->update(array('is_change' => 1), 'property_id = '.(int)$form_data[$property_cls->id]);
                        $auction_option = PEO_getOptionById($data['auction_sale']);
                        $switch_to = $data['auction_sale'] == $auction_sale_ar['private_sale']?'sale':$auction_option['code'];
                        Property_transition($form_data[$property_cls->id],$agent_id_,'admin',$switch_to,$row_);
			        }*/
                    $row = $property_cls->getRow('property_id = '.$property_id);
                    $property_cls->update($data,$property_cls->id.'='.$form_data[$property_cls->id]);
                    $row = $property_cls->getRow('property_id = '.$property_id);
                    //update price to reserve price
                    /*$data_term=array('value'=>$data['price']);
                    $property_term_cls->update($data_term,'property_id='.$form_data[$property_cls->id].' AND auction_term_id=7');*/
                    /*if ($data['auction_sale'] == $auction_sale_ar['auction']){
                        $row = $property_term_cls->getRow(' property_id = '.$form_data[$property_cls->id]);
                        if (is_array($row) and count($row) > 0){//update term
                            $property_term_cls->update(array('value'=>$data['price']),'property_id = '.$form_data[$property_cls->id].'
                                                                              AND auction_term_id = '.AT_getIdByCode('reserve'));
                        }
                    }*/

					$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
								 'Action' => 'UPDATE',
								 'Detail' => "UPDATE PROPERTY ID :". $property_id, 
								 'UserID' => $_SESSION['Admin']['EmailAddress'],
								 'IPAddress' =>$_SERVER['REMOTE_ADDR']
							   	  ));
								  
				} else {//insert
                    $data['admin_created'] = 1;
                    $temp = Calendar_createTemp();
                    $row_notify =  $notification_cls->getRow("temp_id='".$temp."'");
                    if(count($row_notify) > 0 and is_array($row_notify)){
                        $data['notify_inspect_time'] = $row_notify['notify_value'];
                        $notification_cls->delete("temp_id='".$temp."'");
                    }
					$property_cls->insert($data);
					$property_id = $property_cls->insertId();
                    Calendar_update($property_id,$temp);
					// Write Logs					
					$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"), 
							 'Action' => 'INSERT',
							 'Detail' => "ADD NEW PROPERTY ID :". $property_id,
							 'UserID' => $_SESSION['Admin']['EmailAddress'],
							 'IPAddress' =>$_SERVER['REMOTE_ADDR']
							  ));
							  
				}
                updateSlugProperty($property_id);
				// UPDATE NOTIFICATION TO ANDROID
				push(0, array('type_msg' => 'update-property'));


				if ($property_cls->hasError()) {
					$message = $property_cls->getError();
					$form_data = $data;
					extractDateTime($form_data['end_time'],$form_data);
				} else {
					//begin create folder
					$path = ROOTPATH.'/store/uploads/'.$_SESSION['admin']['agent']['id'].'/'.$property_id;
					if ($_SESSION['admin']['agent']['id']>0 and $property_id > 0) {
						createFolder($path, 2);
					}
					if (!is_dir($path)) {
						die(msgBox('It can not create folder.'));
					}
					$_SESSION['admin']['property']['path'] = rtrim($path,'/').'/';					
					//end	
						
					$message = $form_data[$property_cls->id] > 0 ? 'Edited successful.':'Added successful.';
					if ($_POST['next'] == 1) {
						redirect(ROOTURLS.'/admin/?module='.$module.'&action=edit-media&property_id='.$property_id.'&token='.$token);
					} else {
						$form_data = $data;
						extractDateTime($form_data['end_time'],$form_data);
                        redirect(ROOTURLS.'/admin/?module='.$module.'&action=edit-detail&property_id='.$property_id.'&token='.$token);
					}
				}
			}
		}
		
	}
}

$auction_arr = PEO_getAuctionSale();
$row = $property_cls->getRow($property_cls->id.'='.$property_id);

if ($property_cls->hasError()) {
	$message = $property_cls->getError();
} else if (is_array($row) and count($row) > 0) {
	//set form data
    if ($row['agent_id'] > 0){
        $_SESSION['admin']['agent']['id'] = $row['agent_id'];
        //$form_data['agent_name'] = A_getFullName($row['agent_id']);

        $agent = $agent_cls->getRow('SELECT agt.firstname, agt.lastname, ag.*
                               FROM '.$agent_cls->getTable().' AS agt
                               LEFT JOIN '.$agent_cls->getTable('agent_type').' AS ag
                               ON agt.type_id = ag.agent_type_id
                               WHERE agt.agent_id = \''.$row['agent_id'].'\'',true);
        $form_data['agent_name'] = $agent['firstname'].' '.$agent['lastname'];
        $smarty->assign('type',$agent['title']);
        $isAgent = ($agent['title'] == 'agent' || PE_isTheBlock($property_id,'agent'))? 1: 0;
        $isBlock = ($agent['title'] == 'theblock') ? true : false;
        $smarty->assign('isBlock',$isBlock);

        $path = ROOTPATH.'/store/uploads/'.$_SESSION['admin']['agent']['id'].'/'.$property_id;
        if ($property_id > 0) {
            createFolder($path, 2);
        }
        if (!is_dir($path)) {
            die(msgBox('It can not create folder.['.$path.']'));
            //die(msgBox('It can not create folder.[/store/uploads/'.$_SESSION['admin']['agent']['id'].'/'.$id.']'));
        }
        $_SESSION['admin']['property']['path'] = rtrim($path,'/').'/';

        $is_auction = PE_isAuction((int)$property_id);
        $readonly = '';
        /*if($is_auction && $row['pay_status']==Property::PAY_COMPLETE){
            $st_time = new DateTime($row['start_time']);
            $now = new DateTime(date('Y-m-d H:i:s'));
            $readonly = ($st_time < $now || Property_datediff(date('Y-m-d H:i:s'),$row['start_time']))?'readonly="readonly"':'';
        }*/

        foreach ($property_cls->getFields() as $key => $val) {
            if (isset($row[$key])) {
                $form_data[$key] = formUnescape($row[$key]);
            }
        }
        $land_size = explode(' ',$form_data['land_size']);
        $form_data['land_size_number'] = $land_size[0];
        $form_data['unit'] = $property_entity_option_cls->getItemByField('title',$land_size[1],'property_entity_option_id');
        $form_data['price'] = (int)@$form_data['price'];
        $form_data['pay_status'] = $property_cls->getPayStatus($form_data['pay_status']);

        if ($form_data['price'] == 0) {
            $form_data['show_price'] = '';
        } else {
            $form_data['price'] = number_format($form_data['price'], 0, '', '');
            $form_data['show_price'] = showPrice($form_data['price']);
        }
        if ($form_data['buynow_price'] == 0) {
            $form_data['show_buynow_price'] = '';
        } else {
            $form_data['buynow_price'] = number_format($form_data['buynow_price'], 0, '', '');
            $form_data['show_buynow_price'] = showPrice($form_data['buynow_price']);
        }
        if ($form_data['price_on_application'] == 0) {
            $form_data['show_price_on_application'] = '';
        } else {
            $form_data['price_on_application'] = number_format($form_data['price_on_application'], 0, '', '');
            $form_data['show_price_on_application'] = showPrice($form_data['price_on_application']);
        }
        if ($form_data['advertised_price_from'] == 0) {
            $form_data['show_advertised_price_from'] = '';
        } else {
            $form_data['advertised_price_from'] = number_format($form_data['advertised_price_from'], 0, '', '');
            $form_data['show_advertised_price_from'] = showPrice($form_data['advertised_price_from']);
        }
        if ($form_data['advertised_price_to'] == 0) {
            $form_data['show_advertised_price_to'] = '';
        } else {
            $form_data['advertised_price_to'] = number_format($form_data['advertised_price_to'], 0, '', '');
            $form_data['show_advertised_price_to'] = showPrice($form_data['advertised_price_to']);
        }

        $money_step = (int)@$form_data['money_step'];
        if ($money_step == 0) {
            $form_data['money_step'] = '';
        }

        if (isset($form_data['end_time'])) {
            extractDateTime($form_data['end_time'],$form_data);
        }


        //begin security
        if ($property_id > 0 and $form_data[$property_cls->id] > 0 and  $property_id != $form_data[$property_cls->id]) {
            die(msgBox('Access invalid!'));
        }
        //end
        if (trim($form_data['suburb']) == '' or trim($form_data['state']) == 0 or trim($form_data['postcode']) == '') {
        $agent_row = $agent_cls->getRow('agent_id = '.$_SESSION['admin']['agent']['id']);
        if ($agent_cls->hasError()) {

        } else if (is_array($agent_row) and count($agent_row)>0) {
            if (trim($form_data['suburb']) == '') {
                $form_data['suburb'] = $agent_row['suburb'];
            }

            if (trim($form_data['state']) == 0) {
                $form_data['state'] = $agent_row['state'];
            }

            if (trim($form_data['postcode']) == '') {
                $form_data['postcode'] = $agent_row['postcode'];
            }
        }
        }
        $isAgent = PE_isTheBlock($property_id,'agent')?1:0;
    }else{
        unset($row['agent_id']);
    }
}else{//error when save data
    //$form_data = $data;
}
//end



if ((int)$form_data['country'] <= 0) {
	$form_data['country'] = $config_cls->getKey('general_country_default');
}

$smarty->assign('readonly',$readonly);
$smarty->assign('is_auction',$is_auction);
//$smarty->assign('package_tpl',PK_getPackageTpl($property_id,true,$form_data['auction_sale']));
$smarty->assign('agent_options',A_optionName());
if ($isAgent && $form_data['agent_id'] > 0) {
    $smarty->assign('agent_manager_options', A_getChildId($form_data['agent_id'], array(0 => array('value' => 'Select...', 'active' => 1))));
}else{
    $smarty->assign('agent_manager_options',array(0 => array('value' => 'Select...', 'active' => 1)));
}
$smarty->assign('auction_sales',PEO_getOptions('auction_sale',array(),$isAgent));
$smarty->assign('property_types',@$form_data['kind'] == 2 ? PEO_getOptions('property_type') : PEO_getOptions('property_type_commercial'));
$smarty->assign('auction_sale_ar',$auction_sale_ar);
$smarty->assign('period_options',PEO_getOptions('period'));
// Vo Phi Hung
// TODO: Re-sorting price_range
$arr = PEO_getOptions('price_range');
$temp = preg_replace("/[^0-9]/", '', $arr);
asort($temp);
$result = array();
foreach($temp as $key => $value){
    $result[$key] = $arr[$key];
}
//BEGIN
$_options_price_begin = getOptionsPriceRange();
$_options_price_end = $_options_price_begin;
list($key,$val) = each($_options_price_end);
unset($_options_price_end[$key]);
$_options_price_end['etc'] = 'etc'; 
//END

$smarty->assign('options_price_begin',$_options_price_begin);
$smarty->assign('options_price_end',$_options_price_end);

$smarty->assign('bedrooms',array('0' => 0) +  PEO_getOptions('bedrooms'));
$smarty->assign('bathrooms',array('0' => 0) + PEO_getOptions('bathrooms'));
$smarty->assign('parkings',PEO_getParking());
$smarty->assign('land_sizes',PEO_getOptions('land_size'));
$smarty->assign('unit',PEO_getOptions('unit'));
$smarty->assign('car_spaces',PEO_getOptions('car_spaces'));
$smarty->assign('car_ports',PEO_getOptions('garage_carport'));
$smarty->assign('property_kinds',PEO_getKind());
$smarty->assign('states',R_getOptions( ($form_data['country'] > 0 ? $form_data['country'] : -1 ),array(0=>'Select...')));
//$smarty->assign('countries',R_getOptions());
$smarty->assign('countries',R_getOptionsStep2());
$smarty->assign('form_data',formUnescapes($form_data));

?>