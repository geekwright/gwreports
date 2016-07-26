<?php
/**
* dbcommon.php - database utility functions
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

if (!defined("XOOPS_ROOT_PATH")) {
    die("Root path not defined");
}

function startTransaction()
{
    global $xoopsDB;
    $sql = 'START TRANSACTION';
    $result = $xoopsDB->queryF($sql);
    return $result;
}

function rollbackTransaction()
{
    global $xoopsDB;
    $sql = 'ROLLBACK';
    $result = $xoopsDB->queryF($sql);
    return $result;
}

function commitTransaction()
{
    global $xoopsDB;
    $sql = 'COMMIT';
    $result = $xoopsDB->queryF($sql);
    return $result;
}

function formatDBError()
{
    global $xoopsDB, $xoopsUser;

    $msg=$xoopsDB->errno();
    if (($xoopsUser && ($xoopsUser->isAdmin()))) {
        $msg=$xoopsDB->errno() . ' ' . $xoopsDB->error();
    }
    return($msg);
}

function cleaner($string, $htmlok=false)
{
    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
    if (!$htmlok) {
        $string=html_entity_decode($string);
        $string=strip_tags($string);
    }
    $string=trim($string);
    return $string;
}

function cleaneryn($string)
{
    $r=intval($string);
    $r=($r ? 1 : 0);
    return $r;
}

function dbescape($string)
{
    return mysql_real_escape_string($string);
}

function clipstring($string, $length)
{
    // encoding parameter may have naming issues in some cases but seems to work for utf-8
    if (function_exists('mb_substr')) {
        $ret=mb_substr($string, 0, $length, XOOPS_DB_CHARSET);
    } else {
        $ret=substr($string, 0, $length);
    }
    if ($ret===false) {
        $ret=(string)$string;
    } // if string is empty things can get stupid
    return $ret;
}

function getTcpdfPath()
{
    global $xoopsModuleConfig;

    $tcpdf_path='';
    $tcpdf_path=$xoopsModuleConfig['tcpdf_path'];
    if ($tcpdf_path=='') {
        if (file_exists('tcpdf/tcpdf.php')) {
            $tcpdf_path='tcpdf/tcpdf.php';
        } elseif (file_exists(XOOPS_ROOT_PATH.'/libraries/tcpdf/tcpdf.php')) {
            $tcpdf_path=XOOPS_ROOT_PATH.'/libraries/tcpdf/tcpdf.php';
        } else {
            $tcpdf_path='';
        }
    }
    return $tcpdf_path;
}
