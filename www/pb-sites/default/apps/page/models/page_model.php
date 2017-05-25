<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * @FILE		start_c.php
 * @DESC		initializes the pasteboard system
 * @PACKAGE		PASTEBOARD
 * @VERSION		1.0.0
 * @AUTHOR		James McCarthy
 * @EMAIL		james.mccarthy@gmail.com
 */

function _get_content_index($pb)
{
	// VIEW FUNCTION; called by view_index.php
	$data = '';
	$i = 0;
	$add_comma = NULL;
	
	$pb['DATABASE']['sql'] = "SELECT page_title, page_slug from pb_page where page_type='STANDARD'";
	$pb['DATABASE']['func_cback'] = __FUNCTION__ . ', ' . __LINE__;
	$sql_result = query_exec($pb, $pb['DATABASE']['sql']);	
	
	if($pb['DATABASE']['result_count'] > 0) 
	{ 
		
		while ($row = mysql_fetch_array($sql_result, MYSQL_ASSOC)) {
    		#foreach ($row as $key=>$value) 
			#{ 
			if($i > 0) $add_comma = ", ";
			$data .= "<a href=\"/page/view/" . $row['page_slug'] . "\" >" . $row['page_title'] . "</a>" . $add_comma;
			$i++;
			#}
  		}
	}
	
	_log_msg($pb, 'INFO', 'model: ' . $pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['model'] . ' Function: ' . __FUNCTION__);
	return($data);
}


function _get_content($pb, $id)
{
	$data = array();
	
	if(!is_numeric($id)) 
	{
		$field = 'page_slug';
		$field_value = $id;
	} else {
		$field = 'page_id';
		$field_value = $id;
	}
	
	$pb['DATABASE']['sql'] = "SELECT * from pb_page WHERE " . $field . "='" . $field_value . "' AND page_type='STANDARD'";
	db_cback(__FUNCTION__ . ', ' . __LINE__);
	$sql_result = query_exec($pb, $pb['DATABASE']['sql']);	

	if($pb['DATABASE']['result_count'] > 0) 
	{ 
		while ($row = mysql_fetch_array($sql_result, MYSQL_ASSOC)) {
	   		foreach ($row as $key=>$value) 
			{ 
				$data[$key] = $value; 
			}
  		}
	} else {
		_log_err($pb, 'DATABASE', __FUNCTION__, __LINE__, __FILE__, 'NO RECORDS RETURNED: 0');
		show_404(); 
	}

	_log_msg($pb, 'INFO', 'model: ' . $pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['model'] . ' Function: ' . __FUNCTION__);
	return($data);
}

function _get_front_page($pb)
{
	$data = array();

	db_limit('1');
	db_select('*');
	db_where('page_type','FRONT');
	db_from('pb_page');
	db_cback(__FUNCTION__ . ', ' . __LINE__);
	$sql_result = db_query();
	
	if($pb['DATABASE']['result_count'] > 0) 
	{ 
		while ($row = mysql_fetch_array($sql_result, MYSQL_ASSOC)) {
	   		foreach ($row as $key=>$value) 
			{ 
				$data[$key] = $value; 
			}
  		}
	} else {
		_log_err($pb, 'DATABASE', __FUNCTION__, __LINE__, __FILE__, 'NO RECORDS RETURNED: 0');
	}

	_log_msg($pb, 'INFO', 'model: ' . $pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['model'] . ' Function: ' . __FUNCTION__);
	return($data);
}

// IS THIS USED ANYMORE? 2/20/10
function _find_maintenance_page($pb)
{
	$pb['DATABASE']['sql'] = "SELECT page_id from pb_page WHERE page_type = 'MAINTENANCE' LIMIT 1";
	$pb['DATABASE']['func_cback'] = __FUNCTION__ . ', ' . __LINE__;
	$sql_result = query_exec($pb, $pb['DATABASE']['sql']);	
	
	if($pb['DATABASE']['result_count'] > 0) 
	{ 
		while ($row = mysql_fetch_array($sql_result, MYSQL_ASSOC)) {
	   		foreach ($row as $key=>$value) 
			{ 
				$data = $value;
			}
  		}
	} else {
		_log_err($pb, 'DATABASE', __FUNCTION__, __LINE__, __FILE__, 'NO RECORDS RETURNED: 0');
	}

	_log_msg($pb, 'INFO', 'model: ' . $pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['model'] . ' Function: ' . __FUNCTION__);
	return($data); // $data
}


/* End of file */
/* Location: ./pb-modules/pages/model.php */