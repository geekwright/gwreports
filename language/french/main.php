<?php
// @version    $Id: main.php 10 2011-05-12 22:42:27Z rgriffith $
if (!defined("XOOPS_ROOT_PATH")) die("Root path not defined");
define('_MD_GWREPORTS_TITLE','Gestionnaire de rapports');
define('_MD_GWREPORTS_TITLE_SEP',' : ');

// error messages
define('_MD_GWREPORTS_MSG_BAD_TOKEN','Jeton de s&eacute;curit&eacute; expir&eacute;.');
define('_MD_GWREPORTS_MISSING_PARAMETER','Un param&egrave;tre requis est manquant.');
define('_MD_GWREPORTS_NOT_AUTHORIZED','Non autoris&eacute;.');

define('_MD_GWREPORTS_TOPIC_ADD_OK','Sujet ajout&eacute;.');
define('_MD_GWREPORTS_TOPIC_ADD_ERR','Ajout du sujet impossible.');
define('_MD_GWREPORTS_TOPIC_UPD_OK','Sujet mis &agrave; jour.');
define('_MD_GWREPORTS_TOPIC_UPD_ERR','Mise &agrave; jour du sujet impossible.');
define('_MD_GWREPORTS_TOPIC_NOTFOUND','Sujet inexistant.');
define('_MD_GWREPORTS_TOPIC_DELETED','Sujet supprim&eacute;.');
define('_MD_GWREPORTS_TOPIC_EMPTY','Aucun rapport dans ce sujet.');

define('_MD_GWREPORTS_REPORT_ADD_OK','Rapport ajout&eacute;.');
define('_MD_GWREPORTS_REPORT_ADD_ERR','Ajout du rapport impossible.');
define('_MD_GWREPORTS_REPORT_UPD_OK','Rapport mis &agrave; jour.');
define('_MD_GWREPORTS_REPORT_UPD_ERR','Mise &agrave; jour du rapport impossible.');
define('_MD_GWREPORTS_REPORT_NOTFOUND','Rapport inexistant.');
define('_MD_GWREPORTS_REPORT_DELETED','Rapport supprim&eacute;.');
define('_MD_GWREPORTS_REPORT_EMPTY','Aucun rapport dans ce sujet.');

define('_MD_GWREPORTS_SECTION_ADD_OK','Section ajout&eacute;e.');
define('_MD_GWREPORTS_SECTION_ADD_ERR','Ajout de section impossible.');
define('_MD_GWREPORTS_SECTION_UPD_OK','Section mise &agrave; jour.');
define('_MD_GWREPORTS_SECTION_UPD_ERR','Mise &agrave; jour de la section impossible.');
define('_MD_GWREPORTS_SECTION_NOTFOUND','Section inexistante.');
define('_MD_GWREPORTS_SECTION_DELETED','Section supprim&eacute;e.');
define('_MD_GWREPORTS_SECTION_EMPTY','Aucune donn&eacute;e retourn&eacute;e pour cette section de rapport.');

define('_MD_GWREPORTS_PARAMETER_ADD_OK','Param&egrave;tre ajout&eacute;.');
define('_MD_GWREPORTS_PARAMETER_ADD_ERR','Ajout de param&egrave;tre impossible.');
define('_MD_GWREPORTS_PARAMETER_UPD_OK','Param&egrave;tre mis &agrave; jour.');
define('_MD_GWREPORTS_PARAMETER_UPD_ERR','Mise &agrave; jour param&egrave;tre impossible.');
define('_MD_GWREPORTS_PARAMETER_NOTFOUND','Param&egrave;tre inexistant.');
define('_MD_GWREPORTS_PARAMETER_DUPLICATE','Un param&egrave;tre avec ce nom existe d&eacute;j&agrave;.');
define('_MD_GWREPORTS_PARAMETER_DELETED','Param&egrave;tre supprim&eacute;.');
define('_MD_GWREPORTS_PARAMETER_RESERVED','Nom de param&egrave;tre r&eacute;serv&eacute;, inutilisable &agrave; cet endroit.');

define('_MD_GWREPORTS_COLUMN_ADD_OK','Format de colonne ajout&eacute;.');
define('_MD_GWREPORTS_COLUMN_ADD_ERR','Ajout de format de colonne impossible.');
define('_MD_GWREPORTS_COLUMN_UPD_OK','Format de colonne mis &agrave; jour.');
define('_MD_GWREPORTS_COLUMN_UPD_ERR','Mise &agrave; jour  format de colonne impossible.');
define('_MD_GWREPORTS_COLUMN_NOTFOUND','Format de colonne inexistant.');
define('_MD_GWREPORTS_COLUMN_DUPLICATE','un format de colonne avec ce nom existe d&eacute;j&agrave;.');
define('_MD_GWREPORTS_COLUMN_DELETED','Format de colonne supprim&eacute;.');

