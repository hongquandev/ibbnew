<?php 
session_start();
require '../../configs/config.inc.php';
require ROOTPATH.'/includes/functions.php';
include ROOTPATH.'/includes/model.class.php';
include 'lang/comment.en.lang.php';
include_once ROOTPATH.'/includes/pagging.class.php';
if (!isset($pag_cls) or !($pag_cls instanceof Paginate)) {
	$pag_cls = new Paginate();
}

include_once ROOTPATH.'/modules/general/inc/user_online.php';

if (!isset($user_online_cls) || !($user_online_cls instanceof UserOnline)) {
    $user_online_cls = new UserOnline();
}
$user_online_cls->checkOnline();

$action = getParam('action');
if (eregi('-',$action)) {
	$acts = explode('-',$action);
	if (isset($acts[1])) {
		switch ($acts[1]) {
			case 'comment':
				include_once ROOTPATH.'/modules/comment/inc/comment.php';
				switch ($acts[0]) {
					case 'send':
						
						$result = array('error' => 'There is an error when you comment.');
						
						$name = getPost('name');
						$email = getPost('email');
						$title = getPost('title');
						$content = scanContent(getPost('content'));
						$property_id = (int)restrictArgs(getPost('property_id',0));
						
						if ($property_id > 0) {
							$data = array('name' => $comment_cls->escape($name),
											'email' => $comment_cls->escape($email),
											'title' => $comment_cls->escape($title),
											'content' => $comment_cls->escape($content),
											'created_date' => date('Y-m-d H:i:s'),
											'property_id' => $property_id,
											'type' => 'property',
											'active' => 0);
							
							$comment_cls->insert($data);
							
							if ($comment_cls->hasError()) {
							
							} else {
								$comment_id = $comment_cls->insertId();
							}
							
							$row = $comment_cls->getRow('SELECT COUNT(*) AS num 
												FROM '.$comment_cls->getTable().' AS com
												WHERE com.property_id = '.$property_id,true);
							
							
							$data['delete_last'] = 0;
							if (is_array($row) and count($row) > 0 and $row['num'] > 5) {
								$data['delete_last'] = 1;
							}
							
							$data['created_date'] = date('d/m/Y');
							$result = array('success' => 1,'data' => array());
						}
						die(_response($result));
					break;
					
					case 'view':
						$property_id = (int)restrictArgs(getQuery('property_id',0));

						
						$p = (int)restrictArgs(getQuery('p',1));
						$p = $p <= 0 ? 1 : $p;
						$len = 5;
						$str = '<div class="your-say-list"><ul id="comment_container">';
                        $page = '';
						global $pag_cls;

						$comment_rows = $comment_cls->getRows('SELECT com.comment_id,com.name,com.email,com.title,com.content,com.created_date
												FROM '.$comment_cls->getTable().' AS com
												WHERE com.property_id='.$property_id.' AND com.active=1
												ORDER BY com.comment_id DESC
												LIMIT '.(($p-1)*$len).','.$len,true);
                        $total_row = $comment_cls->getRows('property_id='.$property_id.' AND active=1');
                        $pag_cls->setTotal(count($total_row))
                                    ->setPerPage($len)
                                    ->setCurPage($p)
                                    ->setLenPage(10)
                                    ->setUrl('/modules/comment/action.php?action=view-comment&property_id='.$property_id)
                                    ->setLayout('ajax')
                                    ->setFnc('com.view');

					    //print_r($comment_cls->sql);
																		
						if ($comment_cls->hasError()) {
						
						} else if (is_array($comment_rows) and count($comment_rows)>0) {
							foreach ($comment_rows as $row) {

								$str .= '<li>
											<p class="cm-title">'.$row['title'].'</p>
											<p class="cm-posted">
												Posted by '.$row['name'].' on '.$row['created_date'].'
											</p>
											<p class="cm-content">'.$row['content'].'</p>
										</li>';
							}
                            //global $pag_cls;
                           $page = '<div class="clearthis"></div>'.$pag_cls->layout();
						}
                        $str .='</ul></div>'.$page;

						die($str);
					break;
				}
			break;
		}
		
		if (isset($result['success'])) {
			$result_ = array('success'=>1);
		} else {
			$result_ = array('error'=>$result['error'],'info'=>'a');
		}
		die( _response($result_));
	}
} 
?>