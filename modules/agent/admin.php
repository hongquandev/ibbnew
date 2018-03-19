<?php 
$module = 'agent';
include_once ROOTPATH.'/admin/functions.php';
include_once 'lang/'.$module.'.en.lang.php';
include_once ROOTPATH.'/modules/general/inc/regions.php';
include_once 'inc/agent.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once 'inc/admin.agent.php';
include_once ROOTPATH.'/includes/checkingform.class.php';
include_once ROOTPATH.'/modules/configuration/inc/configuration.php';

$message = '';
$agent_id = (int)restrictArgs(getParam('agent_id',0));
$action = getParam('action');
$token = getParam('token');
$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
//print_r($action);
//die($action);
switch ($action) {
	case 'add':
	case 'edit':
	case 'edit-personal':
    case 'edit-company':
	//case 'edit-legalcontact':
	case 'edit-lawyer':
	case 'edit-contact':
	case 'edit-ccdetail':
	case 'delete-ccdetail':
	
	case 'edit-note':
	case 'active-note':
	case 'inactive-note':
	case 'delete-note':
	
	case 'edit-note2':
	case 'active-note2':
	case 'inactive-note2':
	case 'delete-note2':
    case 'edit-site':
	
		if ($action == 'edit' or $action == 'add') {
			$action = 'edit-personal';	
		}
		
		$action_ar = explode('-', $action);
		if (in_array($action_ar[0], array('edit', 'active', 'inactive'))) {
			if ($agent_id == 0 && $perm_ar['add'] == 0) {
				$session_cls->setMessage($perm_msg_ar['add']);
				redirect('/admin/?module=agent&token='.$token);	
			} else if ($perm_ar['edit'] == 0) {
				$session_cls->setMessage($perm_msg_ar['edit']);
				redirect('/admin/?module=agent&token='.$token);
			}
		} else if ($action_ar[0] == 'delete') {
			$session_cls->setMessage($perm_msg_ar['delete']);
			redirect('/admin/?module=agent&token='.$token);
		}

		$form_action = '?module=agent&action='.$action.'&agent_id='.$agent_id.'&token='.$token;
		
		
		// Process Load Dynamic Agent Menu Left Bar In Admin
		include_once 'inc/admin.agent.leftbar.php';
		// End Process Load Dynamic Agent Menu Left Bar In Admin 		
		include_once ROOTPATH.'/modules/agent/inc/admin.agent.'.$action_ar[1].'.php';
		
		$smarty->assign(array('prev' => A_prevAdminLink($agent_id),
							  'next' => A_nextAdminLink($agent_id),
							  'action_ar' => $action_ar,
							  'form_action' => $form_action,
							  'agent_id' => $agent_id));
	
	    break;
	case 'add-bidder':
    case 'edit-bidder':
    case 'delete-bidder':
        include_once 'inc/admin.bidder.form.php';
        break;
    case 'exportCSV-bidder':
        //die($action);
        __exportCSV_bidder();
        exit;
        break;
	default:
		if ($perm_ar['view'] == 0) {
			$message = $perm_msg_ar['view'];
		}
	break;
}

