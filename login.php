<!--
 * @Author: David Kelly 
 * @Date: 2017-11-23 15:43:44 
 * @Last Modified by:   david 
 * @Last Modified time: 2017-11-23 15:43:44
* @Description: User Login.
-->
<?php
require_once("config.php");
require_once("utility.php");

date_default_timezone_set("Europe/Dublin");

// Get IP address
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
// Get user agent
$browser = $_SERVER['HTTP_USER_AGENT'];

// Build client ID string
$anonClientID = (string)$browser. (string)$ip;

// Start a session
session_start();

// Hash and store client ID 
$anonClientID = md5($anonClientID);
$_SESSION["AnonClientSessionID"]=$anonClientID;

// Check if we have seen this client
$sql = "SELECT `Counter`,`Tstamp` FROM `clientSession` WHERE `SessionID` = '$anonClientID'";
$objDateTime = new DateTime('NOW');
$query = mysqli_query($link,$sql);

if ($query->num_rows == 0) {  // New client
	$sql = "INSERT INTO `clientSession` (`SessionID`, `Counter`, `Tstamp`) VALUES ('$anonClientID', '0', NOW())";
	
	if (!mysqli_query($link,$sql)) {
		die('Error: ' . mysqli_error($con));
	} // Inserted
} else { // We have seen this client
    $sql = "SELECT `Counter` FROM `clientSession` WHERE `SessionID` = '$anonClientID'";
	$result = mysqli_query($link,$sql);
    if (!$result) { 
        die('Could not query:' . mysql_error()); 
    } else { // OK
        $counter = ($result->fetch_row()[0]);  // get the counter
		if ($counter >=3) // 3 login attempts
		{
			$sql = "SELECT `Tstamp` FROM `clientSession` WHERE `SessionID` = '$anonClientID'";
			$result = mysqli_query($link,$sql);
			
			if (!$result) {
			    die('Could not query:' . mysql_error());
			} else {
				// get the last login attempt time to determine if a 5 min lockout should be enforced
				$lastLoginAttemptTime = ($result->fetch_row()[0]);		
			}
			$currentTime = date('Y-m-d H:i:s');			
			$differenceInSeconds = strtotime($currentTime) - strtotime($lastLoginAttemptTime);			
			if((int)$differenceInSeconds <= 300) { // 5 minute lockout
                // Client not permitted to attempt login
                // Redirect to register view until lockout expires 
                header("location: index.php");
		        die();
			} else
			{ // Display Login
				
				//reset the counter as 3 minutes has passed.
				$sql = "UPDATE `clientSession` SET `Counter`=0, `Tstamp` = NOW() WHERE `SessionID` = '$anonClientID'";
				$result = mysqli_query($link,$sql);
				if (!$result) {
				    die('Could not query:' . mysql_error());
				} // OK
			}
		}
		// Client can proceed to attempt login
    }
}

// Initialize variables
$username = $password = "";
$username_err = $password_err = $login_err = "";
// $captcha_err = ""; // No longer using captcha!
$auth = false;

// Time
$mytime = new DateTime();
$mytime = $mytime->format('Y-m-d H:i:s');

