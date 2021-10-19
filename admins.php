<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php") ?>
<?php confirmLogin(); ?>
<?php
    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($connection,$_POST['username']);
        $password = mysqli_real_escape_string($connection,$_POST['password']);
        $confirmPassword = mysqli_real_escape_string($connection,$_POST['confirmPassword']);
        
        //Getting Time
        date_default_timezone_set("Asia/Karachi");
        $currentTime = time();
        // $DateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
        $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
        $Admin = $_SESSION["Username"];

        //Checking for Empty Submission
        if(empty($username) || empty($password) || empty($confirmPassword)){
            $_SESSION["ErrorMessage"] = "All Fields must be Filled";
            redirectTo("admins.php");
        }
        else if(strlen($password)<4){
            $_SESSION["ErrorMessage"] = "Password must be atleast 4 characters";
            redirectTo("admins.php");
        }
        else if($password !== $confirmPassword){
            $_SESSION["ErrorMessage"] = "Password does not matches confirm Password";
            redirectTo("admins.php");
        }
        else{
            global $connecting;
            $query = "INSERT INTO registration(datetime,username,password,addedby)
            VALUES('$DateTime','$username','$password', '$Admin')";
            $execute = mysqli_query($connection,$query);
            if($execute){
                $_SESSION["SuccessMessage"] = "Admin Added Successfully";
                redirectTo("admins.php");
            }
            else{
                $_SESSION["ErrorMessage"] = "Something went wrong";
                redirectTo("admins.php");
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
    <title>Manage Admins</title>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h2><a class="nav-link text-light" href="dashboard.php" id="brand">CMS</a></h2>

                <!-- Navigation -->
                <ul id="side-menu" class="nav nav-pills nav-stacked d-flex flex-column">
                    <li class="nav-item"><a class="nav-link text-light" href="dashboard.php">
                       <i class="fab fa-dashcube"></i> Dashboard</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="addNewPost.php">
                       <i class="far fa-plus-square"></i> Add New Post</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="categories.php">
                       <i class="fas fa-tags"></i> Categories</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light active" href="admins.php">
                       <i class="fas fa-user-shield"></i> Manage Admins</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="comments.php">
                       <i class="fas fa-comment"></i> Manage Comments</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="blogs.php">
                       <i class="fas fa-rss-square"></i> Live Blog</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="logOut.php">
                       <i class="fas fa-sign-out-alt"></i> Log out</a></li>
                </ul>
            </div>

            <div class="col-sm-10">
               <form action="admins.php" method="post">
                   <h1>Manage Admin Access</h1>
                   <div><?php echo ErrorMessage();
                        echo SuccessMessage();
                    ?></div>
                   <fieldset>
                       <div class="form-group">
                           <label for="username"><span class="field-info">Username</span></label>
                           <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                       </div>

                       <div class="form-group">
                           <label for="password"><span class="field-info">Password</span></label>
                           <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                       </div>

                       <div class="form-group">
                           <label for="confirmPassword"><span class="field-info">Confirm Password</span></label>
                           <input type="password" class="form-control" name="confirmPassword" id="password" placeholder="Retype the Password">
                       </div>
                       <input type="submit" value="Add new Admin" name="submit" class="btn btn-success btn-block mb-2">
                   </fieldset>
               </form>

               <!-- Extracting the data and displaying in tables -->
               <div class="table-responsive">
                   <table class="table table-striped table-hover">
                       <tr>
                            <th>S.No</th>
                            <th>Date and Time</th>
                            <th>UserName</th>
                            <th>Addedby</th>
                            <th>Action</th>
                       </tr>

                        <?php
                            global $connection;
                            $viewQuery = "SELECT * from registration ORDER BY id desc";
                            $Execute = mysqli_query($connection, $viewQuery);
                            $data = mysqli_fetch_all($Execute, MYSQLI_ASSOC);
                            mysqli_free_result($Execute);
                            $SRNO = 0;
                            foreach($data as $value){
                                $id = $value['id'];
                                $datetime = $value['datetime'];
                                $name = $value['username'];
                                $Creator = $value['addedby']; 
                                $SRNO++;

                        ?>

                        <tr>
                            <td><?php echo $SRNO; ?></td>
                            <td><?php echo $datetime; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $Creator; ?></td>
                            <td><a href="deleteAdmin.php?id=<?php echo $id; ?>"><span class="btn btn-danger">
                                Delete Admin
                            </span></a></td>
                        </tr>
                        <?php } ?>
                   </table>
               </div>

            </div>
        </div>
        <footer>
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