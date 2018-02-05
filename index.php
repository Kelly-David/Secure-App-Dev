<!--
 * @Author: David Kelly 
 * @Date: 2017-11-23 15:43:44 
 * @Last Modified by:   david 
 * @Last Modified time: 2017-11-23 15:43:44 
 * @Description: User Registration. User enters username and password to create an account.
-->
<?php
require_once("config.php");
require_once("utility.php");
session_start();

// Initialize variables
$username = $password = $email = $dob = "";
$username_err = $password_err = $email_err = $dob_err = "";
$auth = false;

if($_SERVER["REQUEST_METHOD"] == "POST") {
   // username and password sent from form 
   
   $username = strtoupper(mysqli_real_escape_string($link,$_POST['username']));
   $password = mysqli_real_escape_string($link,$_POST['password']); 
   $email = mysqli_real_escape_string($link,$_POST['email']); 
   $dob = mysqli_real_escape_string($link,$_POST['dob']); 

   // Testing
   debug_to_console( $username );
   debug_to_console( $password );
   debug_to_console( $email );
   debug_to_console( $dob );

   // Validate username
   if(empty($username)) {

    $username_err = "Username error - please enter a valid username.";

    } elseif(!preg_match('/^[a-zA-Z0-9 .]+$/', $username) || (strlen($username) < 6)) {
    
        $username_err = "Username format error - please enter a valid username.";
        
    } else {

    // Prepare a select statement
    $sql = "SELECT email FROM user WHERE email = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        
        // Set parameters
        $param_email = $email;
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1){

                mysqli_stmt_bind_result($stmt, $hashed_email);

                if(mysqli_stmt_fetch($stmt)) {
                    if(password_verify($email, $hashed_email)) {
                    $username_err = "Email registered in the system. Re-enter or <a href='login.php'>login</a>."; 
                    }                       
                }
            } 
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Validate password
if(empty($password)){
    // No password
    $password_err = "Please enter a password.";  
} elseif(strlen($password) < 6) {
    // Password length error
    $password_err = "Password must have at least 6 characters.";
} elseif(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/', $password))
    // Password format error
    $password_err = "Password must be in the correct format.";
   
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err)){
       // Prepare an insert statement
       $sql = "INSERT INTO user (username, passcode, email, dob, state) VALUES (?, ?, ?, ?, ?)";
       
       if($stmt = mysqli_prepare($link, $sql)){
           // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_password, $param_email, $param_dob, $param_state );
           // Set parameters
           $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];
            $param_username = password_hash($username, PASSWORD_BCRYPT, $options);
            $param_password = password_hash($password, PASSWORD_BCRYPT, $options);
            $param_email = password_hash($email, PASSWORD_BCRYPT, $options);
            $param_dob = password_hash($dob, PASSWORD_BCRYPT, $options);
            $param_state = 1;
           
           // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt)){
               // Redirect to welcome page
               session_start();
               $_SESSION['username'] = $username;  
               header("location: welcome.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
 <?php include("partials/styles.php"); ?> 
    <title>Register</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row" style="margin: 1rem 0 0 0">
            <div class="col-sm-3">
                <p></p>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">Register
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
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Enter username" onkeyup="validate('username');">
                                <small id="usernameAlert" class="form-text text-muted float-right"><?php echo $username_err; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Enter an email">
                                <small id="emailAlert" class="form-text text-muted float-right"><?php echo $email_err; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control form-control-sm" id="dob" name="dob" placeholder="Enter dob">
                                <small id="dobAlert" class="form-text text-muted float-right"><?php echo $dob_err; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter a password"
                                    onkeyup="validate('password');">
                                <span>
                                    <small id="passwordAlert" class="form-text text-muted float-right"><?php echo $password_err; ?></small>
                                </span>
                            </div>
                            <br>
                            <small>
                                <a href="login.php">Already registered?</a>
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