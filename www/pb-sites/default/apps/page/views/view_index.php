<?php

/**
 * pages/view.php
 * content template for displaying static pages
 *
 * @package    pasteboard
 * @subpackage core
 * @author     pasteboard team <pb_team@pasteboard.org>
 * @copyright  Copyright (c) 2010, pasteboard group
 * @license    GNU General Public License, http://pasteboard.org/?p=license
 * @link       http://www.pasteboard.org
 */
 
 // VIEW LEVEL SHOULD USE VARIABLES ONLY
?>
<!-- VIEW: view_index.php -->
<!-- generated on <?= get_date_long(); ?> -->

<!-- example of pulling data out of the $pb global array -->
<div style="margin: 10px 0 10px 0; border: 1px solid #006633; background-color: #99CC99; padding: 5px; font-family: verdana, sans-serif;">
<p style="background-color: #99CC99; padding: 20px 20px 0 20px;">
FILE: view_index.php<br />
THEME: <?= $pb['SITE_INFO']['theme'] ?><br />
APPLICATION: <?= $pb['ROUTER']['app'] ?><br />
SESSION: <?= $_SESSION['SID'] ?><br />
USERNAME: <? if(isSet($_SESSION['username'])) { print $_SESSION['username'] . "| <a href=\"/admin/login/\">admin</a>"; } else { print "no username found | <a href=\"/admin/login\">login</a>"; } ?><br />
BASE URL: <?= $pb['SITE_INFO']['SITE_URL'] ?><br />
<!-- example of using the singular variables of the DATA array index -->
</p>
<p style="background-color: #99CC99; padding-left: 20px;>PAGE CONTENT: <p>
<?= $page_content ?>

<p style="background-color: #99CC99; padding: 0px 20px 20px 20px">
<b>Other Articles (function within view_index.php)</b><br />
<!-- example of calling a function to return dynamic data within a view -->
<?= get_content_index(); ?>
</p>

<!-- <p style="background-color: #99CC99;">
<a href="/page/view/2/">Next Page</a> (segment URI) / <a href="/?c=page&f=view&i=2">Next Page</a> (query string)
</p> -->

</div>
<!-- /VIEW: view_index.php -->