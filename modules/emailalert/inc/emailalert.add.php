<?php
/*ini_set('display_errors',1);
error_reporting(E_ALL);*/


    $id = (int)getParam('id',0);
    if ($id > 0){
        $form_data = $email_cls->getRow('email_id = '.$id);
    } else{
        $form_data = $email_cls->getFields();
    }
    //prepare grid
    unset($grid);
    $grid = EA_prepareGrid();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['search']) and is_array($_POST['search']) and count($_POST['search']) > 0) {
        $data = array();
		foreach ($_POST['search'] as $key => $val){
			if (isset($_POST['search'][$key])) {
				$data[$key] = $email_cls->escape($_POST['search'][$key]);
                $data[$key] = utf8_decode($data[$key]);
                $data[$key] = utf8_to_latin9($data[$key]);
                //$data[$key] = formUnescapes($_POST['search'][$key]);
			} else {
				unset($data[$key]);
			}
        }
		$data['agent_id'] = $_SESSION['agent']['id'];
        //print_r($data);
        //prepare send Mail
        $result = array();
        $result = searchPro($data,0,'add');
        $banner = PE_getBanner($data);
        $auction_sale_ar = PEO_getAuctionSale();
       /* if($data['auction_sale'] == $auction_sale_ar['auction']) {
                    $auction_sale = 'auction';
            } else {
                    $auction_sale = 'sale';
            }*/
            $full_link = ROOTURL.'?module=property&action=search'/*.$auction_sale*/;
            $fields = array('property_kind','property_type','auction_sale','minprice','maxprice','address','suburb','state','postcode','bedroom','bathroom','parking',
                            'car_space','car_port','land_size_max','land_size_min','unit');
            foreach ($fields as $_f){
                $full_link .= '&'.$_f.'='.($fields == 'auction_sale'?setAuctionSale($data[$_f]):$data[$_f]);
            }
            $subject = formUnescape($data['name_email']);
            $email_agent = $agent_cls->getRow('agent_id = '.$_SESSION['agent']['id']);
            $email_agent['full_link'] = $full_link;
            $email_agent['description'] = $data['description'];
            $nd = tplEmail($result,$email_agent);
            $data['content'] = addslashes($nd);

            if(count($result) > 0 and is_array($result))
            {
                $id_data = array();
                foreach($result as $row)
                {

                    $id_data[] = $row['property_id'];
                }
                $data['property_number'] = implode(',',$id_data);

                if(count($result) >= 5)
                {
                    $data['abort'] = 1;
                }
            }
        if($data['email_id'] == 0){
            $data['end_time'] = date('Y-m-d H:i:s');
            if (count($result) > 0){
                $email = $email_agent['email_address'];
                $row = $agent_cls->getRow(" `email_address` = '$email' ");
                if(count($row)> 0 AND is_array($row))
                {
                    if($row['notify_email'] == 0)
                    {
                        $agent_cls->update(array('allow_alert' => 1),"agent_id = ".$row['agent_id']);
                    }
                }
                $mail = EA_sendEmail($email_agent['email_address'],$subject,$nd,$message,$banner);
                if ($mail){
					//StaticsReport('alertemail');
                    $data['last_cron'] = date('Y-m-d H:i:s');
                    $message = 'Thank you for registering your email alert. We will email you property alerts with properties that match your requirements as they are added to our database !';
                }else{
                    /*$message = 'The email don\'t send !';*/
                    $message = $mail;
                }
            }else{
                $message = 'Thank you for registering your email alert. Currently there are no properties that match your requirements !';
            }
            $email_cls->insert($data);
        }else{
            if (EA_getStatus($data['email_id']) == 1){
                if (count($result) > 0){
                    if (EA_sendEmail($email_agent['email_address'],$subject,$nd,$message)){
					       StaticsReport('alertemail');
                           $data['last_cron'] = date('Y-m-d H:i:s');
                           $mess = 'Now existing property if you request we will send mail for you !';
                    }
                }else{
                        $data['last_cron'] = '0000-00-00 00:00:00';
                        $mess = 'No property match! We will send email for you when properties found !';
                }
            } else {
                $mess = '  If you want to receive email alerts, please set the status to active !';
              }
            $email_cls->update($data,'email_id = '.$data['email_id']);
            if ($email_cls->hasError){
            }else{
                $message = 'Update successful !'.$mess;
             }
        }
        $grid = array();
        $grid = EA_prepareGrid();
        $session_cls->setMessage($message);
        redirect(ROOTURL.'/?module=emailalert&action=add-email');
    }
    unset($_POST['search']);
}
	if (!((int)$form_data['country'] > 0)) {
		$form_data['country'] = COUNTRY_DEFAULT;
	}
    if($id == 0) // New Email Alert
    {
        $form_data['parking'] = -1;
    }
	$property_type_ar = array(0 => 'Any')  + PEO_getOptions('property_type') + PEO_getOptions('property_type_commercial');
	if ($form_data['property_kind'] == 1) {
		$property_type_ar = array(0 => 'Any')  + PEO_getOptions('property_type_commercial');	
	} else if ($form_data['property_kind'] == 2) {
		$property_type_ar = array(0 => 'Any')  + PEO_getOptions('property_type');	
	}

    $smarty->assign('message',$message);
	$smarty->assign('auction_sales',PEO_getOptions('auction_sale'));
	$smarty->assign('property_types',$property_type_ar);
	$smarty->assign('property_kinds',PEO_getKind(array(0 => 'Any')));
	$smarty->assign('price_ranges',PEO_getOptions('price_range'));
	$smarty->assign('parking',PEO_getParking(array(-1 => 'Any')));
	$smarty->assign('bedrooms',PEO_getOptions('bedrooms'));
	$smarty->assign('bathrooms',PEO_getOptions('bathrooms'));
	$smarty->assign('land_sizes',PEO_getOptions('land_size'));
	$smarty->assign('car_spaces',PEO_getOptions('car_spaces'));
	$smarty->assign('car_ports',PEO_getOptions('garage_carport'));
    $smarty->assign('schedule',EA_optionSchedule());
	$search_data['price'] = optionsPrice('Any');
	$smarty->assign('states',R_getOptions($form_data['country']));
	$smarty->assign('countries',R_getOptionsStep2());	
	$smarty->assign('form_data',formUnescapes($form_data));
    $smarty->assign('row', $grid);
    $smarty->assign('agent_id', $_SESSION['agent']['id']);
    $smarty->assign('len_ar', PE_getItemPerPage());

?>

