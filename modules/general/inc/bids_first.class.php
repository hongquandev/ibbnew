<?php

class Bids_first extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->id = array('property_id', 'agent_id', 'pay_bid_first_status', 'bid_first_time');
        $this->table = 'bids_first_payment';
        $this->fields = array('property_id' => 0,
            'agent_id' => 0,
            'pay_bid_first_status' => 0,
            'abort' => 0,
            //NUMBER MONEY WAS ADDED AFTER BIDDING
            'bid_first_time' => '0000-00-00 00:00:00');
    }

    public function getStatus($agent_id = 0, $property_id = 0)
    {
        $row = $this->getRow('agent_id = ' . (int)$agent_id . ' AND property_id = ' . (int)$property_id);
        if (is_array($row) && count($row) > 0) {
            return (bool)$row['pay_bid_first_status'];
        }
        return false;
    }
}

?>