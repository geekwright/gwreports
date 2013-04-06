<?php
/**
* blocks.php - code to support blocks
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

if (!defined('XOOPS_ROOT_PATH')){ exit(); }
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

function b_gwreports_block_topic_show($options) {
	global $xoopsDB, $xoopsUser;

	$block=null;
	$ourdir=basename( dirname( dirname( __FILE__ ) ) ) ;

	$topic_id=$options[0];

	$usergroups=array(XOOPS_GROUP_ANONYMOUS);

	if($xoopsUser) {
		$usergroups=$xoopsUser->getGroups();
	}

	$wherein='';
	foreach($usergroups as $i) {
		if($wherein=='') $wherein .='('.$i;
		else $wherein .=','.$i;
	}
	if($wherein=='')  return $block; // error if no groups
	$wherein .=')';

	$sql='SELECT DISTINCT report_id, report_name, report_description, grouping_order FROM ';
	$sql.= $xoopsDB->prefix('gwreports_report') . ' r, ';
	$sql.= $xoopsDB->prefix('gwreports_grouping') . ' g, '; // topic, report, grouping_order
	$sql.= $xoopsDB->prefix('gwreports_access') . ' a '; // report, groupid

	$sql.= ' WHERE a.groupid in '.$wherein;
	$sql.= ' AND g.report=a.report ';
	$sql.= " AND g.topic = $topic_id ";
	$sql.= " AND r.report_id = g.report ";
	$sql.= " AND r.report_active = 1 ";
	$sql.= ' ORDER BY grouping_order, report_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$rid=$myrow['report_id'];
			$block[$rid]['report_id']=$rid;

			$block[$rid]['report_name']=htmlspecialchars($myrow['report_name'], ENT_QUOTES);
			$block[$rid]['report_description']=htmlspecialchars($myrow['report_description'], ENT_QUOTES);
			$block[$rid]['link']=XOOPS_URL."/modules/$ourdir/report_view.php?rid=$rid";
		}
	}

	return $block;
}

function b_gwreports_block_topic_edit($options) {

	global $xoopsDB;
	$topics=array();

	$sql='SELECT topic_id, topic_name, topic_order FROM '. $xoopsDB->prefix('gwreports_topic');
	$sql.= ' ORDER BY topic_order, topic_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$topics[$myrow['topic_id']] = $myrow['topic_name'];
		}
	}

	$form = _MB_GWREPORTS_BLOCK_TOPIC_ID.": ";
	if (count($topics)) {
		$form.= "<select 'id='options[0]' name='options[0]'>";
		foreach($topics as $i=>$v) {
			$sel='';
			if($i==$options[0]) $sel='selected="yes"';
  			$form.="<option $sel value=\"$i\">$v</option>";
		}
		$form.= '</select>';
	}
	else {
		$form.= "<input type='text' value='".$options[0]."'id='options[0]' name='options[0]' />";
	}
	return $form;
}

function b_gwreports_block_quick_report_show($options) {
	global $xoopsDB, $xoopsUser, $xoTheme;

	$this_report_needs_jquery=false;
	$block=null;
	$ourdir=basename( dirname( dirname( __FILE__ ) ) ) ;

	$report_id=$options[0];

	$usergroups=array(XOOPS_GROUP_ANONYMOUS);

	if($xoopsUser) {
		$usergroups=$xoopsUser->getGroups();
	}

	$wherein='';
	foreach($usergroups as $i) {
		if($wherein=='') $wherein .='('.$i;
		else $wherein .=','.$i;
	}
	if($wherein=='')  return $block; // error if no groups
	$wherein .=')';

	$sql='SELECT DISTINCT report_id, report_name, report_description FROM ';
	$sql.= $xoopsDB->prefix('gwreports_report') . ' r, ';
	$sql.= $xoopsDB->prefix('gwreports_access') . ' a '; // report, groupid

	$sql.= ' WHERE a.groupid in '.$wherein;
	$sql.= " AND r.report_id = $report_id ";
	$sql.= " AND r.report_id = a.report ";
	$sql.= " AND r.report_active = 1 ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$rid=$myrow['report_id'];
			$block['report_id']=$rid;
			$block['report_name']=htmlspecialchars($myrow['report_name'], ENT_QUOTES);
			$block['report_description']=htmlspecialchars($myrow['report_description'], ENT_QUOTES);
			$block['link']=XOOPS_URL."/modules/$ourdir/report_view.php?rid=$rid";
		}
	}

	if(is_null($block)) return;

	$parameters=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_parameter');
	$sql.= " WHERE report = $report_id ";
	$sql.= ' ORDER BY parameter_order, parameter_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$parameters[$myrow['parameter_id']] = $myrow;
		}
	}

	if(count($parameters)) {
		$mymoduledir='modules/'.$ourdir.'/';
		if(isset($xoTheme) && is_object($xoTheme)) $xoTheme->addStylesheet($mymoduledir.'module.css');

		$body='';
		$token=false;
		$formtitle=''; // $block['report_name'];
		$report_script=XOOPS_URL."/modules/$ourdir/report_view.php";

		$form = new XoopsSimpleForm($formtitle, 'parmblockform', $report_script, 'POST', $token);

		foreach ($parameters as $v) {
			$caption=$v['parameter_title'];

			$parm_desc=htmlspecialchars($v['parameter_description'], ENT_QUOTES);
			$parm_length=$v['parameter_length'];
			$parm_length_min=$parm_length;
			if($parm_length_min>10) $parm_length_min=10;
			$parm_required=$v['parameter_required'];
			$parm_name='rptparm_'.$v['parameter_name'];
			$parm_type=$v['parameter_type'];
			$parm_value=$v['parameter_default'];
			if(isset($v['value'])) $parm_value = $v['value'];

			switch ($parm_type) {
				case "yesno":
					$element=new XoopsFormRadioYN($caption, $parm_name, $parm_value);
		        	break;
				case "date":
					$element=new XoopsFormTextDateSelect($caption, $parm_name, $parm_length, strtotime($parm_value));
		        	break;
				case "datetime":
					$element=new XoopsFormDateTime($caption, $parm_name, $parm_length, $parm_value);
		        	break;
				case "autocomplete":
					$this_report_needs_jquery=true;
					$element=new XoopsFormText($caption, $parm_name, $parm_length_min, $parm_length, htmlspecialchars($parm_value, ENT_QUOTES));
					$element->setExtra(" class='autocomplete' size='10' autocompleteurl='".XOOPS_URL."/modules/gwreports/autocomplete.php?parameter_id=".$v['parameter_id']."'" );
					break;
				default: // text, liketext, int
					$element=new XoopsFormText($caption, $parm_name, $parm_length_min, $parm_length, htmlspecialchars($parm_value, ENT_QUOTES));
		        	break;
			}
			if($parm_desc!='')  $element->setExtra(' title="'.$parm_desc.'" ');
			$form->addElement($element,$parm_required);
			unset($element);
		}

		$form->addElement(new XoopsFormButton('', 'submit', _MB_GWREPORTS_REPORT_RUN_BUTTON, 'submit'));

		$form->addElement(new XoopsFormHidden('rid', $report_id));

		$body=$form->render();
		$block['form']=$body;
		$block['needjquery']=$this_report_needs_jquery;
	}


	return $block;

}

function b_gwreports_block_quick_report_edit($options) {

	global $xoopsDB;
	$reports=array();
	$limit=60; // when list will get unwieldy

	$sql='SELECT report_id, report_name FROM '. $xoopsDB->prefix('gwreports_report');
	$sql.= " WHERE report_active = 1 ";
	$sql.= ' ORDER BY report_name, report_id ';

	$result = $xoopsDB->query($sql,$limit,0);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$reports[$myrow['report_id']] = $myrow['report_name'];
		}
	}

	$form = _MB_GWREPORTS_BLOCK_QUICK_REPORT_ID.": ";
	if (count($reports) && count($reports)<$limit) {
		$form.= "<select 'id='options[0]' name='options[0]'>";
		foreach($reports as $i=>$v) {
			$sel='';
			if($i==$options[0]) $sel='selected="yes"';
  			$form.="<option $sel value=\"$i\">$v</option>";
		}
		$form.= '</select>';
	}
	else {
		$form.= "<input type='text' value='".$options[0]."'id='options[0]' name='options[0]' />";
	}
	return $form;
}

// report in a block

//supporting functions - from report_view.php renamed to block namespace
function b_gwreports_emitColumnHeader($column_name, &$columns, $multirow=1) {
// return a column header using column definitions

	$title=$column_name;
	
	if(isset($columns[$column_name])) { // have a definition
		if($columns[$column_name]['column_hide']) return '';
		$title=$columns[$column_name]['column_title'];
		if($title=='') $title=$column_name;
	}

	if($multirow) $header="<th>$title</th>";
	else $header='<td class="head">'.$title.'</td>';
	return $header;
}

function b_gwreports_emitColumn($column_name, &$columns, $row, $breaktriggered, $rowheaders) {
// condition column display using column definitions

	$r=$row[$column_name];
	$css='';
	if(isset($columns[$column_name])) { // have a definition
		if($columns[$column_name]['column_style']!='') {
			$css=' '.$columns[$column_name]['column_style'];
		}

		if($columns[$column_name]['column_break']) {
			if($breaktriggered) {
				$columns[$column_name]['last_column_break']=$r;
			}
		}

		if($columns[$column_name]['column_outline']) {
			if($r==$columns[$column_name]['last_column_outline'] && !$breaktriggered) $r='';
			else $columns[$column_name]['last_column_outline']=$r;
		}

		if($columns[$column_name]['column_sum']) {
			$columns[$column_name]['total_column_sum'] += $r;
			$columns[$column_name]['sum_column_break'] += $r;
		}

		$r = htmlspecialchars($r);

		if($columns[$column_name]['column_apply_nl2br']) {
			$r = nl2br($r);
		}

		if($columns[$column_name]['column_is_unixtime']) {
			if($columns[$column_name]['column_format']!='') {
				$r=date($columns[$column_name]['column_format'],$r);
			}
			else $r=formatTimestamp($r);
		}
		else { // not unixtime
			if($columns[$column_name]['column_format']!='') {
				$r=sprintf($columns[$column_name]['column_format'],$r);
			}
		}

		if($columns[$column_name]['column_extended_format']!='') {
			$row[$column_name]=$r; // preserve any formatting we have so far
			$r=str_replace($rowheaders, $row, $columns[$column_name]['column_extended_format']);
			$r=str_replace('{$xurl}', XOOPS_URL, $r);
		}

		if($columns[$column_name]['column_hide']) return '';
	}
	$r="<td$css>$r</td>";
	return $r;
}

function b_gwreports_checkBreak(&$columns, $row) {
// check row for any column change break
$breaktriggered=false;

	foreach ($row as $col=>$val) {
		if(isset($columns[$col])) { // have a definition
			if($columns[$col]['column_break']) {
				if($val!=$columns[$col]['last_column_break']) {
					$breaktriggered=true;
				}
			}
		}
	}
	return $breaktriggered;
}

function b_gwreports_emitBreak(&$columns, $rowheaders) {
// output columns for a column change break
$sumline='';
$havesum=false;
$havebreak=false;

	foreach ($rowheaders as $col=>$val) {
		$r='';
		$css='';
		if(isset($columns[$col])) { // have a definition
			if($columns[$col]['column_break']) $havebreak=true;
			if(!$columns[$col]['column_hide']) {
				if($columns[$col]['column_style']!='') {
					$css=' '.$columns[$col]['column_style'];
				}
				if($columns[$col]['column_sum']) {
					$havesum=true;
					$r=$columns[$col]['sum_column_break'].'';
					$columns[$col]['sum_column_break']=0;	// used it, now reset
					if($columns[$col]['column_format']!='') {
						$r=sprintf($columns[$col]['column_format'],$r);
					}
					$r='<hr /><br />'.$r;
				}
				else { // not sum
					$r='&nbsp;';
				}
			}
		}
		else { // no definition
			$r=' ';
		}
		if($r!='') $sumline.="<td$css>$r</td>";
	}

	if($havebreak) return $sumline;
	else return '';
}

function b_gwreports_emitFinalSummary(&$columns, $rowheaders) {
// output columns for final summary row
$sumline='';
$havesum=false;

	foreach ($rowheaders as $col=>$val) {
		$r='';
		$css='';
		if(isset($columns[$col])) { // have a definition
			if(!$columns[$col]['column_hide']) {
				if($columns[$col]['column_style']!='') {
					$css=' '.$columns[$col]['column_style'];
				}
				if($columns[$col]['column_sum']) {
					$havesum=true;
					$r=$columns[$col]['total_column_sum'].''; // coerce to string
					if($columns[$col]['column_format']!='') {
						$r=sprintf($columns[$col]['column_format'],$r);
					}
					$r='<hr /><br />'.$r;
				}
				else { // not sum
					$r=' ';
				}
			}
		}
		else { // no definition
			$r=' ';
		}
		if($r!='') $sumline.="<td$css>$r</td>";
	}

	if($havesum) return $sumline;
	else return '';
}

function b_gwreports_initializeColumns(&$columns, $row, &$rowheaders) {
// initialize columns and return count of columns
$cnt=0;

	$rowheaders=array();

	foreach ($row as $col=>$val) {
		$rowheaders[$col]='{'.$col.'}';

		if(isset($columns[$col])) { // have a definition
			if(!$columns[$col]['column_hide']) ++$cnt;
			if($columns[$col]['column_sum']) {
				$columns[$col]['total_column_sum'] = 0;
				$columns[$col]['sum_column_break'] = 0;
			}
			if($columns[$col]['column_break']) {
				$columns[$col]['last_column_break'] = $val; // preset with first row
			}
			if($columns[$col]['column_outline']) $columns[$col]['last_column_outline'] = '';

		}
		else ++$cnt;
	}

	return $cnt;
}

//supporting functions - from include/common.php renamed to block namespace
function b_gwreports_getReportSections($report_id) {

	global $xoopsDB;
	$sections=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_section');
	$sql.= " WHERE report = $report_id ";
	$sql.= ' ORDER BY section_order, section_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$sections[$myrow['section_id']] = $myrow;
		}
	}
	return $sections;
}

function b_gwreports_getReportParameters($report_id) {

	global $xoopsDB;
	$parameters=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_parameter');
	$sql.= " WHERE report = $report_id ";
	$sql.= ' ORDER BY parameter_order, parameter_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$parameters[$myrow['parameter_id']] = $myrow;
		}
	}
	return $parameters;
}

function b_gwreports_getColumns($section_id) {

	global $xoopsDB;
	$columns=array();

	$sql='SELECT * FROM '. $xoopsDB->prefix('gwreports_column');
	$sql.= " WHERE section = $section_id ";

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$columns[$myrow['column_name']] = $myrow;
		}
	}
	return $columns;
}

function b_gwreports_dbescape($string) {
	return mysql_real_escape_string($string); 
}

// show report block
function b_gwreports_block_report_show($options) {
	global $xoopsDB, $xoopsUser;

	$block=null;
	$ourdir=basename( dirname( dirname( __FILE__ ) ) ) ;

	$report_id=intval($options[0]);

	$usergroups=array(XOOPS_GROUP_ANONYMOUS);

	if($xoopsUser) {
		$usergroups=$xoopsUser->getGroups();
	}

	$wherein='';
	foreach($usergroups as $i) {
		if($wherein=='') $wherein .='('.$i;
		else $wherein .=','.$i;
	}
	if($wherein=='')  return $block; // error if no groups
	$wherein .=')';

	$sql='SELECT DISTINCT report_id FROM ';
	$sql.= $xoopsDB->prefix('gwreports_report') . ' r, ';
	$sql.= $xoopsDB->prefix('gwreports_access') . ' a '; // report, groupid

	$sql.= ' WHERE a.groupid in '.$wherein;
	$sql.= " AND r.report_id = $report_id ";
	$sql.= ' AND r.report_id = a.report ';
	$sql.= ' AND r.report_active = 1 ';

	$result = $xoopsDB->query($sql);
	$rid=0;
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$rid=intval($myrow['report_id']);
		}
	}
if ($rid) { // b_gwreports_
	$body='';
	$this_report_needs_jquery=false;
	$sections=b_gwreports_getReportSections($report_id);

	$parameters=b_gwreports_getReportParameters($report_id);

	foreach ($parameters as $v) {
		$parm_length=$v['parameter_length'];
		$parm_required=$v['parameter_required'];
//		$parm_name='rptparm_'.$v['parameter_name'];
//		$parm_shortname=$v['parameter_name'];
		$parm_type=$v['parameter_type'];
		$parm_value=$v['parameter_default'];
//		if(isset($_GET[$parm_shortname])) $parm_value = cleaner($_GET[$parm_shortname]);
//		if(isset($_POST[$parm_name])) $parm_value = cleaner($_POST[$parm_name]);
		switch ($parm_type) {
			case "int":
				$parm_value = intval($parm_value);
		        break;
			case "yesno":
				$parm_value = intval($parm_value);
				if($parm_value) $parm_value='1'; else $parm_value='0';
		        break;
			default: // text, liketext, date
//				$parm_value=clipstring($parm_value,$parm_length);
				if ( function_exists('mb_substr') ) $parm_value=mb_substr($parm_value, 0, $parm_length, XOOPS_DB_CHARSET);
				else $parm_value=substr($parm_value, 0, $parm_length);
		        break;
		}
		$parameters[$v['parameter_id']]['value']=$parm_value;
	}

	$parmtags=array();
	$parmsubs=array();

	$pc=0;
	$parmtags[$pc]='{$xpfx}';
	$parmsubs[$pc]=$xoopsDB->prefix('').'_';
	++$pc;
	$parmtags[$pc]='{$xuid}';
	$parmsubs[$pc]=($xoopsUser ? $xoopsUser->getVar('uid') : 0 );
	foreach ($parameters as $v) {
		++$pc;
		$parmtags[$pc]='{'.$v['parameter_name'].'}';
		$parm_type=$v['parameter_type'];
		// apply any preconditioning
		// 	'text','liketext','date','datetime','integer','yesno'
		switch ($parm_type) {
			case "liketext":
				$parmsubs[$pc]=b_gwreports_dbescape('%'.$v['value'].'%');
		        break;
			case "date":
				$parmsubs[$pc]=strtotime($v['value']);
		        break;
			case "integer":
				$parmsubs[$pc]=intval($v['value']);
		        break;
			case "decimal":
				$dp=$v['parameter_decimals'];
				$dp=sprintf('%01d',$dp);
				$parmsubs[$pc]=sprintf('%01.'.$dp.'f',round($v['value'],$dp));
		        break;
			case "yesno":
				$parmsubs[$pc]=intval($v['value']);
		        break;
			default:
				$parmsubs[$pc]=b_gwreports_dbescape($v['value']);
		        break;
		}
	}


	foreach ($sections as $s) {
		$section_id=$s['section_id'];
		$section_name=$s['section_name'];
		$section_description=$s['section_description'];
		$section_order=$s['section_order'];
		$section_showtitle=$s['section_showtitle'];
		$section_multirow=$s['section_multirow'];
		$section_skipempty=$s['section_skipempty'];
		$section_datatools=$s['section_datatools'];
		$section_query=$s['section_query'];

		if($section_datatools) $this_report_needs_jquery=true;

		unset($columns);
		$columns=b_gwreports_getColumns($section_id);

		$rowclass='even';

		$sql=str_replace($parmtags, $parmsubs, $section_query);
		$result = $xoopsDB->query($sql);
		$dbmsg='';
		if($xoopsDB->errno()) return null;
		if ($result) {
			if($myrow=$xoopsDB->fetchArray($result)) {
				$rowheaders=array();
				$colcount=b_gwreports_initializeColumns($columns, $myrow, $rowheaders);
				if($section_multirow) {
					$datatool_class='';
					if($section_datatools) $datatool_class=' class="dataTable" ';
					$body.='<table'.$datatool_class.'><thead><tr>';
					if($section_showtitle) {
						$colspan=$colcount;
						$body.="<th colspan=$colspan>$section_name</th></tr><tr>";
					}
					foreach ($myrow as $col=>$row) {
						$body.=b_gwreports_emitColumnHeader($col, $columns,$section_multirow);
					}
					$body.='</tr></thead><tbody>';
					while($myrow) {
						$breaktriggered=b_gwreports_checkBreak($columns, $myrow);
						if($breaktriggered) {
							$trcontent=b_gwreports_emitBreak($columns, $rowheaders);
							if($trcontent!='') {
								$body.='<tr class="sumbreak">';
								$body.=$trcontent.'</tr>';
							}
						}
						if ($rowclass=='even') $rowclass='odd'; else $rowclass='even';
						$body.='<tr class="'.$rowclass.'">';
						foreach ($myrow as $col=>$row) {
							$body.= b_gwreports_emitColumn($col, $columns, $myrow, $breaktriggered, $rowheaders);
						}
						$body.='</tr>';

						$myrow=$xoopsDB->fetchArray($result);
					}

					// automatic break at end
					$trcontent=b_gwreports_emitBreak($columns, $rowheaders);
					if($trcontent!='') {
						$body.='<tr class="sumbreak">';
						$body.=$trcontent.'</tr>';
					}

					// final summary
					$trcontent=b_gwreports_emitFinalSummary($columns, $rowheaders);
					if($trcontent!='') {
						$body.='<tr class="sumtotal">';
						$body.=$trcontent.'</tr>';
					}

				} else { // $section_multirow is false
					$body.='<table><tbody>';
					if($section_showtitle) {
						$body.="<tr><th colspan=\"2\">$section_name</th></tr>";
					}
					while($myrow) {
						$breaktriggered=false;
						$breaktriggered=b_gwreports_checkBreak($columns, $myrow);
						if($breaktriggered) {
							$body.='<tr class="sumbreak"><td>&nbsp;</td><td></td></tr>';
						}
						foreach ($myrow as $col=>$row) {
							$trcontent=b_gwreports_emitColumnHeader($col, $columns, $section_multirow);
							$trcontent.=b_gwreports_emitColumn($col, $columns, $myrow, $breaktriggered, $rowheaders);
							if($trcontent!='') $body.= '<tr>'.$trcontent.'</tr>';
						}
						$myrow=$xoopsDB->fetchArray($result);
					}
				}

				$body.='</tbody></table><br />';
			}
			else { // else no data for section
				if(!$section_skipempty) {
					$body.='<table><tr>';
					if($section_showtitle) $body.="<th>$section_name</th></tr><tr>";
					$body.='<td><em>'._MB_GWREPORTS_SECTION_EMPTY.'</em></th></tr></table><br />';
				}
			}
		}
	} // foreach ($sections as $s)

	if($body!='') {
		$block['body']=$body;
		$block['needjquery']=$this_report_needs_jquery;
	}
}

	return $block;
}

function b_gwreports_block_report_edit($options) {

	global $xoopsDB;
	$topics=array();

	$sql='SELECT report_id, report_name FROM '. $xoopsDB->prefix('gwreports_report');
	$sql.= ' ORDER BY report_name, report_id ';

	$result = $xoopsDB->query($sql);
	if ($result) {
		while($myrow=$xoopsDB->fetchArray($result)) {
			$reports[$myrow['report_id']] = $myrow['report_name'];
		}
	}

	$form = _MB_GWREPORTS_BLOCK_QUICK_REPORT_ID.": ";
	if (count($reports) && count($reports)<200) {
		$form.= "<select 'id='options[0]' name='options[0]'>";
		foreach($reports as $i=>$v) {
			$sel='';
			if($i==$options[0]) $sel='selected="yes"';
  			$form.="<option $sel value=\"$i\">$v</option>";
		}
		$form.= '</select>';
	}
	else {
		$form.= "<input type='text' value='".$options[0]."'id='options[0]' name='options[0]' />";
	}
	return $form;
}

?>
