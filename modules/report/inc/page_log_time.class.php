<?php
class Page_Log_Time extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'page_log_time';
		//$this->id = 'page_log_id';
		$this->fields = array('page_log_id' => 0,
							  'create_at' => '0000-00-00',
							  'view' => 0);
	}
}		
?>