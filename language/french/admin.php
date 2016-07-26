<?php
// @version    $Id: admin.php 15 2011-05-19 23:37:21Z rgriffith $
if (!defined("XOOPS_ROOT_PATH")) {
    die("Root path not defined");
}
// Admin constants

// Admin Menu
define("_AD_GWREPORTS_ADMENU", "Menu");
define("_AD_GWREPORTS_AD_TOPIC", "Sujets");
define("_AD_GWREPORTS_AD_REPORT", "Rapports");
define("_AD_GWREPORTS_AD_EXPLORE", "Explore");
define('_AD_GWREPORTS_ADMENU_ABOUT', 'A propos');
define("_AD_GWREPORTS_ADMENU_PREF", "Pr&eacute;f&eacute;rences");
define("_AD_GWREPORTS_ADMENU_GOMOD", "Aller au module");
if (!defined("_MI_GWREPORTS_ADMENU")) {
    @include_once dirname(__FILE__) . '/modinfo.php';
}


// Admin Report List
define('_AD_GWREPORTS_AD_REPORT_FORMNAME', 'Selectionner un rapport');
define('_AD_GWREPORTS_AD_REPORT_LIKE', 'Nom partiel du rapport');
define('_AD_GWREPORTS_AD_REPORT_SEARCH_BUTTON', 'Rechercher');
define('_AD_GWREPORTS_AD_REPORT_LISTNAME', 'Rapports');
define('_AD_GWREPORTS_AD_REPORT_LISTEMPTY', 'Aucun rapport correspondant');
define('_AD_GWREPORTS_AD_REPORT_ID', 'ID');
define('_AD_GWREPORTS_AD_REPORT_NAME', 'Nom du Rapport');
define('_AD_GWREPORTS_AD_REPORT_ACTIVE', 'Actif');
define('_AD_GWREPORTS_AD_REPORT_OPTIONS', 'Options');
define('_AD_GWREPORTS_AD_REPORT_EXPORT', 'Export');
define('_AD_GWREPORTS_AD_REPORT_IMPORT', 'Import');

// Admin Report Import
define('_AD_GWREPORTS_AD_IMPORT_FORMNAME', 'Importer une d&eacute;finition de rapport');
define('_AD_GWREPORTS_AD_IMPORT_FILENAME', 'Fichier rapport &agrave; importer');
define('_AD_GWREPORTS_AD_IMPORT_BUTTON', 'Importer');
define('_AD_GWREPORTS_AD_IMPORT_ERROR', 'Import impossible');
define('_AD_GWREPORTS_AD_IMPORT_BADFILE', 'fichier non compatible (doit être un fichier export&eacute; pr&eacute;c&eacute;demment)');
define('_AD_GWREPORTS_AD_IMPORT_OK', 'Rapport import&eacute;');

// Admin Explore
define('_AD_GWREPORTS_AD_EXPLORE_FORMNAME', 'Explorer les Databases');
define('_AD_GWREPORTS_AD_EXPLORE_DATABASE', 'Database');
define('_AD_GWREPORTS_AD_EXPLORE_PICKDB', '(Choisissez une Database)');
define('_AD_GWREPORTS_AD_EXPLORE_TABLES', 'Tables');
define('_AD_GWREPORTS_AD_EXPLORE_QUERY', 'Requ&egrave;te g&eacute;n&eacute;r&eacute;e');
define('_AD_GWREPORTS_AD_EXPLORE_BUTTON', 'S&eacute;lectionner');
define('_AD_GWREPORTS_AD_EXPLORE_ERROR', 'Erreur d\'exploration.');

