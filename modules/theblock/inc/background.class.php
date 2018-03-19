<?php
class Background extends Model{
	/**
	Construct
	*/
	public function __construct(){
		parent::__construct();
		$this->table = 'background';

		$this->id = 'background_id';

		$this->fields = array('background_id' => 0,
							'link' => '',
							'active' => '',
                            'cms_page'=>'',
                            'upload_time'=>'0000-00-00',
                            'repeat'=>0,
                            'fixed'=>0,
                            'background_color'=>'',
                            'theblock_id'=>'',
                            'agent_id'=>0,
                            'type'=>''
							);
	}
}
?>