<?php
include_once ROOTPATH.'/includes/model.class.php';
class property_history extends Model{
	public function __construct(){
		parent::__construct();
		$this->id = 'property_transition_history_id';
		$this->table = 'property_transition_history';
		$this->fields = array('property_transition_history_id' => 0,
							  'property_id' => 0,
                              'auction_sale' => 0,
							  'start_price' => 0.00,
							  'reserve_price' => 0.00,
                              'bid_price' => 0.00,
                              'last_bidder' => 0.00,
							  'transition_time' => '0000-00-00 00:00:00',
                              'end_time' => '0000-00-00 00:00:00',
                              'start_time' => '0000-00-00 00:00:00');
	}

    public function get_Fields($property_id)
    {
        global $property_cls;
        $data=$property_cls->getRows('SELECT * FROM property_transition_history WHERE property_id='.$property_id ,true);
        if(is_array($data) && count($data)){
            return $data;
        }else{
            return array();
        }
    }
    public function get_Field($property_id)
    {
        global $property_cls;
        $data = $property_cls->getRow('SELECT * FROM property_transition_history WHERE property_id='.$property_id.'
                                      ORDER BY property_transition_history_id DESC',true);
        if(is_array($data) && count($data)){
            if($data['bid_price'] == 0 OR !isset($data['bid_price'])){
                $row_bids_tran = $property_cls->getRow('SELECT max(price) as last_price FROM bids_transition_history WHERE property_id='.$property_id.'
                                                        AND property_transition_history_id =  '.$data['property_transition_history_id'],true);
                //print_r($row_bids_tran);
                if(count($row_bids_tran) > 0 and is_array($row_bids_tran))
                {
                    if($row_bids_tran['last_price'] != '' OR isset($row_bids_tran['last_price'])){
                        $data['bid_price'] = $row_bids_tran['last_price'];
                        $property_history_cls = new property_history();
                        $property_history_cls->update($data,'property_transition_history_id='.$data['property_transition_history_id']);
                        unset($property_history_cls);
                    }
                }
            }
            return $data;
        }else{
            return array();
        }
    }
}
?>