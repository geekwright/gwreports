<?php
/**
* export.php - export a report to a flat file
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

include '../../../mainfile.php';
include_once ('../include/dbcommon.php');

if(!($xoopsUser && ($xoopsUser->isAdmin()))) {
	redirect_header(XOOPS_URL, 3, _NOPERM);
} 
$xoopsLogger->activated = false;

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

$eol = "\n";

$report_id=0;
$report_name='';
$report_description='';

if(isset($_GET['rid'])) $report_id = intval($_GET['rid']);
if(isset($_POST['rid'])) $report_id = intval($_POST['rid']);

// get data from table

	$sql='SELECT * FROM '.$xoopsDB->prefix('gwreports_report');
	$sql.=" WHERE report_id = $report_id ";

	$cnt=0;
	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$report_name=$myrow['report_name'];
			$report_description=$myrow['report_description'];
			$report_active=$myrow['report_active'];
			++$cnt;
		}
		if($cnt) {
			$zapus = array('.', ',', ' ', ':', '/', '\\');
			$filename = str_replace($zapus, '_', 'export_'.$report_name).'.txt';
			header('Content-Type: text/plain');
			header("Content-Disposition: attachment; filename=\"$filename\"");

			echo 'GWREPORTS EXPORT 1.1'.$eol;

			echo 'REPORT'.$eol;
			echo base64_encode($report_name).$eol;
			echo base64_encode($report_description).$eol;

			$parameters=getReportParameters($report_id);
			foreach ($parameters as $parm) {
				echo 'PARAMETER'.$eol;
				echo base64_encode($parm['parameter_name']).$eol;
				echo base64_encode($parm['parameter_title']).$eol;
				echo base64_encode($parm['parameter_description']).$eol;
				echo $parm['parameter_order'].$eol;
				echo base64_encode($parm['parameter_default']).$eol;
				echo $parm['parameter_required'].$eol;
				echo $parm['parameter_length'].$eol;
				echo $parm['parameter_type'].$eol;
				echo $parm['parameter_decimals'].$eol;
				echo base64_encode($parm['parameter_sqlchoice']).$eol;
			}
			$sections=getReportSections($report_id);
			foreach ($sections as $sec) {
				echo 'SECTION'.$eol;
				$section_id=$sec['section_id'];

				echo base64_encode($sec['section_name']).$eol;
				echo base64_encode($sec['section_description']).$eol;
				echo $sec['section_order'].$eol;
				echo $sec['section_showtitle'].$eol;
				echo $sec['section_multirow'].$eol;
				echo $sec['section_skipempty'].$eol;
				echo $sec['section_datatools'].$eol;
				echo base64_encode($sec['section_query']).$eol;

				$columns=getColumns($section_id);
				foreach ($columns as $col) {
					echo 'COLUMN'.$eol;
					echo base64_encode($col['column_name']).$eol;
					echo base64_encode($col['column_title']).$eol;
					echo $col['column_hide'].$eol;
					echo $col['column_sum'].$eol;
					echo $col['column_break'].$eol;
					echo $col['column_outline'].$eol;
					echo $col['column_apply_nl2br'].$eol;
					echo $col['column_is_unixtime'].$eol;
					echo base64_encode($col['column_format']).$eol;
					echo base64_encode($col['column_style']).$eol;
					echo base64_encode($col['column_extended_format']).$eol;
				}
			}
			echo 'END'.$eol;
		}
	}

?>
