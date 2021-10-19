<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php") ?>
<?php 
  if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($connection,$_POST['name']);
    $email = mysqli_real_escape_string($connection,$_POST['email']);
    $comment = mysqli_real_escape_string($connection,($_POST['comment']));

    //Getting Time
    date_default_timezone_set("Asia/Karachi");
    $currentTime = time();
    // $DateTime = strftime("%Y-%m-%d %H:%M:%S", $currentTime);
    $DateTime = strftime("%B-%d-%Y %H:%M:%S", $currentTime);
    $postId = $_GET['id'];

    //Checking for Empty Submission
    if(empty($name) || empty($email) || empty($comment)){
      $_SESSION["ErrorMessage"] = "All fields are required";
      redirectTo("fullPost.php?id={$postId}");
  }
    else if(strlen($comment)>500){
        $_SESSION["ErrorMessage"] = "Comment Should Only have 500 characters or less";
        redirectTo("fullPost.php?id={$postId}");
    }
    else{
      global $connecting;
      $postIdFromURL = $_GET["id"];
      $query = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,admin_panel_id)
      VALUES('$DateTime','$name','$email','$comment','Pending','OFF', '$postIdFromURL')";
      $execute = mysqli_query($connection,$query);
      if($execute){
          $_SESSION["SuccessMessage"] = "Comment Added Successfully";
          redirectTo("fullPost.php?id={$postId}");
      }
      else{
          $_SESSION["ErrorMessage"] = "Something went wrong! Try Again";
          redirectTo("fullPost.php?id={$postId}");
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
    <link rel="stylesheet" href="css/publicstyle.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
    <title>Full Post</title>
</head>
<body>

    <!-- Navbar -->
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
      <a href="index.html" class="navbar-brand">Faiq's CMS</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="index.html" class="nav-link">Home</a>
          </li>

          <li class="nav-item">
            <a href="about.html" class="nav-link active">Blogs</a>
          </li>

          <li class="nav-item">
            <a href="services.html" class="nav-link">About Us</a>
          </li>

          <li class="nav-item">
            <a href="blog.html" class="nav-link">Services</a>
          </li>

          <li class="nav-item">
            <a href="contact.html" class="nav-link">Contact Us</a>
          </li>

          <li class="nav-item">
            <a href="contact.html" class="nav-link">Features</a>
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
  
  <!-- Main Content -->
  <div id="main-content" class="mt-5">
        <div class="container">
            <div class="blog-header">
                <h1>The Complete Responsive Blog CMS</h1>
                <p class="lead">The Complete Blog Site Using PHP by Faiq Ahmad</p>
                <?php 
                  echo ErrorMessage();
                  echo SuccessMessage();
                ?>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <?php 
                        global $connection;
                        if(isset($_GET["button"])){
                          $search = $_GET["search"];
                          $viewQuery = "SELECT * FROM admin_panel WHERE
                          datetime LIKE '%$search%' OR title LIKE '%$search%' 
                          OR category LIKE '%$search%' OR post LIKE '%$search%'";
                        }
                        else{
                            $postIdFromURL = $_GET["id"];
                          $viewQuery = "SELECT * FROM admin_panel WHERE id='$postIdFromURL' 
                          ORDER BY datetime desc";
                        }
                        $Execute = mysqli_query($connection, $viewQuery);
                        $data = mysqli_fetch_all($Execute, MYSQLI_ASSOC);
                        mysqli_free_result($Execute);

                        foreach($data as $value){
                            $id=$value["id"];
                            $Datetime=$value["datetime"];
                            $title=$value["title"];
                            $category=$value["category"];
                            $author=$value["author"];
                            $Image=$value["image"];
                            $post=$value["post"];
                        
                    ?>
                        <div class="box mb-4 d-flex flex-column w-100 h-auto">
                            <img src="Upload/<?php echo $Image; ?>" alt="">
                            <h3 id="heading">Title: <?php echo htmlentities($title); ?></h3>
                            <p class="description">Category: <?php echo htmlentities($category); ?>
                            Published On <?php echo htmlentities($Datetime); ?></p>
                            <div class="caption">
                              <p class="post"><?php echo nl2br($post); ?></p>
                            </div>
                        </div>


                    <?php } ?>
                    <h3>Comments</h3>
                    <?php 
                      $connection;
                      $PostIdForComments = $_GET["id"];
                      $query = "SELECT * FROM comments WHERE admin_panel_id='$PostIdForComments' AND status='ON'";
                      $Execute = mysqli_query($connection, $query);
                      $data = mysqli_fetch_all($Execute, MYSQLI_ASSOC);
                      mysqli_free_result($Execute);
                      

                      foreach($data as $value){
                        $CommentDate = $value["datetime"];
                        $CommenterName = $value["name"];
                        $Comment = $value["comment"];
                     

                    ?>

                    <div class="d-flex comment-block mb-2">
                      <div class="mr-2">
                        <img class="" src="images/Person.png" width="100px" height="100px">
                      </div>
                      <div>
                        <p class="comment-info"><?php echo $CommenterName; ?></p>
                        <p class="description"><?php echo $CommentDate; ?></p>
                        <p><?php echo nl2br($Comment); ?></p>
                      </div>
                    </div>


                    <?php } ?>
                    <br>
                    <hr>


                    <h1>Share Your thoughts about the Post</h1>
                    <div>
                    
                      <form action="fullPost.php?id=<?php echo $postIdFromURL; ?>" method="post" enctype="multipart/form-data">
                          <fieldset>
                            <div class="from-group">
                              <label for="Name">Name</label>
                              <input type="text" name="name" placeholder="Name" class="form-control">
                            </div>

                            <div class="form-group">
                              <label for="email">Email</label>
                              <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                              <label for="comment">Comment</label>
                              <textarea name="comment" placeholder="Comments" class="form-control"></textarea>
                            </div>
                            <input type="submit" name="submit" value="Submit" class="btn btn-success btn-block mb-2">
                          </fieldset>
                      </form>
                    </div>
                </div>        
                
                <div class="col-sm-3 offset-sm-1">
                <h2>About Me</h2>
                    <img src="images/150816221_2857611001164332_6163092573375868284_n.jpg" alt="" class="img-fluid img-responsive rounded-circle">
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque repudiandae molestiae, quo delectus dolores odio similique odit corrupti labore vel perferendis nobis aspernatur, recusandae quam velit assumenda minus doloribus enim.</p>
                    <div class="card text-center">
                      <div class="card-header bg-primary text-white">
                        <h3>Categories</h3>
                      </div>
                      <div class="card-body">
                        <?php 
                          global $connection;
                          $viewQuery = "SELECT * FROM category ORDER BY datetime desc";
                          $execute = mysqli_query($connection, $viewQuery);
                          while($data = mysqli_fetch_array($execute)){
                            $id = $data["id"];
                            $category = $data["name"];
                          
                        ?>
                        <a href="blogs.php?Category=<?php echo $category ?>">
                        <span id="heading"><?php echo $category. "<br>"; ?></span>
                        </a>
                        <?php } ?>
                      </div>
                      <div class="card-footer">

                      </div>
                    </div>

                    <div class="card  mt-4">
                      <div class="card-header bg-primary text-white text-center">
                        <h3>Recent Posts</h3>
                      </div>
                      <div class="card-body" id="background">
                        <?php
                          global $connection;
                          $viewQuery = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5";
                          $execute = mysqli_query($connection, $viewQuery);
                          while($data=mysqli_fetch_array($execute)){
                            $id = $data["id"];
                            $title = $data["title"];
                            $Datetime = $data["datetime"];
                            $image = $data["image"];
                            if(strlen($Datetime) > 11){
                              $Datetime = substr($Datetime,0,10). '..';
                            }
                        
                        ?>
                        <div class="d-flex">
                          <div class="mr-2">
                            <img src="Upload/<?php echo htmlentities($image); ?>" alt="" width="70px" height="70px">
                          </div>
                          <div>
                            <a href="fullpost.php?id=<?php echo $id; ?>">
                              <p id="heading"><?php echo htmlentities($title); ?></p>
                            </a>
                            <p class="description"><?php echo htmlentities($Datetime); ?></p>
                            <hr>
                          </div>
                        </div>
                        <?php } ?>
                      </div>
                      <div class="card-footer">
                        
                      </div>
                    </div>
                </div>
            </div>
        </div>
                </div>
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
    
    <script src="js/jquery.min.js"></script>    
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>