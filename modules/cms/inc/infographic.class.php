<?php
class Infographic extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'cms_infographic';
        $this->id = 'id';
        $this->fields = array('id' => 0,
            'page_id' => 0,
            'step' => 0,
            'icon_on' => '',
            'icon_off' => '',
            'title' => '',
            'content' => '',
        );
    }
    
    public function insert_infographic($infographic_data = array()) {
        if(is_array($infographic_data) && count($infographic_data) > 0 ){
            $page_id = $infographic_data['page_id'];
            $infographic_icon_on = $infographic_data['on_icons'];
            $infographic_icon_off = $infographic_data['off_icons'];
            $infographic_title = $infographic_data['titles'];
            $infographic_content = $infographic_data['contents'];
            foreach ($infographic_title as $key => $title ) {
                $icon_on = $infographic_icon_on[$key];
                $icon_off = $infographic_icon_off[$key];
                $content = $infographic_content[$key];
                //if(!empty($title) && !empty($infographic_content[$key]) ) {
                    $data = array('page_id'=>$page_id, 'step' => $key, 'title' => $title, 'content' => $content, 'icon_on'=> $icon_on, 'icon_off' => $icon_off);
                    $this->insert($data);
                //}
            }
        }
    }
    
    public function update_infographic($infographic_data = array()) {
        if(is_array($infographic_data) && count($infographic_data) > 0 && $infographic_data['page_id'] > 0){
            $page_id = $infographic_data['page_id'];
            $infographic_icon_on = $infographic_data['on_icons'];
            $infographic_icon_off = $infographic_data['off_icons'];
            $infographic_title = $infographic_data['titles'];
            $infographic_content = $infographic_data['contents'];
            foreach ($infographic_title as $key => $title ) {
                $icon_on = $infographic_icon_on[$key];
                $icon_off = $infographic_icon_off[$key];
                $content = $infographic_content[$key];
                //if(!empty($title) && !empty($infographic_content[$key]) ) {
                    $data = array( 'title' => $title, 'content' => $content, 'icon_on'=> $icon_on, 'icon_off' => $icon_off);
                    //var_dump($data);die();
                    $this->update($data, ' page_id =' .$page_id.  ' AND step =' . $key);
                //}
            }
        }
    }
}

if (!isset($infographic_cls) or !($infographic_cls instanceof Infographic)) {
    $infographic_cls = new Infographic();
}
?>