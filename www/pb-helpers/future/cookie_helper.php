<?php

/**
 * @FILE		/pa-apps/sitemap_builder/sitemap.php
 * @DESC		produces a sitemap output as an XML for google+XML for webstart
 * @PACKAGE		PROJECT_WEBSTART
 * @SITE		http://www.projectwebstart.org
 * @PARAMS		none
 *				https://www.google.com/webmasters/tools/docs/en/protocol.html#sitemapXMLFormat
 */
 
 # path to /pages/dir
 # use XML output function for webstart
echo "started.sitemap_builder : google.xml<hr />";

// LOAD PROJECT_WEBSTART CONFIGURATION FILE //
include("../../pw-config.php");

// GET THE DIRECTORY LISTING OF THE /pages DIRECTORY
$path = ABSPATH . PAGESPATH;
$handle=opendir($path);

while(false!==($file=readdir($handle))){

	// put this into an exceptions array
	if($file != "." && $file != ".." && $file != "phpsnips" && $file != "thank_you.xml" && $file != "paypal_thanks.xml" && $file != "sitemap.xml"){
	$files[]="$file";
	}
}
closedir($handle);
sort($files);

// OPEN SITE_MAP.XML FOR EXDITING
     if(($fh_xml = fopen($CONFIG[GOOGLE_SITEMAP],'w+')) === FALSE){
        die('Failed to open file for writing : ' . $CONFIG[GOOGLE_SITEMAP]);
     }
     
      if(($fh_page = fopen(ABSPATH . PAGESPATH. 'sitemap.xml','w+')) === FALSE){
        die('Failed to open file for writing : ' . $CONFIG[GOOGLE_SITEMAP]);
     }
     
     
print "<pre>";
	
	print "outputted sitemap.xml to: " . ABSPATH . PAGESPATH. "sitemap.xml<br />";
	
	# Output header for XML file
	$googleresult_header = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<!--Google Site Map File Generated for $CONFIG[SITE_URL] $CONFIG[DATE_TIME] -->
	<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">";
     $pageresult_header = "<content><![CDATA[<!-- Site Map File Generated for $CONFIG[SITE_NAME] $CONFIG[DATE_TIME] --><p><span class=\"emph\">Sitemap</span><br />Maybe this will help you find what you are looking for: an alphabetical list of all the pages at $CONFIG[SITE_URL]. If not, please <a href=\"page/contact/\">contact us</a></p><ul id=\"sitemap\">";
     
     $i=1;
     while ($i < count($files)) {
     	$filename = split("\.", $files[$i]);
        $googleresult_body .= "
        <url>
            <loc>" . URLPATH  . "page/$filename[0]/</loc>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>
        </url>";
        
        $pageresult_body .= "<li><a href=\"" . URLPATH  . "page/$filename[0]/\">$filename[0]</a>";
        $i++;
     }
     
     # Output/Write XML to file and close file handler
     $googleresult_footer .= "\n</urlset>";
     $pageresult_footer .= "</ul>]]></content>";
     $googleresult = $googleresult_header . $googleresult_body . $googleresult_footer;
     fwrite($fh_xml, $googleresult);
     
     // BUILD OUT REST OF PAGE BODY
     $pageresult = $pageresult_header . $pageresult_body . $pageresult_footer;
     $pagebuild = writeHeader($pageresult);
     fwrite($fh_page, $pagebuild);
     
     fclose($fh_xml);
     fclose($fh_page);
     
     print $googleresult;
     print "</pre>";    
     
     print "<hr />";
	 print "completed.sitemap_builder : <a href=\"" . URLPATH  .  "page/sitemap/\">sitemap.xml</a><br />";
	 print "Submit this URL to google webmaster tools: <a href=\"" . URLPATH . "sitemap.xml\">" . URLPATH . "sitemap.xml</a>";


function writeHeader($content) {
GLOBAL $CONFIG;

$pagebuild = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<page>
<template>default.tpl</template>
<pagecss></pagecss>
	
<title>HelpMePayMyLawyer.Org - Sitemap</title>
	
<meta_pragma>no-cache</meta_pragma>
<meta_content_type>text/html; charset=UTF-8</meta_content_type>
<meta_content_language>en-US</meta_content_language>
<meta_robots>all</meta_robots>
	
<meta_description>Sitemap for HelpMePayMyLawyer.Org, please mail me a $1 to help with divorce costs.</meta_description>
<meta_abstract>Sitemap for HelpMePayMyLawyer.Org</meta_abstract>
<meta_keywords>reno, divorce, attorney, children, fathers rights, parental alienation, judges, washoe, nevada</meta_keywords>
<meta_author>James McCarthy</meta_author>
<meta_rating>General</meta_rating>
$content
<lastupdate>$CONFIG[DATE_TIME]</lastupdate>
<status>Published</status>
</page>	
";

return($pagebuild);

}

?>