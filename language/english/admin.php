<?php
// @version    $Id$
if (!defined("XOOPS_ROOT_PATH")) die("Root path not defined");
// Admin constants

// Admin Menu
define("_AD_GWREPORTS_ADMENU", "gwReports Menu");
define("_AD_GWREPORTS_AD_TOPIC", "Topics");
define("_AD_GWREPORTS_AD_REPORT", "Reports");
define("_AD_GWREPORTS_AD_EXPLORE", "Explore");
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
define('_AD_GWREPORTS_AD_REPORT_OPTIONS', 'Options');
define('_AD_GWREPORTS_AD_REPORT_EXPORT', 'Export');
define('_AD_GWREPORTS_AD_REPORT_IMPORT', 'Import');

// Admin Report Import
define('_AD_GWREPORTS_AD_IMPORT_FORMNAME', 'Import Report Definition');
define('_AD_GWREPORTS_AD_IMPORT_FILENAME', 'Report File to Import');
define('_AD_GWREPORTS_AD_IMPORT_BUTTON', 'Import');
define('_AD_GWREPORTS_AD_IMPORT_ERROR', 'Import Failed');
define('_AD_GWREPORTS_AD_IMPORT_BADFILE', 'Not a report export file');
define('_AD_GWREPORTS_AD_IMPORT_OK', 'Report imported');

// Admin Explore
define('_AD_GWREPORTS_AD_EXPLORE_FORMNAME', 'Explore Databases');
define('_AD_GWREPORTS_AD_EXPLORE_DATABASE', 'Database');
define('_AD_GWREPORTS_AD_EXPLORE_PICKDB', '(Choose a Database)');
define('_AD_GWREPORTS_AD_EXPLORE_TABLES', 'Tables');
define('_AD_GWREPORTS_AD_EXPLORE_QUERY', 'Generated Query');
define('_AD_GWREPORTS_AD_EXPLORE_BUTTON', 'Draw');
define('_AD_GWREPORTS_AD_EXPLORE_ERROR', 'Something isn\'t right here.');

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