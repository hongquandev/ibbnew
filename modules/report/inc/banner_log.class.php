<?php
class Banner_Log extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'banner_log';
		$this->id = 'banner_log_id';
		$this->fields = array('banner_log_id' => 0,
							'banner_id' => 0,
							'created_at' => '0000-00-00',
							'click' => 0,
							'view' => 0);
	}
}
?>