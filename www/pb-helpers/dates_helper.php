<?php 
 
/**
 * @FILE		diagnostics_helper.php
 * @DESC		produces diagnostic output in table format for the pb_array
 * @PACKAGE		pasteboard
 * @SITE		http://www.pasteboard.org
 */

 function get_date($format='DATE_SIMPLE_SLASH')
 {
	switch($format)
	{
		case "TIME_UNIX":							// 1257282398
			return(time());							
			break;
		case "DATE_MYSQL":						 	// 2009-12-25 17:16:32
 			return(date("Y-m-d H:i:s"));
			break;                                     
		case "DATE_LONG_TS":						// March 10, 2001, 5:16 pm
 			return(date("F j, Y, g:i a"));
			break;          
		case "DATE_MONTH_LONG":						// March
 			return(date("F"));
			break;                  				
		case "DATE_MONTH_SHORT":					// Mar
 			return(date("M"));
			break;                                        
		case "DATE_DAY_LONG":						// Saturday
 			return(date("l"));
			break;                     
		case "DATE_DAY_SHORT":						// Sat
 			return(date("D"));
			break;                                           
		case "DATE_SIMPLE_SLASH":					// 03/10/01
 			return(date("m/d/y"));
			break;             
		case "DATE_SIMPLE_DASH":					// 03-10-01
 			return(date("m-d-y"));
			break;              
		case "DATE_SIMPLE_DOT":						// 03.10.01
 			return(date("m.d.y"));
			break;                
		case "TIME_24":								// 17:16:18
 			return(date("H:i:s"));
			break;                      
		case "TIME_12":								// 5:16 pm
 			return(date("g:i a"));
			break;                       
		case "TIME_ZONE":							// MST 
 			return(date("T"));
			break;                         
		case "DATE_FORMATTED_LONG":					// Saturday, March 20, 2009
 			return(date("l, F m, Y"));
			break;      
		case "DATE_FORMATTED_SHORT":				// Sat Mar 10 2009 
 			return(date("D M j Y"));
			break;                                 
		case "DATE_YEAR":							// 2009
 			return(date("Y"));
			break;
	}
}

?>