<?php
class Cron extends Model{
	public function __construct(){
		parent::__construct();
		
		$this->table = 'cron';
		
		$this->id = 'cron_id';
		
		$this->fields = array('cron_id' => 0,
						'key' => '',
						'scan' => 0,
                        'cron_type' => '',
						'describe' => '');
	}


}
?>