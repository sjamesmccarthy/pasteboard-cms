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
 
 /* Logs INFO and ERROR msgs.
 * @since	0.1.0
 * @param	array   $pb        global pb_array
 * @param	str   	$level      the level of the msg: info, error, etc.
 * @param	str   	$msg        the message of the error.
 * @return  TRUE
 */
function _log_msg($pb, $level, $msg)
{				
        $msg_str = $pb['LOG']['id'] . "|" . is_IP() . "|" . strtoupper($level) . "|" . DATE_MYSQL . "|" . $msg . "\n";
       
		if(PB_LOG_STATUS == TRUE)
		{
			$fp = fopen($pb['LOG']['path'], APPEND_WRITE_BOTTOM);
			flock($fp, LOCK_EX);	
			fwrite($fp, $msg_str);
			flock($fp, LOCK_UN);
			fclose($fp);
		}
		
		// Create HTML to display on screen
		
		return(TRUE);
}

/* End of file */
/* Location: ./pb-libraries/pb-system.php */