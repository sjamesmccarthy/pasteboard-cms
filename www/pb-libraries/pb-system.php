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
 
/* Too many times have a wished the print_r statement would have a (MAKE_PRETTY) flag.
 * now it does! but needs to  be referenced preint_r.
 *
 * @since	0.1.0
 * @param	array   $value        the array that needs Pretty'ing
 * @return  str     $str          the array print_r'd smashed between <pre></pre>
 */
function preint_r($value, $ret=FALSE) 
{
	if($ret == FALSE) 
	{
		print '<pre>';
		print_r($value);
		print '</pre>';
	} else {
		$str = print_r($value);
		return($str);
	}	
}

function array_mash_pb($pb, $layout)
{
	foreach ($layout as $key => $value)
	{
		$pb['LAYOUT'][$key] = $value;
	}
}

/* Santitizes a string
 * 
 * @since	0.1.0
 * @return  str     $str		Removes special characters like $!%^()[]{}:\/@#&*<>, and replaces [spaces] with -         
 */
function sanitize($str) 
{
	$bad_chars = array('$','\'','"','!','%','^','[',']','{','}','(',')',':',';','/','@','#','&','*','<','>',',','.');
	trim($str);
	$str = str_replace($bad_chars, '', $str);
	$str = str_replace(' ', '-', $str);
	return($str);
}

function load_view($file_name, $type='null') 
{
	global $pb, $layout;
	$app_view = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/' . PB_APPS_PATH . $pb['ROUTER']['app'] . '/views/';
	
	// extract arrays into VARS
	if(!empty($layout)) extract($layout, EXTR_PREFIX_SAME, "pb");
	if(!empty($pb['SITE_INFO'])) extract($pb['SITE_INFO'], EXTR_PREFIX_SAME, "pb");
	if(!empty($pb['LAYOUT']['content'])) extract($pb['LAYOUT']['content'], EXTR_PREFIX_SAME, "pb");
	if(!empty($pb['LAYOUT'])) extract($pb['LAYOUT'], EXTR_PREFIX_SAME, "pb");
	if(!empty($pb['VARS'])) extract($pb['VARS'], EXTR_PREFIX_SAME, "pb");
	
	#if(empty($pb['LAYOUT']['404']) AND MAINTENANCE == FALSE) 
	#{
		#$ext_var = $pb['LAYOUT']['content']; 
	#} #else {
		#$ext_var = $layout;
	#}
	
	if($pb['ROUTER']['app'] == 'admin')
	{
		$theme_view = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/themes/' . ADMIN_THEME . '/views/';
		#extract($pb['SITE_INFO'], EXTR_PREFIX_SAME, "pb");		
	} else {
		$theme_view = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/themes/' . THEME . '/views/';
		#extract($ext_var, EXTR_PREFIX_SAME, "pb");
	}
	
	#extract($pb['VARS'], EXTR_PREFIX_SAME, "pb");
	#extract($layout, EXTR_PREFIX_SAME, "pb");

	// look to see if .php is in the $file_name var; if not add it.
	if(!preg_match("/.php/i", $file_name)) { $file_name = $file_name . ".php"; }
	
	// first check to see if the view is part of an app (most likely)	
	if(file_exists($app_view . $file_name))
	{
		include_once($app_view . $file_name);
	} else {
		// if not, check to see if it's located in the themes directory includes folder
		if(file_exists($theme_view . $file_name))
		{
			include_once($theme_view . $file_name);
		} else {
			// _log_err($pb, 'SYSTEM', __FUNCTION__, __LINE__, __FILE__, 'View File Not Found: ' . $file_name);
			sys_fail($pb, 'view file: ' . $file_name . ' not found (function: ' . __FUNCTION__ . ')');
		}
	}
}

