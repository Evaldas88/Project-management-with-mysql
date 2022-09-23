<?php
require_once "./Assets/db.php";

$sql = "SELECT projects.id, project_name FROM projects 
 LEFT JOIN people on project_id = People.project_id
 GROUP BY Project_Name
 ORDER BY projects.id";
$result = mysqli_query($conn, $sql);

     // update logic 
     $project_names = '';
     $update=false;  
     if (isset($_GET['action']) && $_GET['action'] == 'update') {
       $update=true;  
       $id=$_GET['id'];
       $sql  = 'SELECT project_name FROM projects WHERE  id = ' . $_GET['id'];
       $exits = mysqli_query($conn, $sql );
       if (mysqli_num_rows($exits) == 1) {
         $n = mysqli_fetch_array($exits);
         $project_names = $n['project_name'];
       }  
     }

     if ($_SERVER["REQUEST_METHOD"] == "POST") { 
       if (isset($_POST['updates'])) {
         print_r($_POST);
         $project_name = $_POST['project'] ;
           $stmt = $conn->prepare ("UPDATE projects SET project_name ='" . $project_name . "' WHERE id = " . $id . "");
           $stmt->execute();
           $stmt->close();
           unset($_POST['project_name']);
         header('location: projects.php');  
         exit;
       } else {
     // create new projects logic
         $projects =  $_POST['project'] ;
         $check = "SELECT * from projects WHERE project_name = '" . $projects . "'";
         $exits = mysqli_query($conn, $check);
         if (mysqli_num_rows($exits) < 1) {
           $stmt = $conn->prepare("INSERT INTO projects (project_name) VALUES (?)");
           $stmt->bind_param("s", $projects);
           $stmt->execute();
           $stmt->close();
           header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
           die;
         }
       }
     }
     require_once "./Assets/delete.php";

 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <title>Projects</title>
  <style>
    <?php include('./Assets/style.css') ?>
  </style>
</head>

<body>
<?php require_once "./Assets/navbar.php"; ?>
  <div class="container pt-1">
    <table class="table  table-bordered mt-5 text-center">
      <thead>
        <tr class="bg-dark  p-2 text-white bg-opacity-75">
          <th class="w-25">ID</th>
          <th class="w-25">Project Name</th>
          <th class="w-25">Actions </th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            print '<tr>'
              . '<td>' . $row['id'] . '</td>'
              . '<td>' . $row['project_name'] . '</td>'
              . '<td>'
              . '<a href="?action=update&id='  . $row['id'] . '"><button class="btn btn-info me-1"><i class="bi bi-pen"></i></button></a>'
              . '<a href="?action=del&id='  . $row['id'] . '"><button class="btn btn-danger  "><i class="bi bi-trash3-fill"></i></button></a>'
              . '</td>'
              . '</tr>';
          }
        }
        ?>
      </tbody>
    </table>
    <div class="mb-5">
      <form class=" " action="" method="POST">
        <input type="hidden" name="id" value="<?php print $id; ?>">
        <input type="text" name="project" required placeholder=" Project name" value="<?php print $project_names; ?>">
        <div class=" mt-3">
          <?php if ($update == true) : ?>
            <button class="btn btn-info  "  name="updates">Update</button>
          <?php else : ?>
            <button class="btn btn-secondary"><i class="bi bi-box-arrow-in-right me-1"></i>Enter</button>
          <?php endif ?>
         </div>
    </div>
  </div>
</body>

</html>