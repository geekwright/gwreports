<?php
/**
* topics.php - list defined topics in administration area
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

include ('../../../include/cp_header.php');
include_once "functions.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once ('../include/dbcommon.php');

xoops_cp_header();

adminmenu(2);

	$myuserid = $xoopsUser->getVar('uid');

	$topic_name_like='';
	$offset=0;
	$limit=30;

	if(isset($_GET['topic_name_like'])) $topic_name_like = cleaner($_GET['topic_name_like']);
	$sl_topic_name_like=$xoopsDB->quoteString('%'.$topic_name_like.'%');
	if(isset($_GET['offset'])) $offset = intval($_GET['offset']);
	$token=0;

	$form = new XoopsThemeForm(_AD_GWREPORTS_AD_TOPIC_FORMNAME, 'form1', '', 'GET', $token);

	$caption = _AD_GWREPORTS_AD_TOPIC_LIKE;
	$form->addElement(new XoopsFormText($caption, 'topic_name_like', 50, 100, htmlspecialchars($topic_name_like, ENT_QUOTES)),false);

	$form->addElement(new XoopsFormButton('', 'submit', _AD_GWREPORTS_AD_TOPIC_SEARCH_BUTTON, 'submit'));

	//$form->display();
	$body=$form->render();

echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td width='100%' >";
echo $body;
echo '</td></tr>';
echo "</table>";

echo "<table width='100%' border='0' cellspacing='1' class='outer'>";
echo '<tr><th colspan="3" align="center">'._AD_GWREPORTS_AD_TOPIC_LISTNAME.'</th></tr>';
echo '<tr><th>'._AD_GWREPORTS_AD_TOPIC_ID."</th><th>"._AD_GWREPORTS_AD_TOPIC_NAME.'</th>';
echo '<th>'._AD_GWREPORTS_AD_TOPIC_OPTION.'</tr>';

$sql="SELECT topic_id, topic_name FROM ".$xoopsDB->prefix('gwreports_topic');
$sql.=" WHERE topic_name like $sl_topic_name_like ";
$sql.=" ORDER BY topic_name ";

$result = $xoopsDB->query($sql,$limit,$offset);
$cnt=0;
$teven='class="even"';
$todd='class="odd"';
$tclass=$teven;
if ($result) {
	while($myrow=$xoopsDB->fetchArray($result)) {
		++$cnt;
		echo '<tr cellspacing="2" cellpadding="2" '.$tclass.'>';
		echo '<td>'.$myrow['topic_id'].'</td>';
		echo '<td><a href="../edittopic.php?tid='.$myrow['topic_id'].'"">'.$myrow['topic_name'].'</a></td>';
		echo '<td><a href="../sortreports.php?tid='.$myrow['topic_id'].'"">'._AD_GWREPORTS_ADMIN_REPORT_SORT.'</a></td></tr>';
	}
}
if($cnt==0) echo '<tr><td colspan="3" align="center">'._AD_GWREPORTS_AD_TOPIC_LISTEMPTY.'</td></tr>';
echo "</table>";

$dirname=$xoopsModule->getInfo('dirname');
$body='';
$body.='<br /><a href="'.XOOPS_URL.'/modules/'.$dirname.'/newreport.php">'._AD_GWREPORTS_ADMIN_REPORT_ADD.'</a>';
$body.=' | <a href="'.XOOPS_URL.'/modules/'.$dirname.'/newtopic.php">'._AD_GWREPORTS_ADMIN_TOPIC_ADD.'</a>';
$body.=' | <a href="'.XOOPS_URL.'/modules/'.$dirname.'/sorttopics.php">'._AD_GWREPORTS_ADMIN_TOPIC_SORT.'</a>';

echo $body;

xoops_cp_footer();
?>