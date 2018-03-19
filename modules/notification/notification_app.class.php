<?php
class Notification_app extends Model
{
    const ANDROID = 'android';
    const IPHONE = 'iphone';

    /**
    Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = 'notification_app';

        $this->id = 'id';

        $this->fields = array('id' => 0,
                              'registration_id' => '',
                              'issuer_id' => 0,
                              'type' => ''
        );

    }

    public function getRegId($issuer_id = 0, $type = '')
    {
        $rows = $this->getRows('issuer_id =\'' . $issuer_id . '\' AND type=\'' . $type . '\'');

        if (is_array($rows) && count($rows) > 1) {
            $this->delete('issuer_id =\'' . $issuer_id . '\' AND type=\'' . $type . '\'');
            return 0;
        }

        if (is_array($rows) && count($rows) > 0) {
            return $rows[0]['id'];
        }

        return null;
    }

    public function getRegs($issuer_id = 0, $type = 'android')
    {
        if ($issuer_id > 0) {
            $rows = $this->getRows("issuer_id = '" . $issuer_id . "' AND type='" . $type . "'");
        } else {
            $rows = $this->getRows("type='" . $type . "'");
        }
        if (is_array($rows) && count($rows) > 0) {
            return $rows;
        }

        return null;
    }

    public function getRegIDs($issuer_id = 0, $type = 'android')
    {
        $sql = 'SELECT DISTINCT registration_id FROM notification_app ';
        if ($issuer_id > 0) {
            $sql .= ' WHERE issuer_id=\'' . $issuer_id . '\' AND type=\'' . $type . '\'';
        } else {
            $sql .= ' WHERE type=\'' . $type . '\'';
        }
        //$rows = $this->query($sql);
		$rows = $this->getRows($sql, true);
        if (is_array($rows) && count($rows) > 0) {
            $registrationIDs = array();
            foreach ($rows as $row)
            {
                $registrationIDs[] = $row['registration_id'];
            }
            return $registrationIDs;
        }

        return null;
    }

     public function getRegIDsWithoutUserId($issuer_id = 0, $type = 'android')
    {

        $sql = 'SELECT DISTINCT registration_id FROM notification_app ';
        if ($issuer_id > 0) {
             $myRow = $this->getRegId($issuer_id, $type);
            $where = '';
            if($myRow!=null){
                $where = ' AND registration_id <> \''.$myRow['registration_id'].'\'';
            }
            $sql .= ' WHERE issuer_id <>\'' . $issuer_id . '\' AND type=\'' . $type . '\' '.$where;
        } else {
            $sql .= ' WHERE type=\'' . $type . '\'';
        }
        //$rows = $this->query($sql);
		$rows = $this->getRows($sql, true);
        if (is_array($rows) && count($rows) > 0) {
            $registrationIDs = array();
            foreach ($rows as $row)
            {
                $registrationIDs[] = $row['registration_id'];
            }
            return $registrationIDs;
        }

        return null;
    }

    public function doSave($issuer_id, $reg_id, $type)
    {
        $id = $this->getRegId($issuer_id, $type);
        if ($id == null || $id == 0) {
            $this->insert(array('issuer_id' => $issuer_id, 'registration_id' => $reg_id, 'type' => $type));
        } else {
            $this->update(array('registration_id' => $reg_id, 'type' => $type), 'id = \'' . $id . '\'');
        }
    }


}