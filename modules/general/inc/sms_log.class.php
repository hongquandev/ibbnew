<?php
class SMS_log extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'sms_log';
		
		$this->id = 'log_id';
		
		$this->fields = array('log_id' => 0,
							'message' => '',
							'created_at' => '0000-00-00 00:00:00',
							'status' => '');
	
	}
}
?>