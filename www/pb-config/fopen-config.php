<?php

if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * fopen-config.php
 * The file handling configuration file. It's pretty straight forward and maps a bunch of
 * file handler parameters that are easier to remember.
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org, http://us.php.net/manual/en/function.fopen.php
 */

define('READ_ONLY', 					'r'); 	// Reading only, pointer at beginning of file
define('READ_WRITE_TOP',	 			'r+'); 	// Reading and writing, pointer at beginning of file
define('WRITE_ONLY_TRUNCATE',			'w'); 	// Writing only, pointer at beginning of file and truncate to 0 length, try to create if file doesn't exist
define('WRITE_READ_TRUNCATE', 			'w+'); 	// Reading and Writing, pointer at beginning of file and truncate to 0 length, try to create if file doesn't exist
define('APPEND_WRITE_BOTTOM', 			'a'); 	// Writing only, pointer at end of file, try to create if file doesn't exist
define('APPEND_READ_WRITE_BOTTOM', 		'a+'); 	// Reading and Writing, pointer at the end of file, try to create if file doesn't exist
define('CREATE_WRITE_TOP', 				'x'); 	// Create file and open for writing only, pointer at beginning of file, returns FALSE if file exists
define('CREATE_READ_WRITE_TOP', 		'x+'); 	// Create file for reading and writing, poointer at beginning of file, returns FALSE if file exists

/* Custom FOPEN formats can be listed below this line */
/* They will be global to all sites */

/* End of file useragents.php */
/* Location: ./pb-config/fopen-config.php */