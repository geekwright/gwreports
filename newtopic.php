<?php
/**
* newtopic.php - add a new topic definition
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
$GLOBALS['xoopsOption']['template_main'] = 'gwreports_topic.html';
include(XOOPS_ROOT_PATH."/header.php");

include('include/common.php');

if (!($xoopsUser && ($xoopsUser->isAdmin()))) {
    redirect_header('index.php', 3, _NOPERM);
}

$op='display';
if (isset($_POST['submit'])) {
    $op='add';
}

$topics=getTopicList();
$xoopsTpl->assign('topics', $topics);

$topic_name='';
$topic_description='';

    if (isset($_POST['topic_name'])) {
        $topic_name = cleaner($_POST['topic_name']);
    }
    if (isset($_POST['topic_description'])) {
        $topic_description = cleaner($_POST['topic_description']);
    }

if ($op!='display') {
    $check=$GLOBALS['xoopsSecurity']->check();

    if (!$check) {
        $op='display';
        $err_message = _MD_GWREPORTS_MSG_BAD_TOKEN;
    }
}

if ($op=='add') {
    $sl_topic_name=dbescape($topic_name);
    $sl_topic_description=dbescape($topic_description);

    $dberr=false;
    $dbmsg='';

    $sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_topic');
    $sql.=' (topic_name, topic_description) ';
    $sql.=" VALUES ('$sl_topic_name', '$sl_topic_description' )";
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        $dberr=true;
        $dbmsg=formatDBError();
    }

    if (!$dberr) {
        $new_topic_id = $xoopsDB->getInsertId();
    }

    if (!$dberr) {
        $message = _MD_GWREPORTS_TOPIC_ADD_OK;
        redirect_header("edittopic.php?tid=$new_topic_id", 3, $message);
    } else {
        $err_message = _MD_GWREPORTS_TOPIC_ADD_ERR .' '.$dbmsg;
    }
}

    $body='';
    $token=true;
    $formtitle=_MD_GWREPORTS_NEWTOPIC_FORM;
    $form = new XoopsThemeForm($formtitle, 'form1', 'newtopic.php', 'POST', $token);

    $caption = _MD_GWREPORTS_TOPIC_NAME;
    $form->addElement(new XoopsFormText($caption, 'topic_name', 40, 250, htmlspecialchars($topic_name, ENT_QUOTES)), true);

    $caption = _MD_GWREPORTS_TOPIC_DESC;
    $form->addElement(new XoopsFormTextArea($caption, 'topic_description', $topic_description, 10, 50, 'topic_description'), false);


    $form->addElement(new XoopsFormButton(_MD_GWREPORTS_NEWTOPIC_ADD_BUTTON_DSC, 'submit', _MD_GWREPORTS_NEWTOPIC_ADD_BUTTON, 'submit'));

    //$form->display();
    $body=$form->render();

//$dirname=$xoopsModule->getInfo('dirname');
$body.='<br /><a href="admin/index.php">'._MD_GWREPORTS_ADMIN_MENU.'</a>';
$body.=' | <a href="admin/reports.php">'._MD_GWREPORTS_ADMIN_REPORT.'</a>';
$body.=' | <a href="admin/topics.php">'._MD_GWREPORTS_ADMIN_TOPIC.'</a>';
$body.=' | <a href="newreport.php">'._MD_GWREPORTS_ADMIN_REPORT_ADD.'</a>';
$body.=' | <a href="sorttopics.php">'._MD_GWREPORTS_ADMIN_TOPIC_SORT.'</a>';

//$debug='<pre>$_POST='.print_r($_POST,true).'</pre>';

setPageTitle(_MD_GWREPORTS_NEWTOPIC_FORM);
if (isset($body)) {
    $xoopsTpl->assign('body', $body);
}

if (isset($message)) {
    $xoopsTpl->assign('message', $message);
}
if (isset($err_message)) {
    $xoopsTpl->assign('err_message', $err_message);
}
if (isset($debug)) {
    $xoopsTpl->assign('debug', $debug);
}

include(XOOPS_ROOT_PATH."/footer.php");
