<?

session_start();
require("admin-library/admin-start.php");
if(!$_SESSION[username]) { header('location:/pb-admin/auth.php'); }

// http://www.pasteboard.org
// for support visit our forums online

?>