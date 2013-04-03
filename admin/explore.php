<?php
/**
* explore.php - show available database and table information
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

	if($xoop25plus) {
		echo $moduleAdmin->addNavigation('explore.php');
	} else {
		adminmenu(5);
	}

function getDatabaseList() {

	global $xoopsDB;
	$databases=array();

	$sql='SHOW DATABASES';

	$result = $xoopsDB->queryF($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchRow($result)) {
			$databases[$myrow[0]] = $myrow[0];
		}
	}
	return $databases;
}

function getTableList($database) {

	global $xoopsDB;
	$tables=array();

	$sql='SHOW TABLES FROM '.dbescape($database);


	$result = $xoopsDB->queryF($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchRow($result)) {
			$tables[$myrow[0]] = $myrow[0];
		}
	}
	return $tables;
}

function getBasicQuery($database,$table,&$lines,&$rptname) {

	global $xoopsDB;
	$query=''; $where='';
	$sql='SHOW COLUMNS FROM '.dbescape($database).'.'.dbescape($table);

	$result = $xoopsDB->queryF($sql);
	if ($result) {
		$prefix='SELECT ';
		$whereprefix='WHERE ';
		while($myrow=$xoopsDB->fetchArray($result)) {
			++$lines;
			$line=$prefix.$myrow['Field'].' -- '.$myrow['Type']."\n";
			$query.=$line;
			$prefix=', ';
			if($myrow['Key']=='PRI') {
				if((stristr($myrow['Type'], 'int') === FALSE) 
					&& (stristr($myrow['Type'], 'dec') === FALSE)
					&& (stristr($myrow['Type'], 'float') === FALSE)){ // text
					$where.=$whereprefix.$myrow['Field'].' = \'{'.$myrow['Field']."}'\n";
				} else { 
					$where.=$whereprefix.$myrow['Field'].' = {'.$myrow['Field']."}\n";
				}
				++$lines;
				$whereprefix=' AND ';
			}
		}
		++$lines;
		$dbstring=$database.'.';
		$tbstring=$table;
		if(XOOPS_DB_NAME==$database) {
			$dbstring='';
			$pfxlen=strlen(XOOPS_DB_PREFIX)+1;
			if(substr($table,0,$pfxlen)==(XOOPS_DB_PREFIX.'_')) {
				$rptname=substr($table,$pfxlen); // strip prefix if used for add report
				$tbstring='{$xpfx}'.$rptname;
			}
		}
		$line='FROM '.$dbstring.$tbstring."\n";
		$query.=$line;
		$query.=$where;
	}
	return $query;
}

	$database='';
	if(isset($_POST['database'])) $database = substr(cleaner($_POST['database']),3);
	$table='';
	if(isset($_POST['table'])) $table = cleaner($_POST['table']);


	$token=0;

	$form = new XoopsThemeForm(_AD_GWREPORTS_AD_EXPLORE_FORMNAME, 'formdb', 'explore.php', 'POST', $token);

	// XoopsFormSelect( string $caption, string $name, [mixed $value = null], [int $size = 1], [bool $multiple = false])
	$caption = _AD_GWREPORTS_AD_EXPLORE_DATABASE;
	$databases=getDatabaseList();
	if(!isset($databases[$database])) $database=''; // not a valid database
	$dblistbox = new XoopsFormSelect($caption, 'database', 'db_'.$database, 1, false);
	$dblistbox->addOption('', _AD_GWREPORTS_AD_EXPLORE_PICKDB);
	foreach ($databases as $i) {
		$dblistbox->addOption('db_'.$i, $i);
	}
	$dblistbox->setExtra('onChange="document.formdb.submit();return true;" ');
	$form->addElement($dblistbox);

	if($database!='') {
		$tables=getTableList($database);
		$caption = _AD_GWREPORTS_AD_EXPLORE_TABLES;
		$list_size = count($tables);
		if($list_size>10) $list_size=10;
		if(!isset($tables[$table])) $table=''; // not a valid table
		$tablelistbox = new XoopsFormSelect($caption, 'table', $table, $list_size, false);
		foreach ($tables as $i) {
			$tablelistbox->addOption($i, $i);
		}
		$tablelistbox->setExtra('onChange="document.formdb.submit()"');
		$form->addElement($tablelistbox);
	}

	$form->addElement(new XoopsFormButton('', 'draw', _AD_GWREPORTS_AD_EXPLORE_BUTTON, 'submit'));

	$form1=$form->render();

	$form2='';
	if($database!='' && $table!='') {
		unset($form);
		$form = new XoopsThemeForm(_AD_GWREPORTS_AD_EXPLORE_QUERY, 'formqry', '../newreport.php', 'POST', $token);

		$line=2;
		$rptname=$table;
		$query=getBasicQuery($database,$table,$lines,$rptname);
		$caption = _AD_GWREPORTS_AD_EXPLORE_QUERY;
		$form->addElement(new XoopsFormTextArea($caption, 'section_query', $query, $lines, 50  ));

		$form->addElement(new XoopsFormHidden( 'report_name',$rptname));
		$form->addElement(new XoopsFormButton('', 'notsubmit', _AD_GWREPORTS_ADMIN_REPORT_ADD, 'submit'));

		$form2=$form->render();
	}

echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td width='100%' >";
echo $form1;
echo '</td></tr>';
if($form2!='') echo '<tr><td>'.$form2.'</td></tr>';
echo "</table>";


$dirname=$xoopsModule->getInfo('dirname');
$body='';
$body.='<br /><a href="'.XOOPS_URL.'/modules/'.$dirname.'/newreport.php">'._AD_GWREPORTS_ADMIN_REPORT_ADD.'</a>';
$body.=' | <a href="import.php">'._AD_GWREPORTS_AD_REPORT_IMPORT.'</a>';
$body.=' | <a href="'.XOOPS_URL.'/modules/'.$dirname.'/newtopic.php">'._AD_GWREPORTS_ADMIN_TOPIC_ADD.'</a>';
//echo $body;

//echo '<pre>$_POST='.print_r($_POST,true).'</pre>';
include 'footer.php';
?>
