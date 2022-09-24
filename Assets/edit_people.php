<?php
session_start();
include "db.php";
$sql = 'SELECT first_name, last_name,  project_id FROM people WHERE id = ' . $_GET['id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$_POST['firstname'] = $row['first_name'];
$_POST['lastname'] = $row['last_name'];
$id = $_GET['id'];
$project_id = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input_name = trim($_POST["first_name"]);
  $input_lastname = trim($_POST["last_name"]);

  if (empty($input_name) or empty($input_lastname)) {
    $error = "Please make sure all fields are filled   correctly!";
  } else {

    $stmt = $conn->prepare('UPDATE people SET first_name = "' . $_POST['first_name'] . '", last_name = "' . $_POST['last_name'] .  '", project_id = "' . $_POST['project_id'] . '" WHERE id = ' . $_GET['id'] . ';');
    $stmt->execute();
    $_SESSION['message'] = "Record has been updated";
    $_SESSION['type'] = "warning";
    $stmt->close();
    unset($_POST['first_name']);
    unset($_POST['last_name']);
    unset($_POST['project_id']);
    header('location:../people.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include "./include/header.php"; ?>
<title>People</title>
</head>
<body>
  <div class=" container ">
    <div class="position-absolute top-50 start-50 translate-middle">
      <div class="card bg-success p-2 text-dark bg-opacity-25">
        <div class="card-body ">
          <form class=" " method="post">
            <input type="hidden" name="id" value="<?php print $id; ?>">
            <input class="mb-3" type="text" name="first_name" placeholder="Please write  name" value="<?php print $row['first_name'] ?>"></br>
            <input class="mb-3" type="text" name="last_name" placeholder="Please write  last name" value="<?php print $row['last_name']; ?>"></br>
            <p class="text-danger "><?php print $error; ?></p>
            <label for="exampleInputEmail1" class="form-label">Select project:</label>
            <select class="form-control text-center   " style="width:auto;" name="project_id">
              <?php
              $sql = "SELECT DISTINCT id, project_name FROM Projects";
              $result = mysqli_query($conn, $sql);
              while ($row = mysqli_fetch_assoc($result)) {
                print '<option value="' . $row['id'] . '">' .  $row['id']  . '. ' . $row['project_name'] . '</option>';
              }
              ?>
            </select>
            <div class="mt-3 text-center">
              <button class="btn btn-secondary" type="submit" name="update"><i class="bi bi-box-arrow-in-right me-1"></i>Enter</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</body>