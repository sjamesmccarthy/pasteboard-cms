<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * @FILE		start_c.php
 * @DESC		initializes the pasteboard system
 * @PACKAGE		PASTEBOARD
 * @VERSION		1.0.0
 * @AUTHOR		James McCarthy
 * @EMAIL		james.mccarthy@gmail.com
 */

function _auth($pb)
{
	$data = array();
	$pb['VARS']['login'] = $_POST['username'];
	
	if(valid_email_address($_POST['username']) == TRUE)
	{
		$field_name = 'user_email';
		$field_code = 7;
		$email = TRUE;
	} else {
		$field_name = 'user_login';
		$field_code = 24;
	}
	
	$row = __get_user($pb, $field_name, $_POST['username'], $_POST['pswd']);
	
	if($row['admin'] == TRUE)
	{ 
		//__set_session_data();
		// $_SESSION['login'] = $_POST['username'];
		$_SESSION['login'] = $row['user_login'];
		$_SESSION['email'] = $row['user_email'];
		$_SESSION['rememberme'] = $_POST['rememberme_duration'];
		$_SESSION['user_id'] = $row['user_id'];
		
		if($email == TRUE) 
		{ 
			$cookie_username = str_ireplace('@','%',$row[$field_name]); 
		} else { 
			$cookie_username = $row[$field_name]; 
		}
		
			# $cookie_username (use ID instead) ID + 5 RANDOM CHARACTERS
			$interval 		= 'W';
			$name_cookie 	= 'pasteboard_' . md5(COOKIEHASH . SECRET_KEY);
			$encrypt_pass	= sha1($row['user_password']);
			$value_cookie 	= rand(time(),5) . '%'. $_SESSION['user_id'] . '%' . $encrypt_pass . '%' . time() . '-' . $_POST['rememberme_duration'] . $interval . '%' . $field_code;
			bake_cookie($name_cookie, $value_cookie , $_POST['rememberme_duration'], $interval);

		_log_msg($pb, 'LOGIN', 'model: ' . $pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['model'] . ' Function: ' . __FUNCTION__);  		
	} else {
		redirect('/admin/login/?result=BAD_LOGIN');
	}
		
	//return($data);
}

function _auth_cookie($pb)
{
	# MJo@Ks2# (server)
	$auth_data = explode('%', $_COOKIE['pasteboard_' . md5(COOKIEHASH . SECRET_KEY)]);
	
	foreach($_COOKIE as $key => $value)
	{
		if(preg_match("/pasteboard_/i", $key))
		{
			$auth_site_ar = explode('_', $key);
		}
	}
	
	$auth_username = $auth_data[1];	
	$auth_pswd = $auth_data[2];
	$field_name = 'user_id';
	$auth_site = $auth_site_ar[1];
		
	if(md5(COOKIEHASH . SECRET_KEY) == $auth_site) 
	{	
		$row = __get_user($pb, $field_name, $auth_username);
		if ($auth_data[4] == 7) { $pb['VARS']['login'] = $row['user_email']; }
 		if ($auth_data[4] == 24) { $pb['VARS']['login'] = $row['user_login']; }

		if($row['admin'] == TRUE) 
		{ 
			if($auth_pswd == sha1($row['user_password'])) 
			{
				$_SESSION['login'] = $row['user_login']; // use email or login
				$_SESSION['user_id'] = $auth_username;
				$_SESSION['email'] = $row['user_email'];
				$_SESSION['rememberme'] = 'CHECK_COOKIE_EXP';
				$auth_cookie_valid = TRUE;
				
				if($pb['ROUTER']['function'] == 'login')
				{
					redirect('/admin/dashboard/');
				}
				
			} else {
			
				$auth_cookie_valid = FALSE;
				_logout();
				redirect('/admin/login/');
			}
		}
	}
	
	return($auth_cookie_valid);
}

function _logout()
{
	reset_cookie();
	session_destroy();
	//_log_msg($pb, 'INFO', 'model: ' . $pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['model'] . ' Function: ' . __FUNCTION__);

	}

function _resetpswd($pb)
{
	$data = array();
	if(valid_email_address($_POST['email']) == FALSE)
	{
		redirect('/admin/login/?result=RESET_PASSWORD&status=FAILED');
	}
	
	db_limit('1');
	db_select('user_email');
	db_where('user_email', $_POST['email']);
	db_from('pb_user');
	db_cback(__FUNCTION__ . ', ' . __LINE__);
	$sql_result = db_query();

	if($pb['DATABASE']['result_count'] > 0) 
	{ 
		while ($row = mysql_fetch_array($sql_result, MYSQL_ASSOC)) 
		{
	   		$user_email = $row['user_email'];
	   	}
			
		$text_pswd = create_new_pswd();
		$md5_pswd = md5($text_pswd);
		
		$data = array('user_password' => $md5_pswd);
		db_where('user_email', $_POST['email']);
		db_update('pb_user', $data);
		db_cback(__FUNCTION__ . ', ' . __LINE__);
		$sql_result = db_query();
		
		mail_to($user_email);
		mail_from('no-reply@pasteboard.org','The PasteBoard Group');
		mail_subject('YOUR PASSWORD HAS BEEN RESET');
		mail_msg('Your new password is: ' . $text_pswd);
		mail_priority('1');
		mail_send();
		
		redirect('/admin/login/?result=PASSWORD_RESET');
	} else {
		_log_err($pb, 'DATABASE', __FUNCTION__, __LINE__, __FILE__, 'NO RECORDS RETURNED: 0');
		redirect('/admin/login/?result=RESET_PASSWORD&status=FAILED');
	}

	_log_msg($pb, 'INFO', 'model: ' . $pb[strtoupper($pb['ROUTER']['app']) . '_CONTROLLER']['model'] . ' Function: ' . __FUNCTION__);
	return($data);
}

function _delete($pb)
{
	// Delete a user account
}

function __get_user($pb, $field_name, $login, $pswd=NULL)
{
	$data = array();
	
	if(is_numeric($login)) 
	{
		$field_name = 'user_id'; 
	}
	
	db_select($field_name . ', user_password, user_id,user_email,user_login');
	db_from('pb_user');
	db_where($field_name, $login);
	
	if(!is_Null($pswd)) 
	{
		// this is not needed when authenticating against auth_cookie
		// instead we will retrieve the md5-password-hash and compare in auth_cookie(); 
		db_where('user_password', md5($_POST['pswd'])); 
	}
	
	db_order_by('user_login');
	db_cback(__FUNCTION__ . ', ' . __LINE__);
	$sql_result = db_query();
	
	if($pb['DATABASE']['result_count'] > 0) 
	{ 
		$data['admin'] = TRUE;
		while ($row = mysql_fetch_array($sql_result, MYSQL_ASSOC)) 
		{
			foreach ($row as $key=>$value) 
			{ 
				$data[$key] = $value; 
			}
		}
	} else {
		$data['admin'] = FALSE;
		_log_err($pb, 'LOGIN', __FUNCTION__, __LINE__, __FILE__, 'BAD_LOGIN_ATTEMPT');
	}
	
	return($data);
}

function __set_session_data($name=NULL, $value=NULL)
{
	if(isSet($name)) 
	{
		$_SESSION[$name] = $value;
	} else {
		$_SESSION['login'] = $_POST['username'];
		$_SESSION['rememberme'] = $_POST['rememberme_duration']; 
	}
}
/* End of file */
/* Location: ./pb-modules/pages/model.php */