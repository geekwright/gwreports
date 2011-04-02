<?php
/**
* xoops_version.php - xoops module definition
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

$modversion['name'] = _MI_GWREPORTS_NAME;
$modversion['version'] = '0.1';
$modversion['description'] = _MI_GWREPORTS_DESC;
$modversion['credits'] = "geekwight, LLC";
$modversion['help'] = "";
$modversion['license'] = "GPL V2";
$modversion['official'] = 0;
$modversion['image'] = "images/icon_big.png";
$modversion['dirname'] = basename( dirname( __FILE__ ) ) ;

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 1;

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "gwreports_search";

// comments
$modversion['hasComments'] = 0;
// notification
$modversion['hasNotification'] = 0;
// Config

$modversion['config'][1] = array(
	'name'			=> 'index_text' ,
	'title'			=> '_MI_GWREPORTS_INDEX_TEXT' ,
	'description'	=> '_MI_GWREPORTS_INDEX_TEXT_DSC' ,
	'formtype'		=> 'textarea' ,
	'valuetype'		=> 'text' ,
	'default'		=> '' ,
	'options'		=> array()
) ;
$modversion['config'][] = array(
	'name'			=> 'show_breadcrumbs' ,
	'title'			=> '_MI_GWREPORTS_SHOW_BREADCRUMBS' ,
	'description'	=> '_MI_GWREPORTS_SHOW_BREADCRUMBS_DSC' ,
	'formtype'		=> 'yesno' ,
	'valuetype'		=> 'int' ,
	'default'		=> '1' ,
	'options'		=> array()
) ;

// Database
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['onInstall'] = 'include/install.php';
$modversion['onUpdate'] = 'include/update.php';
$modversion['onUninstall'] = 'include/uninstall.php';
$modversion['tables'][0] = 'gwreports_report';
$modversion['tables'][]  = 'gwreports_access';
$modversion['tables'][]  = 'gwreports_parameter';
$modversion['tables'][]  = 'gwreports_section';
$modversion['tables'][]  = 'gwreports_topic';
$modversion['tables'][]  = 'gwreports_grouping';
$modversion['tables'][]  = 'gwreports_column';

// Blocks 
$modversion['blocks'][1] = array(
  'file' => 'blocks.php',
  'name' => _MI_GWREPORTS_BLOCK_TOPIC,
  'description' => _MI_GWREPORTS_BLOCK_TOPIC_DESC,
  'show_func' => 'b_gwreports_block_topic_show',
  'edit_func' => 'b_gwreports_block_topic_edit',
  'options' => 'options',
  'template' => 'gwreports_block_topic.html');

$modversion['blocks'][] = array(
  'file' => 'blocks.php',
  'name' => _MI_GWREPORTS_BLOCK_QUICK_REPORT,
  'description' => _MI_GWREPORTS_BLOCK_QUICK_REPORT_DESC,
  'show_func' => 'b_gwreports_block_quick_report_show',
  'edit_func' => 'b_gwreports_block_quick_report_edit',
  'options' => 'options',
  'template' => 'gwreports_block_quick_report.html');

// Templates
$modversion['templates'][1] = array(
  'file' => 'gwreports_index.html',
  'description' => 'Module Index' );

$modversion['templates'][] = array(
  'file' => 'gwreports_columnedit.html',
  'description' => 'Column Manager' );

$modversion['templates'][] = array(
  'file' => 'gwreports_reportedit.html',
  'description' => 'Report Manager' );

$modversion['templates'][] = array(
  'file' => 'gwreports_reportview.html',
  'description' => 'Report Viewer' );

$modversion['templates'][] = array(
  'file' => 'gwreports_reportprint.html',
  'description' => 'Report Print' );

$modversion['templates'][] = array(
  'file' => 'gwreports_sectionedit.html',
  'description' => 'Report Section Manager' );

$modversion['templates'][] = array(
  'file' => 'gwreports_topic.html',
  'description' => 'Topic Manager' );

?>
