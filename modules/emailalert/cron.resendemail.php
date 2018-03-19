<?php
/*
	Author  : StevenDuc
	Skype   : stevenduc21
	Company : Global OutSource Solution
 
*/
		//Include File Init();
	if (!isset($_GET['$resend'])) {
	
		include_once '../../configs/config.inc.php';
		include_once '../../includes/functions.php';
	} else {
		include_once ROOTPATH.'/configs/config.inc.php';
		include_once ROOTPATH.'/includes/functions.php';
	}
	
		include_once ROOTPATH.'/modules/emailalert/inc/emailalert.class.php';
		include_once ROOTPATH.'/modules/property/inc/property.php';
		include_once ROOTPATH.'/modules/property/inc/property_media.class.php';
		include_once ROOTPATH.'/modules/property/inc/property_entity_option.class.php';
		include_once ROOTPATH.'/modules/general/inc/regions.php';	
		include_once(ROOTPATH."/includes/class.phpmailer.php");
		$mail = new PHPMailer();
	// Call Constructor init();
	if (!isset($email_cls) || !($email_cls instanceof EmailAlert)) {
		$email_cls = new EmailAlert();
	}
	
	if (!isset($property_cls) || !($property_cls instanceof Property)) {
		$property_cls = new Property();
	}
	
	if (!isset($property_media_cls) || !($property_media_cls instanceof Property_media)) {
		$property_media_cls = new EmailAlert();
	}
	if (!isset($property_entity_option_cls) || !($property_entity_option_cls instanceof Property_entity_option)) {
		$property_entity_option_cls = new Property_entity_option();
	}
	$sqlQuery = "SELECT e.*, agent.firstname, agent.lastname, agent.fullname, agent.email_address, agent.agent_id
							FROM email_alert AS e 
										INNER JOIN agent as agent
						 					ON e.agent_id = agent.agent_id 
							WHERE e.active = 0 ";
								
	$firtsql = mysql_query($sqlQuery);
	
	while ($row = mysql_fetch_array($firtsql) )
	{
		//echo 'AAAAAAAA';
		if (isset($row['property_type']) && ($row['property_type'] > 0)) {
				$where_ar[] = "pro.type = e.property_type AND pro.`type` = ".$row['property_type'];		
		}
		if (isset($row['address']) && strlen($row['address']) > 0) {
			$where_ar[] = "pro.address = e.address AND pro.address = '".$row['address']."'";
		}
		
		if (isset($row['auction_sale']) && strlen($row['auction_sale']) > 0) {
			$where_ar[] = "pro.auction_sale = e.auction_sale AND pro.auction_sale = '".$row['auction_sale']."'";
		}
						
		if (isset($row['suburb']) && strlen($row['suburb']) > 0) {
			$where_ar[] = "pro.suburb = e.suburb AND pro.suburb = '".$property_cls->escape($row['suburb'])."'";
		}
		
		if (isset($row['state']) && $row['state'] > 0) {
			$_state_id = (int)preg_replace('#[^0-9]#','',$property_cls->escape($row['state']));
			$where_ar[] = "pro.state = e.state AND pro.state = ".$_state_id;
		}
		
		if (isset($row['postcode']) && strlen($row['postcode']) > 0) {
			$_postcode = (int)preg_replace('#[^0-9]#','',$property_cls->escape($row['postcode']));
			$where_ar[] = "pro.postcode = e.postcode AND pro.postcode = '".$_postcode."'";
		}
		
		if (isset($row['country']) && $row['country'] > 0) {
			$_country_id = (int)preg_replace('#[^0-9]#','',$property_cls->escape($row['country']));
			$where_ar[] = "pro.country = e.country AND pro.country = ".$_country_id;
		}
		
		if (isset($row['bedroom']) && $row['bedroom'] > 0) {
			$_bedroom_val = (int)preg_replace('#[^0-9]#','',$row['bedroom']);
			$where_ar[] = "pro.bedroom = e.bedroom AND pro.bedroom = ".$_bedroom_val;
		}
		
		if (isset($row['price_range']) && $row['price_range'] > 0) {
			$_price_range_val = (int)preg_replace('#[^0-9]#','',$row['price_range']);
			$where_ar[] = "pro.price_range = e.price_range AND pro.price_range = ".$_price_range_val;
		}
		
		if (isset($row['land_size']) && $row['land_size'] > 0) {
			$_land_size_val = (int)preg_replace('#[^0-9]#','',$row['land_size']);
			$where_ar[] = "pro.land_size = e.land_size AND pro.land_size = ".$_land_size_val;
		}
		
		if (isset($row['bathroom']) && $row['bathroom'] > 0) {
			$_bathroom_val = (int)preg_replace('#[^0-9]#','',$row['bathroom']);
			$where_ar[] = "pro.bathroom = e.bathroom AND pro.bathroom = ".$_bathroom_val;
		}
		
		if (isset($row['minprice']) || isset($row['maxprice'])) {
	
			if (isset($row['minprice']) && isset($row['maxprice'])) {
				$_minprice = (int)preg_replace('#[^0-9]#','',$row['minprice']);
				$_maxprice = (int)preg_replace('#[^0-9]#','',$row['maxprice']);
				if ($_minprice == 0 && $_maxprice == 0) {
					//$where_ar[] = "";
				} else if ($_minprice == 0) {
					$where_ar[] = "pro.price < ".$_maxprice;
				} else if ($_maxprice == 0) {
					$where_ar[] = "pro.price > ".$_minprice;
				} else if ($_maxprice < $_minprice){
					$where_ar[] = "pro.price >= ".$_maxprice." AND pro.price <= ".$_minprice;
				} else {//$form_data['maxprice'] >= $form_data['minprice']
					$where_ar[] = "pro.price >= ".$_minprice." AND pro.price <= ".$_maxprice;
				}
			} else if (isset($row['minprice']) && $row['minprice'] >0) {
				$_minprice = (int)preg_replace('#[^0-9]#','',$row['minprice']);
				$where_ar[] = "pro.price >= ".$_minprice;
			} else if (isset($row['maxprice']) && $row['maxprice'] >0 ){//$form_data['maxprice']
				$_maxprice = (int)preg_replace('#[^0-9]#','',$row['maxprice']);
				$where_ar[] = "pro.price <= ".$_maxprice;
			}
		}
							
		if (count($where_ar) > 0) {
			$where_str = implode(' AND ', $where_ar);
		}
					
		$sql = 'SELECT SQL_CALC_FOUND_ROWS pro.*, ag.firstname, ag.lastname, ag.fullname, ag.email_address, ag.agent_id, e.email_id,
								(SELECT reg1.name FROM '.$region_cls->getTable().' AS reg1 WHERE reg1.region_id = pro.state) AS state_name,
								(SELECT reg2.code FROM '.$region_cls->getTable().' AS reg2 WHERE reg2.region_id = pro.state) AS state_code,
								(SELECT reg3.name FROM '.$region_cls->getTable().' AS reg3 WHERE reg3.region_id = pro.country) AS country_name,
								(SELECT reg4.code FROM '.$region_cls->getTable().' AS reg4 WHERE reg4.region_id = pro.country) AS country_code,
								(SELECT pro_opt1.value 
									FROM '.$property_entity_option_cls->getTable().' AS pro_opt1 
									WHERE pro_opt1.property_entity_option_id = pro.bathroom) AS bathroom_value,
								(SELECT pro_opt2.value 
									FROM '.$property_entity_option_cls->getTable().' AS pro_opt2 
									WHERE pro_opt2.property_entity_option_id = pro.bedroom) AS bedroom_value,
								(SELECT pro_opt3.value 
									FROM '.$property_entity_option_cls->getTable().' AS pro_opt3 
									WHERE pro_opt3.property_entity_option_id = pro.car_port) AS carport_value,
									(SELECT med.file_name
									FROM '.$property_media_cls->getTable('medias').' AS med,'.$property_media_cls->getTable().' AS pro_med 
									WHERE med.media_id = pro_med.media_id AND med.type = \'photo\' AND pro_med.property_id = pro.property_id LIMIT 0,1) AS file_name
								FROM '.$property_cls->getTable().' AS pro , '.$email_cls->getTable().' AS e INNER JOIN agent as ag
										ON  ag.agent_id = e.agent_id AND e.agent_id = '.$_SESSION['agent']['id'].'
								WHERE pro.active = 1  
										AND '.$where_str.' GROUP BY pro.property_id LIMIT 0,5 ';
		//echo $sql;
			
		$rows = $property_cls->getRows($sql,true);
										
		$total_row = $property_cls->getFoundRows();
		$cronfind = mysql_query($sql) or die (mysql_error('errrrrrrr'));	
		//print_r($cronfind); 	
		
						
		 while ($rowcron = mysql_fetch_array($cronfind))
		{
				//echo 'BBBBBBBBBB';
				$namefirt = $rowcron['firstname'];
				//echo $namefirt;
				$namelast = $rowcron['lastname'];			
				$email_ar = $rowcron['email_address'];
				$cv = $rowcron['email_id'];	
				$pr_id = $rowcron['property_id'];			
				 //echo 'Successful';
				//echo 'Sending Email Success';
				// Proccess Send Email 			
				//echo $pr_id;	
				$subject = 'Property You Have Requested';		
				//$subject = 'Property You Have Requested';							
				$emailTo = '';
				if($rowcron['file_name'] == '') {
					$rowcron['file_name'] = ROOTURL.'/modules/property/templates/images/auction-img.jpg';
				} else {
					$rowcron['file_name'] = trim(ROOTURL.$rowcron['file_name'],'/');	
				}
				// Get & Set Data With existing data ;
				if (isset($row['suburb']) && strlen($row['suburb']) > 0) {
				} else {	
					$rowcron['suburb'] = '';		
				}
				if (isset($row['property_type']) && ($row['property_type'] > 0)) {
				} else {
					$rowcron['type'] = '';
				}
				if (isset($row['state']) && $row['state'] > 0) {	
				} else {
					$rowcron['state'] = '';
				}
				if (isset($row['minprice']) || isset($row['maxprice'])) {

					if (isset($row['minprice']) && isset($row['maxprice'])) {
						
						if ($_minprice == 0 && $_maxprice == 0) {
							//$where_ar[] = "";
						} else if ($_minprice == 0) {
						
						} else if ($_maxprice == 0) {
						
						} else if ($_maxprice < $_minprice){
						
						} else {//$form_data['maxprice'] >= $form_data['minprice']
							
						}
						} else if (isset($row['minprice']) && $row['minprice'] >0) {
						
						} else if (isset($row['maxprice']) && $row['maxprice'] >0 ){ //$form_data['maxprice']
					}
				} else {
					$rowcron['price'] = '';
					$row['minprice'] = 0;
					$row['maxprice'] = 0;
				}
				if (isset($row['bedroom']) && $row['bedroom'] > 0) {
				} else {
					$rowcron['bedroom'] = '';
				}
				if (isset($row['land_size']) && $row['land_size'] > 0) {
				} else {
					$rowcron['land_size'] = '';	
				}
				if (isset($row['car_space']) && $row['car_space'] > 0) {	
				} else {
					$rowcron['car_space'] = '';	
				}
				if (isset($row['bathroom']) && $row['bathroom'] > 0) {
				} else {
					$rowcron['bathroom'] = '';		
				}	
				// End Get & Set Data With existing data ;
				if($rowcron['auction_sale'] == 9) {  // Return ReSult Search Auction List 
								//echo 'DUC1';
								
								$content = '';
									$r_str = '<div>
												<div style="margin-top:20px; margin-left:40px; float:left; color: #2f2f2f; font-size: 14px; font-weight: normal;">
													If you want to display all search results that you required please click button
											  	</div>
												<div style="margin-top:16px;float:right;margin-right:130px;">
												<a href="'.ROOTURL.'/?module=property&action=search-auction&property_type='.$rowcron['type'].'&region='.$rowcron['suburb'].' &state='.$rowcron['state'].'&minprice='.$row['minprice'].'&maxprice='.$row['maxprice'].'&bedroom='.$row['bedroom'].'&bathroom='.$row['bathroom'].'&land_size='.$row['land_size'].' ">
													<img style="border:none;" src="'.ROOTURL.'/modules/general/templates/images/showall.png" />
												</a>
												</div> </div>';			
								
								$line_str .= '<div class="auctions-box" style="float:left;">
													<div class=""  style="float:left;">
														<ul class="locat-list" style="list-style-type:none; ">
															<li style="list-style-type:none; ">
																<div class="f-right locat-pro" style="float:left; width:610px;margin-bottom: 15px;padding-bottom: 15px; ">
																	<ul class="pro-list" style="list-style-type:none;">
																		<li style="list-style-type:none;" >
																			<div class="i-img f-left" style="float:left; margin-left:-55px;">
																				<a href="'.ROOTURL.'/?module=property&action=view-auction-detail&id='.$pr_id.'"><img src="'.$rowcron['file_name'].'" alt="img" style="width:180px;height:115px; border:none; margin-left:-55px; "/></a>
																			</div>
																			<div class="i-info f-right" style="height: 115px; position: relative; float:right; width: 360px;">
																				<p class="i-name mb-10px" style="font-size:13px; margin-top: 0; ">
																					'.$rowcron['address'].', '.$rowcron['suburb'].' , '.$rowcron['state_name'].',
																					'.$rowcron['postcode'].'
																				</p>
																				<p class="detail-icons" style="margin-bottom:10px;">
																					<span class="bed icons">
																					 '.$rowcron['bedroom_value'].' <img src="'.ROOTURL.'/modules/general/templates/images/imgemail1.png" style="border:none;margin-top:2px; "/> 
																				</span>
																				<span class="bath icons"> 
																					'.$rowcron['bathroom_value'].' <img src="'.ROOTURL.'/modules/general/templates/images/imgemail2.png" style="border:none;margin-top:2px; "/>
																				</span>

																				<span class="car icons"> 
																					'.$rowcron['carport_value'].' <img src="'.ROOTURL.'/modules/general/templates/images/imgemail3.png" style="border:none;margin-top:2px; "/> 
																					</span>
																				</p>
																				<div class="i-action" style="bottom: 0; left: 0; position: absolute; width: 100%; margin-top: 42px; ">
																					<div class="f-left pt-7px" style="padding-top:20px; float:left;">
																						<span class="price" style="color: #FF7700; font-size: 14px; font-weight: bold;"> '.$rowcron['price'].' </span>
																					</div>
																					<div class="f-right" style="float:right; padding-top:15px; ">
																						<a href="'.ROOTURL.'/?module=property&action=view-auction-detail&id='.$pr_id.'">
																							<img src="'.ROOTURL.'/modules/general/templates/images/btn-view.png" style="border:none; " />
																						</a>
																					</div>
																				</div>  
																			</div>
																			<div class="clearthis">
																			</div> 
																		</li>                        
																		</ul>
																	</div>
																	<div style="padding-bottom: 150px; margin-left: 50px; width: 565px; border-bottom: 1px dashed #6B6B6B; "> </div>
																	<div class="clearthis">
																	</div>
																</li>
														</ul>
														
													</div> </div> ';
												
								} // End  Return ReSult Search Auction List. 
								 
				if($rowcron['auction_sale'] == 10) { // Return ReSult Search Private Sale List
						
							$r_str = '<div>
										<div style="margin-top:20px; margin-left:40px; float:left; color: #2f2f2f; font-size: 14px; font-weight: normal;">
											If you want to display all search results that you required please click button
										</div>
										<div style="margin-top:16px;float:right;margin-right:110px;">
											<a href="'.ROOTURL.'/?module=property&action=search-auction&property_type='.$rowcron['type'].'&region='.$rowcron['suburb'].' &state='.$rowcron['state'].'&minprice='.$row['minprice'].'&maxprice='.$row['maxprice'].'&bedroom='.$row['bedroom'].'&bathroom='.$row['bathroom'].'&land_size='.$row['land_size'].' ">
											<img style="border:none;" src="'.ROOTURL.'/modules/general/templates/images/showall.png" />
										</a>
										</div> </div>';		
							
								$line_str .= '<div class="auctions-box" style="float:left;">
													<div class=""  style="float:left;">
														<ul class="locat-list" style="list-style-type:none; ">
															<li style="list-style-type:none; ">
																<div class="f-right locat-pro" style="float:left; width:610px;margin-bottom: 15px;padding-bottom: 15px; ">
																	<ul class="pro-list" style="list-style-type:none;">
																		<li style="list-style-type:none;" >
																			<div class="i-img f-left" style="float:left; margin-left:-55px;">
																				<a href="'.ROOTURL.'/?module=property&action=view-sale-detail&id='.$pr_id.'"><img src="'.$rowcron['file_name'].'" alt="img" style="width:180px;height:115px; border:none; margin-left:-55px; "/></a>
																			</div>
																			<div class="i-info f-right" style="height: 115px; position: relative; float:right; width: 360px;">
																				<p class="i-name mb-10px" style="font-size:13px; margin-top: 0; ">
																					'.$rowcron['address'].', '.$rowcron['suburb'].' , '.$rowcron['state_name'].',
																					'.$rowcron['postcode'].'
																				</p>
																				<p class="detail-icons" style="margin-bottom:10px;">
																					<span class="bed icons">
																						 '.$rowcron['bedroom_value'].'<img src="'.ROOTURL.'/modules/general/templates/images/imgemail1.png" style="border:none;margin-top:2px "/> 
																					</span>
																					<span class="bath icons"> 
																						'.$rowcron['bathroom_value'].' <img src="'.ROOTURL.'/modules/general/templates/images/imgemail2.png" style="border:none;margin-top:2px "/> 
																					</span>
																					<span class="car icons"> 
																						'.$rowcron['carport_value'].' <img src="'.ROOTURL.'/modules/general/templates/images/imgemail3.png" style="border:none;margin-top:2px "/> 
																					</span>
																				</p>
																				<div class="i-action" style="bottom: 0; left: 0; position: absolute; width: 100%; margin-top: 42px; ">
																					<div class="f-left pt-7px" style="padding-top:20px; float:left;">
																						<span class="price" style="color: #FF7700; font-size: 14px; font-weight: bold;"> '.$rowcron['price'].' </span>
																					</div>
																					<div class="f-right" style="float:right; padding-top:15px; ">
																						<a href="'.ROOTURL.'/?module=property&action=view-sale-detail&id='.$pr_id.'">
																							<img src="'.ROOTURL.'/modules/general/templates/images/btn-view.png" style="border:none; " />
																						</a>
																					</div>
																				</div>  
																			</div>
																			<div class="clearthis">
																			</div> 
																		</li>                        
																		</ul>
																	</div>
																	<div style="padding-bottom: 150px; margin-left: 50px; width: 565px; border-bottom: 1px dashed #6B6B6B; "> </div>
																	<div class="clearthis">
																	</div>
																</li>
														</ul>												
														
													</div> </div> '; 
													
							
						} // End Return ReSult Search Private Sale List.	
					
				 // Process Run Cron Agent With Cron System 
				
				$nd = '<h5 style="font-weight: normal; font-size: 14px; color: #2f2f2f;">
																		Dear '.$namefirt.' '.$namelast.' 
																</h5>
																<h3 style="font-size: 14px;"> Property You Have Requested </h3>
																	
																	'.$r_str.'
																	<br /> 
																	<br />
																	<br />
																	<br />
																	<br />
																	<br />
																	'.$line_str.' ';	
																					
				$content = emailTemplatesSend($nd);	
											
											 
				$sqlcron = 'SELECT Now(), schedule, end_time, last_cron, email_id, active From '.$email_cls->getTable().'';
				$execron = mysql_query($sqlcron);
				
				while($drowcron = mysql_fetch_assoc($execron)) {
				
					//Updates Last Cron 
				$today = getdate(); 
				$dates = $today["year"] . "-" . $today["mon"] ."-" . $today["mday"] . "-"
										.$today["hours"] . "-" . $today["minutes"] . "-" . $today["seconds"];
										
				/*$sqlcron = 'Update '.$email_cls->getTable().' 
								SET last_cron = "'.$dates.'" 
							WHERE email_id = '.$cv.' 
								AND active = 0'; */
								
				$sqlcron = 'Update '.$email_cls->getTable().' 
							SET last_cron = "'.$dates.'" 
							WHERE  active = 0'; 
							
				//echo($sqlcron);	
					
										
				$cronup = mysql_query($sqlcron); 
				
					// With Daily
					if ($drowcron['schedule'] == 1) {	
							$targetday = $today["mday"];			
							$ddcron1 = 'SELECT DAY(last_cron), email_id FROM '.$email_cls->getTable().'
											WHERE DAY(last_cron) > DAY(end_time) AND allows = 1 AND schedule = 1 AND active = 0';	
													
							$ddayexe1 = mysql_query($ddcron1); 
							$numResult = mysql_num_rows($ddayexe1);
								if ($numResult > 0) { 
									//echo 'TESTDUCCCCCCCCCCCCCCCCCCCCC';
									$up1 = "Update email_alert set active = 1 WHERE email_id = $cv AND schedule = 1 AND active = 0";
									mysql_query($up1);	
									//echo $numResult;
									// Proccess Send Email 					
									$mail->IsMail();
									$mail->FromName = SITE_TITLE;
									$mail->Sender = $email_ar;
									$mail->Subject = $subject;
									$mail->AddBCC($email_ar);
									$mail->IsHTML(true);	
									$mail->Body = $content;
									$mail->Send(); 		
									
								}	
									
					}
					// With Weekly
						$targetday = $today["mday"];	
						$drowcron['end_time'];
						$drowcron['last_cron'];
						//print_r($drowcron['end_time']);
							//print_r($drowcron['last_cron']);
								 
					if ($drowcron['schedule'] == 2 ) {
								
							$ddcron2 = 'Select DATEDIFF(Now(), end_time) as DDIF from '.$email_cls->getTable().'
										 WHERE DATEDIFF(Now(), end_time) >= 7 AND allows = 1 AND schedule = 2 AND active = 0 ';	
													
							$ddayexe2 = mysql_query($ddcron2); 
							$numResult2 = mysql_num_rows($ddayexe2);
								if ($numResult2 > 0) { 
									
									$up2 = "Update email_alert set active = 1 WHERE email_id = $cv AND schedule = 2 AND active = 0";
									mysql_query($up2);		
									// Proccess Send Email 					
									$mail->IsMail();
									$mail->FromName = SITE_TITLE;
									$mail->Sender = $email_ar;
									$mail->Subject = $subject;
									$mail->AddBCC($email_ar);
									$mail->IsHTML(true);	
									$mail->Body = $content;
									$mail->Send(); 		
												
								}		
									
					}
					
					// With Monthly
					if ($drowcron['schedule'] == 3) {
							$targetday = $today["mday"];			
							$ddcron3 = 'SELECT MONTH(last_cron) FROM '.$email_cls->getTable().'
											WHERE MONTH(last_cron) > MONTH(end_time) AND allows = 1 AND schedule = 3 AND active = 0';	
													
							$ddayexe3 = mysql_query($ddcron3);
							$numResult3 = mysql_num_rows($ddayexe3);
								if ($numResult3 > 0) { 
									$up3 = "Update email_alert set active = 1 WHERE email_id = $cv AND schedule = 3 AND active = 0";
									mysql_query($up3);	
									// Proccess Send Email 					
									$mail->IsMail();
									$mail->FromName = SITE_TITLE;
									$mail->Sender = $email_ar;
									$mail->Subject = $subject;
									$mail->AddBCC($email_ar);
									$mail->IsHTML(true);	
									$mail->Body = $content;
									$mail->Send(); 		
													
							}
							
							
						}
					}
			}  // End While $rowcron

		$results = mysql_query($sql);	
		//mysql_free_result($result); 		
}
	
?>