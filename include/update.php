<?php
/**
* update.php - tweaks on module update
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

if (!defined("XOOPS_ROOT_PATH")) die("XOOPS root path not defined");

function xoops_module_update_gwreports(&$module, $old_version) {
// currently nothing to do
    $module->setErrors("Update Post-Process Completed");
    return true;
}

?>