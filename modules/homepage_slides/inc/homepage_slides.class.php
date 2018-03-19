<?php

class Homepage_slides extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'homepage_slides';
        $this->id = 'id';
        $this->fields = array('id' => 0,
            'image' => '',
            'text' => '',
            'position' => '',
            'active' => 1,
            'date_creation' => '0000-00-00 00:00:00',
        );
    }
}
if (!isset($slide_cls) or !($slide_cls instanceof Homepage_slides)) {
    $slide_cls = new Homepage_slides();
}

?>