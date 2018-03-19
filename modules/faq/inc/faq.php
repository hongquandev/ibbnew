<?php 
include_once 'faq.class.php';
include_once ROOTPATH.'/modules/contentfaq/inc/contentfaq.class.php';

if (!isset($faq_cls) or !($faq_cls instanceof Faq)) {
	$faq_cls = new Faq();
}

if (!isset($contentfaq_cls) or !($contentfaq_cls instanceof ContentFaq)) {
	$contentfaq_cls = new ContentFaq();
}

function Menu($faq_id = 0) {

global $faq_cls, $contentfaq_cls;

$rs = '';

$cms_row = array();
$cms_faq = array();

$total = 0;
$tem_2 = array();
$tem_1 = array();

$rows = $faq_cls->getRows('SELECT * FROM '.$faq_cls->getTable().' WHERE active = 1', true);

	foreach ($rows as $row) {
		$rs2 = '';
		$rs3 = '';
			$cms_faq[] = $row;
			//echo $row['title'];
		
			$rows2 = $faq_cls->getRows('SELECT * FROM '.$contentfaq_cls->getTable().' AS b
										WHERE b.faq_id = '.$row['faq_id'].'', true);										
			//echo $faq_cls->sql;
			
			$total = $faq_cls->getFoundRows();
			
			if (is_array($rows2) and count($rows2) > 0) {
					
				foreach($rows2 as $row2) {
				
					$rs2 .= ' <div class="sr-nap2">
									<a class="ctquestion" href="javascript:void(0)" onclick = "showNode(\'a'.$row2['content_id'].'\')" 
									   id="q'.$row2['content_id'].'" name="q'.$row2['content_id'].'" >Q: '.$row2['question'].'
									</a> 
							 	</div>
													
								 <div style="margin-left:20px;margin-top:10px; margin-bottom:10px;">
											<div class="cthide" id="a'.$row2['content_id'].'" style="display:none"> '.$row2['answer'].' </div> 
								 </div> 
							';
							
					$tem_2 = array('question'=>$row2['question'] , 'answer'=>$row2['answer'] );
				}	
				
			}
			
		$tem_1 = array('title'=> $row['title'] );
					
	/*	$rs .= '<ul id="nav"> 
					<li onmouseover="mouseOver()" ><a href="#">'.$row['title'].'</a> 
						
						<ul> 
							'.$rs2.'
						</ul> 
					</li> 
				</ul>'; 
	*/			
		$rs .='<div class="sr-nap"> 
					<ul>
						<li onmouseover="mouseOver()" ><a href="#">'.$row['title'].'</a> 
							<ul class="sr-nap2"> 
								'.$rs2.' 
							</ul> 
						</li> 
				</ul> </div> ';		  
					                   
	}

	return $rs;
	
}

function Menu2($faq_id = 0) {

global $faq_cls, $contentfaq_cls;

$rs = '';

$cms_row = array();
$cms_faq = array();

$total = 0;
$tem_2 = array();
$tem_1 = array();

$rows = $faq_cls->getRows('SELECT * FROM '.$faq_cls->getTable().' WHERE active = 1 ORDER BY faq_id ASC LIMIT 0,1', true);

	foreach ($rows as $row) {
		$rs2 = '';
		$rs3 = '';
			$cms_faq[] = $row;
			//echo $row['title'];
		
			$rows2 = $faq_cls->getRows('SELECT * FROM '.$contentfaq_cls->getTable().' AS b
										WHERE b.faq_id = '.$row['faq_id'].' ', true);										
			//echo $faq_cls->sql;
			
			$total = $faq_cls->getFoundRows();
			
			if (is_array($rows2) and count($rows2) > 0) {
					
				foreach($rows2 as $row2) {
				
					$rs2 .= '<div class="sr-nap2">
					
								<a class="ctquestion2" href="javascript:void(0)" onclick = "showNode(\'a'.$row2['content_id'].'\')" 
								   id="q'.$row2['content_id'].'" name="q'.$row2['content_id'].'" >Q: '.$row2['question'].'
								</a> 
							 </div>
													
							 <div style="margin-left:20px;margin-top:10px; margin-bottom:10px;">
										<div class="cthide" id="a'.$row2['content_id'].'" style="display:none"> '.$row2['answer'].' </div> 
							 </div> ';
							
				}	
				
			}
			
				
		$rs .= '<div class="sr-nap2">
					
						'.$rs2.' 	
				</div>';  
					                   
	}

	return $rs;
	
}


?>