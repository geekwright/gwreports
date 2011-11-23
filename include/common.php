<?php
/**
* common.php - common function definitions
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
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once ('include/dbcommon.php');

$mymoduledir='modules/'.$xoopsModule->getInfo('dirname').'/';
if(isset($xoTheme) && is_object($xoTheme)) $xoTheme->addStylesheet($mymoduledir.'module.css');

function setPageTitle($title,$headingonly=false) {
global $xoopsModule,$xoopsTpl;

	$display_name = $xoopsModule -> getVar('name');
	if($display_name!=$title) $display_name .= _MD_GWREPORTS_TITLE_SEP . $title;
	if(!$headingonly) {
		@$xoopsTpl->assign('xoops_pagetitle', $display_name); // html title
		@$xoopsTpl->assign('icms_pagetitle',  $display_name);
	}
	$xoopsTpl->assign('title',$title);	// content heading
}

function getUserGroups() {
global $xoopsUser;

	$userinfo=array(XOOPS_GROUP_ANONYMOUS);

	if($xoopsUser) {
		$userinfo=$xoopsUser->getGroups();
	}

	return $userinfo;
}

function getSystemGroups() {
// get array of system groups
// should be an API to do this?
	global $xoopsDB;
	$sysgroups=array();

	$sql='SELECT groupid, name FROM '. $xoopsDB->prefix('groups');
	$sql.= ' ORDER BY name ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$sysgroups[$myrow['groupid']] = $myrow['name'];
		}
	}

	return $sysgroups;
}

function getTopicList() {

	global $xoopsDB;
	$topics=array();

	$sql='SELECT topic_id, topic_name, topic_description, topic_order FROM '. $xoopsDB->prefix('gwreports_topic');
	$sql.= ' ORDER BY topic_order, topic_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$topics[$myrow['topic_id']] = $myrow;
		}
	}
	return $topics;
}

function buildIdInClause($idarray) {
	$wherein='';
	foreach($idarray as $i) {
		if($wherein=='') $wherein .='('.$i;
		else $wherein .=','.$i;
	}
	if($wherein=='')  return '';
	$wherein .=')';
	return $wherein;
}

function getTopicListByGroup($userGroups) {

	global $xoopsDB;
	$topics=array();
	$wheregroup=buildIdInClause($userGroups);
	if($wheregroup=='')  return $topics;

	$sql='SELECT DISTINCT topic_id, topic_name, topic_description, topic_order FROM ';
	$sql.= $xoopsDB->prefix('gwreports_topic') . ' t, ';
	$sql.= $xoopsDB->prefix('gwreports_grouping') . ' g, '; // topic, report, grouping_order
	$sql.= $xoopsDB->prefix('gwreports_access') . ' a '; // report, groupid

	$sql.= ' WHERE a.groupid in '.$wheregroup;
	$sql.= ' AND g.report=a.report ';
	$sql.= ' AND t.topic_id=g.topic ';
	$sql.= ' ORDER BY topic_order, topic_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$topics[$myrow['topic_id']] = $myrow;
		}
	}
	return $topics;
}

function getReportListByGroup($topic_id, $userGroups) {

	global $xoopsDB;
	$reports=array();
	$wheregroup=buildIdInClause($userGroups);
	if($wheregroup=='')  return $reports;

	$sql='SELECT DISTINCT report_id, report_name, report_description, grouping_order FROM ';
	$sql.= $xoopsDB->prefix('gwreports_report') . ' r, ';
	$sql.= $xoopsDB->prefix('gwreports_grouping') . ' g, '; // topic, report, grouping_order
	$sql.= $xoopsDB->prefix('gwreports_access') . ' a '; // report, groupid

	$sql.= ' WHERE a.groupid in '.$wheregroup;
	$sql.= ' AND g.report=a.report ';
	$sql.= " AND g.topic = $topic_id ";
	$sql.= " AND r.report_id = g.report ";
	$sql.= " AND r.report_active = 1 ";
	$sql.= ' ORDER BY grouping_order, report_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$reports[$myrow['report_id']] = $myrow;
		}
	}
	return $reports;
}

function checkUserReportAccess($report_id) {

	global $xoopsDB;
	$access_ok=false;
	$userGroups=getUserGroups();
	$wheregroup=buildIdInClause($userGroups);
	if($wheregroup=='')  return false;

	$sql='SELECT count(*) as cnt FROM ' . $xoopsDB->prefix('gwreports_access'); 
	$sql.= ' WHERE groupid in '.$wheregroup;
	$sql.= " AND report = $report_id ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		if($myrow=$xoopsDB->fetchArray($result)) {
			$cnt=$myrow['cnt'] = $myrow;
			if($cnt>0) $access_ok=true;
		}
	}
	return $access_ok;
}

function getReportAccess($report_id) {
// get array of system groups with access to a report
	global $xoopsDB;
	$access_groups=array();

	$sql='SELECT groupid FROM '. $xoopsDB->prefix('gwreports_access');
	$sql.= " WHERE report = $report_id ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$access_groups[] = $myrow['groupid'];
		}
	}

	return $access_groups;
}

function getReport($report_id) {
// get report definition
	global $xoopsDB;
	$report=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_report');
	$sql.= " WHERE report_id = $report_id ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		if($myrow=$xoopsDB->fetchArray($result)) {
			$report = $myrow;
		}
	}

	return $report;
}

function getParmTypes() {
// list parameter types
// enum('text','liketext','datetime','integer','yesno')
$parmtypes=array();
$parmtypes[]=array('parm_value'=>'text', 'parm_display'=> _MD_GWREPORTS_PARMTYPE_TEXT );
$parmtypes[]=array('parm_value'=>'liketext', 'parm_display'=> _MD_GWREPORTS_PARMTYPE_LIKETEXT );
$parmtypes[]=array('parm_value'=>'date', 'parm_display'=> _MD_GWREPORTS_PARMTYPE_DATE );
//$parmtypes[]=array('parm_value'=>'datetime', 'parm_display'=> _MD_GWREPORTS_PARMTYPE_DATETIME );
$parmtypes[]=array('parm_value'=>'integer', 'parm_display'=> _MD_GWREPORTS_PARMTYPE_INTEGER );
$parmtypes[]=array('parm_value'=>'decimal', 'parm_display'=> _MD_GWREPORTS_PARMTYPE_DECIMAL );
$parmtypes[]=array('parm_value'=>'yesno', 'parm_display'=> _MD_GWREPORTS_PARMTYPE_YESNO );
$parmtypes[]=array('parm_value'=>'autocomplete', 'parm_display'=> _MD_GWREPORTS_PARMTYPE_AUTOCOMPLETE );

	return $parmtypes;
}

function checkParmType($parmtypes, $parameter_type)
{
// return a valid parameter_type
	$check_parameter_type='text';
	foreach ($parmtypes as $i => $v) {
		if($v['parm_value']==$parameter_type) {
			$check_parameter_type=$parameter_type;
			break;
		}
	}
	return $check_parameter_type;
}

function checkReservedParmameterName($parameter_name)
{
// return true if parameter_name is considered reserved
$ret=false;

	if($parameter_name=='rid') $ret=true; // interferes with report viewer
	if (substr($parameter_name,0,1)=='$') $ret=true; // all '$' names reserved for now
	return $ret;
}

function getReportTopic($report_id) {
// get topic associated with a report
	global $xoopsDB;
	$report_topic=0;

	$sql='SELECT topic FROM '. $xoopsDB->prefix('gwreports_grouping');
	$sql.= " WHERE report = $report_id ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$report_topic = $myrow['topic'];
		}
	}

	return $report_topic;
}

function getTopic($topic_id) {
// get topic definition
	global $xoopsDB;
	$topic=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_topic');
	$sql.= " WHERE topic_id = $topic_id ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$topic = $myrow;
		}
	}

	return $topic;
}

function getReportsByTopic($topic_id) {
// get topic associated with a report
	global $xoopsDB;
	$reports=array();

	$sql='SELECT * FROM '.$xoopsDB->prefix('gwreports_report').', '.$xoopsDB->prefix('gwreports_grouping');
	$sql.= " WHERE topic = $topic_id  AND report = report_id ";
	$sql.= ' ORDER BY grouping_order, report_id ';
	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$reports[$myrow['report_id']] = $myrow;
		}
	}

	return $reports;
}

function getReportSections($report_id) {

	global $xoopsDB;
	$sections=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_section');
	$sql.= " WHERE report = $report_id ";
	$sql.= ' ORDER BY section_order, section_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$sections[$myrow['section_id']] = $myrow;
		}
	}
	return $sections;
}

function getSection($section_id) {

	global $xoopsDB;
	$section=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_section');
	$sql.= " WHERE section_id = $section_id ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$section = $myrow;
		}
	}
	return $section;
}

function getColumns($section_id) {

	global $xoopsDB;
	$columns=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_column');
	$sql.= " WHERE section = $section_id ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$columns[$myrow['column_name']] = $myrow;
		}
	}
	return $columns;
}

function getReportParameters($report_id) {

	global $xoopsDB;
	$parameters=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_parameter');
	$sql.= " WHERE report = $report_id ";
	$sql.= ' ORDER BY parameter_order, parameter_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$parameters[$myrow['parameter_id']] = $myrow;
		}
	}
	return $parameters;
}

function getParameterForm($report_id,$parameters,$editor=false) {
global $xoopsModuleConfig;

	$show_spreadsheet=$xoopsModuleConfig['show_spreadsheet'];
	$show_print=$xoopsModuleConfig['show_print'];

	$report_script='';
	if($editor) {
		$report_script='report_test.php';
	}

	$body='';
	$token=false;
	$formtitle=_MD_GWREPORTS_PARAMETER_LIST;
	if(count($parameters)==0) $formtitle=_MD_GWREPORTS_PARAMETER_LIST_EMPTY;
	$form = new XoopsThemeForm($formtitle, 'parmform', $report_script, 'POST', $token);

	foreach ($parameters as $v) {
		if($editor) {
			$caption= '<a href="editparameter.php?pid='.$v['parameter_id'].'">'.$v['parameter_title'].'</a>';
		} else {
			$caption=$v['parameter_title'];
		}
		$parm_desc=htmlspecialchars($v['parameter_description'], ENT_QUOTES);
//		if($parm_desc!='') $caption.=' <img src="images/help.png" title="'.$parm_desc.'" />';
		$parm_length=$v['parameter_length'];
		$parm_required=$v['parameter_required'];
		$parm_name='rptparm_'.$v['parameter_name'];
		$parm_type=$v['parameter_type'];
		$parm_value=$v['parameter_default'];
		if(isset($v['value'])) $parm_value = $v['value'];

		switch ($parm_type) {
			case "yesno":
				$element=new XoopsFormRadioYN($caption, $parm_name, $parm_value);
		        break;
			case "date":
				$element=new XoopsFormTextDateSelect($caption, $parm_name, $parm_length, strtotime($parm_value));
		        break;
			case "datetime":
				$element=new XoopsFormDateTime($caption, $parm_name, $parm_length, $parm_value);
		        break;
	 	    case "autocomplete":
		     	$element=new XoopsFormText($caption, $parm_name, $parm_length, $parm_length, htmlspecialchars($parm_value, ENT_QUOTES));
		     	$element->setExtra(" class='autocomplete' size='10' autocompleteurl='autocomplete.php?parameter_id=".$v['parameter_id']."'" );
		    break;
	
			default: // text, liketext, int, decimal
				$element=new XoopsFormText($caption, $parm_name, $parm_length, $parm_length, htmlspecialchars($parm_value, ENT_QUOTES));
		        break;
		}
		if($parm_desc!='')  $element->setExtra(' title="'.$parm_desc.'" ');
		$form->addElement($element,$parm_required);
		unset($element);
	}

if($editor) {
	$form->addElement(new XoopsFormButton(_MD_GWREPORTS_REPORT_TEST_DSC, 'submit', _MD_GWREPORTS_REPORT_TEST_BUTTON, 'submit'));

	$form->addElement(new XoopsFormLabel('', "<a href=\"newparameter.php?rid=$report_id\">"._MD_GWREPORTS_ADMIN_PARAMETER_ADD."</a> | <a href=\"sortparameters.php?rid=$report_id\">"._MD_GWREPORTS_ADMIN_PARAMETER_SORT.'</a>','parameter_tools'),false);
} else {
	$caption = _MD_GWREPORTS_REPORT_RUN_DSC;
	$rpttray=new XoopsFormElementTray($caption, '');

	$buttontext=_MD_GWREPORTS_REPORT_RUN_BUTTON;
	$runbutton = new XoopsFormButton('', 'submit', $buttontext, 'submit');
	$runbutton->setExtra(' onClick=\'this.form.action = "'.$report_script.'"\' ');
	$rpttray->addElement($runbutton);

	if($show_print) {
		$buttontext=_MD_GWREPORTS_REPORT_PRINT_BUTTON;
		$printbutton = new XoopsFormButton('', 'print', $buttontext, 'submit');
		$printbutton->setExtra(' onClick=\'this.form.action = "report_print.php"\' ');
		$rpttray->addElement($printbutton);
	}

	if($show_spreadsheet) {
		$buttontext=_MD_GWREPORTS_REPORT_SPREADSHEET_BUTTON;
		$ssbutton = new XoopsFormButton('', 'spreadsheet', $buttontext, 'submit');
		$ssbutton->setExtra(' onClick=\'this.form.action = "report_xls.php"\' ');
		$rpttray->addElement($ssbutton);
	}

	$form->addElement($rpttray);
}

	$form->addElement(new XoopsFormHidden('rid', $report_id));

	//$form->display();
	$body=$form->render();

	return $body;
}

function getParameterRecap($parameters) {

	$body='';
	$body.= '<table class="parmform">';
	$body.= '<tr><th colspan="2">'._MD_GWREPORTS_PARAMETER_LIST.'</th></tr>';

	foreach ($parameters as $v) {
		$parm_title=$v['parameter_title'];
		$parm_value=$v['parameter_default'];
		if(isset($v['value'])) $parm_value = $v['value'];
		$parm_type=$v['parameter_type'];

		switch ($parm_type) {
			case "yesno":
				if($parm_value) $parm_value = _YES;
				else $parm_value = _NO;
		        break;
			case "date":
//				$parm_value=formatTimestamp(strtotime($parm_value),'s');
				$parm_value=strftime('%Y-%m-%d', strtotime($parm_value));

		        break;
		    case "autocomplete":
		    	$parm_value=$parm_value.'';
		    
				break;
			default: // text, liketext, int
				$parm_value=$parm_value.'';
		        break;
		}

		$parm_title=htmlspecialchars($parm_title, ENT_QUOTES);
		$parm_value=htmlspecialchars($parm_value, ENT_QUOTES);

		$body.= '<tr valign="top" align="left"><td class="head">'.$parm_title.'</td>';
		$body.= '<td class="even">'.$parm_value.'</td></tr>';
	}

	$body.= '</table>';
	return $body;
}

// end of common stuff
?>
