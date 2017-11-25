<!--
 * @Author: David Kelly 
 * @Date: 2017-11-23 15:43:44 
 * @Last Modified by:   david 
 * @Last Modified time: 2017-11-23 15:43:44 
-->
<?php
require_once("config.php");
require_once("utility.php");
session_start();

// Initialize variables
$username = $password = "";
$username_err = $password_err = $login_err = "";
$auth = false;

// Time
date_default_timezone_set("Europe/Dublin");
$mytime = new DateTime();
$mytime = $mytime->format('Y-m-d H:i:s');

if($_SERVER["REQUEST_METHOD"] == "POST") {
   // username and password sent from form 
   
   $myusername = strtoupper(mysqli_real_escape_string($link,$_POST['username']));
   $mypassword = mysqli_real_escape_string($link,$_POST['password']); 

   debug_to_console( $myusername );
   debug_to_console( $mypassword );
   
    // Validate username
    if(empty($myusername)) {
        // No username
        $username_err = "Username error - please enter a valid username.";
    } 
    // Validate password
    if(empty($mypassword)){
        // No password
        $password_err = "Password error -please enter a password.";  
    } elseif(strlen($mypassword) < 6) {
        // Password length error
        $password_err = "Password must have atleast 6 characters.";
    }
   
    // Check input errors before inserting in database
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
                    
                    if((password_verify($mypassword, $hashed_password)) && (empty($login_err))) {
                        // Password is correct
                        $update = "UPDATE user SET lastLogin = ?, attempt = 0 WHERE username = ?";
                        if($stmt = mysqli_prepare($link, $update)) {
                            mysqli_stmt_bind_param($stmt, "ss", $param_lastLogin, $param_username);
                            $param_lastLogin = $mytime;
                            $param_username = $myusername;
                            if(mysqli_stmt_execute($stmt)){

                            } else {
                                echo "Oops! Something went wrong. Please try again later.";                             
                            }
                        }
                        // Start a new session and save the username to the session
                        session_start();
                        $_SESSION['username'] = $myusername;     
                        // Redirect to auth view 
                        header("location: welcome.php");
                    } elseif($att < 3) {
                        // Failed login - Log the attempt
                        $attempt_sql = "UPDATE user SET attempt = attempt + 1 WHERE username = ?";
                        if($stmt = mysqli_prepare($link, $attempt_sql)) {
                            mysqli_stmt_bind_param($stmt, "s", $param_username);
                            $param_username = $myusername;
                            if(mysqli_stmt_execute($stmt)){

                            } else {
                                echo "Oops! Something went wrong. Please try again later.";                             
                            }
                        }
                        // Display an error message if password is not valid
                        $password_err = 'The password you entered was not valid.';
                    } else {
                        // Account is blocked
                    }
                }
            } else{
                // Display an error message if username doesn't exist
                $username_err = 'No account found with username ' . $myusername . '.';
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
                        <small class="form-text text-muted"><?php echo $login_err; ?></small>                            
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
                            <small class="form-text text-muted">Minimum length is 6. Use alpha-numeric characters only. No symbols, punctuation or whitespace.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/6e3dca925a.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
        <script src="validate.js"></script>
    </div>
</body>

</html>