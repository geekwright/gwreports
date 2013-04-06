<?php
/**
* editreport.php - edit a report
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

if(!($xoopsUser && ($xoopsUser->isAdmin()))) {
	redirect_header('index.php', 3, _NOPERM);
} 

$topics=getTopicList();

$op='display';
if(isset($_POST['update'])) {
	$op='update';
}
if(isset($_POST['delete'])) {
	$op='delete';
}

$report_id=0;
$report_name='';
$report_description='';
$report_active=0;
$access_groups=array();
$report_topic=0;
$old_report_topic=0;
$this_report_needs_jquery=false;


	if(isset($_GET['rid'])) $report_id = intval($_GET['rid']);
	if(isset($_POST['rid'])) $report_id = intval($_POST['rid']);

// get data from table

	$sql='SELECT * FROM '.$xoopsDB->prefix('gwreports_report');
	$sql.=" WHERE report_id = $report_id ";

	$cnt=0;
	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$report_name=$myrow['report_name'];
			$report_description=$myrow['report_description'];
			$report_active=$myrow['report_active'];
			++$cnt;
		}
		if($cnt) {
			$xoopsTpl->assign('report_id', $report_id);
			$access_groups=getReportAccess($report_id);
			$report_topic=getReportTopic($report_id);
			$old_report_topic=$report_topic;
			$sections=getReportSections($report_id);
			$xoopsTpl->assign('report_sections', $sections);
			$parameters=getReportParameters($report_id);
			foreach($parameters as $p) if($p['parameter_type']=='autocomplete') $this_report_needs_jquery=true;
			$xoopsTpl->assign('report_parameters', $parameters);
			$report_parameter_form=getParameterForm($report_id,$parameters,$editor=true);
			$xoopsTpl->assign('report_parameter_form', $report_parameter_form);
		}
		else {
 			$err_message = _MD_GWREPORTS_REPORT_NOTFOUND;
			$report_id=0;
		}
	}
	else {
 		$err_message = _MD_GWREPORTS_REPORT_NOTFOUND;
		$report_id=0;
	}


	if(isset($_POST['report_name'])) $report_name = cleaner($_POST['report_name']);
	if(isset($_POST['report_description'])) $report_description = cleaner($_POST['report_description']);
	if(isset($_POST['report_active'])) $report_active = intval($_POST['report_active']);
	if($report_active) $report_active=1;
	if(isset($_POST['access_groups'])) $access_groups = $_POST['access_groups'];
	if(isset($_POST['report_topic'])) $report_topic = intval($_POST['report_topic']);

if ($op!='display') {
	$check=$GLOBALS['xoopsSecurity']->check();

	if (!$check) {
		$op='display';
		$err_message = _MD_GWREPORTS_MSG_BAD_TOKEN;
	}
}

if($op=='update') {
	$sl_report_name=dbescape($report_name);
	$sl_report_description=dbescape($report_description);

	$dberr=false;
	$dbmsg='';
	startTransaction();
	$sql ='UPDATE '.$xoopsDB->prefix('gwreports_report');
	$sql.=" SET report_name   =  '$sl_report_name' ";
	$sql.=" , report_description  =  '$sl_report_description' ";
	$sql.=" , report_active  =  $report_active ";
	$sql.=" WHERE report_id = $report_id ";

	$result = $xoopsDB->queryF($sql);
	if (!$result) {
		$dberr=true;
		$dbmsg=formatDBError();
	}

	if(!$dberr) {
		$sql ='DELETE FROM '.$xoopsDB->prefix('gwreports_access');
		$sql.=" WHERE report = $report_id ";
		$result = $xoopsDB->queryF($sql);
		if (!$result) {
			$dberr=true;
			$dbmsg=formatDBError();
		}
	}
	if(!$dberr) {
		foreach($access_groups as $groupid) {
			$sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_access');
			$sql.=' (report, groupid) ';
			$sql.=" VALUES ($report_id, $groupid)";

			$result = $xoopsDB->queryF($sql);
			if (!$result) {
				$dberr=true;
				$dbmsg=formatDBError();
				break;
			}
		}
	}

// only update topic if it has changed
if($old_report_topic!=$report_topic) {
	if(!$dberr) {
		$sql ='DELETE FROM '.$xoopsDB->prefix('gwreports_grouping');
		$sql.=" WHERE report = $report_id ";
		$result = $xoopsDB->queryF($sql);
		if (!$result) {
			$dberr=true;
			$dbmsg=formatDBError();
		}
	}
	if(!$dberr) {
		if($report_topic) {
			$sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_grouping');
			$sql.=' (topic, report) ';
			$sql.=" VALUES ($report_topic, $report_id)";

			$result = $xoopsDB->queryF($sql);
			if (!$result) {
				$dberr=true;
				$dbmsg=formatDBError();
			}
		}
	}
}

	if(!$dberr) {
		commitTransaction();
		$message = _MD_GWREPORTS_REPORT_UPD_OK;
//		redirect_header("editreport.php?rid=$new_report_id", 3, $message);
	}
	else {
		rollbackTransaction();
		$err_message = _MD_GWREPORTS_REPORT_UPD_ERR .' '.$dbmsg;
	}
}

if ($op=='delete') {
	$dberr=false;
	$dbmsg='';
	startTransaction();
	if(!$dberr) {
		$sql='DELETE  FROM '.$xoopsDB->prefix('gwreports_column');
		$sql.=' WHERE section in ';
		$sql='( SELECT section_id  FROM '.$xoopsDB->prefix('gwreports_section');
		$sql.=" WHERE report = $report_id )";
		$result = $xoopsDB->queryF($sql);
		if (!$result) {
			$dberr=true;
			$dbmsg=formatDBError();
		}
	}
	if(!$dberr) {
		$sql='DELETE  FROM '.$xoopsDB->prefix('gwreports_grouping');
		$sql.=" WHERE report = $report_id ";
		$result = $xoopsDB->queryF($sql);
		if (!$result) {
			$dberr=true;
			$dbmsg=formatDBError();
		}
	}
	if(!$dberr) {
		$sql='DELETE  FROM '.$xoopsDB->prefix('gwreports_section');
		$sql.=" WHERE report = $report_id ";
		$result = $xoopsDB->queryF($sql);
		if (!$result) {
			$dberr=true;
			$dbmsg=formatDBError();
		}
	}
	if(!$dberr) {
		$sql='DELETE  FROM '.$xoopsDB->prefix('gwreports_access');
		$sql.=" WHERE report = $report_id ";
		$result = $xoopsDB->queryF($sql);
		if (!$result) {
			$dberr=true;
			$dbmsg=formatDBError();
		}
	}
	if(!$dberr) {
		$sql='DELETE  FROM '.$xoopsDB->prefix('gwreports_parameter');
		$sql.=" WHERE report = $report_id ";
		$result = $xoopsDB->queryF($sql);
		if (!$result) {
			$dberr=true;
			$dbmsg=formatDBError();
		}
	}
	if(!$dberr) {
		$sql='DELETE  FROM '.$xoopsDB->prefix('gwreports_report');
		$sql.=" WHERE report_id = $report_id ";
		$result = $xoopsDB->queryF($sql);
		if (!$result) {
			$dberr=true;
			$dbmsg=formatDBError();
		}
	}

	if(!$dberr) {
		commitTransaction();
		$message = _MD_GWREPORTS_REPORT_DELETED;
		redirect_header("admin/reports.php", 3, $message);
	}
	else {
		rollbackTransaction();
		$err_message = _MD_GWREPORTS_REPORT_UPD_ERR .' '.$dbmsg;
	}
}

$body='';
	$token=true;
	$formtitle=_MD_GWREPORTS_EDITREPORT_FORM;
	$form = new XoopsThemeForm($formtitle, 'form1', 'editreport.php', 'POST', $token);

	$caption = _MD_GWREPORTS_REPORT_NAME;
	$form->addElement(new XoopsFormText($caption, 'report_name', 40, 250, htmlspecialchars($report_name, ENT_QUOTES)),true);

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

	$caption = _MD_GWREPORTS_REPORT_ACTIVE;
	$form->addElement(new XoopsFormRadioYN($caption, 'report_active', $report_active),false);

	$form->addElement(new XoopsFormHidden('rid', $report_id));

	$caption = _MD_GWREPORTS_EDITREPORT_UPD_BUTTON_DSC;
	$updtray=new XoopsFormElementTray($caption, '');

	$updtray->addElement(new XoopsFormButton('', 'update', _MD_GWREPORTS_EDITREPORT_UPD_BUTTON, 'submit'));

	$delbtn=new XoopsFormButton('', 'delete', _MD_GWREPORTS_EDITREPORT_DEL_BUTTON, 'submit');
	$delbtn->setExtra('onClick=\'this.form.target = "_self";return confirm("'._MD_GWREPORTS_EDITREPORT_DEL_CONFIRM.'")\'');
	$updtray->addElement($delbtn);
	$form->addElement($updtray);

	//$form->display();
	$body=$form->render();

//$dirname=$xoopsModule->getInfo('dirname');
$body.='<br /><a href="admin/index.php">'._MD_GWREPORTS_ADMIN_MENU.'</a>';
$body.=' | <a href="admin/reports.php">'._MD_GWREPORTS_ADMIN_REPORT.'</a>';
$body.=' | <a href="admin/topics.php">'._MD_GWREPORTS_ADMIN_TOPIC.'</a>';
$body.=' | <a href="newtopic.php">'._MD_GWREPORTS_ADMIN_TOPIC_ADD.'</a>';
if($report_topic) $body.=" | <a href=\"sortreports.php?tid=$report_topic\">"._MD_GWREPORTS_ADMIN_REPORT_SORT.'</a>';
//$debug='<pre>$_POST='.print_r($_POST,true).'</pre>';

setPageTitle(_MD_GWREPORTS_EDITREPORT_FORM);
$xoopsTpl->assign('needjquery', $this_report_needs_jquery);
if(isset($body)) $xoopsTpl->assign('body', $body);

if(isset($message)) $xoopsTpl->assign('message', $message);
if(isset($err_message)) $xoopsTpl->assign('err_message', $err_message);
if(isset($debug)) $xoopsTpl->assign('debug', $debug);

include(XOOPS_ROOT_PATH."/footer.php");
?>
