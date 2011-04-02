<?php
/**
* editcolumn.php - edit column information
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
$GLOBALS['xoopsOption']['template_main'] = 'gwreports_columnedit.html';
include(XOOPS_ROOT_PATH."/header.php");

include ('include/common.php');

if(!($xoopsUser && ($xoopsUser->isAdmin()))) {
	redirect_header('index.php', 3, _NOPERM);
} 

$op='display';
if(isset($_POST['update'])) {
	$op='update';
}
if(isset($_POST['delete'])) {
	$op='delete';
}

$column_id=0;
$column_name='';
$column_title='';
$column_hide=0;
$column_sum=0;
$column_break=0;
$column_outline=0;
$column_is_unixtime=0;
$column_format='';
$column_style='';
$column_extended_format='';

	if(isset($_GET['cid'])) $column_id = intval($_GET['cid']);
	if(isset($_POST['cid'])) $column_id = intval($_POST['cid']);

// get data from table

	$sql='SELECT * FROM '.$xoopsDB->prefix('gwreports_column');
	$sql.=" WHERE column_id = $column_id ";

	$cnt=0;
	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$section_id=$myrow['section'];
			$column_name=$myrow['column_name'];
			$column_title=$myrow['column_title'];
			$column_hide=$myrow['column_hide'];
			$column_sum=$myrow['column_sum'];
			$column_break=$myrow['column_break'];
			$column_outline=$myrow['column_outline'];
			$column_is_unixtime=$myrow['column_is_unixtime'];
			$column_format=$myrow['column_format'];
			$column_style=$myrow['column_style'];
			$column_extended_format=$myrow['column_extended_format'];
			++$cnt;
		}
		if($cnt) {
			if($section_id) $section=getSection($section_id);

			if(isset($section['section_name'])) $section_name = $section['section_name'];
			else redirect_header('index.php', 3, _MD_GWREPORTS_SECTION_NOTFOUND );

			$report_id=$section['report'];
			$xoopsTpl->assign('report_id', $report_id);
			$xoopsTpl->assign('section_id', $section_id);
			$report=getReport($report_id);
			$report_name=$report['report_name'];
		}
		else {
 			$err_message = _MD_GWREPORTS_COLUMN_NOTFOUND;
			redirect_header('index.php', 3, $err_message );
		}
	}
	else {
 		$err_message = _MD_GWREPORTS_COLUMN_NOTFOUND;
		redirect_header('index.php', 3, $err_message );
	}


//	if(isset($_POST['column_name'])) $column_name = cleaner($_POST['column_name']);
	if(isset($_POST['column_title'])) $column_title = cleaner($_POST['column_title']);
	if(isset($_POST['column_hide'])) $column_hide = cleaneryn($_POST['column_hide']);
	if(isset($_POST['column_sum'])) $column_sum = cleaneryn($_POST['column_sum']);
	if(isset($_POST['column_break'])) $column_break = cleaneryn($_POST['column_break']);
	if(isset($_POST['column_outline'])) $column_outline = cleaneryn($_POST['column_outline']);
	if(isset($_POST['column_is_unixtime'])) $column_is_unixtime = cleaneryn($_POST['column_is_unixtime']);
	if(isset($_POST['column_format'])) $column_format = cleaner($_POST['column_format']);
	if(isset($_POST['column_style'])) $column_style = cleaner($_POST['column_style']);
	if(isset($_POST['column_extended_format'])) $column_extended_format = cleaner($_POST['column_extended_format'],true);

if ($op!='display') {
	$check=$GLOBALS['xoopsSecurity']->check();

	if (!$check) {
		$op='display';
		$err_message = _MD_GWREPORTS_MSG_BAD_TOKEN;
	}
}

if($op=='update') {
	$myts = myTextSanitizer::getInstance();
//	$sl_column_name=$myts->addslashes($column_name);
	$sl_column_title=$myts->addslashes($column_title);
	$sl_column_format=$myts->addslashes($column_format);
	$sl_column_style=$myts->addslashes($column_style);
	$sl_column_extended_format=$myts->addslashes($column_extended_format);

	$dberr=false;
	$dbmsg='';

	$sql ='UPDATE '.$xoopsDB->prefix('gwreports_column');
	$sql.=" SET column_title = '$sl_column_title' ";
	$sql.=" , column_hide = $column_hide ";
	$sql.=" , column_sum = $column_sum ";
	$sql.=" , column_break = $column_break ";
	$sql.=" , column_outline = $column_outline ";
	$sql.=" , column_is_unixtime = $column_is_unixtime ";
	$sql.=" , column_format = '$sl_column_format' ";
	$sql.=" , column_style = '$sl_column_style' ";
	$sql.=" , column_extended_format = '$sl_column_extended_format' ";
	$sql.=" WHERE column_id = $column_id ";

	$result = $xoopsDB->queryF($sql);
	if (!$result) {
		$dberr=true;
		$dbmsg=formatDBError();
	}

	if(!$dberr) {
		$new_column_id = $xoopsDB->getInsertId();
		$message = _MD_GWREPORTS_COLUMN_UPD_OK;
	}
	else {
		if($xoopsDB->errno()==1062) $err_message =_MD_GWREPORTS_COLUMN_DUPLICATE;
		else $err_message = _MD_GWREPORTS_COLUMN_ADD_ERR .' '.$dbmsg;
	}
}

if ($op=='delete') {
		$sql='DELETE  FROM '. $xoopsDB->prefix('gwreports_column');
		$sql.=" WHERE column_id = $column_id ";
		$result = $xoopsDB->queryF($sql);

		$message = _MD_GWREPORTS_COLUMN_DELETED;
		redirect_header("editsection.php?sid=$section_id", 3, $message);
}

	$columns=getColumns($section_id);
	$xoopsTpl->assign('section_columns', $columns);
	$parameters=getReportParameters($report_id);
	$xoopsTpl->assign('report_parameters', $parameters);
	$report_parameter_form=getParameterForm($report_id,$parameters,$editor=true);
	$xoopsTpl->assign('report_parameter_form', $report_parameter_form);

$body='';
	$token=true;
	$formtitle=_MD_GWREPORTS_NEWCOLUMN_FORM;
	$form = new XoopsThemeForm($formtitle, 'form1', 'editcolumn.php', 'POST', $token);

	$caption = _MD_GWREPORTS_SECTION_REPORT_NAME;
	$form->addElement(new XoopsFormLabel($caption, '<a href="editreport.php?rid='.$report_id.'">'.$report_name.'</a>', 'report_name'),false);

	$caption = _MD_GWREPORTS_SECTION_NAME;
	$form->addElement(new XoopsFormLabel($caption, '<a href="editsection.php?sid='.$section_id.'">'.$section_name.'</a>', 'section_name'),false);

	$caption = _MD_GWREPORTS_COLUMN_NAME;
	$form->addElement(new XoopsFormLabel($caption, htmlspecialchars($column_name, ENT_QUOTES), 'lbl_column_name'),false);
	$form->addElement(new XoopsFormHidden('column_name', htmlspecialchars($column_name, ENT_QUOTES)));

	$caption = _MD_GWREPORTS_COLUMN_TITLE;
	$form->addElement(new XoopsFormText($caption, 'column_title', 40, 250, htmlspecialchars($column_title, ENT_QUOTES)),false);

	$caption = _MD_GWREPORTS_COLUMN_HIDE;
	$form->addElement(new XoopsFormRadioYN($caption, 'column_hide', $column_hide),false);

	$caption = _MD_GWREPORTS_COLUMN_SUM;
	$form->addElement(new XoopsFormRadioYN($caption, 'column_sum', $column_sum),false);

	$caption = _MD_GWREPORTS_COLUMN_BREAK;
	$form->addElement(new XoopsFormRadioYN($caption, 'column_break', $column_break),false);

	$caption = _MD_GWREPORTS_COLUMN_OUTLINE;
	$form->addElement(new XoopsFormRadioYN($caption, 'column_outline', $column_outline),false);

	$caption = _MD_GWREPORTS_COLUMN_IS_UNIXTIME;
	$form->addElement(new XoopsFormRadioYN($caption, 'column_is_unixtime', $column_is_unixtime),false);

	$caption = _MD_GWREPORTS_COLUMN_FORMAT;
	$form->addElement(new XoopsFormText($caption, 'column_format', 40, 250, htmlspecialchars($column_format, ENT_QUOTES)),false);

	$caption = _MD_GWREPORTS_COLUMN_STYLE;
	$form->addElement(new XoopsFormText($caption, 'column_style', 40, 250, htmlspecialchars($column_style, ENT_QUOTES)),false);

	$caption = _MD_GWREPORTS_COLUMN_EXTENDED_FMT;
	$form->addElement(new XoopsFormTextArea($caption, 'column_extended_format',  htmlspecialchars($column_extended_format, ENT_QUOTES), 'column_extended_format'), false);

	$caption = _MD_GWREPORTS_EDITCOLUMN_UPD_BUTTON_DSC;
	$updtray=new XoopsFormElementTray($caption, '');

	$updtray->addElement(new XoopsFormButton('', 'update', _MD_GWREPORTS_EDITCOLUMN_UPD_BUTTON, 'submit'));

	$delbtn=new XoopsFormButton('', 'delete', _MD_GWREPORTS_EDITCOLUMN_DEL_BUTTON, 'submit');
	$delbtn->setExtra('onClick=\'this.form.target = "_self";return confirm("'._MD_GWREPORTS_EDITCOLUMN_DEL_CONFIRM.'")\'');
	$updtray->addElement($delbtn);
	$form->addElement($updtray);


	$form->addElement(new XoopsFormHidden('cid', $column_id));

	//$form->display();
	$body=$form->render();

//$dirname=$xoopsModule->getInfo('dirname');
$body.='<br /><a href="admin/index.php">'._MD_GWREPORTS_ADMIN_MENU.'</a>';
$body.=' | <a href="admin/reports.php">'._MD_GWREPORTS_ADMIN_REPORT.'</a>';
$body.=' | <a href="admin/topics.php">'._MD_GWREPORTS_ADMIN_TOPIC.'</a>';

//$debug='<pre>$_POST='.print_r($_POST,true).'</pre>';
//$debug.='<pre>$_GET='.print_r($_GET,true).'</pre>';

setPageTitle(_MD_GWREPORTS_EDITCOLUMN_FORM);
if(isset($body)) $xoopsTpl->assign('body', $body);

if(isset($message)) $xoopsTpl->assign('message', $message);
if(isset($err_message)) $xoopsTpl->assign('err_message', $err_message);
if(isset($debug)) $xoopsTpl->assign('debug', $debug);

include(XOOPS_ROOT_PATH."/footer.php");
?>
