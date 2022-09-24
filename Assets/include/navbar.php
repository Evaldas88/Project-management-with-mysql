<?php
// function for active navrbar
function active($currect_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);  
  if($currect_page == $url){
      echo 'active'; //class name in css 
  } 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <nav class="navbar navbar-expand-lg bg-secondary py-1 mb-3   ">
    <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
            <img src="./Assets/images/logo.png" class="me-2" height="30"   alt="Logo" loading="lazy" /></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link  text-light <?php active('index.php');?>" aria-current="page" href="index.php">Project view</a>
                 </li>
                <li class="nav-item">
                    <a class="nav-link text-light <?php active('projects.php');?>"   aria-current="page" href="projects.php" >Projects edit</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light <?php active('people.php');?>"  aria-current="page" href="people.php">People edit</a>
                </li>
            </ul>
        </div>
    </div>
    </nav>
</body>
</html>

 