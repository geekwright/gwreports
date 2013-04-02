#
# Tables for gwreports module
# @version    $Id$
#

CREATE TABLE gwreports_report (
  report_id int(8) unsigned NOT NULL auto_increment,
  report_name varchar(255) NOT NULL,
  report_description text NOT NULL,
  report_active tinyint unsigned NOT NULL default '0',
  PRIMARY KEY (report_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gwreports_access (
  report int(8) unsigned NOT NULL,
  groupid int(5)  unsigned NOT NULL,
  PRIMARY KEY (report, groupid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gwreports_parameter (
  parameter_id int(8) unsigned NOT NULL auto_increment,
  report int(8) unsigned NOT NULL,
  parameter_name varchar(255) NOT NULL,
  parameter_title varchar(255) NOT NULL,
  parameter_description text NOT NULL,
  parameter_order int(8) unsigned NOT NULL default '0',
  parameter_default varchar(255) NOT NULL,
  parameter_required tinyint unsigned NOT NULL default '0',
  parameter_length int(3) unsigned NOT NULL default '0',
  parameter_type enum('text','liketext','date','integer','yesno','decimal', 'autocomplete') NOT NULL default 'text',
  parameter_decimals int(3) unsigned NOT NULL default '0',
  parameter_sqlchoice text NOT NULL,
  PRIMARY KEY (parameter_id),
  UNIQUE KEY (report, parameter_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gwreports_topic (
  topic_id int(8) unsigned NOT NULL auto_increment,
  topic_name varchar(255) NOT NULL,
  topic_description text NOT NULL,
  topic_order int(8) unsigned NOT NULL default '0',
  PRIMARY KEY (topic_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gwreports_grouping (
  topic int(8) unsigned NOT NULL,
  report int(8)  unsigned NOT NULL,
  grouping_order int(8) unsigned NOT NULL default '0',
  PRIMARY KEY (topic, report)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gwreports_section (
  section_id int(8) unsigned NOT NULL auto_increment,
  report int(8)  unsigned NOT NULL,
  section_name varchar(255) NOT NULL,
  section_description text NOT NULL,
  section_order int(8) unsigned NOT NULL default '0',
  section_showtitle tinyint unsigned NOT NULL default '0',
  section_multirow tinyint unsigned NOT NULL default '1',
  section_skipempty tinyint unsigned NOT NULL default '0',
  section_query text NOT NULL,
  PRIMARY KEY (section_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE gwreports_column (
  column_id int(8) unsigned NOT NULL auto_increment,
  section int(8) unsigned NOT NULL,
  column_name varchar(255) NOT NULL,
  column_title varchar(255) NOT NULL,
  column_hide tinyint unsigned NOT NULL default '0',
  column_sum tinyint unsigned NOT NULL default '0',
  column_break tinyint unsigned NOT NULL default '0',
  column_outline tinyint unsigned NOT NULL default '0',
  column_apply_nl2br tinyint unsigned NOT NULL default '0',
  column_is_unixtime tinyint unsigned NOT NULL default '0',
  column_format varchar(255) NOT NULL default '',
  column_style varchar(255) NOT NULL default '',
  column_extended_format text NOT NULL default '',
  PRIMARY KEY (column_id),
  UNIQUE KEY (section, column_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

