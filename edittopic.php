<?php
/**
* edittopic.php - update a report topic
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
if (isset($_POST['update'])) {
    $op='update';
}
if (isset($_POST['delete'])) {
    $op='delete';
}

$topics=getTopicList();
$xoopsTpl->assign('topics', $topics);

$topic_id=0;
$topic_name='';
$topic_description='';

if (isset($_GET['tid'])) {
    $topic_id = intval($_GET['tid']);
}
if (isset($_POST['tid'])) {
    $topic_id = intval($_POST['tid']);
}

// get data from table

    $sql='SELECT * FROM '.$xoopsDB->prefix('gwreports_topic');
    $sql.=" WHERE topic_id = $topic_id ";

    $cnt=0;
    $result = $xoopsDB->query($sql);
    if ($result) {
        while ($myrow=$xoopsDB->fetchArray($result)) {
            $topic_name=$myrow['topic_name'];
            $topic_description=$myrow['topic_description'];
        }
    } else {
        $err_message = _MD_GWREPORTS_TOPIC_NOTFOUND;
        $topic_id=0;
    }

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

if ($op=='update') {
    $sl_topic_name=dbescape($topic_name);
    $sl_topic_description=dbescape($topic_description);

    $dberr=false;
    $dbmsg='';

    $sql ='UPDATE '.$xoopsDB->prefix('gwreports_topic');
    $sql.=" SET topic_name = '$sl_topic_name'";
    $sql.=" , topic_description =  '$sl_topic_description' ";
    $sql.=" WHERE topic_id = $topic_id ";
    $result = $xoopsDB->queryF($sql);
    if (!$result) {
        $dberr=true;
        $dbmsg=formatDBError();
    }

    if (!$dberr) {
        $message = _MD_GWREPORTS_TOPIC_UPD_OK;
//		redirect_header("edittopic.php?cpid=$new_topic_id", 3, $message);
    } else {
        $err_message = _MD_GWREPORTS_TOPIC_UPD_ERR .' '.$dbmsg;
    }
}

if ($op=='delete') {
    $sql='DELETE  FROM '.$xoopsDB->prefix('gwreports_grouping');
    $sql.=" WHERE topic = $topic_id ";
    $result = $xoopsDB->queryF($sql);

    $sql='DELETE  FROM '.$xoopsDB->prefix('gwreports_topic');
    $sql.=" WHERE topic_id = $topic_id ";
    $result = $xoopsDB->queryF($sql);

    $message = _MD_GWREPORTS_TOPIC_DELETED;
    redirect_header("admin/topics.php", 3, $message);
}

    $body='';
if ($topic_id) {
    $token=true;
    $formtitle=_MD_GWREPORTS_EDITTOPIC_FORM;
    $form = new XoopsThemeForm($formtitle, 'form1', 'edittopic.php', 'POST', $token);

    $caption = _MD_GWREPORTS_TOPIC_NAME;
    $form->addElement(new XoopsFormText($caption, 'topic_name', 40, 250, htmlspecialchars($topic_name, ENT_QUOTES)), true);

    $caption = _MD_GWREPORTS_TOPIC_DESC;
    $form->addElement(new XoopsFormTextArea($caption, 'topic_description', $topic_description, 10, 50, 'topic_description'), false);

    $form->addElement(new XoopsFormHidden('tid', $topic_id));

    $caption = _MD_GWREPORTS_EDITTOPIC_UPD_BUTTON_DSC;
    $updtray=new XoopsFormElementTray($caption, '');

    $updtray->addElement(new XoopsFormButton('', 'update', _MD_GWREPORTS_EDITTOPIC_UPD_BUTTON, 'submit'));

    $delbtn=new XoopsFormButton('', 'delete', _MD_GWREPORTS_EDITTOPIC_DEL_BUTTON, 'submit');
    $delbtn->setExtra('onClick=\'this.form.target = "_self";return confirm("'._MD_GWREPORTS_EDITTOPIC_DEL_CONFIRM.'")\'');
    $updtray->addElement($delbtn);
    $form->addElement($updtray);

    //$form->display();
    $body=$form->render();
}

//$dirname=$xoopsModule->getInfo('dirname');
$body.='<br /><a href="admin/index.php">'._MD_GWREPORTS_ADMIN_MENU.'</a>';
$body.=' | <a href="admin/reports.php">'._MD_GWREPORTS_ADMIN_REPORT.'</a>';
$body.=' | <a href="admin/topics.php">'._MD_GWREPORTS_ADMIN_TOPIC.'</a>';
$body.=' | <a href="sorttopics.php">'._MD_GWREPORTS_ADMIN_TOPIC_SORT.'</a>';
$body.=" | <a href=\"sortreports.php?tid=$topic_id\">"._MD_GWREPORTS_ADMIN_REPORT_SORT.'</a>';

//$debug='<pre>$_POST='.print_r($_POST,true).'</pre>';

setPageTitle(_MD_GWREPORTS_EDITTOPIC_FORM);
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
