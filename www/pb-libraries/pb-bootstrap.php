<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * pb-bootsrap.php
 * A process controller to the front-end controller (index.php) that
 * loads all framework libraries and hands site & page data to viewer.
  *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org
 */
 
/* Get ready, set, go!  Hang on, this could be Mr. Toad's wild ride through 
 * a maze of programming fun, but we hope not there isn't too much smoke and mirrors.
 * @since	0.1.0
 * @param	array   $pb        global pb_array
 * @return  TRUE
 */

function _bootstrap($pb)         
{     
	// function name							// array index in $pb and brief description
	_benchmark($pb,'__framework','TIMER_ON'); 	// ['BENCHMARK'] start timer (beta only)
    __init_libs($pb, 'AUTO_ALL'); 			// ['AUTOLOAD'] load required framework libraries
   $pb = __sitewhoami($pb); 							// ['SITE_INFO'] determine the website being used, set CONFIG items for site-specifics
    __init_log($pb); 							// ['LOG'] initializes the log file (creates if not found)
    _uri_segment($pb);  						// ['URI_SEG'] creates pb->VARS->_GET array, plus populates super-global _GET array  
    _useragent($pb); 							// ['USERAGENT'] determine users platform and browser
    _init_session($pb); 						// ['SESSION'] initializes the PHP _SESSION var, does a few DB actions too
	__route_page($pb);							// ['ROUTER'] determines what to do: cache, load app, maintenance
	_benchmark($pb,'__framework','TIMER_OFF'); 	// ['BENCHMARK'] stop timer (beta only)
	_log_msg($pb, 'INFO','pasteboard.Complete (' . $pb['BENCHMARK']['__framework']['time'] . ' seconds)');	
	_output_page($pb); 							// Displays the rendered webpage
}

/* Load the config file for the specific site. Remember the default site is in the /sites/default folder.
 * @since	0.1.0
 * @param	array   $pb        global pb_array
 * @return  TRUE
 */
function __sitewhoami($pb) 
{ 	
	
    $site_url = parse_url($_SERVER['HTTP_HOST']);
    $pb['SITE_INFO']['SITE_URL'] = 'http://' . $site_url['path']; 
 
    $sites_base = PB_ROOT . '/' . PB_SITES_PATH;
    
		if(file_exists($sites_base . $site_url['path'] . '/' .'configsite.php'))
		{
			$pb['SITE_INFO']['is_custom'] = 'TRUE';	
            $pb['SITE_INFO']['site'] = $site_url['path'];            
            $pb['SITE_INFO']['config_file_path'] = $sites_base . $site_url['path'] . '/' .'configsite.php';
            
		} else {
            $pb['SITE_INFO']['is_custom'] = 'FALSE';	
			if(file_exists($sites_base . 'default' . '/' .'configsite.php'))
			{
                $pb['SITE_INFO']['site'] = 'default'; // overwriting for default site
                $pb['SITE_INFO']['config_file_path'] = $sites_base . 'default' . '/' .'configsite.php';
			}
		}
    
    // print "<pre>";
    // print $sites_base . 'default' . '/' .'configsite.php<hr />';
    // print_r($pb);
    require($pb['SITE_INFO']['config_file_path']);
	
	// Adding THEME into $pb array
	$pb['SITE_INFO']['theme'] = THEME;
	$pb['SITE_INFO']['theme_path'] = $pb['SITE_INFO']['site'] . '/themes/' . THEME . '/';
	
	$pb['SITE_INFO']['admin_theme'] = ADMIN_THEME;
	$pb['SITE_INFO']['admin_theme_path'] = $pb['SITE_INFO']['site'] . '/themes/admin/' . ADMIN_THEME . '/';
	
    $pb['SITE_INFO']['timezone'] = date_default_timezone_get();
	
    $pb['LOG']['PRELOAD'][] = 'info|_set_timezone: ' . $pb['SITE_INFO']['timezone'];
    $pb['LOG']['PRELOAD'][] = 'info|_sitewhoami: ' . $pb['SITE_INFO']['site'] . ' Initialized';
	
	return($pb);
}

/* Autoloads the required library files. 
 * @since	0.1.0
 * @param	array   $pb	     		array that contains files to autoload
 * @param 	int     $mode           not used now, unsure of original purpose
 * @return  TRUE
 */
