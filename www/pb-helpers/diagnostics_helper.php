<?php 
   
/**
 * @FILE		diagnostics_helper.php
 * @DESC		produces diagnostic output in table format for the pb_array
 * @PACKAGE		pasteboard
 * @SITE		http://www.pasteboard.org
 */

function format_diagnostics($pb) 
{
	$body 	= '';
	$show 	= array (
			'ERRORS' => '993333:FFCCCC',
			'PACKAGE' => '000000:EEEEEE',
			'URI' => '000000:EEEEEE',
			'BENCHMARKS' => '666666:EEEEEE',
			'CACHE' => '6699FF:EEEEEE',
			'VARS' => '336600:EEEEEE',
			'PHP_SESSION' => '3399FF:EEEEEE',
			'COOKIES' => '3399FF:EEEEEE',
			'DATABASE' => '9966FF:EEEEEE',
			'SQLbuilder' => '9966FF:EEEEEE',
			'SQLog' => '9966FF:EEEEEE',
			'USERAGENT' => 'FF0033:EEEEEE',
			'ROUTER' => '996600:EEEEEE', 
			'APPINFO' => '996600:EEEEEE',
			'HELPERS' => '996600:EEEEEE',
			'SITEINFO' => '6699FF:EEEEEE',
			'LOGS' => 'FF9900:EEEEEE'
			); // function_name + label => border_color:background_color
	
	foreach ($show as $func => $color)
	{
		$color = explode(':', $color);
		
		$body  .= "<div style=\"margin:0 20px 0 20px;\"><fieldset style=\"border:1px solid #" . $color[0] . "; padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#" . $color[1] . "\">\n";
		$body .= "<legend style=\"color:#" . $color[0] . "; font-family: verdana, sans-serif;\">&nbsp;&nbsp; " . $func . "&nbsp;&nbsp;</legend>\n";
			$function = '__format_' . $func;
			$body .= $function($pb);
		$body .= "</fieldset></div>\n";		
	}
	
	$body .= '<p style="font-family: verdana, sans-serif; font-size:9pt; text-align: center; padding-bottom: 10px;">&copy;opyright ' . DATE_YEAR . ' &mdash; <a target="_new" href="http://' . PB_DOMAIN . '">' . PB_NAME . '</a> &mdash; Version ' . PB_VERSION . ' &mdash ' . DB_HOST . '</p>';
	_log_msg($pb, 'INCLUDE','helper: diagnostics_helper, ' . __FUNCTION__);	
	
	return($body);		
}

function __format_PACKAGE($pb)
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	$data .= '<tr>';
	$data .= '<td width="20%" style="background-color: #CCCCCC;" align="left">NAME</td>';
	$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . PB_NAME . ' v.' . PB_VERSION . '</td>';
	$data .= '</tr>';
	$data .= '<tr>';
	$data .= '<td width="20%" style="background-color: #CCCCCC;" align="left">PHP VERSION</td>';
	$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . phpversion() . '</td>';
	$data .= '</tr>';	
	$data .= '</table>';
	return($data);		
}

function __format_ERRORS($pb) 
{
	if(!empty($pb['-ERRORS'])) 
	{
		$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
		foreach($pb['-ERRORS'] as $key => $value)
		{	
			foreach($pb['-ERRORS'][$key] as $key_n => $value_n)
			{
				$data .= '<tr>';
				$data .= '<td width="100%" style="color: #FFFFFF; background-color: #CC6666;" align="left">' . $value_n . '</td>';
				$data .= '</tr>';
			}
		}
		$data .= '</table>';	
	} else {
	
		$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
		$data .= '<tr>';
		$data .= '<td width="100%" style="color: #993333;">No Errors Found</td>';
		$data .= '</tr>';	
		$data .= '</table>';
	}

	return($data);		
}

