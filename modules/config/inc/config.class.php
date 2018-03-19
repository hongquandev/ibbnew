<?php
class Config extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'config';
		$this->id = 'config_id';
		$this->fields = array('config_id' => 0,
								'key' => '',
								'value' => '');
	}
}
?>