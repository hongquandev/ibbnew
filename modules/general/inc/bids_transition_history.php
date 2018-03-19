<?php
class bids_transition_history extends Model{
	public function __construct(){
		parent::__construct();
		$this->id = array('property_id','agent_id','price','time');
		$this->table = 'bids_transition_history';
		$this->fields = array('property_id' => 0,
							  'agent_id' => 0,
							  'step' => 0.00,
							  //NUMBER MONEY WAS ADDED AFTER BIDDING
							  'price' => 0.00,
							  'time' => '0000-00-00 00:00:00',
                              'property_transition_history_id' => 0 );
	}
}

