<?php
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once ROOTPATH.'/modules/agent/inc/agent.php';
include_once ROOTPATH.'/modules/general/inc/bids_first.class.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/modules/payment/inc/payment_store.class.php';
include_once ROOTPATH.'/modules/general/inc/bids_stop.class.php';
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
    $pag_cls = new Paginate();
}
if (!$payment_store_cls || !($payment_store_cls instanceof Payment_store)) {
    $payment_store_cls = new Payment_store();
}
if (!isset($bids_first_cls) or !($bids_first_cls instanceof Bids_first)) {
	$bids_first_cls = new Bids_first();
}

if (!$bids_stop_cls || !($bids_stop_cls instanceof Bids_stop)) {
    $bids_stop_cls = new Bids_stop();
}
$p = (int)restrictArgs(getQuery('p', 1));
$p = $p <= 0 ? 1 : $p;
$len = 7;

$auction_sale_ar = PEO_getAuctionSale();
$form_data = array();
//BEGIN for change agent combobox
$agent_id = isset($_GET['agent_id']) ? $_GET['agent_id']:0;
$agent_id = (int)preg_replace('/[^0-9]/','',$agent_id);
$form_data['agent_id'] = $agent_id;

$row = $agent_cls->getRow('SELECT agt.firstname, agt.lastname, ag.*
                           FROM '.$agent_cls->getTable().' AS agt
                           LEFT JOIN '.$agent_cls->getTable('agent_type').' AS ag
                           ON agt.type_id = ag.agent_type_id
                           WHERE agt.agent_id = \''.$agent_id.'\'',true);
if (is_array($row) and count($row) > 0){
    $form_data['agent_name'] = $row['firstname'].' '.$row['lastname'];
    $smarty->assign('type',$row['title']);
   /* $proBlock = PE_isTheBlock($property_id);
    $isBlock = $row['title'] == 'theblock' || $proBlock;
    $smarty->assign('isBlock',$isBlock);
    $rows = $bids_first_cls->getRows('agent_id = '.$agent_id.' AND pay_bid_first_status > 0');
    foreach ($rows as $item){
        $array[] =  $item['property_id'];
        if ($item['pay_bid_first_status'] == 1){
            $bid_ar[] = $item['property_id'];
        }
    }
    $form_data['auction'] = $array;
    $form_data['has_bid'] = $bid_ar;*/
    $rows = $property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pro.*,

                                   (SELECT CONCAT(a.firstname," ",a.lastname) FROM '.$property_cls->getTable('agent').
                                    ' AS a WHERE a.agent_id = pro.agent_id
                                   ) AS agent_name,

                                   (SELECT b.pay_bid_first_status FROM '.$bids_first_cls->getTable().
                                    ' AS b WHERE b.agent_id = '.$agent_id.' AND pro.property_id = b.property_id AND b.pay_bid_first_status > 0
                                   ) AS pay_bid_first_status

                                   FROM '.$property_cls->getTable().' AS pro

                                   WHERE
                                         pro.active = 1
                                         AND  pro.agent_active = 1
                                         AND  pro.confirm_sold = 0
                                         AND  pro.stop_bid = 0
                                         AND  pro.pay_status = ' . Property::CAN_SHOW . "
                                         
                                         AND  pro.end_time > pro.start_time
                                         AND ((pro.end_time > '".date('Y-m-d H:i:s')."'
								              AND pro.start_time <= '".date('Y-m-d H:i:s')."')
								              OR pro.start_time > '".date('Y-m-d H:i:s')."')
								         AND pro.property_id IN (SELECT property_id FROM ".$bids_first_cls->getTable()." AS b
								                                 WHERE b.agent_id = {$agent_id} AND b.pay_bid_first_status > 0)
								   GROUP BY pro.property_id
								   ORDER BY pro.property_id DESC
								   LIMIT ".($p - 1) * $len.','.$len
                                   ,true);
	//AND  pro.auction_sale =' . $auction_sale_ar['auction']."
    $pag_cls->setTotal($property_cls->getFoundRows())
				->setPerPage($len)
				->setCurPage($p)
				->setLenPage(10)
				->setUrl(ROOTURL.'/admin/?module=agent&action=edit-bidder&agent_id='.$agent_id.'&token='.$token)
				->setLayout('link_simple');
    $data = array();
    if (is_array($rows) and count($rows)> 0){
        foreach ($rows as $_row){
            $_row['description'] = safecontent($_row['description'],300).'...';
            $_row['delete_link'] = ROOTURL.'/admin/?module=agent&action=delete-bidder&agent_id='.$agent_id.'&property_id='.$_row['property_id'].'&token='.$token;
            $data[] = $_row;
        }
    }

}

