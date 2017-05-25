<?php

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * @FILE		pb-useragent.php
 * @DESC		opens a persistent connection to database
 * @PACKAGE		PASTEBOARD
 * @VERSION		1.0.5
 * @AUTHOR		James McCarthy
 * @EMAIL		james.mccarthy@mac.com
 * @LICENSE		Commercial, Copyright 2008
 * @FUNCTIONS	none
 */

function is_browser($pb) 
{
	#return 
}

function is_platform($pb) 
{
	#return 
}

function is_IE6() 
{
	global $pb;
 	$pb['LAYOUT']['SAD_BROWSER'] = TRUE;
	$useragent_config = _get_useragent_config();
	$useragentstr = strtolower($_SERVER['HTTP_USER_AGENT']); 
	$is_IE6 = FALSE;
		
		if(preg_match("/MSIE 6.0/i", $useragentstr))
		{
			$is_IE6 = TRUE;
				
			if(chk_ie6_cookie() === TRUE) 
			{
				// do nothing, pass-thru
			} else {
				show_sad_browser();
				exit;	
			}
		}	
		
	return(TRUE);
}

function chk_ie6_cookie()
{
	global $pb;
	if(isSet($_COOKIE['sad_browser']))
	{
		return(TRUE);
	} else {
		if($pb['VARS']['sad_browser'] == 'ok')
		{
		#print 'found.sad_browser<br />';
		load_helper('cookies');
		bake_cookie('sad_browser', 1, 52, 'W');
		return(FALSE);
		}
	}
}

/******************************************************************
* Function Name: pb_useragent
* Parameters: 
* Description: Cleans URI of any strange characters.
* files if necessary.
* Return type: TRUE
*******************************************************************/ 
function _useragent($pb)
{	
	
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$pb['USERAGENT']['agent_str'] = $useragent;
	$pb['USERAGENT']['IP'] = is_IP();
	
	if(GEO_LOOKUP_IP == TRUE)
	{
		$pb['USERAGENT']['location'] = getLocationByIP($pb['USERAGENT']['IP']);
	}
	
	$useragent_config = _get_useragent_config();

	// browser & version
	if (is_array($useragent_config['web_browsers']) && count($useragent_config['web_browsers'] > 0))
	{
		foreach ($useragent_config['web_browsers'] as $key => $val)
		{	
			if (preg_match("|" . $key . ".*?([0-9\.]+)|i", $useragent, $match))
			{
				$pb['USERAGENT']['name'] = $val;
				$pb['USERAGENT']['version'] = $match[1];
				$pb['USERAGENT']['is_IE6'] = is_IE6();
				break;
			}
		}
	} else {
		#log
	}
	
	// os version & platform
	if (is_array($useragent_config['os_platforms']) && count($useragent_config['os_platforms'] > 0))
	{
		foreach ($useragent_config['os_platforms'] as $key => $val)
		{		
			if (preg_match("|" . $key . "|i", $useragent))
			{
				$pb['USERAGENT']['os_platform'] = $val;
				break;
			}
		}
	} else {
		#log
	}

	// is_mobile TRUE/FALSE
	// will need to add this in later
	$pb['USERAGENT']['is_Mobile'] = is_mobile();

	_log_msg($pb, 'info', '_useragent: ' . $pb['USERAGENT']['name'] . ' ' . $pb['USERAGENT']['version']);
	_log_msg($pb, 'info', '_useragent: ' . $pb['USERAGENT']['os_platform']);
	return($pb['USERAGENT']);
	
}

/**
	 * Set the Mobile Device
	 *
	 * @access	private
	 * @return	bool
*/		
function is_mobile()
{
		$useragent_config = _get_useragent_config();
		$useragentstr = strtolower($_SERVER['HTTP_USER_AGENT']); 
		$is_mobile = "FALSE";
		
		foreach ($useragent_config['mobile_devices'] as $key => $val)
		{
			$val = strtolower($val);
			
			if(preg_match("/$val/i", $useragentstr)) 
			{
				$is_mobile = "TRUE";
			}
		}
		
		return($is_mobile);
		
}
	
function is_IP()
{
	$whoareyou = $_SERVER["REMOTE_ADDR"];
	return($whoareyou);
}

/* End of file */
/* Location: ./pb-libraries/pb-useragent.php */ 