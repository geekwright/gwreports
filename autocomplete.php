<?php

include '../../mainfile.php';
//$GLOBALS['xoopsOption']['template_main'] = 'gwreports_reportview.html';
include(XOOPS_ROOT_PATH."/header.php");
$table = XOOPS_DB_PREFIX."_gwreports_parameter";
$parameter_id=$_REQUEST['parameter_id'];


$sql="SELECT * FROM $table where parameter_id=$parameter_id";
$q=$xoopsDB->query($sql);
$sqlchoice='';
while($r=$xoopsDB->fetchArray($q)){
	$sqlchoice=$r['sqlchoice'];

	}

if($sqlchoice=='')
die;
else{
$str=$_REQUEST['term'];

 $sqlchoice="SELECT * FROM ($sqlchoice) a where a.label LIKE  '%$str%' order by a.label limit 0,30";

		$query=$xoopsDB->query($sqlchoice);
				$data=array();

		while($row=$xoopsDB->fetchArray($query)){
		
				$data[]=array('value'=> $row['value'],"label"=>$row['label']);
			}
		
			echo json_encode($data);
	
	
	}

