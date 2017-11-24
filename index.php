<!--
 * @Author: David Kelly 
 * @Date: 2017-11-23 15:43:44 
 * @Last Modified by:   david 
 * @Last Modified time: 2017-11-23 15:43:44 
-->
<?php
include("config.php");
include("utility.php");
session_start();


if($_SERVER["REQUEST_METHOD"] == "POST") {
   // username and password sent from form 
   
   $myusername = mysqli_real_escape_string($link,$_POST['username']);
   $mypassword = mysqli_real_escape_string($link,$_POST['password']); 

   debug_to_console( $myusername );
   debug_to_console( $mypassword );
   

   if($myusername && $mypassword) {
       // Prepare an insert statement
       $sql = "INSERT INTO user (username, passcode, state) VALUES (?, ?, ?)";
       
       if($stmt = mysqli_prepare($link, $sql)){
           // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_state );
           // Set parameters
           $param_username = $myusername;
           $param_password = $mypassword;
           $param_state = 1;
           
           // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt)){
           // Redirect to login page
           header("location: index.php");
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
    <meta charset="ISO-8859-1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Secure App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="register.html">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.html">Login</a>
                </li>
            </ul>

        </div>
    </nav>
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
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Enter username" onkeyup="validate('username');">
                                <small id="usernameAlert" class="form-text text-muted float-right"></small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter a password"
                                    onkeyup="validate('password');">
                                <span>
                                    <small id="passwordAlert" class="form-text text-muted float-right"></small>
                                </span>
                            </div>
                            <br>
                            <small>
                                <a href="login.html">Already registered?</a>
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