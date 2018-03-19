<?php

class Bids_term extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->id = array('bidder_id', 'company_id');
        $this->table = 'bids_register_term';
        $this->fields = array('bidder_id' => 0,
            'status' => 0,
            'file_application' => '',
            'data_application' => '',
            'data_user_detail' => '',
            'files_application_supporting' => ''
        );
    }

    public function addNew($bidder_id, $agent_id = 0, $file)
    {
        $data = getPost('field');
        $parent = A_getAgentParentInfo($agent_id);
        if (isset($parent['agent_id']) && $parent['agent_id'] > 0) {
            $row = $this->getRow('bidder_id = ' . $bidder_id . ' AND company_id = ' . $parent['agent_id']);
            if (is_array($row) and count($row) > 0) {
                $this->update(array('status' => 1, 'file' => $file, 'data' => serialize($data)), 'bidder_id = ' . $bidder_id . ' AND company_id = ' . $parent['agent_id']);
            } else {
                $this->insert(array('bidder_id' => $bidder_id,
                    'company_id' => $parent['agent_id'],
                    'status' => 1,
                    'data' => serialize($data),
                    'file' => $file));
            }
        }
    }

    public function addApplicationForm($agent_id = 0, $file = '', $data_application = array(), $status = 0)
    {
        if (isset($agent_id) && $agent_id > 0) {
            $data = array('status' => 0);
            if ($file != "") {
                $data['file_application'] = $file;
            }
            if (count($data_application) > 0) {
                $data['data_application'] = serialize($data_application);
            }
            if($status == 1){
                $data['status'] = 1;
            }
            $row = $this->getRow('bidder_id = ' . $agent_id);
            if (is_array($row) and count($row) > 0) {
                $this->update($data, 'bidder_id = ' . $agent_id);
            } else {
                $data['bidder_id'] = $agent_id;
                $this->insert($data);
            }
            if (!$this->hasError()) {
                return true;
            }
        }
        return false;
    }

    public function updateStatusForm($agent_id = 0)
    {
        if (isset($agent_id) && $agent_id > 0) {
            $row = $this->getRow('bidder_id = ' . $agent_id);
            if (is_array($row) and count($row) > 0) {
                $this->update(array('status' => 1), 'bidder_id = ' . $agent_id);
                if (!$this->hasError()) {
                    return true;
                }
            }
        }
        return false;
    }

    public function addDataUserDetail($agent_id = 0, $data = array(), $files_application_supporting = array())
    {
        $row = $this->getRow('bidder_id = ' . $agent_id);
        if (is_array($row) and count($row) > 0) {
            /*UPDATE*/
            $data_row = unserialize($row['data_user_detail']);
            $data = array_merge($data_row, $data);
            $data_fs = unserialize($row['files_application_supporting']);
            if (is_array($data_fs) && count($data_fs) > 0) {
                /*Delete File*/
                $file_delete_ar = $_POST['files_deleted'];
                if (is_array($file_delete_ar) && count($file_delete_ar) > 0) {
                    foreach ($file_delete_ar as $file => $val) {
                        if ($val == 'deleted') {
                            unset($data_fs[$file]);
                        }
                    }
                }
                $files_application_supporting = array_merge($data_fs, $files_application_supporting);
            }
            unset($data['files_deleted']);
            $this->update(array('data_user_detail' => serialize($data), 'files_application_supporting' => serialize($files_application_supporting)), 'bidder_id = ' . $agent_id);
        } else {
            $this->insert(array('bidder_id' => $agent_id, 'data_user_detail' => serialize($data), 'files_application_supporting' => serialize($files_application_supporting)));
        }
        if (!$this->hasError()) {
            return true;
        }
        return false;
    }

    public function addFileApplicationSupport($agent_id = 0, $files_application_supporting = array())
    {
        $row = $this->getRow('bidder_id = ' . $agent_id);
        if (is_array($row) and count($row) > 0) {
            /*UPDATE*/
            $data_fs = unserialize($row['files_application_supporting']);
            if (is_array($data_fs) && count($data_fs) > 0) {
                /*Delete File*/
                $file_delete_ar = $_POST['files_deleted'];
                if (is_array($file_delete_ar) && count($file_delete_ar) > 0) {
                    foreach ($file_delete_ar as $file => $val) {
                        if ($val == 'deleted') {
                            unset($data_fs[$file]);
                        }
                    }
                }
                $files_application_supporting = array_merge($data_fs, $files_application_supporting);
            }
            $this->update(array('files_application_supporting' => serialize($files_application_supporting)), 'bidder_id = ' . $agent_id);
        } else {
            $this->insert(array('bidder_id' => $agent_id, 'files_application_supporting' => serialize($files_application_supporting)));
        }
        if (!$this->hasError()) {
            return true;
        }
        return false;
    }

    public function addDataApplicationForm($agent_id = 0, $data_application = array())
    {
        $row = $this->getRow('bidder_id = ' . $agent_id);
        if (is_array($row) and count($row) > 0) {
            $this->update(array('data_application' => serialize($data_application)), 'bidder_id = ' . $agent_id);
        } else {
            $this->insert(array('bidder_id' => $agent_id, 'data_application' => serialize($data_application)));
        }
        if (!$this->hasError()) {
            return true;
        }
        return false;
    }

    public function addFileUser($agent_id = 0, $files = array())
    {
        $row = $this->getRow('bidder_id = ' . $agent_id);
        if (is_array($row) and count($row) > 0) {
            /*UPDATE*/
            $data_fs = unserialize($row['data_user_detail']);
            if (is_array($data_fs) && count($data_fs) > 0) {
                /*Delete File*/
                $file_delete_ar = $_POST['files_deleted'];
                if (is_array($file_delete_ar) && count($file_delete_ar) > 0) {
                    foreach ($file_delete_ar as $file => $val) {
                        if ($val == 'deleted') {
                            unset($data_fs[$file]);
                        }
                    }
                }
                $files = array_merge($data_fs, $files);
            }
            $this->update(array('data_user_detail' => serialize($files)), 'bidder_id = ' . $agent_id);
        } else {
            $this->insert(array('bidder_id' => $agent_id, 'data_user_detail' => serialize($files)));
        }
        if (!$this->hasError()) {
            return true;
        }
        return false;
    }

    public function getDataUserDetail($agent_id, $type = 'short_name')
    {
        $result = array();
        $row = $this->getRow('bidder_id = ' . $agent_id);
        if (is_array($row) && count($row) > 0) {
            $files = unserialize($row['data_user_detail']);
            if (is_array($files) && count($files) > 0) {
                foreach ($files as $key => $val) {
                    if ($type == 'short_name') {
                        $result[$key] = $this->getPath($val);
                        $result[$key.'_link'] = $val;
                    } else {
                        $result[$key] = $val;
                    }
                }
            }
        }
        return $result;
    }

    public function getFilesSupporting($agent_id, $type = 'short_name')
    {
        $result = array();
        $row = $this->getRow('bidder_id = ' . $agent_id);
        if (is_array($row) && count($row) > 0) {
            $files = unserialize($row['files_application_supporting']);
            if (is_array($files) && count($files) > 0) {
                foreach ($files as $key => $val) {
                    if ($type == 'short_name') {
                        $result[$key] = $this->getPath($val);
                        $result[$key.'_link'] = $val;
                    } else {
                        $result[$key] = $val;
                    }
                }
            }
        }
        return $result;
    }

    public function getFileApplication($agent_id, $type = 'short_name')
    {
        $file = '';
        $row = $this->getRow('bidder_id = ' . $agent_id);
        if (is_array($row) && count($row) > 0) {
            if($row['status'] == 1){
                return '';
            }
            if ($type == 'short_name') {
                $file = $this->getPath($row['file_application']);
            } else {
                $file = $row['file_application'];
            }
        }
        return $file;
    }

    public function getPath($link, $type = "filename")
    {
        if (strlen($link)) {
            $arr = explode('/', $link);
            if ($type == 'filename') {
                return end($arr);
            } else {
                unset($arr[count($arr) - 1]);
                return implode('/', $arr);
            }
        }
        return '';
    }
}

?>