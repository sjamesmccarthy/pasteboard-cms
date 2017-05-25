<?php

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * dates-config.php
 * The dates configuration file. It's pretty straight forward and sets a bunch of
 * date formats that are used through out the framework as well as the template manager.
 *
 * The pb-library ref. refers to Simple-Template-Markup. 
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org, http://php.net/manual/en/function.date.php
 */

/* CONSTANT NAME + PHP CODE                             // pb-library ref.      // example output
 * ********************************************************************************************** */
										
DEFINE('TIME_UNIX', time());							// pb_date('unix')		// 1257282398
DEFINE('DATE_MYSQL', date('Y-m-d H:i:s'));                                      // 2009-12-25 17:16:32
DEFINE('DATE_LONG_TS', date("F j, Y, g:i a"));          // pb_date('stamp')     // March 10, 2001, 5:16 pm
DEFINE('DATE_MONTH_LONG', date("F"));                   // pb_date('month')     // March
DEFINE('DATE_MONTH_SHORT', date("M"));                                          // Mar
DEFINE('DATE_DAY_LONG', date("l"));                     // pb_date('day')       // Saturday
DEFINE('DATE_DAY_SHORT', date("D"));                                            // Sat
DEFINE('DATE_SIMPLE_SLASH', date("m/d/y"));             // pb_date('slash')     // 03/10/01
DEFINE('DATE_SIMPLE_DASH', date("m-d-y"));              // pb_date('dash')      // 03-10-01
DEFINE('DATE_SIMPLE_DOT', date("m.d.y"));               // pb_date('dot')       // 03.10.01
DEFINE('TIME_24', date("H:i:s"));                       // pb_date('time24')    // 17:16:18
DEFINE('TIME_12', date("g:i a"));                       // pb_date('time12')    // 5:16 pm
DEFINE('TIME_ZONE', date("T"));                         // pb_date('zone')      // MST 
DEFINE('DATE_FORMATTED_LONG', date("l, F m, Y"));       // pb_date('expanded')  // Saturday, March 20, 2009
DEFINE('DATE_FORMATTED_SHORT', date("D M j Y"));                                 // Sat Mar 10 2009 
DEFINE('DATE_YEAR', date("Y"));

/* End of file useragents.php */
/* Location: ./pb-config/useragents-config.php */