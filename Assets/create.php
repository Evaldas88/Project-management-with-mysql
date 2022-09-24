<?php

     // update projects logic 
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