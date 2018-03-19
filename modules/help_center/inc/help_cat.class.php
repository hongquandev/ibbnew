<?php
/**
 * Created by JetBrains PhpStorm.
 * User: NHUNG
 * Date: 10/22/11
 * Time: 8:36 AM
 *
 */
class Help_cat extends Model{
        public function __construct(){
        parent::__construct();
        $this->table = 'help_cat';
        $this->id = 'catID';

        $this->fields = array('catID' => 0,
                              'title' => '',
                              'key' => '',
                              'active' => 1,
                              'position' => 0,
                              'allow'=>'',
                              'description'=>''
                              );
        }
}
?>