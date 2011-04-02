<?php
/**
* dbcommon.php - database utility functions
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

function startTransaction() {
global $xoopsDB;
	$sql = 'START TRANSACTION';
	$result = $xoopsDB->queryF($sql);
	return $result;
}

function rollbackTransaction() {
global $xoopsDB;
	$sql = 'ROLLBACK';
	$result = $xoopsDB->queryF($sql);
	return $result;
}

function commitTransaction() {
global $xoopsDB;
	$sql = 'COMMIT';
	$result = $xoopsDB->queryF($sql);
	return $result;
}

function formatDBError() {
global $xoopsDB;

	$msg=$xoopsDB->errno() . ' ' . $xoopsDB->error();
	return($msg);
}

function cleaner($string,$htmlok=false) {
	$string=trim($string);
	$string=html_entity_decode($string);
	if(!$htmlok) $string=strip_tags($string);
	$string=trim($string);
	$string=stripslashes($string);
	return $string;
}

function cleaneryn($string) {
	$r=intval($string);
	if($r) $r=1;
	else $r=0;
	return $r;
}

function getTcpdfPath() {
global $xoopsModuleConfig;

	$tcpdf_path='';
	$tcpdf_path=$xoopsModuleConfig['tcpdf_path'];
	if($tcpdf_path=='') {
		if ( file_exists('tcpdf/tcpdf.php') ) {
			$tcpdf_path='tcpdf/tcpdf.php';
		} elseif ( file_exists(XOOPS_ROOT_PATH.'/libraries/tcpdf/tcpdf.php') ) {
			$tcpdf_path=XOOPS_ROOT_PATH.'/libraries/tcpdf/tcpdf.php';
		} else $tcpdf_path='';
	}
	return $tcpdf_path;
}

?>