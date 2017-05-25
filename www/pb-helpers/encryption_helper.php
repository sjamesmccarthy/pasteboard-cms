<?php 
 
/**
 * @FILE		diagnostics_helper.php
 * @DESC		produces diagnostic output in table format for the pb_array
 * @PACKAGE		pasteboard
 * @SITE		http://www.pasteboard.org
 */

function create_new_pswd ($length = 8)
{
  $str = NULL;
  $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$!%#@&!"; 
    
  $i = 0; 
  while ($i < $length) { 
    $build = substr($chars, mt_rand(0, strlen($chars)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($str, $build)) { 
      $str .= $build;
      $i++;
    }

  }

  return($str);
}


?>