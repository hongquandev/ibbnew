<?php
    include_once ROOTPATH.'/modules/general/inc/bids.class.php';
    include_once ROOTPATH.'/modules/general/inc/bids_transition_history.php';
    include_once ROOTPATH.'/modules/general/inc/property_history.php';

    if (!isset($bids_transition_history_cls) || !($bids_transition_history_cls instanceof bids_transition_history)) {
        $bids_transition_history_cls = new bids_transition_history();
    }

    if (!isset($property_history_cls) || !($property_history_cls instanceof property_history)) {
        $property_history_cls = new property_history();
    }

    if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
        $pag_cls = new Paginate();
    }

     if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
        $pag_cls = new Paginate();
     }

	$property_id = restrictArgs(getParam('property_id',0));
    $agent_id = isset($_SESSION['agent']['id'])?$_SESSION['agent']['id']:'';
    $show_info = true;
    $view = getParam('view','');
	if ($property_id > 0 )
    {

        $row = $property_cls->getRow('property_id='.$property_id);
        if(is_array($row) and count($row) > 0 )
        {
            if($agent_id != $row['agent_id'] or $agent_id =='')
            {
                redirect(ROOTURL);
            }
        }

        $bids_orderby = array("bids" => " Bids History");

        $pro_his_rows = $property_history_cls->getRows('property_id='.$property_id);

        if(is_array($pro_his_rows) and count($pro_his_rows) > 0 )
        {
            /*for($i=1;$i <= count($pro_his_rows) ; $i++)
            {
                $bids_orderby[$i] = 'Switched Bids history '.$i;
            }*/
            $i = 0;
            foreach($pro_his_rows as $row)
            {
                $i++;
                $bids_orderby[$row['property_transition_history_id']] = 'Switched Bids '.$i;
            }
        }

        $smarty->assign('Bids_order_by',$bids_orderby);
        $order_by = getParam('id',0);
        if($order_by == 0)
        {
            $order_by = getPost('order_by');
        }
        $where = '';
        $table = $bid_cls->getTable();
        if($order_by != '')
        {
            if ($order_by == "bids")
            {
                $table = $bid_cls->getTable();
            }
            else
            {
                $table = $bids_transition_history_cls->getTable();
                $where = 'AND property_transition_history_id = '.$order_by;
            }
        }

        $smarty->assign('order_by',$order_by);


        $p = restrictArgs(getParam('p',1));
        $len = 30;
        $bid_rows = $bid_cls->getRows('SELECT SQL_CALC_FOUND_ROWS
                                                bid.price,
                                                bid.time,
                                                agt.firstname,
                                                agt.lastname,
                                                agt.agent_id,
                                                agt.email_address
                                        FROM '.$table.' AS bid,'.$agent_cls->getTable().' AS agt
                                        WHERE bid.agent_id = agt.agent_id AND bid.property_id = '.$property_id.'
                                        '.$where.'
                                        ORDER BY bid.price DESC
                                        LIMIT '.($p - 1)*$len.','.$len,true);


        //$bid_switch_rows =
        $rows = array();
        $total_row = $property_cls->getFoundRows();

		$review_pagging = (($p - 1) * $len).' - '.(($p * $len) > $total_row ? $total_row : ($p * $len)).' ('.$total_row.' items)';
		$v = 'bid-history-full';
		$pag_cls->setTotal($total_row)
				->setPerPage($len)
				->setCurPage($p)
				->setLenPage(20)
				->setUrl('?module=property&action='.$v.'&property_id='.$property_id)
				->setLayout('link_simple');



        if ($bid_cls->hasError()) {

        } else if (is_array($bid_rows) and count($bid_rows) > 0 ) {
            foreach ($bid_rows as $key => $row) {
                $dt = new DateTime($row['time']);
                $rows[] = array('name' =>formUnescape($row['firstname'].' '.$row['lastname']),
                                'price' => showPrice($row['price']),
                                'time' => $dt->format($config_cls->getKey('general_date_format')). ' at '.$dt->format('h A'));
            }

        }




    }
    if($view == 'agent')
        $link_detail = ROOTURL.'/?module=property&action=view-auction-agent_detail&id='.$property_id;
    else{
        $link_detail = ROOTURL.'/?module=property&action=view-auction-detail&id='.$property_id;
    }
    $smarty->assign('link_detail',$link_detail);

    $form_action = ROOTURL.'/?module=property&action=bid-history-full&property_id='.$property_id;
    $smarty->assign('form_action',$form_action);

	$smarty->assign('rows',$rows);
    $smarty->assign('show_info',$show_info);
    $smarty->assign('index',($p-1)*$len);
    $smarty->assign('review_pagging',$review_pagging);
    $smarty->assign('pag_str',$pag_cls->layout());
    $smarty->assign('property_id',$property_id);
    