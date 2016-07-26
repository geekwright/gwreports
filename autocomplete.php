<?php
/**
* autocomplete.php - execute auto-completion query for a report parameter
*
* This file is part of gwreports - geekwright Reports
*
* @copyright  Copyright © 2011-2013 geekwright, LLC. All rights reserved.
* @license    GNU General Public License (GPL)
* @since      1.1
* @author     KS Tan <kstan@simit.com.my>
* @package    gwreports
* @version    $Id$
*/
include '../../mainfile.php';
$xoopsLogger->activated = false; // this corrupts the reading of the json return if left activated with xoops debug on
// provide error logging for our sanity in debugging ajax use (won't see xoops logger)
//restore_error_handler();
//error_reporting(-1);
//trigger_error('autocomplete.php');

//$GLOBALS['xoopsOption']['template_main'] = 'gwreports_reportview.html';
include(XOOPS_ROOT_PATH."/header.php");
include('include/common.php');

$parameter_id=intval($_REQUEST['parameter_id']);
// really should check this to make sure the parameter belongs to a
// report the user is allowed to access to prevent data disclosure

$sql='SELECT report, parameter_sqlchoice FROM '. $xoopsDB->prefix('gwreports_parameter') ." where parameter_id={$parameter_id}";
$q=$xoopsDB->query($sql);
$sqlchoice='';
while ($r=$xoopsDB->fetchArray($q)) {
    $sqlchoice=$r['parameter_sqlchoice'];
    $report_id=$r['report'];
}

if (!($report_id) || $sqlchoice=='') {
    die;
}
// check first for for explicit permission that is part of report, if none, then
// check for admin. This is needed during report development before rights are assigned
if (!checkUserReportAccess($report_id)) {
    if (!($xoopsUser && ($xoopsUser->isAdmin()))) {
        die;
    }
}

$parmtags='{$xpfx}';
$parmsubs=$xoopsDB->prefix('').'_';
$sqlchoice=str_replace($parmtags, $parmsubs, $sqlchoice);

    $str=cleaner($_REQUEST['term']);
    if (strpos($str, '%')===false) {
        $str='%'.$str.'%';
    }
    $str=dbescape($str);

    $sqlchoice="SELECT * FROM ({$sqlchoice}) a where a.label LIKE  '{$str}' order by a.label limit 0,30";

    $query=$xoopsDB->query($sqlchoice);
    $data=array();

    while ($row=$xoopsDB->fetchArray($query)) {
        $data[]=array('value'=> $row['value'],"label"=>$row['label']);
    }
        
    echo json_encode($data);
    exit;
?>