function __init_libs($pb, $file='AUTO_ALL')
{    

	// variables are within the scope of this function.
	
        foreach ($pb['AUTOLOAD'] as $key=>$value) 
        {
            $i=0; // init var for count
			$files_not_loaded=''; // init var
        
            foreach ($pb['AUTOLOAD'][$key] as $filename)
            {
                $required_file = PB_ROOT . '/'. $key . '/' . $filename . '.php';
                // print $required_file . "<hr />";

                    if(file_exists($required_file))
                    {
                        require($required_file);
						$pb['AUTOLOAD'][$key]['file_index'][$i] = $filename;
                        unset($pb['AUTOLOAD'][$key][$i]);
                        $pb['LOG']['PRELOAD'][] = 'INCLUDE|' . 'library: ' . $filename;
                        $i++;

                    } else {
                        #system _log_error
                        unset($pb['AUTOLOAD'][$key][$i]);
                        $files_not_loaded .= $filename . '|';
                        $pb['LOG']['PRELOAD'][] = 'error|' . $key . ' file not found: ' . $filename;
					}
            }
            $pb['AUTOLOAD'][$key]['files_loaded'] = $i;
            if(!empty($files_not_loaded)) $pb['AUTOLOAD'][$key]['errors'] = substr($files_not_loaded,0,-1); 
        }
        
	return($pb);	
}

/* Get ready, set, go!  Hang on, this could be Mr. Toad's wild ride through 
 * a maze of programming fun, but we hope not there isn't too much smoke and mirrors.
 * @since	0.1.0
 * @param	array   $pb        global pb_array
 * @return  TRUE
 */
function __init_log($pb)
{   
    $pb['LOG']['id'] = date("YmdHis");

    // print "<pre>";
    // print_r($pb);

    if(PB_LOG_STATUS == TRUE) 
    {
		# PB_ROOT . 
        $logfile_dir = PB_ROOT . '/' . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/' . PB_LOG_PATH;

        // print $logfile_dir . "<hr />";

        $logfile = $logfile_dir . 'log-' . date ('mdy') . '.php';

		// check to see if the DIRECTORY exists (not the file)
        if(file_exists($logfile_dir)) 
        {
            $pb['LOG']['dir'] = 'TRUE';            
            if(file_exists($logfile)) // now we check the file
            {
                $pb['LOG']['file_exist'] = 'TRUE';
            } else {
                fopen($logfile, CREATE_WRITE_TOP);               
            }
            $pb['LOG']['path'] = $logfile;
        }
        
        // check to see if it is writable.
        if(is_writable($logfile))
        {
            $pb['LOG']['is_writable'] = 'TRUE';
        }
        else {
            $pb['LOG']['is_writable'] = 'FALSE, FIXED';
            chmod($logfile, 0777); 
        }
        
		// Output any PRELOAD log entries for _load_library and _sitewhoami
        $i=1;
        foreach ($pb['LOG']['PRELOAD'] as $entry) 
        {
        	// Change this to EXPLODE, split has been deprecated as of PHP 5.3
            $entry = explode('|', $entry);
			if($entry[0] != "error")
			{
				_log_msg($pb, $entry[0],$entry[1]);
			} else {
				_log_err($pb, 'PRELOAD', __FUNCTION__, __LINE__, __FILE__, $entry[1]);
			}
        }
       
	   // remove PRELOAD index from array
        unset($pb['LOG']['PRELOAD']);
    }

	return($pb);
}

function __init_app($pb)
{ 
	// Setup path information for the app
	$pb['ROUTER']['path_app'] = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/' . PB_APPS_PATH . $pb['ROUTER']['app'] . '/';
	$pb['ROUTER']['path_models'] =  $pb['ROUTER']['path_app'] . 'models/';
	$pb['ROUTER']['path_views'] = $pb['ROUTER']['path_app'] . 'views/';
	$controller_file = $pb['ROUTER']['app'] . '_controller.php';
	
		if(file_exists($pb['ROUTER']['path_app'] . $controller_file))
		{
			$pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['name'] = $pb['ROUTER']['app'];
			$pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['controller'] = $controller_file;
			include_once($pb['ROUTER']['path_app'] . $controller_file);
		} else {
			$pb['ROUTER']['app'] = 'page';
			$pb['ROUTER']['function'] = 'view';
			_log_err($pb, 'ROUTER', __FUNCTION__, __LINE__, __FILE__, 'File Not Found: ' . $controller_file);
			show_404();
		}
}

function __route_page($pb)
{

	if(MAINTENANCE == TRUE)
	{
		_show_maintenance($pb);
	} else {
	
		// 1. Check CACHE_ENGINE == ON and there is page (/pb-sites/[site]/cache/[app]/23.cache)
		if(USE_CACHE == TRUE)
		{
			_cache_check($pb);							// ['CACHE_CHECK'] check for a cached page / load & display
		} else {
			_dbopen($pb); 								// ['DATABASE'] establish a persistent connection to the mysql database     
			__init_app($pb);							// ['APP_STATUS'] start the application, application will build the page
			_dbclose($pb); 								// ['DATABASE'] close the db connection
		}
	
	}
	
}

/* End of file */
/* Location: ./pb-libraries/pb-bootstrap.php */ 