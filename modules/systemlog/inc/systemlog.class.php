<?php
class SystemLog extends Model{

	public function __construct() {
		parent::__construct();
		$this->table = 'systemlogs';
		$this->id = 'ID';
		$this->fields = array('ID' => 0,
								'Updated' => '0000-00-00 00:00:00',
								'Action' => '',
								'Detail' => '',
								'UserID' => '',
								'IPAddress' => ''
						);
	}
	
}
?>