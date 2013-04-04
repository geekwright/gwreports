<?php
// @version    $Id$
if (!defined("XOOPS_ROOT_PATH")) die("Root path not defined");
define('_MD_GWREPORTS_TITLE','gwreports');
define('_MD_GWREPORTS_TITLE_SEP',' : ');

// error messages
define('_MD_GWREPORTS_MSG_BAD_TOKEN','Expired or invalid security token in request.');
define('_MD_GWREPORTS_MISSING_PARAMETER','A required parameter is missing.');
define('_MD_GWREPORTS_NOT_AUTHORIZED','Not authorized.');

define('_MD_GWREPORTS_TOPIC_ADD_OK','Topic added.');
define('_MD_GWREPORTS_TOPIC_ADD_ERR','Could not add Topic.');
define('_MD_GWREPORTS_TOPIC_UPD_OK','Topic updated.');
define('_MD_GWREPORTS_TOPIC_UPD_ERR','Could not update Topic.');
define('_MD_GWREPORTS_TOPIC_NOTFOUND','Topic does not exist.');
define('_MD_GWREPORTS_TOPIC_DELETED','Topic deleted.');
define('_MD_GWREPORTS_TOPIC_EMPTY','No report topics found.');

define('_MD_GWREPORTS_REPORT_ADD_OK','Report added.');
define('_MD_GWREPORTS_REPORT_ADD_ERR','Could not add Report.');
define('_MD_GWREPORTS_REPORT_UPD_OK','Report updated.');
define('_MD_GWREPORTS_REPORT_UPD_ERR','Could not update Report.');
define('_MD_GWREPORTS_REPORT_NOTFOUND','Report does not exist.');
define('_MD_GWREPORTS_REPORT_DELETED','Report deleted.');
define('_MD_GWREPORTS_REPORT_EMPTY','No reports found in this topic.');

define('_MD_GWREPORTS_SECTION_ADD_OK','Section added.');
define('_MD_GWREPORTS_SECTION_ADD_ERR','Could not add Section.');
define('_MD_GWREPORTS_SECTION_UPD_OK','Section updated.');
define('_MD_GWREPORTS_SECTION_UPD_ERR','Could not update Section.');
define('_MD_GWREPORTS_SECTION_NOTFOUND','Section does not exist.');
define('_MD_GWREPORTS_SECTION_DELETED','Section deleted.');
define('_MD_GWREPORTS_SECTION_EMPTY','No data returned for this report section.');

define('_MD_GWREPORTS_PARAMETER_ADD_OK','Parameter added.');
define('_MD_GWREPORTS_PARAMETER_ADD_ERR','Could not add Parameter.');
define('_MD_GWREPORTS_PARAMETER_UPD_OK','Parameter updated.');
define('_MD_GWREPORTS_PARAMETER_UPD_ERR','Could not update Parameter.');
define('_MD_GWREPORTS_PARAMETER_NOTFOUND','Parameter does not exist.');
define('_MD_GWREPORTS_PARAMETER_DUPLICATE','A parameter with this name already exists.');
define('_MD_GWREPORTS_PARAMETER_DELETED','Parameter deleted.');
define('_MD_GWREPORTS_PARAMETER_RESERVED','Parameter name is reserved and cannot be used here.');

define('_MD_GWREPORTS_COLUMN_ADD_OK','Column format added.');
define('_MD_GWREPORTS_COLUMN_ADD_ERR','Could not add column format.');
define('_MD_GWREPORTS_COLUMN_UPD_OK','Column format updated.');
define('_MD_GWREPORTS_COLUMN_UPD_ERR','Could not update column format.');
define('_MD_GWREPORTS_COLUMN_NOTFOUND','Column format does not exist.');
define('_MD_GWREPORTS_COLUMN_DUPLICATE','A column format with this name already exists.');
define('_MD_GWREPORTS_COLUMN_DELETED','Column format deleted.');

define('_MD_GWREPORTS_RUNTIME_SQL_ERROR','An error (%s) has occurred while processing this report.');

// newreport
define('_MD_GWREPORTS_NEWREPORT_FORM','Add New Report');
define('_MD_GWREPORTS_NEWREPORT_ADD_BUTTON_DSC','Add Report');
define('_MD_GWREPORTS_NEWREPORT_ADD_BUTTON','Add');

