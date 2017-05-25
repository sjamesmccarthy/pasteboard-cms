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

 // Hooks will be things like date_stamps, headers, footers, OPTIONAL ITEMS to include in tempates and views
 
function get_date_long() 
{
	return(DATE_LONG_TS); 
}

function get_timer_stats() 
{
	global $pb;
	$result = '<div>Loadtime: ' . $pb['BENCHMARK']['__framework']['time'] . '| Memory Usage: ' . $pb['BENCHMARK']['__framework']['mem_usage'] . '</div>';
	return($result); 
}

function get_notifications($pb)
{

}

/* End of file */
/* Location: ./pb-libraries/pb-system.php */