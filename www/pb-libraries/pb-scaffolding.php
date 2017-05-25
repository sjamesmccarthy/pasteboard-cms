<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * pb-templatehooks.php
 * A library file containing functions that make creating a template easier.
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
 function _output_page($pb)
{ 
	print $pb['PAGE'];
	_display_diagnostics($pb);
	#preint_r($pb);
}

function display($layout)
{
	global $pb;
	array_mash_pb($pb, $layout);

	$pb['TMP'] = 'load.view';
	ob_start();
	load_view($pb['LAYOUT']['view']);
	$pb['VIEW'] = ob_get_contents();
	ob_end_clean();	 

	$pb['TMP'] = 'load.tpl';
	ob_start();
	load_template($pb['LAYOUT']['template']);
	$pb['PAGE'] = ob_get_contents();
	ob_end_clean();	
	
	unset($pb['TMP']);
}

function _display_diagnostics($pb)
{
	#if($_SESSION['PROFILER'] == 1) { $pb['VARS']['profiler'] = 1; }
	
	if($_SESSION['PROFILER'] == 1)
	{
		load_helper('diagnostics_helper.php');
		$view_diagnostics = format_diagnostics($pb);
		print $view_diagnostics;
	}
}

function get_view($file=NULL)
{
	// THIS FUNCTION RETURNS TO THE TEMPLATE
	global $pb;
	
	if(is_null($file)) {
		$view_dump = $pb['VIEW'];
		unset($pb['VIEW']);
		return($view_dump);

	} 
	else { 
		load_view($file); 
	}
}

function get_meta($name=NULL, $value=NULL, $param=NULL) 
{
	
	global $pb;
	$tag_html = '';

	if(empty($pb['LAYOUT']['404'])) 
	{
		
	if(is_null($name)) 
	{ 
		$meta_tags = array(
			'verify-v1'						=>	$pb['SITE_INFO']['GOOGLE_SITE_VALIDATION'],
			'y-key'							=>	$pb['SITE_INFO']['YAHOO_SITE_VALIDATION'],
			'msvalidate.01' 				=> 	$pb['SITE_INFO']['BING_SITE_VALIDATION'],
			'framework'						=>	PB_NAME,
			'framework_version'				=>	PB_VERSION,
			'framework-license'				=>	PB_LICENSE,
			'framework-download-url'		=>	'http://www.' . PB_DOMAIN . '/download.php',
			'author'						=> 	$pb['SITE_INFO']['SITE_COMPANY_NAME'],
			'copyright'						=> 	$pb['SITE_INFO']['SITE_COPYRIGHT'],
			'cache-control'					=> 	$pb['LAYOUT']['content']['page_meta_cache_control'],
			'exipres'						=> 	$pb['LAYOUT']['content']['page_meta_expires'],
			'description'					=> 	$pb['LAYOUT']['content']['page_meta_description'],
			'keywords'						=> 	$pb['LAYOUT']['content']['page_meta_keywords'],
			'robots'						=> 	$pb['LAYOUT']['content']['page_meta_robots'],
			);
	
		foreach($meta_tags as $key => $value)
		{
			$tag_html .= "<meta content=\"" . $key . "\" value=\"" . $value . "\" />\n";
		}
	} else {
		if($param == 'http-equiv') 
		{
			$tag_html = "<meta http-equiv=\"" . $name . "\" content=\"" . $value . "\">\n";
		} else {
			$tag_html .= "<meta content=\"" . $name . "\" value=\"" . $value . "\" />\n";
		}
	}
	
	}
	
	return($tag_html);
}