function load_template($file_name, $type='null') 
{
	global $pb;
	
	// extract arrays into VARS
	if(!empty($layout)) extract($layout, EXTR_PREFIX_SAME, "pb");
	if(!empty($pb['SITE_INFO'])) extract($pb['SITE_INFO'], EXTR_PREFIX_SAME, "pb");
	if(!empty($pb['LAYOUT']['content'])) extract($pb['LAYOUT']['content'], EXTR_PREFIX_SAME, "pb");
	if(!empty($pb['LAYOUT'])) extract($pb['LAYOUT'], EXTR_PREFIX_SAME, "pb");
	if(!empty($pb['VARS'])) extract($pb['VARS'], EXTR_PREFIX_SAME, "pb");
	
	if($pb['ROUTER']['app'] == 'admin')
	{
		$file_name = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/' . PB_THEMES_PATH . PB_ADMIN_THEMES_PATH . ADMIN_THEME . '/templates/' . $pb['LAYOUT']['template'];
		#extract($pb['SITE_INFO'], EXTR_PREFIX_SAME, "pb");
	} else {
		$file_name = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['theme_path'] . 'templates/' . $pb['LAYOUT']['template'];
		#extract($pb['LAYOUT']['content'], EXTR_PREFIX_SAME, "pb");
	}
		
	#extract($pb['VARS'], EXTR_PREFIX_SAME, "pb");
	
	if(!preg_match("/.php/i", $file_name)) { $file_name = $file_name . ".php"; }
	
	#/Users/james/Dropbox/PASTEBOARD_FRAMEWORK/www//pb-sites/default/themes/serendipity/templates/index.php
	#/home/pasteboard/www/sites/_pasteboard-dev-alpha/pb-sites/default/themes/serendipity/templates/index.php
	#print $file_name; exit;
	if(file_exists($file_name))
	{
		include_once($file_name);
	} else {
		// _log_err($pb, 'SYSTEM', __FUNCTION__, __LINE__, __FILE__, 'Template Not Found: ' . $file_name);
		sys_fail($pb, 'template file: ' . $file_name . ', not found (function: ' . __FUNCTION__ . ')');
	}	
}

function load_model($file_name, $type='null') 
{
	global $pb;
	$pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['model'] = $file_name;
	
	if(file_exists($pb['ROUTER']['path_models'] . $file_name))
	{
		include_once($pb['ROUTER']['path_models'] . $file_name);
	} else {
		// _log_err($pb, 'ROUTER', __FUNCTION__, __LINE__, __FILE__, 'Model Not Found: ' . $file_name);
	}
}

function load_helper($file_name, $type='null') 
{
	global $pb; // using global so not to clutter the arguments
	$files = explode(',', $file_name);
			
	if(!isSet($pb['HELPERS']['list'])) $pb['HELPERS']['list'] = '';
	
	foreach ($files as $name)
	{
		if(!preg_match("/_helper.php/i", $name)) 
		{ 
			$file_name = $name . "_helper.php"; 
		} else {
			$file_name = $name;
		}
		
		// fist check main /helpers
		$helper_file = PB_ROOT . PB_HELPERS_PATH  . $file_name;
		if(file_exists($helper_file))
		{
			$include_file = $helper_file;
		} else  {
		
			// check app /helpers
			$helper_file = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/' . $pb['ROUTER']['app'] . '/helpers/';
			if(file_exists($helper_file))
			{
				$include_file = $helper_file;
				$helper_list .= $file_name . ', ';
			}
			
		}
		if (count($files) > 1) { $add_comma = ', '; } else { $add_comma = ''; }
		$pb['HELPERS']['list'] .= $file_name . $add_comma;
		include_once($include_file);
	}
}
function _getLocationByIP($ip)
{ 
$NetGeoURL = "http://api.hostip.info/get_html.php?ip=".$ip; 
 
if($NetGeoFP = fopen($NetGeoURL,"r"))
{ 
ob_start();
fpassthru($NetGeoFP);
$NetGeoHTML = ob_get_contents();
ob_end_clean();
fclose($NetGeoFP);
}
	$location = split(':', $NetGeoHTML);
	return $location[2];
}

function redirect($location) 
{
	header('Location: ' . $location);
	exit;
}


/* Calculates the time based on microtime() or returns the current Unix timestamp with microseconds.
 * @since	0.1.0
 * @return  the time in microseconds
 */
function __timer() 
{
	#list($usec, $sec) = explode(" ", microtime());
	#return ((float)$usec + (float)$sec);
    return microtime(TRUE); // only works with PHP5, EXPERT: comment out this line, uncomment the two lines above.
}