define('_MD_GWREPORTS_RUNTIME_SQL_ERROR','Une erreur (%s) s\'est produite durant la g&eacute;n&eacute;ration de ce rapport.');

// newreport
define('_MD_GWREPORTS_NEWREPORT_FORM','Ajouter un nouveau rapport');
define('_MD_GWREPORTS_NEWREPORT_ADD_BUTTON_DSC','Ajouter un rapport');
define('_MD_GWREPORTS_NEWREPORT_ADD_BUTTON','Ajouter');

// editreport
define('_MD_GWREPORTS_EDITREPORT_FORM','Edition du rapport');
define('_MD_GWREPORTS_EDITREPORT_UPD_BUTTON_DSC','Sauvegarder les changements');
define('_MD_GWREPORTS_EDITREPORT_UPD_BUTTON','Sauve');
define('_MD_GWREPORTS_EDITREPORT_DEL_BUTTON','Supprimer');
define('_MD_GWREPORTS_EDITREPORT_DEL_CONFIRM','Supprimer ce rapport ?');

// newtopic
define('_MD_GWREPORTS_NEWTOPIC_FORM','Ajouter un nouveau sujet');
define('_MD_GWREPORTS_NEWTOPIC_ADD_BUTTON_DSC','Ajouter un sujet');
define('_MD_GWREPORTS_NEWTOPIC_ADD_BUTTON','Ajouter');

// edit topic
define('_MD_GWREPORTS_EDITTOPIC_FORM','Edition du sujet');
define('_MD_GWREPORTS_EDITTOPIC_UPD_BUTTON_DSC','Sauvegarder les changements');
define('_MD_GWREPORTS_EDITTOPIC_UPD_BUTTON','Sauve');
define('_MD_GWREPORTS_EDITTOPIC_DEL_BUTTON','Supprimer');
define('_MD_GWREPORTS_EDITTOPIC_DEL_CONFIRM','Supprimer ce sujet ?');

// newsection
define('_MD_GWREPORTS_NEWSECTION_FORM','Ajouter une section');
define('_MD_GWREPORTS_NEWSECTION_ADD_BUTTON_DSC','Ajouter section');
define('_MD_GWREPORTS_NEWSECTION_ADD_BUTTON','Ajouter');

// edit section
define('_MD_GWREPORTS_EDITSECTION_FORM','Modifier une section');
define('_MD_GWREPORTS_EDITSECTION_UPD_BUTTON_DSC','Sauvegarder les modifications');
define('_MD_GWREPORTS_EDITSECTION_UPD_BUTTON','Sauver');
define('_MD_GWREPORTS_EDITSECTION_DEL_BUTTON','Supprimer');
define('_MD_GWREPORTS_EDITSECTION_DEL_CONFIRM','Supprimer cette section ?');
define('_MD_GWREPORTS_EDITSECTION_LIMITED_FORM','Voir la section');

// newcolumn
define('_MD_GWREPORTS_NEWCOLUMN_FORM','Ajouter Format de colonne');

// edit column
define('_MD_GWREPORTS_EDITCOLUMN_FORM','Modifier format de colonne');
define('_MD_GWREPORTS_EDITCOLUMN_UPD_BUTTON_DSC','Sauvegarder les modifications');
define('_MD_GWREPORTS_EDITCOLUMN_UPD_BUTTON','Sauve');
define('_MD_GWREPORTS_EDITCOLUMN_DEL_BUTTON','Supprimer');
define('_MD_GWREPORTS_EDITCOLUMN_DEL_CONFIRM','Supprimer ce format de colonne ?');

// newparam&egrave;tre
define('_MD_GWREPORTS_NEWPARAMETER_FORM','Ajouter un param&egrave;tre au rapport');
define('_MD_GWREPORTS_NEWPARAMETER_ADD_BUTTON_DSC','Ajouter param&egrave;tre');
define('_MD_GWREPORTS_NEWPARAMETER_ADD_BUTTON','Ajouter');

