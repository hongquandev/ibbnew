<?php 

        include_once '../../includes/functions.php';
	$smarty = new Smarty; 
	$smarty->template_dir = '../modules/contacts/templates/'; 
        if(detectBrowserMobile()){ 
            $smarty->compile_dir = '../m.templates_c/';
        }else{
            $smarty->compile_dir = '../templates_c/';
        } 
	
		if ($_SESSION['language'] == 'vn') {
			include 'lang/contactus.vn.lang.php';
		}else{
			include 'lang/contactus.en.lang.php';
		}
		
		$result= mysql_query("SELECT * FROM `cms_page`");
		while($row=mysql_fetch_assoc($result)){
			$cms[$row['page_id']] = $row['page_id'];
		} 
		
		$smarty->assign('part', "../modules/contacts/");
		$smarty->assign('imagepart' , "../modules/general/templates/images/");
		if(isset($_GET['action'])) {		
			$smarty->assign('action', $_GET['action']);
		}
			//Read File Xml;
			
			$doc = new DOMDocument();
			$doc->load('../modules/contacts/contact.xml'); 
		  	$ctact = $doc->getElementsByTagName("Contact");
			  foreach( $ctact as $Contact )
			  { 
				  $titles = $Contact->getElementsByTagName("EmailName");
				  $title = $titles->item(0)->nodeValue;
				
			  }
	 			  $emailTo =$title;	 
			   	  $smarty->assign('emailTo', $emailTo); 		  	
	
?>