<?php
include_once ROOTPATH . '/modules/general/inc/regions.php';
include_once ROOTPATH . '/modules/agent/inc/company.php';
include_once ROOTPATH . '/modules/configuration/inc/configuration.php';
include_once ROOTPATH . '/modules/theblock/inc/background.php';
include_once ROOTPATH . '/includes/pagging.class.php';
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
    $pag_cls = new Paginate();
}
switch ($action_ar[2]) {
    case 'agent':
    case 'agency':
        $site_name = getParam('n', '');
        $agent_id = (int)restrictArgs(getParam('uid', 0));
        if ($site_name != '') {
            /*die(in_array($site_name,Agent_specialSite()));*/
            if (!in_array($site_name, Agent_specialSite())) {
                $site = $agent_site_cls->getCRow(array('agent_id'), "name = '{$site_name}' AND type = '{$action_ar[2]}'");
                if (is_array($site) and count($site)) {
                    $agent_id = $site['agent_id'];
                } else {
                    redirect(ROOTURL . '/notfound.html');
                }
            } else {
                redirect('/' . $site_name . '/');
            }
        }
        //PREPARE BACKGROUND
        $bg_data = BG_getBackgroundForAgent($agent_id);
        $smarty->assign('bg_data', $bg_data);
        $user_viewer = 'guest-viewer-detail';
        if(!empty($_SESSION['agent']['type'])){
            $user_viewer = $_SESSION['agent']['type'].'-viewer-detail';
        }
        $smarty->assign('user_viewer', $user_viewer);
        //INFO
        $row = $agent_cls->getRow('SELECT a.agent_id, a.firstname, a.lastname, a.parent_id,
                                    c.address,
                                    c.suburb,
                                    c.postcode,
                                    c.other_state,
                                    c.description,
                                    c.telephone,
                                    c.website,
                                    c.email_address,
                                    c.company_name,
                                    l.logo,
                                    (SELECT r1.code
                                      FROM ' . $region_cls->getTable('regions') . ' AS r1
                                      WHERE r1.region_id = c.state) AS state_code,

                                     (SELECT r2.name
                                      FROM ' . $region_cls->getTable('regions') . ' AS r2
                                      WHERE r2.region_id = c.country) AS country_name,

                                    (SELECT c1.logo
                                     FROM ' . $company_cls->getTable() . ' AS c1
                                     WHERE IF(a.parent_id = 0 || ISNULL(a.parent_id)
                                             ,c1.agent_id = ' . $agent_id . '
                                             ,c1.agent_id = a.parent_id)
                                           ) AS banner
                                   FROM ' . $agent_cls->getTable() . ' AS a
                                   LEFT JOIN ' . $company_cls->getTable() . ' AS c
                                   ON a.agent_id = c.agent_id
                                   LEFT JOIN ' . $agent_logo_cls->getTable() . ' AS l
                                   ON a.agent_id = l.agent_id
                                   WHERE a.agent_id = ' . $agent_id . '
                                   AND (SELECT agt.title
                                        FROM ' . $agent_cls->getTable('agent_type') . ' AS agt
                                        WHERE agt.agent_type_id = a.type_id) = \'agent\'', true);
        if (is_array($row) and count($row) > 0) {
            $row['logo'] = strlen($row['logo']) > 0 ? $row['logo'] : '/modules/general/templates/images/photo_default.jpg';
            if ($action_ar[2] == 'agency' && $row['parent_id'] > 0) {
                redirect(Agent_seoURL('?module=agent&action=view-detail-agent&uid=' . $row['agent_id']));
            }
            $row['parent_id'] = $row['parent_id'] == 0 ? $row['agent_id'] : $row['parent_id'];
            $row['full_name'] = $row['firstname'] . ' ' . $row['lastname'];
            $row['full_address'] = $row['address'] . '<br />' . implode(' ', array($row['suburb'], $row['state_code'], $row['other_state'], $row['postcode'], $row['country_name']));
            $row['short_description'] = strlen($row['description']) >= 400 ?
                safecontent(strip_tags($row['description']), 400) . ' <a href="javascript:void(0)" class="des" style="color:#CC8C04"> [See more...]</a>'
                : $row['description'];
            $row['full_description'] = strlen($row['description']) >= 400 ? $row['description'] . ' <a href="javascript:void(0)" class="des" style="color:#CC8C04"> [Hide...]</a>' :
                $row['description'];
            $row['website'] = showWebsite($row['website']);
            $info = $row;
        } else {
            redirect(ROOTURL);
        }
        //SUB ACCOUNT
        $sub_agent = $agent_cls->getRows('SELECT SQL_CALC_FOUND_ROWS a.firstname
                                              , a.lastname,
                                              l.logo,
                                              a.agent_id,
                                              c.suburb,
                                              c.other_state,
                                              c.postcode,
                                              c.telephone,
                                              c.address,
                                              c.website,
                                             (SELECT r1.code
                                              FROM ' . $region_cls->getTable('regions') . ' AS r1
                                              WHERE r1.region_id = c.state) AS state_code,

                                             (SELECT r2.name
                                              FROM ' . $region_cls->getTable('regions') . ' AS r2
                                              WHERE r2.region_id = c.country) AS country_name
                                          FROM ' . $agent_cls->getTable() . ' AS a
                                          LEFT JOIN ' . $agent_logo_cls->getTable() . ' AS l
                                          ON a.agent_id = l.agent_id
                                          LEFT JOIN ' . $company_cls->getTable() . ' AS c
                                          ON a.agent_id = c.agent_id
                                          WHERE IF(a.parent_id > 0,a.parent_id = ' . $agent_id . ',a.agent_id = ' . $agent_id . ') AND a.is_active = 1
                                          ORDER BY a.agent_id ASC
                                          LIMIT 0,3', true);
        $total_row = $agent_cls->getFoundRows();
        $pag_cls->setTotal($total_row)
            ->setPerPage(3)
            ->setCurPage(1)
            ->setLenPage(5)
            ->setUrl('/modules/agent/action.php?action=viewAgent&uid=' . $agent_id)
            ->setLayout('ajax')
            ->setFnc('viewAgent');
        $smarty->assign('mode', $mode);
        $smarty->assign('sub_pag_str', $pag_cls->layout());
        if (is_array($sub_agent) and count($sub_agent) > 0) {
            foreach ($sub_agent as $row) {
                $row['website'] = showWebsite($row['website']);
                $row['logo'] = strlen($row['logo']) > 0 ? $row['logo'] : '/modules/general/templates/images/photo_default.jpg';
                $row['parent_id'] = $row['parent_id'] == 0 ? $row['agent_id'] : $row['parent_id'];
                $row['full_name'] = $row['firstname'] . ' ' . $row['lastname'];
                $row['full_address'] = $row['address'] . '<br />' . implode(' ', array($row['suburb'], $row['state_code'], $row['other_state'], $row['postcode'], '<br />' . $row['country_name']));
                $sub_account[] = $row;
            }
        }
        $smarty->assign('sub_account', $sub_account);
        //PROPERTIES
        //HIDE AGENT's PROPERTIES DIDN'T PAYMENT
       /* $wh_arr[] = " IF((SELECT title FROM " . $agent_cls->getTable('agent_type') . " AS at
                                   WHERE agt.type_id = at.agent_type_id) IN ('agent')
                                   ,(SELECT ap.payment_id FROM " . $agent_payment_cls->getTable() . " AS ap
                                     WHERE ap.agent_id = IF(agt.parent_id = '',agt.agent_id,agt.parent_id)
                                           AND ap.date_from <= '" . date('Y-m-d H:i:s') . "' AND ap.date_to >= '" . date('Y-m-d H:i:s') . "'
                                     ) != ''
                                   ,1)";*/
        //DON'T ALLOW SHOW PROPERTIES OF INACTIVE AGENT
        /*$wh_arr[] = " IF(ISNULL(pro.agent_manager) || pro.agent_manager = '' || pro.agent_manager = 0
                        , agt.is_active = 1
                        ,(SELECT a.is_active FROM " . $agent_cls->getTable() . " AS a WHERE a.agent_id = pro.agent_manager) = 1)
                        ";*/
        $wh_str = count($wh_arr) > 0 ? ' AND ' . implode(' AND ', $wh_arr) : '';
        $auction_sale_ar = PEO_getAuctionSale();
        $p = (int)restrictArgs(getQuery('p', 0));
        $p = $p <= 0 ? 1 : $p;
        $len = (int)restrictArgs(getQuery('len', 9));
        //$property_type = array('live', 'forthcoming', 'sale');
        $property_type = array('live');
        $property_data = array();
        foreach ($property_type as $val) {
            $auction_sale = array($auction_sale_ar['auction'], $auction_sale_ar['ebiddar'], $auction_sale_ar['ebidda30'], $auction_sale_ar['bid2stay']);
            $wh_clause = array();
            switch ($val) {
                case 'live':
                    /*$wh_clause[] = 'AND pro.end_time > \'' . date('Y-m-d H:i:s') . '\'
                                    AND pro.confirm_sold = 0
                                    AND pro.end_time > pro.start_time
                                    AND pro.stop_bid = 0
                                    AND pro.start_time <= \'' . date('Y-m-d H:i:s') . '\'
                                    AND pro.pay_status = ' . Property::CAN_SHOW;*/
                    $wh_clause[] = 'AND 1
                                    AND pro.end_time > pro.start_time
                                    AND pro.stop_bid = 0
                                    AND 1
                                    AND pro.pay_status = ' . Property::CAN_SHOW;
                    break;
                case 'forthcoming':
                    $wh_clause[] = '    AND pro.stop_bid = 0
                                        AND pro.end_time > pro.start_time
                                        AND pro.start_time >= \'' . date('Y-m-d H:i:s') . '\'
                                        AND pro.pay_status = ' . Property::CAN_SHOW;
                    break;
                case 'sale':
                    $auction_sale = $auction_sale_ar['private_sale'];
                    $wh_clause[] = ' AND ((IF (pro.confirm_sold = 1  AND datediff(\'' . date('Y-m-d H:i:s') . '\', pro.sold_time) < 14 ,1,0) = 1)
                                        OR pro.confirm_sold = 0)';
                    break;
            }
            $wh_clause = array();
            $wh_clause[] = (is_array($auction_sale) and count($auction_sale) > 0) ? 'AND pro.auction_sale IN(' . implode(',', $auction_sale) . ')' : ' AND pro.auction_sale = ' . $auction_sale;
            $wh_clause[] = ' AND (IF(pro.agent_manager = 0
                                   ,pro.agent_id = ' . $agent_id . '
                                   ,pro.agent_manager = ' . $agent_id . ')
                                 OR pro.agent_id IN (SELECT a.agent_id FROM ' . $agent_cls->getTable() . ' AS a
                                                   WHERE a.parent_id = ' . $agent_id . ' OR a.agent_id = ' . $agent_id . ')
                                 )';
            $pag_link = Agent_seoURL('?module=agent&action=view-detail-agency&uid=' . $agent_id);
            $property_data[$val] = Property_getList(' ' . implode(' ', $wh_clause), $p, $len,'',$pag_link);
            $count[$val] = count($property_data[$val]);
        }
        $_SESSION['where'] = 'list';
        $_SESSION['wh_str'] = ' AND (IF(pro.agent_manager = 0
                                   ,pro.agent_id = ' . $agent_id . '
                                   ,pro.agent_manager = ' . $agent_id . ')
                                 OR pro.agent_id IN (SELECT a.agent_id FROM ' . $agent_cls->getTable() . ' AS a
                                                   WHERE a.parent_id = ' . $agent_id . ' OR a.agent_id = ' . $agent_id . '))';
        $max = max($count);
        $key = array_search($max, $count);
        $smarty->assign('key', $key);
        $smarty->assign('info', $info);
        $smarty->assign('property_data', $property_data);
        $smarty->assign('title', $action_ar[2] == 'agency' ? $info['company_name'] . ' PROFILE' : $info['full_name'] . ' PROFILE');

        break;
    default:
        break;
}
$smarty->assign('ROOTURLS', ROOTURLS);
?>