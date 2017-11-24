<!--
 * @Author: David Kelly 
 * @Date: 2017-11-24 20:41:01 
 * @Last Modified by:   david 
 * @Last Modified time: 2017-11-24 20:41:01 
 */-->
 <?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
} else {
    $myusername = $_SESSION['username'];
}
?>

 <!DOCTYPE html>
 <html>
 
 <head>
     <meta charset="ISO-8859-1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
         crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
     <title>Welcome</title>
 </head>
 
 <body>
     <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <a class="navbar-brand" href="#">SecureApp</a>
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
                     <div class="card-header">Welcome
                         <span class="float-right">
                             <small class="form-text text-muted">
                                 <a href="" data-toggle="collapse" data-target="#demo"><i class="fa fa-key" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                 <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                             </small>
                             <span>
                     </div>
                     <div class="card-body">
                         <span class="text-info"><?php echo $myusername; ?></span><br>
                         <small class="text-muted">Welcome to the app!</small>
                     </div>
                     <div class="card-footer">
                         <div id="demo" class="collapse">
                                <form action="" method="post" autocomplete="off" >
                                        <div class="form-group">
                                            <label for="currentpw">Current Password</label>
                                            <input type="text" class="form-control form-control-sm" id="currentpw" name="currentpw" placeholder="Enter current password" onkeyup="validate('currentpw');">
                                            <small id="currentpwAlert" class="form-text text-muted float-right"></small>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter a new password"
                                                onkeyup="validate('password');">
                                            <span>
                                                <small id="passwordAlert" class="form-text text-muted float-right"></small>
                                            </span>
                                        </div>
                                        <button type="submit" id="submit" class="btn btn-primary btn-sm float-right" disabled="true"><i class="fa fa-sign-in" aria-hidden="true"></i> Submit</button>
                                    </form>
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