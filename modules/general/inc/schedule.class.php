<?php
class Schedule extends Model {
	public function __construct() {
		parent::__construct();
		$this->table = 'schedule';
		$this->id = 'schedule_id';
		$this->fields = array('schedule_id' => 0,
							'key' => '',
							'begin_time' => '0000-00-00 00:00:0');
	}
}
?>