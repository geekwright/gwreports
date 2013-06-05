<?php
// @version    $Id$
if(file_exists(XOOPS_ROOT_PATH.'/Frameworks/moduleclasses/icons/32/about.png')) {
$pathIcon32='../../Frameworks/moduleclasses/icons/32';

$adminmenu[1] = array(
	'title'	=> _MI_GWREPORTS_ADMENU ,
	'link'	=> 'admin/index.php' ,
	'icon'	=> $pathIcon32.'/home.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_ABOUT ,
	'link'	=> 'admin/about.php' ,
	'icon'	=> $pathIcon32.'/about.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_TOPIC ,
	'link'	=> 'admin/topics.php' ,
	'icon'	=> $pathIcon32.'/category.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_REPORT ,
	'link'	=> 'admin/reports.php' ,
	'icon'	=> $pathIcon32.'/index.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_EXPLORE ,
	'link'	=> 'admin/explore.php' ,
	'icon'	=> $pathIcon32.'/list.png'
) ;

} else {

$adminmenu[1] = array(
	'title'	=> _MI_GWREPORTS_ADMENU ,
	'link'	=> 'admin/index.php' ,
	'icon'	=> 'images/admin/home.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_ABOUT ,
	'link'	=> 'admin/about.php' ,
	'icon'	=> 'images/admin/about.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_TOPIC ,
	'link'	=> 'admin/topics.php' ,
	'icon'	=> 'images/admin/topic.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_REPORT ,
	'link'	=> 'admin/reports.php' ,
	'icon'	=> 'images/admin/report.png'
) ;

$adminmenu[] = array(
	'title'	=> _MI_GWREPORTS_AD_EXPLORE ,
	'link'	=> 'admin/explore.php' ,
	'icon'	=> 'images/admin/explore.png'
) ;

}
?>