// editreport
define('_MD_GWREPORTS_EDITREPORT_FORM','Edit Report');
define('_MD_GWREPORTS_EDITREPORT_UPD_BUTTON_DSC','Save Changes');
define('_MD_GWREPORTS_EDITREPORT_UPD_BUTTON','Save');
define('_MD_GWREPORTS_EDITREPORT_DEL_BUTTON','Delete');
define('_MD_GWREPORTS_EDITREPORT_DEL_CONFIRM','Delete this report?');

// newtopic
define('_MD_GWREPORTS_NEWTOPIC_FORM','Add New Topic');
define('_MD_GWREPORTS_NEWTOPIC_ADD_BUTTON_DSC','Add Topic');
define('_MD_GWREPORTS_NEWTOPIC_ADD_BUTTON','Add');

// edit topic
define('_MD_GWREPORTS_EDITTOPIC_FORM','Edit Topic');
define('_MD_GWREPORTS_EDITTOPIC_UPD_BUTTON_DSC','Save Changes');
define('_MD_GWREPORTS_EDITTOPIC_UPD_BUTTON','Save');
define('_MD_GWREPORTS_EDITTOPIC_DEL_BUTTON','Delete');
define('_MD_GWREPORTS_EDITTOPIC_DEL_CONFIRM','Delete this topic?');

// newsection
define('_MD_GWREPORTS_NEWSECTION_FORM','Add Report Section');
define('_MD_GWREPORTS_NEWSECTION_ADD_BUTTON_DSC','Add Section');
define('_MD_GWREPORTS_NEWSECTION_ADD_BUTTON','Add');

// edit section
define('_MD_GWREPORTS_EDITSECTION_FORM','Edit Section');
define('_MD_GWREPORTS_EDITSECTION_UPD_BUTTON_DSC','Save Changes');
define('_MD_GWREPORTS_EDITSECTION_UPD_BUTTON','Save');
define('_MD_GWREPORTS_EDITSECTION_DEL_BUTTON','Delete');
define('_MD_GWREPORTS_EDITSECTION_DEL_CONFIRM','Delete this section?');
define('_MD_GWREPORTS_EDITSECTION_LIMITED_FORM','View Section');

// newcolumn
define('_MD_GWREPORTS_NEWCOLUMN_FORM','Add Column Format');

// edit column
define('_MD_GWREPORTS_EDITCOLUMN_FORM','Edit Column Format');
define('_MD_GWREPORTS_EDITCOLUMN_UPD_BUTTON_DSC','Save Changes');
define('_MD_GWREPORTS_EDITCOLUMN_UPD_BUTTON','Save');
define('_MD_GWREPORTS_EDITCOLUMN_DEL_BUTTON','Delete');
define('_MD_GWREPORTS_EDITCOLUMN_DEL_CONFIRM','Delete column format?');

// newparameter
define('_MD_GWREPORTS_NEWPARAMETER_FORM','Add Report Parameter');
define('_MD_GWREPORTS_NEWPARAMETER_ADD_BUTTON_DSC','Add Parameter');
define('_MD_GWREPORTS_NEWPARAMETER_ADD_BUTTON','Add');

// newparameter
define('_MD_GWREPORTS_EDITPARAMETER_FORM','Edit Report Parameter');
define('_MD_GWREPORTS_EDITPARAMETER_UPD_BUTTON_DSC','Save Changes');
define('_MD_GWREPORTS_EDITPARAMETER_UPD_BUTTON','Save');
define('_MD_GWREPORTS_EDITPARAMETER_DEL_BUTTON','Delete');
define('_MD_GWREPORTS_EDITPARAMETER_DEL_CONFIRM','Delete this parameter?');
define('_MD_GWREPORTS_REPORT_TEST_DSC','Test Report');
define('_MD_GWREPORTS_REPORT_TEST_BUTTON','Test');
define('_MD_GWREPORTS_REPORT_RUN_DSC','Report Options');
define('_MD_GWREPORTS_REPORT_RUN_BUTTON','Run');
define('_MD_GWREPORTS_REPORT_PRINT_BUTTON','Print');
define('_MD_GWREPORTS_REPORT_SPREADSHEET_BUTTON','Spreadsheet');

