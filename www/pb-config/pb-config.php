<?php 
if ( ! defined('PB-START')) exit('No direct script access allowed');

/**
 * pb-config.php
 * The configuration file. It's pretty straight forward and sets a bunch of
 
 * constants for use with the system so that we don't have to pass a bunch of
 * params to functions or over use the GLOBAL scope which can become confusing.
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2009, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org
 */

/**
 * Information about the pasteboard package.
 */
define('PB_NAME', 'pasteboard');
define('PB_VERSION', '0.0.1');
define('PB_LICENSE', 'GPL v.3');
define('PB_DOMAIN', 'pasteboard.local');
define('PB_UPDATE_STATUS', TRUE);
define('PB_LOG_STATUS', TRUE);
define('PB_BUILD_NAME', 'kismet');

/**
 * System path information. 
 * Makes it easier in case things change down the road.
 */
define('PB_ROOT', $_SERVER["DOCUMENT_ROOT"]);
define('PB_CONFIG_PATH', 'pb-config' . '/' );
define('PB_LIBRARIES_PATH', 'pb-libraries' . '/' );
define('PB_HELPERS_PATH', 'pb-helpers' . '/' );
define('PB_SITES_PATH', 'pb-sites' . '/');
define('PB_THEMES_PATH', 'themes' . '/');
define('PB_ADMIN_THEMES_PATH', 'admin/');
define('PB_APPS_PATH', 'apps' . '/' );
define('PB_LOG_PATH', 'logs' . '/' );
define('PB_SCRIPTS_PATH', 'scripts' . '/' );

/**
 * For future multi-language support, but not really being used right now.
 */
define('CHARACTER_ENDCODING', 'text/html; charset=UTF-8');
define('LANGUAGE','us-EN');

/**
 * Why load everything at one time. 
 * Autoload only the library files necessary to fire-up the system
 */
$pb['AUTOLOAD']['pb-config'] = array('useragents-config', 'dates-config', 'fopen-config', 'stopwords-config');
$pb['AUTOLOAD']['pb-libraries'] = array('pb-database', 'pb-useragent', 'pb-hooks','pb-sessions', 'pb-cache', 'pb-scaffolding','pb-errors','pb-uri', 'pb-logs');
/**
 * php.ini override settings
 * LIST ANY ADDITIONAL .INI OVERRIDE SETTINGS HERE. (ADVANCED)
 */
ini_set('max_upload_filesize', 8388608); // uploading files via website; some php environments also need a .htaccess file
ini_set('magic_quotes_gpc', 0); // Kill magic quotes

$log_msg[] = ('info|pb-config Initialized');

/* End of file */
/* Location: ./pb-config/pb-config.php */