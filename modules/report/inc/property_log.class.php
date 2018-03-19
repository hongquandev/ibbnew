<?php
class Property_Log extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'property_log';
		$this->id = 'property_log_id';
		$this->fields = array('property_log_id' => 0,
							'property_id' => 0,
							'created_at' => '0000-00-00',
							'view' => 0);
	}
}
?>