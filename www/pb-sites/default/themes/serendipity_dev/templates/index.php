<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<!-- required: plops the page title based on the XML file -->
<title><?= get_title(); ?></title>

<!-- required: base href so you don't have to keep writing this for all relative URLs -->
<base href="<?= get_base_url(); ?>" /> 
	
<!-- optional: favorite icon, okay to remove if you don't want to use -->
<?= get_fav_icon(); ?>
	
<!-- required: CSS information -->
<?= get_css(); ?>

<!-- required: default meta tag information -->
<?= get_meta(); ?>

<!-- optional: custom meta tag information 
<?= get_meta('expires','Wed, 26 Feb 1997 08:21:57 GMT','http-equiv'); ?>
<?= get_meta('mobile_view','FALSE'); ?> 
-->

<!-- optional: JAVASCRIPT files -->
<?= get_js(); ?>

</head>

<body>

<!-- required: creates the actual page elements -->
<div id="wrapper" style="font-family:verdana, sans-serif;">
	<p>template.start</p>
	<p>page_slug: <?= $page_slug; ?></p>
	<!-- <img src="/pb-sites/default/images/home.png" alt="home_pg" /> -->
	<?= get_view(); ?>
	<p>/template.end</p>
</div> <!-- DIVid: wrapper -->

</body>
</html>