// Admin Topic List
define('_AD_GWREPORTS_AD_TOPIC_FORMNAME', 'Selectionner un sujet');
define('_AD_GWREPORTS_AD_TOPIC_LIKE', 'Nom partiel du sujet');
define('_AD_GWREPORTS_AD_TOPIC_SEARCH_BUTTON', 'Rechercher');
define('_AD_GWREPORTS_AD_TOPIC_LISTNAME', 'Sujets');
define('_AD_GWREPORTS_AD_TOPIC_LISTEMPTY', 'Pas de sujets correspondant');
define('_AD_GWREPORTS_AD_TOPIC_ID', 'ID');
define('_AD_GWREPORTS_AD_TOPIC_NAME', 'Nom du sujet');
define('_AD_GWREPORTS_AD_TOPIC_OPTION', 'Option');

// admin menus
define('_AD_GWREPORTS_ADMIN_MENU', 'Admin');
define('_AD_GWREPORTS_ADMIN_TOPIC', 'Sujets');
define('_AD_GWREPORTS_ADMIN_TOPIC_ADD', 'Ajouter un sujet');
define('_AD_GWREPORTS_ADMIN_TOPIC_SORT', 'R&eacute;ordonner les sujets');
define('_AD_GWREPORTS_ADMIN_REPORT', 'Rapports');
define('_AD_GWREPORTS_ADMIN_REPORT_ADD', 'Ajouter un rapport');
define('_AD_GWREPORTS_ADMIN_REPORT_SORT', 'R&eacute;ordonner les rapports');
define('_AD_GWREPORTS_ADMIN_SECTION_ADD', 'Ajouter une Section');
define('_AD_GWREPORTS_ADMIN_SECTION_SORT', 'R&eacute;ordonner les Sections');
define('_AD_GWREPORTS_ADMIN_PARAMETER_ADD', 'Ajouter un param&egrave;tre');
define('_AD_GWREPORTS_ADMIN_PARAMETER_SORT', 'R&eacute;ordonner les param&egrave;tres');

// todo list messages
define('_AD_GWREPORTS_TODO_TITLE', 'Action Requise');
define('_AD_GWREPORTS_TODO_ACTION', 'Action');
define('_AD_GWREPORTS_TODO_MESSAGE', 'Message');
define('_AD_GWREPORTS_AD_TODO_RETRY', 'Recommencer');
define('_AD_GWREPORTS_AD_TODO_MYSQL', 'MySQL version %1$s ou plus est requis. (D&eacute;tect&eacute; = %2$s)');
define('_AD_GWREPORTS_AD_TODO_INNODB', 'Support de InnoDB dans MySQL requis.');

// limited mode messages
define('_AD_GWREPORTS_DISABLED', 'Cette fonction n\est pas disponible.');
define('_AD_GWREPORTS_NO_IMPORT_DIR', 'Le r&eacute;pertoire d\'import n\'existe pas, merci de cr&eacute;er le r&eacute;pertoire <br />%s');
define('_AD_GWREPORTS_EMPTY_IMPORT_DIR', 'Le r&eacute;pertoire d\'import est vide.');
define('_AD_GWREPORTS_LIMITED_MODE', 'Cette installation s\'execute en mode limit&eacute;.');

// new in 1.1 -- need verification
// about and menu strings
define('_AD_GW_ABOUT_ABOUT', 'A propos');
define('_AD_GW_ABOUT_AUTHOR', 'par');
define('_AD_GW_ABOUT_CREDITS', 'Cr&eacute;dits');
define('_AD_GW_ABOUT_LICENSE', 'Licence:');
define('_AD_GW_ADMENU_PREF', 'Pr&eacute;f&eacute;rences');
define('_AD_GW_ADMENU_GOMOD', 'Aller à Module');
define('_AD_GW_ADMENU_HELP', 'Page d\'aide');
define('_AD_GW_ADMENU_TOADMIN', 'Retour &agrave; l\'administration du module');
define('_AD_GW_ADMENU_WELCOME', 'Bienvenue sur gwreports!');
define('_AD_GW_ADMENU_MESSAGE', '<img src="../images/icon_big.png" alt="Logo" style="float:left; margin-right:2em;" /> G&eacute;n&eacute;rateur de rapports');

define('_AD_GWREPORTS_BAD_TOKEN', 'Le jeton de s&eacute;curit&eacute; n\'est pas valide.');
