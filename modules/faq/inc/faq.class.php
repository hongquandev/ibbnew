<?php
 class Faq extends Model{

	public function __construct() {
		parent::__construct();
		$this->table = 'faq';
		$this->id = 'faq_id';
		$this->fields = array('faq_id' => 0,
							  'title' => '',
							  'description' => '',
							  'active' => 1,
							  'create_date' => '0000-00-00',
							  'update_date' => '0000-00-00'
							);
		}
	
}

?>