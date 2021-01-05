<?php
session_start();
require "function.php";

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
   $id = $_COOKIE['id'];
   $key = $_COOKIE['key'];

   $query = "SELECT username FROM user WHERE id = '$id';";
   $result = mysqli_query($conn, $query);
   $row = mysqli_fetch_assoc($result);

   if ($key === hash('sha256', $row['username'])) {
      $_SESSION['admin'] = true;
      $_SESSION['user'] = $row['username'];
   }
}


if (isset($_POST["login"])) {

   $username = $_POST["username"];
   $password = $_POST["password"];

   $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username';");

   // cek username
   if (mysqli_num_rows($result) === 1) {
      //cek password
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row["password"])) {
         // set session
         $_SESSION['admin'] = true;
         $_SESSION['user'] = $row['username'];

         if (isset($_POST['remember'])) {
            setcookie('id', $row['id']);
            setcookie('key', hash('sha256', $row['username']));
         }
         header("Location: surat.php");
         exit;
      }
   }
   $error = true;
}

?>

<!doctype html>
<html lang="en">

<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="../css/bootstrap/bootstrap.css">
   <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">

   <title>SiPesan (Admin)</title>
</head>

<body>

   <script src="../js/js/jquery-3.5.1.js"></script>
   <script src="../js/js/jquery-3.5.1.min.js"></script>
   <script src="../js/js/bootstrap.js"></script>
   <script src="../js/js/bootstrap.min.js"></script>
   <!-- <script src="../js/js/bootstrap.bundle.js"></script> -->
   <!-- <script src="../js/js/bootstrap.bundle.min.js"></script> -->
   <script src="../js/js/font-awesome.min.js"></script>
   <script src="js/script.js"></script>

</body>

</html>