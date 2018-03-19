<?php
class Press_article extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'press_article';

		$this->id = 'press_id';

		$this->fields = array('press_id' => 0,
                            'cat_id'=>0,
							'title' => '',
                            'content'=>'',
                            'seo_url'=>'',
                            'active' => 0,
                            'tag'=>'',
                            'user_id'=>'',
                            'creation_date'=>'0000-00-00 00:00:00',
                            'modified_date'=>'0000-00-00 00:00:00',
                            'show_date'=>'0000-00-00 00:00:00',
                            'publish_facebook'=>0,
                            'publish_twitter'=>0,
                            'scan'=>0
							);

	}
}