function __format_URI($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';

	foreach($pb['URI_SEG'] as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_BENCHMARKS($pb) 
{
	$count = count($pb['BENCHMARK']);
	$data  = '<table width="100%" style="font-family: verdana, sans-serif;">';
	$data .= '<tr>';
	$data .= '<td width="33%" style="background-color: #999999;">Timer_Name</td>';
	$data .= '<td width="33%" style="background-color: #999999;">Time (seconds)</td>';
	$data .= '<td width="33%" style="background-color: #999999;">Memory_Usage</td>';
	$data .= '</tr>';
	foreach($pb['BENCHMARK'] as $key => $value)
	{
		$data .= '<tr>';
		$data .= '<td width="33%" style="background-color: #CCCCCC;">' . $key . '</td>';
		
		foreach($pb['BENCHMARK'][$key] as $data_key => $data_value)
		{
			$data .= '<td width="33%" style="background-color: #CCCCCC;">' . $data_value . '</td>';
		}
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_VARS($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	#foreach($pb['VARS']['_GET'] as $key => $value)
	foreach($pb['VARS'] as $key => $value)
	{	
		if($key == CONTROLLER_TRIG) { $desc = ' (CONTROLLER_TRIG)'; }
		else if($key == FUNCTION_TRIG) { $desc = ' (FUNCTION_TRIG)'; }
		else if($key == ID_TRIG) { $desc = ' (ID_TRIG)'; }
		else { $desc = ''; }
		
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . $desc. '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_CACHE($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	
	if(USE_CACHE == TRUE)
	{
		foreach($pb['CACHE'] as $key => $value)
		{	
			$data .= '<tr>';
			$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
			$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
			$data .= '</tr>';
		}
	}
	else {
		$data .= '<tr><td style="background-color: #CCCCCC; padding-right: 5px;" align="left"> CACHE_DISABLED </td></tr>';
	}
	
	$data .= '</table>';
	
	return($data);
}

/*
function __format_SESSION($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($pb['SESSION'] as $key => $value)
	{	
		$data .= '<tr>';
			if($key == 'init') 
			{ 
				$entry = explode('|', $value);
				$key = 'start';
				$value = $entry[1] . ' (uid: ' . $entry[0] . ')';
			}

		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}
*/

function __format_PHP_SESSION($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($_SESSION as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_COOKIES($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($_COOKIE as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_DATABASE($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($pb['DATABASE'] as $key => $value)
	{	
		if($key != 'SQLog' AND $key != 'sql' AND $key != 'result_count')
		{
			$data .= '<tr>';
			$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
			$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
			$data .= '</tr>';
		}
	}
	$data .= '</table>';
	return($data);
}

function __format_SQLbuilder($pb) 
{
	$count = count($pb['SQL']['CREATE']);
	
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	$data .= '<tr>';
	$data .= '<td width="70%" style="background-color: #999999;">SQL_Segments</td>';
	$data .= '</tr>';
	foreach($pb['SQL']['CREATE'] as $key => $value)
	{
		$data .= '<tr>';
		$data .= '<td width="100%" style="background-color: #CCCCCC;">' . $key . ' - ' .  $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	
	return($data);
}

function __format_SQLog($pb) 
{
	$count = count($pb['DATABASE']['SQLog']);
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	$data .= '<tr>';
	$data .= '<td width="70%" style="background-color: #999999;">SQL_Statement</td>';
	$data .= '<td width="15%" style="background-color: #999999;">Function_Called_From</td>';
	$data .= '<td width="5%" style="background-color: #999999;">Result_Count</td>';
	$data .= '<td width="5%" style="background-color: #999999;">Load_Time</td>';
	$data .= '<td width="5%" style="background-color: #999999;">Memory_Usage</td>';
	$data .= '</tr>';
	foreach($pb['DATABASE']['SQLog'] as $key => $value)
	{
		$entry = explode('|', $value);
		$data .= '<tr>';
		$data .= '<td width="70%" style="background-color: #CCCCCC;">' . $entry[0] . '</td>';
		$data .= '<td width="15%" style="background-color: #CCCCCC;">' . $entry[4] . '</td>';
		$data .= '<td width="5%" style="background-color: #CCCCCC;">' . $entry[1] . '</td>';
		$data .= '<td width="5%" style="background-color: #CCCCCC;">' . $entry[2] . '</td>';
		$data .= '<td width="5%" style="background-color: #CCCCCC;">' . $entry[3] . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_USERAGENT($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($pb['USERAGENT'] as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_ROUTER($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($pb['ROUTER'] as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_APPINFO($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	$arr_key = strtoupper($pb['ROUTER']['app']) . '_CONTROLLER';
	foreach($pb[$arr_key] as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_SITEINFO($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($pb['SITE_INFO'] as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_HELPERS($pb) 
{
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($pb['HELPERS'] as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="100%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	$data .= '</table>';
	return($data);
}

function __format_LOGS($pb) 
{
	$logfile = explode('/', $pb['LOG']['path']);
	
	$data = '<table width="100%" style="font-family: verdana, sans-serif;">';
	foreach($pb['LOG'] as $key => $value)
	{	
		$data .= '<tr>';
		$data .= '<td width="20%" style="background-color: #CCCCCC; padding-right: 5px;" align="right">' . $key . '</td>';
		$data .= '<td width="80%" style="background-color: #CCCCCC;" align="left">' . $value . '</td>';
		$data .= '</tr>';
	}
	
	$data .= '</table>';

	/*
	$data .= '<table width="100%" style="font-family: verdana, sans-serif;">';
	$data .= '<tr><td width="100%" colspan="4" style="background-color: #999999;">Detailed Log for ' . $pb['LOG']['id'] . '| Truncated at last 20 entries due to memory limits</td></tr>';
	$data .= '<tr>';
	$data .= '<td width="15%" style="background-color: #999999;">Instance_ID</td>';
	$data .= '<td width="30%" style="background-color: #999999;">Machine_IP/Location</td>';
	$data .= '<td width="10%" style="background-color: #999999;">Log_Type</td>';
	$data .= '<td width="45%" style="background-color: #999999;">Log_Description</td>';
	$data .= '</tr>';
	
	$handle = fopen($pb['LOG']['path'], READ_ONLY);
	if ($handle) {
		$i=0;
		//while (!feof($handle)) {
		while($i < 21) {
			$buffer = fgets($handle, 4096);
			if (preg_match("/" . $pb['LOG']['id'] . "/i", $buffer)) 
			{
			$log_line = explode('|', $buffer);
				if(GEO_LOOKUP_IP == TRUE) { $location = ' (' . ltrim($pb['USERAGENT']['location']) . ')'; }
				if(preg_match("/\ERROR/i", $log_line[2])) { $color = 'FF9999'; } else { $color = 'CCCCCC'; }
			$data .= '<tr>';
			$data .= '<td width="15%" style="background-color: #' . $color . ';">' . $log_line[0] . '</td>';
			$data .= '<td width="30%" style="background-color: #' . $color . ';">' . $log_line[1] . $location . '</td>';
			$data .= '<td width="10%" style="background-color: #' . $color . ';">' . $log_line[2] . '</td>';
			$data .= '<td width="45%" style="background-color: #' . $color . ';">' . $log_line[4] . '</td>';
			$data .= '</tr>';
			$i++;
			}
		}
	fclose($handle);
	$data .= "</table>";
	}
*/

	return($data);
}

?>