<?php
require_once "./Assets/db.php";
require_once "./Assets/create-project.php";

$sql = "SELECT projects.id, project_name FROM projects 
 LEFT JOIN people on project_id = People.project_id
 GROUP BY Project_Name
 ORDER BY projects.id";
$result = mysqli_query($conn, $sql);


?>
<!DOCTYPE html>
<?php require_once "./Assets/include/header.php"; ?>
<title>Projects</title>

</head>

<body>
<?php require_once "./Assets/include/navbar.php"; ?>
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
            <button class="btn btn-secondary"><i class="bi bi-box-arrow-in-right me-1"></i>Enter </button>
          <?php endif ?>
         </div>
    </div>
  </div>
  <?php require_once "./Assets/include/footer.php"; ?>
            
</body>

</html>