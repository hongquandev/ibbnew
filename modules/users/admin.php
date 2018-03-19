<?php 
	
	include 'lang/users.en.lang.php';
	$smarty -> assign("action",$_GET['action']);	 
	
	//if(isset($adduser))
//	{
//		include_once 'inc/users.add.php';
//	}
	
	//$smarty->assign('part', "../modules/users/inc/");
	
	//if (isset($_POST['submit']))
	//{
	//	include 'inc/users.add.php';
	//}
	
	
		if (isset($subadd))
		{
			include 'inc/users.add.php';
		}

	switch ($_GET['action']) {
		
		default: 
			 
		break;
		
		case 'changepassword':  
			include 'inc/changepassword.php';
		break;
		case 'edituser':
			include 'inc/users.edit.php';
		break;
		case 'adduser':
			include 'inc/users.add.php';
		break;
		
		
	}
	//Get Country Selected
	$filter = mysql_query("SELECT a.name, b.country FROM regions as a, agent as b WHERE a.region_id=b.country AND b.agent_id ='{$_GET['ID']}' ");
	$row=mysql_fetch_assoc($filter);
	$smarty->assign("filter",$row);
	
	
	
	//Get Country
	$result =mysql_query("SELECT name, region_id FROM  regions WHERE parent_id=0");
	while($row=mysql_fetch_assoc($result)){
		$country[$row['region_id']] = $row['name'];
	} 
	$smarty -> assign("country",$country);
	
	
	//Get State Selected
	$filters =mysql_query("SELECT a.name, b.suburb FROM regions as a, agent as b WHERE a.region_id=b.suburb AND b.agent_id = '{$_GET['ID']}'");
	$row=mysql_fetch_assoc($filters);
	$smarty -> assign("filters",$row);
	//Get State
	$result =mysql_query("SELECT name, region_id FROM regions WHERE parent_id !=0");
	while ($row=mysql_fetch_assoc($result)){
		   $state[$row['region_id']] =$row['name'];
	}
	$smarty -> assign("state",$state);
	if ($_GET['ID'] > 0) {
	
			$result=mysql_query("SELECT * FROM agent
										  WHERE `agent_id` = '{$_GET['ID']}'");  	
			$row=mysql_fetch_assoc($result); 
			$smarty -> assign("row",$row);
	
	}
?>