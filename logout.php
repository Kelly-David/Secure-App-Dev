<?php
/*
 * @Author: David Kelly 
 * @Date: 2017-11-24 21:08:35 
 * @Last Modified by: david
 * @Last Modified time: 2017-11-27 14:29:03
 */

session_start();
if(isset($_COOKIE[session_name()])) {
    setcookie(session_name(),'',time()-3600); # unset session id/cookies
}
unset($_SESSION['username']);
$_SESSION = array();
session_destroy();
session_commit(); 

header("location: login.php");

exit;
?>