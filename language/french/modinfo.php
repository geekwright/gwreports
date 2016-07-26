<?php
// @version    $Id: modinfo.php 10 2011-05-12 22:42:27Z rgriffith $
if (!defined("XOOPS_ROOT_PATH")) {
    die("Root path not defined");
}
// Module Info

// The name and description of module
define("_MI_GWREPORTS_NAME", "Rapports");
define("_MI_GWREPORTS_DESC", "G&eacute;n&eacute;rateur de rapports");

// config options
define("_MI_GWREPORTS_INDEX_TEXT", "Index Text");
define("_MI_GWREPORTS_INDEX_TEXT_DSC", "Message a afficher sur la page index.");
define("_MI_GWREPORTS_SHOW_BREADCRUMBS", "Afficher Breadcrumbs");
define("_MI_GWREPORTS_SHOW_BREADCRUMBS_DSC", "Afficher les breadcrumbs dans les pages de sujet et rapport ?");
define("_MI_GWREPORTS_SHOW_SPREADSHEET", "Afficher l'option Feuille de calcul");
define("_MI_GWREPORTS_SHOW_SPREADSHEET_DSC", "Afficher l'option Feuille de calcul dans le visualiseur de rapport ?");
define("_MI_GWREPORTS_SHOW_PRINT", "Afficher l'option d'impression");
define("_MI_GWREPORTS_SHOW_PRINT_DSC", "Afficher l'option d'impression dans le visualiseur de rapport ?");

// Blocks
define("_MI_GWREPORTS_BLOCK_TOPIC", "Menu des sujets");
define("_MI_GWREPORTS_BLOCK_TOPIC_DESC", "Affiche les rapports pour un sujet particulier dans bloc.");
define("_MI_GWREPORTS_BLOCK_QUICK_REPORT", "Rapport rapide");
define("_MI_GWREPORTS_BLOCK_QUICK_REPORT_DESC", "Affiche un formulaire pour executer un simple rapport dans un bloc.");
define("_MI_GWREPORTS_BLOCK_REPORT", "Rapport dans un bloc");
define("_MI_GWREPORTS_BLOCK_REPORT_DESC", "Affiche un (petit) rapport dans un bloc.");

// Admin Menu
define("_MI_GWREPORTS_ADMENU", "Menu");
define("_MI_GWREPORTS_AD_TOPIC", "Sujets");
define("_MI_GWREPORTS_AD_REPORT", "Rapports");
define("_MI_GWREPORTS_AD_EXPLORE", "Explorer");

// new in 1.1 - need verification
define("_MI_GWREPORTS_AD_ABOUT", "A propos");
