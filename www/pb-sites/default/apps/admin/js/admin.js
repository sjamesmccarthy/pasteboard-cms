function rememberme_toggle()
{

	var selIdx = document.getElementById('rememberme_duration').selectedIndex;
	if(selIdx > 0)
	{
		if(selIdx == 1) {
		document.getElementById('rememberme_desc').innerHTML = ' week'; 
		}
		else {
		document.getElementById('rememberme_desc').innerHTML = ' weeks'; 
		}
	} else {
		document.getElementById('rememberme_desc').innerHTML = ' this session';
	}
}

function error_chk() 
{

	var missing = "";
	var ve = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
	
	if(!document.forms[0].username.value) { missing += " \n- Your username"; }
	if(!document.forms[0].pswd.value) { missing += " \n- Your password"; }
	
	if( missing ){ 
		alert ("Missing entries for the following fields:\n" + missing )
		return false;
	}
	
}	