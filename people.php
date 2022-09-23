<?php
require_once "./Assets/db.php";
require_once "./Assets/delete.php";

$sql = "SELECT  People.id, People.project_id, CONCAT(first_name, ' ', last_name) AS Full_Name FROM People ";
$result = mysqli_query($conn, $sql);
// create people logic 
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $input_name = trim($_POST["firstname"]);
  $input_lastname = trim($_POST["lastname"]);
  $project = trim($_POST['create']);
  if (empty($input_name) or empty($input_lastname)) {
    $error = "Please make sure all fields are filled   correctly!";
  } elseif(empty($project)){
    $error = "First create project!";
  }
  else {
    $stmt = $conn->prepare("INSERT INTO People (first_name, last_name, project_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $first_name, $last_name, $project_id);
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $project_id = $_POST['project'];
    $stmt->execute();
    $stmt->close();
    header('Location: ' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
    die;
  }
}

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
          <th class="w-25">Full Name</th>
          <th class="w-25">Project Name</th>
          <th class="w-25">Actions </th>
        </tr>
      </thead>
      <tbody>
        <?php
        // forming table from database
        $sql = 'SELECT people.id, concat(" ", people.first_name, " ", people.last_name) AS  fullname,   projects.project_name
        FROM people
        LEFT OUTER JOIN projects ON people.project_id = projects.id
        ORDER BY people.id';

        $result_projects = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result_projects)) {
          print '<tr>'
            . '<td>' . $row['id'] . '</td>'
            . '<td>' . $row['fullname'] .  '</td>'
            . '<td>' .  $row['project_name'] . '</td>'
            . '<td>'
            . '<a href="./assets/edit_people.php?id='  . $row['id'] . '"><button class="btn btn-info me-1 "><i class="bi bi-pen"></i></button></a>'
            . '<a href="?action=delete&id='  . $row['id'] . '"><button class="btn btn-danger  "><i class="bi bi-trash3-fill"></i></button></a>'
            . '</td>'
            . '</tr>';
        }
        ?>
        </form>
  </div>
  </tbody>
  </table>
  <div class=" container  d-flex justify-content-center m-5">
    <div class="card bg-secondary p-2 text-dark bg-opacity-25">
      <div class="card-body ">
        <form class="text-center" method="post">
          <input class="mb-1" type="text" name="firstname" placeholder="Please write  name"></br>
          <input class="mb-3" type="text" name="lastname" placeholder="Please write  last name"></br>
          <p class="text-danger "><?php print $error; ?></p>
          <label for="exampleInputEmail1" class="form-label">Select project:</label>
          <select class=" " style="width:auto;" name="project">
            <?php // allow to select existing projects
            $sql = "SELECT DISTINCT id, project_name FROM Projects";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
              print '<option>' .  $row['id']  . '. ' . $row['project_name'] . '</option>';
            }
            ?>
          </select>
          <div class=" mt-3">
            <button class="btn btn-secondary" type="submit" name="create"><i class="bi bi-box-arrow-in-right me-1"></i>Enter</button>
          </div>
      </div>
    </div>
  </div>
</body>

</html>