<?php
include "./Assets/db.php";


$sql = "SELECT projects.id, project_name,  GROUP_CONCAT(CONCAT_WS(' ', people.first_name, people.last_name) SEPARATOR '; ' ) AS Group_people  FROM projects 
LEFT JOIN people on Projects.id = People.project_id
GROUP BY Project_Name
ORDER BY projects.id";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include "./Assets/include/header.php"; ?>
<title>View</title>

</head>

<body>
  <?php include "./Assets/include/navbar.php"; ?>
 
  <div class="container pt-1">
    <table class="table  table-bordered mt-5 text-center">
      <thead>
        <tr class="bg-dark  p-2 text-white bg-opacity-75">
          <th class=" w-25">ID</th>
          <th class=" w-25 ">Project Name</th>
          <th class=" w-25 ">People for project</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            print '<tr>'
              . '<td>' . $row['id'] . '</td>'
              . '<td>' . $row['project_name'] . '</td>'
              . '<td>' . $row['Group_people'] . '</td>'
              . '</tr>';
          }
        }
        ?>
      </tbody>
    </table>
    <?php include "./Assets/include/footer.php"; ?>

</body>

</html>