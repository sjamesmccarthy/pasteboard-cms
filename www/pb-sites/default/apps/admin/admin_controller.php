<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * @FILE		start_c.php
 * @DESC		initializes the pasteboard system
 * @PACKAGE		PASTEBOARD
 * @VERSION		1.0.0
 * @AUTHOR		James McCarthy
 * @EMAIL		james.mccarthy@gmail.com
 
 * @FUNCTIONS	none
 */

__index($pb);

# initialize the controller (app)
function __index($pb) 
{	
	_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Initialized');
	_benchmark($pb, 'app_' . $pb['ROUTER']['app'], 'TIMER_ON');
	load_helper('email,cookies,encryption');
	
	__rememberme($pb);
	$run = _check_func($pb);
	
		if($run == TRUE)
		{
			$pb['ROUTER']['function']($pb);
		} else {
			redirect('/admin/login');
		}
		
		__killapp($pb);
}

# terminate the controller (app)
function __killapp($pb)
{
	$arr_key = 'app_' . $pb['ROUTER']['app'];
	_benchmark($pb, 'app_' . $pb['ROUTER']['app'], 'TIMER_OFF');
	$pb[$pb['ROUTER']['app'] . '_CONTROLLER']['load_time'] = $pb['BENCHMARK'][$arr_key]['time'];
	$pb[$pb['ROUTER']['app'] . '_CONTROLLER']['mem_usage'] = $pb['BENCHMARK'][$arr_key]['mem_usage'];
	_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Terminated');
}

function __rememberme($pb)
{
		if(isSet($_COOKIE['pasteboard_' . md5(COOKIEHASH . SECRET_KEY)]))
		{	
			load_model('auth_model.php');
			_auth_cookie($pb);
		} else {
			return(FALSE);
		}
}

# run the function
function login($pb)
{
	global $layout;
	if(empty($_SESSION['username']))
	{
		if(empty($pb['VARS']['status'])) { $pb['VARS']['status'] = ''; }
		if(empty($pb['VARS']['result'])) { $pb['VARS']['result'] = NULL; }
		$notification_msg = __get_notification($pb);
			
		$layout	 = 	array(
					'view' => 'login_view.php',
					'template' => 'auth.php',
					'auth' => 'login',
					'notification_title' => $pb['VARS']['result'],
					'notification_msg' => $notification_msg,
					'content' => array('page_title' => 'ADMIN: LOGIN')
					);
	
		_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Function: ' . __FUNCTION__);
		display($layout);
	} else {
		redirect('/admin/dashboard/');
	}
}
  
function auth()
{
	global $pb;
	load_model('auth_model.php');
	$notification_msg = __get_notification($pb);
	$data = _auth($pb);
	
	/*
	$layout	 = 	array(
				'view' => 'dashboard_view.php',
				'template' => 'auth.php',
				'auth' => 'true',
				'notification_title' => $pb['VARS']['result'],
				'notification_msg' => $notification_msg,
				'content' => array('page_title' => 'ADMIN: LOGGED-IN')
				);

	_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Function: ' . __FUNCTION__);
	display($layout);
	*/
	
	redirect('/admin/dashboard/');
}

function logout()
{
	global $pb;
	load_model('auth_model.php');
	_logout();
	
	$layout	 = 	array(
				'view' => 'login_view.php',
				'template' => 'auth.php',
				'auth' => 'false',
				'notification_title' => 'LOGOUT',
				'notification_msg' => 'you have been logged out',
				'result' => '',
				'content' => array('page_title' => 'ADMIN: LOGOUT')
				);

	_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Function: ' . __FUNCTION__);
	display($layout);
}

function resetpswd()
{
	# 5f4dcc3b5aa765d61d8327deb882cf99
	global $pb;
	load_model('auth_model.php');
	$data = _resetpswd($pb);
	
	$layout	 = 	array(
				'view' => 'login_view.php',
				'template' => 'auth.php',
				'auth' => 'reset',
				'notification_title' => $pb['VARS']['result'],
				'notification_msg' => $notification_msg,
				'content' => array('page_title' => 'ADMIN: RESET-PASSWORD')
				);

	_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Function: ' . __FUNCTION__);
	display($layout);
}

function delete()
{
	global $pb;
	//load_model('page_model.php');
	
	print "delete.true.not_really<br />";
	$layout	 = 	array(
				'view' => 'login_view.php',
				'template' => 'auth_tpl.php',
				'auth' => 'delete',
				'notification_title' => $pb['VARS']['result'],
				'notification_msg' => $notification_msg,
				'content' => array('page_title' => 'ADMIN: DELETED ACCOUNT')
				);

	_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Function: ' . __FUNCTION__);
	display($layout);
}

function dashboard()
{
	global $pb;
	#if(!empty($_COOKIE['pasteboard_' . md5($COOKIEHASH . SECRET_KEY)]))
	#{
	#load_model('dashboard_model.php');

		$layout	 = 	array(
					'view' => 'dashboard_view.php',
					'template' => 'index.php',
					'auth' => 'active',
					'content' => array('page_title' => 'ADMIN: Dashboard')
					);
	
		_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Function: ' . __FUNCTION__);
		display($layout);
	#} else {
		#redirect('/admin/login/?result=NOT_LOGGED_IN');
	#}
}

function settings()
{
	preint_r($_SESSION);
}

function showhint()
{
	print "maybe another time.";
}

function __get_notification($pb)
{
	switch($pb['VARS']['result'])
	{
		case "BAD_LOGIN":
		$msg = "username/password combination do not match";
		break;
		
		case "RESET_PASSWORD":
			if($pb['VARS']['status'] == "FAILED") 
			{
			$msg = "the email submitted was not found";
			} else {
			$msg = "you have requested to reset your password";
			}
		break;
		
		case "PASSWORD_RESET":
		# 5f4dcc3b5aa765d61d8327deb882cf99
		$msg = "your password has been reset<br />please check your email";
		break;
		
		case "LOGOUT":
		$msg = "you have been logged out";
		
		case "NOT_LOGGED_IN":
		$msg = "you no longer appear to be logged in";
		break;
		
		default:
		$msg = NULL;
		break;
	}
	
	return($msg);
	
	// check result $pb['VARS']['result']
	// if 'Bad_Login' = $notification = 'We're sorry username/password combination not found.';
	// if 'Password_Reset' = $notification = 'You're password has been reset. Please check your email.';
	// if 'Password_Expiration' = $notification = 'You're password has expired. Please enter a new one.';
	// if 'Account_Locked' = $notification = 'Your account has been locked. Too many password attempts.';
	// if 'Account_Disabled = $notification = 'Your account is disabled. Contact the support team.';
	// else $result = 'login'; $notification = NULL;
	
}

/* End of file */
/* Location: ./pb-modules/pages/controller.php */