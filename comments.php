<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php")?>
<?php confirmLogin(); ?>
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
    <title>Manage Comments</title>
</head>
<body>

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
      <a href="index.html" class="navbar-brand">Faiq's CMS</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index.php" class="nav-link">Home</a>
          </li>

          <li class="nav-item">
            <a href="blogs.php" target="_blank" class="nav-link">Blogs</a>
          </li>

          <li class="nav-item">
            <a href="services.php" class="nav-link">Services</a>
          </li>

          <li class="nav-item">
            <a href="about.php" target="_blank" class="nav-link">About Us</a>
          </li>

          <li class="nav-item">
            <a href="contact.php" class="nav-link">Contact Us</a>
          </li>

          <li class="nav-item">
            <a href="features.php" class="nav-link">Features</a>
          </li>
        </ul>

        <form action="blogs.php" class="navbar-form d-flex mt-2  ml-auto">
            <div class="form-group mr-2">
                <input type="text" class="form-control" placeholder="Search" name="search">
            </div>
            <div class="form-group">
                <button class="btn btn-default form-control" name="button">Go</button>
            </div>
        </form>
      </div>
    </div>
  </nav>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h2><a class="nav-link text-light" href="dashboard.php" id="brand">Dashboard</a></h2>

                <!-- Navigation -->
                <ul id="side-menu" class="nav nav-pills nav-stacked d-flex flex-column">
                    <li class="nav-item active"><a class="nav-link text-light" href="dashboard.php">
                       <i class="fab fa-dashcube"></i> Dashboard</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="addNewPost.php">
                       <i class="far fa-plus-square"></i> Add New Post</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="categories.php">
                       <i class="fas fa-tags"></i> Categories</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="admins.php">
                       <i class="fas fa-user-shield"></i> Manage Admins</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light active" href="comments.php">
                       <i class="fas fa-comment"></i> Manage Comments</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="blogs.php">
                       <i class="fas fa-rss-square"></i> Live Blog</a></li>
                    <li class="nav-item mb-2"><a class="nav-link text-light" href="logOut.php">
                       <i class="fas fa-sign-out-alt"></i> Log out</a></li>
                </ul>
            </div>

                <div class="col-sm-10">
                    <div><?php echo ErrorMessage(); 
                        echo SuccessMessage();
                    ?></div>

                    <!-- UnApproved Comments -->
                    <h1>UnApproved Comments</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approve</th>
                                <th>Delete</th>
                                <th>Details</th>
                            </tr>

                        <?php 
                            global $connection;
                            $viewQuery = "SELECT * from comments WHERE status='OFF' ORDER BY id desc";
                            $Execute = mysqli_query($connection, $viewQuery);
                            $data = mysqli_fetch_all($Execute, MYSQLI_ASSOC);
                            mysqli_free_result($Execute);
                            $SRNO = 0;

                            foreach($data as $value){
                                $CommentId = $value["id"];
                                $DateTimeOfComment = $value["datetime"];
                                $PersonName = $value["name"];
                                $PersonComment = $value["comment"];
                                $CommentedPostById = $value["admin_panel_id"];
                                $SRNO++;

                                if(strlen($PersonName) > 10){
                                    $PersonName = substr($PersonName, 0, 10). '..';
                                }

                                if(strlen($PersonComment) > 18){
                                    $PersonComment = substr($PersonComment, 0 , 18). '..';
                                }

                        ?>
                        
                        <tr>
                            <td><?php echo $SRNO; ?></td>
                            <td style="color: #5e5eff;"><?php echo $PersonName; ?></td>
                            <td><?php echo $DateTimeOfComment; ?></td>
                            <td><?php echo $PersonComment; ?></td>
                            <td><a href="approveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-success">Approve</a></td>
                            <td><a href="deleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
                            <td><a href="fullPost.php?id=<?php echo $CommentedPostById; ?>" class="btn btn-primary">Live Preview</a></td>
                        </tr>

                        <?php } ?>

                        </table>
                    </div>

                    <!-- Approved Comments -->
                    <h1>Approved Comments</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Approved By</th>
                                <th>Revert Approve</th>
                                <th>Delete</th>
                                <th>Details</th>
                            </tr>

                        <?php 
                            global $connection;
                            $Admin = 'Joji';
                            $viewQuery = "SELECT * from comments WHERE status='ON' ORDER BY id desc";
                            $Execute = mysqli_query($connection, $viewQuery);
                            $data = mysqli_fetch_all($Execute, MYSQLI_ASSOC);
                            mysqli_free_result($Execute);
                            $SRNO = 0;

                            foreach($data as $value){
                                $CommentId = $value["id"];
                                $DateTimeOfComment = $value["datetime"];
                                $PersonName = $value["name"];
                                $PersonComment = $value["comment"];
                                $approvedby = $value["approvedby"];
                                $CommentedPostById = $value["admin_panel_id"];
                                $SRNO++;

                                if(strlen($PersonName) > 10){
                                    $PersonName = substr($PersonName, 0, 10). '..';
                                }

                                if(strlen($PersonComment) > 18){
                                    $PersonComment = substr($PersonComment, 0 , 18). '..';
                                }

                        ?>
                        
                        <tr>
                            <td><?php echo htmlentities($SRNO); ?></td>
                            <td style="color: #5e5eff;"><?php echo htmlentities($PersonName); ?></td>
                            <td><?php echo htmlentities($DateTimeOfComment); ?></td>
                            <td><?php echo htmlentities($PersonComment); ?></td>
                            <td><?php echo htmlentities($approvedby); ?></td>
                            <td><a href="disapproveComments.php?id=<?php echo $CommentId; ?>" class="btn btn-warning">Disapprove</a></td>
                            <td><a href="deleteComments.php?id=<?php echo $CommentId; ?>" class="btn btn-danger">Delete</a></td>
                            <td><a href="fullPost.php?id=<?php echo $CommentedPostById; ?>" class="btn btn-primary">Live Preview</a></td>
                        </tr>

                        <?php } ?>

                        </table>
                    </div>
                    
                </div>
                
            </div>
        </div>
        <footer class="main-footer">
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