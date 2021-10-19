<?php require_once ("Include/db.php") ?>
<?php require_once ("Include/sessions.php") ?>
<?php require_once ("Include/functions.php") ?>
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
    <title>Blogs</title>
    <style>
        /* body{
            overflow-x: hidden;
        } */
      
      #heading{
        font-family: Bitter,Georgia, 'Times New Roman', Times, serif;
        font-weight: bold;
        color: #005390;
      }

      #heading:hover{
        color: #0090DB;
      }

    </style>
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
            <a href="index.php" class="nav-link">Home</a>
          </li>

          <li class="nav-item">
            <a href="blogs.php" class="nav-link active">Blogs</a>
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
  
  <!-- Main Content -->
  <div id="main-content" class="mt-5">
        <div class="container">
            <div class="blog-header">
                <h1>The Complete Responsive Blog CMS</h1>
                <p class="lead">The Complete Blog Site Using PHP by Faiq Ahmad</p>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <?php 
                        global $connection;
                        if(isset($_GET["button"])){
                          $search = $_GET["search"];
                          $viewQuery = "SELECT * FROM admin_panel WHERE
                          datetime LIKE '%$search%' OR title LIKE '%$search%' 
                          OR category LIKE '%$search%' OR post LIKE '%$search%' ORDER BY id desc";
                        }

                        elseif(isset($_GET["Category"])){
                          $Category = $_GET["Category"];
                          $viewQuery = "SELECT * FROM admin_panel WHERE category='$Category' ORDER BY id desc";
                        }

                        elseif(isset($_GET["Page"])){
                          //blogs.php?page=1or2
                          $page = ($_GET["Page"]);
                          if($page==0 || $page<1){
                            $showPostFrom = 0;
                          }
                          else{
                            $showPostFrom = ($page * 5)-5;
                            
                          }
                          $viewQuery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT $showPostFrom,5";
                         
                        }
                        else{
                          $viewQuery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,3";
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
                            Published On <?php echo htmlentities($Datetime); ?>
                          
                            <?php 
                                    $connection;
                                    $query = "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$id' AND status='ON'";
                                    $Execute = mysqli_query($connection, $query);
                                    $data = mysqli_fetch_array($Execute);
                                    $totalApproved = array_shift($data);
                                    if($totalApproved > 0){
                                ?>
                                        <span class="badge float-right badge-success">
                                            <?php echo 'Comments: '. $totalApproved; ?>
                                        </span>
                                    <?php } ?>
                          
                          </p>
                            <div class="caption">
                              <p class="post"><?php 
                                if(strlen($post)>150){
                                  $post = substr($post,0,150). '...';
                                }
                                echo htmlentities($post);
                              ?></p>
                            </div>
                                <a href="fullPost.php?id=<?php echo $id ?>"><span class="btn btn-info">
                                  Read More &rsaquo;&rsaquo;
                                </span></a>
                        </div>
                    <?php } ?>
                              
                    <nav>
                      <ul class="pagination pull-left">
                        <?php
                        if(isset($page)){
                          if($page > 1){
                            ?>
                            <li class="page-item">
                              <a href="blogs.php?Page=<?php echo $page-1; ?>" class="page-link">&laquo;</a>
                            </li>
                          <?php } ?>
                      <?php } ?>

                    <?php
                    
                      global $connection;
                      $queryPagination = "SELECT COUNT(*) from admin_panel";
                      $execute = mysqli_query($connection, $queryPagination); 
                      $data = mysqli_fetch_array($execute);
                      $totalPost = array_shift($data);
                      $postPerpage = $totalPost/5;
                      $postPerpage = ceil($postPerpage);
                      // echo $postPerpage;
                      for($i = 1; $i<=$postPerpage; $i++){
                        if(isset($page)){
                          if($i == $page){
                          ?>
                            <li class="active page-item"><a class="page-link" href="blogs.php?Page<?php echo $i; ?>"><?php echo $i; ?></a></li>
                          <?php } 
                          else{ ?>
                            <li class="page-item"><a class="page-link" href="blogs.php?Page<?php echo $i; ?>"><?php echo $i; ?></a></li>
                          <?php }
                          }
                          ?>
                          <?php } ?> 
                          <?php
                        if(isset($page)){
                          if($page+1 <= $postPerpage){
                            ?>
                            <li class="page-item">
                              <a href="blogs.php?Page=<?php echo $page+1; ?>" class="page-link">&raquo;</a>
                            </li>
                          <?php } ?>
                        <?php } ?> 
                              </ul>  
                          </nav>               
                      
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
                      <div class="card-body">
                        <?php
                          global $connection;
                          $viewQuery = "SELECT * FROM admin_panel ORDER BY id desc LIMIT 0,5";
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