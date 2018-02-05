<?php
/**
 * File: mysql.php
 * Project: /Applications/XAMPP/xamppfiles/htdocs/c00193216/db
 * File Created: Monday, 5th February 2018 1:37:05 pm
 * Author: david
 * -----
 * Last Modified: Monday, 5th February 2018 1:50:53 pm
 * Modified By: david
 * -----
 * Description: Create DB and tables
 */


include('./utility.php');

$DBMS = 'MySQL';

$DB_Param = array();
$DB_Param['server'] = 'localhost:3306';
$DB_Param['database'] = 'c00193216';
$DB_Param['user'] = 'root';
$DB_Param['password'] = '';

$link = mysqli_connect($DB_Param['server'],$DB_Param['user'],$DB_Param['password'], $DB_Param['database']);
// Check connection
if($link === false) {
    die('Error: Could not connect to db :' . mysqli_connect_error());
}


