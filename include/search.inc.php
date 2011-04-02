<?php
/**
* search.inc.php - search report definitions
*
* This file is part of gwreports - geekwright Reports
*
* @copyright  Copyright © 2011 geekwright, LLC. All rights reserved. 
* @license    gwreports/docs/license.txt  GNU General Public License (GPL)
* @since      1.0
* @author     Richard Griffith <richard@geekwright.com>
* @package    gwreports
* @version    $Id$
*/

if (!defined("XOOPS_ROOT_PATH")) die("Root path not defined");

function gwreports_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB, $xoopsUser;

	$ret = array();

	// we cannot search by user id, so return empty result
	if ( $userid != 0 ) {
		return $ret;
	}

	// get array of groups for current user
	$usergroups=array(XOOPS_GROUP_ANONYMOUS);
	if($xoopsUser) {
		$usergroups=$xoopsUser->getGroups();
	}
	$wheregroup='';
	foreach($usergroups as $i) {
		if($wheregroup=='') $wheregroup .='('.$i;
		else $wheregroup .=','.$i;
	}
	$wheregroup .=')';

	$sql = 'SELECT DISTINCT report_id, report_name, report_description FROM ';
	$sql.= $xoopsDB->prefix('gwreports_report') . ' r, ';
	$sql.= $xoopsDB->prefix('gwreports_access') . ' a ';
	$sql.=' WHERE report_active = 1  ';
	$sql.=' AND a.groupid in '.$wheregroup;
	$sql.=' AND r.report_id=a.report ';
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((report_name LIKE '%$queryarray[0]%' OR report_description LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(report_name LIKE '%$queryarray[$i]%' OR report_description LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
	}

	$sql .= "ORDER BY report_name, report_id ";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$retcnt = 0;
 	while($myrow = $xoopsDB->fetchArray($result)){
		$ret[$retcnt]['image'] = "images/srchicon.gif";
		$ret[$retcnt]['link']="report_view.php?rid=".$myrow['report_id'];
		$ret[$retcnt]['title'] = $myrow['report_name'];
		$ret[$retcnt]['time'] = '';
		$ret[$retcnt]['uid'] = 0;
		$retcnt++;
	}
	
	return $ret;
}
?>