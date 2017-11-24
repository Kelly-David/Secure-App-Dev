<?php
/*
 * @Author: David Kelly 
 * @Date: 2017-11-23 21:14:15 
 * @Last Modified by: david
 * @Last Modified time: 2017-11-24 09:03:53
 */

   define('DB_SERVER', 'localhost:3306');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'test');

   /* Attempt to connect to MySQL database */
   $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
   // Check connection
   if($link === false){
     die("ERROR: Could not connect. " . mysqli_connect_error());
  }
?>