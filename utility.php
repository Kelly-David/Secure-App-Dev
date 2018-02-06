<?php
/*
 * @Author: David Kelly 
 * @Date: 2017-11-23 21:14:15 
 * @Last Modified by: david
 * @Last Modified time: 2018-02-06 10:57:39
 */


// Testing fucntion: output to console
function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

/** Function: Checks ReCaptcha 
 *  Source: Levit Jun 10 '15 at 7:02 
 *  Available: https://stackoverflow.com/questions/27274157/new-google-recaptcha-with-checkbox-server-side-php
*/
function isValid() 
{
    try {

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret'   => '6Lcb6D8UAAAAANgb3YxxUzEE3QO997LnQz9XVtgi',
                 'response' => $_POST['g-recaptcha-response'],
                 'remoteip' => $_SERVER['REMOTE_ADDR']];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data) 
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result)->success;
    }
    catch (Exception $e) {
        return null;
    }
}

function getSalt($param) {
    $secure_param = "";

    $param = md5($param);
    $param = substr($param,0,10);
    $secure_param = strrev($param);

    return $secure_param;
}

function getParmaSalt($param) {
    return strrev(substr(md5($param),0,10));
}

?>