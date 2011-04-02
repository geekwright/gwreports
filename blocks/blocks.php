<?php
/**
* blocks.php - code to support blocks
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

if (!defined('XOOPS_ROOT_PATH')){ exit(); }
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

function b_gwreports_block_topic_show($options) {
	global $xoopsDB, $xoopsUser;

	$block=null;
	$ourdir=basename( dirname( dirname( __FILE__ ) ) ) ;

	$topic_id=$options[0];

	$usergroups=array(XOOPS_GROUP_ANONYMOUS);

	if($xoopsUser) {
		$usergroups=$xoopsUser->getGroups();
	}

	$wherein='';
	foreach($usergroups as $i) {
		if($wherein=='') $wherein .='('.$i;
		else $wherein .=','.$i;
	}
	if($wherein=='')  return $block; // error if no groups
	$wherein .=')';

	$sql='SELECT DISTINCT report_id, report_name, report_description, grouping_order FROM ';
	$sql.= $xoopsDB->prefix('gwreports_report') . ' r, ';
	$sql.= $xoopsDB->prefix('gwreports_grouping') . ' g, '; // topic, report, grouping_order
	$sql.= $xoopsDB->prefix('gwreports_access') . ' a '; // report, groupid

	$sql.= ' WHERE a.groupid in '.$wherein;
	$sql.= ' AND g.report=a.report ';
	$sql.= " AND g.topic = $topic_id ";
	$sql.= " AND r.report_id = g.report ";
	$sql.= " AND r.report_active = 1 ";
	$sql.= ' ORDER BY grouping_order, report_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$rid=$myrow['report_id'];
			$block[$rid]['report_id']=$rid;

			$block[$rid]['report_name']=htmlspecialchars($myrow['report_name'], ENT_QUOTES);
			$block[$rid]['report_description']=htmlspecialchars($myrow['report_description'], ENT_QUOTES);
			$block[$rid]['link']=XOOPS_URL."/modules/$ourdir/report_view.php?rid=$rid";
		}
	}

	return $block;
}

function b_gwreports_block_topic_edit($options) {

	global $xoopsDB;
	$topics=array();

	$sql='SELECT topic_id, topic_name, topic_order FROM '. $xoopsDB->prefix('gwreports_topic');
	$sql.= ' ORDER BY topic_order, topic_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$topics[$myrow['topic_id']] = $myrow['topic_name'];
		}
	}

	$form = _MB_GWREPORTS_BLOCK_TOPIC_ID.": ";
	if (count($topics)) {
		$form.= "<select 'id='options[0]' name='options[0]'>";
		foreach($topics as $i=>$v) {
			$sel='';
			if($i==$options[0]) $sel='selected="yes"';
  			$form.="<option $sel value=\"$i\">$v</option>";
		}
		$form.= '</select>';
	}
	else {
		$form.= "<input type='text' value='".$options[0]."'id='options[0]' name='options[0]' />";
	}
	return $form;
}

function b_gwreports_block_quick_report_show($options) {
	global $xoopsDB, $xoopsUser, $xoTheme;

	$block=null;
	$ourdir=basename( dirname( dirname( __FILE__ ) ) ) ;

	$report_id=$options[0];

	$usergroups=array(XOOPS_GROUP_ANONYMOUS);

	if($xoopsUser) {
		$usergroups=$xoopsUser->getGroups();
	}

	$wherein='';
	foreach($usergroups as $i) {
		if($wherein=='') $wherein .='('.$i;
		else $wherein .=','.$i;
	}
	if($wherein=='')  return $block; // error if no groups
	$wherein .=')';

	$sql='SELECT DISTINCT report_id, report_name, report_description FROM ';
	$sql.= $xoopsDB->prefix('gwreports_report') . ' r, ';
	$sql.= $xoopsDB->prefix('gwreports_access') . ' a '; // report, groupid

	$sql.= ' WHERE a.groupid in '.$wherein;
	$sql.= " AND r.report_id = $report_id ";
	$sql.= " AND r.report_id = a.report ";
	$sql.= " AND r.report_active = 1 ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$rid=$myrow['report_id'];
			$block['report_id']=$rid;
			$block['report_name']=htmlspecialchars($myrow['report_name'], ENT_QUOTES);
			$block['report_description']=htmlspecialchars($myrow['report_description'], ENT_QUOTES);
			$block['link']=XOOPS_URL."/modules/$ourdir/report_view.php?rid=$rid";
		}
	}

	if(is_null($block)) return;

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

	if(count($parameters)) {
		$mymoduledir='modules/'.$ourdir.'/';
		if(isset($xoTheme) && is_object($xoTheme)) $xoTheme->addStylesheet($mymoduledir.'module.css');

		$body='';
		$token=false;
		$formtitle=''; // $block['report_name'];
		$report_script=XOOPS_URL."/modules/$ourdir/report_view.php";

		$form = new XoopsSimpleForm($formtitle, 'parmblockform', $report_script, 'POST', $token);

		foreach ($parameters as $v) {
			$caption=$v['parameter_title'];

			$parm_desc=htmlspecialchars($v['parameter_description'], ENT_QUOTES);
			$parm_length=$v['parameter_length'];
			$parm_length_min=$parm_length;
			if($parm_length_min>10) $parm_length_min=10;
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
				default: // text, liketext, int
					$element=new XoopsFormText($caption, $parm_name, $parm_length_min, $parm_length, htmlspecialchars($parm_value, ENT_QUOTES));
		        	break;
			}
			if($parm_desc!='')  $element->setExtra(' title="'.$parm_desc.'" ');
			$form->addElement($element,$parm_required);
			unset($element);
		}

		$form->addElement(new XoopsFormButton('', 'submit', _MB_GWREPORTS_REPORT_RUN_BUTTON, 'submit'));

		$form->addElement(new XoopsFormHidden('rid', $report_id));

		$body=$form->render();
		$block['form']=$body;
	}


	return $block;

}

function b_gwreports_block_quick_report_edit($options) {

	global $xoopsDB;
	$reports=array();
	$limit=60; // when list will get unwieldy

	$sql='SELECT report_id, report_name FROM '. $xoopsDB->prefix('gwreports_report');
	$sql.= " WHERE report_active = 1 ";
	$sql.= ' ORDER BY report_name, report_id ';

	$result = $xoopsDB->query($sql,$limit,0);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$reports[$myrow['report_id']] = $myrow['report_name'];
		}
	}

	$form = _MB_GWREPORTS_BLOCK_QUICK_REPORT_ID.": ";
	if (count($reports) && count($reports)<$limit) {
		$form.= "<select 'id='options[0]' name='options[0]'>";
		foreach($reports as $i=>$v) {
			$sel='';
			if($i==$options[0]) $sel='selected="yes"';
  			$form.="<option $sel value=\"$i\">$v</option>";
		}
		$form.= '</select>';
	}
	else {
		$form.= "<input type='text' value='".$options[0]."'id='options[0]' name='options[0]' />";
	}
	return $form;
}
?>