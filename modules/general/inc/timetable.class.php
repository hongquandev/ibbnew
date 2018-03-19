<?php
class Timetable extends Model {
	public function __construct() {
		parent::__construct();
		$this->table = 'timetable';
		$this->id = 'timetable_id';
		$this->fields = array('timetable_id' => 0,
							'key' => '',
							'begin_time' => '0000-00-00 00:00:0');
	}
}
?>