<?php
/**
* newparameter.php - add new report parameter
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

$parmtypes=getParmTypes();

$op='display';
if(isset($_POST['submit'])) {
	$op='add';
}

$report_id=0;
$report_name='';

	if(isset($_GET['rid'])) $report_id = intval($_GET['rid']);
	if(isset($_POST['rid'])) $report_id = intval($_POST['rid']);
	$report_definition=getReport($report_id);
	if(isset($report_definition['report_name'])) $report_name = $report_definition['report_name'];
	else redirect_header('index.php', 3, _MD_GWREPORTS_REPORT_NOTFOUND );
	$parameters=getReportParameters($report_id);
	$xoopsTpl->assign('report_parameters', $parameters);
	$sections=getReportSections($report_id);
	$xoopsTpl->assign('report_sections', $sections);
	$report_parameter_form=getParameterForm($report_id,$parameters,$editor=true);
	$xoopsTpl->assign('report_parameter_form', $report_parameter_form);

$parameter_name='';
$parameter_description='';
$parameter_title='';
$parameter_default='';
$parameter_required=1;
$parameter_length=0;
$parameter_type='text';

	if(isset($_POST['parameter_name'])) $parameter_name = str_replace(' ', '_',cleaner($_POST['parameter_name']));
	if(isset($_POST['parameter_description'])) $parameter_description = cleaner($_POST['parameter_description']);
	if(isset($_POST['parameter_title'])) $parameter_title = cleaner($_POST['parameter_title']);
	if($parameter_title=='') $parameter_title=$parameter_name;
	if(isset($_POST['parameter_default'])) $parameter_default = cleaner($_POST['parameter_default']);
	if(isset($_POST['parameter_type'])) $parameter_type = cleaner($_POST['parameter_type']);
	$parameter_type=checkParmType($parmtypes, $parameter_type);

	if(isset($_POST['parameter_required'])) $parameter_required = cleaneryn($_POST['parameter_required']);
	if(isset($_POST['parameter_length'])) $parameter_length = intval($_POST['parameter_length']);
	if($parameter_length==0) $parameter_length=20;

if ($op!='display') {
	$check=$GLOBALS['xoopsSecurity']->check();

	if (!$check) {
		$op='display';
		$err_message = _MD_GWREPORTS_MSG_BAD_TOKEN;
	}
}

if($op=='add') {
	$myts = myTextSanitizer::getInstance();
	$sl_parameter_name=$myts->addslashes($parameter_name);
	$sl_parameter_description=$myts->addslashes($parameter_description);
	$sl_parameter_title=$myts->addslashes($parameter_title);
	$sl_parameter_default=$myts->addslashes($parameter_default);

	$dberr=false;
	$dbmsg='';

	$sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_parameter');
	$sql.=' (report, parameter_name, parameter_description, parameter_title, parameter_default, parameter_required, parameter_length, parameter_type) ';
	$sql.=" VALUES ( $report_id, '$sl_parameter_name', '$sl_parameter_description', '$sl_parameter_title', '$sl_parameter_default', $parameter_required, $parameter_length, '$parameter_type') ";

	$result = $xoopsDB->queryF($sql);
	if (!$result) {
		$dberr=true;
		$dbmsg=formatDBError();
	}

	if(!$dberr) {
		$new_parameter_id = $xoopsDB->getInsertId();
		$message = _MD_GWREPORTS_PARAMETER_ADD_OK;
		redirect_header("editparameter.php?pid=$new_parameter_id", 3, $message);
	}
	else {
		if($xoopsDB->errno()==1062) $err_message =_MD_GWREPORTS_PARAMETER_DUPLICATE;
		else $err_message = _MD_GWREPORTS_PARAMETER_ADD_ERR .' '.$dbmsg;
	}
}

$body='';
	$token=true;
	$formtitle=_MD_GWREPORTS_NEWPARAMETER_FORM;
	$form = new XoopsThemeForm($formtitle, 'form1', 'newparameter.php', 'POST', $token);

	$caption = _MD_GWREPORTS_SECTION_REPORT_NAME;
	$form->addElement(new XoopsFormLabel($caption, '<a href="editreport.php?rid='.$report_id.'">'.$report_name.'</a>', 'report_name'),false);

	$caption = _MD_GWREPORTS_PARAMETER_NAME;
	$form->addElement(new XoopsFormText($caption, 'parameter_name', 40, 250, htmlspecialchars($parameter_name, ENT_QUOTES)),true);

	$caption = _MD_GWREPORTS_PARAMETER_TITLE;
	$form->addElement(new XoopsFormText($caption, 'parameter_title', 40, 250, htmlspecialchars($parameter_title, ENT_QUOTES)),false);

	$caption = _MD_GWREPORTS_PARAMETER_DESC;
	$form->addElement(new XoopsFormTextArea($caption, 'parameter_description', $parameter_description, 4, 50, 'parameter_description'),false);

	$caption = _MD_GWREPORTS_PARAMETER_LENGTH;
	$form->addElement(new XoopsFormText($caption, 'parameter_length', 8 , 8, intval($parameter_length)),true);

	$caption = _MD_GWREPORTS_PARAMETER_REQUIRED;
	$form->addElement(new XoopsFormRadioYN($caption, 'parameter_required', $parameter_required),true);

	// XoopsFormSelect( string $caption, string $name, [mixed $value = null], [int $size = 1], [bool $multiple = false])
	$caption = _MD_GWREPORTS_PARAMETER_TYPE;
	$parmtype_size = count($parmtypes);
	if($parmtype_size>6) $parmtype_size=6;
	$listbox = new XoopsFormSelect($caption, 'parameter_type', $parameter_type, $parmtype_size, false);
	foreach ($parmtypes as $i => $v) {
		$listbox->addOption($v['parm_value'], $v['parm_display']);
	}
	$form->addElement($listbox);

	$caption = _MD_GWREPORTS_PARAMETER_DEFAULT;
	$form->addElement(new XoopsFormText($caption, 'parameter_default', 25 , 100, $parameter_default),false);

	$form->addElement(new XoopsFormButton(_MD_GWREPORTS_NEWPARAMETER_ADD_BUTTON_DSC, 'submit', _MD_GWREPORTS_NEWPARAMETER_ADD_BUTTON, 'submit'));

	$form->addElement(new XoopsFormHidden('rid', $report_id));

	//$form->display();
	$body=$form->render();

//$dirname=$xoopsModule->getInfo('dirname');
$body.='<br /><a href="admin/index.php">'._MD_GWREPORTS_ADMIN_MENU.'</a>';
$body.=' | <a href="admin/reports.php">'._MD_GWREPORTS_ADMIN_REPORT.'</a>';
$body.=' | <a href="admin/topics.php">'._MD_GWREPORTS_ADMIN_TOPIC.'</a>';
$body.=" | <a href=\"editreport.php?rid=$report_id\">"._MD_GWREPORTS_EDITREPORT_FORM.'</a>';

//$debug='<pre>$_POST='.print_r($_POST,true).'</pre>';

setPageTitle(_MD_GWREPORTS_NEWPARAMETER_FORM);
if(isset($body)) $xoopsTpl->assign('body', $body);

if(isset($message)) $xoopsTpl->assign('message', $message);
if(isset($err_message)) $xoopsTpl->assign('err_message', $err_message);
if(isset($debug)) $xoopsTpl->assign('debug', $debug);

include(XOOPS_ROOT_PATH."/footer.php");
?>
