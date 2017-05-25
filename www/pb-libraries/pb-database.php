<?php

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * pb-database.php
 * Creates a persistent connection to the mysql database using the credentials
 * as found in the sites config settings file.
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org
 */

function db_show_sql()
{
	global $pb;
	print "<p>Database_SQL: (this is being delted on db_reset() in query_exec()<br />";
	print $pb['DATABASE']['sql'] . "</p>";
	preint_r($pb['DATABASE']);
	exit;
}

function db_query()
{
	global $pb;
	$sql = '';
	$sql_ordered_ar = array();
	
	if(isSet($pb['SQL']['CREATE']['SELECT']))
	{
		$sql_statement_order = array('SELECT','FROM','JOIN','WHERE','LIKE','GROUP_BY','ORDER_BY','LIMIT');
	} 
	else if(isSet($pb['SQL']['CREATE']['UPDATE']))
	{
		$sql_statement_order = array('UPDATE','SET','WHERE');
	} 
	else if(isSet($pb['SQL']['CREATE']['DELETE']))
	{
		$sql_statement_order = array('DELETE','FROM','WHERE');
	}
	
	 foreach($sql_statement_order as $key) 
	 {
	   	if(array_key_exists($key,$pb['SQL']['CREATE'])) 
	    {
	       	$sql_ordered_ar[$key] = $pb['SQL']['CREATE'][$key];
	       	//unset($pb['SQL']['CREATE'][$key]);
	    }
	 }
	
	// loop through the new properly ordered array and create the SQL statement
	foreach($sql_ordered_ar  as $key => $value)
	{	
		$key = str_ireplace('_',' ', $key);
		$sql .= $key . ' ' . $value . ' ';
	}

	$pb['DATABASE']['sql'] = $sql;
	$result = query_exec($pb, $pb['DATABASE']['sql']);
	
	return($result);
}

function db_cback($where_from)
{
	global $pb;
	$pb['DATABASE']['func_cback'] = $where_from;
}

function db_select($input=NULL) 
{
	# db_select('page_id, page_title');
	global $pb;
	$input = str_ireplace(' ', '', $input);
	_db_clean($input);
	
	if(empty($input)) $input='*';

	if(empty($pb['SQL']['CREATE']['SELECT']))
	{
		$pb['SQL']['CREATE']['SELECT'] = $input;
	} else {
		$pb['SQL']['CREATE']['SELECT'] .= ',' . $input;
	}
		
	//return 
}

function db_from($input) 
{
	# db_from('table_name');
	global $pb;
	_db_clean($input);
	$pb['SQL']['CREATE']['FROM'] = $input;
	
	//return 
}

function db_where($input, $value, $operator='=') 
{
	# db_where('page_id','2');
	global $pb;
	_db_clean($value);
	
	if(empty($pb['SQL']['CREATE']['WHERE']))
	{
		$pb['SQL']['CREATE']['WHERE'] = $input . " " . $operator . " '" . $value . "'";
	} else {
		// make this AND
		$pb['SQL']['CREATE']['WHERE'] .= ' AND ' . $input . " " . $operator . " '" . $value . "'";
	}
	
	//return 
}

function db_orwhere($input, $value, $operator='=') 
{
	# db_where('page_id','2');
	global $pb;
	db_clean($value);
	
	if(empty($pb['SQL']['CREATE']['WHERE']))
	{
		$pb['SQL']['CREATE']['WHERE'] = $input . " " . $operator . " '" . $value . "'";
	} else {
		// make this AND
		$pb['SQL']['CREATE']['WHERE'] .= ' OR ' . $input . " " . $operator . " '" . $value . "'";
	}
	
	//return 
}

function db_order_by($input, $order='desc') 
{
	# db_order_by('page_id','asc')
	global $pb;
	_db_clean($input);
	
	$input = str_ireplace(' ', '', $input);
	if(empty($pb['SQL']['CREATE']['ORDER_BY']))
	{
		$pb['SQL']['CREATE']['ORDER_BY'] = $input . " " . $order;
	} else {
		$pb['SQL']['CREATE']['ORDER_BY'] = 'ERROR';
	}

	//return 
}

function db_order_by_RAND($input, $order='RAND') 
{
	# db_order_by_RAND('page_id','RAND')
	global $pb;
	_db_clean($input);
	
	$input = str_ireplace(' ', '', $input);
	if(empty($pb['SQL']['CREATE']['ORDER_BY']))
	{
		$pb['SQL']['CREATE']['ORDER_BY'] = $input . " " . $order;
	} else {
		$pb['SQL']['CREATE']['ORDER_BY'] = 'ERROR';
	}
	
	//return 
}

function db_limit($input) 
{
	# db_limit('19')
	# db_limit('10,5')
	global $pb;
	_db_clean($input);
	
	$pb['SQL']['CREATE']['LIMIT'] = $input;
	
	//return 
}

