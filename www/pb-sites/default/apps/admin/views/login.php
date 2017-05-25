<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<!--
Design by James McCarthy
http://www.pasteboard.org
Copyright 2008
-->

<head>

<!-- required: plops the page title based on the XML file -->
<title><? print $CONFIG[SITE_NAME] . "| Admin"; ?></title>

<!-- required: base href so you don't have to keep writing this for all relative URLs -->
<base href="<? print $CONFIG[SITE_URL]; ?>/pb-admin/" />
	
<!-- optional: favorite icon, okay to remove if you don't want to use -->
<link rel="shortcut icon" href="admin-themes/<? print $CONFIG[ADMINTHEME]; ?>/images/favicon.ico" type="image/x-icon" />
	
<!-- required: CSS information -->
<link href="admin-themes/<? print $CONFIG[ADMINTHEME]; ?>/css/login.css" rel="stylesheet" type="text/css" media="screen" />

<script src="<? print ABSPATH . PB_ROOT . 'js/err_login.js'; ?>" type="text/javascript"></script>
</head>

<body>

<div id="stripe">
	<p>&laquo; Back to <a href="<? print $CONFIG[SITE_URL]; ?>"><? print $CONFIG[SITE_NAME]; ?></a></p>
</div>

<div id="container">
	
	<img src="admin-themes/<? print $CONFIG[ADMINTHEME]; ?>/images/login.png" />
	<form id="login" action="auth.php" method="post" onsubmit="return error_chk('login');">

	<? if($CONFIG[ERR]) {
		print "<div id=\"error\"><p>";
		
			if($CONFIG[BADLOGIN] == 1) { 
				print "BAD LOGIN"; 
				$FORM_ACTION = "login";
			} 
	   		elseif($CONFIG[LOGGEDOUT] == 1) { 
	   			print "LOGGED OUT"; 
	   			$FORM_ACTION = "login";
	   		}
	   		elseif($CONFIG[RESET] == 1) { 
	   			print "RESET PASSWORD"; 
	   			$FORM_ACTION = "do_reset";
	   		} 
	   		elseif($CONFIG[RESETSENT] == 1) { 
	   			print "GENERATED NEW PASSWORD<br /><p>emailed to $_POST[email]</p>"; 
	   			$FORM_ACTION = "login";
	   		} 
	   		
	   		else {
	   			$FORM_ACTION = "login";
	   		}
	   		
	   	print "</p></div>";
	   	} else { $FORM_ACTION = "login"; }
	 ?>
	
	<input type="hidden" name="action" value="<? print $FORM_ACTION; ?>">
		
	<? if($_GET[action] != "reset") { ?>
	<p>
	username:<br />
	<input class="fields" type="text" name="username">
	</p>
	
	<p>
	password:<br />
	<input class="fields" type="password" name="pswd">
	</p>
	
	<div id="button">
	<input type="submit" value="Login">
	</div>
	
	<div id="rememberme">
	<!-- <input type="checkbox" name="rememberme" value="1"> Remember Me -->
	<p><a href="auth.php?action=reset">Lost Your Password?</a></p>
	<p style="font-size: xx-small">Serial Number:<br />
	<? $SN = makeserial(); print "<b>" . $SN . "</b>"; ?></p>
	</div>
	
	<!-- <div id="forgot">
	<p>
	<a href="auth.php?action=reset">Lost Your Password?</a>
	</p>
	</div> -->
	
	<? } else { ?>
	
	<p>
	email:<br />
	<input class="fields" type="text" name="email" size="23">
	</p>
	
	<p>
	Please type the email address you used to register your account. If you don't know this your password can't be reset and you will have to <a href="/?p=contact">contact</a> us.
	</p>
	
	<div id="button">
	<input type="submit" value="Generate New Password">
	</div>
	
	<div id="rememberme">
	<p><a href="/pb-admin/">Login</a></p>
	</div>
	
	<? } ?>
	
	</form>

</div> <!-- container -->

</body>
</html>