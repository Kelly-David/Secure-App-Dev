<?php
/*
 * @Author: David Kelly 
 * @Date: 2017-11-23 21:14:15 
 * @Last Modified by: david
 * @Last Modified time: 2017-11-24 08:59:42
 */

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>