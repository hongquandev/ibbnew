<?php
 class ContentFaq extends Model{

	public function __construct() {
		parent::__construct();
		$this->table = 'content_faq';
		$this->id = 'content_id';
		$this->fields = array('content_id' => 0,
							  'position' => 0,
							  'question' => '',
							  'answer' => '',
							  'create_time' => '0000-00-00',
							  'update_time' => '0000-00-00',
                              'active'=>0
							);
		}
	
}

?>