<!--
 * @Author: David Kelly 
 * @Date: 2017-11-24 20:41:01 
 * @Last Modified by:   david 
 * @Last Modified time: 2017-11-24 20:41:01 
 */-->
<?php
require_once("config.php");
require_once("utility.php");
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
} else {
    $myusername = $_SESSION['username'];
    $usernameout = htmlspecialchars($myusername, ENT_QUOTES);
    $auth = true;
}
?>

 <!DOCTYPE html>
 <html>
 
 <head>
    <?php include("partials/styles.php"); ?> 
    <title>Welcome</title>
 </head>
 
 <body>
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
                                 <a href="welcome.php"><i class="fa fa-home" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                 <a href="users.php"><i class="fa fa-users" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                 <a href="" data-toggle="collapse" data-target="#demo"><i class="fa fa-key" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                 <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                             </small>
                             <span>
                     </div>
                     <div class="card-body">
                         <span class="text-info"><?php echo $usernameout; ?></span><br>
                         <small class="text-muted">Welcome to the app!</small>
                     </div>
                     <div class="card-footer">
                         <?php include("reset.php"); ?>
                     </div>
                 </div>
             </div>
         </div>
         <?php include("partials/js.php"); ?> 
     </div>
 </body>
 
 </html>