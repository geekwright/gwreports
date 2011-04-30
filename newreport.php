<?php
/**
* newreport.php - add a new report
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

include '../../mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'gwreports_reportedit.html';
include(XOOPS_ROOT_PATH."/header.php");

include ('include/common.php');

$myuserid=0;
if($xoopsUser) {
	$myuserid = $xoopsUser->getVar('uid');
}
if(!($xoopsUser && ($xoopsUser->isAdmin()))) {
	redirect_header('index.php', 3, _NOPERM);
} 

$topics=getTopicList();

$op='display';
if(isset($_POST['submit'])) {
	$op='add';
}

$report_name='';
$report_description='';
$report_active=0;
$access_groups=array();
$report_topic=0;

	if(isset($_POST['report_name'])) $report_name = cleaner($_POST['report_name']);
	if(isset($_POST['report_description'])) $report_description = cleaner($_POST['report_description']);
	if(isset($_POST['report_active'])) $report_active = intval($_POST['report_active']);
	if($report_active) $report_active=1;
	if(isset($_POST['access_groups'])) $access_groups = $_POST['access_groups'];
	if(isset($_POST['report_topic'])) $report_topic = intval($_POST['report_topic']);

$section_name=$report_name;
$section_description='';
$section_showtitle=0;
$section_multirow=1;
$section_skipempty=0;
$section_query='';

	if(isset($_POST['section_name'])) $section_name = cleaner($_POST['section_name']);
	if(isset($_POST['section_description'])) $section_description = cleaner($_POST['section_description']);
	if(isset($_POST['section_query'])) $section_query = cleaner($_POST['section_query'],true);
	if(isset($_POST['section_multirow'])) $section_multirow = cleaneryn($_POST['section_multirow']);
	if(isset($_POST['section_showtitle'])) $section_showtitle = cleaneryn($_POST['section_showtitle']);
	if(isset($_POST['section_skipempty'])) $section_skipempty = cleaneryn($_POST['section_skipempty']);


if ($op!='display') {
	$check=$GLOBALS['xoopsSecurity']->check();

	if (!$check) {
		$op='display';
		$err_message = _MD_GWREPORTS_MSG_BAD_TOKEN;
	}
}

if($op=='add') {
	$sl_report_name=dbescape($report_name);
	$sl_report_description=dbescape($report_description);

	$sl_section_name=dbescape($section_name);
	$sl_section_description=dbescape($section_description);
	$sl_section_query=dbescape($section_query);

	$dberr=false;
	$dbmsg='';
	startTransaction();
	$sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_report');
	$sql.=' (report_name, report_description) ';
	$sql.=" VALUES ('$sl_report_name', '$sl_report_description' )";
	$result = $xoopsDB->queryF($sql);
	if (!$result) {
		$dberr=true;
		$dbmsg=formatDBError();
	}

	if(!$dberr) {
		$new_report_id = $xoopsDB->getInsertId();
		foreach($access_groups as $groupid) {
			$sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_access');
			$sql.=' (report, groupid) ';
			$sql.=" VALUES ($new_report_id, $groupid)";

			$result = $xoopsDB->queryF($sql);
			if (!$result) {
				$dberr=true;
				$dbmsg=formatDBError();
				break;
			}
		}
	}
	if(!$dberr) {
		if($report_topic) {
			$sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_grouping');
			$sql.=' (topic, report) ';
			$sql.=" VALUES ($report_topic, $new_report_id)";

			$result = $xoopsDB->queryF($sql);
			if (!$result) {
				$dberr=true;
				$dbmsg=formatDBError();
			}
		}
	}

	if(!$dberr) {
		if($new_report_id) {
			$sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_section');
			$sql.=' (report, section_name, section_description, section_showtitle, section_multirow, section_skipempty, section_query) ';
			$sql.=" VALUES ( $new_report_id, '$sl_section_name', '$sl_section_description', $section_showtitle, $section_multirow, $section_skipempty, '$sl_section_query') ";

			$result = $xoopsDB->queryF($sql);
			if (!$result) {
				$dberr=true;
				$dbmsg=formatDBError();
			}
		}
	}

	if(!$dberr) {
		commitTransaction();
		$message = _MD_GWREPORTS_REPORT_ADD_OK;
		redirect_header("editreport.php?rid=$new_report_id", 3, $message);
	}
	else {
		rollbackTransaction();
		$err_message = _MD_GWREPORTS_REPORT_ADD_ERR .' '.$dbmsg;
	}
}

$body='';
	$token=true;
	$formtitle=_MD_GWREPORTS_NEWREPORT_FORM;
	$form = new XoopsThemeForm($formtitle, 'form1', 'newreport.php', 'POST', $token);

	$caption = _MD_GWREPORTS_REPORT_NAME;
	$form->addElement(new XoopsFormText($caption, 'report_name', 40, 250, htmlspecialchars($report_name, ENT_QUOTES)),true);

	$caption = _MD_GWREPORTS_SECTION_QUERY;
	$form->addElement(new XoopsFormTextArea($caption, 'section_query', $section_query, 10, 50, 'section_query'),true);

//	$caption = _MD_GWREPORTS_REPORT_ACTIVE;
//	$form->addElement(new XoopsFormRadioYN($caption, 'report_active', $report_active),false);

	$caption = _MD_GWREPORTS_REPORT_SYSGROUP;
	$form->addElement(new XoopsFormSelectGroup($caption, 'access_groups', $include_anon = true, $access_groups, $size = 4, $multiple = true  ),false);

	// XoopsFormSelect( string $caption, string $name, [mixed $value = null], [int $size = 1], [bool $multiple = false])
	$caption = _MD_GWREPORTS_REPORT_TOPIC;
	$topic_size = count($topics)+1;
	if($topic_size>6) $topic_size=6;
	$listbox = new XoopsFormSelect($caption, 'report_topic', $report_topic, $topic_size, false);
	$listbox->addOption(0, _MD_GWREPORTS_NO_TOPIC);
	foreach ($topics as $i => $v) {
		$listbox->addOption($v['topic_id'], $v['topic_name']);
	}
	$form->addElement($listbox);

	$caption = _MD_GWREPORTS_REPORT_DESC;
	$form->addElement(new XoopsFormTextArea($caption, 'report_description', $report_description, 4, 50, 'report_description'),false);

// section
//	$caption = _MD_GWREPORTS_SECTION_NAME;
//	$form->addElement(new XoopsFormText($caption, 'section_name', 40, 250, htmlspecialchars($section_name, ENT_QUOTES)),true);

//	$caption = _MD_GWREPORTS_SECTION_SHOWTITLE;
//	$form->addElement(new XoopsFormRadioYN($caption, 'section_showtitle', $section_showtitle),true);

//	$caption = _MD_GWREPORTS_SECTION_MULTIROW;
//	$form->addElement(new XoopsFormRadioYN($caption, 'section_multirow', $section_multirow),true);

//	$caption = _MD_GWREPORTS_SECTION_SKIPEMPTY;
//	$form->addElement(new XoopsFormRadioYN($caption, 'section_skipempty', $section_skipempty),true);

//	$caption = _MD_GWREPORTS_SECTION_DESC;
//	$form->addElement(new XoopsFormTextArea($caption, 'section_description', $section_description, 4, 50, 'section_description'),false);


	$form->addElement(new XoopsFormButton(_MD_GWREPORTS_NEWREPORT_ADD_BUTTON_DSC, 'submit', _MD_GWREPORTS_NEWREPORT_ADD_BUTTON, 'submit'));

	//$form->display();
	$body=$form->render();

//$dirname=$xoopsModule->getInfo('dirname');
$body.='<br /><a href="admin/index.php">'._MD_GWREPORTS_ADMIN_MENU.'</a>';
$body.=' | <a href="admin/reports.php">'._MD_GWREPORTS_ADMIN_REPORT.'</a>';
$body.=' | <a href="admin/topics.php">'._MD_GWREPORTS_ADMIN_TOPIC.'</a>';
$body.=' | <a href="newtopic.php">'._MD_GWREPORTS_ADMIN_TOPIC_ADD.'</a>';

//$debug='<pre>$_POST='.print_r($_POST,true).'</pre>';

setPageTitle(_MD_GWREPORTS_NEWREPORT_FORM);
if(isset($body)) $xoopsTpl->assign('body', $body);

if(isset($message)) $xoopsTpl->assign('message', $message);
if(isset($err_message)) $xoopsTpl->assign('err_message', $err_message);
if(isset($debug)) $xoopsTpl->assign('debug', $debug);

include(XOOPS_ROOT_PATH."/footer.php");
?>
