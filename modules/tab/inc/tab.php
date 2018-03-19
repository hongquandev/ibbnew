<?php 
include_once 'tabs.class.php';
if (!isset($tab_cls) or !($tab_cls instanceof Tabs)) {
	$tab_cls = new Tabs();
}

/**
*@function : Tab_getOptions
*/
function Tab_getOptions($parent_id = 0) {
	global $tab_cls;
	$rs = array();
	$rows = $tab_cls->getRows('parent_id = '.$parent_id.' AND active = 1 ORDER BY `order` ASC');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$rs[$row['tab_id']] = $row['title'];
			
			$rows2 = $tab_cls->getRows('parent_id = '.$row['tab_id'].' AND active = 1 ORDER BY `order` ASC');
			if (is_array($rows2) and count($rows2) > 0) {
				$_rs = Tab_getOptions($row['tab_id']);
				foreach ($_rs as $_k => $_v) {
					$rs[$_k] = $_v;
				} 
			}
		}
	}
	return $rs;
}

/**
*@funtion : Tab_getTreeOptions
*/
function Tab_getTreeOptions($action = 1,$parent_id = 0, $title = '') {
	global $tab_cls;
	$rs = array();
	if ($action == 1) {
		$rows = $tab_cls->getRows('parent_id = '.$parent_id.' AND active = 1 ORDER BY `order` ASC');
	} else {
		$rows = $tab_cls->getRows('parent_id = '.$parent_id.' ORDER BY `order` ASC');
	}
	
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$rs[$row['tab_id']] = $title.' &raquo; '.$row['title'];
			
			$rows2 = $tab_cls->getRows('parent_id = '.$row['tab_id'].' AND active = 1 ORDER BY `order` ASC');
			if (is_array($rows2) and count($rows2) > 0) {
				$_rs = Tab_getTreeOptions($action , $row['tab_id'],$rs[$row['tab_id']]);
				foreach ($_rs as $_k => $_v) {
					$rs[$_k] = $_v;
				} 
			}
		}
	}
	return $rs;
}


/**
*@funtion : Tab_getTreeOptionsLevelOne
*/
function Tab_getTreeOptionsLevelOne($parent_id = 0, $title = '') {
	global $tab_cls;
	$rs = array();
	$rows = $tab_cls->getRows('parent_id = '.$parent_id.' AND active = 1 ORDER BY `order` ASC');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$rs[$row['tab_id']] = $title.' &raquo; '.$row['title'];
		}
	}
	return $rs;
}

