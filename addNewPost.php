<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php") ?>
<?php confirmLogin(); ?>
<?php
    if(isset($_POST['submit'])){
        $title = mysqli_real_escape_string($connection,$_POST['title']);
        $category = mysqli_real_escape_string($connection,$_POST['Category']);
        $Post = mysqli_real_escape_string($connection,$_POST['Post']);
        
        //Getting Time
        date_default_timezone_set("Asia/Karachi");
        $currentTime = time();
        // $DateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
        $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
        $Image = $_FILES["Image"]["name"];
        $Target = "Upload/".basename($_FILES["Image"]["name"]);
        $Admin = $_SESSION["Username"];

        //Checking for Empty Submission
        if(empty($title)){
            $_SESSION["ErrorMessage"] = "Title Cannot be Empty";
            redirectTo("addNewPost.php");
        }
        else if(strlen($title)<2){
            $_SESSION["ErrorMessage"] = "Title Should be at least 2 characters";
            redirectTo("addNewPost.php");
        }
        else{
            global $connecting;
            $query = "INSERT INTO admin_panel(datetime,title,category,author,image,post)
            VALUES('$DateTime','$title','$category', '$Admin', '$Image', '$Post')";
            $execute = mysqli_query($connection,$query);
            move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
            if($execute){
                $_SESSION["SuccessMessage"] = "Post Added Successfully";
                redirectTo("addNewPost.php");
            }
            else{
                $_SESSION["ErrorMessage"] = "Something went wrong! Try Again";
                redirectTo("addNewPost.php");
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
    <title>Admin Panel</title>
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
                    <li class="nav-item mb-2"><a class="nav-link text-light active" href="addNewPost.php">
                       <i class="far fa-plus-square"></i> Add New Post</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="categories.php">
                       <i class="fas fa-tags"></i> Categories</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="#">
                       <i class="fas fa-user-shield"></i> Manage Admins</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="comments.php">
                       <i class="fas fa-comment"></i> Manage Comments</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="#">
                       <i class="fas fa-rss-square"></i> Live Blog</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="#">
                       <i class="fas fa-sign-out-alt"></i> Log out</a></li>
                </ul>
            </div>

            <div class="col-sm-10">
               <form action="addNewPost.php" method="post" enctype="multipart/form-data">
                   <h1>Add New Post</h1>
                   <div><?php echo ErrorMessage();
                        echo SuccessMessage();
                    ?></div>
                   <fieldset>
                       <div class="form-group">
                           <label for="title">Title</label>
                           <input type="text" class="form-control" name="title" id="Title" placeholder="Title">
                       </div>

                       <div class="form-group">
                           <label for="categorySelect">Select Category</label>
                           <select name="Category" id="categorySelect" class="form-control">
                           <?php
                            global $connection;
                            $viewQuery = "SELECT * from category ORDER BY datetime desc";
                            $Execute = mysqli_query($connection, $viewQuery);
                            $data = mysqli_fetch_all($Execute, MYSQLI_ASSOC);
                            mysqli_free_result($Execute);
                  
                            foreach($data as $value){
                                $id = $value['id'];
                                $Category = $value['name']; 
                            ?>

                            <option><?php echo $Category; ?></option>
                            <?php } ?>
                           </select>
                       </div>
                      
                       <div class="form-group">
                           <label for="image">Select Image</label>
                           <input type="file" class="form-control" name="Image" id="image">
                       </div>

                       <div class="form-group">
                           <label for="post">Post Area</label>
                           <textarea name="Post" id="postarea" class="form-control"></textarea>
                       </div>

                       <input type="submit" value="Add new Post" name="submit" class="btn btn-success btn-block mb-2">
                   </fieldset>
               </form>

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