<?php
class Bids_stop extends Model{
	public function __construct(){
		parent::__construct();
		$this->id = array('property_id','agent_id');
		$this->table = 'bids_stop';
		$this->fields = array('property_id' => 0,
							  'agent_id' => 0,
							  'time' => '0000-00-00 00:00:00');
	}
}

