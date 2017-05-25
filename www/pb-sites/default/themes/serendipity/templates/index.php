<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?= get_title(); ?></title>
<?= get_base_url(); ?>
<?= get_css(); ?>
<?= get_meta(); ?>
</head>

<body>
	<!-- top navigation start -->
	<div id="topNav">	
		<ul>
			<li><a href="index.html" title="Home" class="hover">home</a></li>
			<li><a href="#" title="Our Clients">our clients</a></li>
			<li><a href="#" title="Support">support</a></li>
			<li><a href="#" title="New Services">new services</a></li>
			<li><a href="#" title="Productions">productions</a></li>
			<li><a href="#" title="Contact">contact</a></li>
		</ul>
	</div>
	<!-- top navigation start -->
	<!-- body start -->
	<div id="body">
		<a href="index.html" title="Green Web"><img src="/pb-sites/default/themes/serendipity/images/logo.gif" alt="Green Web" width="309" height="47" border="0" class="logo" /></a>
		<h1>the way of success
		lorem, sed vulputate </h1>
		<div class="bodyText">
			<h2><span>Who</span> are we?</h2>
			
			<!-- VIEW FILE: MAIN -->
			<div><?= get_view(); ?></div>
			
			<h3 class="floatLeft">Nunc sodales quam :</h3>
			<h4> Trimis in faucibus orci luctus etc quis du</h4>
		</div>
		<div class="catagory">
			<div class="pink">
				<h3 class="floatLeft">News</h3><h4 class="floatLeft">12.02.07</h4><br class="spacer" />
				<?= get_view('news'); ?>
				<!-- sodales quam vel diam. Aenen diam risus, commodo nec, cuus id, mattis id, sem -->
				<h5 class="floatLeft">ante. Nunc quis dui</h5><a href="#" title="more" class="more">more</a>
			</div>
			<div class="green">
				<h3 >Solutions</h3>
				<?= get_view('solutions'); ?>
				<h5 class="floatLeft">sit amet bibendum</h5><a href="#" title="more" class="more">more</a>
			</div>
			<div class="blue">
				<h3>Support</h3>
				<?= get_view('support'); ?>
				<h5 class="floatLeft">aliquet bibendum</h5><a href="#" title="more" class="more">more</a>
	      </div>
		<br class="spacer" /></div>
		<div class="goal">
			<h2><span>Our</span> goals</h2>
			<p class="greenText"><strong>Sed id justo at est nonummy elementum. Pellentesque at lectus id neque aliquet bibendum. Quisque lacusfur magna, aliquet et, dignissim at, consectetuer ut, metus.</strong></p>
			<ul>
				<li><strong>Nunc sodales quam vel diam. Aenean diam risus,</strong> cod nec, cursus id, mattis id, sem. Curabitur eleifend dolor vitae massa. DonecUt a nisi. Donec</li>
				<li><strong>Donec euismod, justo sit amet viverra tincidunt, libero velit elementum lorem, </strong>sed vulputate odio dui a erat sed vu. Suspendisse eget enim. Phasellus interdum</li>
			</ul>
		</div>
		<form method="post" action="#" name="login" class="login">
			<h2>Members login</h2>
			<label>Name</label><input name="name" type="text" tabindex="1" id="name" /><br class="spacer" />
			<label>Password</label>
			<input name="password" type="text" tabindex="2" id="password" />
			<br class="spacer" />
			<a href="#" title="Forget password - click here">forget password</a> 
			<input name="" type="image" src="/pb-sites/default/themes/serendipity/images/login_btn.gif" tabindex="3" title="Login" class="loginBtn" />
		</form>
	<br class="spacer" /></div>	
	<!-- body end -->	
	<!-- footer start -->
	<div id="footer">
		<div class="footer">
			<ul>
				<li><a href="#" title="Home">home</a>|</li>
				<li><a href="#" title="Our Clients">our clients</a>|</li>
				<li><a href="#" title="Support">support</a>|</li>
				<li><a href="#" title="New Sservices">new services</a>|</li>
				<li><a href="#" title="Productions">productions</a>|</li>
				<li><a href="#" title="Contact">contact</a></li>
			</ul>
			<p>&copy;green web. All rights reserved.</p>
			<p class="valid"><a href="http://validator.w3.org/check?uri=referer" target="_blank" title="Valid XHTML" class="xhtml">XHTML</a> <a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank" title="Valid CSS" class="css">CSS</a></p><br class="spacer" />
			<p class="tworld">Designed by : <a href="http://www.templateworld.com" title="Template World" target="_blank">Template World</a></p>
	    <br class="spacer" /></div>
	</div>
	<!-- footer end -->		
</body>
</html>
