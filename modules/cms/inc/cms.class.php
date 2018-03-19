<?php
class Cms extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'cms_page';
		$this->id = 'page_id';
		$this->fields = array('page_id' => 0,
						'parent_id' => 0,
						'title' => '',
						'title_chinese' => '',
						'content' => '',
						'content_chinese' => '',
						'creation_time' => '0000-00-00 00:00:00',
						'update_time' => '0000-00-00 00:00:00',
						'is_active' => 1,
                        'is_tour_guide' => 0,
						'views' => 0,
						'sort_order' => 0,
						'dateviews' => '0000-00-00',
						'set_faq' =>0,
						'action' => '',
						'permit' => 0,
						'type' => 0,
						'title_frontend' => '',
						'alias_title' => '',
                        'allow_display_center_banner' => 0,
						'permit_buyer' => 0,
						'permit_partner' => 0,
                        'deny_access'=> '',
                        'key'=>'',
                        'theme_id' => 0,
                        'key_url' => '',
        );
	}
}
?>