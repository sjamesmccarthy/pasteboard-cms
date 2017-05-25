<?php 
if ( ! defined('PB-START')) exit('No direct script access allowed');

DEFINE('COOKIEHASH', $_SERVER["HTTP_HOST"]);

function bake_cookie($name, $value, $expire=1, $time='D', $path='/')
{

	if($expire == 0) { $expire = 1; } 
	$secs 	= 3600;
	
	switch($time)
	{
		case "H": // HOURS 3600s
		$expire_n = $secs * $time;
		break;
		
		case "D": // DAYS 86400s
		$$expire_n = ($secs * 24) * $expire;
		break;
		
		case "W": // WEEKS 604800s
		$expire_n = ($secs * 24) * 7 * $expire;
		break;
		
		default: // HOURS (3600s DEFAULT)
		$expire_n = $secs;
		break;
	}
	
	setcookie($name, $value, time()+$expire_n, $path);
}

function reset_cookie($name='ALL') 
{
	foreach ($_COOKIE as $key => $value)
	{
		setcookie ($key, "", time() - 3600, '/');
		unset($_COOKIE[$key]); 
	}
}

function take_cookie($name)
{

}

/* End of file */
/* Location: ./pb-libraries/pb-system.php */