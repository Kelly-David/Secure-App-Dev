<?php

/*

This file contains all of the code to setup the initial MySQL database. (setup.php)

*/
$DBMS = 'MySQL';

$_DVWA = array();
$_DVWA[ 'db_server' ]   = 'localhost:3306';
$_DVWA[ 'db_database' ] = 'c00193216';
$_DVWA[ 'db_user' ]     = 'root';
$_DVWA[ 'db_password' ] = '';

define( 'DVWA_WEB_PAGE_TO_ROOT', '../../../' );

if( !@($GLOBALS["___mysqli_ston"] = mysqli_connect( $_DVWA[ 'db_server' ],  $_DVWA[ 'db_user' ],  $_DVWA[ 'db_password' ] )) ) {
	dvwaMessagePush( "Could not connect to the MySQL service.<br />Please check the config file." );
	if ($_DVWA[ 'db_user' ] == "root") {
		dvwaMessagePush( 'Your database user is root, if you are using MariaDB, this will not work, please read the README.md file.' );
	}
	dvwaPageReload();
}


// Create database
$drop_db = "DROP DATABASE IF EXISTS {$_DVWA[ 'db_database' ]};";
if( !@mysqli_query($GLOBALS["___mysqli_ston"],  $drop_db ) ) {
	dvwaMessagePush( "Could not drop existing database<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
	dvwaPageReload();
}

$create_db = "CREATE DATABASE {$_DVWA[ 'db_database' ]};";
if( !@mysqli_query($GLOBALS["___mysqli_ston"],  $create_db ) ) {
	dvwaMessagePush( "Could not create database<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
	dvwaPageReload();
}

// Create table 'users'
if( !@((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $_DVWA[ 'db_database' ])) ) {
	dvwaMessagePush( 'Could not connect to database.' );
	dvwaPageReload();
}

$create_tb = "CREATE TABLE users(
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50),
    passcode VARCHAR(200),
    lastLogin TIMESTAMP,
    state BOOLEAN NOT NULL DEFAULT 1,
    attempt INT(10) NOT NULL DEFAULT 0,
    PRIMARY KEY (id)
);";
if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_tb ) ) {
	dvwaMessagePush( "Table could not be created<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
	dvwaPageReload();
}

// Insert some data into users
// Get the base directory for the avatar media...
$baseUrl  = 'http://' . $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'PHP_SELF' ];
$stripPos = strpos( $baseUrl, 'setup.php' );
$baseUrl  = substr( $baseUrl, 0, $stripPos ) . 'hackable/users/';

$insert = "INSERT INTO 
	users (username, passcode) 
		VALUES ('admin','Password123');";
if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
	dvwaMessagePush( "Data could not be inserted into 'users' table<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
	dvwaPageReload();
}

// Done

echo("<body><h1>Please <a href='login.php'>login</a></h1></body>" );

?>
