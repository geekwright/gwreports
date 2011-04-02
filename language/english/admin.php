<?php
// @version    $Id$
if (!defined("XOOPS_ROOT_PATH")) die("Root path not defined");
// Admin constants

// Admin Menu
define("_AD_GWREPORTS_ADMENU", "gwReports Menu");
define("_AD_GWREPORTS_AD_TOPIC", "Topics");
define("_AD_GWREPORTS_AD_REPORT", "Reports");
define('_AD_GWREPORTS_ADMENU_ABOUT', 'About');
define("_AD_GWREPORTS_ADMENU_PREF", "Preferences");
define("_AD_GWREPORTS_ADMENU_GOMOD", "Go To Module");
if (!defined("_MI_GWREPORTS_ADMENU")) {
@include_once dirname(__FILE__) . '/modinfo.php';
}


// Admin Report List
define('_AD_GWREPORTS_AD_REPORT_FORMNAME', 'Select Reports');
define('_AD_GWREPORTS_AD_REPORT_LIKE', 'Partial Report Name');
define('_AD_GWREPORTS_AD_REPORT_SEARCH_BUTTON', 'Search');
define('_AD_GWREPORTS_AD_REPORT_LISTNAME', 'Reports');
define('_AD_GWREPORTS_AD_REPORT_LISTEMPTY', 'No matching reports');
define('_AD_GWREPORTS_AD_REPORT_ID', 'ID');
define('_AD_GWREPORTS_AD_REPORT_NAME', 'Report Name');
define('_AD_GWREPORTS_AD_REPORT_ACTIVE', 'Active');

// Admin Topic List
define('_AD_GWREPORTS_AD_TOPIC_FORMNAME', 'Select Topic');
define('_AD_GWREPORTS_AD_TOPIC_LIKE', 'Partial Topic Name');
define('_AD_GWREPORTS_AD_TOPIC_SEARCH_BUTTON', 'Search');
define('_AD_GWREPORTS_AD_TOPIC_LISTNAME', 'Topics');
define('_AD_GWREPORTS_AD_TOPIC_LISTEMPTY', 'No matching topics');
define('_AD_GWREPORTS_AD_TOPIC_ID', 'ID');
define('_AD_GWREPORTS_AD_TOPIC_NAME', 'Topic Name');
define('_AD_GWREPORTS_AD_TOPIC_OPTION', 'Option');

// admin menus
define('_AD_GWREPORTS_ADMIN_MENU', 'Admin');
define('_AD_GWREPORTS_ADMIN_TOPIC', 'Topics');
define('_AD_GWREPORTS_ADMIN_TOPIC_ADD', 'Add Topic');
define('_AD_GWREPORTS_ADMIN_TOPIC_SORT', 'Reorder Topics');
define('_AD_GWREPORTS_ADMIN_REPORT', 'Reports');
define('_AD_GWREPORTS_ADMIN_REPORT_ADD', 'Add Report');
define('_AD_GWREPORTS_ADMIN_REPORT_SORT', 'Reorder Reports');
define('_AD_GWREPORTS_ADMIN_SECTION_ADD', 'Add Section');
define('_AD_GWREPORTS_ADMIN_SECTION_SORT', 'Reorder Sections');
define('_AD_GWREPORTS_ADMIN_PARAMETER_ADD', 'Add Parameter');
define('_AD_GWREPORTS_ADMIN_PARAMETER_SORT', 'Reorder Parameters');

// todo list messages
define('_AD_GWREPORTS_TODO_TITLE', 'Action Required');
define('_AD_GWREPORTS_TODO_ACTION', 'Action');
define('_AD_GWREPORTS_TODO_MESSAGE', 'Message');
?>