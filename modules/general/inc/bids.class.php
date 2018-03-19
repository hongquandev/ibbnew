<?php
class Bids extends Model{
	public function __construct(){
		parent::__construct();
		$this->id = array('property_id','agent_id','price','time');
		$this->table = 'bids';
		$this->fields = array('property_id' => 0,
							  'agent_id' => 0,
							  'step' => 0.00,
							  //NUMBER MONEY WAS ADDED AFTER BIDDING
							  'price' => 0.00,
							  'time' => '0000-00-00 00:00:00',
							  'data' => '',
                              'in_room' => 0,
                              'is_offer' => 0,
							  'type_approved' => 0);
	}
}
?>