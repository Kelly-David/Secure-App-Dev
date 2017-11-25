<?php
/*
 * @Author: David Kelly 
 * @Date: 2017-11-24 21:08:35 
 * @Last Modified by: david
 * @Last Modified time: 2017-11-25 06:14:42
 */

// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: login.php");
exit;
?>