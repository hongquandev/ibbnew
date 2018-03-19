<?php
class ReportEmail extends Model {

	public function __construct() {
		parent::__construct();
		$this->table = 'report_email';
		$this->id = 'report_id';
		$this->fields = array('report_id' => 0,
						'date_create' => '0000-00-00',
						'title' => '',
						'send_number' => 0					
						);
	}
	
}
?>