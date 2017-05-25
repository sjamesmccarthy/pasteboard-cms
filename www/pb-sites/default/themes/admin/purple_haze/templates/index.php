<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<!--
Design by James McCarthy
http://www.pasteboard.org
Copyright 2008
-->

<head>

<!-- required: plops the page title based on the XML file -->
<title><?= get_title(); ?></title>

<!-- required: base href so you don't have to keep writing this for all relative URLs -->
<?= get_base_url(); ?>
	
<!-- optional: favorite icon, okay to remove if you don't want to use -->

<!-- required: CSS information -->
<?= get_css(); ?>

<body>

<div id="wrap">
	<div id="header"><h1><? print substr($SITE_NAME,0,25); ?>&nbsp;&raquo; <a class="small" target="_new" href="<?= $SITE_URL ?>">view site</a></h1></div>
	<div id="welcome"><p><?= $login ?><br /><a target="_new" href="http://www.projectwebstart.com/?p=contact">support</a> . <a href="<?= $SITE_URL ?>/admin/logout/">logout</a></p></div>	
	
		<!-- <form id="sysadmin"> -->
		<div id="nav">
		<ul>
			<li id="nav-dashboard"><a href="?form=dashboard">Dashboard</a></li> .
			<li id="nav-pages"><a href="?form=pages">Content</a></li> .			
			<li id="nav-plugins"><a href="?form=plugins">Plugins</a></li> .
			<li id="nav-seo"><a href="?form=seo">SEO</a></li> .
			<li id="nav-profile"><a href="?form=profile">Profile</a></li> .
			<li id="nav-settings"><a href="?form=settings">Settings</a></li>
			
			<? 
			#commenting out for now
			#if($_SESSION[role] == "system") { build_sysadmin(); } 
			?>
			
		</ul>
	</div>
	<!-- </form> -->
	
	<div id="main">
	<?= get_view(); ?>
	</div>
	
</div>
	<div id="footer">
	<p>powered by PASTEBOARD v<? print PB_VERSION; ?> | copyright 2010 The PasteBoard Group | theme: <?= ADMIN_THEME ?></p>
	</div>
	
</body>

</html>