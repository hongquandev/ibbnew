<?php
/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 8:35 AM
 *
 */
class Help_center extends Model{
        public function __construct(){
        parent::__construct();
        $this->table = 'help_center';
        $this->id = 'helpID';

        $this->fields = array('helpID' => 0,
                              'catID' => 0,
                              'question' => '',
                              'answer' => '',
                              'active' => 1,
                              'position' => 0,
                              'allow'=>'',
                              'creation_time'=>'0000-00-00',
                              'update_time'=>'0000-00-00'
                              );
        }
}
?>