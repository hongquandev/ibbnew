<?php 
include_once 'menu.class.php';
if (!isset($menu_cls) or !($menu_cls instanceof Menu)) {
	$menu_cls = new Menu();
}

/**
* @function : Tab_getOptions
*/

function Menu_getOptions($parent_id = 0, $level= 0, $sp = '>>') {
	global $menu_cls;
	$rs = array();
	$rows = $menu_cls->getRows('parent_id = '.$parent_id.' AND active = 1 ORDER BY `order` ASC');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$rs[$row['menu_id']] = str_repeat($sp, $level).$row['title'];
			$rs += Menu_getOptions($row['menu_id'], $level + 1, $sp);
		}
	}
	return $rs;
}

/**
* @function : Tab_getMenuOptions
*/

function Menu_getMenuOptions($parent_id = 0, $level= 0, $sp = '>>') {
	global $menu_cls;
	$rs = array();
	$rows = $menu_cls->getRows('parent_id = '.$parent_id.' AND active = 1 AND (
									CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.Menu_areaByKey('header').',%\' OR
									CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.Menu_areaByKey('footer').',%\'
									) ORDER BY `order` ASC');
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$rs[$row['menu_id']] = str_repeat($sp, $level).$row['title'];
			$rs += Menu_getOptions($row['menu_id'], $level + 1, $sp);
		}
	}
	return $rs;
}



/**
* @funtion : Tab_getTreeOptions
* $wh_str : AND ...
*/

function Menu_getTreeOptions($parent_id = 0, $title = '', $wh_str = '') {
	global $menu_cls;
	$rs = array();
	$rows = $menu_cls->getCRows(array('menu_id', 'title', 'url', '`order`', 'area_ids', 'banner_area_ids', 'access', 'active'), 'parent_id = '.$parent_id.' '.$wh_str.' ORDER BY `order` ASC');
	
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$row['title'] = $title.' &raquo; '.$row['title'];
			$rs[$row['menu_id']] = $row;
			$rs += Menu_getTreeOptions($row['menu_id'], $row['title']);
		}
	}
	return $rs;
}

/**
@ function : Menu_getBreakCrumbsAr
**/

function Menu_getBreakCrumbsAr($parent_id = 0) {
	global $menu_cls;
	$rs = array();
	$row = $menu_cls->getCRow(array('title', 'parent_id'), 'menu_id = '.$parent_id);
	
	if (is_array($row) and count($row) > 0) {
		$rs = Menu_getBreakCrumbsAr($row['parent_id']) + array($row['title']);
	}
	return $rs;
}

/**
@ function : Menu_areaAr
**/

function Menu_areaAr() {
	return array(1 => 'Header', 
			2 => 'Footer', 
			3 => 'Landing Page (Vendor)', 
			4 => 'Landing Page (Buyer)',
			5 => 'Landing Page (Partner)',
			6 => 'Landing Page (Agent Auction)',
			7 => 'Step 1(pro)', 
			8 => 'Step 2(pro)', 
			9 => 'Step 3(pro)', 
			10 => 'Step 4(pro)', 
			11 => 'Step 5(pro)', 
			12 => 'Step 6(pro)', 
			13 => 'Step 7(pro)',
			30 => 'Float');
}

/**
@ function : Menu_areaByKey
**/

function Menu_areaByKey($key = '') {
	$rs = array('header' => 1, 
			'footer' => 2,
			'landing-vendor' => 3,
			'landing-buyer' => 4,
			'landing-partner' => 5,
			'landing-agent' => 6,
			'step1-pro' => 7,
			'step2-pro' => 8,
			'step3-pro' => 9,
			'step4-pro' => 10,
			'step5-pro' => 11,
			'step6-pro' => 12,
			'step7-pro' => 13,
			'float' => 30);
			
	return isset($rs[$key]) ? $rs[$key] : $rs['center'];
}

/**
@ function : Menu_getBackGeneral
**/

function Menu_getBackGeneral($parent_id = 0) {
	global $menu_cls;
	$rs = array();
	$rows = $menu_cls->getCRows(array('menu_id', 'parent_id'), 'parent_id = '.$parent_id);
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$rs[] = $row['menu_id'];
			$rs += Menu_getBackGeneral($row['menu_id']);
		}
	}
	return $rs;
}

/**
@ function : Menu_getList
**/

