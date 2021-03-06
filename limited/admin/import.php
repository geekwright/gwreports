<?php
/**
* import.php - import an exported report definition
*     limited mode version loads files from trust path only
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

    if (!$xoop25plus) {
        adminmenu(4);
    }

    $pathname=XOOPS_TRUST_PATH.'/modules/gwreports/import/';
    if (!is_dir($pathname)) {
        redirect_header('reports.php', 3, sprintf(_AD_GWREPORTS_NO_IMPORT_DIR, $pathname));
    }
    $files=glob($pathname.'*');
    $filelist=array();
    if (is_array($files) && count($files) > 0) {
        foreach ($files as $filename) {
            $check=file_get_contents($filename, false, null, -1, 80);
            if (substr($check, 0, 17)=='GWREPORTS EXPORT ') {
                $filelist[basename($filename)]=basename($filename);
            }
        }
    }
    if (count($filelist)<1) {
        redirect_header('reports.php', 3, _AD_GWREPORTS_EMPTY_IMPORT_DIR);
    }

    $import_file='';
    if (isset($_POST['import_file'])) {
        $import_file=$filelist[cleaner($_POST['import_file'])];
        $check=$GLOBALS['xoopsSecurity']->check();
        if (!$check) {
            $op='display';
            $err_message = _AD_GWREPORTS_BAD_TOKEN;
            $import_file='';
        }
    }
    if ($import_file && $import_file!='') {
        $import = file($pathname.$import_file, FILE_IGNORE_NEW_LINES);
        $gwreports_export_sig='GWREPORTS EXPORT '; // this is followed by $export_version
        $have_export_sig=(substr($import[0], 0, strlen($gwreports_export_sig))==$gwreports_export_sig);
        $export_version=substr($import[0], strlen($gwreports_export_sig));
        if (count($import)>4 && $have_export_sig && $export_version<=1.1 && $import[1]=='REPORT') {
            //			echo '<pre>$import='.print_r($import,true).'</pre>';
            $line=2;
            $report_name=dbescape(base64_decode($import[$line++]));
            $report_description=dbescape(base64_decode($import[$line++]));

            $dberr=false;
            $dbmsg='';
            startTransaction();
            $sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_report');
            $sql.=' (report_name, report_description) ';
            $sql.=" VALUES ('$report_name', '$report_description' )";
            $result = $xoopsDB->queryF($sql);
            if (!$result) {
                $dberr=true;
                $dbmsg=formatDBError();
            }

            if (!$dberr) {
                $report_id = $xoopsDB->getInsertId();
            }

            while ($dberr==false && isset($import[$line]) && $import[$line]!='END') {
                $table=$import[$line++];
                switch ($table) {
                    case "END": break;
                    case "PARAMETER":
                        $parameter_name = dbescape(base64_decode($import[$line++]));
                        $parameter_title = dbescape(base64_decode($import[$line++]));
                        $parameter_description = dbescape(base64_decode($import[$line++]));
                        $parameter_order = intval($import[$line++]);
                        $parameter_default = dbescape(base64_decode($import[$line++]));
                        $parameter_required = intval($import[$line++]);
                        $parameter_length = intval($import[$line++]);
                        $parameter_type = dbescape($import[$line++]);
                        $parameter_decimals = intval($import[$line++]);
                         // sqlchoice added in version 1.1
                        $parameter_sqlchoice='';
                        if ($export_version>1.0) {
                            $parameter_sqlchoice = dbescape(base64_decode($import[$line++]));
                        }

                        $sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_parameter');
                        $sql.=' (report, parameter_name, parameter_title, parameter_description, parameter_order, parameter_default, parameter_required, parameter_length, parameter_type, parameter_decimals, parameter_sqlchoice) ';
                        $sql.=" VALUES ( $report_id, '$parameter_name', '$parameter_title', '$parameter_description', $parameter_order, '$parameter_default', $parameter_required, $parameter_length, '$parameter_type', $parameter_decimals, '$parameter_sqlchoice') ";

                        $result = $xoopsDB->queryF($sql);
                        if (!$result) {
                            $dberr=true;
                            $dbmsg=formatDBError();
                        }
                        break;
                    case "SECTION":
                        $section_name = dbescape(base64_decode($import[$line++]));
                        $section_description = dbescape(base64_decode($import[$line++]));
                        $section_order = intval($import[$line++]);
                        $section_showtitle = intval($import[$line++]);
                        $section_multirow = intval($import[$line++]);
                        $section_skipempty = intval($import[$line++]);
                        if ($export_version>1.0) {
                            $section_datatools = intval($import[$line++]);
                        }
                        $section_query = dbescape(base64_decode($import[$line++]));

                        $sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_section');
                        $sql.=' (report, section_name, section_description, section_order, section_showtitle, section_multirow, section_skipempty, section_datatools, section_query) ';
                        $sql.=" VALUES ( $report_id, '$section_name', '$section_description', $section_order, $section_showtitle, $section_multirow, $section_skipempty, $section_datatools, '$section_query') ";

                        $result = $xoopsDB->queryF($sql);
                        if (!$result) {
                            $dberr=true;
                            $dbmsg=formatDBError();
                        } else {
                            $section_id = $xoopsDB->getInsertId();
                        }
                        break;
                    case "COLUMN":
                        $column_name = dbescape(base64_decode($import[$line++]));
                        $column_title = dbescape(base64_decode($import[$line++]));
                        $column_hide = intval($import[$line++]);
                        $column_sum = intval($import[$line++]);
                        $column_break = intval($import[$line++]);
                        $column_outline = intval($import[$line++]);
                        $column_apply_nl2br = intval($import[$line++]);
                        $column_is_unixtime = intval($import[$line++]);
                        $column_format = dbescape(base64_decode($import[$line++]));
                        $column_style = dbescape(base64_decode($import[$line++]));
                        $column_extended_format = dbescape(base64_decode($import[$line++]));

                        $sql ='INSERT INTO '.$xoopsDB->prefix('gwreports_column');
                        $sql.=' (section, column_name, column_title, column_hide, column_sum, column_break, column_outline, column_apply_nl2br, column_is_unixtime, column_format, column_style, column_extended_format ) ';
                        $sql.=" VALUES ($section_id, '$column_name', '$column_title', $column_hide, $column_sum, $column_break, $column_outline, $column_apply_nl2br, $column_is_unixtime, '$column_format', '$column_style', '$column_extended_format' ) ";

                        $result = $xoopsDB->queryF($sql);
                        if (!$result) {
                            $dberr=true;
                            $dbmsg=formatDBError();
                        }
                        break;
                    default:
                        $dberr=true;
                        $dbmsg=_AD_GWREPORTS_AD_IMPORT_BADFILE;
                        break;
                }
            }

            if (!$dberr) {
                commitTransaction();
                $err_message = _AD_GWREPORTS_AD_IMPORT_OK;
                $dirname=$xoopsModule->getInfo('dirname');
                redirect_header(XOOPS_URL.'/modules/'.$dirname."/editreport.php?rid=$report_id", 3, $err_message);
            } else {
                rollbackTransaction();
                $err_message = _AD_GWREPORTS_AD_IMPORT_ERROR .' '.$dbmsg;
            }
        } else {
            $err_message=_AD_GWREPORTS_AD_IMPORT_BADFILE;
        }
    }

    if (isset($err_message)) {
        echo '<br /><b>'.$err_message.'</b><br />';
    }

    $token=true;

    $form = new XoopsThemeForm(_AD_GWREPORTS_AD_IMPORT_FORMNAME, 'form1', '', 'POST', $token);

    $caption = _AD_GWREPORTS_AD_IMPORT_FILENAME;
    $list_size = count($filelist)+1;
    if ($list_size>10) {
        $list_size=10;
    }
    $listbox = new XoopsFormSelect($caption, 'import_file', $import_file, $list_size, false);
    foreach ($filelist as $v) {
        $listbox->addOption($v, $v);
    }
    $form->addElement($listbox);
    $form->addElement(new XoopsFormButton('', 'submit', _AD_GWREPORTS_AD_IMPORT_BUTTON, 'submit'));

    //$form->display();
    $body=$form->render();

echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td width='100%' >";
echo $body;
echo '</td></tr>';
echo "</table>";


$dirname=$xoopsModule->getInfo('dirname');
$body='';
$body.='<br /><a href="'.XOOPS_URL.'/modules/'.$dirname.'/newreport.php">'._AD_GWREPORTS_ADMIN_REPORT_ADD.'</a>';
$body.=' | <a href="'.XOOPS_URL.'/modules/'.$dirname.'/newtopic.php">'._AD_GWREPORTS_ADMIN_TOPIC_ADD.'</a>';

echo $body;


//echo '<pre>$_POST='.print_r($_POST,true).'</pre>';
//echo '<pre>$_FILES='.print_r($_FILES,true).'</pre>';

xoops_cp_footer();