//END


//SHOW PROPERTIES
/*

$sql =                              'SELECT pro.*,
                                     (SELECT title FROM ' . $agent_cls->getTable('agent_type') . ' AS at
                                      WHERE agt.type_id = at.agent_type_id) AS pro_type
                                     FROM ' . $property_cls->getTable() . ' AS pro
                                     INNER JOIN ' . $property_cls->getTable('agent') . ' AS agt
									 ON pro.agent_id = agt.agent_id
                                     WHERE pro.active = 1
                                      AND  pro.agent_active = 1
                                      AND  pro.confirm_sold = 0
                                      AND  pro.stop_bid = 0
                                      AND  pro.pay_status = ' . Property::CAN_SHOW . '
                                      AND  pro.auction_sale =' . $auction_sale_ar['auction'].'
                                      AND pro.end_time > pro.start_time';
$live_rows = $property_cls->getRows($sql.' AND pro.end_time > \''.date('Y-m-d H:i:s').'\'
								           AND pro.start_time <= \''.date('Y-m-d H:i:s').'\'',true);

$forth_rows = $property_cls->getRows($sql.' AND pro.start_time > \''.date('Y-m-d H:i:s').'\'',true);
$auction = array_merge($live_rows,$forth_rows);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auction_arr = $_POST['auction'];
    if (count($auction_arr)> 0){
         foreach ($auction as $pro){
           if (in_array($pro['property_id'],$auction_arr)){
               if ($bids_first_cls->getStatus($agent_id,$pro['property_id'])){
               }else{
                  $bids_first_cls->insert(array('property_id'=>$pro['property_id'],
                                                'agent_id'=>$agent_id,
                                                'pay_bid_first_status'=>2,
                                                'bid_first_time'=>date('Y-m-d H:i:s')));
               }
           }else{
               $bid_first_cls->delete('property_id = '.$pro['property_id'].' AND agent_id = '.$agent_id.' AND pay_bid_first_status = 2');
           }
        }
    }
    $message = 'Updated successful!';
    if (count($form_data['has_bid']) && count($auction_arr) > 0){
        $form_data['auction'] = array_merge($form_data['has_bid'],$auction_arr);
    }else{
        $form_data['auction'] = count($form_data['has_bid']) > 0?$form_data['has_bid']:count($auction_arr)> 0?$auction_arr:null;
    }
} */

switch ($action){
    case 'delete-bidder':
        $property_id = getParam('property_id');
        $agent_id = getParam('agent_id');
        $bid_first_cls->delete('property_id = '.$property_id.' AND agent_id = '.$agent_id.' AND pay_bid_first_status >= 0');
        $payment_row = $payment_store_cls->getRow('property_id = '.$property_id.' AND agent_id = '.$agent_id .' AND bid = 1');
        if(count($payment_row) > 0 and is_array($payment_row)){
            $payment_store_cls->update(array('is_paid' => 0),'property_id = '.$property_id.' AND agent_id = '.$agent_id.' AND bid = 1');
        }
        if ($bids_first_cls->hasError()){
            $message = 'You have not permission !';
        }else{
             $stop = $bids_stop_cls->getRow('SELECT count(agent_id) AS count
                                             FROM '.$bids_stop_cls->getTable().'
                                             WHERE property_id ='.$property_id,true);
             $registered = $bids_first_cls->getRow('SELECT count(agent_id) AS count
                                                    FROM '.$bids_first_cls->getTable().'
                                                    WHERE property_id = '.$property_id .' AND pay_bid_first_status > 0',true);

             $count_stop = (is_array($stop) && count($stop > 0))?$stop['count']:0;
             $count_registered = (is_array($registered) && count($registered > 0))?$registered['count']:0;

             if ($count_registered > 0 && $count_stop == $count_registered){
                    $property_cls->update(array('no_more_bid'=>1/*,
                                                'set_count'=>'No More Online Bids'*/),
                                                'property_id = '.$property_id);

             }
             redirect(ROOTURL.'/admin/?module=agent&action=edit-bidder&agent_id='.$agent_id.'&token='.$token);
        }
        break;
    case 'edit-bidder':
    case 'add-bidder':
        break;
}


//END

$smarty->assign('options_live',$live_rows);
$smarty->assign('options_forth',$forth_rows);
$smarty->assign('form_data',formUnescapes($form_data));
$smarty->assign('messsage',$message);
$smarty->assign('data',$data);
$smarty->assign('pag_str',$pag_cls->layout());
$smarty->assign('ROOTURL',ROOTURL);

?>