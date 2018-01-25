<?php

include('./utility.php');

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
	debug_to_console( "Could not connect to the MySQL service.<br />Please check the config file." );
}


// Create database
$drop_db = "DROP DATABASE IF EXISTS {$_DVWA[ 'db_database' ]};";
if( !@mysqli_query($GLOBALS["___mysqli_ston"],  $drop_db ) ) {
	debug_to_console( "Could not drop existing database<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
}

$create_db = "CREATE DATABASE {$_DVWA[ 'db_database' ]};";
if( !@mysqli_query($GLOBALS["___mysqli_ston"],  $create_db ) ) {
	debug_to_console( "Could not create database<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
}

// Create table 'user'
if( !@((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $_DVWA[ 'db_database' ])) ) {
	debug_to_console( 'Could not connect to database.' );
}

$create_tb = "CREATE TABLE user(
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50),
    passcode VARCHAR(200),
    lastLogin TIMESTAMP,
    state BOOLEAN NOT NULL DEFAULT 1,
    attempt INT(10) NOT NULL DEFAULT 0,
	sessionID varchar(33),
    PRIMARY KEY (id)
);";
if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_tb ) ) {
	debug_to_console( "Table could not be created<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
}

$create_session_tb = "CREATE TABLE clientSession(
    SessionID varchar(33) NOT NULL,
	Counter int(11) NOT NULL,
	Tstamp datetime NOT NULL,
    PRIMARY KEY (SessionID)
);";

if( !mysqli_query($GLOBALS["___mysqli_ston"],  $create_session_tb ) ) {
	debug_to_console( "Table could not be created<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
}

// Insert some data into users

$insert = "INSERT INTO 
	user (username, passcode) 
		VALUES ('admin','Password123');";
if( !mysqli_query($GLOBALS["___mysqli_ston"],  $insert ) ) {
	debug_to_console( "Data could not be inserted into 'users' table<br />SQL: " . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)) );
}

// Done

$login = "<a href='login.php'>login</a>";
header("location: index.php");

?>
