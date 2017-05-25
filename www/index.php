<? 
/** 
 * pasteboard 
 * a content management framework
 * This is the PHP page the serves all page requests.
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 */

if(preg_match("/5/i", phpversion())) { DEFINE('PHP5', TRUE); }

/**
 * We'll define a CONSTANT variable that will allow access to library files.
 * Set the $pb array.
 * This little booger is equivalent to what an object would have been if this was written in OOP.
 * Well maybe not TECHNICALLY the same thing, but I hope you get the idea. It will be passed
 * between functions and hold framework and site variables.
 */
$pb = array();
$layout = array();
session_start();

/*
 * We'll define a CONSTANT, PB_START, that will allow access to library files and log the starting gun.
 */
define('PB-START', TRUE);
$pb['LOG']['PRELOAD'][] = 'INFO|pasteboard.Started';

/**
 * Now, we'll import the config file for the pasteboard framework.
 * This IS_NOT the site config file which will be loaded in a few seconds, literally.
 */
require('./pb-config/pb-config.php'); 

/**
 * Okay, almost there. Loading the system & bootstrap files. 
 * This file basically starts things up by requiring library files and setting up the
 * theme & template scaffolding for the specific site. Are you excited yet? 
 */
require('./pb-libraries/pb-system.php');
require('./pb-libraries/pb-bootstrap.php');


/**
 * Next, we'll also define error_reporting as E_STRICT, including warnings and use a custom error function to write to pb-log file
 * And we'll make sure the server is running PHP 5 or exit the pasteboard framework.
 * And ... set the default timezone for the server.
 */
error_reporting(E_ALL);
// set_error_handler('_custom_error');
version_compare(PHP_VERSION, '5', '<') and exit('PasteBoard requires PHP 5 or newer.');
date_default_timezone_set('US/Pacific');

/**
 * Buckle-up and enjoy the ride!
 * Oh, BTW, in case you want to peek, the pb_bootstrap function is in /pb-libraries/.
 */
_bootstrap($pb);
exit;

/* End of file */
/* Location: index.php */