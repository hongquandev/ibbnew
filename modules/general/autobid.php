<?php
$rl_rows = $bid_room_cls->getRows('SELECT DISTINCT property_id FROM '.$bid_room_cls->getTable().' WHERE `ignore` = 0 ORDER BY time_joined ASC', true);
//$bid_room_cls->freeResult();
$count = count($rl_rows);
output('count['.$count.']'.$nl);
if (is_array($rl_rows) && $count > 0) {
	foreach ($rl_rows as $row) {
	//for ($i = 0; $i < $count; $i ++) {
		//$row = $rl_rows[$i];
		
		$step = 0;
		output($nl.$row['property_id'].'> segment '.(++$step));
		$r_rows = $bid_room_cls->getRows('SELECT agent_id
										  FROM '.$bid_room_cls->getTable().' 
										  WHERE property_id = '.$row['property_id'].' ORDER BY time_joined ASC', true);
		$bid_room_cls->freeResult();
		if (is_array($r_rows) && count($r_rows) > 0 && (!$property_cls->isLocked($row['property_id']) || $property_cls->isExpire($row['property_id']))) {
			//$p_row = $property_cls->getRow('property_id = '.$row['property_id']);
			$p_row = $property_cls->getCRow(array('end_time'), 'property_id = '.(int)$row['property_id']);
			$property_cls->freeResult();
			output('property:'.$row['property_id'].' remain :['.remainTime($p_row['end_time']).']');
			if (remainTime($p_row['end_time']) > (int)$config_cls->getKey('general_active_autobid_time')) {
				unset($p_row);
				continue;
			}
			
			
			if (remainTime($p_row['end_time']) < 0) {
				$bid_room_cls->delete('property_id = '.$row['property_id']);
			}
			
			
			$property_cls->lock($row['property_id']);
			$property_cls->freeResult();
			$nxt_agent_id = 0;
			
			//BEGIN SET next IS ONLY ROOM
			$b_row = $bid_cls->getRow('SELECT bid.agent_id, bid.time
									   FROM '.$bid_cls->getTable().' AS bid, '.$bid_room_cls->getTable().' AS bid_room
									   WHERE bid.property_id = bid_room.property_id  AND bid.agent_id = bid_room.agent_id 
											 AND bid_room.property_id = '.$row['property_id'].'
									   ORDER BY bid.price DESC', true);
			$bid_cls->freeResult();
			if (count($r_rows) == 1 || (!is_array($b_row) || count($b_row) == 0)) {
				//WHEN room == 1 OR NOT BIDDER IN ROOM BID YET
				$nxt_agent_id = $r_rows[0]['agent_id'];
			} else {
				$nxt_agent_id = $bid_room_cls->getNext($b_row['agent_id'], $row['property_id']);
				$bid_room_cls->freeResult();
				//$b2_row = $bid_cls->getRow('agent_id = '.$nxt_agent_id.' AND property_id = '.$row['property_id'].' ORDER BY `time` DESC');
			}
			//END
			
			
			//WE ONLY BID WHEN next IS NOT LAST BIDER
			$b3_row =  Bid_getLastBidByPropertyId($row['property_id']);
			if ($nxt_agent_id > 0 && $nxt_agent_id != @$b3_row['agent_id']) { 
				output(', segment '.(++$step));
				
				$abs_row = $autobid_setting_cls->getRow('SELECT money_max, money_step, money_step
														 FROM '.$autobid_setting_cls->getTable().'
														 WHERE agent_id = '.$nxt_agent_id.' AND property_id = '.$row['property_id'], true);
				$autobid_setting_cls->freeResult();
				if (is_array($abs_row) && count($abs_row) > 0) {
					$price = PE_getPriceForBid($row['property_id']);
					if ($price >= $abs_row['money_max']) {
						$autobid_setting_cls->update(array('accept' => 0),'agent_id = '.$nxt_agent_id.' AND property_id = '.$row['property_id']);
						$bid_room_cls->del($nxt_agent_id, $row['property_id']);
						$autobid_setting_cls->setReceived(array('agent_id' => $nxt_agent_id, 'property_id' => $row['property_id'], 'received' => 1));
					} else {
						$money_step = ($price + $abs_row['money_step']) > $abs_row['money_max'] ? $abs_row['money_max'] - $price : $abs_row['money_step'];
						output(', segment '.(++$step));
						// DOUBLE BID REASON
						Bid_addByBidder($nxt_agent_id, $row['property_id'], $money_step,0,false,true,true);
						unset($money_step);
					}
					unset($price);
				}
				
				unset($nxt_agent_id, $b3_row, $abs_row);
				//$b3_row = $abs_row = null;
			}
			unset($p_row);
			output(', segment '.(++$step).$nl);
			$property_cls->unLock($row['property_id']);
		}
		
		//END	
		$property_cls->freeResult();	
		if ($step == 4) {
			//usleep(200000);
		}
		unset($step, $row);
		//$row = null;
	}
}
unset($rl_rows);
$bid_room_cls->freeResult();
$config_cls->freeResult();
?>