if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check the Captcha
    // if (!isValid()) { $captcha_err = 'Captcha Error!'; }

    $myusername = strtoupper(mysqli_real_escape_string($link,$_POST['username']));
    $mypassword = mysqli_real_escape_string($link,$_POST['password']); 
    $usernameout = htmlspecialchars($myusername, ENT_QUOTES);
   
    // Validate username
    if(empty($myusername)) {
        // No username
        $username_err = "Username error - please enter a valid username.";
    } 
    // Validate password
    if(empty($mypassword)){
        // No password
        $password_err = "Password error -please enter a password.";  
    } elseif(!preg_match('/^[a-zA-Z0-9 .]+$/', $myusername) || (strlen($myusername) < 6)) {
    
        $username_err = "Username format error - please enter a valid username.";
        
    }
   
    // Check input errors 
    if(empty($username_err) && empty($password_err)){
       // Prepare an insert statement
       $sql = "SELECT username, passcode, lastLogin, attempt FROM user WHERE username = ?";
       
       if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        
        // Set parameters
        $param_username = $myusername;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Store result
            mysqli_stmt_store_result($stmt);            
            
            // Check if username exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){                    
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $myusername, $hashed_password, $llogin, $att);

                if(mysqli_stmt_fetch($stmt)){
                    $time = strtotime($llogin);
                    $curtime = time();
                    if((($curtime-$time) < 300) && ($att == 3)) {     // 5 mins
                        $login_err = "Account blocked - try again later";
                    }

                    if(empty($login_err)) { // Proceed if no login error

                        if(password_verify($mypassword, $hashed_password)) {
                            // Password is correct
                            $update = "UPDATE user SET lastLogin = ?, attempt = 0 WHERE username = ?";
                            if($stmt = mysqli_prepare($link, $update)) {
                                mysqli_stmt_bind_param($stmt, "ss", $param_lastLogin, $param_username);
                                $param_lastLogin = $mytime;
                                $param_username = $myusername;
                                if(mysqli_stmt_execute($stmt)){

                                } else {
                                    echo "Please try again later.";                             
                                }
                            }
                            // Start a new session and save the username to the session
                            session_start();
                            $_SESSION['username'] = $myusername;     
                            // Redirect to auth view 
                            header("location: welcome.php");
                        } 
                        elseif($att < 3) {
                            // Failed login - Log the attempt against the user and session

                            $user_sql = "UPDATE user SET attempt = attempt + 1 WHERE username = ?";
                            if($stmt = mysqli_prepare($link, $user_sql)) {
                                mysqli_stmt_bind_param($stmt, "s", $param_username);
                                $param_username = $myusername;
                                if(mysqli_stmt_execute($stmt)){

                                } else {
                                    echo "Please try again later.";                             
                                }
                            }
                            $session_sql = "UPDATE clientSession SET Counter = Counter + 1, Tstamp = NOW() WHERE SessionID = '$anonClientID'";
                            $result = mysqli_query($link,$session_sql);
                            if (!$result) {
                                die('Could not query:' . mysql_error());
                            } // OK
                            $username_err = 'Username ' . $usernameout . ' and password combination invalid';
                        } 
                    
                    }
                }
            } else{
                // Display an error message if username doesn't exist
                $username_err = 'No account found with username ' . $usernameout . '.';
                // Log the failed attept against the session
                $session_sql = "UPDATE clientSession SET Counter = Counter + 1, Tstamp = NOW() WHERE SessionID = '$anonClientID'";
                $result = mysqli_query($link,$session_sql);
                if (!$result) {
                    die('Could not query:' . mysql_error());
                } // OK
            }
        } else{
            echo "Please try again later.";
        }
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}

// Close connection
mysqli_close($link);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="ISO-8859-1">
    <?php include("partials/styles.php"); ?> 
    <title>Login</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row" style="margin: 1rem 0 0 0">
            <div class="col-sm-3">
                <p></p>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">Login
                        <span class="float-right">
                            <small class="form-text text-muted">
                                <a href="" data-toggle="collapse" data-target="#demo">
                                    <i class="fa fa-info" aria-hidden="true">&nbsp;</i>
                                </a>
                            </small>
                            <span>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" autocomplete="off" >
                        <small class="form-text text-muted text-center"><?php echo $login_err; ?></small>                            
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Enter username" onkeyup="validate('username');">
                                <small id="usernameAlert" class="form-text text-muted float-right"><?php echo $username_err; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter a password"
                                    onkeyup="validate('password');">
                                <small id="passwordAlert" class="form-text text-muted float-right"><?php echo $password_err; ?></small>
                            </div>
                                <br>
                                <small>
                                    <a href="index.php">New user?</a>
                                </small>
                                <button type="submit" id="submit" class="btn btn-primary btn-sm float-right" disabled="true"><i class="fa fa-sign-in" aria-hidden="true"></i> Submit</button>
                            </form>
                        </div>
                        <div class="card-footer">
                            <div id="demo" class="collapse">
                                <small class="form-text text-muted">
                                    <b>Username</b><br> Minimum length is 6. Use alpha-numeric characters only. No symbols.<br><br>
                                    <b>Password</b><br> Minimum length is 6. Must contain at least: 1 uppercase char, 1 number. No symbols.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include("partials/js.php"); ?> 
    </div>
</body>

</html>