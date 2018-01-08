<?php

if( isset( $_POST[ 'create_db' ] ) ) {

    $DBMS = 'MySQL';
	
	if( $DBMS == 'MySQL' ) {
		include_once 'db/includes/DBMS/MySQL.php';
	}
	else {
		dvwaMessagePush( 'ERROR: Invalid database selected. Please review the config file syntax.' );
		dvwaPageReload();
	}
}

?>

<!-- Create db button -->
<form action="#" method="post">
	<input name="create_db" type="submit" value="Build Database">
</form>