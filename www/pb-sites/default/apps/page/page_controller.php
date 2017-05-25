<?php 

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * @FILE		page_controller.php
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
	$run = _check_func($pb);
		
		if($run == TRUE)
		{
		$pb['ROUTER']['function']($pb);
		} else {
			show_404();
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

# run the function
function view($pb)
{
	load_model('page_model.php');
	
	if($pb['ROUTER']['is_front'] == 'TRUE')
	{
		$results = _get_front_page($pb);
		$view = 'view_index.php';
	} else {
		$results = _get_content($pb, $pb['ROUTER']['id']);
		$view = 'view_page.php';
	}

	if(empty($pb['LAYOUT']['404'])) 
	{
	
	$layout	 = 	array(
				'view' => $view,
				'template' => $results['page_template'],
				'id' => $pb['ROUTER']['id'],
				'content' => $results
				);

	_log_msg($pb, 'INFO', 'app: ' . $pb['ROUTER']['app'] . ' Function: ' . __FUNCTION__);
	display($layout);
	}
	
}

/* functions called from VIEWs */
function get_content_index()
{
	/* 
	view_index.php		Displays an index listing of all content in pb_pages table by title (page_title)
	*/
	
	global $pb;
	load_model('page_model.php');
	print _get_content_index($pb);
}

/* End of file */
/* Location: ./pb-modules/pages/controller.php */