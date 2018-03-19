<?php
class Calendar extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'calendar';
		$this->id = 'calendar_id';
		$this->fields = array('calendar_id' => 0,
							'property_id' => 0,
							'begin' => '0000-00-00 00:00:00',
							'end' => '0000-00-00 00:00:00',
							'repeat' => 0,
							'temp' => '',
                            'daily_scan' => 0,
                            'last_time_daily' => '0000-00-00 00:00:00',
                            'last_time_weekly' => '0000-00-00 00:00:00',
                            'change_time' => '0000-00-00 00:00:00',
                            'is_max_end_time' => 0,
                            'allow_weekly' => 0,
                            );
	}
}
?>