function get_css($file='ALL', $media='screen') 
{
	// THIS FUNCTION RETURNS TO THE TEMPLATE OR VIEW
	global $pb;
	$output = '';
	
	if($pb['TMP'] == 'load.tpl') 
	{
	
	$css_found = FALSE;
	$single_css = FALSE;
	$css_html = '';

	if($pb['ROUTER']['app'] == 'admin')
	{
		$base_dir_views = PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/apps/' . $pb['ROUTER']['app'] . '/css/';
		$base_dir_theme = PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/' . PB_THEMES_PATH . PB_ADMIN_THEMES_PATH . ADMIN_THEME . '/css/';
	} else {
		$base_dir_views = PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/apps/' . $pb['ROUTER']['app'] . '/css/';
		$base_dir_theme = PB_SITES_PATH . $pb['SITE_INFO']['theme_path'] . 'css/';
	}
	
	switch($file)
	{
		case "ALL":
		$page_css = TRUE;
		$theme_css = TRUE;
		break;
		
		case "PAGE":
		$page_css = TRUE;
		break;
		
		case "THEME":
		$theme_css = TRUE;
		break;
		
		default:
		$single_css = TRUE;
	}
	
	// can I determine whether this is the TEMPLATE or VIEW being loaded and restrict to template
	if($page_css == TRUE)
	{
		$css_files_views = scandir(PB_ROOT . $base_dir_views); // PHP5 only
		if(count($css_files_views > 2)) 
		{ 
			foreach($css_files_views as $key => $value) 
			{
				if(preg_match("/.css/i", $value))
				{
				#$css_html .= "@import url(\"/" . $base_dir_views . $value ."\") $media;\n";
				$css_html .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"" . $media . "\" href=\"" . $base_dir_views . $value . "\" />\n";				
				$css_found = TRUE;	
				__log_file($file, __FUNCTION__);
				}			
			} 
		}
	}
	
	if($theme_css == TRUE)
	{
		$css_files_theme = scandir(PB_ROOT . $base_dir_theme); // PHP5 only
		if(count($base_dir_theme > 2)) 
		{ 
			foreach($css_files_theme as $key => $value) 
			{
				if(preg_match("/.css/i", $value))
				{
				#$css_html .= "@import url(\"/" . $base_dir_theme . $value ."\") $media;\n";
				$css_html .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"" . $media . "\" href=\"" . $base_dir_theme . $value . "\" />\n";
				$css_found = TRUE;
				__log_file($file, __FUNCTION__);
				}
			}
		}	
	} 
	
	if($single_css == TRUE)
	{
		// SINGLE_CSS
		if(file_exists(PB_ROOT . $base_dir_views . $file))
		{
			#$css_html .= "@import url(\"" . $base_dir_views . $file ."\") $media;\n";
			$css_html .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"" . $media . "\" href=\"" . $base_dir_views . $value . "\" />\n";		
			$css_found = TRUE;
			__log_file($file, __FUNCTION__);
		} 
		else if (file_exists(PB_ROOT . $base_dir_theme . $file))
		{
			#$css_html .= "@import url(\"/" . $base_dir_theme . $file ."\") $media;\n";
			$css_html .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"" . $media . "\" href=\"" . $base_dir_theme . $value . "\" />\n";		
			$css_found = TRUE;
			__log_file($file, __FUNCTION__);
		} else {
			$output = "<!-- CSS STYLE SHEET: $file NOT FOUND -->\n";
			_log_err($pb, 'SCAFFOLDING', __FUNCTION__, __LINE__, __FILE__, 'No SPECIFIC CSS FILE FOUND: $file');
		}
	}
	
	if($css_found == TRUE)
	{
		#$output = "<style type=\"text/css\" media=\"all\">\n" . $css_html . "</style>\n";
		$output = $css_html;
		$pb['LAYOUT']['CSS'] = TRUE;
	} else {
		$output = "<!-- NO CSS STYLE SHEETS FOUND -->\n";
		_log_err($pb, 'SCAFFOLDING', __FUNCTION__, __LINE__, __FILE__, 'No CSS FILES FOUND');
	}
	
	} // end load.tpl
	else {
		$output = '<!-- ERROR, TRYING TO LOAD CSS FILE FROM A VIEW -->';
		_log_err($pb, 'SCAFFOLDING', __FUNCTION__, __LINE__, __FILE__, 'INVALID, TRYING TO LOAD CSS FILE FROM A VIEW');
	}
	
	return($output);
}

