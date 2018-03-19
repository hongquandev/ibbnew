<?php
try {
    $step = getParam('step');
    $property_id = restrictArgs(getParam('property_id', 0));
    $text = '';
    $data = array();
    $result = array('error' => 1);
    if ($property_id > 0) {
        $row = $property_cls->getRow('SELECT no_more_bid,
			stop_bid,
			confirm_sold
			FROM ' . $property_cls->getTable() . ' WHERE property_id = ' . $property_id, true);
        switch ($step) {
            case 1:
                $text = 'Going Once';
                    $data['no_more_bid'] = 0;
                break;
            case 2:
                $text = 'Going Twice';
                    $data['no_more_bid'] = 0;
                break;
            case 3:
                $text = 'Third and Final Call';
                    $data['no_more_bid'] = 0;
                break;
            case 'sold':
                $text = 'Sold';
                $data['confirm_sold'] = 1;
                $data['sold_time'] = date('Y-m-d H:i:s'); 
                break;
            case 'reset':

                //$bid = $bid_cls->getRows('property_id = '.$property_id);
                //$text = (is_array($bid) and count($bid) > 0)?'Auction Live':'Looking For Opening Bid';

                $text = PE_isNoMoreBid($property_id)? 'No More Online Bids':'Auction Live';
                break;
            case 'passedin':
                $text = 'Passed In';
                $data['stop_bid'] = 1;
                $data['stop_time'] = date('Y-m-d H:i:s');
                break;
            case 'pre_amble':
                $text = 'Auctioneer pre amble';
                $data['lock_bid'] = 1;
                break;
            case 'start':
                $text = 'Auction Live';
                $data['lock_bid'] = 0;
                break;
            default:
                break;
        }
        if ($row['stop_bid'] == 0 and $row['confirm_sold'] == 0) {
            if (Property_isLockBid($property_id) && in_array($step,array(1,2,3,'reset','passedin'))) {
                out('0', 'Sorry, this property is not ready. Please click Start Auction button for opening bid.');
            } else {
                $data['set_count'] = $text;
                $property_cls->update($data, 'property_id = ' . $property_id);
                if (!$property_cls->getError()) {
                    $result = array('success' => 1, 'property_id' => $property_id, 'step' => $step, 'property_id' => $property_id);
                    pushWithoutUserId($_SESSION['agent']['id'], array('type_msg' => $text=='Sold'?'sold':'update-set-count'));
                    out('1', 'Saved successful!', $result);
                }
            }
        }
    }
    out('0', 'Process error1');
} catch (Exception $e) {
    out('0', $e->getMessage());
}


?>