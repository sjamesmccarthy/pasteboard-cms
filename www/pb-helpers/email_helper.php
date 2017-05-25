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
function _mail($to, $from, $subject, $message, $reply_to=NULL, $headers_extra=NULL)
{				
	$from_field = explode('|', $from);
	
	$from_clean = clean_email($from_field[1]);
	$to_clean = clean_email($to);
	$subject_clean = clean_email($subject);
	$reply_to_clean = clean_email($reply_to);
	
	//$to_clean = valid_email_address($to_clean);
	//$from_clean = valid_email_address($from_clean);
	
	$headers  = 'From: ' . $from_clean  . '<' . $from_field[0] . '>' . "\r\n";
	$headers .= 'X-Mailer: PHP/' . phpversion();
	if(isSet($reply_to)) { $headers .= "Reply-To: " . $reply_to_clean . "\r\n"; }
	if(isSet($headers_extra)) { $headers .= $headers_extra . "\r\n"; }
	
	mail($to_clean, $subject, $message, $headers);
}

function valid_email_address($email) 
{
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
	   _log_err($pb, 'EMAIL_INVALID', __FUNCTION__, __LINE__, __FILE__, 'Invalid Email: ' . $email);
		#redirect('/admin/login/?result=RESET_PASSWORD&status=FAILED');
		return(FALSE);
    } else {
		return(TRUE);
	}
}

function clean_email($str) 
{
	/*
	$str = strtolower($str);
	$str = trim($str);
	$injections_array = array(
							'(\n+)',
							'(\r+)',
							'(\t+)',
							'(%0A+)',
							'(%0D+)',
							'(%08+)',
							'(%09+)',
							'cc',
							'bcc',
							'content-type'
							);
	$inject_glue 	= join('|', $injections_array);
	$inject_glue 	= "/$inject_glue/i";
	
	if(preg_match($inject_glue,$str)) {
	print "INJECTION FOUND";
		_log_err($pb, 'EMAIL_INJECTION', __FUNCTION__, __LINE__, __FILE__, 'Header: ' . $str);
		show_404();
	} else {
		return($str);
	}
	*/
	$str = $str;
	
	return($str);
}

function mail_to($input)
{
	global $pb;
	valid_email_address($input);
	$pb['MAIL']['to'] = clean_email($input);
	
}

function mail_from($input, $name=NULL)
{
	global $pb;
	valid_email_address($input);
	$from_clean = clean_email($input);
	if(!is_null($name)) { $name_clean = clean_email($name); } else { $name_clean = 'sys_php_mail'; }
	$pb['MAIL']['from'] = 'From: ' . $name_clean  . '<' . $from_clean . '>';
}

function mail_replyto($input)
{
	global $pb;
	valid_email_address($input);
	$pb['MAIL']['reply_to'] = clean_email($input);
}

function mail_subject($input)
{
	global $pb;
	$pb['MAIL']['subject'] = clean_email($input);
}

function mail_msg($input) 
{
	global $pb;
	$pb['MAIL']['msg'] = $input;
}

function mail_attachment($filename, $type)
{
	//global $pb;
	//need to add this data with some research.
	//open the file, read it into VAR and attache in header.
}

function mail_priority($input)
{
	global $pb;
	$pb['MAIL']['priority'] = $input;
}

function mail_send()
{
	global $pb;
	$headers  = $pb['MAIL']['from'] . "\r\n";;
	$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
	$headers .= 'Mime-Version: 1.0' . "\r\n";
	if(isSet($pb['MAIL']['priority'])) { $headers .= 'X-Priority: ' . $pb['MAIL']['priority'] . "\r\n"; }
	if(isSet($pb['MAIL']['reply_to'])) { $headers .= "Reply-To: " . $pb['MAIL']['reply_to'] . "\r\n"; }

	mail($pb['MAIL']['to'], $pb['MAIL']['subject'], $pb['MAIL']['msg'], $headers);
}

/* End of file */
/* Location: ./pb-libraries/pb-system.php */