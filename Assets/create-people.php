<?php 

     // create people logic 
     $error = "";
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
       $input_name = trim($_POST["firstname"]);
       $input_lastname = trim($_POST["lastname"]);
       $project = trim($_POST['create']);
       if (empty($input_name) or empty($input_lastname)) {
         $error = "Please make sure all fields are filled   correctly!";
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