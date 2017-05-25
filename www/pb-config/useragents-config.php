<?php  

if ( ! defined('PB-START')) exit('No direct script access allowed');
 
/**
 * useragents-config.php
 * The user-agents configuration file. It's pretty straight forward and sets a bunch of
 * arrays to determine the viewer's environment, such as browser, platform and whether
 * the device being used is a mobile device, such as a phone or iPod Touch.
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org, http://www.zytrax.com/tech/web/mobile_ids.html
 */

function _get_useragent_config()
{

$useragent_config['os_platforms'] = array (
	'windows nt 6.1'	=> 'Windows 7',
	'windows nt 6.0'	=> 'Windows Vista',
	'windows nt 5.2'	=> 'Windows 2003',
	'windows nt 5.0'	=> 'Windows 2000',
	'windows nt 5.1'	=> 'Windows XP',
	'windows nt 4.0'	=> 'Windows NT 4.0',
	'winnt4.0'			=> 'Windows NT 4.0',
	'winnt 4.0'			=> 'Windows NT',
	'winnt'				=> 'Windows NT',
	'windows 98'		=> 'Windows 98',
	'win98'				=> 'Windows 98',
	'windows 95'		=> 'Windows 95',
	'win95'				=> 'Windows 95',
	'windows'			=> 'Unknown Windows OS',
	'iphone'			=> "Mac OS X (iPhone)",
	'os x'				=> 'Mac OS X',
	'symbian'			=> "Symbian",
	'Symbian OS'		=> "Symbian OS", 
	'Symbian'			=> "Symbian OS", 
	'SymbianOS'			=> "Symbian OS", 
	'elaine'			=> "Palm",
	'palm'				=> "Palm",
	'series60'			=> "Symbian S60",
	'windows ce'		=> "Windows CE"
	);

$useragent_config['web_browsers'] = array(
	'Opera'				=> 'Opera',
	'Trident'			=> 'Internet Explorer 8',
	'MSIE'				=> 'Internet Explorer',
	'Internet Explorer'	=> 'Internet Explorer',
	'Camino'			=> 'Camino',
	'Firefox'			=> 'Firefox',
	'Chimera'			=> 'Chimera',
	'Phoenix'			=> 'Phoenix',
	'Firebird'			=> 'Firebird',
	'Netscape'			=> 'Netscape',
	'OmniWeb'			=> 'OmniWeb',
	'Chrome'			=> 'Chrome',
	'Safari'			=> 'Safari',
	'Konqueror'			=> 'Konqueror',
	'Lynx'				=> 'Lynx',
	'mobileexplorer'	=> 'Mobile Internet Explorer',
	'palmsource'		=> 'Palm',
	'palmscape'			=> 'Palmscape',
	'netfront'			=> "Netfront Browser",
	'operamini'			=> "Opera Mini",
	'opera mini'		=> "Opera Mini",
	'vodafone'			=> "Vodafone",
	'docomo'			=> "NTT DoCoMo",
	'o2'				=> "O2",
	'blazer' => "Treo"
	);

$useragent_config['mobile_devices'] = array(
	'motorola' => "Motorola",
	'mot-' => "Motorola",
	'nokia'	=> "Nokia",
	'palm' => "Palm",
	'palmsource' => "Palm",
	'iphone' => "iPhone",
	'appleiphone' => "Apple iPhone",
	'ipod' => "iPod Touch",
	'appleipod' => "Apple iPod Touch",
	'sony'	=> "Sony Ericsson",
	'ericsson' => "Sony Ericsson",
	'blackberry' => "BlackBerry",
	'lge' => "LG",
	'xda' => "XDA",
	'mda' => "MDA",
	'htc' => "HTC",
	'nintendo' => "Nintendo Wii",
	'samsung' => "Samsung",
	'sie-' => "Siemens",
	'SonyEricsson' => "SonyEricsson",
	'playstation' => "Sony PlayStation 3",
	'benq'				=> "BenQ",
	'ipaq'				=> "HP iPaq",
	'playstation portable' 	=> "PlayStation Portable"
	);

	return($useragent_config);
}	

/* End of file useragents.php */
/* Location: ./pb-config/useragents-config.php */