/**
*@function : Tab_topMenu
*/
function Tab_topMenu1($parent_id = 0, $level = 1) {
	global $tab_cls;
	$rs = '';
	$rows = $tab_cls->getRows('parent_id = '.$parent_id.' AND active = 1 ORDER BY `order` ASC');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$permit_ar = permission(@$_SESSION['Admin']['role_id'],$row['tab_id']);
			if ($permit_ar['view'] == 0) {
				continue;
			}
			
			/*
			if (preg_match('/\?/',$row['uri'])) {
				$row['uri'] .= '&token='.encodeToken($row['tab_id']);
			} else {
				$row['uri'] .= '?token='.encodeToken($row['tab_id']);
			}
			*/
			
			$row['uri'] .= (eregi('\?',$row['uri']) ? '&' : '?' ).'token='.Tab_createToken($row['tab_id']);
            $row['uri'] = str_replace('/admin/','',$row['uri']);
			$row['uri'] = ROOTURLS.'/admin/'.$row['uri'];
			$key = str_replace('[\s+]','',strtolower($row['title']));
			/*if (strlen($rs) > 0 and $level == 1) {
				$rs .= '<span> | </span>'; 
			}*/

            if ($row['img_path'] == '') {
                $imgs = '';
            } else {
                $imgs = $row['img_path'];
            }

            if ($level == 1){
				/*if (strlen($_rs1) > 0) {
					$rs .= '<a href="'.$row['uri'].'" class="topmenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, \''.$key.'\')">'.$row['title'].'</a>';
					$rs .= $_rs1;
				} else {
                    $rs .= '<a href="'.$row['uri'].'" class="topmenu" >'.$row['title'].'</a>';
				}	*/
                $cls = '<a title="'.$row['title'].'" id="cls-'.$row['tab_id'].'" href="'.$row['uri'].'">';
			} else {
                if (eregi('popup',$row['uri'])){
                    $cls = '<a href="javascript:void(0)" id="cls-'.$row['tab_id'].'" onclick="window.open(\''.$row['uri'].'\',\'iBB_Help_Center\',\'width=850,scrollbars=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,resizable=no\')">'.$row['title'].'</a>';
                }else{
				    $cls = '<a href="'.$row['uri'].'" id="cls-'.$row['tab_id'].'" >'.$row['title'].'</a> ';
                }
			}
            $rs .= '<li>
							' . $cls . '
								<span class="trim rb-a-3">
								<span class="' . $imgs . '"> </span>
									<span class="text">' . $row['title']. '</span>
								</span>
							</a>';
				/*if (strlen($subMenu) > 0) {
					$data .= '<div class="navSubMenu _bottomNavSubMenu"><ul>'.$subMenu.'</ul></div></li>';
				}*/

			
			$_rs1 = '';
			$rows2 = $tab_cls->getRows('parent_id = '.$row['tab_id'].' AND active = 1 ORDER BY `order` ASC');
			if (is_array($rows2) and count($rows2) > 0) {
				$_rs2 = Tab_topMenu($row['tab_id'],$level+1);
				//print_r($_rs2);
				$_rs1 = '<div id="'.$key.'" align="left" class="anylinkcss">';
				
				$_rs1 .= $_rs2;
				 
				$_rs1 .= '</div>';
			} 
			
			/*if ($level == 1){
				if (strlen($_rs1) > 0) {
					$rs .= '<a href="'.$row['uri'].'" class="topmenu" onClick="return clickreturnvalue()" onMouseover="dropdownmenu(this, event, \''.$key.'\')">'.$row['title'].'</a>';
					$rs .= $_rs1;
				} else {
                    $rs .= '<a href="'.$row['uri'].'" class="topmenu" >'.$row['title'].'</a>';
				}
				
			} else {
                if (eregi('popup',$row['uri'])){
                    $rs .= '<a href="javascript:void(0)" onclick="window.open(\''.$row['uri'].'\',\'iBB_Help_Center\',\'width=850,scrollbars=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,resizable=no\')">'.$row['title'].'</a>';
                }else{
				    $rs .= '<a href="'.$row['uri'].'" >'.$row['title'].'</a> ';
                }
			}*/
            $rs .= '</li>';
			
		}
	}
	return $rs;
}

function Tab_topMenu($parent_id = 0, $level = 1) {
	global $tab_cls;
	$rs = '';
	$rows = $tab_cls->getRows('parent_id = '.$parent_id.' AND active = 1 ORDER BY `order` ASC');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$permit_ar = permission(@$_SESSION['Admin']['role_id'],$row['tab_id']);
			if ($permit_ar['view'] == 0) {
				continue;
			}

			$row['uri'] .= (eregi('\?',$row['uri']) ? '&' : '?' ).'token='.Tab_createToken($row['tab_id']);
            $row['uri'] = str_replace('/admin/','',$row['uri']);
			//$row['uri'] = ROOTURLS.'/admin/'.$row['uri'];
			$row['uri'] = ROOTURLS.'/fixit/'.$row['uri'];
			$key = str_replace('[\s+]','',strtolower($row['title']));

            if ($row['img_path'] == '') {
                $imgs = '';
            } else {
                $imgs = 'icon-19 '.$row['img_path'];
            }




			$rows2 = $tab_cls->getRows('parent_id = '.$row['tab_id'].' AND active = 1 ORDER BY `order` ASC');
            $_rs1 = '';
			if (is_array($rows2) and count($rows2) > 0) {
				$_rs2 = Tab_topMenu($row['tab_id'],$level+1);
                $_rs1 .=  '<div class="navSubMenu _bottomNavSubMenu"><ul>'.$_rs2.'</ul></div></li>';
			}

            if ($level == 1){
                if ($_rs1 != ''){
                    $cls = '<a href="javascript:void(0)" title="'.$row['title'].'" id="cls-'.$row['tab_id'].'" onlick="return clickreturnvalue()">';
                }else{
                    $cls = '<a title="'.$row['title'].'" id="cls-'.$row['tab_id'].'" href="'.$row['uri'].'">';
                }
			} else {
                if (eregi('popup',$row['uri'])){
                    $cls = '<a href="javascript:void(0)" id="cls-'.$row['tab_id'].'" onclick="window.open(\''.$row['uri'].'\',\'iBB_Help_Center\',\'width=850,scrollbars=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,resizable=no\')">';
                }else{
				    $cls = '<a href="'.$row['uri'].'" id="cls-'.$row['tab_id'].'" >';
                }
			}
            $rs .= '<li>
							' . $cls . '
								<span class="trim rb-a-3">
								<span class="' . $imgs . '"> </span>
									<span class="text">' . $row['title']. '</span>
								</span>
							</a>';
            $rs .= $_rs1;
            $rs .= '</li>';

		}
	}
	return $rs;
}