// sort
define('_MD_GWREPORTS_SORT_UP', 'Move Up');
define('_MD_GWREPORTS_SORT_DOWN', 'Move Down');
define('_MD_GWREPORTS_SORT_REVERSE', 'Reverse');
define('_MD_GWREPORTS_SORT_SAVE', 'Save');
define('_MD_GWREPORTS_SORT_ACTIONS', 'Actions');
define('_MD_GWREPORTS_SORT_EMPTY', 'Nothing to Sort');

define('_MD_GWREPORTS_SORT_TOPIC_SELECT', 'Select a Topic to Move');
define('_MD_GWREPORTS_SORT_TOPIC_FORM', 'Reorder Topics');
define('_MD_GWREPORTS_SORT_TOPICS', 'Topics');

define('_MD_GWREPORTS_SORT_REPORT_SELECT', 'Select a Report to Move');
define('_MD_GWREPORTS_SORT_REPORT_FORM', 'Reorder Reports in a Topics');
define('_MD_GWREPORTS_SORT_REPORTS', 'Reports');

define('_MD_GWREPORTS_SORT_PARAMETER_SELECT', 'Select a Parameter to Move');
define('_MD_GWREPORTS_SORT_PARAMETER_FORM', 'Reorder Parameters');
define('_MD_GWREPORTS_SORT_PARAMETERS', 'Parameters');

define('_MD_GWREPORTS_SORT_SECTION_SELECT', 'Select a Section to Move');
define('_MD_GWREPORTS_SORT_SECTION_FORM', 'Reorder Report Sections');
define('_MD_GWREPORTS_SORT_SECTIONS', 'Sections');

// admin menus
define('_MD_GWREPORTS_ADMIN_MENU', 'Admin');
define('_MD_GWREPORTS_ADMIN_TOPIC', 'Topics');
define('_MD_GWREPORTS_ADMIN_TOPIC_ADD', 'Add Topic');
define('_MD_GWREPORTS_ADMIN_TOPIC_SORT', 'Reorder Topics');
define('_MD_GWREPORTS_ADMIN_REPORT', 'Reports');
define('_MD_GWREPORTS_ADMIN_REPORT_ADD', 'Add Report');
define('_MD_GWREPORTS_ADMIN_REPORT_SORT', 'Reorder Reports');
define('_MD_GWREPORTS_ADMIN_SECTION_ADD', 'Add Section');
define('_MD_GWREPORTS_ADMIN_SECTION_SORT', 'Reorder Sections');
define('_MD_GWREPORTS_ADMIN_PARAMETER_ADD', 'Add Parameter');
define('_MD_GWREPORTS_ADMIN_PARAMETER_SORT', 'Reorder Parameters');

// common field names
define('_MD_GWREPORTS_REPORT_NAME','Name');
define('_MD_GWREPORTS_REPORT_DESC','Description');
define('_MD_GWREPORTS_REPORT_ACTIVE','Is Active');
define('_MD_GWREPORTS_REPORT_SYSGROUP','Authorized Groups');
define('_MD_GWREPORTS_REPORT_TOPIC','Assign to Topic');
define('_MD_GWREPORTS_TOPIC_NAME','Report Topic');
define('_MD_GWREPORTS_TOPIC_DESC','Description');
define('_MD_GWREPORTS_TOPIC_LIST','Report Topics');
define('_MD_GWREPORTS_NO_TOPIC','(none)');
define('_MD_GWREPORTS_SECTION_NAME','Section Name');
define('_MD_GWREPORTS_SECTION_DESC','Description');
define('_MD_GWREPORTS_SECTION_LIST','Report Sections');
define('_MD_GWREPORTS_PARAMETER_NAME','Parameter Name');
define('_MD_GWREPORTS_PARAMETER_DESC','Description');
define('_MD_GWREPORTS_PARAMETER_LIST','Report Parameters');
define('_MD_GWREPORTS_PARAMETER_LIST_EMPTY','Report Tools');
define('_MD_GWREPORTS_PARAMETER_TITLE','Title to Display');
define('_MD_GWREPORTS_PARAMETER_DEFAULT','Default Value');
define('_MD_GWREPORTS_PARAMETER_TYPE','Parameter Type');
define('_MD_GWREPORTS_PARAMETER_REQUIRED','Required');
define('_MD_GWREPORTS_PARAMETER_LENGTH','Field Length');
define('_MD_GWREPORTS_PARAMETER_DECIMALS','Number of Decimal Places');
define('_MD_GWREPORTS_PARAMETER_SQL_FMT','To reference in SQL');