// newparam&egrave;tre
define('_MD_GWREPORTS_EDITPARAMETER_FORM','Modifier un param&egrave;tre de rapport');
define('_MD_GWREPORTS_EDITPARAMETER_UPD_BUTTON_DSC','Sauvegarder les modifications');
define('_MD_GWREPORTS_EDITPARAMETER_UPD_BUTTON','Sauve');
define('_MD_GWREPORTS_EDITPARAMETER_DEL_BUTTON','Supprimer');
define('_MD_GWREPORTS_EDITPARAMETER_DEL_CONFIRM','Supprimer ce param&egrave;tre ?');
//define('_MD_GWREPORTS_REPORT_TEST_DSC','Tester le rapport');
define('_MD_GWREPORTS_REPORT_TEST_DSC',''); // surcharge inutile avec le bouton 'tester'
//define('_MD_GWREPORTS_REPORT_TEST_BUTTON','Test');
define('_MD_GWREPORTS_REPORT_TEST_BUTTON','Tester le rapport');
define('_MD_GWREPORTS_REPORT_RUN_DSC','Options du rapport');
define('_MD_GWREPORTS_REPORT_RUN_BUTTON','Ex&eacute;cuter');
define('_MD_GWREPORTS_REPORT_PRINT_BUTTON','Imprimer');
define('_MD_GWREPORTS_REPORT_SPREADSHEET_BUTTON','Exporter (XLS)');

// sort
define('_MD_GWREPORTS_SORT_UP', 'Monter');
define('_MD_GWREPORTS_SORT_DOWN', 'Descendre');
define('_MD_GWREPORTS_SORT_REVERSE', 'Inverser');
define('_MD_GWREPORTS_SORT_SAVE', 'Sauve');
define('_MD_GWREPORTS_SORT_ACTIONS', 'Actions');
define('_MD_GWREPORTS_SORT_EMPTY', 'Rien &agrave; trier');

define('_MD_GWREPORTS_SORT_TOPIC_SELECT', 'Selectionner un sujet &agrave; d&eacute;placer');
define('_MD_GWREPORTS_SORT_TOPIC_FORM', 'R&eacute;ordonner les sujets');
define('_MD_GWREPORTS_SORT_TOPICS', 'Sujets');

define('_MD_GWREPORTS_SORT_REPORT_SELECT', 'Selectionner un rapport &agrave; d&eacute;placer');
define('_MD_GWREPORTS_SORT_REPORT_FORM', 'R&eacute;ordonner les rapports dans un sujet');
define('_MD_GWREPORTS_SORT_REPORTS', 'Rapports');

define('_MD_GWREPORTS_SORT_PARAMETER_SELECT', 'Selectionner un param&egrave;tre &agrave; d&eacute;placer');
define('_MD_GWREPORTS_SORT_PARAMETER_FORM', 'R&eacute;ordonner param&egrave;tres');
define('_MD_GWREPORTS_SORT_PARAMETERS', 'Param&egrave;tres');

define('_MD_GWREPORTS_SORT_SECTION_SELECT', 'Selectionner une section &agrave; d&eacute;placer');
define('_MD_GWREPORTS_SORT_SECTION_FORM', 'R&eacute;ordonner des sections');
define('_MD_GWREPORTS_SORT_SECTIONS', 'Sections');

// admin menus
define('_MD_GWREPORTS_ADMIN_MENU', 'Administration');
define('_MD_GWREPORTS_ADMIN_TOPIC', 'Sujets');
define('_MD_GWREPORTS_ADMIN_TOPIC_ADD', 'Ajouter un sujet');
define('_MD_GWREPORTS_ADMIN_TOPIC_SORT', 'R&eacute;ordonner les sujets');
define('_MD_GWREPORTS_ADMIN_REPORT', 'Rapports');
define('_MD_GWREPORTS_ADMIN_REPORT_ADD', 'Ajouter un rapport');
define('_MD_GWREPORTS_ADMIN_REPORT_SORT', 'R&eacute;ordonner les rapports');
define('_MD_GWREPORTS_ADMIN_SECTION_ADD', 'Ajouter une Section');
define('_MD_GWREPORTS_ADMIN_SECTION_SORT', 'R&eacute;ordonner les sections');
define('_MD_GWREPORTS_ADMIN_PARAMETER_ADD', 'Ajouter un param&egrave;tre');
define('_MD_GWREPORTS_ADMIN_PARAMETER_SORT', 'R&eacute;ordonner les param&egrave;tres');

