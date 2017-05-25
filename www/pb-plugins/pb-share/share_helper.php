<?

/**
 * @FILE		tell_five.php
 * @DESC		email to five people
 * @PACKAGE		PROJECT_WEBSTART
 * @VERSION		1.0
 * @AUTHOR		James McCarthy
 * @LICENSE		Commercial, Copyright 2008
 * @SITE		http://www.projectwebstart.com
 */

# Required hidden fields:
# recipient, redirect, from, url
	
	include_once($_SERVER[DOCUMENT_ROOT] . '/pb-config.php');
		
	$mailto_tmp = str_replace(";", "@", $_POST[recipient]);
	$mailto = str_replace("-dot-", ".", $mailto_tmp);
	
	#Business Name <noreply;pasteboard-dot-org
	$from_tmp = str_replace(";", "@", $_POST[from]);
	$from = str_replace("-dot-", ".", $from_tmp);
	
$subject = "A note from your friend $_POST[name]"; 
$headers = "From: $from"; 
$msg="$_POST[name] thought that you might be interested in the following website.\n\n\t$_POST[url]\n\nKarensKommune.Org is all about having a HUGE heart and serving others in need, connecting people to get the word out about opportunities for others to serve the community. Check it out and join our revolution to irresistibly serve God and our community.\n\nNamaste,\nKaren\n\n";

if($_POST[note]) { $msg .= "$_POST[name] has a special note for you:\n" . stripslashes($_POST[note]) . "\n\n"; }

$emailList;
$emailList["e1"] = $_POST[email1];
if($_POST[email2]) { $emailList["e2"] = $_POST[email2]; $count++; }
if($_POST[email3]) { $emailList["e3"] = $_POST[email3]; $count++; }
if($_POST[email4]) { $emailList["e4"] = $_POST[email4]; $count++; }
if($_POST[email5]) { $emailList["e5"] = $_POST[email5]; $count++; }
if($_POST[email6]) { $emailList["e6"] = $_POST[email6]; $count++; }

foreach($emailList as $key => $value) {
    mail($value,$subject,$msg,$headers); 
}

// WRITE TO CSV FILE
 	$today = date("m-d-Y H:i:s");

  	$csv_string = "\"$_POST[name]\",\"$_POST[email]\",\"$_POST[note]\",\"$today\"\n";

	$file = ABSPATH . PB_ROOT . '/csvdata/share_mgr-data.csv';

  	$fh = fopen($file, "w+");
  	$wrote = fwrite($fh, $csv_string);
  	fclose($fh); 


header('location:' . $_POST[redirect]);


?>