define('_MD_GWREPORTS_COLUMN_NAME','Column Name');
define('_MD_GWREPORTS_COLUMN_TITLE','Display Title');
define('_MD_GWREPORTS_COLUMN_HIDE','Hide this column?');
define('_MD_GWREPORTS_COLUMN_SUM','Sum this column?');
define('_MD_GWREPORTS_COLUMN_BREAK','Break on column change?');
define('_MD_GWREPORTS_COLUMN_OUTLINE','Outline column?');
define('_MD_GWREPORTS_COLUMN_APPLY_NL2BR','Convert newlines?');
define('_MD_GWREPORTS_COLUMN_IS_UNIXTIME','Column is Unix Time?');
define('_MD_GWREPORTS_COLUMN_FORMAT','sprintf() or date() format string');
define('_MD_GWREPORTS_COLUMN_STYLE','HTML/CSS style for column');
define('_MD_GWREPORTS_COLUMN_EXTENDED_FMT','Extended format');
define('_MD_GWREPORTS_COLUMN_LIST','Defined Column Formats');
define('_MD_GWREPORTS_COLUMN_AS_VAR','Extended format reference');

define('_MD_GWREPORTS_SECTION_REPORT_NAME','Report Name');
define('_MD_GWREPORTS_SECTION_MULTIROW','Section is Multirow');
define('_MD_GWREPORTS_SECTION_QUERY','SQL Query');
define('_MD_GWREPORTS_SECTION_SHOWTITLE','Show Section Name');
define('_MD_GWREPORTS_SECTION_SKIPEMPTY','Supress display if empty');


// Parameter Types
// enum('text','liketext','datetime','integer','yesno')
define('_MD_GWREPORTS_PARMTYPE_TEXT','Text');
define('_MD_GWREPORTS_PARMTYPE_LIKETEXT','Like Text');
define('_MD_GWREPORTS_PARMTYPE_DATE','Date');
//define('_MD_GWREPORTS_PARMTYPE_DATETIME','Date Time');
define('_MD_GWREPORTS_PARMTYPE_INTEGER','Integer');
define('_MD_GWREPORTS_PARMTYPE_DECIMAL','Decimal');
define('_MD_GWREPORTS_PARMTYPE_YESNO','Yes/No');

// limited mode messages
define('_MD_GWREPORTS_DISABLED', 'This function is not available.');

// new in 1.1
define('_MD_GWREPORTS_PARMTYPE_AUTOCOMPLETE','Auto Complete');
define('_MD_GWREPORTS_PARAMETER_SQLCHOICE','SQL Query for Auto Complete');
define('_MD_GWREPORTS_PARAMETER_SQLCHOICE_DESC','SQL query returning the autocomplete values as two columns, value and label. For example:<br/><i>select uid as value, uname as label from {$xpfx}xoops_users</i>');
define('_MD_GWREPORTS_SECTION_DATATOOLS', 'Enable data tools');
// for jQuery dataTables plugin used in datatools - _XX_ are parameters
define('_MD_GWREPORTS_JQDT_ALL','All');
define('_MD_GWREPORTS_JQDT_SLENGTHMENU', 'Display _MENU_ records');
define('_MD_GWREPORTS_JQDT_SSEARCH', 'Filter: _INPUT_');
define('_MD_GWREPORTS_JQDT_SINFO', 'Showing _START_ to _END_ of _TOTAL_ records');
define('_MD_GWREPORTS_JQDT_SINFOEMPTY', 'Nothing to show');
define('_MD_GWREPORTS_JQDT_SINFOFILTERED', ' (filtered from _MAX_ records)');
define('_MD_GWREPORTS_JQDT_SEMPTYTABLE', 'No data');
define('_MD_GWREPORTS_JQDT_SZERORECORDS', 'No records to show');
define('_MD_GWREPORTS_JQDT_SNEXT', 'Next');
define('_MD_GWREPORTS_JQDT_SPREVIOUS', 'Previous');
define('_MD_GWREPORTS_JQDT_SFIRST', 'First');
define('_MD_GWREPORTS_JQDT_SLAST', 'Last');
?>