function Menu_getList($parent_id = 0, $level = 0, $sp = ' > ') {
	global $menu_cls;
	$rs = array();
	$access = isset($_SESSION['agent']['type_id']) && $_SESSION['agent']['type_id'] > 0 ? $_SESSION['agent']['type_id'] : AgentType_getIdByKey('guest');
	$rows = $menu_cls->getCRows(array('menu_id', 'parent_id', 'title', 'url', '`order`', 'area_ids', 'banner_area_ids', 'access', 'active'), '
												active = 1 AND 
												parent_id = '.$parent_id.' AND 													
												(
												CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.Menu_areaByKey('header').',%\' OR
												CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.Menu_areaByKey('footer').',%\'  
												) 
												AND CONCAT_WS(\'\', \',\', `access`, \',\') LIKE \'%,'.$access.',%\'
												ORDER BY `order` ASC');
	
	if (is_array($rows) and count($rows) > 0) {
		foreach ($rows as $row) {
			$row['title'] = str_repeat($sp, $level).$row['title'];
			$rs[$row['menu_id']] = $row;
			$rs += Menu_getList($row['menu_id'], $level + 1, $sp);
		}
	}
	return $rs;
}

/**
@ function : Menu_getTop
**/

function Menu_getTop($parent_id = 0) {
	global $menu_cls, $langstrings;
	$rs = '';
	$area_id = Menu_areaByKey('header');
	$access = isset($_SESSION['agent']['type_id']) && $_SESSION['agent']['type_id'] > 0 ? $_SESSION['agent']['type_id'] : AgentType_getIdByKey('guest');
	$rows = $menu_cls->getCRows(array('menu_id', 'title', 'url', 'parent_id'), 
								'AND active = 1 
								AND parent_id = '.$parent_id.' 
								AND CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.$area_id.',%\' 
								AND CONCAT_WS(\'\', \',\', `access`, \',\') LIKE \'%,'.$access.',%\' 
								ORDER BY `order` ASC');
	if ($parent_id == 0) {
        if(count($rows) == 9){
            $rs = '<ul class="nav" '.(count($rows) == 9 ? 'id="nav-equal9"' : (count($rows) == 9 ? 'id="nav-equal9"' :'')).'>';
        }else if(count($rows) == 6){
           $rs = '<ul class="nav" '.(count($rows) == 6 ? 'id="nav-equal6"' : (count($rows) < 6 ? 'id="nav-equal6"' :'')).'>';
        }else{
           $rs = '<ul class="nav" '.(count($rows) > 8 ? 'id="nav-more"' : (count($rows) < 8 ? 'id="nav-less"' :'')).'>';
        }
		//$rs = '<ul class="nav">';
	}
	if (is_array($rows) && count($rows) > 0) {
		if ($parent_id > 0) {
			//$rs .= '<ul class="sub-nav" id="menu_'.$parent_id.'" style="display: none;">';
			$rs .= '<ul  id="menu_'.$parent_id.'" style="display: none;" class="sub-nav">';
		}

		$i = 0;
		$count = count($rows);
        //print_r($langstrings);
		foreach ($rows as $row) {
            $row['title'] = Localizer::translate($row['title']);
            //echo '11translation 12translate="13'.(str_replace(' ','_',$row['title'])) .'">'.$row['title'].' /14translation><br>';
			$url = ROOTURL.(preg_match('/^\//',$row['url']) ? '' : '/').$row['url'];
			if ($parent_id == 0) {
				$i++;
				$cls = $i == $count ? 'class="child item-menu-last"' : ($i == 1 ? 'class="child item-menu-first"' : 'class="child"');

				$rs .= '<li onmouseover="gosMenu.onhover(\'menu_'.$row['menu_id'].'\')" onmouseout="gosMenu.onhover(\'menu_'.$row['menu_id'].'\')" '.$cls.'>';
				if ($row['url'] == '#') {
					$rs .= '<a href="javascript:void(0)" onclick="return false"><span><span>'.$row['title'].'</span></span></a>';
				} else {
					$rs .= '<a href="'.$url.'"><span><span>'.$row['title'].'</span></span></a>';
				}
			}
            else {
				$rs .= '<li class="first"><p><a class="" href="'.$url.'"><span>'.$row['title'].'</span></a></p>';
			}
			$rs .= Menu_getTop($row['menu_id']).'</li>';
		}
		
		if ($parent_id > 0) {
			$rs .= '</ul>';
		}
	}
	
	if ($parent_id == 0) {
		$rs .= '</ul>';
	}
	
	return $rs;
}

function Menu_getMobileTop($parent_id = 0) {
	global $menu_cls;
	$rs = '';
	$area_id = Menu_areaByKey('header');
	$access = isset($_SESSION['agent']['type_id']) && $_SESSION['agent']['type_id'] > 0 ? $_SESSION['agent']['type_id'] : AgentType_getIdByKey('guest');
	$rows = $menu_cls->getCRows(array('menu_id', 'title', 'url', 'parent_id'),
								'AND active = 1
								AND show_mobile = 1
								AND parent_id = '.$parent_id.'
								AND CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.$area_id.',%\'
								AND CONCAT_WS(\'\', \',\', `access`, \',\') LIKE \'%,'.$access.',%\'
								ORDER BY `order` ASC');
	if ($parent_id == 0) {
	}
	if (is_array($rows) && count($rows) > 0) {
		if ($parent_id > 0) {
			$rs .= '<ul class="sub-nav" id="menu_'.$parent_id.'" style="display: none;">';
		}

		$i = 0;
		$count = count($rows);
		foreach ($rows as $row) {
			$url = ROOTURL.(preg_match('/^\//',$row['url']) ? '' : '/').$row['url'];
			if ($parent_id == 0) {
				$i++;
				$cls = $i == $count ? 'class="item-menu-last"' : '';
				$rs .= '<li '.$cls.'>';
				if ($row['url'] == '#') {
					$rs .= '<a class="level-1" href="javascript:void(0)" onclick="return false"><span><span>'.$row['title'].'</span></span></a>';
				} else {
					$rs .= '<a class="level-1" href="'.$url.'"><span><span>'.$row['title'].'</span></span></a>';
				}
                $rs .= '<span class="icon-nav">+</span><div class="clearthis"></div>';
			}else{
				$rs .= '<li class="first"><p><a class="" href="'.$url.'"><span>'.$row['title'].'</span></a></p>';
			}
			$rs .= Menu_getMobileTop($row['menu_id']).'</li>';
		}

		if ($parent_id > 0) {
			$rs .= '</ul>';
		}
	}

	return $rs;
}

/**
@ function : Menu_getBottom
**/

function Menu_getBottom($parent_id = 0) {
	global $menu_cls;
	$rs = '';
	$access = isset($_SESSION['agent']['type_id']) && $_SESSION['agent']['type_id'] > 0 ? $_SESSION['agent']['type_id'] : AgentType_getIdByKey('guest');
	$area_id = Menu_areaByKey('footer');
	$rows = $menu_cls->getCRows(array('menu_id', 'title', 'url', 'parent_id'), 
								'AND active = 1 
								AND parent_id = '.$parent_id.' 
								AND CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.$area_id.',%\' 
								AND CONCAT_WS(\'\', \',\', `access`, \',\') LIKE \'%,'.$access.',%\'
								ORDER BY `order` ASC');
								
	if (is_array($rows) && count($rows) > 0) {
		if ($parent_id > 0) {
			$rs .= '<ul>';
		} else {
			$i = 0;
			$count = count($rows);
		}
		
		foreach ($rows as $row) {
            $url_r = $row['url'];
			$row['url'] = ROOTURL.(preg_match('/^\//',$row['url']) ? '' : '/').$row['url'];
            $row['title'] = Localizer::translate($row['title']);
            //echo '11translation 12translate="13'.(str_replace(' ','1_1',$row['title'])) .'">'.$row['title'].' /14translation><br>';
			if ($parent_id == 0) {
				$i++;
				$cls = $i == $count ? 'footer-menu-last' : '';
				$sufId = $i == $count ? '-last' : '';			
					
				/*if ($url_r == '#') {
					$rs .= '<div class="f-block first '.$cls.'"><label>'.$row['title'].'</label>';
				} else {
					$rs .= '<div class="f-block first '.$cls.'"><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
				}*/

                if(count($rows) == 9){
                      if ($url_r == '#') {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 9 ? 'id="f-equal9'.$sufId.'"' : (count($rows) == 9 ? 'id="f-equal9"' :'')).'><label>'.$row['title'].'</label>';
                      } else {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 9 ? 'id="f-equal9'.$sufId.'"' : (count($rows) == 9 ? 'id="f-equal9"' :'')).'><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
                      }
                }
                else if(count($rows) == 8){
                      if ($url_r == '#') {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 8 ? 'id="f-equal8'.$sufId.'"' : (count($rows) == 8 ? 'id="f-equal8"' :'')).'><label>'.$row['title'].'</label>';
                      } else {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 8 ? 'id="f-equal8'.$sufId.'"' : (count($rows) == 8 ? 'id="f-equal8"' :'')).'><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
                      }
                }
                else if(count($rows) == 7){
                      if ($url_r == '#') {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 7 ? 'id="f-equal7'.$sufId.'"' : (count($rows) == 7 ? 'id="f-equal7"' :'')).'><label>'.$row['title'].'</label>';
                      } else {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 7 ? 'id="f-equal7'.$sufId.'"' : (count($rows) == 7 ? 'id="f-equal7"' :'')).'><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
                      }
                }
                else if(count($rows) == 6){
                      if ($url_r == '#') {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 6 ? 'id="f-equal6'.$sufId.'"' : (count($rows) == 6 ? 'id="f-equal6"' :'')).'><label>'.$row['title'].'</label>';
                      } else {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 6 ? 'id="f-equal6'.$sufId.'"' : (count($rows) == 6 ? 'id="f-equal6"' :'')).'><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
                      }
                }
                else if(count($rows) == 5){
                      if ($url_r == '#') {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 5 ? 'id="f-equal5'.$sufId.'"' : (count($rows) == 5 ? 'id="f-equal5"' :'')).'><label>'.$row['title'].'</label>';
                      } else {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 5 ? 'id="f-equal5'.$sufId.'"' : (count($rows) == 5 ? 'id="f-equal5"' :'')).'><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
                      }
                }
                else if(count($rows) == 4){
                      if ($url_r == '#') {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 4 ? 'id="f-equal4'.$sufId.'"' : (count($rows) == 4 ? 'id="f-equal4"' :'')).'><label>'.$row['title'].'</label>';
                      } else {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 4 ? 'id="f-equal4'.$sufId.'"' : (count($rows) == 4 ? 'id="f-equal4"' :'')).'><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
                      }
                }
                else if(count($rows) == 3){
                      if ($url_r == '#') {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 3 ? 'id="f-equal3'.$sufId.'"' : (count($rows) == 3 ? 'id="f-equal3"' :'')).'><label>'.$row['title'].'</label>';
                      } else {
                          $rs .= '<div class="f-block first '.$cls.'" '.(count($rows) == 3 ? 'id="f-equal3'.$sufId.'"' : (count($rows) == 3 ? 'id="f-equal3"' :'')).'><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
                      }
                }
                else{
                    if ($url_r == '#') {
                        $rs .= '<div class="f-block first '.$cls.'"><label>'.$row['title'].'</label>';
                    } else {
                        $rs .= '<div class="f-block first '.$cls.'"><a href="'.$row['url'].'"><label style="cursor:pointer">'.$row['title'].'</label></a>';
                    }
                }

			} else {
                if(preg_match('/^function/',$url_r))
                {
                    $func = explode('-',$url_r);
                    $func = $func[1];
                    $rs .= '<li style="font-size:12.1px; font-weight:normal;">
                            <a onclick="'.$func.'" href="javascript:void(0)"><span>'.$row['title'].'</span>
                            </a></li>';
                }
                else{
                    $rs .= '<li style="font-size:12.1px; font-weight:normal;">
                            <a class="" href="'.$row['url'].'"><span>'.$row['title'].'</span>
                            </a></li>';
                }
			}
			$rs .= Menu_getBottom($row['menu_id']).'</li>';

			if ($parent_id == 0) {
				$rs .= '</div>';
			}
		}
		
		if ($parent_id > 0) {
			$rs .= '</ul>';
		}
	}
	
	return $rs;
}