function Tab_topMenuSlick($parent_id = 0, $level = 1) {
	global $tab_cls;
	$rs = '';
	$rows = $tab_cls->getRows('parent_id = '.$parent_id.' AND active = 1 ORDER BY `order` ASC');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$permit_ar = permission(@$_SESSION['Admin']['role_id'],$row['tab_id']);
			if ($permit_ar['view'] == 0) {
				continue;
			}

			$row['uri'] .= (eregi('\?',$row['uri']) ? '&' : '?' ).'token='.Tab_createToken($row['tab_id']);
            $row['uri'] = str_replace('/admin/','',$row['uri']);
			//$row['uri'] = ROOTURLS.'/admin/'.$row['uri'];
			$row['uri'] = ROOTURLS.'/fixit/'.$row['uri'];
			$key = str_replace('[\s+]','',strtolower($row['title']));

            if ($row['img_path'] == '') {
                $imgs = '';
            } else {
                $imgs = 'icon-19 '.$row['img_path'];
            }
			$rows2 = $tab_cls->getRows('parent_id = '.$row['tab_id'].' AND active = 1 ORDER BY `order` ASC');
            $_rs1 = '';
			if (is_array($rows2) and count($rows2) > 0) {
				$_rs2 = Tab_topMenu($row['tab_id'],$level+1);
                $_rs1 .=  '<ul>'.$_rs2.'</ul></li>';
			}

            if ($level == 1){
                if ($_rs1 != ''){
                    $cls = '<a href="#" title="'.$row['title'].'" id="cls-'.$row['tab_id'].'">';
                }else{
                    $cls = '<a title="'.$row['title'].'" id="cls-'.$row['tab_id'].'" href="'.$row['uri'].'">';
                }
			} else {
                if (eregi('popup',$row['uri'])){
                    $cls = '<a href="javascript:void(0)" id="cls-'.$row['tab_id'].'" onclick="window.open(\''.$row['uri'].'\',\'iBB_Help_Center\',\'width=850,scrollbars=yes,directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,resizable=no\')">';
                }else{
				    $cls = '<a href="'.$row['uri'].'" id="cls-'.$row['tab_id'].'" >';
                }
			}
            $rs .= '<li>
							' . $cls . '
								<span class="trim rb-a-3">
								<span class="' . $imgs . '"> </span>
									<span class="text">' . $row['title']. '</span>
								</span>
							</a>';
            $rs .= $_rs1;
            $rs .= '</li>';

		}
	}
	return $rs;
}

function Tab_checkByTabId($tab_id = 0) {
	global $tab_cls;
	$row = $tab_cls->getRow("tab_id = '".$tab_cls->escape($tab_id)."'");
	if (is_array($row) and count($row) > 0) {
		return true;
	}
	return false;
}

/**
@ function : Tab_createToken
@ param : tab_id (int)
@ output : string
**/

function Tab_createToken($tab_id = 0) {
	return md5(session_id().$tab_id);
}

/**
@ function : Tab_getIdFromToken
@ param : token (string)
@ output : int
**/

function Tab_getIdFromToken($token = '') {
	global $tab_cls;
	$rows = $tab_cls->getRows('active = 1');
	$tab_id = 0;
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			if ($token == Tab_createToken($row['tab_id'])) {
				$tab_id = $row['tab_id'];
				break;
			}
		}
	}
	return $tab_id;
}

/**
@ function : Tab_getTokenFromUri
@ param : uri (string) 
@ output : string
**/

function Tab_getTokenFromUri($uri = '', $strict = true) {
	global $tab_cls;
	
	$wh_str = $strict ? 'uri = \''.$tab_cls->escape($uri).'\'' : 'uri LIKE %'.$tab_cls->escape($uri).'%';
	$row = $tab_cls->getRow($wh_str);
	$token = '';
	if (is_array($row) && count($row) > 0) {
		$token = Tab_createToken($row['tab_id']);
	}
	return $token;
}
?>