<?php
class Bid_track extends Model{
	public function __construct(){
		parent::__construct();
		$this->id = '';
		$this->table = 'bid_track';
		$this->fields = array('data' => '',
							  'time' => '0000-00-00 00:00:00'
							  );
	}
	
}
?>