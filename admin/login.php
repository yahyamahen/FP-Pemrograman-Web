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
      $_SESSION['username'] = $row['username'];
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
      echo var_dump($row);
      if (password_verify($password, $row["PASSWORD"])) {
         // set session
         $_SESSION['admin'] = true;
         $_SESSION['username'] = $row['username'];

         if (isset($_POST['remember'])) {
            setcookie('id', $row['id']);
            setcookie('key', hash('sha256', $row['username']));
         }
         header("Location: home");
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

<body class="login-body">
   <div class="row login-frame">
      <div class="col-md-5 d-flex flex-column justify-content-center">
         <div class="header-title mb-4 ml-4 align-self-center">
            <h1>Admin SiPesan</h1>
            <h5>(Sistem Informasi Surat Pengantar Perusahaan)</h5>
         </div>
         <div class="form-login-body align-self-center">
            <h3>Masuk</h3>
            <form action="" method="POST" class="row g-1" id="form-login">
               <div class="form-group col-md-12">
                  <label for="username">Username</label>
                  <input class="form-control" type="text" id="username" name="username" placeholder="Username Admin">
               </div>

               <div class="form-group col-md-12">
                  <label for="pass">Password</label>
                  <input class="form-control" type="password" id="password" name="password" placeholder="*********">
               </div>

               <div class="col-12">
                  <div class="form-check text-center">
                     <input class="form-check-input" type="checkbox" id="remember" name="remember">
                     <label class="form-check-label" for="remember"> Remember Me</label>
                  </div>
               </div>

               <div class=" form-group col-md-12 mt-2">
                  <button type="submit" name="login" id="login" class="form-control btn btn-primary"> MASUK </button>
               </div>
               <?php if (isset($error)) : ?>
                  <div class="form-group col-md-12">
                     <p class="text-center" style="color: red; font-style: italic;">Username / password salah</p>
                  </div>
               <?php endif; ?>
            </form>
            <div class="text-center mb-2 col-md-12"><a href="register">Register Akun</a></div>
            <!-- <div class="text-center col-md-12">Lupa Password? <a href="#">Hubungi Admin</a></div> -->
         </div>
      </div>

      <div class="col-md-7">
         <div class="hero">
            <!-- <img src="../images/admin_bg.jpg" alt="bg"> -->
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