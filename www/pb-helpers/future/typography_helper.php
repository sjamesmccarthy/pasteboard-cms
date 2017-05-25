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
  
/* End of file */
/* Location: ./pb-libraries/pb-system.php */