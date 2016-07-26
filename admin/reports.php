<?php
/**
* reports.php - list defined reports in administration area
*
* This file is part of gwreports - geekwright Reports
*
* @copyright  Copyright © 2011-2013 geekwright, LLC. All rights reserved.
* @license    gwreports/docs/license.txt  GNU General Public License (GPL)
* @since      1.0
* @author     Richard Griffith <richard@geekwright.com>
* @package    gwreports
* @version    $Id$
*/

include 'header.php';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

    if ($xoop25plus) {
        echo $moduleAdmin->addNavigation('reports.php');
    } else {
        adminmenu(4);
    }

    $myuserid = $xoopsUser->getVar('uid');

    $report_name_like='';

    if (isset($_GET['report_name_like'])) {
        $report_name_like = cleaner($_GET['report_name_like']);
    }
    $sl_report_name_like=$xoopsDB->quoteString('%'.$report_name_like.'%');

// set up pagenav counts
    $offset=0;
    $limit=30;
    $total=0;

    $sql="SELECT count(*) FROM ".$xoopsDB->prefix('gwreports_report');
    $sql.=" WHERE report_name like $sl_report_name_like ";

    $result = $xoopsDB->query($sql);
    if ($result) {
        $myrow=$xoopsDB->fetchRow($result);
        $total=$myrow[0];
    }

    if (isset($_GET['offset'])) {
        $offset = intval($_GET['offset']);
    }


    $token=0;

    $form = new XoopsThemeForm(_AD_GWREPORTS_AD_REPORT_FORMNAME, 'form1', '', 'GET', $token);

    $caption = _AD_GWREPORTS_AD_REPORT_LIKE;
    $form->addElement(new XoopsFormText($caption, 'report_name_like', 50, 100, htmlspecialchars($report_name_like, ENT_QUOTES)), false);

    $form->addElement(new XoopsFormButton('', 'submit', _AD_GWREPORTS_AD_REPORT_SEARCH_BUTTON, 'submit'));

    //$form->display();
    $body=$form->render();

echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td width='100%' >";
echo $body;
echo '</td></tr>';
echo "</table>";

echo "<table width='100%' border='0' cellspacing='1' class='outer'>";
echo '<tr><th colspan="4" align="center">'._AD_GWREPORTS_AD_REPORT_LISTNAME.'</th></tr>';
echo '<tr><th>'._AD_GWREPORTS_AD_REPORT_ID."</th><th>"._AD_GWREPORTS_AD_REPORT_NAME.'</th>';
echo '<th>'._AD_GWREPORTS_AD_REPORT_ACTIVE.'</th>';
echo '<th>'._AD_GWREPORTS_AD_REPORT_OPTIONS.'</th></tr>';

$sql="SELECT report_id, report_name, report_active FROM ".$xoopsDB->prefix('gwreports_report');
$sql.=" WHERE report_name like $sl_report_name_like ";
$sql.=" ORDER BY report_name ";

$result = $xoopsDB->query($sql, $limit, $offset);
$cnt=0;
$teven='class="even"';
$todd='class="odd"';
$tclass=$teven;
if ($result) {
    while ($myrow=$xoopsDB->fetchArray($result)) {
        ++$cnt;
        echo '<tr cellspacing="2" cellpadding="2" '.$tclass.'>';
        echo '<td>'.$myrow['report_id'].'</td>';
        echo '<td><a href="../editreport.php?rid='.$myrow['report_id'].'"">'.$myrow['report_name'].'</a></td>';
        echo '<td>'.($myrow['report_active'] ? _YES : _NO) .'</td>';
        echo '<td><a href="export.php?rid='.$myrow['report_id'].'"">'._AD_GWREPORTS_AD_REPORT_EXPORT.'</a></td>';
        echo '</tr>';
    }
}
if ($cnt==0) {
    echo '<tr><td colspan="3" align="center">'._AD_GWREPORTS_AD_REPORT_LISTEMPTY.'</td></tr>';
}
echo "</table>";

// output pagenav
if ($total > $limit) {
    include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
    $navextra='';
    if ($report_name_like!='') {
        $navextra='report_name_like='.urlencode($report_name_like);
    }
    $nav = new xoopsPageNav($total, $limit, $offset, 'offset', $navextra);
    echo $nav->renderNav();
}


$dirname=$xoopsModule->getInfo('dirname');
$body='';
$body.='<br /><a href="'.XOOPS_URL.'/modules/'.$dirname.'/newreport.php">'._AD_GWREPORTS_ADMIN_REPORT_ADD.'</a>';
$body.=' | <a href="import.php">'._AD_GWREPORTS_AD_REPORT_IMPORT.'</a>';
$body.=' | <a href="'.XOOPS_URL.'/modules/'.$dirname.'/newtopic.php">'._AD_GWREPORTS_ADMIN_TOPIC_ADD.'</a>';echo $body;

include 'footer.php';
