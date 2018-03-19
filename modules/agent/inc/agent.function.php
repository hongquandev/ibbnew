<?php


function A_emailTemplatesSend($content,$footer = true) {
	global $config_cls;
	$sign = '';
	if ($footer){
		$sign = $config_cls->getKey('email_sign');

	}


	$str = '<table class="table-mail-template-main" cellpadding="0" cellspacing="0" width="800" align="center" style="margin:auto; font-family: Arial, Helvetica, sans-serif;">
			<tr>
				<td style="padding: 5px 15px;">
					<img src="'.ROOTURL.'/modules/general/templates/images/emailalert/images/email-logo.png" width="319" height="77" />
				</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;">
					<table class="table-email-template" cellpadding="0" cellspacing="0" width="787px" style="font-size: 11px; color: #666;">
						<tr class="tra-email-template">
							<td background=\''.ROOTURL.'/modules/general/templates/images/emailalert/images/email-box-tl.png\'0 0 no-repeat; width="19px" height="40px" >   </td>
							<td background=\''.ROOTURL.'/modules/general/templates/images/emailalert/images/email-box-tc.png\'0 0 repeat-x; style="width: 749px; height: 30px; text-align: right; padding-top: 10px;">
								<a href="'.ROOTURL.'" style="padding: 0px 5px 0px 0px;"> <img src="'.ROOTURL.'/modules/general/templates/images/btn-email-home.png" style="border:none;" /> </a> <a href="'.ROOTURL.'/?module=property&action=view-auction-list" style="padding: 0px 5px 0px 0px;"><img style="border:none;" src="'.ROOTURL.'/modules/general/templates/images/emailalert/images/btn-auctions.png" width="98px" height="22px" /></a><a href="'.ROOTURL.'/?module=property&action=view-sale-list" style="padding: 0px 5px 0px 0px;"><img src="'.ROOTURL.'/modules/general/templates/images/emailalert/images/btn-forsale.png" style="border:none;" width="98px" height="22px" /></a><a href="'.ROOTURL.'/?module=agent&action=view-dashboard-vendor" style="padding: 0px 5px 0px 0px;"><img src="'.ROOTURL.'/modules/general/templates/images/emailalert/images/btn-vendor.png" style="border:none;" width="82px" height="22px" /></a><a href="'.ROOTURL.'/?module=agent&action=view-dashboard-buyer" style="padding: 0px 5px 0px 0px;"><img style="border:none;" src="'.ROOTURL.'/modules/general/templates/images/emailalert/images/btn-buyer.png" width="71px" height="22px" /></a>
							</td>
							<td background=\''.ROOTURL.'/modules/general/templates/images/emailalert/images/email-box-tr.png\' 0 0 no-repeat; width="19px" height="40px" >
							</td>
						</tr>

						<tr class="trb-email-template">
							<td background=\''.ROOTURL.'/modules/general/templates/images/emailalert/images/email-box-cl.png\' 0 0 repeat-y; style="" width: 19px;>
							</td>
							<td class="tdb-email-template" style="background-color: #fff; width: 749px; ">
								<br/>
									'.$content.'

								<br/>
								<br/>
								<br/>
								<br/>

								<div align="center" style="margin-bottom: 30px; width:740px; float:right">
									'.$sign.'
								</div>
								<br/><br/>

							</td>
							<td background=\''.ROOTURL.'/modules/general/templates/images/emailalert/images/email-box-cr.png\' 0 0 repeat-y; style="width: 19px; ">
							</td>
						</tr>
						<tr class="trc-email-template" height ="240px">
							<td background=\''.ROOTURL.'/modules/general/templates/images/emailalert/images/email-box-bl.png\' 0 0 no-repeat; style="" width: 19px; height: 166px; >
							</td>
							<td background=\''.ROOTURL.'/modules/general/templates/images/emailalert/images/email-box-bc.png\' 0 0 repeat-x;  style="" width: 749px; height: 166px; >
							    <table class="tdc-email-template" height ="240px" cellspacing="10" >
									<tr style="">
										<td style="vertical-align: top; padding-right: 10px; padding-top:0px;">
											<label style="font-size: 12px; color: #fff;">
												<strong>SEARCH</strong>
											</label>
											<ul style="font-size: 12px; color: #fff; list-style: none; margin: 0px; padding: 0px;">
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=property&action=view-search-advance-auction" style="color: #fff; text-decoration: none;">Auction List</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=property&action=view-search-advance-sale" style="color: #fff; text-decoration: none;">Private Sale List</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/search-partner-list.html" style="color: #fff; text-decoration: none;">Partner List </a>
												</li>
											</ul>
										</td>
										<td style="vertical-align: top; padding-right: 10px; padding-top:0px;">
											<label style="font-size: 12px; color: #fff;">
												<strong>AUCTIONS</strong>
											</label>
											<ul style="font-size: 12px; color: #fff; list-style: none; margin: 0px; padding: 0px;">
												<!-- <li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=property&action=view-tv-show" style="color: #fff; text-decoration: none;">The Block</a>
												</li> -->
											<li style="margin-left: 0px;">
												<a href="'.ROOTURL.'/?module=property&action=view-auction-list" style="color: #fff; text-decoration: none;">Live Auctions</a>
											</li>
											<li style="margin-left: 0px;">
												<a href="'.ROOTURL.'/?module=property&action=view-forthcoming-list" style="color: #fff; text-decoration: none;">Forthcoming Auctions</a>
											</li>
											<li style="margin-left: 0px;">
												<a href="'.ROOTURL.'/ibb-aution-rules.html" style="color: #fff; text-decoration: none;">iBB Auction rules</a>
											</li>
											</ul>
										</td>
										<td style="vertical-align: top; padding-right: 10px; padding-top:0px;">
											<label style="font-size: 12px; color: #fff;">
												<strong>FOR SALE</strong>
											</label>
											<ul style="font-size: 12px; color: #fff; list-style: none; margin: 0px; padding: 0px;">
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=property&action=view-sale-list" style="color: #fff; text-decoration: none;">Private Sale List</a>
												</li>
											</ul>
										</td>
										<td style="vertical-align: top; padding-right: 10px; padding-top:0px;">
											<label style="font-size: 12px; color: #fff;">
												<strong>VENDOR</strong>
											</label>
											<ul style="font-size: 12px; color: #fff; list-style: none; margin: 0px; padding: 0px;">
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/vendor-how-it-works.html" style="color: #fff; text-decoration: none;">How It Works</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/vendor-pricing.html" style="color: #fff; text-decoration: none;">Vendor Pricing</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=agent&action=register-vendor" style="color: #fff; text-decoration: none;">Register</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=agent&action=view-property-vendor" style="color: #fff; text-decoration: none;">List New Property</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/edit-existing-property.html" style="color: #fff; text-decoration: none;">Edit Existing Property</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=agent&action=view-auction-vendor" style="color: #fff; text-decoration: none;">Manage Auction Terms</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/vendor-benefits.html" style="color: #fff; text-decoration: none;">Vendor Benefits</a>
												</li>
											</ul>
										</td>
										<td style="vertical-align: top; padding-right: 10px; padding-top:0px;">
											<label style="font-size: 12px; color: #fff;">
												<strong>BUYER</strong>
											</label>
											<ul style="font-size: 12px; color: #fff; list-style: none; margin: 0px; padding: 0px;">
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/buyer-how-it-works.html" style="color: #fff; text-decoration: none;">How It Works</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/buyer-pricing.html" style="color: #fff; text-decoration: none;">Buyer Pricing</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/index.php?module=agent&action=register-buyer" style="color: #fff; text-decoration: none;">Register</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=agent&action=edit-notification" style="color: #fff; text-decoration: none;">Edit Notifications</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/?module=agent&action=view-property-buyer" style="color: #fff; text-decoration: none;">List Property</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/buyer-benefits.html" style="color: #fff; text-decoration: none;">Benefits</a>
												</li>
											</ul>
										</td>
										<td style="vertical-align: top; padding-top:0px;">
											<label style="font-size: 12px; color: #fff;">
												<strong>PARTNERS</strong>
											</label>
											<ul style="font-size: 12px; color: #fff; list-style: none; margin: 0px; padding: 0px;">
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/view-partner-list.html" style="color: #fff; text-decoration: none;">Partner List</a>
												</li>
												<li style="margin-left: 0px;">
													<a href="'.ROOTURL.'/index.php?module=agent&action=register-partner" style="color: #fff; text-decoration: none;">Register</a>
												</li>
											</ul>
										</td>
									</tr>
									<tr></tr>

									<tr>
										<td></td>
										<td></td>
										<td style="text-align: right; font-size: 14px; font-weight: bold; margin-left: 0px; width: 138px;">
										    <a style="color: white; text-decoration: none;" href="http://gos.com.vn">&copy; Powered by Gos</a>
										</td>
									</tr>

								</table>
							</td>
							<td background=\''.ROOTURL.'/modules/general/templates/images/emailalert/images/email-box-br.jpg\' 0 0 no-repeat; style="" width: 19px; height: 166px;>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>';

		return $str;
}



