<?php
/*
 * @Author: David Kelly 
 * @Date: 2017-11-25 13:40:24 
 * @Last Modified by: david
 * @Last Modified time: 2017-11-25 13:51:09
 */

 // Initialize variables
$mypassword = $mypassword_confirm = "";
$mypassword_err = $mypassword_confirm_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
   // password and password_confirm sent from form 
   $mypassword = mysqli_real_escape_string($link,$_POST['password']);
   $mypassword_confirm = mysqli_real_escape_string($link,$_POST['password_confirm']); 

   // Validate password
   if(empty($mypassword)){
    // No password
    $mypassword_err = "Password error - please enter a password.";  
    } elseif(strlen($mypassword) < 6) {
    // Password length error
    $mypassword_err = "Password must have atleast 6 characters.";
    }

    // Validate password_confirm
   if(empty($mypassword_confirm)){
    // No password_confirm
    $mypassword_confirm_err = "Password error - please enter a password.";  
    } elseif(strlen($mypassword) < 6) {
    // Password_confirm length error
    $mypassword_confirm_err = "Password must have atleast 6 characters.";
    }

    // Validate match
    if($mypassword != $mypassword_confirm) {
        // Passwords do not match
        $mypassword_err = "Passwords do not match";  
        $mypassword_confirm_err = "Passwords do not match";  
    }

    if(empty($mypassword_err) && empty($mypassword_confirm_err)) {
        // No errors
        $updatepw = "UPDATE user SET passcode = ? WHERE username = ?";
        if($stmt = mysqli_prepare($link, $updatepw)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_password, $param_username);

            $param_password = password_hash($mypassword, PASSWORD_DEFAULT);            
            $param_username = $myusername;

            if(mysqli_stmt_execute($stmt)){

            } else {
                echo "Oops! Something went wrong. Please try again later.";                             
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($link);    
        // Redirect to logout  
        header("location: logout.php");
    }
}

?>
<div id="demo" class="collapse<?php if($mypassword_err || $mypassword_confirm_err) {echo '.show';}?>">
    <form action="" method="post" autocomplete="off">
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter a password" onkeyup="validate('password');">
            <small id="passwordAlert" class="form-text text-muted float-right">
                <?php echo $mypassword_err; ?>
            </small>
        </div>
        <div class="form-group">
            <label for="password">Confirm Password</label>
            <input type="password" class="form-control form-control-sm" id="password_confirm" name="password_confirm" placeholder="Re-enter password"
                onkeyup="validate('password_confirm');">
            <span>
                <small id="password_confirmAlert" class="form-text text-muted float-right">
                    <?php echo $mypassword_confirm_err; ?>
                </small>
            </span>
        </div>
        <br>
        <button type="submit" id="submit" class="btn btn-primary btn-sm float-right" disabled="true">
            <i class="fa fa-sign-in" aria-hidden="true"></i> Submit</button>
    </form>
</div>
