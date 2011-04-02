<?php
/**
* index.php - display list of topics, or list of reports in a topic
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
$GLOBALS['xoopsOption']['template_main'] = 'gwreports_index.html';
include(XOOPS_ROOT_PATH."/header.php");

include ('include/common.php');

$userGroups=getUserGroups();

$topic_id=0;
if(isset($_GET['tid'])) $topic_id = intval($_GET['tid']);
if(isset($_POST['tid'])) $topic_id = intval($_POST['tid']);

if($topic_id==0) {
	$topics=getTopicListByGroup($userGroups);
	if(count($topics)==1) {
		$topic_id=$topics[1]['topic_id'];
	}
}
if($topic_id==0) {
	$modtitle=$xoopsModule->getVar('name');
	setPageTitle($modtitle);
	$index_description=$xoopsModuleConfig['index_text'];
	if($index_description!='') $xoopsTpl->assign('page_message', $index_description);
//	$topics=getTopicListByGroup($userGroups);
	$xoopsTpl->assign('topics', $topics);
//	$debug='<pre>$topics='.print_r($topics,true).'</pre>';
}
else {
	$topic=getTopic($topic_id);
	setPageTitle($topic['topic_name']);
	if($topic['topic_description']!='') $xoopsTpl->assign('page_message', $topic['topic_description']);
	$reports=getReportListByGroup($topic_id, $userGroups);
	$xoopsTpl->assign('reports', $reports);
//	$debug='<pre>$reports='.print_r($reports,true).'</pre>';
}

// establish breadcrumbs
$show_breadcrumbs=$xoopsModuleConfig['show_breadcrumbs'];
if($show_breadcrumbs) {
	$bc_modtitle=$xoopsModule->getVar('name');
	$bc_topic='';
	if(isset($topic['topic_name'])) $bc_topic=$topic['topic_name'];
	$bc_tid=$topic_id;
	$bc_report='';
	$bc_rid=0;
	$xoopsTpl->assign('bc_modtitle', $bc_modtitle);
	if($bc_topic!='') {
		$xoopsTpl->assign('bc_topic', $bc_topic);
		$xoopsTpl->assign('bc_tid', $bc_tid);
	}
	if($bc_report!='') {
		$xoopsTpl->assign('bc_report', $bc_report);
		$xoopsTpl->assign('bc_rid', $bc_rid);
	}
}

$body='';
if(($xoopsUser && ($xoopsUser->isAdmin()))) {
	$body.='<br /><a href="admin/index.php">'._MD_GWREPORTS_ADMIN_MENU.'</a>';
}

if(isset($body)) $xoopsTpl->assign('body', $body);

if(isset($message)) $xoopsTpl->assign('message', $message);
if(isset($err_message)) $xoopsTpl->assign('err_message', $err_message);
if(isset($debug)) $xoopsTpl->assign('debug', $debug);

include(XOOPS_ROOT_PATH."/footer.php");
?>
