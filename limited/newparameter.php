<?php
/**
* newparameter.php - stub for limited mode
*
* This file is part of gwreports - geekwright Reports
*
* @copyright  Copyright © 2013 geekwright, LLC. All rights reserved. 
* @license    gwreports/docs/license.txt  GNU General Public License (GPL)
* @since      1.1
* @author     Richard Griffith <richard@geekwright.com>
* @package    gwreports
* @version    $Id$
*/

include '../../mainfile.php';
if(isset($_GET['rid'])) {
	$rid = intval($_GET['rid']);
	redirect_header("editreport.php?rid=$rid", 3, _MD_GWREPORTS_DISABLED);
}
else redirect_header('admin/index.php', 3, _MD_GWREPORTS_DISABLED);
exit;
?>