function db_like($input, $match, $wildcard='') 
{
	# db_like('page_title','foo');
	# db_like('page_title','foo', 'before');
	# db_like('page_title','foo', 'after');
	global $pb;
	_db_clean($match);
	
	$input = str_ireplace(' ', ',', $input);
	
	switch(strtolower($wildcard))
	{
		case "before":
			if(empty($pb['SQL']['CREATE']['LIKE']))
			{
				# WHERE page_title LIKE '%foo'
				$pb['SQL']['CREATE']['LIKE'] = $input . " LIKE '%" . $match . "'";
			} else {
				$pb['SQL']['CREATE']['LIKE'] = 'ERROR multiple LIKES';
			}
		break;
		
		case "after":
				if(empty($pb['SQL']['CREATE']['LIKE']))
			{
				# WHERE page_title LIKE 'foo%'
				$pb['SQL']['CREATE']['LIKE'] = $input . " LIKE '" . $match . "%'";
			} else {
				$pb['SQL']['CREATE']['LIKE'] = 'ERROR multiple LIKES';
			}
		break;
		
		case "both":
			if(empty($pb['SQL']['CREATE']['LIKE']))
			{
				# WHERE page_title LIKE '%foo%'
				$pb['SQL']['CREATE']['LIKE'] = $input . " LIKE '%" . $match . "%'";
			} else {
				$pb['SQL']['CREATE']['LIKE'] = 'ERROR multiple LIKES';
			}
		break;		
		
		default:
			if(empty($pb['SQL']['CREATE']['LIKE']))
			{
				# WHERE page_title LIKE '%foo%'
				$pb['SQL']['CREATE']['LIKE'] = $input . " LIKE '" . $match . "'";
			} else {
				$pb['SQL']['CREATE']['LIKE'] = 'ERROR multiple LIKES';
			}
		break;
	}
	
	//return 
}

function xdb_join($pb) 
{
	#return 
}

function db_groupby($input) 
{
	global $pb;
	_db_clean($input);
	
	$pb['SQL']['CREATE']['GROUP_BY'] = $input; 
	// return	
}

function db_update($table, $data) 
{
	# $upd_array('field' => 'value', 'field2' => 'value2');
	# $this->db->where('id', $id);
	# $this->db->update('mytable', $data); 
	# UPDATE $table set field_name = 'field_data';
	
	global $pb;
	$pb['SQL']['CREATE']['UPDATE'] = $table . ' SET ';
	
	foreach ($data as $key => $value)
	{
		_db_clean($value);
		if(count($data) > 1) { $add_comma = ','; } else { $add_comma = NULL; }
		$pb['SQL']['CREATE']['UPDATE'] .= $key . "='" . $value . "'" . $add_comma;
	}
	
	//return 
}

function db_insert($table, $data) 
{	
	global $pb;
	foreach ($data as $key => $value)
	{
		_db_clean($value);
		if(count($data) > 1) { $add_comma = ','; } else { $add_comma = NULL; }
		$insert_keys = $key . $add_comma;
		$insert_values = $values . $add_comma;
	}
	
	$pb['SQL']['CREATE']['INSERT'] = 'INTO ' . $table . ' ' . $keys . ' VALUES ' . $values;
	// return
}

function db_delete($table) 
{	
	global $pb;
	// DELETE REQUIRES A WHERE
	$pb['SQL']['CREATE']['DELETE'] = 'FROM ' . $table; 
	// return	
}

function _dbopen($pb) 
{
	_benchmark($pb, 'lib_database', 'TIMER_ON');
	
	$pb['DATABASE']['CON'] = mysql_connect(DB_HOST, DB_USER, DB_PSWD);	
	if(!$pb['DATABASE']['CON'])  
	{ 
		_log_err($pb, 'DATABASE', __FUNCTION__, __LINE__, __FILE__, 'DATABASE CONNECTION FAILED');
	}

	$DBH = mysql_select_db(DB_NAME, $pb['DATABASE']['CON']);

	$pb['DATABASE']['name'] = DB_NAME;
	$pb['DATABASE']['con_type'] = 'mysql_pconnect';
			
	_benchmark($pb, 'lib_database', 'TIMER_OFF');
	_log_msg($pb, 'INFO','_dbopen: ' . $pb['DATABASE']['con_type']);	
	return($pb['DATABASE']);
}

function _dbclose($pb) 
{
    mysql_close($pb['DATABASE']['CON']);
    _log_msg($pb, 'info', __FUNCTION__ . ' CLOSED');
}

function _db_clean($input) 
{
	$input = mysql_real_escape_string($input);
	return($input);	
}

function query_exec($pb) {
    
	_benchmark($pb,'sql_runtime','TIMER_ON');
	$sql_result = mysql_query($pb['DATABASE']['sql'],$pb['DATABASE']['CON']);
	$pb['DATABASE']['result_count'] = mysql_num_rows($sql_result);
	_benchmark($pb,'sql_runtime','TIMER_OFF');
	
	// Add the SQL to an array.
	__logSQL($pb);
	_benchmarkreset($pb, 'sql_runtime');
	
	db_reset();
	return($sql_result);
}

function db_reset()
{
	global $pb;
	if(isSet($pb['DATABASE']['sql'])) { unset($pb['DATABASE']['sql']); }
	if(isSet($pb['SQL']['CREATE'])) { unset($pb['SQL']['CREATE']); }
}

function __logSQL($pb) 
{
	if(isSet($pb['DATABASE']['SQLog'])) 
	{
		$d = count($pb['DATABASE']['SQLog']);
	} else {
		$d=0;
	}
	
	if(empty($pb['DATABASE']['func_cback'])) { $pb['DATABASE']['func_cback'] = 'Not Implemented With SHORT-SQL'; }
	$pb['DATABASE']['SQLog'][$d] = $pb['DATABASE']['sql'] . '|' . $pb['DATABASE']['result_count'] . '|' . $pb['BENCHMARK']['sql_runtime']['time'] . '|' . $pb['BENCHMARK']['sql_runtime']['mem_usage'] . '|' . $pb['DATABASE']['func_cback'];
	_log_msg($pb, 'SQL','SQL_logged from ' . $pb['DATABASE']['func_cback']);	
	unset($pb['DATABASE']['func_cback']);
	
	return(TRUE);
}

// END // 