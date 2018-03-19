<?php
ini_set('display_errors',0);
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include ROOTPATH.'/admin/functions.php';
include_once ROOTPATH.'/modules/configuration/inc/config.class.php';
include_once ROOTPATH.'/includes/pagging.class.php';
include_once ROOTPATH.'/modules/property/inc/property.php';
include_once 'inc/package.php';

include_once ROOTPATH.'/modules/systemlog/inc/systemlog.php';
if (!isset($systemlog_cls) or !($systemlog_cls instanceof SystemLog)) {
	$systemlog_cls = new SystemLog();
}

if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

if (!isset($config_cls) or !($config_cls instanceof Config)) {
	$config_cls = new Config();
}


$action = getParam('action','');
$token = getParam('token');

$perm_ar = permission($_SESSION['Admin']['role_id'], Tab_getIdFromToken($token));
switch ($action){
    case 'loadList':
		$property_type_ar = PEO_getOptions('property_type', array('Any')) + PEO_getOptions('property_type_commercial');
		$area_ar = B_getOptionsDisplay();
		$page_ar = CMS_getTypePage();
		$state_ar = R_getOptions($config_cls->getKey('general_country_default'), array('Any'));
		$country_ar = R_getOptions();
		
	
        $html = '<table width="100%" class="grid-table" cellspacing="1">
                    <thead class="title">
                        <td width="30px" align="center" style="font-weight:bold;color:#fff;">#</td>
                        <td align="center" style="font-weight:bold;color:#fff;">Price</td>
						<td align="center" style="font-weight:bold;color:#fff;">Type</td>
						<td align="center" style="font-weight:bold;color:#fff;">Area</td>
						<!--<td align="center" style="font-weight:bold;color:#fff;">Page</td>-->
						<td align="center" style="font-weight:bold;color:#fff;">Country</td>
						<td align="center" style="font-weight:bold;color:#fff;">State</td>
                        <td align="center" style="font-weight:bold;color:#fff;width:100px;">Status</td>
                        <td align="center" style="font-weight:bold;color:#fff;width:100px;">Action</td>
                    </thead>
                    <tbody>';
        $p = (int)restrictArgs(getQuery('p',1));
        $p = $p <= 0 ? 1 : $p;
		$len = 10;

        $rows = $package_banner_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *
		                                      FROM '.$package_banner_cls->getTable().'
		                                      LIMIT '.(($p-1)*$len).','.$len,true);
        $total_rows = $package_banner_cls->getFoundRows();
        $pag_cls->setTotal($total_rows)
                ->setPerPage($len)
                ->setCurPage($p)
                ->setLenPage(10)
                ->setUrl('../modules/package/action.admin.php?action=loadList&token='.$token)
                ->setLayout('ajax')
                ->setFnc('loadList');
		if (is_array($rows) && count($rows) > 0) {
            $i = ($p-1)*$len + 1;
			foreach($rows as &$row) {
				$row['link_status'] = '?module=package&action=active-banner&package_id='.$row['package_id'].'&token='.$token;
				$row['link_edit'] = '?module=package&action=edit-banner&package_id='.$row['package_id'].'&token='.$token;
				$row['link_delete'] = '?module=package&action=delete-banner&package_id='.$row['package_id'].'&token='.$token;
                $status = $row['active'] == 1?'Active':'Inactive';
                $mod = $i%2 == 0?1:2;
                $html .= '<tr class="item'.$mod.'">
                             <td align="center">'.$i.'</td>
                             <td><span style="margin-left:4px;">$'.$row['price'].'</span></td>
							 <td><span style="margin-left:4px;">'.$property_type_ar[$row['property_type_id']].'</span></td>
							 <td><span style="margin-left:4px;">'.$area_ar[$row['area']].'</span></td>
							 <!--<td><span style="margin-left:4px;">'.$page_ar[$row['page_id']].'</span></td>-->
							 <td><span style="margin-left:4px;">'.$country_ar[$row['country_id']].'</span></td>
							 <td><span style="margin-left:4px;">'.$state_ar[$row['state_id']].'</span></td>
								
                             <td>
            	                <span style="margin-left:4px">
                    	        <center><a href="'.$row['link_status'].'">'.$status.'</a></center>
                                </span>
                             </td>
                             <td width="70px" align="center">
                                 <a href="'.$row['link_edit'].'" style="color:#0000FF">edit</a> |
                                 <a href="javascript:void(0)" onclick ="deleteItem2(\''.$row['link_delete'].'\')" style="color:#0000FF">delete</a>
                             </td>
                        </tr>';
                $i++;
			}
		}
        $html .= '</tbody>
                  </table>
                  '.$pag_cls->layout();
        die($html);
        break;
    case 'validate-option':
        return __validateOption();
        break;
    case 'load-group-list':
        return __loadGroupList();
        break;
    case 'list-package':
        return __listPackage();
        break;
    case 'multidelete-package':
    case 'delete-package':
        if ($perm_ar['delete'] == 1) {
            return __deletePackage();
        } else {
            die(json_encode($perm_msg_ar['delete']));
        }
        break;
    case 'multiactive-package':
    case 'active-package':
        if ($perm_ar['edit'] == 1) {
            return __activePackage();
        } else {
            die(json_encode($perm_msg_ar['edit']));
        }
        break;
    case 'load-option-list':
        return __loadOptionList();
        break;
}

