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


/* End of file */
/* Location: ./pb-libraries/pb-system.php */