<?php
class Property_package_payment extends Model
{
    /**
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'property_package_payment';
        $this->id = 'property_package_payment_id';
        $this->fields = array('property_package_payment_id' => 0,
            'property_id' => 0,
            'package_id' => 0,
            'option_id' => 0,
            'pay_status' => 0,
            'group_id' => 0,
            'payment_id' => 0,
        );
    }


    /**
     **/

    public function getItem($id = 0, $field = '')
    {
        $row = $this->getRow($this->id . ' = ' . $id);
        if (is_array($row) && count($row) > 0 && strlen($field) > 0) {
            return @$row[$field];
        }
        return null;
    }

    /**
     **/

    public function getItemByField($field, $value, $result = array())
    {
        $row = $this->getRow("`$field` = '$value'");
        if (is_array($row) && count($row) > 0) {
            if (is_array($result)) {
                return $row;
            } else {
                return $row[$result];
            }
        }
        return null;
    }
}

?>