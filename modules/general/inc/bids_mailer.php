<?php
class Bids_mailer extends Model{
	public function __construct(){
		parent::__construct();
		$this->id = array('property_id','agent_id','bids_mailer_id');
		$this->table = 'bids_mailer';
		$this->fields = array();
               /* array('bids_mailer_id' => 0,
                              'property_id' => 0,
							  'agent_id' => 0,
                              'email' => "",
                              'bid_price' => 0,
							  'sent' => 0,
                              'auto_bid' => 0,  
							  'bid_time' => '0000-00-00 00:00:00');*/
	}
}