// common field names
define('_MD_GWREPORTS_REPORT_NAME','Nom');
define('_MD_GWREPORTS_REPORT_DESC','Description');
define('_MD_GWREPORTS_REPORT_ACTIVE','Est actif');
define('_MD_GWREPORTS_REPORT_SYSGROUP','Groupes autoris&eacute;s');
define('_MD_GWREPORTS_REPORT_TOPIC','Assign&eacute; au sujet');
define('_MD_GWREPORTS_TOPIC_NAME','Sujet de Rapport');
define('_MD_GWREPORTS_TOPIC_DESC','Description');
define('_MD_GWREPORTS_TOPIC_LIST','Sujets de rapport');
define('_MD_GWREPORTS_NO_TOPIC','(aucun)');
define('_MD_GWREPORTS_SECTION_NAME','Nom de la section');
define('_MD_GWREPORTS_SECTION_DESC','Description');
define('_MD_GWREPORTS_SECTION_LIST','Liste des Sections de rapport');
define('_MD_GWREPORTS_PARAMETER_NAME','Nom du param&egrave;tre');
define('_MD_GWREPORTS_PARAMETER_DESC','Description');
define('_MD_GWREPORTS_PARAMETER_LIST','Param&egrave;tres du rapport');
define('_MD_GWREPORTS_PARAMETER_LIST_EMPTY','Outil de rapport');
define('_MD_GWREPORTS_PARAMETER_TITLE','Titre &agrave; afficher');
define('_MD_GWREPORTS_PARAMETER_DEFAULT','Valeur par d&eacute;faut');
define('_MD_GWREPORTS_PARAMETER_TYPE','Type de param&egrave;tre');
define('_MD_GWREPORTS_PARAMETER_REQUIRED','Requis');
define('_MD_GWREPORTS_PARAMETER_LENGTH','Longueur du champs');
define('_MD_GWREPORTS_PARAMETER_DECIMALS','Nombre de d&eacute;cimales');
define('_MD_GWREPORTS_PARAMETER_SQL_FMT','A r&eacute;f&eacute;rencer dans SQL');

define('_MD_GWREPORTS_COLUMN_NAME','Nom de la colonne');
define('_MD_GWREPORTS_COLUMN_TITLE','Afficher le titre');
define('_MD_GWREPORTS_COLUMN_HIDE','Cacher cette colonne ?');
define('_MD_GWREPORTS_COLUMN_SUM','Additionner cette colonne ?');
define('_MD_GWREPORTS_COLUMN_BREAK','Break au changment de colonne ?');
define('_MD_GWREPORTS_COLUMN_OUTLINE','Souligner la colonne ?');
define('_MD_GWREPORTS_COLUMN_APPLY_NL2BR','Convertion fin de ligne ?');
define('_MD_GWREPORTS_COLUMN_IS_UNIXTIME','Colonne au format heure Unix ?');
define('_MD_GWREPORTS_COLUMN_FORMAT','sprintf() ou date() format string');
define('_MD_GWREPORTS_COLUMN_STYLE','HTML/CSS style pour la colonne');
define('_MD_GWREPORTS_COLUMN_EXTENDED_FMT','format &eacute;tendut');
define('_MD_GWREPORTS_COLUMN_LIST','Formats de colonne d&eacute;finis');
define('_MD_GWREPORTS_COLUMN_AS_VAR','R&eacute;f&eacute;rence des formats &eacute;tendus');

define('_MD_GWREPORTS_SECTION_REPORT_NAME','Nom du rapport');
define('_MD_GWREPORTS_SECTION_MULTIROW','Section multi colonne');
define('_MD_GWREPORTS_SECTION_QUERY','Requ&egrave;te SQL');
define('_MD_GWREPORTS_SECTION_SHOWTITLE','Afficher le nom de la section');
define('_MD_GWREPORTS_SECTION_SKIPEMPTY','Supprimer l\'affichage si aucune donn&eacute;e');


// Parameter Types
// enum('text','liketext','datetime','integer','yesno')
define('_MD_GWREPORTS_PARMTYPE_TEXT','Texte');
define('_MD_GWREPORTS_PARMTYPE_LIKETEXT','Like Texte');
define('_MD_GWREPORTS_PARMTYPE_DATE','Date');
//define('_MD_GWREPORTS_PARMTYPE_DATETIME','Date Time');
define('_MD_GWREPORTS_PARMTYPE_INTEGER','Entier');
define('_MD_GWREPORTS_PARMTYPE_DECIMAL','D&eacute;cimal');
define('_MD_GWREPORTS_PARMTYPE_YESNO','Oui/Non');

// limited mode messages
define('_MD_GWREPORTS_DISABLED', 'Cette fonction n\est pas disponible.');

// new in 1.1 -- need verification
define('_MD_GWREPORTS_PARMTYPE_AUTOCOMPLETE','auto-complétion');
define('_MD_GWREPORTS_PARAMETER_SQLCHOICE','Requ&ecirc;te SQL pour l\'auto-compl&eacute;tion');
define('_MD_GWREPORTS_PARAMETER_SQLCHOICE_DESC',"Requ&ecirc;te SQL retournant deux colonnes nomm&eacute;es, value et label. Par exemple:<br/>select uid as value, uname as label from {\$xpfx}xoops_users");
?>
