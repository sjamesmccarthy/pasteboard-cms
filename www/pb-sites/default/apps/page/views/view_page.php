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
<div style="margin: 10px 0 10px 0; border: 1px solid #FFFF00; background-color: #FFFFCC; padding: 5px; font-family: verdana, sans-serif;">
<p style="background-color: #FFFFCC; padding: 20px;">
<!-- example of using the singular variables of the DATA array index -->
SECONDARY PAGE CONTENT:
</p>
<?= $page_content ?>
<p style="background-color: #FFFFCC; padding: 20px;">
<a href="/">Back Home</a>
</p>

</div>
<!-- /VIEW: view_index.php -->