/**
@ function : Menu_getBottomEmail
**/

function Menu_getBottomEmail($parent_id = 0) {
	global $menu_cls;
	$rs = '';
	$access = AgentType_getIdByKey('guest');
	$area_id = Menu_areaByKey('footer');
	$limit = $parent_id == 0 ? ' LIMIT 5' : '';
	$rows = $menu_cls->getCRows(array('menu_id', 'title', 'url', 'parent_id'), 
								'AND active = 1 
								AND parent_id = '.$parent_id.' AND CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.$area_id.',%\' 
								AND CONCAT_WS(\'\', \',\', `access`, \',\') LIKE \'%,'.$access.',%\' 
								ORDER BY `order` ASC '.$limit);
								
	if (is_array($rows) && count($rows) > 0) {
		if ($parent_id > 0) {
			$rs .= '<ul style="font-size:12px;color:#fff !important;list-style-type:none;margin:0;padding:10px 0 0 0;">';
		}else {
			$i2 = 0;
			$count2 = count($rows);
		}
		
		foreach ($rows as $row) {
			if ($parent_id == 0) {
                $i2++;
				$cls2 = $i2 == $count2 ? 'td-footer-menu-last' : '';	
                
                if($cls2){
                    $rs .= '<td class="'.$cls2.'" style="vertical-align:top;padding-right:0px;padding-top:0px;padding-left:0px;padding-bottom:0px;">';
                }else{
                    $rs .= '<td style="vertical-align:top;padding-right:12px;padding-top:0;padding-left:0px;padding-bottom:0px;">';
                }

				$rs .= '<label style="font-size:12px;color:#fff !important;list-style-type:none;margin:0px;padding:0px;">';
				$rs .= '<strong >'.$row['title'].'</strong>';
				$rs .= '</label>';
			} else {
                $url = ROOTURL.'/'. $row['url'];
                if(preg_match('/^function/',$row['url']))
                {
                    $func = explode('-',$row['url']);
                    $func = $func[1];
                    $url = ROOTURL.'/?func='.$func;
                }
				$rs .= '<li style="font-size:12.1px;font-weight:normal;padding: 0px 0px;margin: 0px 0px">
                            <a href="'.$url.'" style="color: #6d737f;text-decoration: none;">
                                <span style="color: #6d737f;text-decoration: none;">'.$row['title'].'</span>
                            </a>
                        </li>';
			}
			
			$rs .= Menu_getBottomEmail($row['menu_id']).'</li>';
			
			if ($parent_id == 0) {
				$rs .= '</td>';
			}
		}
		
		if ($parent_id > 0) {
			$rs .= '</ul>';
		}
	}
	
	return $rs;
}

/**
@ function : Menu_getByBannerAreaId
@ in : id = banner_area_id
**/

function Menu_getByBannerAreaId($parent_id = 0, $banner_area_id = 0, $label = '', $sp = ' > ') {
	global $menu_cls;
	$rs = array();
	$rows = $menu_cls->getCRows(array('menu_id', 'title'),
								'AND active = 1
								AND (
									CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.Menu_areaByKey('header').',%\' OR
									CONCAT_WS(\'\', \',\', area_ids, \',\') LIKE \'%,'.Menu_areaByKey('footer').',%\' OR
									url = \'home\'
									)
								AND CONCAT_WS(\'\', \',\', banner_area_ids, \',\') LIKE \'%,'.$banner_area_id.',%\'
								AND parent_id = '.$parent_id.'
								ORDER BY `order` ASC');
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			$rs[$row['menu_id']] = ucwords(strtolower($label.$row['title']));
			$rs += Menu_getByBannerAreaId($row['menu_id'], $banner_area_id, $rs[$row['menu_id']] . $sp, $sp);
		}
	}
	
	return $rs;	
}

/**
@ function : Menu_getTitleById
@ in :
**/

function Menu_getTitleArById($menu_id_ar = array()) {
	global $menu_cls;
	$rs = array();
	$rows = $menu_cls->getCRows(array('menu_id', 'title', 'level'), 
								'AND active = 1 
								AND menu_id IN (\''.implode("','", $menu_id_ar).'\')
								ORDER BY `iurl` ASC');
								
	if (is_array($rows) && count($rows) > 0) {
		foreach ($rows as $row) {
			$level_ar = unserialize($row['level']);
			$rs[$row['menu_id']] = ucwords(strtolower(implode(' > ', $level_ar)));
		}
	}
	
	return $rs;	
}

/**
@ function : Menu_convert
**/

function Menu_convert($ar = array(), $str = '') {
	$val_ar = strlen($str) > 0 ? explode(',', $str) : array();
	$rs = array();
	if (is_array($ar) && count($ar) > 0 && count($val_ar) > 0) {
		foreach ($val_ar as $v) {
			if (isset($ar[$v])) {
				$rs[] = $ar[$v];
			}
		}
	}
	return implode(', ', $rs);
}

/**
@ function : Menu_incView
**/

function Menu_incView($url = '') {
	global $menu_cls;
	if (trim($url) == '') {
		$url = 'home';
	}
	
	$url = addslashes($url);
	$menu_cls->update(array('views' => array('fnc' => 'views + 1')), 'url = \''.'/'.trim($url,'/').'\' OR url = \''.trim($url,'/').'\'');
}
?>