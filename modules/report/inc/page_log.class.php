<?php
class Page_Log extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'page_log';
		$this->id = 'page_log_id';
		$this->fields = array('page_log_id' => 0,
								'page_id' => 0,
								'key' => '',
								'title' => '');
	}

}		
?>