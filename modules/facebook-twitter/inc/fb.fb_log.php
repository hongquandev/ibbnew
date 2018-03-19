<?php
include_once ROOTPATH.'/includes/model.class.php';
class FB_log extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'fb_log';
		
		$this->id = 'fb_id';
		
		$this->fields = array('fb_id' => 0,
							'message' => '',
							'created_at' => '0000-00-00 00:00:00');
	
	}
}

?>