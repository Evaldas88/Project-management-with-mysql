<?php
 require_once "./Assets/db.php";


$sql = "SELECT projects.id, project_name,  GROUP_CONCAT(CONCAT_WS(' ', people.first_name, people.last_name) SEPARATOR '; ' ) AS Group_people  FROM projects 
LEFT JOIN people on Projects.id = People.project_id
GROUP BY Project_Name
ORDER BY projects.id";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Projects</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">Project  management</a>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="people.php">People</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="projects.php">Projects</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
        

    <div class="container">
    <table class="table  table-bordered mt-5 text-center">
      <thead>
        <tr>
          <th class=" w-25 table-success">ID</th>
          <th class=" w-25 table-success">Project Name</th>
          <th class=" w-25 table-success">People for project</th>

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
    
</body>
</html>