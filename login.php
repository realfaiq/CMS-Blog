<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php") ?>
<?php
    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($connection,$_POST['username']);
        $password = mysqli_real_escape_string($connection,$_POST['password']);
        
        //Checking for Empty Submission
        if(empty($username) || empty($password)){
            $_SESSION["ErrorMessage"] = "All Fields must be Filled";
            redirectTo("login.php");
        }
        else{
            $foundAccount = loginAttempt($username, $password);
            $_SESSION["Id"] = $foundAccount["id"];
            $_SESSION["Username"] = $foundAccount["username"];
            if($foundAccount){
                $_SESSION["SuccessMessage"] = "Welcome {$_SESSION["Username"]}";
                redirectTo("dashboard.php");
            }
            else{
                $_SESSION["ErrorMessage"] = "Invalid Username Or Password";
                redirectTo("login.php");
            }
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/adminstyle.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
    <title>Login</title>
    <style>
        body{
            background: #ffffff;
        }

    </style>
</head>
<body>


        <!-- Navbar -->
        <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
      <a href="index.html" class="navbar-brand">Faiq's CMS</a>
      </div>
    </div>
  </nav>
    
    <div class="container-fluid">
        <div class="row">

            <div class="offset-sm-4 col-sm-4 mt-5" id="form">
            <div><?php echo ErrorMessage();
                        echo SuccessMessage();
                    ?></div>
               <form action="login.php" method="post" class="mt-4">
                   <h2 class="mb-4">Login</h2>
                   
                   <fieldset>
                       <div class="form-group mb-4">
                           <div class="input-group input-group-lg">
                               <div class="input-group-prepend">
                                   <span class="input-group-text"><i class="fas fa-user"></i></span>
                               </div>
                                <label for="username"><span class="field-info"></span></label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                           </div>
                       </div>

                       <div class="form-group mb-4">
                           <div class="input-group input-group-lg">
                               <div class="input-group-prepend">
                                   <span class="input-group-text"><i class="fas fa-unlock"></i></span>
                               </div>
                                <label for="password"><span class="field-info"></span></label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                           </div>
                       </div>
                       <input type="submit" value="Login" name="submit" class="btn btn-primary btn-block mb-2">
                   </fieldset>
               </form>

            

            </div>
        </div>
        <footer class="fixed-bottom">
            <div class="row">
                <div class="col" id="dark">
                    <div class="nav-dark text-light py-3">
                        <p class="container text-center">Theme By Faiq Ahmad | Copyright &copy; 2021 | All Rights Reserved</p>
                        <p class="text-center">This site is for Study Purpose Only It may Contain Bugs So Use the Source Code at Your Own Risk</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
   
    <!-- JS -->
    <script src="js/jquery.min.js"></script>    
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>