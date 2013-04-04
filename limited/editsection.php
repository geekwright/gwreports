<?php
/**
* editsection.php - edit a report section
*     limited mode version cannot add or modify section definition or sql
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
$GLOBALS['xoopsOption']['template_main'] = 'gwreports_sectionedit.html';
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

$section_id=0;
$section_name='';
$section_description='';
$section_showtitle=0;
$section_multirow=1;
$section_skipempty=0;
$section_datatools=0;
$section_query='';
$report_id=0;
$report_name='';

	if(isset($_GET['sid'])) $section_id = intval($_GET['sid']);
	if(isset($_POST['sid'])) $section_id = intval($_POST['sid']);

// get data from table

	$sql='SELECT * FROM '.$xoopsDB->prefix('gwreports_section');
	$sql.=" WHERE section_id = $section_id ";

	$cnt=0;
	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$section_name=$myrow['section_name'];
			$section_description=$myrow['section_description'];
			$section_showtitle=$myrow['section_showtitle'];
			$section_multirow=$myrow['section_multirow'];
			$section_skipempty=$myrow['section_skipempty'];
			$section_datatools=$myrow['section_datatools'];
			$section_query=$myrow['section_query'];
			$report_id=$myrow['report'];
			++$cnt;
		}
		if($cnt) {
			$xoopsTpl->assign('report_id', $report_id);
			$report_definition=getReport($report_id);
			if(isset($report_definition['report_name'])) $report_name = $report_definition['report_name'];
			else redirect_header('index.php', 3, _MD_GWREPORTS_REPORT_NOTFOUND );
		}
		else {
 			$err_message = _MD_GWREPORTS_SECTION_NOTFOUND;
			$report_id=0;
			$section_id=0;
		}
	}
	else {
 		$err_message = _MD_GWREPORTS_SECTION_NOTFOUND;
		$report_id=0;
		$section_id=0;
	}

	if($report_id==0) redirect_header('newreport.php', 3, $err_message);

	$op='display';

// load related data for presentation
	$xoopsTpl->assign('section_id', $section_id);
	$sections=getReportSections($report_id);
	$xoopsTpl->assign('report_sections', $sections);
	$parameters=getReportParameters($report_id);
	$xoopsTpl->assign('report_parameters', $parameters);
	$report_parameter_form=getParameterForm($report_id,$parameters,$editor=true);
	$xoopsTpl->assign('report_parameter_form', $report_parameter_form);

$body='';
	$token=true;
	$formtitle=_MD_GWREPORTS_EDITSECTION_LIMITED_FORM;
	$form = new XoopsThemeForm($formtitle, 'form1', 'editsection.php', 'POST', $token);

	$caption = _MD_GWREPORTS_SECTION_REPORT_NAME;
	$form->addElement(new XoopsFormLabel($caption, '<a href="editreport.php?rid='.$report_id.'">'.$report_name.'</a>', 'report_name'),false);

	$caption = _MD_GWREPORTS_SECTION_NAME;
	$form->addElement(new XoopsFormLabel($caption, htmlspecialchars($section_name, ENT_QUOTES), 'section_name'),false);

	$caption = _MD_GWREPORTS_SECTION_QUERY;
	$form->addElement(new XoopsFormLabel($caption, nl2br(htmlspecialchars($section_query, ENT_QUOTES)), 'section_query'),false);

	$caption = _MD_GWREPORTS_SECTION_SHOWTITLE;
	$showyesno=($section_showtitle ? _YES : _NO);
	$form->addElement(new XoopsFormLabel($caption, htmlspecialchars($showyesno, ENT_QUOTES), 'section_showtitle'),false);

	$caption = _MD_GWREPORTS_SECTION_MULTIROW;
	$showyesno=($section_multirow ? _YES : _NO);
	$form->addElement(new XoopsFormLabel($caption, htmlspecialchars($showyesno, ENT_QUOTES), 'section_multirow'),false);

	$caption = _MD_GWREPORTS_SECTION_SKIPEMPTY;
	$showyesno=($section_skipempty ? _YES : _NO);
	$form->addElement(new XoopsFormLabel($caption, htmlspecialchars($showyesno, ENT_QUOTES), 'section_skipempty'),false);

	$caption = _MD_GWREPORTS_SECTION_DATATOOLS;
	$showyesno=($section_datatools ? _YES : _NO);
	$form->addElement(new XoopsFormLabel($caption, htmlspecialchars($showyesno, ENT_QUOTES), 'section_datatools'),false);

	$caption = _MD_GWREPORTS_SECTION_DESC;
	$form->addElement(new XoopsFormLabel($caption, nl2br(htmlspecialchars($section_description, ENT_QUOTES)), 'section_description'),false);

	$form->addElement(new XoopsFormHidden('sid', $section_id));

	//$form->display();
	$body=$form->render();


//$dirname=$xoopsModule->getInfo('dirname');
$body.='<br /><a href="admin/index.php">'._MD_GWREPORTS_ADMIN_MENU.'</a>';
$body.=' | <a href="admin/reports.php">'._MD_GWREPORTS_ADMIN_REPORT.'</a>';
$body.=' | <a href="admin/topics.php">'._MD_GWREPORTS_ADMIN_TOPIC.'</a>';
$body.=" | <a href=\"editreport.php?rid=$report_id\">"._MD_GWREPORTS_EDITREPORT_FORM.'</a>';

//$debug='<pre>$_POST='.print_r($_POST,true).'</pre>';

$columns=getColumns($section_id);
$xoopsTpl->assign('section_columns', $columns);

setPageTitle(_MD_GWREPORTS_EDITSECTION_LIMITED_FORM);
if(isset($body)) $xoopsTpl->assign('body', $body);

if(isset($message)) $xoopsTpl->assign('message', $message);
if(isset($err_message)) $xoopsTpl->assign('err_message', $err_message);
if(isset($debug)) $xoopsTpl->assign('debug', $debug);

include(XOOPS_ROOT_PATH."/footer.php");
?>