function __exportCSV_bidder(){
    include_once ROOTPATH.'/modules/property/inc/property.php';
    global $agent_cls, $bids_first_cls, $token,$property_cls,$bid_cls,$region_cls;
    $start = (int)( $_REQUEST['start'] == 0 ? 0 : $_REQUEST['start'] );
    $limit = (int)($_REQUEST['limit'] == 0 ? 20 : $_REQUEST['limit'] );
    $sort_by = $_REQUEST['sort'] == '' ? 'a.agent_id' : $_REQUEST['sort'] ;
    $dir = $_REQUEST['dir'] == '' ? 'ASC' : $_REQUEST['dir'] ;
    $query = restrictArgs(getParam('query',''),'[^0-9A-Za-z\-\_]');
    if($query == '')
    {
        $query = '1';
    }
    else{
        $query = " (a.agent_id = '{$query}'
                   OR a.agent_id IN (SELECT agt.agent_id FROM ".$agent_cls->getTable()." AS agt WHERE agt.firstname LIKE '%".$query."%' OR agt.lastname LIKE '%".$query."%'
							                       OR CONCAT(agt.firstname,' ',agt.lastname) LIKE '%".$query."%')
		           OR a.email_address LIKE '%{$query}%'
		           OR (SELECT agt.name
								     FROM {$agent_cls->getTable('agent_type')} AS agt
								     WHERE agt.agent_type_id = a.type_id
									 ) LIKE '%{$query}%' )
        ";
    }

    $auction_sale_ar = PEO_getAuctionSale();
    $rows = $agent_cls->getRows('SELECT a.*,
                                     (SELECT agt.name
								     FROM '.$agent_cls->getTable('agent_type').' AS agt
								     WHERE agt.agent_type_id = a.type_id
									 ) AS type_name,
									 (SELECT reg1.name
                                                FROM '.$region_cls->getTable().' AS reg1
                                                WHERE reg1.region_id = a.state
                                            ) AS state_name,
                                    (SELECT reg3.name
                                        FROM '.$region_cls->getTable().' AS reg3
                                        WHERE reg3.region_id = a.country
                                    ) AS country_name,
                                 b.property_id as pro_id,
                                 GROUP_CONCAT(property_id) As property_id
                                 FROM agent AS a
                                 INNER JOIN '.$bids_first_cls->getTable().' AS b ON a.agent_id = b.agent_id
                                 WHERE b.pay_bid_first_status > 0
                                 AND b.property_id IN (

                                 (SELECT pro.property_id
                                  FROM ' . $property_cls->getTable() . ' AS pro
                                  WHERE pro.active = 1
                                      AND  pro.agent_active = 1
                                      AND  pro.confirm_sold = 0
                                      AND  pro.stop_bid = 0
                                      AND  pro.pay_status = ' . Property::CAN_SHOW . '
                                      AND  pro.auction_sale ='.$auction_sale_ar['auction'].'
                                      AND  pro.end_time > pro.start_time
                                      AND ((pro.end_time > \''.date('Y-m-d H:i:s').'\'
								           AND pro.start_time <= \''.date('Y-m-d H:i:s').'\')
								           OR pro.start_time > \''.date('Y-m-d H:i:s').'\')))
								  AND '.$query.'
                                 GROUP BY a.agent_id
                                 ORDER BY '.$sort_by.' '.$dir.'
								 ',true);
    //die($agent_cls->sql);
    /*$total = $agent_cls->getFoundRows();
    if (is_array($rows) and count($rows)> 0){
        foreach ($rows as $row){
            $row['full_name'] = $row['firstname'].' '.$row['lastname'];
            $edit_link = '?module=agent&action=edit-bidder&agent_id='.$row['agent_id'].'&token='.$token;
            $row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';
            $topics[] = $row;
        }
    }*/

    $file_name = restrictArgs(getParam('file_name',''),'[^0-9A-Za-z\-\_]');
    $file_name = $file_name == '' ? 'data' : $file_name;
    header('Content-Type: text/octect-stream; charset=utf-8');
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="'.$file_name.'.csv"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Disposition: attachment; filename="'.$file_name.'.csv";');
    ob_clean();
    flush();

    // output to csv
    $title = array();
    $title[] = 'No';
    $title[] = 'Register Bid On Properties Id';
    $title[] = 'Bidder';
    $title[] = 'Email Address';
    $title[] = 'Address';
    $title[] = 'Suburb';
    $title[] = 'State';
    $title[] = 'Post Code';
    $title[] = 'Country';
    $title[] = 'Telephone';
    $title[] = 'MobilePhone';
    $title[] = 'License Number';
    //$title[] = 'Register Time';
    $title[] = 'Type';

    echo '"' . stripslashes(implode('","',$title)) . "\"\n";
    //$rows = $bid_cls->getRows($query,true);
    if(count($rows)>0 and is_array($rows))
    {
        foreach($rows as $key => $row)
        {
            $content = array();
            $content['No'] = $key +1 ;
            $content['property_id'] = $row['pro_id'];
            $content['bidder'] = $row['firstname'].' '.$row['lastname'];
            $content['email'] = $row['email_address'];
            $content['address'] = $row['street'];
            $content['suburb'] = $row['suburb'];
            $content['state'] = $row['state_name'];
            $content['postcode'] = $row['postcode'];
            $content['contry'] = $row['country_name'];
            $content['telephone'] = $row['telephone'];
            $content['mobilephone'] = $row['mobilephone'];
            $content['license'] = $row['license_number'];
            //$content['time'] = $row['bid_first_time'];
            $content['type'] = $row['type_name'];
            echo '"' . stripslashes(implode('","',$content)) . "\"\n";
        }
    }
    exit;
}


if (strlen($message) == 0) {
	$message = $session_cls->getMessage();
}

$smarty->assign(array('action' => $action,
					  'message' => $message,
                      'action_arr'=> explode('-',$action)));
?>