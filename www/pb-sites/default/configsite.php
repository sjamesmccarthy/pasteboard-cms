<?php 
if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * configsite.php
 * configuration file for the website. This information can be manually changed
 * or through the ADMIN interface. 
 *
 * @package    pasteboard
 * @subpackage site
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org
 */

 /* Site Contact information */
 // $pb['SITE_INFO'][]
$pb['SITE_INFO']['SITE_COMPANY_NAME'] = 'pasteboard group';
$pb['SITE_INFO']['SITE_COMPANY_CONTACT_NAME'] = 'James McCarthy';
$pb['SITE_INFO']['SITE_COMPANY_CONTACT_EMAIL'] = 'jmccarthy@projectwebstart.com';
$pb['SITE_INFO']['SITE_COMPANY_CONTACT_PHONE'] = '(775) 815-9726';
$pb['SITE_INFO']['SITE_NAME'] = 'PASTEBOARD';
$pb['SITE_INFO']['SITE_SUPPORT_EMAIL'] = 'webemail@pasteboard.org';
$pb['SITE_INFO']['SITE_COPYRIGHT'] = 'Copyright (c) 2010 ' . $pb['SITE_INFO']['SITE_COMPANY_NAME'] . '. All rights reserved.';

/* Site Search Information: Google */
$pb['SITE_INFO']['GOOGLE_SITE_VALIDATION'] = '';
$pb['SITE_INFO']['GOOGLE_SITEMAP'] = '';
$pb['SITE_INFO']['GOOGLE_ANALYTICS'] = '';
$pb['SITE_INFO']['GOOGLE_ADS'] = '';

/* Site Search Information: Yahoo */
$pb['SITE_INFO']['YAHOO_SITE_VALIDATION'] = '';

/* Site Search Information: MSN/BING */
$pb['SITE_INFO']['BING_SITE_VALIDATION'] = '';

/* Site Technical Settings */
define('USE_404', TRUE);
define('USE_CACHE', FALSE);
define('USE_BACKUP', TRUE);
define('GEO_LOOKUP_IP', FALSE);
define('MAINTENANCE', FALSE);
define('SITE_LANGUAGE', 'en-us');
define('ROBOTS_FILE', 'allow_robots');
define('HTACCESS', 'public-access');
define('DIAGNOSTIC_REPORT', TRUE);
define('SECRET_KEY', 'Facing Giants One More Time');

/* Site Look and Feel */
define('THEME', 'serendipity');
define('ADMIN_THEME', 'purple_haze');

/* Site URI configuration */
define('CONTROLLER_TRIG', 'c');
define('FUNCTION_TRIG', 'f');
define('ID_TRIG', 'i');

/* Site Time Zone */
date_default_timezone_set('US/Pacific'); // set this to your timezone.

// switch ($_SERVER['HTTP_HOST'])
// {
	// case PB_BUILD_NAME . '.' . PB_DOMAIN:
	/* Site Database Information */
	// define('DB_NAME', 'pbdev');
	// define('DB_HOST', 'pasteboard.org');
	// define('DB_USER', 'pasteboard');
	// define('DB_PSWD', 'kandl3x+en1d');
	// break;
	
	// case PB_BUILD_NAME . '.' . PB_DOMAIN . '.dev':
	/* Site Database Information */
	define('DB_NAME', 'pasteboard');
	define('DB_HOST', 'local');
	define('DB_USER', 'root');
	define('DB_PSWD', 'jewel4me');
	// break;
// }

/* End of file */
/* Location: ./sites/[site_domain]/configsite.php */