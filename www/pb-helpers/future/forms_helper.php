<?

/*
// -------------------------------------------------------------------
// CONTACT_MGR()
// -------------------------------------------------------------------
// This file will write data to a CSV file 
//
// -------------------------------------------------------------------
// USAGE INSTRUCTIONS
// -------------------------------------------------------------------
// <? snip_login(); ?>
//
// -------------------------------------------------------------------
// UPDATE HISTORY
// -------------------------------------------------------------------
// SJM - 01/06/09 - Added new header/footer comments
//
*/
	
	include_once($_SERVER[DOCUMENT_ROOT] . '/pb-config.php');
	
	# DO SOME MINOR SERVER_SIDE ERROR CHECKING
 	if(!$_POST[name]) $err++;
 	if(!$_POST[email]) $err++;
  	if(!$_POST[subject]) $err++;
  	if($err > 1) {
  		print "Could not process form, because javascript is not enabled"; 
  		die; 
  	}
 	# ##########
	
	$mailto_tmp = str_replace(";", "@", $_POST[recipient]);
	$mailto = str_replace("-dot-", ".", $mailto_tmp);
	
	$subject = "Comment Form | $_POST[subject]"; 
	$headers = "From: $_POST[name] <$_POST[email]>"; 
	$msg = "Subject: $_POST[subject]\nFrom: $_POST[name] ($_POST[email])\n\nNote: $_POST[note]\n\nSent from $_SERVER[REMOTE_ADDR] : http://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";
	mail($mailto,$subject,$msg,$headers);
	
	// WRITE TO CSV FILE
 	$today = date("m-d-Y H:i:s");

  	$csv_string = "\"$_POST[name]\",\"$_POST[email]\",\"$_POST[note]\",\"$today\"\n"; 

  	$file = ABSPATH . PB_ROOT . '/csvdata/contact_mgr-data.csv';

  	$fh = fopen($file, "w+");
  	$wrote = fwrite($fh, $csv_string);
  	fclose($fh); 

	header('location:' . $_POST[redirect]);

?>