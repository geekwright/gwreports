<?php
// @version    $Id$
$adminmenu[1] = array(
	'title'	=> _MI_GWREPORTS_ADMENU ,
	'link'	=> 'admin/index.php' ,
	'icon'	=> 'images/icon_opt_home.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_TOPIC ,
	'link'	=> 'admin/topics.php' ,
	'icon'	=> 'images/icon_opt_topic.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_REPORT ,
	'link'	=> 'admin/reports.php' ,
	'icon'	=> 'images/icon_opt_report.png'
) ;

//$adminmenu[] = array(
//	'title'	=> _MI_GWREPORTS_AD_EXPLORE ,
//	'link'	=> 'admin/explore.php' ,
//	'icon'	=> 'images/icon_opt_explore.png'
//) ;
if(!defined("_MI_GWREPORTS_AD_LIMITED")) define("_MI_GWREPORTS_AD_LIMITED", "Yes");

?>