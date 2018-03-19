<?php 
include_once 'contentfaq.class.php';
if (!isset($contentfaq_cls) or !($contentfaq_cls instanceof ContentFaq)) {
	$contentfaq_cls = new ContentFaq();
}
/*
function Menu($faq_id = 0) {
	global $contentfaq_cls;
	$rs = '';
	$cms_row = array();
	$rows = $contentfaq_cls->getRows('SELECT * FROM '.$contentfaq_cls->getTable().' WHERE active = 1 ORDER BY position ASC ', true);
	// $rs.='<span style="float:right; margin-bottom:10px;"> <a href="javascript:void(0)" onclick="Collapse()" > Collapse all </a> </span>';
	$rs.= '<div class="brx"> </div>';
	foreach ($rows as $row) {
		$rs2 = '';
		$rs3 = '';
		$cms_faq[] = $row;
		$rs.='<dl>
				<dt><!-- <h1>The Environmental Challenge</h1> --></dt>
				<dd>
					<ul class="common-questions questions">
						<li>
							<div>		 
								<span class="title" >
									<a href="javascript:void(0)"  onclick = "showNode(\''.$row['content_id'].'\')" id="q'.$row['content_id'].'" name="q'.$row['content_id'].'" >
										<img src="modules/general/templates/images/IBB_1.png" width="16px;" id="img1'.$row['content_id'].'" /> 
										<p id="ttr"> '.$row['question'].'</p> 
									</a>		 							 		  
								</span> 
								<div class="clearthis"> </div>
							</div>
							<div class="content"  id="a'.$row['content_id'].'"style="display: none;"><p> '.$row['answer'].' </p></div>						
						</li>
					</ul>
				</dd>
			</dl>';
	} 
	
	return $rs;
}
*/