function get_js($file='ALL') 
{
	// THIS FUNCTION RETURNS TO THE TEMPLATE OR VIEW
	global $pb;
	$output = '';

	$js_found = FALSE;
	$single_js = FALSE;
	$js_html = '';

	$base_dir_views = PB_SITES_PATH . $pb['SITE_INFO']['site'] . '/apps/' . $pb['ROUTER']['app'] . '/js/';
	$base_dir_theme = PB_SITES_PATH . $pb['SITE_INFO']['theme_path'] . 'js/';
	
	switch($file)
	{
		case "ALL":
		$page_js = TRUE;
		$theme_js = TRUE;
		break;
		
		case "PAGE":
		$page_js = TRUE;
		break;
		
		case "THEME":
		$theme_js = TRUE;
		break;
		
		default:
		$single_js = TRUE;
	}
	
	// can I determine whether this is the TEMPLATE or VIEW being loaded and restrict to template
	if($page_js == TRUE)
	{
		$js_files_views = scandir(PB_ROOT . $base_dir_views); // PHP5 only
		if(count($js_files_views > 2)) 
		{ 
			foreach($js_files_views as $key => $value) 
			{
				if(preg_match("/.js/i", $value))
				{
				$js_html .= "<script type=\"text/javascript\" language=\"javascript\" src=\"/" . $base_dir_views . $value ."\"></script>\n";
				$js_found = TRUE;	
				__log_file($file, __FUNCTION__);
				}			
			} 
		}
	}
	
	if($theme_js == TRUE)
	{
		$js_files_theme = scandir(PB_ROOT . $base_dir_theme); // PHP5 only
		if(count($base_dir_theme > 2)) 
		{ 
			foreach($js_files_theme as $key => $value) 
			{
				if(preg_match("/.js/i", $value))
				{
				$js_html .= "<script type=\"text/javascript\" language=\"javascript\" src=\"/" . $base_dir_theme . $value ."\"></script>\n";
				$js_found = TRUE;
				__log_file($file, __FUNCTION__);
				}
			}
		}	
	} 
	
	if($single_js == TRUE)
	{
		// SINGLE_CSS
		if(file_exists(PB_ROOT . $base_dir_views . $file))
		{
			$js_html .= "<script type=\"text/javascript\" language=\"javascript\" src=\"/" . $base_dir_views . $file ."\"></script>\n";
			$js_found = TRUE;
			__log_file($file, __FUNCTION__);
		} 
		else if (file_exists(PB_ROOT . $base_dir_theme . $file))
		{
			$js_html .= "<script type=\"text/javascript\" language=\"javascript\" src=\"/" . $base_dir_theme . $file ."\"></script>\n";
			$js_found = TRUE;
			__log_file($file, __FUNCTION__);
		} else {
			$output = "<!-- JS STYLE SHEET: $file NOT FOUND -->\n";
			_log_err($pb, 'SCAFFOLDING', __FUNCTION__, __LINE__, __FILE__, 'No SPECIFIC CSS FILE FOUND: $file');
		}
	}
	
	if($js_found == TRUE)
	{
		$output = $js_html;
		$pb['LAYOUT']['JS'] = TRUE;
	} else {
		$output = "<!-- NO JS FILES FOUND -->\n";
		_log_err($pb, 'SCAFFOLDING', __FUNCTION__, __LINE__, __FILE__, 'No JS FILES FOUND');
	}
		
	return($output);
}

function get_fav_icon($file='favicon.ico')
{
	global $pb;
	$base_fav_file = PB_SITES_PATH . $pb['SITE_INFO']['theme_path'] . 'images/' . $file;
	$fav_html = '';
	
	if (file_exists($base_fav_file)) {
		$fav_html = "<link rel=\"shortcut icon\" href=\"/" . $base_fav_file . "\" type=\"image/x-icon\" />\n";
   		__log_file($file, __FUNCTION__);
    } else {
		_log_err($pb, 'SCAFFOLDING', __FUNCTION__, __LINE__, __FILE__, 'No favicon FILE FOUND');
    }
	
	return($fav_html);
}

function get_base_url()
{
	// THIS FUNCTION RETURNS TO THE TEMPLATE
	global $pb;
	$base_html = "<base href=\"" . $pb['SITE_INFO']['SITE_URL'] . "\" />\n";
	return($base_html);	
}

function get_title()
{
	// THIS FUNCTION RETURNS TO THE TEMPLATE
	global $pb;
	$title = $pb['LAYOUT']['content']['page_title'];
	return($title);
}

function get_header($file='header.php') 
{
	// THIS FUNCTION RETURNS TO THE TEMPLATE
	global $pb;
	$base_header_file = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['theme_path'] . 'includes/' . $file;

    if (file_exists($base_header_file)) {
		include_once($base_header_file);
		__log_file($file, __FUNCTION__);
    } else {
		_log_err($pb, 'SCAFFOLDING', __FUNCTION__, __LINE__, __FILE__, 'No HEADER_FILE FOUND: $file');
    }
    
}

function get_footer($file='footer.php') 
{   
	// THIS FUNCTION RETURNS TO THE TEMPLATE
	global $pb;
	$base_footer_file = PB_ROOT . PB_SITES_PATH . $pb['SITE_INFO']['theme_path'] . 'includes/' . $file;

    if (file_exists($base_footer_file)) {
		include_once($base_footer_file);
		__log_file($file, __FUNCTION__);
    } else {
		_log_err($pb, 'SCAFFOLDING', __FUNCTION__, __LINE__, __FILE__, 'No FOOTER_FILE FOUND: $file');
    }
    
}

function __log_file($file, $f_cback)
{
	global $pb;
	_log_msg($pb, 'INCLUDE', $f_cback . ' / file: $file');	
}

/* End of file */
/* Location: ./pb-content/config/pb-configsite.php */
/* DO NOT EDIT WITH DREAMWEAVER, IF YOU MUST, THEN INCLUDE THIS LINE ?> */