/* resets the benchmark request and removes it from the $pb array  
 * @since	0.1.0.0
 * @param	array   $pb        global pb_array
 * @param 	str     $tName      the name of the timer, if none is specified defaults to ALL
 * @return  TRUE
 */
function _benchmarkreset($pb, $tName='ALL')
{
	$rTimer = explode(',', $tName);
	
	if($rTimer[0] === "ALL") 
	{
		foreach($pb['BENCHMARK'] as $key => $value)
	 	{
	 		unset($pb['BENCHMARK'][$key]);
	 	}
	} else {
		foreach($rTimer as $i) { unset($pb['BENCHMARK'][$i]); }
	}
}

/* System Timer, independent of benchmark library
 * @since	0.1.0
 * @param	array   $pb        global pb_array
 * @param	str     $toggle     Toggles between start(1) and stop(0)
 * @return  the time in seconds
 */
function _benchmark($pb, $tName='default', $toggle='TIMER_ON') 
{
    $button = __timer();

    switch($toggle)
    {
        case "TIMER_ON":
        $pb['BENCHMARK'][$tName]['ON'] = $button;
        break;
        
        case "TIMER_OFF":
        $start_time = (int) $pb['BENCHMARK'][$tName]['ON'];
        $pb['BENCHMARK'][$tName]['time'] = round(($button-$start_time), 3);
		$pb['BENCHMARK'][$tName]['mem_usage'] = __get_memory_usage(TRUE);
		//memory_get_usage();
		unset($pb['BENCHMARK'][$tName]['ON']);
        break;
        
        default:
        //log error
        break;
    }
    
}

function __get_memory_usage($round=FALSE) 
{
	$mem_usage = memory_get_usage();
	
	if($round == TRUE)
	{
		if ($mem_usage < 1024)
			$result = $mem_usage . " b"; 
		elseif ($mem_usage < 1048576) 
			$result = round($mem_usage/1024,2) . " Kb"; 
		else 
			$result = round($mem_usage/1048576,2) . " MB"; 
	} else {
		$result = $mem_usage;
	}
	
	return($result);
}

function _add_notification($msg)
{
	global $pb;
	
	if(isSet($pb['NOTIFICATIONS'])) 
	{
		$n = count($pb['NOTIFICATIONS']);
	} else {
		$n=0;
	}
	
	$pb['NOTIFICATIONS'][$n] = $msg;
	return(TRUE);
}

/** 
 * We will set the error handler to call back the funtion CUSTOM_ERROR that is inside this file.
 * The reason for that is to just pretty-up a line of text for the log file; nothing else fancy going on.
 * FATAL_ERRORS will not be logged
 */
function _custom_error($errno, $errstr, $errfile, $errline)
{
	/* If this function is found it is ran automatically */
	
    global $pb;

    switch($errno)
    {
    
    case "2":
    $errname = 'E_WARNING';
    break;
    
    case "8":
    $errname = 'E_NOTICE';
    break;

    case "256":
    $errname = 'E_USER_ERROR';
    break;

    case "512":
    $errname = 'E_USER_WARNING';
    break;
 
    case "1024":
    $errname = 'E_USER_NOTICE';
    break;

    case "4096":
    $errname = 'E_RECOVERABLE_ERROR';
    break;

    case "8191":
    $errname = 'E_ALL';
    break;
    
    default:
    $errname ='UNKNOWN_ERROR_TYPE';
    break;
    
    }
    
    $msg =  "[$errno, $errname] $errstr [$errfile, $errline]";
	// _log_err($pb, 'CUSTOM_ERROR_FUNC', __FUNCTION__, __LINE__, __FILE__, $msg);
	
	return(TRUE);
} 

function _check_func($pb)
{
	if(!function_exists($pb['ROUTER']['function']))
	{
		// _log_err($pb, 'BOOTSTRAP', __FUNCTION__, __LINE__, __FILE__, 'Function Does Not Exist: ' . $pb['ROUTER']['function']);
		#if($pb['ROUTER']['app'] != 'admin') { sys_fail($pb, 'function does not exist: ' . $pb['ROUTER']['function'] . ' for APP: <b> ' . $pb['ROUTER']['app']) . '</b>'; }
	} else {
		return(TRUE);
	}
}

/* End of file */
/* Location: ./pb-libraries/pb-system.php */