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

$link = mysqli_connect($DB_Param['server'],$DB_Param['user'],$DB_Param['password']);
// Check connection
if($link === false) {
    die('Error: Could not connect to db :' . mysqli_connect_error());
}

// Drop the db if is already exists
$sql_purge = "DROP DATABASE IF EXISTS {$DB_Param['database']};";
if( !@mysqli_query($link,$sql_purge)) {
    debug_to_console("Could not drop database");
}

// Create the db
$sql_create = "CREATE DATABASE {$DB_Param['database']};";
if( !@mysqli_query($link,$sql_create)) {
    debug_to_console("Could not create database");
}

// Use the database
if( !@((bool)mysqli_query($link, "USE " . $DB_Param['database'])) ) {
	debug_to_console( 'Could not connect to database.' );
}

// Create the user table
$sql_create_tb = "CREATE TABLE user(
    id INT NOT NULL AUTO_INCREMENT,
    fullname VARCHAR(50),
    passcode VARCHAR(200),
    email VARCHAR(200),
    dob VARCHAR(10),
    lastLogin TIMESTAMP,
    state BOOLEAN NOT NULL DEFAULT 1,
    attempt INT(10) NOT NULL DEFAULT 0,
	sessionID varchar(33),
    PRIMARY KEY (id)
);";
if( !@mysqli_query($link,$sql_create_tb)) {
    debug_to_console("Could not create user table");
}

// Done - redirect
$login = "<a href='login.php'>login</a>";
header("location: index.php");

?>



