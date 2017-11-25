<?php
/*
 * @Author: David Kelly 
 * @Date: 2017-11-25 11:50:26 
 * @Last Modified by: david
 * @Last Modified time: 2017-11-25 13:47:42
 */
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
    $auth = true;
}
?>
 <!DOCTYPE html>
 <html>
 
 <head>
     <meta charset="ISO-8859-1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb"
         crossorigin="anonymous">
     <link rel="stylesheet" href="style.css">
     <title>Users</title>
 </head>
 
 <body>
     <div class="container-fluid">
         <div class="row" style="margin: 1rem 0 0 0">
             <div class="col-sm-3">
                 <p></p>
             </div>
             <div class="col-sm-6">
                 <div class="card">
                     <div class="card-header">
                         Users
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
                            <?php
                                // Attempt select query execution with order by clause
                                $sql = "SELECT id, username FROM user ORDER BY username";
                                $count = 1;
                                if($result = mysqli_query($link, $sql)){
                                    if(mysqli_num_rows($result) > 0){
                                        echo "<table class='table'>";
                                            echo "<thead>";
                                            echo "<tr>";
                                                echo "<th>#</th>";
                                                echo "<th>Username</th>";
                                            echo "</tr>";
                                            echo "</thead>";
                                        while($row = mysqli_fetch_array($result)){
                                            echo "<tbody>";
                                            echo "<tr>";
                                                echo "<td>" . $count. "</td>";
                                                echo "<td>" . $row['username'] . "</td>";
                                            echo "</tr>";
                                            echo "</tbody>";
                                            $count+=1;
                                        }
                                        echo "</table>";
                                        // Close result set
                                        mysqli_free_result($result);
                                    } else{
                                        echo "No records matching your query were found.";
                                    }
                                } else{
                                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                                }
                            ?>
                     </div>
                     <div class="card-footer">
                         <?php include("reset.php"); ?>
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
