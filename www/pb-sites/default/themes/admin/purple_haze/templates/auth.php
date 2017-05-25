<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<!--
Design by James McCarthy
http://www.pasteboard.org
Copyright 2008
-->

<head>
<!-- required: plops the page title -->
<title><?= get_title(); ?> </title>

<!-- required: base href so you don't have to keep writing this for all relative URLs -->
<?= get_base_url(); ?>
	
<!-- optional: favorite icon, okay to remove if you don't want to use -->
<?= get_fav_icon(); ?>
	
<!-- required: CSS information -->
<?= get_css(); ?>

<!-- optional: JS scripts -->
<?= get_js(); ?>
</head>

<body>

<div id="stripe">
	<p>&laquo; Back to <a href=""><?= $SITE_COMPANY_NAME; ?></a></p>
</div>
	
<?= get_view(); ?>

</body>
</html>