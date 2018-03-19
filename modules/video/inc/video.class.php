<?php
class Video extends Model{
	public function __construct() {
		parent::__construct();
		$this->table = 'videos';
		$this->id = 'video_id';
		$this->fields = array('video_id' => 0,
						'video_name' => '',
						'video_file' => '',
						'video_content' => '',
						'is_embed' => '');
	}
}
?>