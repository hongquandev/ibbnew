<?php
class Theblock_Banner extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'theblock_banner';
		$this->id = 'theblock_banner_id';
		$this->fields = array('theblock_banner_id' => 0,
						'link_header' => '',
						'link_footer' => '',
						'cms_page' => '',
						'theblock_id' => '',
						'active' => '',
                        'upload_time' => '0000-00-00');
	}
}
?>