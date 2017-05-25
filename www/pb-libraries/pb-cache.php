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
 
/* whatami? maintenance, page, blog, review, article, forum, etc.
 * first three params are: [c] controller, [m] model/function, [i] id.
 * these can be customized to something else in the configsite.php file.
 *
 * @since	0.1.0
 * @param	array   $pb        global pb_array
 */

function __cache_display($cache_file) 
{
	//redirect($cache_file)
	//or include_once($cache_file);
	
}

function __cache_write($pb) 
{
	// if(USE_CACHE == TRUE)
	// if($pb['CACHE']['status'] == 'WRITE') 
	// fput($pb['CACHE']['content'], cache_dir/$c_$i.html)
	// 
	
}

function __cache_get($pb) 
{
	// if(USE_CACHE == TRUE)
	// fopen(cache_dir/$c_$i.html
	// find expiration and check
	// if(CACHE_PAGE == TRUE)
	// $pb['CACHE']['status'] = 'READ';
	// $CACHED_PAGE_CONTENT = include(cache_dir/$c_$i.html); ($page = ob_get_contents)
	// return($CACHED_PAGE_CONTENT)
	
	// else unlink(cache_dir/$c_$i.html);
	//$pb['CACHE']['status'] = 'WRITE';
	// return(FALSE);

}

function _cache_check($pb) 
{
		#$pb['CACHE']['dir'] = '/' . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/cache/' . $pb['VARS']['_GET'][CONTROLLER_TRIG] . '/' ;
		// $pb['CACHE']['dir'] = '/' . PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/cache/' . $pb['VARS'][CONTROLLER_TRIG] . '/' ;
		// if FILE_EXISTS(cache_dir/$c_$i.html)
		//	__cache_get
		_log_msg($pb, 'INFO','_cache_check: ' . USE_CACHE . '/Not Implemented');	
		// return TRUE
		// http://www.snipe.net/2009/03/quick-and-dirty-php-caching/
}

/* End of file */
/* Location: ./pb-libraries/pb-system.php */