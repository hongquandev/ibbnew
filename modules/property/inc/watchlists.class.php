<?php
class Watchlists extends Model{
	public function __construct(){
		parent::__construct();
		
		$this->table = 'watchlists';
		
		$this->id = 'watchlist_id';
		
		$this->fields = array('watchlist_id' => 0,
						'agent_id' => 0,
						'property_id' => 0,
						'viewed_time' => '0000-00-00 00:00:00');
	}
}
?>