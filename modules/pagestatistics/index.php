<?php 
		$smarty = new Smarty;  	
		$smarty->assign('part', "../modules/cms/");
		$smarty->assign('imagepart' , "../modules/general/templates/images/");		
		$result = "SELECT title,content from cms_page WHERE page_id = '{$_GET['pages_id']}' 
					AND is_active = 1 ";	
		$showBanner = "SELECT banner_file from banners
						WHERE status = 1 ";				
		$smarty->assign('imagepart' , "../modules/general/templates/images/");
			if (isset($_GET['pages_id']))
			{				
					$handle = mysql_query($result);
					if($row = mysql_fetch_assoc($handle))
							{			
								$smarty->assign('row', $row);	
								$smarty->assign('pages_id', $_GET['pages_id']);	
							}
					else
					{
						$smarty->assign('row', "error");
					}
					
					// Show banner 
					$handle2 = mysql_query($showBanner);
					$arr = array();
					
					while($rowbanner = mysql_fetch_assoc($handle2))
					{
						$arr[] = $rowbanner['banner_file'];
					}		
						$smarty->assign('rowbanner', $arr);		
						$smarty->assign('pages_id', $_GET['pages_id']);
			}
            else{
                Report_pageRemove(Report_parseUrl());
                //redirect(ROOTURL.'/notfound.html');
				redirect('/notfound.html');
            }

?>