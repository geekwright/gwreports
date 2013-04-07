<?php
/**
* update.php - tweaks on module update
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

if (!defined("XOOPS_ROOT_PATH")) die("Root path not defined");

function xoops_module_update_gwreports(&$module, $old_version) {
global $xoopsDB;

	if($old_version<102) {
		$sql=    'ALTER TABLE '.$xoopsDB->prefix('gwreports_parameter')." CHANGE parameter_type parameter_type enum('text','liketext','date','integer','yesno','decimal','autocomplete') NOT NULL default 'text'";
		$xoopsDB->queryF($sql);

		$sql='ALTER TABLE '.$xoopsDB->prefix('gwreports_parameter').' CHANGE sqlchoice parameter_sqlchoice text NOT NULL';
		$xoopsDB->queryF($sql);

		$sql='ALTER TABLE '.$xoopsDB->prefix('gwreports_parameter').' ADD COLUMN parameter_sqlchoice text NOT NULL AFTER parameter_decimals';
		$xoopsDB->queryF($sql);

		$sql='ALTER TABLE '.$xoopsDB->prefix('gwreports_section').' ADD COLUMN section_datatools tinyint unsigned NOT NULL default \'0\' AFTER section_skipempty';
		$xoopsDB->queryF($sql);
	}
	
    return true;
}

?>
