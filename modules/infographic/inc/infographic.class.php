<?php
class Infographic extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'cms_infographic';
        $this->id = 'cms_infographic_id';
        $this->fields = array('cms_infographic_id' => 0,
            'page_id' => 0,
            'title_step_1' => '',
            'content_step_1' => '',
            'title_step_2' => '',
            'content_step_2' => '',
            'title_step_3' => '',
            'content_step_3' => '',
            'title_step_4' => '',
            'content_step_4' => '',
            'title_step_5' => '',
            'content_step_5' => '',
            'title_step_6' => '',
            'content_step_6' => '',
        );
    }
}

if (!isset($infographic_cls) or !($infographic_cls instanceof Infographic)) {
    $infographic_cls = new Infographic();
}
?>