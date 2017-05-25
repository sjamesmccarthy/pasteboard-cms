<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * pb-render.php
 * Contains functions for building the page and displaying it.
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org
 */
 
 /* Parsing the URL whether it is using mod_rewrite or standard $_GET query string
 * If mod_rewrite is enabled it will write values to $pb['VARS'] array and to the super-global $_GET
 * If using standard QUERY_STRING all values will be rewritten to $_GET 
 *
 * without mod_rewrite:
 * http://ladybug.pasteboard.org/?c=module&m=action&i=23&color=green&where=reno&limit=31,60
 *
 * with mod_rewrite:
 * http://ladybug.pasteboard.org/module/action/23/?&color=green&where=reno&limit=31,60
 *
 * First 3 params are required: c=module / f=function_action / i=id 
 * (these can be reassigned in configsite.php)
 *
 * @since	0.1.0
 */

 function _uri_segment($pb, $ext_script = FALSE) 
{   
	$pb['VARS'] = array();
    $pb['URI_SEG']['uri_path'] = $_SERVER['REQUEST_URI'];
	$URI_elements = explode('/', $pb['URI_SEG']['uri_path']);
	$URI_elements = array_filter($URI_elements);
	$e=0; // for errors array element
	
	// SCRIPT EXECUTION
	// if URI includes .php then locate element in URI array; otherwise move on
	if (preg_match("/\.php/i", $pb['URI_SEG']['uri_path'])) 
	{
		$ext_script = TRUE;
		foreach($URI_elements as $key => $value)
		{
			if(preg_match("/\.php/i", $value))
			{
			$script_name = $value;
			}
		}
		
		// Check to see if the script exists in /pb-sites/[site]/scripts/ and execute
		$exec_path = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/' . PB_SCRIPTS_PATH . $script_name;
		if(file_exists($exec_path)) 
		{ 
			include($exec_path); 
			exit;
		} else {
			_log_err($pb, 'URI_SEGMENTING', __FUNCTION__, __LINE__, __FILE__, 'Script Not Found: ' . $script_name);
			redirect('/');
		}

	}
	
	// Check to see if the REQUEST_URI is the homepage
    if($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/?')
    {    
         //_routing function: IS_FRONT
         $pb['ROUTER']['is_front'] = 'TRUE';
         $pb['VARS'][CONTROLLER_TRIG] = 'page';
		 $pb['VARS'][FUNCTION_TRIG] = 'view';
		 $pb['VARS'][ID_TRIG] = '0';
		 $pb['URI_SEG']['uri_type'] ='INDEX_WEBROOT';
		 _log_msg($pb, 'INFO','_uri_segment: FRONT PAGE');
    } else {
	// Not the homepage so lets check out the URI and make some decisions
	
			$pb['ROUTER']['is_front'] = 'FALSE';
			$pb['ROUTER']['WHERE'] = 'SINGLE';
			         
			$keys = array(1=>CONTROLLER_TRIG, FUNCTION_TRIG, ID_TRIG);
			
			// init the TRIG array elements; nothing else
			foreach ($keys as $newelement) 
			{ 
				$pb['VARS'][$newelement] = ''; 
			} 

			// Determine what kind of URI (QUERY_STRING or SEGMENT_PATH or MIX this is by the URI_elements split
			if(preg_match("/\?/i", $URI_elements[1])) // removed,  || count($URI_elements) == 1, on 2/19/10
			{
				$pb['URI_SEG']['uri_type'] ='QUERY_STRING';
				
				$parse_split = array();
				parse_str(substr($URI_elements[1], 1), $parse_split);
				$pb['VARS'] = array_merge($pb['VARS'], $parse_split);
				$_GET = array_merge($_GET, $parse_split); 	

			} else {

				$i=1;
				$pb['URI_SEG']['uri_type'] ='SEGMENT_PATH';
				
					foreach ($URI_elements as $value)
					{
						$duplicate = FALSE;

						if(trim($value) != '') 
						{
							// if there is faux query_string data appended to the URI split apart in name/value pairs
							if (preg_match("/\?/i", $value)) 
							{	
								$pb['URI_SEG']['uri_type'] ='SEGMENT_PATH_WITH_QUERY_STRING';
								
								$parse_split = array();
								parse_str($value, $parse_split);	

									// check to see if the SEG_QRY_STR was attached to a segment element
									// if so clean it up to create separate variable elements in the array
									foreach ($parse_split as $key_tmp => $value_tmp) 
									{
										if(preg_match("/\?/i", $key_tmp))
										{
											$key_split = explode('?', $key_tmp);
											$parse_split[$key_split[1]] = $value_tmp;
											
												// flag warning in ERROR array and create create the orphaned var
												if($key_split[0] != '') 
												{
													$parse_split[$key_split[0]] = $key_split[0];
													_log_err($pb, 'URI_SEGMENTING', __FUNCTION__, __LINE__, __FILE__, 'Malformed SEG_QRY_STR "' . $key_tmp . ' ' . $value_tmp . '" Always separate with forward slash');
												}
												
											unset($parse_split[$key_tmp]);
										}
										
									}
										
								$pb['VARS'] = array_merge($pb['VARS'], $parse_split);
								$_GET = array_merge($_GET, $parse_split);   

							// otherwise treat like a regular / separated URI and segment
							} else {
															
									if($i <= count($keys)) 
									{   
										// this is one of the TRIG keys
										$pb['VARS'][$keys[$i]] = $value;
										$_GET[$keys[$i]] = $value;									
									} else {
										
										// this is a parameter. make sure the parameter IS_NOT a TRIG key
										if(array_key_exists($value, $pb['VARS']))
										{
											_log_err($pb, 'URI_SEGMENTING', __FUNCTION__, __LINE__, __FILE__, 'Duplicate KEY found');
											$duplicate = TRUE;
										}
										
										if($duplicate == TRUE) 
										{
											$key_value = $value . '_DUPLICATE';
										}
										else {
											$key_value = $value;
										}
										
										$pb['VARS'][$key_value] = $value;
										$_GET[$key_value] = $value;
									}   
							}
						}    
					$i++;        
					}
			}
	_log_msg($pb, 'INFO','_uri_segment: SECONDARY PAGE FOUND w/ID: ' . $pb['VARS'][ID_TRIG]);
    }

	// Regardless of is_front or app, SET ROUTER indexes
	$pb['ROUTER']['app'] = $pb['VARS'][CONTROLLER_TRIG];
	$pb['ROUTER']['function'] = $pb['VARS'][FUNCTION_TRIG];
	$pb['ROUTER']['id'] = $pb['VARS'][ID_TRIG];
	if(isSet($pb['VARS']['profiler'])) { $_SESSION['PROFILER'] = $pb['VARS']['profiler']; }
	
	_log_msg($pb, 'info', '_uri_segment: ' . $pb['URI_SEG']['uri_type']);
	return(TRUE);
}

function __uri_route($pb)
{
	// this will allow you to rewrite your URL to something different
	// http://www.pb.org/page/example-sub-page -> http://www.pb.org/page/view/2/
}

/* End of file */
/* Location: ./pb-libraries/pb-system.php */