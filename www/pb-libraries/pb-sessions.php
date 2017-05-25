<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * pb-sessions.php
 * Contains functions for system-level session handling. 
 * We primarily use the built-in PHP _SESSION variable, but will store off
 * some information to the $pb global array.
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org
 */

/* Does the actual writing to the log file. 
 * Note: The initializer for the logging system is located in the bootstrap.
 * That function makes sure that directory and files, based on SITE, exist before getting to this point.
 *
 * @since	0.1.0
 * @param	str     $level          1 = Error Messages (including PHP errors)
                                    2 = Debug Messages
                                    3 = Informational Messages
                                    4 = All Messages
 * @param   str     $msg            description of the log entry. keep it short, long log entries suck.
 * @param   str     $php_error      spits out the php error message if it exists, will also change $level to 1
 */

 function _init_session($pb, $action='create')
 {
	/*
	Name	wordpress_logged_in_ee971f2af7fd2da0c91401e5c8c0e54e
	Value	admin%7C1269880638%7Cd1936629c089845afe83de4a34d127e0
	Host	eqsq.com
	Path	/
	Secure	No
	Expires	Mon, 29 Mar 2010 16:37:50 GMT
	*/
	
    if(!empty($_SESSION)) 
    {
      # session_found
    } else {
        $_SESSION['SID_START'] = TIME_UNIX . '|' . date('m-d-Y h:m:s', TIME_UNIX);
        $_SESSION['SID'] = session_id();
    }  

	_log_msg($pb, 'INFO','_init_session: Not Implemented');	
 }

function __session_db($pb, $action='add') 
{
    switch($action)
	{
	
	case 'add':
	break;
	
	case 'delete':
	break;
	
	}
	
}

 
/* End of file */
/* Location: ./pb-libraries/pb-system.php */