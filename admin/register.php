<?php
session_start();
require_once "function.php";

function adminCreated()
{
   global $conn;

   if (isset($_POST["regist"])) {
      if (registration($_POST) == 1) {
         echo
            "<script>
            alert('Admin Dibuat');
            document.location.href='login';
         </script>";
      } else {
         echo "<script> alert('Error :  " . mysqli_error($conn) . "');</script>";
      }
   }
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

<body class="register-body">
   <div class="row register-frame">
      <div class="col-md-6">
         <div class="hero">
            <div class="header-title">
               <h1>Admin SiPesan</h1>
               <h5>(Sistem Informasi Surat Pengantar Perusahaan)</h5>
            </div>
         </div>
      </div>

      <div class="col-md-6 d-flex flex-column justify-content-center">
         <div class="form-register-body align-self-center mr-5 mt-2">
            <h3>Register Admin</h3>
            <form class="row g-2" action="" method="post">
               <div class="col-md-12">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Buat Username Admin">
               </div>
               <div class="col-md-12">
                  <label for="pass" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="********">
               </div>
               <div class="col-md-12">
                  <label for="pass2" class="form-label">Konfirmasi Password</label>
                  <input type="password" class="form-control" id="password2" name="password2" placeholder="********">
               </div>
               <div class="col-12">
                  <button type="submit" class="mt-4 form-control btn btn-primary" name="regist">DAFTAR</button>
                  <?php adminCreated(); ?>
               </div>
            </form>
            <div class="col-12">
               <li class="list-group text-center mt-2"><a href="login">LOGIN</a></li>
            </div>
         </div>
      </div>
   </div>

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