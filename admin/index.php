<?php
/**
* index.php - admin page for about and configuration messages
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

include ('../../../include/cp_header.php');
xoops_cp_header();
include_once "functions.php";
include_once "../include/dbcommon.php";
adminmenu(1);

// build todo list
$todo = array();
$todocnt = 0;

$op='';


if(defined("_MI_GWREPORTS_AD_LIMITED")) {
	$pathname=XOOPS_TRUST_PATH.'/modules/gwreports/import/';
	if(!is_dir($pathname))  {
		++$todocnt;
		$todo[$todocnt]['link']='index.php';
		$todo[$todocnt]['linktext']= _AD_GWREPORTS_AD_TODO_RETRY;
		$todo[$todocnt]['msg']= sprintf(_AD_GWREPORTS_NO_IMPORT_DIR,$pathname);
	}
}

// check mysql version
	$mysqlversion_required='4.1.0';

	$sql="select version()";
	$result = $xoopsDB->queryF($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchRow($result)) {
			$mysqlversion=$myrow[0];
		}
		if(version_compare($mysqlversion,$mysqlversion_required) < 0) {
			++$todocnt;
			$todo[$todocnt]['link']='index.php';
			$todo[$todocnt]['linktext']=_AD_GWREPORTS_AD_TODO_RETRY;
			$todo[$todocnt]['msg']= sprintf(_AD_GWREPORTS_AD_TODO_MYSQL, $mysqlversion_required, $mysqlversion);
		}
	}

// check for InnoDB support in mysql. We should have bombed out in install, but ...

	$have_innodb=false;

	$sql="show ENGINES";
	$result = $xoopsDB->queryF($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			if($myrow['Engine']=='InnoDB' && ($myrow['Support']=='YES' || $myrow['Support']=='DEFAULT')) $have_innodb=true;
		}
	}
	if(!$have_innodb) {
		++$todocnt;
		$todo[$todocnt]['link']='index.php';
		$todo[$todocnt]['linktext']=_AD_GWREPORTS_AD_TODO_RETRY;
		$todo[$todocnt]['msg']= _AD_GWREPORTS_AD_TODO_INNODB;
	}


// we don't have any todo checks for gwreports yet
if(false) {
	++$todocnt;
	$todo[$todocnt]['link']='script.php';
	$todo[$todocnt]['linktext']= 'Try to fix';
	$todo[$todocnt]['msg']= 'Something is wrong';
}

// display todo list
if($todocnt>0) {
	$teven='class="even"';
	$todd='class="odd"';
	$tclass=$teven;
	echo '<table width="100%" border="1" cellspacing="1" class="outer">';
	echo  '<tr><th colspan="2">'._AD_GWREPORTS_TODO_TITLE.'</th></tr>';
	echo '<tr><th width="25%">'._AD_GWREPORTS_TODO_ACTION.'</th><th>'._AD_GWREPORTS_TODO_MESSAGE.'</th></tr>';

	for ($i=1; $i<=$todocnt; ++$i) {
		if($tclass==$todd) $tclass=$teven;
		else $tclass=$todd;
		echo '<tr cellspacing="2" cellpadding="2" '.$tclass.'>';
		echo '<td><a href="'.$todo[$i]['link'].'">'.$todo[$i]['linktext'].'</a></td>';
		echo '<td>'.$todo[$i]['msg'].'</a></td>';
		echo '</tr>';
	}
	echo '</table>';
}

// about section
echo'<table width="100%" border="0" cellspacing="1" class="outer">';
echo '<tr><th>'._AD_GWREPORTS_ADMENU_ABOUT.'</th></tr><tr><td width="100%" >';
echo '<center><br /><b>'. _MI_GWREPORTS_DESC . '</b></center><br />';
echo '<center>Brought to you by <a href="http://www.geekwright.com/" target="_blank">geekwright, LLC</a></center><br />';
echo '</td></tr>';
if(defined("_MI_GWREPORTS_AD_LIMITED")) echo '<tr><td class="odd"><center>'._AD_GWREPORTS_LIMITED_MODE.'</center</td></tr>';
echo '</table>';


xoops_cp_footer();
?>