function __loadGroupList(){
    global $package_property_group_cls, $pag_cls, $token;
    $html = '<table width="100%" class="grid-table" cellspacing="1">
                <tbody>
                <tr class="title">
                    <td width="30px" align="center" style="font-weight:bold;color:#fff;">#</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Title</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:100px;">Position</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:100px;">Status</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:100px;">System</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:100px;">Action</td>
                </tr>';
    $p = (int)restrictArgs(getQuery('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $len = 7;

    $rows = $package_property_group_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *
		                                      FROM ' . $package_property_group_cls->getTable() . '
		                                      ORDER BY `order` ASC
		                                      LIMIT ' . (($p - 1) * $len) . ',' . $len, true);
    $total_rows = $package_property_group_cls->getFoundRows();
    $pag_cls->setTotal($total_rows)
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage($len)
            ->setUrl('../modules/package/action.admin.php?action=load-group-list&token=' . $token)
            ->setLayout('ajax')
            ->setFnc('loadList');
    if (is_array($rows) && count($rows) > 0) {
        $i = ($p - 1) * $len + 1;
        foreach ($rows as &$row) {
            $row['link_status'] = '?module=package&action=active-group&package_id=' . $row['group_id'] . '&token=' . $token;
            $row['link_edit'] = '?module=package&action=edit-group&package_id=' . $row['group_id'] . '&token=' . $token;
            $row['link_delete'] = '?module=package&action=delete-group&package_id=' . $row['group_id'] . '&token=' . $token;
            $status = $row['is_active'] == 1 ? 'Active' : 'Inactive';
            $mod = $i % 2 == 0 ? 1 : 2;
            $delete = !$row['is_system'] ? ' | <a href="javascript:void(0)" onclick ="deleteItem2(\'' . $row['link_delete'] . '\')" style="color:#0000FF">delete</a>':'';
            $html .= '<tr class="item' . $mod . '">
                             <td align="center">' . $i . '</td>
                             <td><span style="margin-left:4px;">'. $row['name'] . '</span></td>
							 <td><span style="margin-left:4px;"><center>' . $row['order']. '</center></span></td>
                             <td>
            	                <span style="margin-left:4px">
                    	        <center><a href="' . $row['link_status'] . '">' . $status . '</a></center>
                                </span>
                             </td>
                             <td>
            	                <span style="margin-left:4px">
                    	        <center>'.($row['is_system'] == 1?'Yes':'No').'</center>
                                </span>
                             </td>
                             <td width="70px" align="center">
                                 <a href="' . $row['link_edit'] . '" style="color:#0000FF">edit</a>'.$delete.'
                             </td>
                        </tr>';
            $i++;
        }
    }
    $html .= '</tbody>
                  </table>
                  ' . $pag_cls->layout();
    die($html);
}

function __listPackage(){
    global $package_property_cls,$token;

	$start = (int)restrictArgs(getParam('start',0));
	$limit = (int)restrictArgs(getParam('limit',20));
	$sort_by = getParam('sort','pk.package_id');
	$dir = getParam('dir','ASC');
	$search_query = getParam('query');

	$search_where = '';
	if (strlen($search_query) > 0) {
		$search_where = "WHERE (pk.name LIKE '%".$search_query."%')";
	}

	$rows = $package_property_cls->getRows('SELECT SQL_CALC_FOUND_ROWS pk.*
							FROM '.$package_property_cls->getTable().' AS pk
							'.$search_where.'
							ORDER BY '.$sort_by.' '.$dir.'
							LIMIT '.$start.','.$limit,true);

	$total = $package_property_cls->getFoundRows();
	$topics = array();
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
            $edit_link = '?module=package&action=edit-property_new&package_id='.$row['package_id'].'&token='.$token;
			$row['edit_link'] = '<a href="'.$edit_link.'"><img src="/admin/resources/images/default/dd/table_edit.png"/></a>';

			//$delete_link = '../modules/package/action.admin.php?action=delete-property_new&package_id='.$row['package_id'].'&token='.$token;
			$row['delete_link'] = '<a onclick ="outAction(\'delete\','.$row['package_id'].')"><img src="/admin/resources/images/default/dd/delete.png"/></a>';
            $topics[] = $row;
		}
	}
	$result = array('totalCount' => $total, 'topics' =>formUnescapes($topics), 'limit' => $limit);
	die(json_encode($result));
}

function __loadOptionList(){
    global $package_property_option_cls, $pag_cls, $token;
    $groupId = restrictArgs(getQuery('group_id', 0));
    $option = getPost('option','');
    $html = '<table width="100%" class="grid-table" cellspacing="1">
                <tbody>
                <tr class="title">
                    <td width="30px" align="center" style="font-weight:bold;color:#fff;">#</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Title</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Code</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Option Type</td>
                    <td align="center" style="font-weight:bold;color:#fff;">Price</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:50px;">Position</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:50px;">Status</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:50px;">System</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:50px;">Remove</td>
                    <td align="center" style="font-weight:bold;color:#fff;width:50px;">Action</td>
                </tr>';
    $p = (int)restrictArgs(getQuery('p', 1));
    $p = $p <= 0 ? 1 : $p;
    $len = 7;
    if (strlen($option)){
        $allRows = json_decode($option,true);
        $rows = array_slice($allRows,($p - 1) * $len,$len);
        $total_rows = count($allRows);
    }else{
        $rows = $package_property_option_cls->getRows('SELECT SQL_CALC_FOUND_ROWS *
                                                  FROM ' . $package_property_option_cls->getTable() . '
                                                  WHERE group_id = '.$groupId.'
                                                  ORDER BY `order` ASC
                                                  LIMIT ' . (($p - 1) * $len) . ',' . $len, true);
        $total_rows = $package_property_option_cls->getFoundRows();
    }

    $pag_cls->setTotal($total_rows)
            ->setPerPage($len)
            ->setCurPage($p)
            ->setLenPage($len)
            ->setUrl('../modules/package/action.admin.php?action=load-option-list&group_id='.$groupId.'&token=' . $token)
            ->setLayout('ajax')
            ->setFnc('loadOptionList');
    $response = array();
    $optionType = getOptionsType();
    if (is_array($rows) && count($rows) > 0) {
        $i = ($p - 1) * $len + 1;
        foreach ($rows as &$row) {
            $status = $row['is_active'] == 1 ? 'Active' : 'Inactive';
            $mod = $i % 2 == 0 ? 1 : 2;
            $delete = !$row['is_system'] ? '<input type="checkbox" onclick="optionGrid.update(\''.$row['code'].'\')"/>':'';
            $html .= '<tr class="item' . $mod . '" id="option_'.$row['code'].'">
                             <td align="center" class="cell-uq">' . $i . '</td>
                             <td><span style="margin-left:4px;">'. $row['name'] . '</span></td>
                             <td><span style="margin-left:4px;">'. $row['code'] . '</span></td>
                             <td><span style="margin-left:4px;">'. $optionType[$row['type']] . '</span></td>
                             <td><span style="margin-left:4px;">'. showPrice_cent($row['price']) . '</span></td>
							 <td><span style="margin-left:4px;"><center>' . $row['order']. '</center></span></td>
                             <td class="cell-status">
            	                <span style="margin-left:4px">
                    	        <center><a href="javascript:void(0)" onclick="optionGrid.change(\''.$row['code'].'\')">' . $status . '</a></center>
                                </span>
                             </td>
                             <td>
            	                <span style="margin-left:4px">
                    	        <center>'.($row['is_system'] == 1?'Yes':'No').'</center>
                                </span>
                             </td>
                             <td align="center" class="cell-remove">'.$delete.'</td>
                             <td width="70px" align="center">
                                 <a href="javascript:void(0)" onclick="optionGrid.edit(\''.$row['code'].'\')" style="color:#0000FF">edit</a>
                             </td>
                        </tr>';
            $i++;
        }
    }
    $html .= '</tbody>
                  </table>
                  ' . $pag_cls->layout();
    $html .= '<script type="text/javascript">
                var optionGrid = new jsonOption(\'#options\',
                                    \'.edit-table#option-list table.grid-table\',
                                    \'#frmPackage\',
                                    \'/modules/package/action.admin.php?action=validate-option&group_id=' . $groupId . '&token=' . $token . '\');
                optionGrid.init();
                optionGrid._callbackResetAction_fnc.push(function() {
                    self[\'optionTable\'].reset();
                });
                optionGrid._callbackEditAction_fnc.push(function() {
                             if (!isNaN(optionGrid.index) && optionGrid.index != null){
                                var data = optionGrid.options[optionGrid.index];
                                if (data.option){
                                    jQuery.each(data.option, function(k,item){
                                        var childOption = {};
                                        childOption.id = k;
                                        jQuery.each(item, function(field,value){
                                            childOption[field] = value;
                                        });
                                        self[\'optionTable\'].addNewRow(childOption);
                                    });
                                }
                             }
                             return;
                        });
              </script>';
    $response['html'] = $html;
    $response['json'] = '';
    die(json_encode($response));
}

function __validateOption(){
    global $package_cls;
    $params = array();
    $params['group_id'] = getParam('group_id',0);
    foreach ($_POST as $key => $value) {
        if (preg_match('/option_([a-zA-Z_\d]+)/i', $key, $matches)) {
            if (count($matches) > 1) {
                $params[$matches[1]] = $package_cls->escape($_POST[$key]);
            }
        }
        if ($key == 'option'){
            $params['option'] = $value;
        }
        if ($key == 'price'){
            $params['price'] = $value;
        }

    }
    //validate code
    $pattern = '/^[a-z][a-z_0-9]{1,254}$/';
    if (!preg_match($pattern,$params['code'])){
        $response = array('error'=>1,
                         'message'=>'Attribute ' . $params['code'] . ' is invalid. Please use only letters (a-z), numbers (0-9) or underscore(_) in this field, first character should be a letter.');
        die(json_encode($response));
    }
    if (!PA_isUniqueCode($params)){
        $response = array('error'=>1,
                         'message'=>$params['code'].' is existed. Please choose another');
        die(json_encode($response));
    }

    $response = array();
    $oldOptions = $params;

    $json = $oldOptions;
    $options = getOptionsType();
    $delete = !$params['is_system'] ? '<input type="checkbox" onclick="optionGrid.update(\''.$params['code'].'\')"/>':'';
    $html = '<tr class="item" id="option_'.$params['code'].'">
            <td align="center" class="cell-uq" ></td>
            <td><span style="margin-left:4px;">' . $params['name'] . '</span></td>
            <td><span style="margin-left:4px;">' . $params['code'] . '</span></td>
            <td><span style="margin-left:4px;">' . $options[$params['type']] . '</span></td>
            <td><span style="margin-left:4px;">' . $params['price'] . '</span></td>
            <td><span style="margin-left:4px;"><center>' . $params['order'] . '</center></span></td>
            <td class="cell-status">
            	<span style="margin-left:4px;">
            		<center>
                    	<a href="javascript:void(0)" onclick="optionGrid.change(\''.$params['code'].'\')">' . ($params['is_active'] == 1 ? 'Active' : 'Inactive') . '</a>
                    </center>
                </span>
            </td>
            <td>
            	<span style="margin-left:4px;">
            		<center>
                    	<a href="">' . ($params['is_system'] == 1 ? 'Yes' : 'No') . '</a>
                    </center>
                </span>
            </td>
            <td align="center" class="cell-remove">'.$delete.'</td>
            <td width="70px" align="center">
              <a href="javascript:void(0)" onclick="optionGrid.edit(\''.$params['code'].'\')" style="color:#0000FF">edit</a>
            </td>
        </tr>';
    $response['success'] = 1;
    $response['html'] = $html;
    $response['data'] = $json;
    die(json_encode($response));
    
}

function __deletePackage(){
    global $package_property_cls, $package_property_group_option_cls, $systemlog_cls;
	$package_ids = getParam('package_id');
	if (strlen($package_ids) > 0) {
		$package_id_ar = explode(',',$package_ids);
		if (count($package_id_ar) > 0) {
			foreach ($package_id_ar as $package_id) {
				$row = $package_property_cls->getRow('package_id = '.$package_id);
				if (is_array($row) && count($row) > 0) {
					//delete all group option
                    $package_property_group_option_cls->delete('package_id = '.$package_id);
					$message = 'Deleted Package '.$row['name'];
                    $package_property_cls->delete('package_id = '.$package_id);
					// Write Logs
					$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'DELETE',
												 'Detail' => $message,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
				}
			}
		}
	}
	die(json_encode('Deleted successful!'));
}

function __activePackage(){
    global $package_property_cls, $systemlog_cls;
	$package_ids = getParam('package_id');
	if (strlen($package_ids) > 0) {
		$package_id_ar = explode(',',$package_ids);
		if (count($package_id_ar) > 0) {
			foreach ($package_id_ar as $package_id) {
				$row = $package_property_cls->getRow('package_id = '.$package_id);
				if (is_array($row) && count($row) > 0) {
                    $_stt = (1-(int)$row['is_active'] == 0)?'InActive':'Active';
				    $package_property_cls->update(array('is_active'=>1-(int)$row['is_active']),'package_id = '.$package_id);

                    if ($package_property_cls->hasError()) {
                        die(json_encode($package_property_cls->getError()));
                    }
					// Write Logs
					$systemlog_cls->insert(array ('Updated' => date("Y-m-d H:i:s"),
												 'Action' => 'UPDATE',
												 'Detail' => "Package #".$package_id." SET STATUS: ".$_stt,
												 'UserID' => $_SESSION['Admin']['EmailAddress'],
												 'IPAddress' =>$_SERVER['REMOTE_ADDR']));
				}
			}
		}
	}
	die(json_encode('This information has been updated!'));
}
?>