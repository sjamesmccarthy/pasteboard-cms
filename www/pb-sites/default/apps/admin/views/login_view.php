<!-- <div id="logo_container">
<img src="/pb-sites/default/themes/admin/purple_haze/images/login.png" />
</div> -->

<div id="container">
	
	<img src="/pb-sites/default/themes/admin/purple_haze/images/login.png" />
	
	<? 	if(isSet($notification_title)) {
		$skip_notification = FALSE;
		
			if($notification_title == 'BAD_LOGIN') { 
				$FORM_ACTION = "auth";
			} 
	   	
	   		elseif($notification_title == 'RESET_PASSWORD') { 
	   			$FORM_ACTION = "resetpswd";
	   			$notification_title = 'RESET_PASSWORD_ERROR';
	   			if($status != "FAILED") { $skip_notification = TRUE; }
	   		}
	   		
	   		elseif($notification_title == 'PASSWORD_RESET') { 
	   			$FORM_ACTION = "login";
	   		}
	   		
	   		elseif($notification_title == 'NOT_LOGGED_IN') { 
	   			$FORM_ACTION = "auth";
	   		}
	   		
			elseif($notification_title == 'LOGOUT') { 
	   			$FORM_ACTION = "auth";
	   		}
			
	   		else {
	   			$FORM_ACTION = "login";
	   		}
	   		
			$msg = "<div id=\"error\"><p>";
	   		$msg .= '<b>' . str_replace('_', ' ',$notification_title) . '</b><br /><span style="font-size: 9pt;">';
			$notification_msg = wordwrap($notification_msg, 45, "<br />");
			$msg .= $notification_msg . '</span>';
				
	   		if($skip_notification != TRUE)
	   		{
	   			print "$msg</p></div>";
	   		}
	   	}
	    else {
	   		$FORM_ACTION = "auth"; 
	   	}
	 ?>

	<form id="login" action="/admin/<?= $FORM_ACTION ?>/" method="post" onsubmit="return error_chk('login');">
	
	<? if($notification_title != "RESET_PASSWORD_ERROR") { ?>
		<? if($result == "PASSWORD_RESET") { ?>
			<!-- <p id="rememberme"><a href="/admin/login/">Login</a></p> -->
		<? } else { ?>
	<p>
	username:<br />
	<input class="fields" type="text" name="username" size="20">
	</p>
	
	<p>
	password:<br />
	<input class="fields" type="password" name="pswd"  size="20">
	</p>
	
	<p id="button">
	<input type="submit" value="Login" class="button" />
	</p>
	
	<p id="rememberme">
	<!-- <input type="checkbox" name="rememberme" value="1"> --> 
	Remember me for 
	<select id="rememberme_duration" name="rememberme_duration" onchange="rememberme_toggle();">
	<option value="0" SELECTED>-</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	</select> <span id="rememberme_desc">this session</span> 
	</p>

	
	<? } ?>
	<? } else { ?>
	<!-- else if for newpswd -->
	
	<p>
	email:<br />
	<input class="fields" type="text" name="email" size="20">
	</p>
	
	<p>
	Please type the email address you used to register your account. If you don't know this your password can't be reset and you will have to <a href="/page/view/contact-us">contact</a> us.
	</p>
	
	<p id="button">
	<input type="submit" value="Generate New Password">
	</p>
	
	<p id="rememberme">
	<a href="/admin/login/">Login</a>
	</p>
	
	<? } ?>
	
	</form>

</div> <!-- container -->
	
	<? if($result == "PASSWORD_RESET") { ?>
	<div id="forgot_container">
	<p><a href="/admin/login">Try Login Again</a></p>
	</div>
	<? }
	else if($FORM_ACTION != 'resetpswd') { ?> 
	<div id="forgot_container">
	<p><a href="/admin/login/?result=RESET_PASSWORD">Lost Your Password?</a></p>
	</div>
	<? } ?>
	