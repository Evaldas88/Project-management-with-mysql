<?php
session_start();
include "./Assets/app/db.php";
include "./Assets/app/create-people.php";
include "./Assets/app/delete.php";

$sql = "SELECT  People.id, People.project_id, CONCAT(first_name, ' ', last_name) AS Full_Name FROM People ";
$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include "./Assets/include/header.php"; ?>
<title>People</title>

</head>

<body>
<?php include "./Assets/include/navbar.php";
include "./Assets/app/message.php" ?>

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
            . '<a href="./assets/app/edit_people.php?id='  . $row['id'] . '"><button class="btn btn-info me-1 "><i class="bi bi-pen"></i></button></a>'
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
  <?php include "./Assets/include/footer.php";
  include "./Assets/include/script.php" ?>
</body>

</html>