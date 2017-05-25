<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * pb-system.php
 * Contains functions for system-level actions like preint_r modification, maintenance
 * debug, errors, logs, ets.
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org
 */
 
 function show_sad_browser()
 {
 	$file = PB_ROOT . '/pb-views/bad_browser.php';
 
  		if(file_exists($file))
		{
			include($file);
			__log_file($file, __FUNCTION__);
			
		} 
		
 }
 
 function show_404() 
 {
	
 	global $pb, $layout;
 	$pb['LAYOUT']['404'] = TRUE;
	
	// check for a cache file HERE and use it if we find it!
	if(USE_CACHE == TRUE) 
	{
		//_get_cache_file('maintenance.cache');
	} else {
	 	$pb['DATABASE']['sql'] = "SELECT * from pb_page WHERE page_type = '404' LIMIT 1";
		$pb['DATABASE']['func_cback'] = __FUNCTION__ . ', ' . __LINE__;
		$sql_result = query_exec($pb, $pb['DATABASE']['sql']);	
	
		if($pb['DATABASE']['result_count'] > 0) 
		{ 
			while ($row = mysql_fetch_array($sql_result, MYSQL_ASSOC)) {
		   		foreach ($row as $key=>$value) 
				{ 
					$data[$key] = $value; 
					//$pb['LAYOUT'][$key] = $value; 
					//$pb['LAYOUT']['template'] = $value;
				}
	  		}
		} else {
			_log_err($pb, 'DATABASE', __FUNCTION__, __LINE__, __FILE__, '404-NO RECORDS RETURNED');
			// check for default error_404.php file in the system VIEW directory
		}
					//'heading' => '404 Page Not Found', // match $page_title
					//'message' => 'The page you requested was not found.', // match $page_content
		
		//Similar to how a controller builds a page, but inside a library file.
		
		$layout	=	array(
					'view' => 'error_404.php',
					'heading' => $data['page_title'],
					'message' => $data['page_content'],
					'template' => $data['page_template'],
					'content' => array(
								'page_title' => $data['page_title'], 
								'page_slug' => $data['page_slug'])
					);
		
		display($layout);
	}
 }
 
 function _show_maintenance($pb) 
 {
	global $layout;
 	$pb['LAYOUT']['MAINTENANCE'] = TRUE;
	
	// check for a cache file HERE and use it if we find it!
	if(USE_CACHE == TRUE) 
	{
		//_get_cache_file('error-404.cache');
	} else {
		_dbopen($pb);
	 	$pb['DATABASE']['sql'] = "SELECT * from pb_page WHERE page_type = 'MAINTENANCE' LIMIT 1";
		$pb['DATABASE']['func_cback'] = __FUNCTION__ . ', ' . __LINE__;
		$sql_result = query_exec($pb, $pb['DATABASE']['sql']);	
	
		if($pb['DATABASE']['result_count'] > 0) 
		{ 
			while ($row = mysql_fetch_array($sql_result, MYSQL_ASSOC)) {
		   		foreach ($row as $key=>$value) 
				{ 
					$pb['LAYOUT'][$key] = $value; 
					//$pb['LAYOUT']['template'] = $value;
				}
	  		}
		} else {
			_log_err($pb, 'DATABASE', __FUNCTION__, __LINE__, __FILE__, 'MAINTENANCE-NO RECORDS RETURNED');
		}
		
		_dbclose($pb);
		
		//if is_admin == TRUE then we just want to create a NOTIFICATION and not use the "maintenance" view.
			// _add_notification('MAINTENANCE ENABLED.<br />You must be logged out of ADMIN to see the maintenance view');
		//else DISPLAY similar to how a controller builds a page, but inside a library file.
		// 'heading' => 'Boo! Hoo! Maintenance', // match $page_title
		// 'message' => 'This site is currently undergoing some TLC, be back in a jiffy', // match $page_content
		
		$layout	=	array(
					'view' => 'maintenance.php',
					'heading' => $pb['LAYOUT']['page_title'],
					'message' => $pb['LAYOUT']['page_content'],
					'template' => $pb['LAYOUT']['page_template'],
					'content' => array(
								'page_title' => 'Maintenance', 
								'page_slug' => 'Maintenance')
					);
					
		display($layout);
	}
 }

/* Add error to $pb[_ERRORS] index
 * @since	0.1.0
 * @param	array   $pb        global pb_array
 * @param	str   	$index	  	name of index in array
 * @param	str   	$func       php constant for capturing FUNCTION name
 * @param	str   	$line       php constant for capturing LINE number
 * @param	str   	$file		php constant for capturing FILE name
 * @param	str   	$msg        error msg
 * @return  TRUE
 * USAGE: add_err($pb, $index, $func, $line, $file, $msg);
 */
function _log_err($pb, $index, $func, $line, $file, $msg)
{	
	if(isSet($pb['-ERRORS'][$index])) 
	{
		$e = count($pb['-ERRORS'][$index]);
	} else {
		$e=0;
	}
	
	if($index == 'CUSTOM_ERROR_FUNC') 
	{
	$long_msg = $msg;
	} else {
	$long_msg = $msg . '-> Line ' . $line . '-> function: ' . $func . '-> file: ' . $file;
	}
	
	$pb['-ERRORS'][$index][$e] = $long_msg;
	_log_msg($pb, '__ERROR_WARNING', $long_msg);
	
	return(TRUE);
}


function sys_fail($pb, $msg)
{
	print "<div style=\"background: #ffcccc; border: 2px solid #cc0000; padding: 10px;\">";
	print "system failure<br />";
	print $msg;
	print "</div>";
}

/* End of file */
/* Location: ./pb-libraries/pb-system.php */